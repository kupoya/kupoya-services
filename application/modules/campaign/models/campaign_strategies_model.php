<?php
/**
 * Campaign Strategies Model
 *
 * @link    http://kupoya.com
 *
 * Description:
 * [describe]
 *
 * @package		kupoya
 * @copyright	Copyright (c) 2011 Liran Tal
 * @version		1.0
 */
class Campaign_Strategies_Model extends Base_Model {
    
	/**
     * @var string		model table name
     */
	protected $_table = 'campaign_strategies';
	
	
    /**
     * @var string		primary key is actually 'campaign_id' and 'strategy_id'
     */
	protected $primary_key = 'campaign_id';
    
	
	/*
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
     * @TODO inspect if it's possible to just pass a parameter to set active to true without actually
     * having to insert a record and then update it
     * 
     * @param array $data array elements: campaign_id, strategy_id and active being true/false
     * @return bool true/false
     */
    public function create_campaign_strategy($data)
    {
        if (!isset($data['campaign_id']) || !isset($data['strategy_id']))
        {
            log_message('error', '- Campaign Strategies => Create => no campaign_id or strategy_id provided');
            return FALSE;
        }
        
        $ret = $this->insert(
            array(
                'campaign_id' => $data['campaign_id'],
                'strategy_id' => $data['strategy_id'],
                // by default, set the active state of this campaign/strategy mapping to inactive
                'active' => isset($data['active']) ? (bool) $data['active'] : '0'
            )
        );
        
        if ($ret === FALSE)
            return FALSE;

        return TRUE;        
    }
    
    
    /**
     * Set Active Strategy for Campaign
     *
     * A specific strategy will be made active, while others will be rendered inactive
     * 
     * @param array $data array elements: strategy_id, campaign_id
     */
    public function set_active($data)
    {
        if (!is_array($data) || !isset($data['strategy_id']) || !isset($data['campaign_id']))
            return FALSE;
        
        // confirm user access to this record
        $ret = $this->authorize_action_update($data);
        if (!$ret)
            return FALSE;
        
        // set all strategies status to inactive
        $this->set_status(
            array(
                'campaign_id' => $data['campaign_id'],
            ),
            FALSE, TRUE
        );
            
        // now set specific strategy to active
        $this->set_status(
            array(
                'campaign_id' => $data['campaign_id'],
                'strategy_id' => $data['strategy_id'],
            ),
            TRUE
        );
    }
    
    
    /**
     * Set Strategy of Campaign to Inactive status
     * 
     * A specific strategy will be made inactive.
     * 
     * @param array $data array elements: strategy_id, campaign_id
     */
    public function set_inactive($data)
    {
        if (!is_array($data) || !isset($data['strategy_id']) || !isset($data['campaign_id']))
            return FALSE;
            
        // confirm user access to this record
        $ret = $this->authorize_action_update($data);
        if (!$ret)
            return FALSE;
            
        // set campaign and strategy mapping to inactive
        $ret = $this->set_status(
            array(
                'campaign_id' => $data['campaign_id'],
                'strategy_id' => $data['strategy_id'],
            ),
            FALSE
        );
        
        return $ret;
    }
    
    
    
    public function set_status($data, $active = FALSE, $batch = FALSE)
    {
        if (!is_array($data) || !isset($data['campaign_id']))
            return FALSE;
        
        $ret = FALSE;
        
        // we are requested to set all strategies of a different campaign to a certain status
        if ($batch === TRUE)
        {
            // update all campaign strategies to specific status
            $ret = $this->update($data['campaign_id'], array('active' => (bool) $active));
        }
        
        if (isset($data['strategy_id']) && $batch === FALSE)
        {

            $this->db->where(
                array(
                    'campaign_id' => $data['campaign_id'],
                    'strategy_id' => $data['strategy_id'],
                )
            );
            $this->db->set('active', $active);
            $ret = $this->db->update($this->_table);
            
        }
        
        return $ret;
        
    }
    
    




    public function authorize_action_update(&$data)
    {
        $bool = parent::authorize_action($data);
        $bool = $bool && $this->auth_campaign_strategies_update($data);
        
        return $bool;
    }


    /**
     * Auth Campaign Strategies
     * 
     * Verify user owning this brand, code and campaign strategy mapping
     * 
     * @param array $data array elements: strategy_id, campaign_id, operator_id
     * @return bool $ret true or false depending on access for the user
     */
    public function auth_campaign_strategies_update($data)
    {
        /*
         * SQL Example:
         * 
			SELECT op.id, op.brand_id
     		FROM operator op
     		JOIN brand b ON op.brand_id = b.id
     		JOIN code code ON code.brand_id = b.id
     		JOIN campaign_strategies cs ON cs.campaign_id = code.campaign_id
     		WHERE
     			op.id = 1
     		AND
     			cs.campaign_id = 1
     		AND
     			cs.strategy_id = 2
     	 *
     	 *
         */
        $this->db->select('op.id');
        $this->db->select('op.brand_id');
        $this->db->from('operator AS op');
        $this->db->join('brand AS b', 'op.brand_id = b.id');
        $this->db->join('code AS code', 'code.brand_id = code.id');
        $this->db->join('campaign_strategies AS cs', 'cs.campaign_id = code.campaign_id');
        
        if (isset($data['campaign_id']) && isset($data['strategy_id']))
        {
            $this->db->where('cs.campaign_id', $data['campaign_id']);
            $this->db->where('cs.strategy_id', $data['strategy_id']);
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