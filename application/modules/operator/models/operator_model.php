<?php
class Operator_Model extends Base_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'operator';
	
	
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
	 * Update last login time
	 */
	public function update_last_login(&$data)
	{
	    if (is_numeric($data))
	        $operator_id = $data;
	    elseif (isset($data['operator']['id']))
	        $operator_id = $data['operator']['id'];
	    else
	        return false;

	    $ret = $this->update($operator_id, array('last_login' => time()));
	    
	    return $ret;
	}
	
	
	/**
	 * Set status
	 * 
	 * Set status to enabled or disabled
	 * 
	 * @param mixed $data either integer representing the operator id or the operator data payload (expecting to access $data['operator']['id'])
	 * @param bool $status true to enable and false to disable
	 * @return bool true/false
	 */
	public function set_status(&$data, $status = true)
	{
	    if (is_numeric($data))
	        $operator_id = $data;
	    elseif (isset($data['operator']['id']))
	        $operator_id = $data['operator']['id'];
	    else
	        return false;

	    $ret = $this->update($operator_id, array('active' => $status));
	    
	    return $ret;
	}
	

	public function get($record_id = NULL, $override = FALSE)
	{
		if (!isset($record_id) || !$record_id)
			return FALSE;

		// this is required because in controllers/auth.php:78 we're trying to get the operator records
		// but unable to pass through operator_auth() because no operator session object is set yet
		if ($override === TRUE)
			return parent::get($record_id);

		// verify access to this record
		$data['operator_id'] = $record_id;
		if ($this->authorize_action($data['operator_id']))
		{
			return parent::get($record_id);
		}

		return FALSE;
	}


	public function load_operator($data)
	{
		if (!isset($data['operator_id']))
		{
			return FALSE;
		}

        $operator = $this->get($data['operator_id']);
        if ($operator)
        {
        	$data['operator'] = (array) $operator;
        }
        else
        	return FALSE;
		
		// also load contact information for this operator
		if (isset($data['operator']))
		{
			$this->load->model('contact/contact_model');
			$options['operator']['id'] = $data['operator_id'];
			$options['contact']['id'] = $data['operator']['contact_id'];
			$contact = $this->contact_model->get($options);
			if ($contact)
			{
				$data['contact'] = (array) $contact;
			}
		}

		if (!$data)
			return FALSE;

		return $data;
	}


	/**
	 * Save an Operator
	 * 
	 * @param array $data array elements: name, contact_id
	 * @return mixed $ret boolean false on errors, and array elements: customer_id
	 */
	public function save_operator($data)
	{
	    if (!isset($data['operator']))
	        return false;
	        
	    $operator = $data['operator'];
	    
	    // if id was received then we update the record, otherwise we insert a new one 
	    if (isset($operator['id']))
	    {
	        // confirm user access to this record
            $ret = $this->authorize_action($data);
            if (!$ret)
                return FALSE;
	        
	        $operator_id = $operator['id'];
	        
	        if (isset($operator['username']))
	            $record['username'] = $operator['username'];
	            
	        if (isset($operator['password']))
	            $record['password'] = $operator['password'];
	            
	        if (isset($operator['email']))
	            $record['email'] = $operator['email'];
	        
	        if (isset($operator['active']))
	            $record['active'] = $operator['active'];
	        
	        if (isset($operator['contact_id']))
	            $record['contact_id'] = $operator['contact_id'];
	         
	        if (isset($operator['brand_id']))
	            $record['brand_id'] = $operator['brand_id'];

	        $ret = $this->update($operator_id, $record);
	        if (!$ret)
	        {
	            log_message('debug', ' - Operator => Save => error updating record');
	            return false;
	        }

	    }
	    else
	    {
	         // create the record
	         
	         // if no associated record ids provided then we quit
	         if (!isset($operator['contact_id']) || !isset($operator['brand_id']))
	         {
	             log_message('error', ' - Operator => Save => Insert => missing contact_id or brand_id');
	             return false;
	         }   
	        
    	    $operator_id = $this->insert(
    	        array(
    	            'username' => isset($operator['username']) ? $operator['username'] : '',
    	            'password' => isset($operator['password']) ? $operator['password'] : '',
    	            'email' => isset($operator['email']) ? $operator['email'] : '',
    	            'blocked' => isset($operator['blocked']) ? $operator['blocked'] : '0',
    	            'contact_id' => $operator['contact_id'],
    	            //'brand_id' => $operator['brand_id'],
    	            // @TODO fix the date to use the new DateTime class which is better
    	            'created_time' => date('Y-m-d H:i:s'),
    	        )
    	    ); 
	    }
	    
	    if (!$operator_id)
	        return false;
	        
	    log_message('debug', ' + Customer => Save => saved record');
	    
	    return array(
	    	'operator_id' => $operator_id,
	    );

	}
	
	
	
	public function authorize_action(&$data)
	{
	    $bool = parent::authorize_action($data);
	    $bool = $bool && $this->auth_operator($data);
	    
	    return $bool;
	}
	
	
	public function auth_operator(&$data)
	{
		// make sure loaded operator is the same as current operator
		if ($this->get_operator_id() != $data['operator_id'])
			return FALSE;

	    /*
         * SQL Example:
         * 
			SELECT op.id, op.brand_id
     		FROM operator op
     		WHERE
     			op.id = 1
     	 *
     	 *
         */

	    // $operator = $data['operator'];
	    
        $this->db->select('op.id');
        $this->db->select('op.brand_id');
        $this->db->from('operator AS op');
        
        if (!isset($data['operator_id']))
        {
            $operator_id = $this->get_operator_id();
        }
        else
        {
            $operator_id = $data['operator_id'];
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