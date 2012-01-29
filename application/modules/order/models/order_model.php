<?php
class Order_Model extends Base_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'order';
	
	
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
	 * Get order history
	 * 
	 * @param array $data
	 * 	$data['strategy']['id'] = the strategy id
	 * 
	 * @return array $results mysql result array 
	 */
	public function get_order_history(&$data)
	{
		if (!isset($data['strategy']['id']) || empty($data['strategy']['id']) || !is_numeric($data['strategy']['id']))
			return FALSE;

		$strategy_id = $data['strategy']['id'];

		/*
		SELECT
		 o.created_time, p.name as plan_name, p.bank, p.plan_type, o.status, o.order_total
		FROM
		 `order` as `o`
		JOIN strategy s ON s.id = o.strategy_id
		JOIN plan p ON p.id = o.plan_id
		JOIN strategy_type st ON st.id = p.strategy_type
		WHERE
			s.id = 1
		*/

		// confirm user access to this record
		$this->load->model('strategy/strategy_model');
	    $ret = $this->strategy_model->authorize_action($data);
	    if (!$ret)
	        return FALSE;

		$this->load->library('datatables');

		$this->datatables->select('o.created_time, p.name as plan_name, p.bank, p.plan_type, o.status, o.order_total');
		$this->datatables->from('order as o');

		$this->datatables->join('strategy AS s', 's.id = o.strategy_id');
		$this->datatables->join('plan AS p', 'p.id = o.plan_id');

		$this->datatables->where('s.id', $strategy_id);

        //$this->datatables->unset_column('code_id');

        $result = $this->datatables->generate();

		return $result;
	}


	/**
	 * Set status
	 * 
	 * Set status to enabled or disabled
	 * 
	 * @param mixed $data either integer representing the order id or the order data payload (expecting to access $data['order']['id'])
	 * @param integer $status the status of the order: 0 for open, 1 for paid
	 * @return bool true/false
	 */
	public function set_status(&$data, $status = 0)
	{
	    if (is_numeric($data))
	        $order_id = $data;
	    elseif (isset($data['order']['id']))
	        $order_id = $data['order']['id'];
	    else
	        return FALSE;

	    $ret = $this->update($order_id, array('status' => $status));
	    
	    return $ret;
	}
	

	/**
	 * Save an order
	 * 
	 * @param array $data array elements: name, contact_id
	 * @return mixed $ret boolean false on errors, and array elements: customer_id
	 */
	public function save_order($data, $new = FALSE)
	{
	    if (!isset($data['order']))
	        return FALSE;
	        
	    $order = $data['order'];
	    
	    // if id was received then we update the record, otherwise we insert a new one 
	    if (isset($order['id']) && $new === FALSE)
	    {
	        // confirm user access to this record
            $ret = $this->authorize_action($data);
            if (!$ret)
                return FALSE;
	        
	        $order_id = $order['id'];
	        
	        if (isset($order['operator_id']))
	            $record['operator_id'] = $order['operator_id'];
	            
	        if (isset($order['status']))
	            $record['status'] = $order['status'];
	            
	        if (isset($order['sales_rep_id']))
	            $record['sales_rep_id'] = $order['sales_rep_id'];
	        
	        if (isset($order['promotion_id']))
	            $record['promotion_id'] = $order['promotion_id'];
	        
	        if (isset($order['order_total']))
	            $record['order_total'] = isset($order['order_total']) ? $order['order_total'] : $this->calc_order_total($data);
	         
	        if (isset($order['strategy_id']))
	            $record['strategy_id'] = $order['strategy_id'];

	        if (isset($order['plan_id']))
	            $record['plan_id'] = $order['plan_id'];

	        if (isset($order['expiration_date']))
	            $record['expiration_date'] = $order['expiration_date'];

	        $ret = $this->update($order_id, $record);
	        if (!$ret)
	        {
	            log_message('debug', ' - Order => Save => error updating record');
	            return FALSE;
	        }

	    }
	    else
	    {
			// create the record

			// if no associated record ids provided then we quit
			if (!isset($order['operator_id']) && !isset($order['strategy_id']) && !isset($order['plan_id']))
			{
			 log_message('error', ' - Order => Save => Insert => missing operator_id or strategy_id or plan_id');
			 return FALSE;
			}

			$order_total = $this->calc_order_total($data);

			/*
			 * for handling order status: if order status was passed in then it takes, otherwise we check if a 
			 * plan happens to have a cost of 0 - hence free and then status should be 'paid' to flag that it's
			 * an active ("paid") order.
			 */
			if (isset($order['status']))
				$status = $order['status'];
			else if ($order_total == 0)
				$status = 'paid';
			else
				$status = 'open';

    	    $order_id = $this->insert(
    	        array(
    	        	'operator_id' => $order['operator_id'],
    	        	'created_time' => isset($order['created_time']) ? $order['created_time'] : date('Y-m-d H:i:s'),
    	            'status' => $status,
    	            'sales_rep_id' => isset($order['sales_rep_id']) ? $order['sales_rep_id'] : NULL,
    	            'promotion_id' => isset($order['promotion_id']) && $order['promotion_id'] ? $order['promotion_id'] : NULL,
    	            //'order_total' => isset($order['order_total']) ? $order['order_total'] : '0',
    	            'order_total' => $order_total,
    	            'plan_id' => isset($order['plan_id']) ? $order['plan_id'] : 0,
    	            'strategy_id' => $order['strategy_id'],
    	            'expiration_date' => isset($order['expiration_date']) ? $order['expiration_date'] : '0000-00-00 00:00:00',
    	        )
    	    ); 
	    }
	    
	    if (!$order_id)
	        return FALSE;
	        
	    log_message('debug', ' + Order => Save => saved record');
	    
	    return array(
	    	'order_id' => $order_id,
	    );

	}



	public function validate_plan_order(&$data)
	{
		
		$plan = array();

		// checking to see if we received the plan id
		if (is_numeric($data))
		{
			$plan['id'] = $data;
		}
		else
		{
			$plan = $data['plan'];
		}

		if (!isset($plan['id']) || !is_numeric($plan['id']))
			return FALSE;

		$this->load->model('plan/plan_model');

		// check if ordered plan is the 'free' plan


		// get how many free plans
		
        //$ret = $this->plan_model->check_free_plans();

	}
	
	

	/**
	 * Calculate order total
	 * 
	 * Calculates the order total sum based on the plan cost and any promotion set
	 * 
	 * @param array $data 
	 */
	public function calc_order_total(&$data)
	{
		if (!isset($data['plan']['id']))
			return FALSE;
		
		// initialize plan cost;
		$plan_cost = 0;

		// if we don't have the cost then let's find it out
		if (!isset($data['plan']['cost']))
		{
			$this->load->model('plan/plan_model');
			$plan = $this->plan_model->get($data['plan']['id']);
			$plan_cost = isset($plan->cost) ? $plan->cost : 0;
		}
		else
		{
			$plan_cost = $data['plan']['cost'];
		}

		// if any promotions were set, let's get them
		if (isset($data['order']['promotion_id']))
		{
			$this->load->model('promotion/promotion_model');
			$promotion = $this->promotion_model->get($data['order']['promotion_id']);

			// we need promotion_discount to actually calculate this
			if (isset($promotion->discount))
			{
				// calculate promotions by type
				switch ($promotion->type)
				{
					case "percent":
						$plan_cost = $plan_cost - ($plan_cost * ($promotion->discount/100));
						break;

					case "absolute":
						$plan_cost = $plan_cost - ($promotion->discount);
						break;

					default:
						break;
				}
			}
		}

		// the cost is now negative? wtf? are we paying people to use our service? :-)
		// this may happen due to 'absolute' type of promotions which may be higher than any of our plans cost
		// so rule of thumb would be to always provide promotions as percentages but heck...
		if ($plan_cost <= 0)
			$plan_cost = 0;

		// while collecting pennies and dimes would sum up to quite alot of money, let's stick to real numbers for now 
		return (int) round($plan_cost);
	}

	
	public function authorize_action(&$data)
	{
	    $bool = parent::authorize_action($data);
	    $bool = $bool && $this->auth_order($data);
	    
	    return $bool;
	}
	
		
	public function auth_order(&$data)
	{
	    /*
         * SQL Example:
         * 
			SELECT op.id, op.brand_id
     		FROM operator op
     		WHERE
     			op.id = 1
     	 *
     	 *
         */
	    
	    $operator = $data['operator'];
	    
        $this->db->select('op.id');
        $this->db->select('op.brand_id');
        $this->db->from('operator AS op');
        
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
            
        $this->db->where('op.id', $data['operator_id']);
        
        
        $ret = $this->db->get()->row_array();
        
        if (!$ret)
            return FALSE;
        
        return $ret;
	}
	
	
}