<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup_Wizard_Model extends Base_Model
{

	/**
     * @var string		model table name
     */
	protected $_table = '';
	

	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Constructor
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	

	public function register_brand(&$data)
	{
		if (!$data || !isset($data['brand']) || !isset($data['contact']) || !isset($data['customer']))
			return false;

		$this->load->model('contact/contact_model');
		$this->load->model('customer/customer_model');
		$this->load->model('brand/brand_model');

		// create the contact
		$ret = $this->contact_model->save_contact($data);
		if (!$ret || !isset($ret['contact_id']))
			return false;
		
		$contact_id = $ret['contact_id'];

		// create the customer
		// set the contact_id field for the new customer
		$data['customer']['contact_id'] = $contact_id;
		$ret  = $this->customer_model->save_customer($data);
		if (!$ret || !isset($ret['customer_id']))
			return false;
		
		$customer_id = $ret['customer_id'];

		// create the brand
		// set the customer_id and contact_id fields for the new brand
		$data['brand']['contact_id'] = $contact_id;
		$data['brand']['customer_id'] = $customer_id;
		$ret  = $this->brand_model->save_brand($data);
		if (!$ret || !isset($ret['brand_id']))
			return false;
		
		$brand_id = $ret['brand_id'];

		// if we have the operator info let's update it with the brand and contact ids
		if (isset($data['operator']['id']))
		{
			// update
			$ret = $this->db->where('id', $data['operator']['id'])
					 ->set(
						array(
							'brand_id' => $brand_id,
							'contact_id' => $contact_id,
						)
					 )
					 ->update('operator');

			if (!$ret)
				$return['operator']['id'] = false;
			else
				$return['operator']['id'] = $data['operator']['id'];
		}

		$return['brand']['id'] = $brand_id;
		$return['contact']['id'] = $contact_id;
		$return['customer']['id'] = $customer_id;

		return $return;

	}




}