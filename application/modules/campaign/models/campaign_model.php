<?php
class Campaign_Model extends Base_Model {
	
    /**
     * @var string		model table name
     */
	protected $_table = 'campaign';
	
	
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
	 * Create Campaign
	 * 
	 * @param array $data 
	 * @param bool $create_code specify whether a code should be created for this campaign or not
	 * @return mixed $ret boolean false on errors, and newly inserted campaign or code id records: array elements: campaign_id, code_id
	 */
	public function create_campaign($data, $create_code = FALSE)
	{
	    if (!isset($data['campaign']))
	        return FALSE;
	        
	    $campaign = $data['campaign'];

	    if (!isset($campaign['name']))
	    	return FALSE;

	    $campaign_id = $this->insert(
	        array(
    	        'name' => $campaign['name'],
    	        // by default, if no campaign_mode was provided we assume campaign_mode = 1
    	        'campaign_mode' => isset($campaign['campaign_mode']) ? $campaign['campaign_mode'] : '1', 
	        )
	    ); 
	    
	    if (!$campaign_id)
	        return FALSE;
	    
	    if ($create_code === TRUE)
	    {
	        // brand_id was not provided to create the code for this campaign? just create the campaign
	        if (!isset($data['brand']['id']))
	        {
	            log_message('error', ' - Campaign => Create => create_code set to true but no brand_id provided');
	            break;
	        }
	        
	        $this->load->model('code/code_model');
	        $ret = $this->code_model->create_code(
	            array(
	                'brand_id' => $data['brand']['id'],
	                'campaign_id' => $campaign_id,
	            )
	         );
	        
	        if ($ret)
	        {
		        log_message('debug', ' + Campaign => Create => created campaign and code');
		         
		        // return campaign and code ids
		        return array(
		        	'code_id' => $ret['code_id'],
		        	'campaign_id' => $campaign_id,
		        );
	    	}
	    }
	    
	    log_message('debug', ' + Campaign => Create => created campaign');
	    
	    return array(
	        'campaign_id' => $campaign_id,
	    );

	}
	
	
	/**
	 * Update Campaign
	 * 
	 * Update campaign information: campaign name and campaign mode
	 * 
	 * @param array $data array elements: campaign_id, campaign_name, campaign_mode
	 * @return bool $ret true/false
	 */
	public function update_campaign($data)
	{
	    if (!isset($data['campaign_id']))
	        return false;
	        
        // confirm user access to this record
        $ret = $this->auth_campaign($data);
        if (!$ret)
            return false;
	    
        $ret = false;
        
	    if (isset($data['campaign_name']) && isset($data['campaign_mode']))
	    {
    	    $ret = $this->update($data['campaign_id'],
    	        array(
    	            'campaign_name' => $data['campaign_name'],
    	            'campaign_mode' => $data['campaign_mode'],
    	        ) 
    	    );
	    }
	    elseif (isset($data['campaign_name']) && !isset($data['campaign_mode']))
	    {
	        $ret = $this->update($data['campaign_id'],
    	        array(
    	            'campaign_name' => $data['campaign_name'],
    	        )
    	    );
	    }
	    elseif (!isset($data['campaign_name']) && isset($data['campaign_mode']))
	    {
	        $ret = $this->update($data['campaign_id'],
    	        array(
    	            'campaign_mode' => $data['campaign_mode'],
    	        )
    	    );
	    }
	    
	    return $ret;
	        
	    
	}
	
	
	
	public function auth_campaign($data)
	{
	    /*
         * SQL Example:
         * 
			SELECT op.id, op.brand_id
     		FROM operator op
     		JOIN brand b ON op.brand_id = b.id
     		JOIN code code ON code.brand_id = code.id
     		JOIN campaign c ON c.id = code.campaign_id
     		WHERE
     			op.id = 1
     		AND
     			c.id = 1
     	 *
     	 *
         */
        $this->db->select('op.id');
        $this->db->select('op.brand_id');
        $this->db->from('operator AS op');
        $this->db->join('brand AS b', 'op.brand_id = b.id');
        $this->db->join('code AS code', 'code.brand_id = code.id');
        $this->db->join('campaign AS c', 'c.id = code.campaign_id');
        
        if (isset($data['campaign_id']))
            $this->db->where('c.id', $data['campaign_id']);
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
        
        $ret = $this->db->get()->row_array();
        
        if (!$ret)
            return false;
        
        return $ret;
	}
	
	
}