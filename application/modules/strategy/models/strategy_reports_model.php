<?php

$ci =& get_instance();
$ci->load->model('strategy/strategy_model');

class Strategy_Reports_Model extends Strategy_Model {
// class Strategy_Reports_Model extends Base_Model {
	
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
	 * 
	 * @param array $data
	 * 	$data['strategy']['id'] = the strategy id
	 * @param string $agg_type
	 * 	the aggregation type (hour, day, month)
	 * 
	 * @return array $results mysql result array 
	 */
	public function get_strategy_requests_agg_by(&$data = NULL, $agg_type = 'day')
	{
		if (!isset($data['strategy']['id']))
			return FALSE;

		// confirm user access to this record
	    $ret = $this->authorize_action($data);
	    if (!$ret)
	        return FALSE;

	    switch($agg_type)
	    {
	    	case 'hour':
	    		$this->db->select('s.strategy_id as strategy_id, COUNT(s.strategy_id) as visit, HOUR(s.time) as t');
	    		$time_label = 'Hour';
	    		break;
	    	
	    	case 'month':
	    		$this->db->select('s.strategy_id as strategy_id, COUNT(s.strategy_id) as visit, MONTHNAME(s.time) as t');
	    		$time_label = 'Month';
	    		break;

	    	case 'day':
	    	default:
	    		$this->db->select('s.strategy_id as strategy_id, COUNT(s.strategy_id) as visit, DAYNAME(s.time) as t');
	    		$time_label = 'Day';
	    		break;
	    }

		$this->db->from('stat_strategy_requests AS s');
		$this->db->where('s.strategy_id', $data['strategy']['id']);
		$this->db->group_by('t');

		$result = $this->db->get()->result_array();

		$payload['cols'][] = array(
			'id' => '',
			'label' => $time_label,
			'pattern' => '',
			'type' => 'string',
		);

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Visits',
			'pattern' => '',
			'type' => 'number',
		);

		foreach($result as $row => $row_data) {
			$payload['rows'][]['c'] = array(
				0 => array('v' => $row_data['t'], 'f' => null),
				1 => array('v' => (int) $row_data['visit'], 'f' => null),
			);
		}

		return $payload;
	}


	/**
	 * 
	 * @param array $data
	 * 	$data['strategy']['id'] = the strategy id
	 * @param string $agg_type
	 * 	the aggregation type (hour, day, month or date)
	 * 
	 * @return array $results mysql result array 
	 */
	public function get_strategy_requests(&$data = NULL, $agg_type = 'date')
	{
		if (!isset($data['strategy']['id']))
			return FALSE;

		$date_start = $this->input->post('date_start', TRUE);
		$date_end = $this->input->post('date_end', TRUE);

// 		$type = $this->input->post('type');
// 		if (isset($type) && $type)
// 		{
// 			$agg_type = $type;
// log_message('error', 'got type: ************************************************** '.$add_type);
// 		}

		// confirm user access to this record
	    $ret = $this->authorize_action($data);
	    if (!$ret)
	        return FALSE;

	    /*
			SELECT strategy_id, COUNT( strategy_id ) , DATE( TIME ) AS t
			FROM stat_strategy_requests
			WHERE strategy_id =  '1'
			GROUP BY t
	    */

		$this->db->select('s.strategy_id as strategy_id, COUNT(s.strategy_id) as visit, DATE(s.time) as t');
		$this->db->from('stat_strategy_requests AS s');
		// $this->db->join('campaign_strategies AS cs', 'cs.strategy_id = s.id');
		// $this->db->join('code AS code', 'code.campaign_id = cs.campaign_id');
		$this->db->where('s.strategy_id', $data['strategy']['id']);

		// impose date range, by default use the past month
		$now = new DateTime('now');
		if (isset($date_start) && $date_start)
		{	
			$date_params = explode('/', $date_start);
			$month = isset($date_params[0]) ? $date_params[0] : date('m');
			$day = isset($date_params[1]) ? $date_params[1] : date('d');
			$year = isset($date_params[2]) ? $date_params[2] : date('Y');
			$date_start = $now->setDate($year, $month, $day)->format('Y-m-d 00:00:01');
		}
		else
		{
			$date_start = $now->modify('first day of this month')->format('Y-m-d 00:00:01');
		}
		
		if (isset($date_end) && $date_end)
		{
			$date_params = explode('/', $date_end);
			$month = isset($date_params[0]) ? $date_params[0] : date('m');
			$day = isset($date_params[1]) ? $date_params[1] : date('d');
			$year = isset($date_params[2]) ? $date_params[2] : date('Y');
			$date_end = $now->setDate($year, $month, $day)->format('Y-m-d 00:00:01');
		}
		else
		{
			$date_end = $now->modify('last day of this month')->format('Y-m-d 23:59:59');
		}

		$this->db->where('s.time >=', $date_start);
		$this->db->where('s.time <=', $date_end);

		// $this->db->where('cs.campaign_id', $info['campaign']['id']);

		$this->db->group_by('t');

		// we don't really need anymore than 1 row returned and actually that would be a bug if that's the case
		// $this->db->limit(1);

		$result = $this->db->get()->result_array();

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Time',
			'pattern' => '',
			'type' => 'string',
		);

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Visits',
			'pattern' => '',
			'type' => 'number',
		);

		foreach($result as $row => $row_data) {
			$payload['rows'][]['c'] = array(
				0 => array('v' => $row_data['t'], 'f' => null),
				1 => array('v' => (int) $row_data['visit'], 'f' => null),
			);
		}

		return $payload;
	}


}