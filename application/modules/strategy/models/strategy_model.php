<?php
class Strategy_Model extends Base_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'strategy';
	
	
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


	public function promotion_validate($data)
	{
		// it's not even set, nothing to validate here
		if (!isset($data['order']['promotion_id']))
			return TRUE;

		$promotion_id = $data['order']['promotion_id'];
        
        //if (isset($order['promotion_id']) && $order['promotion_id'])
        if (isset($promotion_id) && $promotion_id)
        {
			if (!is_numeric($promotion_id) && $promotion_id > 0)
				return FALSE;

        	$this->load->model('promotion/promotion_model');
            $ret = $this->promotion_model->validate($promotion_id);
            return $ret;
        }

        // promotion_id was not set, let's get out cleanly here
        return TRUE;
	}


	/**
	 * Register a new strategy
	 * 
	 * Initializes a new strategy by creating the entire workflow - campaign, code, strategy and order
	 * 
	 * @param array $data strategy information
	 * @return mixed $records returns the created strategy information as an array or false if anything went wrong
	 */
	public function register_strategy($data)
	{
		if (!isset($data['strategy']) || !isset($data['plan']['id']))
	        return FALSE;

	    // does the promotion validate?
	    if (!$this->promotion_validate($data)) {
	    	//$this->session->set_flashdata('error', 'promotion id is not correct');
	    	return FALSE;
	    }

	    // creates the campaign name if wasn't provided - which is a derived copy of the strategy name
	    if (!isset($data['campaign']['name']) && isset($data['strategy']['name']))
	    {
	    	$data['campaign']['name'] = mb_substr($data['strategy']['name'], 0, 44);
	    }

	    // @TODO check that user is allowed to create another strategy

	    // get operator session
	    $operator = $this->get_operator();
	    if (!$operator)
	    	return FALSE;

	    // load necessary models for creation of a new strategy
		$this->load->model('campaign/campaign_strategies_model');
	    $this->load->model('campaign/campaign_model');
	    $this->load->model('code/code_model');
	    $this->load->model('order/order_model');
	    $this->load->model('operator/operator_model');

	    // set brand information
	    $data['brand']['id'] = $operator['brand_id'];


	    $result = array();

		// create the strategy
		$ret = $this->save_strategy($data, TRUE);
		if ($ret === FALSE)
			return FALSE;
		
		$result += $ret;

	    // create campaign and it's code
		$ret = $this->campaign_model->create_campaign($data, TRUE);
		if ($ret === FALSE)
			return FALSE;
		
		$result += $ret;

		// create campaign strategies mapping and activate
		$ret = $this->campaign_strategies_model->create_campaign_strategy(
			array(
				'campaign_id' => $result['campaign_id'],
				'strategy_id' => $result['strategy_id'],
				'active' => TRUE
			)
		);

		if ($ret === FALSE)
			return FALSE;

		// create the order information
		// first set order settings
		$data['order']['operator_id'] = $operator['id'];
		$data['order']['strategy_id'] = $result['strategy_id'];
		$ret = $this->order_model->save_order($data, TRUE);
		if ($ret === FALSE)
			return FALSE;
		
		$result += $ret;

		return $result;
	}


	
	/**
	 * Save a Strategy
	 * 
	 * @param array $data array elements: name, contact_id
	 * @return mixed $ret boolean false on errors, and array elements: strategy_id
	 */
	public function save_strategy($data, $new = FALSE)
	{
	    if (!isset($data['strategy']))
	        return FALSE;
	        
	    $strategy = $data['strategy'];
	    
	    // if id was received then we update the record, otherwise we insert a new one
	    if (isset($strategy['id']) && $new === FALSE)
	    {
	        // confirm user access to this record
            $ret = $this->authorize_action($data);
            if (!$ret)
                return FALSE;
	        
	        $strategy_id = $strategy['id'];
	        
	        if (isset($strategy['name']))
	            $record['name'] = $strategy['name'];
	            
	        if (isset($strategy['description']))
	            $record['description'] = $strategy['description'];
	            
	        if (isset($strategy['picture']))
	            $record['picture'] = $strategy['picture'];
	        
	        if (isset($strategy['website']))
	            $record['website'] = $strategy['website'];
	        
	        if (isset($strategy['plan_id']))
	            $record['plan_id'] = $strategy['plan_id'];

	        if (isset($strategy['exposure_count']))
	            $record['exposure_count'] = $strategy['exposure_count'];
	         
	        if (isset($strategy['expiration_date']))
	            $record['expiration_date'] = $strategy['expiration_date'];

	        if (isset($strategy['language']))
	            $record['language'] = $strategy['language'];

	        $ret = $this->update($strategy_id, $record);
	        if (!$ret)
	        {
	            log_message('debug', ' - Strategy => Save => error updating record');
	            return FALSE;
	        }

	    }
	    else
	    {
	         // create the record
	         
	         // @TODO
	         // do we always allow users to create strategies? maybe we need to check for something first?

	         // if no associated record ids provided then we quit
	         if (!isset($strategy['plan_id']))
	         {
	             log_message('error', ' - Strategy => Save => Insert => missing plan_id');
	             return FALSE;
	         }   
	        
    	    $strategy_id = $this->insert(
    	        array(
    	            'name' => isset($strategy['name']) ? $strategy['name'] : '',
    	            'description' => isset($strategy['description']) ? $strategy['description'] : '',
    	            'picture' => isset($strategy['picture']) ? $strategy['picture'] : '',
    	            'website' => isset($strategy['website']) ? $strategy['website'] : '',
    	            'plan_id' => $strategy['plan_id'],
    	            'expiration_date' => isset($strategy['expiration_date']) ? $strategy['expiration_date'] : '0000-00-00 00:00:00',
    	            'language' => isset($strategy['language']) ? $strategy['language'] : 'en-us',
    	        )
    	    ); 
	    }
	    
	    if (!$strategy_id)
	        return FALSE;
	        
	    log_message('debug', ' + Strategy => Save => saved record');
	    
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
			SELECT `strategy`.`id`
			FROM (`strategy`)
			JOIN `campaign_strategies` AS cs ON `cs`.`strategy_id` = `strategy`.`id`
			JOIN `code` AS code ON `code`.`campaign_id` = `cs`.`campaign_id`
			JOIN `brand` AS `b` ON `b`.`id` = `code`.`brand_id`
			JOIN `operator` AS `op` ON `op`.`brand_id` = `b`.`id`
			WHERE
			 `strategy`.`id` =  '18'
			AND `op`.`id` =  '1'
     	 *
     	 *
         */

		$this->db->select('strategy.id');
		$this->db->from('strategy');
		$this->db->join('campaign_strategies AS cs', 'cs.strategy_id = strategy.id');
		$this->db->join('code AS code', 'code.campaign_id = cs.campaign_id');
        $this->db->join('brand AS b', 'b.id = code.brand_id');
        $this->db->join('operator AS op', 'op.brand_id = b.id');

        if (isset($data['strategy']['id']))
        {
            $this->db->where('strategy.id', $data['strategy']['id']);
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