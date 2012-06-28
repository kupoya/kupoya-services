<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Strategy_Manage extends Authenticated_Controller {
    
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


    /**
     * Redirects to the specific strategy type extended view
     * 
     * @param int $strategy_id
     * @param int $campaign_id
     */
    public function view($strategy_id = 0, $campaign_id = 0)
    {
        
        $this->load->model('strategy/strategy_model');

        $payload['strategy']['id'] = $strategy_id;
        $payload['campaign']['id'] = $campaign_id;

        // data includes ['plan'] and ['strategy'] arrays
        $data = $this->strategy_model->load($payload);

        // we need to know which stratey type is this so we can fwd to the correct module
        if (isset($data['strategy']['strategy_type_name']))
        {
            $strategy_type = $data['strategy']['strategy_type_name'];
            // we're redirecting to url like: advertisement/view/2/1
            redirect($strategy_type.'/manage/view/'.$strategy_id.'/'.$campaign_id);
        }

    }


    /**
     * Redirects to the specific strategy type extended edit
     * 
     * @param int $strategy_id
     * @param int $campaign_id
     */
    public function edit($strategy_id = 0, $campaign_id = 0)
    {
        // @TODO incomplete
        exit;
        
        $this->load->model('strategy/strategy_model');

        $payload['strategy']['id'] = $strategy_id;
        $payload['campaign']['id'] = $campaign_id;

        // data includes ['plan'] and ['strategy'] arrays
        $data = $this->strategy_model->load($payload);

        // we need to know which stratey type is this so we can fwd to the correct module
        if (isset($data['strategy']['strategy_type_name']))
        {
            $strategy_type = $data['strategy']['strategy_type_name'];
            // we're redirecting to url like: advertisement/view/2/1
            redirect($strategy_type.'/manage/edit/'.$strategy_id.'/'.$campaign_id);
        }

    }
    

    public function get_all_strategies($brand_id = 0)
    {
        if (!$brand_id)
            $brand_id = 0;
        
        $payload['brand']['id'] = $brand_id;

        $this->load->model('strategy/strategy_model');

        $data['result'] = $this->strategy_model->get_strategies($payload);

        $this->load->view('ajax', $data);
    }
    

    public function index($brand_id = 0)
    {
        $this->_menu['page'] = 'my_campaigns';
        $this->template->set('menu', $this->_menu);

        // attempt to get brand_id from session if not provided
        if (!$brand_id)
        {
            $operator = $this->session->userdata('operator');
            $brand_id = $operator['brand_id'];
        }

        $data['brand']['id'] = $brand_id;
        $this->template->build('strategy_list', $data);
    }
    
    

    /**
     * Redirects to the specific strategy create page
     * 
     * @param int $strategy_id
     * @param int $campaign_id
     */
    public function create()
    {
        $data = array();

        $this->_menu['page'] = 'new_campaign';
        $this->template->set('menu', $this->_menu);

        $this->template->build('strategy_create', $data);
    }



    /**
     * Legacy method, unused
     */
    private function _create()
    {
        $this->_menu['page'] = 'new_campaign';
        $this->template->set('menu', $this->_menu);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('strategy_name', 'Strategy Name', 'required|max_length[45]');
                
        if ($this->form_validation->run() == FALSE)
        {
            //error
            $data['data'] = 'error';
            $this->form_validation->set_message('strategy', 'Error Message');
            $this->template->build('strategy_create', $data);
        }
        else 
        {
            //success
            $data['data'] = 'success';
            $this->form_validation->set_message('success', 'Success Message');
            
            //$this->form_validation->set_rules('strategy_name', 'Strategy Name', 'trim|xss_clean');
            $this->load->model('strategy/strategy_model');
            
            $data['id'] = '4';
            $data['name'] = 'rtyrty';
            $data['picture'] = 'rtyrty.jpg';
            $data['description'] = 'vnvn';
            $data['strategy_id'] = '1';

            $ret = $this->strategy_model->save_strategy($data);
            $data['data'] = $ret;
            
            $this->template->build('strategy_create', $data);
        }
        
    }
     
    
}