<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertisement_Model extends Base_Model
{

	/**
     * @var string		model table name
     */
	protected $_table = 'advertisement';

	/**
	 * The primary key, by default set to
	 * `id`, for use in some functions.
	 *
	 * @var string
	 */
	protected $primary_key = 'strategy_id';

	protected $strategy_type = 'advertisement';


	/**
	 * Constructor
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function get($strategy_id = NULL)
	{
		
		if (!isset($strategy_id))
			return FALSE;

		// verify access to this record
		$data['strategy']['id'] = $strategy_id;
		if ($this->authorize_action($data))
		{
			return parent::get($strategy_id);
		}

		return FALSE;
	}


	public function get_plan_usage_info($data = NULL)
	{
		// in case $strategy is an array payload
		if (is_array($data) && isset($data['strategy']['id']))
			$strategy_id = $data['strategy']['id'];

		// otherwise it's just an int parameter
		if (is_numeric($data))
			$strategy_id = $data;

		if (!isset($strategy_id))
			return FALSE;

		// verify access to this record
		$payload['strategy']['id'] = $strategy_id;
		if (!$this->authorize_action($payload))
		{
			return FALSE;
		}

		$ret = array();

		$this->db->select('exposure_count, expiration_date, bank, plan_id');
		$this->db->from('strategy');
		$this->db->where('id', $strategy_id);
		$strategy = $this->db->get()->row_array();

		$ret['strategy'] = (array) $strategy;

		if (isset($ret['strategy']['plan_id']))
		{
			$this->db->select('*');
			$this->db->from('plan');
			$this->db->where('id', $ret['strategy']['plan_id']);
			$plan = $this->db->get()->row_array();

			$ret['plan'] = (array) $plan;
		}

		if (!$ret)
			return FALSE;

		return $ret;
	}


	public function advertisement_load_blocks($strategy_id, $view)
	{
		$this->load->model('strategy/strategy_model');

		$blocks = $this->strategy_model->get_blocks($strategy_id, $view);
		return $blocks;
	}


	public function advertisement_load($strategy_id)
	{
		$options['strategy_type'] = $this->strategy_type;

		$this->load->model('strategy/strategy_model');
		$strategy = $this->strategy_model->get($strategy_id, $options);
		if (!$strategy)
			return FALSE;

		// get plan info
		if (isset($strategy->plan_id) && !empty($strategy->plan_id))
		{
			$this->load->model('plan/plan_model');
			$plan = $this->plan_model->get($strategy->plan_id);
		}

		$advertisement = $this->get($strategy_id);

		// get strategy blocks
		$advertisement_blocks = $this->advertisement_load_blocks($strategy_id, 'advertisement');
		
		$data['strategy'] = (array) $strategy;
		$data['advertisement'] = (array) $advertisement;
		$data['advertisement_blocks'] = (array) $advertisement_blocks;
		$data['plan'] = (array) $plan;
		return $data;
	}


	public function register_advertisement(&$data)
	{
		if (!$data || !isset($data['strategy']) || !isset($data['plan']))
			return FALSE;

		$this->load->model('strategy/strategy_model');

		// start transaction
		$this->db->trans_start();

		$result = $this->strategy_model->register_strategy($data);
		if ($result === FALSE) {
			$this->db->trans_complete();
			return FALSE;
		}

		$data['advertisement']['strategy_id'] = $result['strategy_id'];
		$ret = $this->save_advertisement($data, TRUE);

		// end transaction
		$this->db->trans_complete();

		if ($ret === FALSE)
			return FALSE;

		return $result;
	}


	/**
	 * Save an advertisement
	 * 
	 * @param array $data array elements: name, strategy_id
	 * @return mixed $ret boolean false on errors, and array elements: strategy_id
	 */
	public function save_advertisement($data, $new = FALSE)
	{
		$strategy_id = FALSE;

		if (isset($data['strategy']))
		{
			//forward to strategy_model to save it
			// @TODO this doesn't work well with register_strategy() in strategy_model which already
			// takes care of registering the strategy

			// $this->load->model('strategy/strategy_model');
			// $strategy_id = $this->strategy_model->save_strategy($data);
		}

	    if (!isset($data['advertisement']))
	    	return $strategy_id;
	        
	    $advertisement = $data['advertisement'];
	    
	    // if id was received then we update the record, otherwise we insert a new one 
	    if (isset($advertisement['strategy_id']) && $new === FALSE)
	    {
	        // confirm user access to this record
            $ret = $this->authorize_action($data);
            if (!$ret)
            	return FALSE;
	        
	        $strategy_id = $advertisement['strategy_id'];
	        
	        // updates the strategy blocks in mongo
	        $this->load->model('strategy/strategy_model');
	        $blocks['blocks'] = $data['advertisement_blocks'];
			$ret = $this->strategy_model->save_blocks($advertisement['strategy_id'], 'advertisement', $blocks);

	        if (isset($advertisement['redirect_url']))
	            $record['redirect_url'] = $advertisement['redirect_url'];
	            
	        if (isset($advertisement['text']))
	            $record['text'] = $advertisement['text'];
	            
	        // no records to update? ok, quit
	        if (!isset($record))
	        	return TRUE;
	        
	        $ret = $this->update($strategy_id, $record);
	        if (!$ret)
	        {
	            log_message('debug', ' - Advertisement => Save => error updating record');
	            return FALSE;
	        }

	    }
	    else if (isset($advertisement['strategy_id']) && $new === TRUE)
	    {
			// create the record
    	    $strategy_id = $this->insert(
    	        array(
    	        	'strategy_id' => $advertisement['strategy_id'],
    	        	//'exposure_count' => isset($advertisement['exposure_count']) ? $advertisement['exposure_count'] : '0',
    	            'redirect_url' => isset($advertisement['redirect_url']) ? $advertisement['redirect_url'] : NULL,
    	            'text' => isset($advertisement['text']) ? $advertisement['text'] : NULL,
    	        )
    	    ); 

			if ($strategy_id !== FALSE)
    	    	$strategy_id = TRUE;
	    }
	    
	    if (!$strategy_id)
	        return FALSE;
	        
	    log_message('debug', ' + Advertisement => Save => saved record');
	    
	    return array(
	    	'strategy_id' => $strategy_id,
	    );

	}


	public function authorize_action(&$data)
	{
	    $bool = parent::authorize_action($data);
	    $bool = $bool && $this->auth_strategy($data);
	    
	    return $bool;
	}


	public function auth_strategy(&$data)
	{
	    /*
         * SQL Example:
         * 
			SELECT  `ad`.`strategy_id` 
			FROM (`advertisement` AS ad)
			JOIN  `strategy` AS strategy ON  `strategy`.`id` =  `ad`.`strategy_id` 
			JOIN  `campaign_strategies` AS cs ON  `cs`.`strategy_id` =  `strategy`.`id` 
			JOIN  `code` AS code ON  `code`.`campaign_id` =  `cs`.`campaign_id` 
			JOIN  `brand` AS  `b` ON  `b`.`id` =  `code`.`brand_id` 
			JOIN  `operator` AS  `op` ON  `op`.`brand_id` =  `b`.`id` 
			WHERE  `ad`.`strategy_id` =  '18'
			AND  `op`.`id` =  '1'
     	 *
     	 *
         */

        $this->db->select('ad.strategy_id');
		$this->db->from('advertisement AS ad');
		$this->db->join('strategy AS strategy', 'strategy.id = ad.strategy_id');
		$this->db->join('campaign_strategies AS cs', 'cs.strategy_id = strategy.id');
		$this->db->join('code AS code', 'code.campaign_id = cs.campaign_id');
        $this->db->join('brand AS b', 'b.id = code.brand_id');
        $this->db->join('operator AS op', 'op.brand_id = b.id');
        
        if (isset($data['strategy']['id']))
        {
            $this->db->where('ad.strategy_id', $data['strategy']['id']);
        }
        else
        {
            return FALSE;
        }
        
        if (!isset($data['operator_id']))
        {
            $operator_id = $this->get_operator_id();
        }
        else
        {
            $operator_id = $data['operator_id'];
        }
        
        if (!$operator_id)
            return FALSE;
            
        $this->db->where('op.id', $operator_id);
        
        
        $ret = $this->db->get()->row_array();
        
        if (!$ret)
            return FALSE;
        
        return $ret;
	}

}