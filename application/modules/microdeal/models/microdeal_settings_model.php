<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Microdeal_Settings_Model extends Base_Model
{

	/**
     * @var string		model table name
     */
	protected $_table = 'coupon_settings';

	/**
	 * The primary key, by default set to
	 * `id`, for use in some functions.
	 *
	 * @var string
	 */
	protected $primary_key = 'strategy_id';

	protected $strategy_type = 'microdeal';


	/**
	 * Constructor
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function get($strategy_id = NULL)
	{
		
		if (!isset($strategy_id))
			return FALSE;

		// verify access to this record
		$data['strategy']['id'] = $strategy_id;
		if ($this->authorize_action($data))
		{
			return parent::get($strategy_id);
		}

		return FALSE;
	}



	public function authorize_action(&$data)
	{
	    $bool = parent::authorize_action($data);
	    $bool = $bool && $this->auth_strategy($data);
	    
	    return $bool;
	}


	public function auth_strategy(&$data)
	{
	    /*
         * SQL Example:
         * 
			SELECT  `coupon_settings`.`strategy_id` 
			FROM (`coupon_settings` AS coupon_settings)
			JOIN  `strategy` AS strategy ON  `strategy`.`id` =  `ad`.`strategy_id` 
			JOIN  `campaign_strategies` AS cs ON  `cs`.`strategy_id` =  `strategy`.`id` 
			JOIN  `code` AS code ON  `code`.`campaign_id` =  `cs`.`campaign_id` 
			JOIN  `brand` AS  `b` ON  `b`.`id` =  `code`.`brand_id` 
			JOIN  `operator` AS  `op` ON  `op`.`brand_id` =  `b`.`id` 
			WHERE  `ad`.`strategy_id` =  '18'
			AND  `op`.`id` =  '1'
     	 *
     	 *
         */

        $this->db->select('coupon_settings.strategy_id');
		$this->db->from('coupon_settings AS coupon_settings');
		$this->db->join('strategy AS strategy', 'strategy.id = coupon_settings.strategy_id');
		$this->db->join('campaign_strategies AS cs', 'cs.strategy_id = strategy.id');
		$this->db->join('code AS code', 'code.campaign_id = cs.campaign_id');
        $this->db->join('brand AS b', 'b.id = code.brand_id');
        $this->db->join('operator AS op', 'op.brand_id = b.id');
        
        if (isset($data['strategy']['id']))
        {
            $this->db->where('coupon_settings.strategy_id', $data['strategy']['id']);
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