<?php
class Contact_Model extends Base_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'contact';
	
	
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
	 * Save a Contact
	 * 
	 * @param array $data array elements: name, contact_id
	 * @return mixed $ret boolean false on errors, and array elements: customer_id
	 */
	public function save_contact(&$data)
	{
	    if (!isset($data['contact']))
	        return false;
	        
	    $contact = $data['contact'];
	    
	    // if id was received then we update the record, otherwise we insert a new one 
	    if (isset($contact['id']))
	    {
	        // confirm user access to this record
            $ret = $this->authorize_action($data);
            if (!$ret)
                return false;
	        
	        $contact_id = $contact['id'];
	        
	        if (isset($contact['name']))
	            $record['name'] = $contact['name'];
	            
	        if (isset($contact['first_name']))
	            $record['first_name'] = $contact['first_name'];
	            
	        if (isset($contact['last_name']))
	            $record['last_name'] = $contact['last_name'];

	        if (isset($contact['address']))
	            $record['address'] = $contact['address'];
	        
	        if (isset($contact['city']))
	            $record['city'] = $contact['city'];
	        
	        if (isset($contact['state']))
	            $record['state'] = $contact['state'];
	        
	        if (isset($contact['country']))
	            $record['country'] = $contact['country'];
	        
	        if (isset($contact['phone']))
	            $record['phone'] = $contact['phone'];

	        if (isset($contact['gender']))
	            $record['gender'] = $contact['gender'];
	        
	        if (isset($contact['email']))
	            $record['email'] = $contact['email'];

	        $ret = $this->update($contact_id, $record);
	        if (!$ret)
	        {
	            log_message('debug', ' - Contact => Save => error updating record');
	            return false;
	        }

	    }
	    else
	    {
			// insert a new record
    	    $contact_id = $this->insert(
    	        array(
    	        	'name' => isset($contact['name']) ? $contact['name'] : '',
    	        	'first_name' => isset($contact['first_name']) ? $contact['first_name'] : '',
    	        	'last_name' => isset($contact['last_name']) ? $contact['last_name'] : '',
    	        	'address' => isset($contact['address']) ? $contact['address'] : '',
    	        	'city' => isset($contact['city']) ? $contact['city'] : '',
    	        	'state' => isset($contact['state']) ? $contact['state'] : '',
    	        	'country' => isset($contact['country']) ? $contact['country'] : '',
    	        	'phone' => isset($contact['phone']) ? $contact['phone'] : '',
    	        	'gender' => isset($contact['gender']) ? $contact['gender'] : '',
    	        	'email' => isset($contact['email']) ? $contact['email'] : '',
    	        )
    	    ); 
	    }
	    
	    if (!$contact_id) {
	        log_message('debug', ' - Contact => Save => error inserting record');
	        return false;
	    }
	        
	    log_message('debug', ' + Contact => Save => saved record');
	    
	    return array(
	    	'contact_id' => $contact_id,
	    );

	}
	
	
	
	public function authorize_action(&$data)
	{
	    $bool = parent::authorize_action($data);
	    $bool = $bool && $this->auth_contact($data);
	    
	    return $bool;
	}
	
		
	public function auth_contact(&$data)
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
	    
	    $contact = $data['contact'];
	    
        $this->db->select('op.id');
        $this->db->select('op.brand_id');
        $this->db->from('operator AS op');
        $this->db->join('brand AS b', 'op.brand_id = b.id');
        $this->db->join('customer AS cust', 'b.customer_id = cust.id');
        
        // we need to choose which table to join for the contact id
        // it can either be operator, brand or customer and we verify this by
        // checking which of them is set in the $data payload
        if (isset($data['operator']))
            $this->db->join('contact AS contact', 'op.contact_id = contact.id');
        elseif (isset($data['brand']))
            $this->db->join('contact AS contact', 'b.contact_id = contact.id');
        elseif (isset($data['customer']))
            $this->db->join('contact AS contact', 'cust.contact_id = contact.id');
        else
            return false;
        
        
        if (isset($contact['id']))
            $this->db->where('contact.id', $contact['id']);
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