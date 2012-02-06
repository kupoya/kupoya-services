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