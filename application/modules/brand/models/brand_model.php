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
	        return false;

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
	        return false;
	        
	    $brand = $data['brand'];

	    // if id was received then we update the record, otherwise we insert a new one 
	    if (isset($brand['id']))
	    {
	        // confirm user access to this record
            $ret = $this->authorize_action($data);
            if (!$ret)
                return false;
	        
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
  
	        $ret = $this->update($brand_id, $record);
	        if (!$ret)
	        {
	            log_message('debug', ' - Brand => Save => error updating brand');
	            return false;
	        }

	    }
	    else
	    {
	         // create the brand record
	         
	         // if no associated record ids provided then we quit
	         if (!isset($brand['contact_id']) || !isset($brand['customer_id']) || !isset($brand['service_id']))
	         {
	             log_message('error', ' - Brand => Save => Insert => missing one of contact_id, customer_id or service_id');
	             return false;
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
	        return false;
	        
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
			SELECT op.id, op.brand_id
     		FROM operator op
     		JOIN brand b ON op.brand_id = b.id
     		WHERE
     			op.id = 1
     		AND
     			b.id = 1
     	 *
     	 *
         */
        $this->db->select('op.id');
        $this->db->select('op.brand_id');
        $this->db->from('operator AS op');
        $this->db->join('brand AS b', 'op.brand_id = b.id');
        
        if (isset($data['id']))
            $this->db->where('b.id', $data['id']);
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