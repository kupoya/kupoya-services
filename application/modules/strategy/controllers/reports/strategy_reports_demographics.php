<?php
class Strategy_Reports_Demographics extends Authenticated_Controller {
    
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
    

    public function get_all_strategies($brand_id = 0)
    {
        if (!$brand_id)
            $brand_id = 1;
        
        $payload['brand']['id'] = $brand_id;

        $this->load->model('strategy/strategy_model');

        $data['result'] = $this->strategy_model->get_strategies($payload);

        $this->load->view('ajax', $data);
    }
    

    public function index($brand_id = 0)
    {
        $this->_menu['page'] = 'my_campaigns';
        $this->template->set('menu', $this->_menu);

        $data['data'] = 'sss';
        $this->template->build('strategy_list', $data);
    }


    public function platform($strategy_id = 0)
    {
        $this->_menu['page'] = 'my_campaigns';
        $this->template->set('menu', $this->_menu);

        $data['data'] = 'sss';

        $this->template->set_partial('post_jquery', 'js/strategy_reports_demographics_platform');
        $this->template->build('reports/strategy_reports_platform', $data);
    }


    public function platform_get_all($strategy_id = 0)
    {
        // if (!$brand_id)
        //     $brand_id = 1;
        
        $payload['strategy']['id'] = '13';

        //$this->load->model('strategy/strategy_model');
        $this->load->model('strategy/strategy_reports_demographics_model');

        $data['result'] = $this->strategy_reports_demographics_model->get_platform_list($payload);

        $this->load->view('ajax', $data);
    }
     
     
    
}