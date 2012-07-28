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
	

	public function get($data = NULL)
	{
		if (!isset($data) || !$data)
			return FALSE;

		if (!isset($data['contact']['id']))
			return FALSE;

		// verify access to this record
		if ($this->authorize_action($data))
		{
			return parent::get($data['contact']['id']);
		}

		return FALSE;
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
	    {
	        return FALSE;
	    }
	        
	    $contact = $data['contact'];
	    
	    // if id was received then we update the record, otherwise we insert a new one 
	    if (isset($contact['id']))
	    {
	        // confirm user access to this record
            $ret = $this->authorize_action($data);
            if (!$ret)
                return FALSE;
	        
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

	        if (isset($contact['fax']))
	            $record['fax'] = $contact['fax'];

	        if (isset($contact['gender']))
	            $record['gender'] = $contact['gender'];
	        
	        if (isset($contact['email']))
	            $record['email'] = $contact['email'];

	        if (isset($contact['website']))
	            $record['website'] = $contact['website'];

	        $ret = $this->update($contact_id, $record);
	        if (!$ret)
	        {
	            log_message('debug', ' - Contact => Save => error updating record');
	            return FALSE;
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
	        return FALSE;
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
	
	
	/**
	 * 
	 * @param array $data
	 * 	one of the elements for each contact record
	 * 	['operator']['id']
	 *  ['customer']['id']
	 *  ['brand']['id']
	 * 
	 */
	public function auth_contact(&$data)
	{
	    /*
         * SQL Example:
         * 
         	SELECT contact.id
     		FROM contact 
     		JOIN operator op ON op.contact_id = contact.id
     		WHERE
     			op.id = 1
     		AND
     			contact.id = 1
     	 *
     	 *
         */
	    
	    $contact = $data['contact'];
	    
	    $this->db->select('contact.id');
	    $this->db->from('contact');

	    // join whichever table is required to get the correct contact entry
        // we need to choose which table to join for the contact id
        // it can either be operator, brand or customer and we verify this by
        // checking which of them is set in the $data payload
	    if (isset($data['operator']['id']))
	    {
	    	$this->db->join('operator AS op', 'op.contact_id = contact.id');
	    }
	    elseif (isset($data['brand']['id']))
	    {
	    	$this->db->join('brand AS b', 'b.contact_id = contact.id');
			$this->db->join('operator AS op', 'op.brand_id = b.id');
	    	$this->db->where('b.id', $data['brand']['id']);
	    }
	    else if (isset($data['customer']['id']))
	    {
	    	$this->db->join('customer AS cust', 'cust.contact_id = contact.id');
	    	$this->db->join('brand AS b', 'b.customer_id = cust.id');
	    	$this->db->join('operator AS op', 'op.brand_id = b.id');
	    	$this->db->where('cust.id', $data['customer']['id']);
	    }
	    else
	    	return FALSE;
       
        if (isset($contact['id']))
            $this->db->where('contact.id', $contact['id']);
        else
            return FALSE;
        
        if (!isset($data['operator']['id']))
        {
            $operator_id = $this->get_operator_id();
        }
        else
        {
            $operator_id = $data['operator']['id'];
        }
        
        if (!$operator_id)
            return FALSE;
            
		$this->db->where('op.id', $operator_id);
        
        
        $ret = $this->db->get()->row_array();
        
        if (!$ret)
            return FALSE;
        
        return $ret;
	}
	
	
}