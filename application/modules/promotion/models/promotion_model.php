<?php
class Promotion_Model extends Base_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'promotion';
	
	
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
	 * Validate promotion is still valid (not expired)
	 * 
	 * @param
	 */
	public function validate($promotion_id = NULL)
	{
		if (!$promotion_id)
			return FALSE;

		$curr_date = date('Y-m-d H:i:s');

		$this->db->select('id');
		$this->db->from('promotion');
		$this->db->where('expiration_date >=', $curr_date);
		$this->db->where('id', $promotion_id);

		$ret = $this->db->get()->row_array();

		if (!$ret || count($ret) === 0)
			return FALSE;

		return TRUE;
	}
	
}