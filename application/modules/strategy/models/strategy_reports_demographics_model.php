<?php

require('strategy_model.php');
class Strategy_Reports_Demographics_Model extends Strategy_Model {
	
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
		if (!isset($data['strategy']['id']) || empty($data['strategy']['id']) || !is_numeric($data['strategy']['id']))
			return FALSE;

		$strategy_id = $data['strategy']['id'];

		// confirm user access to this record
		// @TODO
		// $this->load->model('brand/brand_model');
	 //    $ret = $this->brand_model->authorize_action($data);
	 //    if (!$ret)
	 //        return FALSE;

	 	//$this->load->library('datatables');
	 	$this->load->library('mongo_db');

	 	$this->mongo_db->select('platform');

	 	// get_paging();
	 	// ----------------------------------------------------------------------------------------
	 	if($this->ci->input->post("iDisplayStart") && $this->ci->input->post("iDisplayLength") !== "-1")
	 	{
			//$sLimit = "LIMIT " . $this->ci->input->post("iDisplayStart"). ", " .$this->ci->input->post("iDisplayLength");
			$this->mongo_db->limit($this->ci->input->post("iDisplayStart"));
			$this->mongo_db->offset($this->ci->input->post("iDisplayLength"));
		}
		else
		{
			$iDisplayLength = $this->ci->input->post("iDisplayLength");

			if(empty($iDisplayLength))
			{
				//$sLimit = "LIMIT " . "0,10";
				$this->mongo_db->limit(10);
				$this->mongo_db->offset(0);
			}
			else
			{
				//$sLimit = "LIMIT " . "0,". $this->ci->input->post("iDisplayLength");
				$this->mongo_db->limit($iDisplayLength);
				$this->mongo_db->offset(0);
			}
		}
		// ----------------------------------------------------------------------------------------


	 	// get_ordering();
	 	// ----------------------------------------------------------------------------------------
	 	

	 	// ----------------------------------------------------------------------------------------




	 	$ret = $this->mongo_db->get('strategy_requests');

	 	return $ret;
	}



}