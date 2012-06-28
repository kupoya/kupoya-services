<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Microdeal_Model extends Base_Model
{

	/**
     * @var string		model table name
     */
	protected $_table = 'coupon';

	/**
	 * The primary key, by default set to
	 * `id`, for use in some functions.
	 *
	 * @var string
	 */
	protected $primary_key = 'id';

	protected $strategy_type = 'microdeal';


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
	 * Get a specific microdeal coupon 
	 * 
	 * @param integer $coupon_id
	 */
	public function get($coupon_id = NULL)
	{
		
		if (!isset($coupon_id))
			return FALSE;

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if ($this->authorize_action($data))
		{
			return parent::get($coupon_id);
		}

		return FALSE;
	}


	/**
	 * Get microdeal strategy settings
	 * 
	 * @param integer $strategy_id
	 */
	public function get_settings($strategy_id = NULL)
	{
		
		if (!isset($strategy_id))
			return FALSE;

		// load the microdeal_settings_model
		$this->load->model('microdeal/microdeal_settings_model');
		$ret = $this->microdeal_settings_model->get($strategy_id);

		return $ret;
	}


	public function load_blocks($strategy_id, $view)
	{
		$this->load->model('strategy/strategy_model');

		$blocks = array();
		if (is_array($view))
		{
			foreach ($view as $v)
			{
				$blocks[$v] = $this->strategy_model->get_blocks($strategy_id, $v);		
			}
		}
		else
		{
			$blocks = $this->strategy_model->get_blocks($strategy_id, $view);
		}

		return $blocks;
	}



	/**
	 * Get Total Coupon Redemptions for a microdeal
	 * 
	 * @param mixed $data array with elements 'strategy' or the strategy_id as integer
	 * @return int $result
	 */
	public function get_total_redemptions($data)
	{
		if (is_numeric($data))
			$strategy_id = $data;

		if (isset($data['strategy']['id']))
			$strategy_id = $data['strategy']['id'];

		if (!$strategy_id)
			return FALSE;
		
		// static redemptions per strategy id
		static $total_redemptions;

		if (isset($total_redemptions[$strategy_id]))
			return $total_redemptions[$strategy_id];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}

		$this->db->select('COUNT(coupon.id) AS redemptions');
		$this->db->from('coupon AS coupon');
		$this->db->where('coupon.strategy_id', $strategy_id);
		$ret = $this->db->get()->row_array();

		if (!$ret)
			return FALSE;

		$total_redemptions[$strategy_id] = isset($ret['redemptions']) ? (int) $ret['redemptions'] : FALSE;

		return $total_redemptions[$strategy_id];
	}



	/**
	 * Get Total Customers
	 * Provides the conversion rate between scanned/strategy visit hits to actual coupon redemptions. Returns data in percentage (rounded down)
	 * 
	 * @param mixed $data array with elements 'strategy' or the strategy_id as integer
	 * @return int $result
	 */
	public function get_conversion_rate($data)
	{
		if (is_numeric($data))
			$strategy_id = $data;

		if (isset($data['strategy']['id']))
			$strategy_id = $data['strategy']['id'];

		if (!$strategy_id)
			return FALSE;
		
		// static exposure per strategy id
		static $total_customers;

		if (isset($conversion_rate[$strategy_id]))
			return $conversion_rate[$strategy_id];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}

		// select COUNT(DISTINCT(coupon.user_id)) from coupon AS coupon where coupon.strategy_id = 1
		$this->db->select('COUNT(DISTINCT(coupon.user_id)) as total_customers');
		$this->db->from('coupon AS coupon');
		$this->db->where('coupon.strategy_id', $strategy_id);
		$ret = $this->db->get()->row_array();

		if (!$ret)
			return FALSE;

		$conversion_rate[$strategy_id] = isset($ret['total_customers']) ? (int) $ret['total_customers'] : FALSE;

		return $conversion_rate[$strategy_id];
	}



	/**
	 * Get Total Coupon Exposure
	 * Sums the friends count of all users who retreived a coupon for a strategy
	 * 
	 * @param mixed $data array with elements 'strategy' or the strategy_id as integer
	 * @return int $result
	 */
	public function get_total_exposure($data)
	{
		if (is_numeric($data))
			$strategy_id = $data;

		if (isset($data['strategy']['id']))
			$strategy_id = $data['strategy']['id'];

		if (!$strategy_id)
			return FALSE;
		
		// static exposure per strategy id
		static $total_exposure;

		if (isset($total_exposure[$strategy_id]))
			return $total_exposure[$strategy_id];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}

		// select SUM(ui.friends_count) from coupon AS coupon join user_info ui ON coupon.user_id = ui.id where coupon.strategy_id = 1
		$this->db->select('SUM(ui.friends_count) as total_exposure');
		$this->db->from('coupon AS coupon');
		$this->db->join('user_info ui', 'coupon.user_id = ui.id');
		$this->db->where('coupon.strategy_id', $strategy_id);
		$ret = $this->db->get()->row_array();

		if (!$ret)
			return FALSE;

		$total_exposure[$strategy_id] = isset($ret['total_exposure']) ? (int) $ret['total_exposure'] : FALSE;

		return $total_exposure[$strategy_id];
	}






	/**
	 * Get Total Customers
	 * Provides the total customers count. Sums the users who retrieved a coupon at least once from the strategy
	 * 
	 * @param mixed $data array with elements 'strategy' or the strategy_id as integer
	 * @return int $result
	 */
	public function get_total_customers($data)
	{
		if (is_numeric($data))
			$strategy_id = $data;

		if (isset($data['strategy']['id']))
			$strategy_id = $data['strategy']['id'];

		if (!$strategy_id)
			return FALSE;
		
		// static exposure per strategy id
		static $total_customers;

		if (isset($total_customers[$strategy_id]))
			return $total_customers[$strategy_id];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}

		// select COUNT(DISTINCT(coupon.user_id)) from coupon AS coupon where coupon.strategy_id = 1
		$this->db->select('COUNT(DISTINCT(coupon.user_id)) as total_customers');
		$this->db->from('coupon AS coupon');
		$this->db->where('coupon.strategy_id', $strategy_id);
		$ret = $this->db->get()->row_array();

		if (!$ret)
			return FALSE;

		$total_customers[$strategy_id] = isset($ret['total_customers']) ? (int) $ret['total_customers'] : FALSE;

		return $total_customers[$strategy_id];
	}




	/**
	 * Get Returning Customers
	 * Provides the returning customers in percentage (rounded down) for a given campaign
	 * 
	 * @param mixed $data array with elements 'strategy' or the strategy_id as integer
	 * @return int $result
	 */
	public function get_returning_customers($data)
	{
		if (is_numeric($data))
			$strategy_id = $data;

		if (isset($data['strategy']['id']))
			$strategy_id = $data['strategy']['id'];

		if (!$strategy_id)
			return FALSE;
		
		// static exposure per strategy id
		static $returning_customers;

		if (isset($returning_customers[$strategy_id]))
			return $returning_customers[$strategy_id];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}

		// count of returning customers (retreival > 1)
		$sql = 
			'SELECT
	         COUNT(*) as count
	        FROM
	        (
	            SELECT
	             count(coupon.id) as count
	            FROM `coupon`
	            WHERE
	             strategy_id = ?
	            GROUP BY coupon.user_id
	            HAVING COUNT > 1
	        ) as t';
	    
	    $result = $this->db->query($sql, array($strategy_id));
	    if ($result->num_rows() <= 0)
	    	return FALSE;
	    
	    $row = $result->row_array();
	    $returning_customers_count = $row['count'];

	    // count of customers in total...
		$this->db->select('COUNT(DISTINCT(coupon.user_id)) as count');
		$this->db->from('coupon AS coupon');
		$this->db->where('coupon.strategy_id', $strategy_id);
		$ret = $this->db->get()->row_array();

		if (!$ret)
			return FALSE;

		$total_customers_count = $ret['count'];
		if ($total_customers_count == 0)
			$returning_customers_percent = 0;
		else
			$returning_customers_percent = floor(($returning_customers_count / $total_customers_count) * 100);

		$returning_customers[$strategy_id] = $returning_customers_percent;

		return $returning_customers[$strategy_id];
	}




	public function get_estimated_exposure($data)
	{
		$total_redemptions = $this->get_total_redemptions($data);
		if (!$total_redemptions)
			return FALSE;

		if (is_numeric($data))
			$strategy_id = $data;

		if (isset($data['strategy']['id']))
			$strategy_id = $data['strategy']['id'];

		if (!$strategy_id)
			return FALSE;

		static $estimated_exposure;
		if (isset($estimated_exposure[$strategy_id]))
			return $estimated_exposure[$strategy_id];

		$estimated_exposure_factor = 137;
		$estimated_exposure[$strategy_id] = ($estimated_exposure_factor * $total_redemptions);

		return $estimated_exposure[$strategy_id];

	}


	public function microdeal_load($data)
	{
		if (is_numeric($data))
			$strategy_id = $data;

		if (isset($data['strategy']['id']))
			$strategy_id = $data['strategy']['id'];
		
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

		$microdeal = $this->get_settings($strategy_id);

		// get strategy blocks
		// sadly cant use strategy_type = microdeal since the old naming convention is coupon..
		//$strategy_blocks = $this->load_blocks($strategy_id, $this->strategy_type);
		$strategy_blocks = $this->load_blocks($strategy_id, array('coupon', 'coupon_view'));
		
		$result['strategy'] = (array) $strategy;
		$result['microdeal'] = (array) $microdeal;
		$result['blocks'] = (array) $strategy_blocks;
		$result['plan'] = (array) $plan;
		return $result;
	}

}