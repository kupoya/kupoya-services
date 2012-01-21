<?php
class Advertisement_Manage extends Authenticated_Controller {
    
    protected $_data = array();
    
    
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->language('strategy/strategy', 'english');
        $this->load->language('advertisement', 'english');

        $this->load->helper('form');
        $this->load->helper('url');

        $this->_data['menu']['context'] = 'campaigns';

    }
    
    
    public function index()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select('id, serial, status, user_id, purchased_time, strategy_id')
            ->from('coupon');

        $this->datatables->edit_column('id', '<a href="profiles/edit/$1">$2</a>', 'id, username');


        $data['result'] = $this->datatables->generate();
        //$data = null;

        $this->load->view('ajax', $data);

        //$this->_data['data'] = $ret;
        //$this->template->build('advertisement_list', $this->_data);
    }


    public function statistics($strategy_id = 0, $campaign_id = 0)
    {
        $data['strategy']['id'] = $strategy_id;
        $data['campaign']['id'] = $campaign_id;

        $this->template->build('advertisement_statistics', $data);
    }
    


    public function edit_strategy_picture()
    {

        $this->load->model('operator/operator_model');
        $this->load->model('strategy/strategy_model');

        $this->form_validation->set_rules('strategy_id', 'Strategy ID', 'required');
        //$this->form_validation->set_rules('campaign_id', 'Campaign ID', 'required');
        //$this->form_validation->set_rules('brand_picture', 'Brand Picture', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            //error
            log_message('debug', '==> 2');

            
            //$this->template->build('brand_edit', $data);
            redirect($this->redirect_back());
        }
        else
        {
            if ($this->input->post('strategy_id'))
                $strategy_id = $this->input->post('strategy_id');

            if ($this->input->post('campaign_id'))
                $campaign_id = $this->input->post('campaign_id');

            // load the brand and code info
            $payload['strategy']['id'] = $strategy_id;
            $payload['campaign']['id'] = $campaign_id;
            $info = (array) $this->strategy_model->get_parents($payload);
            if (!isset($info['brand']['id']) || empty($info['brand']['id'])) {
                // @TODO notify the user that there has been a problem loading this strategy
                redirect($this->redirect_back());
            }

            $upload_config['upload_path'] = './files/'.$info['brand']['id'].'/';
            //$upload_config['file_name'] = 'brand_logo.jpg';
            //$upload_config['overwrite'] = TRUE;
            $upload_config['allowed_types'] = 'gif|jpg|png';
            $upload_config['remove_spaces'] = TRUE;
            $upload_config['max_size'] = '250';
            $upload_config['max_width']  = '1024';
            $upload_config['max_height']  = '768';

            $this->load->library('upload', $upload_config);

            // check directory exists
            if (!is_dir($upload_config['upload_path']))
            {
                // attempt to create path for the brand
                if (!mkdir($upload_config['upload_path']))
                {
                    // error, could not create directory for some reason... 
                    //redirect('advertisement/view');
                    redirect($this->redirect_back());
                }
            }

            if (!$this->upload->do_upload('strategy_picture'))
            {
                log_message('debug', '==> 5');
                //$error = array('error' => $this->upload->display_errors());

                //$this->load->view('upload_form', $error);
                //redirect('brand/edit_brand');
                redirect($this->redirect_back());
            }
            else
            {
                log_message('debug', '==> 6');
                //$data = array('upload_data' => $this->upload->data());
                //$this->load->view('upload_success', $data);

                // update the brand record for the new picture uploaded
                $upload_data = $this->upload->data();
                $payload = array();
                $payload['strategy']['id'] = $strategy_id;
                $payload['strategy']['picture'] = substr($upload_config['upload_path'], 1).$upload_data['file_name'];
                $ret = (array) $this->strategy_model->save_strategy($payload);
                if (!$ret)
                {
                    // show error, saving image failed
                    redirect($this->redirect_back());
                }

                redirect($this->redirect_back());
            }

        }
        
    }


    public function save()
    {
        $this->menu_page = 'manage';

        // strategy_id is really required here
        $this->form_validation->set_rules('strategy[id]', 'Strategy', 'required|integer');

        $this->form_validation->set_rules('strategy[name]', 'Strategy Name', 'xss_clean|max_length[100]');
        $this->form_validation->set_rules('strategy[description]', 'Strategy Description', 'xss_clean|max_length[512]');
        $this->form_validation->set_rules('strategy[picture]', 'Strategy Picture', 'xss_clean|max_length[160]');
        $this->form_validation->set_rules('strategy[website]', 'Strategy Website', 'xss_clean|max_length[100]');
        $this->form_validation->set_rules('advertisement[redirect_url]', 'Advertisement Redirect URL', 'xss_clean|max_length[100]');
        $this->form_validation->set_rules('advertisement_blocks[block_1]', 'Advertisement Text', '');

        $data['strategy'] = $this->input->post('strategy');
        $data['advertisement'] = $this->input->post('advertisement');
        $data['advertisement_blocks'] = $this->input->post('advertisement_blocks');
        $data['advertisement']['strategy_id'] = $data['strategy']['id'];
        
        if ($this->form_validation->run() === FALSE)
        {
            //error
            log_message('debug', '==> 2');

            $this->template->build('advertisement_edit', $data);
        }
        else
        {
            log_message('debug', '==> 3');

            // save strategy info
            $this->load->model('advertisement/advertisement_model');
            $data = $this->advertisement_model->save_advertisement($data);

            $data['menu']['context'] = $this->menu_context;
            $data['menu']['page'] = $this->menu_page;

            $this->template->build('advertisement_edit', $data);
        }

    }


    public function edit($strategy_id = 0, $campaign_id = 0)
    {
        if (!$strategy_id || !is_numeric($strategy_id))
            redirect($this->redirect_back());

        if (!$campaign_id || !is_numeric($campaign_id))
            redirect($this->redirect_back());

        $this->_data['menu']['page'] = 'campaigns';

// $this->load->model('plan/plan_model');
// $ret = $this->plan_model->check_plan_is_free(1);

        // load strategy information
        $this->load->model('advertisement/advertisement_model');
        $data = $this->advertisement_model->advertisement_load($strategy_id);

        if (!$data) {
            // @TODO notify the user that there has been a problem loading this strategy
            redirect($this->redirect_back());
        }

        //$data['strategy'] = $settings['strategy'];

        $this->load->model('plan/plan_model');
        $data['plans'] = $this->plan_model->get_dropdown();
        $data['campaign']['id'] = $campaign_id;

        $this->_data = array_merge($this->_data, $data);

        $this->template->build('advertisement_edit', $this->_data);
    }


    public function view($strategy_id = 0, $campaign_id = 0)
    {
        if (!$strategy_id || !is_numeric($strategy_id))
            redirect($this->redirect_back());

        if (!$campaign_id || !is_numeric($campaign_id))
            redirect($this->redirect_back());

        $this->_data['menu']['page'] = 'campaigns';

// $this->load->model('plan/plan_model');
// $ret = $this->plan_model->check_plan_is_free(1);

        // load strategy information
        $this->load->model('advertisement/advertisement_model');
        $data = $this->advertisement_model->advertisement_load($strategy_id);

        if (!$data) {
            // @TODO notify the user that there has been a problem loading this strategy
            redirect($this->redirect_back());
        }

        //$data['strategy'] = $settings['strategy'];

        $this->load->model('plan/plan_model');
        $data['plans'] = $this->plan_model->get_dropdown();
        $data['campaign']['id'] = $campaign_id;

        $this->_data = array_merge($this->_data, $data);

        $this->template->build('advertisement_view', $this->_data);
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