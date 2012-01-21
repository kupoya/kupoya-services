<?php
class Strategy_Reports_Mobile extends Authenticated_Controller {
    
    protected $_data = array();

    protected $_menu = array();

    protected $_notifications = array();

    
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->language('strategy', 'english');

        $this->load->helper('form');
        $this->load->helper('url');

        $this->_menu['context'] = 'campaigns';
    }
    

    public function index($strategy_id = 0, $campaign_id = 0)
    {
        $this->_menu['page'] = 'my_campaigns';
        $this->template->set('menu', $this->_menu);

        $data['strategy']['id'] = $strategy_id;
        $data['campaign']['id'] = $campaign_id;

        $ret = $this->platform_get_all($strategy_id);
        $data['platform_list'] = $ret['result'];

        //$this->load->view('reports/strategy_reports_mobile', $data);
        $this->template->build('reports/strategy_reports_mobile', $data);
        
    }


    public function _platform_view($data = 0)
    {

        $this->load->view('reports/strategy_reports_mobile_platform', $data);

        //$this->template->set_partial('post_jquery', 'js/strategy_reports_demographics_platform');
        //$this->template->build('reports/strategy_reports_platform', $data);
    }


    public function _browser_view($data = 0)
    {

        $this->load->view('reports/strategy_reports_mobile_browser', $data);

        //$this->template->set_partial('post_jquery', 'js/strategy_reports_demographics_platform');
        //$this->template->build('reports/strategy_reports_platform', $data);
    }


    public function platform_get_all($strategy_id = 0)
    {
        // if (!$strategy_id)
        //     $strategy_id = 1;
        
        $payload['strategy']['id'] = $strategy_id;

        //$this->load->model('strategy/strategy_model');
        $this->load->model('strategy/strategy_reports_mobile_model');

        $data['result'] = $this->strategy_reports_mobile_model->get_platform_list($payload);

        $this->load->view('ajax', $data);
    }


    public function browser_get_all($strategy_id = 0)
    {
        // if (!$strategy_id)
        //     $strategy_id = 1;
        
        $payload['strategy']['id'] = $strategy_id;

        //$this->load->model('strategy/strategy_model');
        $this->load->model('strategy/strategy_reports_mobile_model');

        $data['result'] = $this->strategy_reports_mobile_model->get_browser_list($payload);

        $this->load->view('ajax', $data);
    }
     
     
    
}