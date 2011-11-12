<?php
class Brand_Manage extends Authenticated_Controller {
    
    
    
    public function __construct()
    {
        parent::__construct();
    }
    
    
    public function index()
    {
        
        //$this->load->model('brand/brand_model');
        
        $data['data'] = $ret;
        $this->template->build('brand_list', $data);
    }
    
    
    public function create()
    {
        
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'required|max_length[45]');
        
        log_message('debug', '==> 1');
        
        if ($this->form_validation->run() == FALSE)
        {
            //error
            log_message('debug', '==> 2');
            $data['data'] = 'error';
            $this->form_validation->set_message('brand_name', 'Error Message');
            $this->template->build('brand_create', $data);
        }
        else 
        {
            log_message('debug', '==> 3');
            //success
            $data['data'] = 'success';
            $this->form_validation->set_message('success', 'Success Message');
            
            //$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|xss_clean');
            $this->load->model('brand/brand_model');
            
            $data['id'] = '4';
            $data['name'] = 'rtyrty';
            $data['picture'] = 'rtyrty.jpg';
            $data['description'] = 'vnvn';
            $data['operator_id'] = '1';
            //$data['blocked'] = true;
//            $data['service_id'] = '1';
//            $data['customer_id'] = '1';
//            $data['contact_id'] = '1';
            
            $ret = $this->brand_model->save_brand($data);
            $data['data'] = $ret;
            
            $this->template->build('brand_create', $data);
        }
        
        log_message('debug', '==> 4');
        
        /*
        log_message('debug', '==> in create()');
        
        $data['name'] = 'bugaga';
        $data['campaign_mode'] = '1';
        $data['brand_id'] = '2';
        
        $this->load->model('campaign/campaign_model');
        $ret = $this->campaign_model->create_campaign($data, true);
        */
        
        //$this->load->model('campaign/campaign_strategies_model');
        //$ret = $this->campaign_strategies_model->get_by(array('campaign_id' => '12', 'strategy_id' => '12'));

        /*
        if ($this->input->post('campaign_name'))
        {
            log_message('debug', '==> got campaign_name');
            $data['data'] = array('name' => $this->input->post('campaign_name'));
        }
        else
        {
            redirect('campaign/campaign_manage/index');
        }
          */

        //$data['data'] = $ret;
        
        //$this->template->build('campaign_create', $data);
        
    }
     
    
}