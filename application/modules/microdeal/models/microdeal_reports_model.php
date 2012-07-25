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
	 * 
	 * @return array $results mysql result array
	 */
	public function get_customer_friends_count_profile(&$data = NULL) {

		if (!isset($data['strategy']['id']))
			return FALSE;

		$strategy_id = $data['strategy']['id'];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}

		$query = '
			SELECT
			 SUM(IF (t1.friends_count >= 0 AND t1.friends_count <= 500, 1, 0)) as range0,
			 SUM(IF (t1.friends_count >= 501 AND t1.friends_count <= 1000, 1, 0)) as range500,
			 SUM(IF (t1.friends_count >= 1001 AND t1.friends_count <= 2000, 1, 0)) as range1000,
			 SUM(IF (t1.friends_count >= 2001, 1, 0)) as range2000
			FROM (
			    SELECT
			     DISTINCT(user_info.id) as user_info_id, user_info.friends_count as friends_count
			    FROM coupon
			    JOIN user as user ON user.id = coupon.user_id
			    JOIN user_info as user_info ON user.user_info_id = user_info.id
			    WHERE
			     coupon.strategy_id = ?
			) as t1
		';

		$result = $this->db->query($query, $strategy_id)->row_array();

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Range',
			'pattern' => '',
			'type' => 'string',
		);

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Users',
			'pattern' => '',
			'type' => 'number',
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => '0-500', 'f' => null),
			1 => array('v' => (int) $result['range0'], 'f' => null),
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => '501-1000', 'f' => null),
			1 => array('v' => (int) $result['range500'], 'f' => null),
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => '1001-2000', 'f' => null),
			1 => array('v' => (int) $result['range1000'], 'f' => null),
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => '2001+', 'f' => null),
			1 => array('v' => (int) $result['range2000'], 'f' => null),
		);

		return $payload;

	}



	/**
	 * 
	 * @param array $data
	 * 	$data['strategy']['id'] = the strategy id
	 * 
	 * @return array $results mysql result array
	 */
	public function get_customer_redemption_profile(&$data = NULL) {

		if (!isset($data['strategy']['id']))
			return FALSE;

		$strategy_id = $data['strategy']['id'];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}

		$this->load->model('microdeal/microdeal_model');
		$returning_customers = $this->microdeal_model->get_returning_customers($data);

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Customer Deal Claims Profile',
			'pattern' => '',
			'type' => 'string',
		);

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Count',
			'pattern' => '',
			'type' => 'number',
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => 'Multiple', 'f' => null),
			1 => array('v' => (int) $returning_customers, 'f' => null),
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => 'One-time', 'f' => null),
			1 => array('v' => (int) (100-$returning_customers), 'f' => null),
		);

		return $payload;



	}


	/**
	 * 
	 * @param array $data
	 * 	$data['strategy']['id'] = the strategy id
	 * 
	 * @return array $results mysql result array
	 */
	public function get_redemptions_per_returning_customer(&$data = NULL) {

		if (!isset($data['strategy']['id']))
			return FALSE;

		$strategy_id = $data['strategy']['id'];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}

		$query = '

		SELECT
		(
		    SELECT COUNT(*) 
		    FROM (
		    SELECT COUNT(id) AS user_freq
		    FROM  coupon
		    WHERE strategy_id = ?
		    GROUP BY user_id
		    HAVING user_freq = 2
		    ) as t1
		) as redemps2,
		(
		    SELECT COUNT(*) 
		    FROM (
		    SELECT COUNT(id) AS user_freq
		    FROM  coupon
		    WHERE strategy_id = ?
		    GROUP BY user_id
		    HAVING user_freq = 3
		    ) as t2
		) as redemps3,
		(
		    SELECT COUNT(*) 
		    FROM (
		    SELECT COUNT(id) AS user_freq
		    FROM  coupon
		    WHERE strategy_id = ?
		    GROUP BY user_id
		    HAVING user_freq = 4
		    ) as t3
		) as redemps4,
		(
		    SELECT COUNT(*) 
		    FROM (
		    SELECT COUNT(id) AS user_freq
		    FROM  coupon
		    WHERE strategy_id = ?
		    GROUP BY user_id
		    HAVING user_freq >= 5
		    ) as t4
		) as redemps5

		';

		$result = $this->db->query($query, array($strategy_id, $strategy_id, $strategy_id, $strategy_id))->row_array();

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Returning Customers',
			'pattern' => '',
			'type' => 'string',
		);

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Deal Claims Count',
			'pattern' => '',
			'type' => 'number',
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => '2', 'f' => null),
			1 => array('v' => (int) $result['redemps2'], 'f' => null),
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => '3', 'f' => null),
			1 => array('v' => (int) $result['redemps3'], 'f' => null),
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => '4', 'f' => null),
			1 => array('v' => (int) $result['redemps4'], 'f' => null),
		);

		$payload['rows'][]['c'] = array(
			0 => array('v' => '5+', 'f' => null),
			1 => array('v' => (int) $result['redemps5'], 'f' => null),
		);

		return $payload;



	}


	/**
	 * 
	 * @param array $data
	 * 	$data['strategy']['id'] = the strategy id
	 * 
	 * @return array $results mysql result array 
	 */
	public function get_redemptions_foot_traffic(&$data = NULL)
	{

		if (!isset($data['strategy']['id']))
			return FALSE;

		$strategy_id = $data['strategy']['id'];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}

	    /*
		SELECT
		    COUNT(coup.strategy_id) AS redemptions, DATE_FORMAT( coup.purchased_time, '%w' ) as t, DATE_FORMAT( coup.purchased_time, '%W' ) AS day_of_week
		FROM coupon coup
		WHERE coup.strategy_id =1
		GROUP BY t
		ORDER BY t ASC
	    */

	    $this->db->select('COUNT(coup.strategy_id) AS redemptions, DATE_FORMAT(coup.purchased_time, "%w") as t, DATE_FORMAT(coup.purchased_time, "%W") AS day_of_week', FALSE);
	    $this->db->from('coupon AS coup');
	    $this->db->where('coup.strategy_id', $strategy_id);

	    $this->db->group_by('t');
	    $this->db->order_by('t', 'ASC');

	    $result = $this->db->get();

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Day of Week',
			'pattern' => '',
			'type' => 'string',
		);

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Deal claims',
			'pattern' => '',
			'type' => 'number',
		);

		foreach($result->result_array() as $row) {
			$payload['rows'][]['c'] = array(
				0 => array('v' => substr($row['day_of_week'], 0, 3), 'f' => null),
				1 => array('v' => (int) $row['redemptions'], 'f' => null),
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
	public function get_strategy_exposure(&$data = NULL, $agg_type = 'date')
	{
		if (!isset($data['strategy']['id']))
			return FALSE;

		$strategy_id = $data['strategy']['id'];

		// verify access to this record
		$data['coupon']['id'] = $strategy_id;
		if (!$this->authorize_action($data))
		{
			return FALSE;
		}


		$date_start = $this->input->post('date_start', TRUE);
		$date_end = $this->input->post('date_end', TRUE);

	    /*
		SELECT
		    COUNT(coup.strategy_id) AS redemptions, DATE( coup.purchased_time ) AS t, SUM(ui.friends_count)
		FROM coupon coup
		JOIN user u ON u.id = coup.user_id
		JOIN user_info ui ON ui.id = u.user_info_id
		WHERE coup.strategy_id = 1
		GROUP BY t
		ORDER BY t ASC
	    */

		// impose date range, by default use the past month
		if (!$date_start)
		{
			$now = new DateTime('now');
			$date_start = $now->modify('first day of last month')->format('Y-m-d 00:00:01');
		}
	
		if (!$date_end)
		{
			$now = new DateTime('now');
			$date_end = $now->format('Y-m-t 23:59:59');
		}

	    //$this->db->select('COUNT(coup.strategy_id) AS redemptions, DATE_FORMAT(coup.purchased_time,"%c/%e") AS t, SUM(ui.friends_count) AS exposure', FALSE);
	    $this->db->select('COUNT(coup.strategy_id) AS redemptions, DATE(coup.purchased_time) AS t, SUM(ui.friends_count) AS exposure');
	    $this->db->from('coupon AS coup');
	    $this->db->join('user AS u', 'u.id = coup.user_id');
	    $this->db->join('user_info AS ui', 'ui.id = u.user_info_id');
	    $this->db->where('coup.strategy_id', $strategy_id);

	    if ($date_start) {
	    	$this->db->where('coup.purchased_time >=', $date_start);
	    }

	    if ($date_end) {
	    	$this->db->where('coup.purchased_time <=', $date_end);
	    }

	    $this->db->group_by('t');
	    $this->db->order_by('t', 'ASC');

	    $result = $this->db->get();

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Time',
			'pattern' => '',
			'type' => 'string',
		);

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Deal claims',
			'pattern' => '',
			'type' => 'number',
		);

		$payload['cols'][] = array(
			'id' => '',
			'label' => 'Est. exposure',
			'pattern' => '',
			'type' => 'number',
			
		);

		foreach($result->result_array() as $row) {
			$payload['rows'][]['c'] = array(
				0 => array('v' => $row['t'], 'f' => null),
				1 => array('v' => (int) $row['redemptions'], 'f' => null),
				2 => array('v' => (int) $row['exposure'], 'f' => null),
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
			'label' => 'Deal claims',
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