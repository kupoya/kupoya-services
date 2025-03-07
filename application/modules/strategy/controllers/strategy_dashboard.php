<?php
/**
 * Strategy Dashboard
 * 
 * Methods in this class provide access to functions providing partials like widgets, blocks, etc.
 * As such, they are accessed only view Modules:run() HMVC and *NOT* via a front-controller user accessed
 * URL (which is why these functions are prefixed with underscore (_) ).
 * 
 * This is done mainly for security reasons for now.
 */
class Strategy_Dashboard extends Authenticated_Controller {
    
    protected $_data = array();

    protected $_menu = array();

    protected $_notifications = array();

    
    public function __construct()
    {
        parent::__construct();

        // $this->load->library('form_validation');

        $this->load->language('strategy', 'english');

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
        // $payload['campaign']['id'] = $campaign_id;

         // data includes ['plan'] and ['strategy'] arrays
        $data = $this->strategy_model->load($payload);

        $data['campaign']['id'] = $campaign_id;

        $this->template->build('strategy_dashboard', $data);

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


    public function _get_requests_graph($data = NULL)
    {
        $this->load->view('strategy_graph_overview', $data);
    }

    public function _get_reports_links($data = NULL)
    {
        $this->load->view('reports/strategy_reports_links', $data);
    }

    public function get_requests_graph_data($strategy_id = 0)
    {
        // @TODO probably needs to return *SOME* kind of view error..
        if (!$strategy_id)
            return FALSE;

        $payload['strategy']['id'] = $strategy_id;
        
        $this->load->model('strategy/strategy_reports_model');
        $res = $this->strategy_reports_model->get_strategy_requests($payload);

        $data['result'] = json_encode($res);

        $this->load->view('ajax', $data);
        
    }

    public function get_strategy_requests_agg_by($type = 'day', $strategy_id = 0)
    {
        // @TODO probably needs to return *SOME* kind of view error..
        if (!$strategy_id)
            return FALSE;

        $payload['strategy']['id'] = $strategy_id;
        
        $this->load->model('strategy/strategy_reports_model');
        $res = $this->strategy_reports_model->get_strategy_requests_agg_by($payload, $type);

        $data['result'] = json_encode($res);

        $this->load->view('ajax', $data);
        
    }


}