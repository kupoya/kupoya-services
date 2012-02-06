<?php
class Strategy_Reports_Demographics extends Authenticated_Controller {
    
    protected $_data = array();

    protected $_menu = array();

    protected $_notifications = array();

    
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->language('strategy/strategy', 'english');

        $this->load->helper('form');
        $this->load->helper('url');

        $this->_menu['context'] = 'campaigns';
    }


    public function index($brand_id = 0)
    {
        $this->_menu['page'] = 'my_campaigns';
        $this->template->set('menu', $this->_menu);

        $data['data'] = 'sss';
        $this->template->build('strategy_list', $data);
    }


    public function get_by_gender($strategy_id = 0)
    {
        if (!$strategy_id)
            return FALSE;
        
        $payload['strategy']['id'] = $strategy_id;

        $this->load->model('strategy/strategy_reports_demographics_model');

        $data['result'] = $this->strategy_reports_demographics_model->get_by_gender($payload);

        $this->load->view('ajax', $data);
    }


    public function get_by_age($strategy_id = 0)
    {
        if (!$strategy_id)
            return FALSE;
        
        $payload['strategy']['id'] = $strategy_id;

        $this->load->model('strategy/strategy_reports_demographics_model');

        $data['result'] = $this->strategy_reports_demographics_model->get_by_age($payload);

        $this->load->view('ajax', $data);
    }
     
     
    
}