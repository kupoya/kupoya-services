<?php
class Plan_Model extends Base_Model {
	
    /**
     * @var string
     * 	model table name
     */
	protected $_table = 'plan';
	

	/**
	 * @var integer
	 * 	specify how many free plans are allowed for each operator
	 */
	protected $_plans_free_allow = 3;


	/**
	 * @var string
	 * 	specify the SQL LIKE clause value for finding free plans
	 */
	protected $_plans_free_name = 'FREE_%';

	
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
	 * Get plan information
	 * 
	 * @param mixed $strategy_type provide an integer or name of the stratey_type
	 * @return array $records all plans information
	 */
	public function get_dropdown($strategy_type = NULL, $only_free = FALSE)
	{
		$this->db->select('plan.*');
		$this->db->select('st.id as strategy_type_id');
        $this->db->select('st.name as strategy_type_name');
        $this->db->from('plan AS plan');
        $this->db->join('strategy_type AS st', 'plan.strategy_type = st.id');
        
        // if requested to return a specific strategy_type plan information
        if (isset($strategy_type))
        {
        	if (is_numeric($strategy_type))
        	{
            	$this->db->where('st.id', $strategy_type);
            }
            else
            {
            	$this->db->where('st.name', $strategy_type);
            }
        }

        // further limit result for only free plans?
        if ($only_free)
        {
        	// gives me: LIKE free%
        	$this->db->like('plan.name', 'FREE_', 'after');
        }
        
        // only return plans which are set valid
        $this->db->where('plan.valid', '1');
        
        //return $this->db->get()->result_array();
        $ret = $this->db->get()->result_array();

        $options = array();
        foreach ($ret as $plan => $plan_info)
        {
        	//$options[$plan_info['id']] = $plan_info['description'];
        	$options[$plan_info['id']] = $plan_info;
        }

        return $options;

	}



