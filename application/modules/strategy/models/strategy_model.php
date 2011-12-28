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



	/**
	 * Get all strategies with extended information for a specific brand id
	 * 
	 * @param array $data
	 * 	$data['brand']['id'] = the brand id
	 * 
	 * @return array $results mysql result array 
	 */
	public function get_strategies(&$data)
	{
		if (!isset($data['brand']['id']) || empty($data['brand']['id']) || !is_numeric($data['brand']['id']))
			return FALSE;

		$brand_id = $data['brand']['id'];

		/*
		SELECT
			code.id, code.brand_id, cs.campaign_id, s.id as strategy_id, s.name as strategy_name, st.name as strategy_type, p.bank as bank_size, p.plan_type as plan_type 
		FROM code
		JOIN campaign_strategies cs ON cs.campaign_id = code.campaign_id
		JOIN strategy s ON s.id = cs.strategy_id
		JOIN plan p ON p.id = s.plan_id
		JOIN strategy_type st ON st.id = p.strategy_type
		WHERE
			code.brand_id = 1
		AND
			cs.active = 1
		*/

		// confirm user access to this record
		$this->load->model('brand/brand_model');
	    $ret = $this->brand_model->authorize_action($data);
	    if (!$ret)
	        return FALSE;

		$this->db->select('code.id, code.brand_id, cs.campaign_id, s.id as strategy_id, s.name as strategy_name, st.name as strategy_type, p.bank as bank_size, p.plan_type as plan_type');
		$this->db->from('code');

		$this->db->join('campaign_strategies AS cs', 'campaign_id = code.campaign_id');
		$this->db->join('strategy AS s', 's.id = cs.strategy_id');
		$this->db->join('plan AS p', 'p.id = s.plan_id');
		$this->db->join('strategy_type AS st', 'st.id = p.strategy_type');

		$this->db->where('code.brand_id', $brand_id);
		$this->db->where('cs.active', '1');

		// we don't really need anymore than 1 row returned and actually that would be a bug if that's the case
		//$this->db->limit(1);

		return $this->db->get()->result_array();
		// $row = $this->db->get()->row_array();
		// $result['brand']['id'] = $row['brand_id'];
		// $result['code']['id'] = $row['id'];

		return $result;

	}

	/**
	 * Get the brand the code information associated with a specific campaign/strategy mapping
	 * 
	 * @param array $info
	 * 	elements: $info['strategy']['id'] and $info['campaign']['id']
	 * @param bool $load
	 * 	@TODO if $load is set to TRUE it will return the result by loading the code and brand info
	 * 
	 * @return array $ret
	 * elements: $ret['code']['id'] and $ret['brand']['id']
	 */
	public function get_parents($info, $load = FALSE)
	{
		if (!isset($info['strategy']['id']) || !isset($info['campaign']['id']))
			return FALSE;
		/*
		SELECT code.brand_id
		FROM strategy AS s
		JOIN campaign_strategies AS cs ON cs.strategy_id = s.id
		JOIN code AS code ON code.campaign_id = cs.campaign_id
		WHERE 
		s.id = 2
		AND
		cs.campaign_id = 1
		*/

		// confirm user access to this record
	    $ret = $this->authorize_action($info);
	    if (!$ret)
	        return FALSE;

		$this->db->select('code.id, code.brand_id');
		$this->db->from('strategy AS s');
		$this->db->join('campaign_strategies AS cs', 'cs.strategy_id = s.id');
		$this->db->join('code AS code', 'code.campaign_id = cs.campaign_id');
		$this->db->where('s.id', $info['strategy']['id']);
		$this->db->where('cs.campaign_id', $info['campaign']['id']);

		// we don't really need anymore than 1 row returned and actually that would be a bug if that's the case
		$this->db->limit(1);

		$row = $this->db->get()->row_array();
		$result['brand']['id'] = $row['brand_id'];
		$result['code']['id'] = $row['id'];

		return $result;

	}
	


	public function get_blocks($strategy_id = NULL, $view = 'login')
	{
		if (!isset($strategy_id))
			return FALSE;

		$this->load->library('mongo_db');

		$where['strategy_id'] = (int) $strategy_id;
		
		if ($view != NULL)
			$where['view'] = $view;
		
		$blocks = $this->mongo_db->get_where('strategy_template', $where);

		if (isset($blocks[0]['blocks']))
			return $blocks[0]['blocks'];
		
		return FALSE;
	}


	public function save_blocks($strategy_id = NULL, $view, $data)
	{
		if (!isset($strategy_id) || !isset($view) || !isset($data))
			return FALSE;

		$this->load->library('mongo_db');

		// set where criteria
		$this->mongo_db->where('strategy_id', (int) $strategy_id);
		$this->mongo_db->where('view', $view);

		// set the fields to update
		$this->mongo_db->set($data);

		$ret = $this->mongo_db->update('strategy_template');

		return $ret;
	}



	/**
	 * Validate the strategy being loaded is of a specific type
	 * 
	 * @param integer $strategy_id
	 * 	the strategy_id to load
	 * @param mixed $type
	 * 	the strategy type in either numeric/integer (the id row in the db) or the string as the name of it
	 */
	public function validate_strategy_type($strategy_id, $type = '')
	{
		/*
		SELECT s.id, st.id, st.name
		FROM strategy AS s
		JOIN plan AS p ON p.id = s.plan_id
		JOIN strategy_type AS st ON st.id = p.strategy_type
		WHERE s.id =2
		AND st.name =  'advertisement'
		*/

		if (!$type || !$strategy_id)
			return FALSE;

		$this->db->select('s.id');
		$this->db->from('strategy AS s');
		$this->db->join('plan AS p', 'p.id = s.plan_id');
		$this->db->join('strategy_type AS st', 'st.id = p.strategy_type');
		$this->db->where('s.id', $strategy_id);

		if (is_numeric($type))
			$this->db->where('st.id', $type);
		else
			$this->db->where('st.name', $type);

		// we don't really need anymore than 1 row returned and actually that would be a bug if that's the case
		$this->db->limit(1);

		return $this->db->get()->row_array();
	}


	public function get($strategy_id = NULL, $options)
	{
		
		if (!isset($strategy_id))
			return FALSE;

		// verify the strategy type
		// make sure the strategy_id that we're going to load matches the strategy type
		// that we are actually loading...
		$ret = $this->validate_strategy_type($strategy_id, $options['strategy_type']);
		if (!$ret)
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

	    // validate plans order
	    //$data['plan']['id']


		// creates the campaign name if wasn't provided - which is a derived copy of the strategy name
	    if (!isset($data['campaign']['name']) && isset($data['strategy']['name']))
	    {
	    	$data['campaign']['name'] = mb_substr($data['strategy']['name'], 0, 44);
	    }  

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

	        if (!isset($record))
	        	return FALSE;

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
	         // like to limit them to X strategies per campaign or something?

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