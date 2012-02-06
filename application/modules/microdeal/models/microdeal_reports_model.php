<?php

$ci =& get_instance();
$ci->load->model('strategy/strategy_model');

class Microdeal_Reports_Model extends Strategy_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'coupon';
	
	
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
	 * 	the aggregation type (hour, day, month or date)
	 * 
	 * @return array $results mysql result array 
	 */
	public function get_strategy_requests(&$data = NULL, $agg_type = 'date')
	{
		if (!isset($data['strategy']['id']))
			return FALSE;

		$strategy_id = $data['strategy']['id'];

		$date_start = $this->input->post('date_start', TRUE);
		$date_end = $this->input->post('date_end', TRUE);

// 		$type = $this->input->post('type');
// 		if (isset($type) && $type)
// 		{
// 			$agg_type = $type;
// log_message('error', 'got type: ************************************************** '.$add_type);
// 		}

		// confirm user access to this record
	    // $ret = $this->authorize_action($data);
	    // if (!$ret)
	    //     return FALSE;

	    /*
		SELECT 
		--    count(visits), count(redemptions), t
		-- SUM(visits > 0) as col1, SUM(redemptions>0) as col2 
		SUM(visits) as visits, SUM(redemptions) as redemptions, t

		FROM
		(
		    (
		    SELECT req.strategy_id as visits, 0 as 'redemptions', DATE( req.TIME ) AS t
		    FROM stat_strategy_requests as req
		    WHERE strategy_id =  '1'
		    ) 
		    
		    UNION ALL
		    
		    (
		    SELECT 0, coup.strategy_id AS redemptions, DATE( coup.purchased_time ) AS t
		    FROM coupon coup
		    WHERE coup.strategy_id =  '1'
		    ) 
		)
		AS t1    
		GROUP BY t
		ORDER BY t ASC
	    */

		// impose date range, by default use the past month
		$now = new DateTime('now');

		if (isset($date_start) && $date_start)
		{	
			// $date_params = explode('-', $date_start);
			// $month = isset($date_params[0]) ? $date_params[0] : date('m');
			// $day = isset($date_params[1]) ? $date_params[1] : date('d');
			// $year = isset($date_params[2]) ? $date_params[2] : date('Y');
			// $date_start = $now->setDate($year, $month, $day)->format('Y-m-d 00:00:01');
			// $date_start = new DateTime($date_start)->format('Y-m-d 00:00:01');;
		}
		else
		{
			// @TODO - change this so by default it will be:
			//$date_start = $now->modify('first day of this month')->format('Y-m-d 00:00:01');

			$date_start = $now->modify('first day of last month')->format('Y-m-d 00:00:01');
		}
		
		if (isset($date_end) && $date_end)
		{
		// 	$date_params = explode('/', $date_end);
		// 	$month = isset($date_params[0]) ? $date_params[0] : date('m');
		// 	$day = isset($date_params[1]) ? $date_params[1] : date('d');
		// 	$year = isset($date_params[2]) ? $date_params[2] : date('Y');
		// 	$date_end = $now->setDate($year, $month, $day)->format('Y-m-d 00:00:01');
			// $date_end = new DateTime($date_end);
		}
		else
		{
			$date_end = $now->modify('last day of this month')->format('Y-m-d 23:59:59');
		}

		// $this->db->where('s.time >=', $date_start);
		// $this->db->where('s.time <=', $date_end);

		// $this->db->where('cs.campaign_id', $info['campaign']['id']);

	    $query = "
		SELECT 
			SUM(visits) as visits, SUM(redemptions) as redemptions, t
		FROM
		(
		    (
		    SELECT req.strategy_id as visits, 0 as 'redemptions', DATE( req.TIME ) AS t
		    FROM stat_strategy_requests as req
		    WHERE
		    	strategy_id =  ?
		    AND
		    	req.time >= ?
		    AND
		    	req.time <= ?
		    ) 
		    
		    UNION ALL
		    
		    (
		    SELECT 0, coup.strategy_id AS redemptions, DATE( coup.purchased_time ) AS t
		    FROM coupon coup
		    WHERE coup.strategy_id = ?
		    AND
		    	coup.purchased_time >= ?
		    AND
		    	coup.purchased_time <= ?
		    ) 
		)
		AS t1    
		GROUP BY t
		ORDER BY t ASC
	    ";

	    $result = $this->db->query($query, array($strategy_id, $date_start, $date_end, $strategy_id, $date_start, $date_end))->result_array();

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

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Redemptions',
			'pattern' => '',
			'type' => 'number',
		);

		foreach($result as $row => $row_data) {
			$payload['rows'][]['c'] = array(
				0 => array('v' => $row_data['t'], 'f' => null),
				1 => array('v' => (int) $row_data['visits'], 'f' => null),
				2 => array('v' => (int) $row_data['redemptions'], 'f' => null),
			);
		}

		return $payload;
	}

}