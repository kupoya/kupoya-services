<?php
class Code_Model extends Base_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'code';
	
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
	 * Create brand<->campaign code
	 * 
	 * Creates the code which is used for the url to redirect to the campaign/strategy
	 * 
	 * @param array $data array elements: brand_id, campaign_id
	 */
	public function create_code($data)
	{
	    if (!isset($data['brand_id']) || !isset($data['campaign_id']))
	        return FALSE;
	    
	    // confirm user access to this record
        $ret = $this->authorize_action_create($data);
        if (!$ret)
            return FALSE;
	        
        $code_id = $this->insert(
            array(
                'brand_id' => $data['brand_id'],
                'campaign_id' => $data['campaign_id'],
            )
        );
        
        if (!$code_id)
            return FALSE;
	        
        return array('code_id' => $code_id);
	    
	}


    public function get_code(&$data)
    {
        if (!isset($data['campaign']['id']) && !isset($data['brand']['id']) && !isset($data['code']['id']))
            return FALSE;

        // verify access to this record
        if ($this->auth_code_update($data))
        {
            $where = array();
            if (isset($data['code']['id']))
                $where['id'] = $data['code']['id'];

            if (isset($data['brand']['id']))
                $where['brand_id'] = $data['brand']['id'];

            if (isset($data['campaign']['id']))
                $where['campaign_id'] = $data['campaign']['id'];

            return (array) parent::get_by($where);
        }

        return FALSE;
    }


    public function authorize_action_create(&$data)
    {
        $bool = parent::authorize_action($data);
        $bool = $bool && $this->auth_code_create($data);
        
        return $bool;
    }

    public function authorize_action_update(&$data)
    {
        $bool = parent::authorize_action($data);
        $bool = $bool && $this->auth_code_update($data);
        
        return $bool;
    }


    /**
     * Authorize code update
     * 
     * Validate that the operator whose associated with the brand_id has access to this code and campaign
     */
    public function auth_code_update($data)
    {
        /*
         * SQL Example:
         * 
            SELECT op.id, op.brand_id
            FROM operator op
            JOIN brand b ON op.brand_id = b.id
            JOIN code code ON code.brand_id = b.id
            JOIN campaign c ON c.id = code.campaign_id
            WHERE
                op.id = 1
            AND
                c.id = 1
            AND
                b.id = 1
         *
         *
         */

        $this->db->select('op.id');
        $this->db->select('op.brand_id');
        $this->db->from('operator AS op');
        $this->db->join('brand AS b', 'op.brand_id = b.id');
        $this->db->join('code AS code', 'code.brand_id = b.id');
        $this->db->join('campaign AS camp', 'camp.id = code.campaign_id');
        
        if (isset($data['campaign_id']) && isset($data['brand_id']))
        {
            $this->db->where('camp.id', $data['campaign_id']);
            $this->db->where('b.id', $data['brand_id']);
        }
        else if (isset($data['campaign']['id']))
        {
            $this->db->where('camp.id', $data['campaign']['id']);
        }
        else
        {
            return FALSE;
        }
        
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


    /**
     * Authorize code creation
     * 
     * Validating that the operator has access to the brand_id provided
     */
    public function auth_code_create($data)
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
        
        if (isset($data['brand_id']))
        {
            $this->db->where('b.id', $data['brand_id']);
        }
        else
        {
            return FALSE;
        }
        
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