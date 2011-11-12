<?php
class Customer_Model extends Base_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'customer';
	
	
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
	 * Save a Customer
	 * 
	 * @param array $data array elements: name, contact_id
	 * @return mixed $ret boolean false on errors, and array elements: customer_id
	 */
	public function save_customer(&$data)
	{
	    if (!isset($data['customer']))
	        return false;
	        
	    $customer = $data['customer'];
	    
	    // if id was received then we update the record, otherwise we insert a new one 
	    if (isset($customer['id']))
	    {
	        // confirm user access to this record
            $ret = $this->authorize_action($data);
            if (!$ret)
                return false;
	        
	        $customer_id = $customer['id'];
	        
	        if (isset($customer['name']))
	            $record['name'] = $customer['name'];
	            
	        if (isset($customer['contact_id']))
	            $record['contact_id'] = $customer['contact_id'];

	        $ret = $this->update($customer_id, $record);
	        if (!$ret)
	        {
	            log_message('debug', ' - Customer => Save => error updating record');
	            return false;
	        }

	    }
	    else
	    {
	         // insert a new record
	         
	         // if no associated record ids provided then we quit
	         if (!isset($customer['contact_id']))
	         {
	             log_message('error', ' - Customer => Save => Insert => missing contact_id');
	             return false;
	         }   
	        
    	    $customer_id = $this->insert(
    	        array(
        	        'name' => isset($customer['name']) ? $customer['name'] : '',
    	            'contact_id' => $customer['contact_id'],
    	        )
    	    ); 
	    }
	    
	    if (!$customer_id)
	        return false;
	        
	    log_message('debug', ' + Customer => Save => saved record');
	    
	    return array(
	    	'customer_id' => $customer_id,
	    );

	}
	
	
	
	public function authorize_action(&$data)
	{
	    $bool = parent::authorize_action($data);
	    $bool = $bool && $this->auth_customer($data);
	    
	    return $bool;
	}
	
		
	public function auth_customer(&$data)
	{
	    /*
         * SQL Example:
         * 
			SELECT op.id, op.brand_id
     		FROM operator op
     		JOIN brand b ON op.brand_id = b.id
     		JOIN customer cust ON b.customer_id = cust.id
     		WHERE
     			op.id = 1
     		AND
     			cust.id = 1
     	 *
     	 *
         */
	    
	    $customer = $data['customer'];
	    
        $this->db->select('op.id');
        $this->db->select('op.brand_id');
        $this->db->from('operator AS op');
        $this->db->join('brand AS b', 'op.brand_id = b.id');
        $this->db->join('customer AS cust', 'b.customer_id = cust.id');
        
        if (isset($customer['id']))
            $this->db->where('cust.id', $customer['id']);
        else
            return false;
        
        
        if (!isset($data['operator_id']))
        {
            $operator_id = $this->get_operator_id();
        }
        else
        {
            $operator_id = $data['operator_id'];
        }
        
        if (!$operator_id)
            return false;
            
        $this->db->where('op.id', $data['operator_id']);
        
        
        $ret = $this->db->get()->row_array();
        
        if (!$ret)
            return false;
        
        return $ret;
	}
	
	
}