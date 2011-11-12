<?php
class Advertisement_Manage extends Authenticated_Controller {
    
    
    
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    
    public function index()
    {
        
        //$this->load->model('advertisement/advertisement_model');
        
        $data['data'] = $ret;
        $this->template->build('advertisement_list', $data);
    }
    



    public function save()
    {

        //$data = $this->input->post('strategy');

        // strategy_id is really required here
        $this->form_validation->set_rules('strategy[id]', 'Strategy', 'required|integer');

        $this->form_validation->set_rules('strategy[name]', 'Strategy Name', 'xss_clean|max_length[100]');
        $this->form_validation->set_rules('strategy[description]', 'Strategy Description', 'xss_clean|max_length[512]');
        $this->form_validation->set_rules('strategy[picture]', 'Strategy Picture', 'xss_clean|max_length[160]');
        $this->form_validation->set_rules('strategy[website]', 'Strategy Website', 'xss_clean|max_length[100]');
        $this->form_validation->set_rules('advertisement[redirect_url]', 'Advertisement Redirect URL', 'xss_clean|max_length[100]');

        if ($this->form_validation->run() === FALSE)
        {
            //error
            log_message('debug', '==> 2');
            $this->template->build('advertisement_edit', $data);
        }
        else
        {
            log_message('debug', '==> 3');

            $data['strategy'] = $this->input->post('strategy');
            $data['advertisement'] = $this->input->post('advertisement');
            $data['advertisement']['strategy_id'] = $data['strategy']['id'];

            // save strategy info
            $this->load->model('advertisement/advertisement_model');
            $data = $this->advertisement_model->save_advertisement($data);

            $this->template->build('advertisement_edit', $data);
        }

    }


    public function view($strategy_id = 0)
    {
        if (!$strategy_id || !is_numeric($strategy_id))
            redirect($this->redirect_back());

        // load strategy information
        $this->load->model('advertisement/advertisement_model');
        $data = $this->advertisement_model->advertisement_load($strategy_id);

        if (!$data) {
            // @TODO notify the user that there has been a problem loading this strategy
            redirect($this->redirect_back());
        }

        //$data['strategy'] = $settings['strategy'];

        $this->template->build('advertisement_edit', $data);
    }


    public function create()
    {        
        $this->form_validation->set_rules('strategy[name]', 'Strategy Name', 'required|xss_clean|max_length[100]');
        $this->form_validation->set_rules('strategy[description]', 'Strategy Description', 'required|xss_clean|max_length[512]');
        $this->form_validation->set_rules('strategy[picture]', 'Strategy Picture', 'required|xss_clean|max_length[160]');
        $this->form_validation->set_rules('strategy[website]', 'Strategy Website', 'required|xss_clean|max_length[100]');

        $this->form_validation->set_rules('plan[id]', 'Plan', 'required|integer');

        //$this->form_validation->set_rules('order[promotion_id]', 'Promotion', 'integer');

        $this->form_validation->set_rules('advertisement[redirect_url]', 'Advertisement Redirect URL', 'xss_clean|max_length[128]');

        //$this->form_validation->set_rules('strategy[expirate_date]', 'Strategy Expiration Date', 'required|max_length[45]');
        //$this->form_validation->set_rules('strategy[language]', 'Strategy Language', 'required|max_length[45]');

        $this->load->model('plan/plan_model');
        $data['plans'] = $this->plan_model->get_dropdown();
        
        log_message('debug', '==> 1');
        
        if ($this->form_validation->run() === FALSE)
        {
            //error
            log_message('debug', '==> 2');

            $data['data'] = $this->input->post('strategy[name]');

            $this->template->build('advertisement_create', $data);
        }
        else 
        {
            //success
            log_message('debug', '==> 3');
            
            // set plan settings
            $data['plan'] = $this->input->post('plan', TRUE);

            // set order promotion
            $order = $this->input->post('order', TRUE);
            if (isset($order['promotion_id'])) {
                $data['order']['promotion_id'] = $order['promotion_id'];
            }

            // set advertisement settings
            $data['advertisement'] = $this->input->post('advertisement', TRUE);

            // set strategy settings
            $data['strategy'] = $this->input->post('strategy', TRUE);
            $data['strategy']['plan_id'] = $data['plan']['id'];
            // be sure to unset the strategy id so that it doesn't get updated by any smart-ass user
            unset($data['strategy']['id']);

            $data['campaign']['name'] = mb_substr($data['strategy']['name'], 0, 44);

            $this->load->model('advertisement/advertisement_model');
            $ret = $this->advertisement_model->register_advertisement($data);

            $data['data'] = $ret;
            $data['error'] = $this->session->flashdata('error');
            
            $this->template->build('advertisement_create', $data);
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