	/**
	 * Upgrade a Plan
	 * 
	 * 
	 */
	public function upgrade($data)
	{
		/**
		 * - 
		 * - make sure user has access to this strategy
		 * - make sure strategy type matches the plan type requested
		 * - make sure plan is valid: valid=1
		 * - create an order record
		 * - if plan_type = bank -> upgrade strategy bank counter and sets expiration time to current day
		 * - if plan_type = expiration -> set expiration time to required time and set strategy bank counter to 0
		 */
		
		if (!isset($data['plan']['id']) || !isset($data['strategy']['id']))
	        return FALSE;

	    if (!$data['plan']['id'] || !$data['strategy']['id'])
	        return FALSE;

	    
	    // validate plan is ok for using it
	    if (!$this->authorize_action($data))
	    	return FALSE;
	    

	    $upgrade_plan = (array) $this->get($data['plan']['id']);
	    if (!$upgrade_plan || !isset($upgrade_plan['id']))
	    	return FALSE;

	   	// we need some models loaded
	    $this->load->model('strategy/strategy_model');
	    $this->load->model('order/order_model');

	    $strategy = $this->strategy_model->get($data['strategy']['id']);

	    $ret = TRUE;

	    if (isset($upgrade_plan['plan_type']) && $upgrade_plan['plan_type'] == 'bank')
	    {
	    	// get plan bank amount for bank type plans and update strategy with bank amount	
	    	$bank_amount = $upgrade_plan['bank'];

			// prepare payload for strategy save 
	    	$payload['strategy']['id'] = $data['strategy']['id'];
	    	
	    	// add the bank amount to the current payload
	    	$ret = $this->strategy_model->upgrade_bank($payload, $bank_amount);

	    	// set expiration_date to current day, we're now on bank plan type, not expiration
	    	$payload['strategy']['expiration_date'] = date('Y-m-d H:i:s', time());
	    	$payload['strategy']['plan_id'] = $upgrade_plan['id'];
	    	$ret = $this->strategy_model->save_strategy($payload);

	    }
	    elseif (isset($upgrade_plan['plan_type']) && $upgrade_plan['plan_type'] == 'expiration')
	    {
			// get plan expiration date for expiration type plans
	    	$expiration_date = $data['plan']['expiration_date'];
	    	
	    	// prepare payload for strategy save 
	    	$payload['strategy']['id'] = $data['strategy']['id'];
	    	$payload['strategy']['expiration_date'] = $expiration_date;
	    	// set bank to 0, we're now on expiration_date plan type, not banks
	    	$payload['strategy']['bank'] = '0';
	    	$payload['strategy']['plan_id'] = $upgrade_plan['id'];

	    	$ret = $this->strategy_model->save_strategy($payload);

	    }
	    else
	    {
	    	// unknown plan_type can't be handled
	    	return FALSE;
	    }

    	// if all went well, we'll add an order record for this action
    	if ($ret)
    	{
	    	// create a new order record
	    	$payload['order']['operator_id'] = $this->get_operator_id();
	    	$payload['order']['strategy_id'] = $data['strategy']['id'];
	    	$payload['order']['plan_id'] = $upgrade_plan['id'];

	    	$ret = $ret && $this->order_model->save_order($payload);
	    }
	    
	    return $ret;


	}

	
	/**
	 * Save a Strategy
	 * 
	 * @TODO needs to be written obviously
	 * 
	 * @param array $data array elements: name, contact_id
	 * @return mixed $ret boolean false on errors, and array elements: strategy_id
	 */
	public function save_plan($data)
	{
	    if (!isset($data['strategy']))
	        return FALSE;
	        
	    $strategy = $data['strategy'];
	    
	    // if id was received then we update the record, otherwise we insert a new one 
	    if (isset($strategy['id']))
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
    	            'expiration_date' => isset($strategy['expiration_date']) ? $strategy['expiration_date'] : '0',
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
	
	

	public function check_free_plans(&$data = NULL)
	{
		/*
		 *
			SELECT  `strategy`.`name` , p . cost
			FROM (
			`strategy`
			)
			JOIN  `plan` AS p ON  `p`.`id` =  `strategy`.`plan_id` 
			JOIN  `campaign_strategies` AS cs ON  `cs`.`strategy_id` =  `strategy`.`id` 
			JOIN  `code` AS code ON  `code`.`campaign_id` =  `cs`.`campaign_id` 
			JOIN  `brand` AS  `b` ON  `b`.`id` =  `code`.`brand_id` 
			JOIN  `operator` AS  `op` ON  `op`.`brand_id` =  `b`.`id` 
			WHERE 
			 `op`.`id` =  '1'
			AND
			 p.cost = 0
		 *
		 *

		$this->db->select('strategy.id');
		$this->db->distinct(); // @TODO needs to fix cause this doesnt work
		$this->db->select('p.cost');
        $this->db->from('strategy');
        $this->db->join('plan AS p', 'p.id = strategy.plan_id');
		$this->db->join('campaign_strategies AS cs', 'cs.strategy_id = strategy.id');
		$this->db->join('code AS code', 'code.campaign_id = cs.campaign_id');
        $this->db->join('brand AS b', 'b.id = code.brand_id');
        $this->db->join('operator AS op', 'op.brand_id = b.id');

        // search for all plans that start with FREE_ - these are our free plans
        $this->db->like('p.name', 'FREE_');

        // operator stuff...

        $this->db->where('op.id', $operator_id);

        //$ret = $this->db->get()->row_array();
        $ret = $this->db->count_all_results();
        */

        $query = "
        SELECT  COUNT(DISTINCT(strategy.id)) AS count
			FROM (`strategy`)
			JOIN  `plan` AS p ON  `p`.`id` =  `strategy`.`plan_id` 
			JOIN  `campaign_strategies` AS cs ON  `cs`.`strategy_id` =  `strategy`.`id` 
			JOIN  `code` AS code ON  `code`.`campaign_id` =  `cs`.`campaign_id` 
			JOIN  `brand` AS  `b` ON  `b`.`id` =  `code`.`brand_id` 
			JOIN  `operator` AS  `op` ON  `op`.`brand_id` =  `b`.`id` 
			WHERE 
			 `op`.`id` =  ?
			AND
			 `p`.`name` LIKE ?
        ";

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
            
        $res = $this->db->query($query, array($operator_id, $this->_plans_free_name));
        
        if (!$res)
            return FALSE;

        // get result row from query
        $row = $res->row_array();
        
        // free query result
        $res->free_result();

		// check amount of currently used free plans against 
        if ($row['count'] >= $this->_plans_free_allow)
        	return FALSE;
        
        return (int) $row['count'];
	}


	
	public function authorize_action(&$data)
	{
	    $bool = parent::authorize_action($data);
	    $bool = $bool && $this->auth_plan($data);
	    
	    return $bool;
	}
	


	public function check_plan_is_free($plan_id)
	{	
		if (!isset($plan_id))
			return FALSE;

		/*
		Sadly not fun to use AR cause it attempts to escape the $this->_plans_free_name string

		$this->db->select('p.id');
		$this->db->from('plan AS p');
		$this->db->where('p.id', $plan_id);
		$this->db->like('p.name', $this->_plans_free_name);
		$ret = $this->db->get()->row_array();
		*/

		$query = '
		SELECT p.id
		FROM plan as p
		WHERE
			p.id = ?
		AND
			p.name LIKE ?
		';

		$res = $this->db->query($query, array($plan_id, $this->_plans_free_name));
		if (!$res)
			return FALSE;

		return (bool) $res->num_rows();
	}


	/**
	 * @TODO needs to be written ofcourse
	 */	
	public function auth_plan(&$data)
	{

		/*
         * SQL Example:
         * 
		SELECT 
		    `strategy`.`id`
		FROM
		    (`strategy`)
		JOIN `plan` AS p ON p.strategy_type = strategy.type
		JOIN `campaign_strategies` AS cs ON `cs`.`strategy_id` = `strategy`.`id`
		JOIN `code` AS code ON `code`.`campaign_id` = `cs`.`campaign_id`
		JOIN `brand` AS `b` ON `b`.`id` = `code`.`brand_id`
		JOIN `operator` AS `op` ON `op`.`brand_id` = `b`.`id`
		WHERE
		    `strategy`.`id` =  '2'
		AND
		    p.id = 27
		AND
		    p.valid = 1
		AND
		    `op`.`id` =  '1'
     	 *
     	 *
         */

		$this->db->select('strategy.id');
		$this->db->from('strategy');
		$this->db->join('plan AS p', 'p.strategy_type = strategy.type');
		$this->db->join('campaign_strategies AS cs', 'cs.strategy_id = strategy.id');
		$this->db->join('code AS code', 'code.campaign_id = cs.campaign_id');
        $this->db->join('brand AS b', 'b.id = code.brand_id');
        $this->db->join('operator AS op', 'op.brand_id = b.id');

        if (isset($data['plan']['id']))
        {
        	$this->db->where('p.id', $data['plan']['id']);
        }
        else
        {
        	return FALSE;
        }
        	
        // make sure plan is valid for usage
        $this->db->where('p.valid', '1');

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


		/* OLD:

	    
         * SQL Example:
         * 
			SELECT op.id, op.brand_id
     		FROM operator op
     		JOIN brand b ON op.brand_id = b.id
     		JOIN code code ON code.brand_id = code.id
     		JOIN campaign_strategies cs ON cs.campaign_id = code.campaign_id
     		WHERE
     			op.id = 1
     		##AND
     		##	cs.campaign_id = 1
     		AND
     			cs.strategy_id = 2
     	 *
     	 *
         
        $this->db->select('op.id');
        $this->db->select('op.brand_id');
        $this->db->from('operator AS op');
        $this->db->join('brand AS b', 'op.brand_id = b.id');
        $this->db->join('code AS code', 'code.brand_id = code.id');
        $this->db->join('campaign_strategies AS cs', 'cs.campaign_id = code.campaign_id');
        
        if (isset($data['strategy']['id']))
        {
            $this->db->where('cs.strategy_id', $data['strategy']['id']);
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

        */
	}
	
	
}