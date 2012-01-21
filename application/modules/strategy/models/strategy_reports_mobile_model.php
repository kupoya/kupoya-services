<?php

require('strategy_model.php');
class Strategy_Reports_Mobile_Model extends Strategy_Model {
	
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
	 * @TODO
	 * 
	 * @param array $data
	 * 	$data['brand']['id'] = the brand id
	 * 
	 * @return array $results mysql result array 
	 */
	public function get_platform_list(&$data)
	{

		if (!isset($data['strategy']['id']))
			return FALSE;

		$date_start = $this->input->post('date_start', TRUE);
		$date_end = $this->input->post('date_end', TRUE);

		// confirm user access to this record
	    $ret = $this->authorize_action($data);
	    if (!$ret)
	        return FALSE;

		/*
		SELECT DISTINCT(platform) as platform, COUNT(platform) count
		 FROM `stat_strategy_requests` 
		WHERE strategy_id = 1
		GROUP BY platform
		*/

		//$this->db->distinct('platform');
		$this->db->select('DISTINCT(platform) AS platform, COUNT(strategy_id) count', TRUE);
		$this->db->from('stat_strategy_requests AS s');
		$this->db->where('s.strategy_id', $data['strategy']['id']);

		// impose date range, by default use the past month
		// $now = new DateTime('now');
		// if (isset($date_start) && $date_start)
		// {	
		// 	$date_params = explode('/', $date_start);
		// 	$month = isset($date_params[0]) ? $date_params[0] : date('m');
		// 	$day = isset($date_params[1]) ? $date_params[1] : date('d');
		// 	$year = isset($date_params[2]) ? $date_params[2] : date('Y');
		// 	$date_start = $now->setDate($year, $month, $day)->format('Y-m-d 00:00:01');
		// }
		// else
		// {
		// 	$date_start = $now->modify('first day of this month')->format('Y-m-d 00:00:01');
		// }
		
		// if (isset($date_end) && $date_end)
		// {
		// 	$date_params = explode('/', $date_end);
		// 	$month = isset($date_params[0]) ? $date_params[0] : date('m');
		// 	$day = isset($date_params[1]) ? $date_params[1] : date('d');
		// 	$year = isset($date_params[2]) ? $date_params[2] : date('Y');
		// 	$date_end = $now->setDate($year, $month, $day)->format('Y-m-d 00:00:01');
		// }
		// else
		// {
		// 	$date_end = $now->modify('last day of this month')->format('Y-m-d 23:59:59');
		// }

		// $this->db->where('s.time >=', $date_start);
		// $this->db->where('s.time <=', $date_end);

		// $this->db->where('cs.campaign_id', $info['campaign']['id']);

		$this->db->group_by('platform');

		// we don't really need anymore than 1 row returned and actually that would be a bug if that's the case
		// $this->db->limit(1);

		$result = $this->db->get()->result_array();

		$payload['cols'][] = array(
			'id' => 'a',
			'label' => 'Platform',
			// 'pattern' => '',
			'type' => 'string',
		);

		$payload['cols'][] = array(
			'id' => 'b',
			'label' => 'Count',
			// 'pattern' => '',
			'type' => 'number',
		);

		foreach($result as $row => $row_data) {
			$payload['rows'][]['c'] = array(
				0 => array('v' => $row_data['platform'], 'f' => null),
				1 => array('v' => (int) $row_data['count'], 'f' => null),
			);
		}

		//$payload = $result;

		return $payload;
	}




	/**
	 * @TODO
	 * 
	 * @param array $data
	 * 	$data['brand']['id'] = the brand id
	 * 
	 * @return array $results mysql result array 
	 */
	public function get_browser_list(&$data)
	{

		if (!isset($data['strategy']['id']))
			return FALSE;

		$date_start = $this->input->post('date_start', TRUE);
		$date_end = $this->input->post('date_end', TRUE);

		// confirm user access to this record
	    $ret = $this->authorize_action($data);
	    if (!$ret)
	        return FALSE;

		/*
		SELECT DISTINCT(browser) as browser, COUNT(platform) count
		 FROM `stat_strategy_requests` 
		WHERE strategy_id = 1
		GROUP BY browser
		*/

		//$this->db->distinct('platform');
		$this->db->select('DISTINCT(browser) AS browser, COUNT(strategy_id) count', TRUE);
		$this->db->from('stat_strategy_requests AS s');
		$this->db->where('s.strategy_id', $data['strategy']['id']);

		// impose date range, by default use the past month
		// $now = new DateTime('now');
		// if (isset($date_start) && $date_start)
		// {	
		// 	$date_params = explode('/', $date_start);
		// 	$month = isset($date_params[0]) ? $date_params[0] : date('m');
		// 	$day = isset($date_params[1]) ? $date_params[1] : date('d');
		// 	$year = isset($date_params[2]) ? $date_params[2] : date('Y');
		// 	$date_start = $now->setDate($year, $month, $day)->format('Y-m-d 00:00:01');
		// }
		// else
		// {
		// 	$date_start = $now->modify('first day of this month')->format('Y-m-d 00:00:01');
		// }
		
		// if (isset($date_end) && $date_end)
		// {
		// 	$date_params = explode('/', $date_end);
		// 	$month = isset($date_params[0]) ? $date_params[0] : date('m');
		// 	$day = isset($date_params[1]) ? $date_params[1] : date('d');
		// 	$year = isset($date_params[2]) ? $date_params[2] : date('Y');
		// 	$date_end = $now->setDate($year, $month, $day)->format('Y-m-d 00:00:01');
		// }
		// else
		// {
		// 	$date_end = $now->modify('last day of this month')->format('Y-m-d 23:59:59');
		// }

		// $this->db->where('s.time >=', $date_start);
		// $this->db->where('s.time <=', $date_end);

		// $this->db->where('cs.campaign_id', $info['campaign']['id']);

		$this->db->group_by('browser');

		// we don't really need anymore than 1 row returned and actually that would be a bug if that's the case
		// $this->db->limit(1);

		$result = $this->db->get()->result_array();

		$payload['cols'][] = array(
			'id' => 'a',
			'label' => 'Browser',
			// 'pattern' => '',
			'type' => 'string',
		);

		$payload['cols'][] = array(
			'id' => 'b',
			'label' => 'Count',
			// 'pattern' => '',
			'type' => 'number',
		);

		foreach($result as $row => $row_data) {
			$payload['rows'][]['c'] = array(
				0 => array('v' => $row_data['browser'], 'f' => null),
				1 => array('v' => (int) $row_data['count'], 'f' => null),
			);
		}

		//$payload = $result;

		return $payload;
	}



}