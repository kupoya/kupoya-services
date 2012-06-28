<?php
/**
 * Microdeal Reports
 * 
 * Methods in this class provide access to functions providing partials like widgets, blocks, etc.
 * As such, they are accessed only view Modules:run() HMVC and *NOT* via a front-controller user accessed
 * URL (which is why these functions are prefixed with underscore (_) ).
 * 
 * This is done mainly for security reasons for now.
 */
class Microdeal_Reports_Overview extends Authenticated_Controller {
    
    protected $_data = array();

    protected $_menu = array();

    protected $_notifications = array();

    
    public function __construct()
    {
        parent::__construct();

        // $this->load->library('form_validation');

        //$this->load->language('strategy', 'english');

        $this->load->helper('form');
        $this->load->helper('url');

        // $this->_menu['context'] = 'campaigns';
    }


    /**
     * main page/entry point strategy reports/statistics info
     * 
     * @param int $strategy_id
     * @param int $campaign_id
     */
    public function index($strategy_id = 0, $campaign_id = 0)
    {
        $this->load->model('strategy/strategy_model');

        $payload['strategy']['id'] = $strategy_id;
        $payload['campaign']['id'] = $campaign_id;

        // data includes ['plan'] and ['strategy'] arrays
        //$data = $this->strategy_model->load($payload);

        $this->template->build('reports/strategy_reports_overview', $payload);

    }
    

    public function _get_strategy_overview($data = NULL)
    {
        // @TODO probably needs to return *SOME* kind of view error..
        if (!$data)
            return FALSE;

        $this->load->model('code/code_model');
        $code = $this->code_model->get_code($data);

        $data['code'] = $code;

        $this->load->view('strategy_overview', $data);
    }


    public function _get_requests_graph_extended($data = NULL)
    {
         // @TODO probably needs to return *SOME* kind of view error..
        if (!$data)
            return FALSE;

        $this->load->view('reports/strategy_reports_overview_extended', $data);       
    }


    public function _get_reports_links($data = NULL)
    {
        $this->load->view('reports/strategy_reports_links', $data);
    }


    public function _widget_requests_graph($data = NULL)
    {
        $this->load->view('widgets/microdeal_request_graph', $data);
    }


    public function _widget_redemptions_graph($data = NULL)
    {
        $this->load->view('widgets/microdeal_redemptions_graph', $data);
    }


    public function get_microdeal_redem_requests($strategy_id = 0)
    {
        // @TODO probably needs to return *SOME* kind of view error..
        if (!$strategy_id)
            return FALSE;

        $payload['strategy']['id'] = $strategy_id;
        
        $this->load->model('microdeal/microdeal_reports_model');
        $res = $this->microdeal_reports_model->get_strategy_requests($payload);

        $data['result'] = json_encode($res);

        $this->load->view('ajax', $data);
        
    }


    public function get_microdeal_redem_expose($strategy_id = 0)
    {
        // @TODO probably needs to return *SOME* kind of view error..
        if (!$strategy_id)
            return FALSE;

        $payload['strategy']['id'] = $strategy_id;
        
        $this->load->model('microdeal/microdeal_reports_model');
        $res = $this->microdeal_reports_model->get_strategy_exposure($payload);

        $data['result'] = json_encode($res);

        $this->load->view('ajax', $data);
        
    }

    // public function get_strategy_requests_agg_by($type = 'day', $strategy_id = 0)
    // {
    //     // @TODO probably needs to return *SOME* kind of view error..
    //     if (!$strategy_id)
    //         return FALSE;

    //     $payload['strategy']['id'] = $strategy_id;
        
    //     $this->load->model('strategy/strategy_reports_model');
    //     $res = $this->strategy_reports_model->get_strategy_requests_agg_by($payload, $type);

    //     $data['result'] = json_encode($res);

    //     $this->load->view('ajax', $data);
        
    // }



    public function get_customer_friends_count_profile($strategy_id = 0)
    {
        // @TODO probably needs to return *SOME* kind of view error..
        if (!$strategy_id)
            return FALSE;

        $payload['strategy']['id'] = $strategy_id;
        
        $this->load->model('microdeal/microdeal_reports_model');
        $res = $this->microdeal_reports_model->get_customer_friends_count_profile($payload);

        $data['result'] = json_encode($res);

        $this->load->view('ajax', $data);

    }


    public function get_redemptions_foot_traffic($strategy_id = 0)
    {
        // @TODO probably needs to return *SOME* kind of view error..
        if (!$strategy_id)
            return FALSE;

        $payload['strategy']['id'] = $strategy_id;
        
        $this->load->model('microdeal/microdeal_reports_model');
        $res = $this->microdeal_reports_model->get_redemptions_foot_traffic($payload);

        $data['result'] = json_encode($res);

        $this->load->view('ajax', $data);

    }

    public function get_customer_redemption_profile($strategy_id = 0)
    {

        // @TODO probably needs to return *SOME* kind of view error..
        if (!$strategy_id)
            return FALSE;

        $payload['strategy']['id'] = $strategy_id;
        
        $this->load->model('microdeal/microdeal_reports_model');
        $res = $this->microdeal_reports_model->get_customer_redemption_profile($payload);

        $data['result'] = json_encode($res);

        $this->load->view('ajax', $data);

    }


    public function get_redemptions_per_returning_customer($strategy_id = 0)
    {

        // @TODO probably needs to return *SOME* kind of view error..
        if (!$strategy_id)
            return FALSE;

        $payload['strategy']['id'] = $strategy_id;
        
        $this->load->model('microdeal/microdeal_reports_model');
        $res = $this->microdeal_reports_model->get_redemptions_per_returning_customer($payload);

        $data['result'] = json_encode($res);

        $this->load->view('ajax', $data);
        
/*
-- GET count of non-frequency>1 for coupon retrievals of 
-- this is the sum of all the users that redeemed only one coupon (unique redemption)
SELECT
    COUNT(*) as total_coupons,
    (
        SELECT COUNT(*)
        FROM
        (
            SELECT
            count(id) as user_freq
            FROM `coupon`
            WHERE 
            strategy_id = 1
            GROUP BY user_id
            HAVING user_freq > 1
            -- ORDER BY user_freq DESC
        ) t
    ) as multiple_redemptions
FROM coupon
WHERE
strategy_id = 1



-- GET TOP RETURNING CUSTOMERS by frequency of retreivals
-- 
    SELECT
    user_id, count(id) as user_freq
    FROM `coupon`
    WHERE 
    strategy_id = 1
    GROUP BY user_id
    ORDER BY user_freq DESC


-- GET count of non frequent retreivals
-- 
    SELECT COUNT(t.user_freq) cnt
    FROM (
        SELECT
        user_id, count(id) as user_freq
        FROM `coupon`
        WHERE 
        strategy_id = 1
        GROUP BY user_id
        ORDER BY user_freq DESC
    ) t
    WHERE t.user_freq = 1
    
    



*/
    }


}