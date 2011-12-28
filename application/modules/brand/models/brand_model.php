<?php
class Brand_Model extends Base_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'brand';
	
	
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
	 * 	array of data, at least expecting brand element with id element
	 * 
	 */
	public function get($data = NULL)
	{
		if (!isset($data['brand']['id']))
			return FALSE;

		// verify access to this record
		//$data['brand']['id'] = $record_id;
		if ($this->authorize_action($data))
		{
			return parent::get($data['brand']['id']);
		}

		return FALSE;
	}
	
	
	/**
	 * Set blocked status
	 * 
	 * Set blocked status to enabled or disabled
	 * 
	 * @param mixed $data either integer representing the brand id or the brand data payload (expecting to access $data['brand']['id'])
	 * @param bool $status true to enable and false to disable the brand
	 * @return bool true/false
	 */
	public function set_status($data, $status = false)
	{

	    if (is_numeric($data))
	        $brand_id = $data;
	    elseif (isset($data['brand']['id']))
	        $brand_id = $data['brand']['id'];
	    else
	        return FALSE;

	    $ret = $this->update($brand_id, array('blocked' => $status));
	    
	    return $ret;
	}
	
	
	/**
	 * Save a Brand
	 * 
	 * @param array $data array elements: name, description, picture, contact_id, customer_id, blocked, service_id
	 * @return mixed $ret boolean false on errors, and newly inserted campaign or code id records: array elements: campaign_id, code_id
	 */
	public function save_brand($data)
	{
		if (!isset($data['brand']))
	        return FALSE;
	        
	    $brand = $data['brand'];

	    // if id was received then we update the record, otherwise we insert a new one 
	    if (isset($brand['id']))
	    {
	        // confirm user access to this record
            $ret = $this->authorize_action($data);
            if (!$ret)
                return FALSE;
	        
	        $brand_id = $brand['id'];
	        if (isset($brand['name']))
	            $record['name'] = $brand['name'];
	            
	        if (isset($brand['picture']))
	            $record['picture'] = $brand['picture'];
	            
	        if (isset($brand['description']))
	            $record['description'] = $brand['description'];
	            
	        if (isset($brand['contact_id']))
	            $record['contact_id'] = $brand['contact_id'];
	            
	        if (isset($brand['customer_id']))
	            $record['customer_id'] = $brand['customer_id'];
	            
	        if (isset($brand['blocked']))
	            $record['blocked'] = $brand['blocked'];
	            
	        if (isset($brand['service_id']))
	            $record['service_id'] = $brand['service_id'];	            
  
  			// nothing to update?
  			if (!$record)
  				return FALSE;

	        $ret = $this->update($brand_id, $record);
	        if (!$ret)
	        {
	            log_message('debug', ' - Brand => Save => error updating brand');
	            return FALSE;
	        }

	    }
	    else
	    {
	         // create the brand record
	         
	         // if no associated record ids provided then we quit
	         if (!isset($brand['contact_id']) || !isset($brand['customer_id']) || !isset($brand['service_id']))
	         {
	             log_message('error', ' - Brand => Save => Insert => missing one of contact_id, customer_id or service_id');
	             return FALSE;
	         }   
	        
    	    $brand_id = $this->insert(
    	        array(
        	        'name' => isset($brand['name']) ? $brand['name'] : '',
    	        	'picture' => isset($brand['picture']) ? $brand['picture'] : '',
    	            'description' => isset($brand['description']) ? $brand['description'] : '',
    	            'contact_id' => $brand['contact_id'],
    	            'customer_id' => $brand['customer_id'],
                    // by default, if no campaign_mode was provided we assume that brand is activated
        	        'blocked' => isset($brand['blocked']) ? $brand['blocked'] : '0',
    	            'service_id' => $brand['service_id'],
    	        )
    	    ); 
	    }
	    
	    if (!$brand_id)
	        return FALSE;
	        
	    log_message('debug', ' + Brand => Save => saved brand');
	    
	    return array(
	    	'brand_id' => $brand_id,
	    );

	}
	
	
	
	public function authorize_action(&$data)
	{
	    $bool = parent::authorize_action($data);
	    $bool = $bool && $this->auth_brand($data);
	    
	    return $bool;
	}
	
		
	public function auth_brand(&$data)
	{
	    /*
         * SQL Example:
         * 
			SELECT b.id
     		FROM brand AS b
     		JOIN operator op ON op.brand_id = b.id
     		WHERE
     			op.id = 1
     		AND
     			b.id = 1
     	 *
     	 *
         */
        
        if (!isset($data['brand']))
        	return FALSE;

        $brand = $data['brand'];
        if (!$brand || !isset($brand['id']))
        	return FALSE;
        
        $this->db->select('b.id');
        $this->db->from('brand AS b');
        $this->db->join('operator AS op', 'op.brand_id = b.id');

        $this->db->where('b.id', $brand['id']);        
        
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