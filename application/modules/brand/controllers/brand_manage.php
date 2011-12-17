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
    

    public function edit_brand_picture()
    {

        $this->load->model('operator/operator_model');
        $this->load->model('brand/brand_model');

        $this->form_validation->set_rules('brand_id', 'Brand ID', 'required');
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
            if ($this->input->post('brand_id'))
                $brand_id = $this->input->post('brand_id');
            
            if (!isset($brand_id) || !$brand_id)
                redirect($this->redirect_back());

            // load the brand
            $payload['brand']['id'] = $brand_id;
            $brand = (array) $this->brand_model->get($payload);
            if (!$brand) {
                // @TODO notify the user that there has been a problem loading this strategy
                redirect($this->redirect_back());
            }

            // if $brand was loaded then the user has access to it

            $upload_config['upload_path'] = './files/'.$brand_id.'/';
            $upload_config['file_name'] = 'brand_logo.jpg';
            $upload_config['overwrite'] = TRUE;
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
                    redirect('brand/edit_brand');
                }
            }

            if (!$this->upload->do_upload('brand_picture'))
            {
                log_message('debug', '==> 5');
                //$error = array('error' => $this->upload->display_errors());

                //$this->load->view('upload_form', $error);
                redirect('brand/edit_brand');
            }
            else
            {
                log_message('debug', '==> 6');
                //$data = array('upload_data' => $this->upload->data());
                //$this->load->view('upload_success', $data);

                // update the brand record for the new picture uploaded
                $upload_data = $this->upload->data();
                $payload['brand']['id'] = $brand_id;
                $payload['brand']['picture'] = substr($upload_config['upload_path'], 1).$upload_data['file_name'];
                $ret = (array) $this->brand_model->save_brand($payload);
                if (!$ret)
                {
                    // show error, saving image failed
                    redirect('brand/edit_brand');                    
                }

                redirect('brand/edit_brand');
            }

        }
        
    }
    
    public function edit_brand($brand_id = NULL)
    {
        $this->load->model('operator/operator_model');
        $this->load->model('brand/brand_model');

        $this->form_validation->set_rules('brand[id]', 'Brand ID', 'required');
        $this->form_validation->set_rules('brand[name]', 'Brand Name', 'required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('brand[description]', 'Brand Description', 'max_length[512]|xss_clean');
        $this->form_validation->set_rules('brand[picture]', 'Brand Picture', 'max_length[256]|xss_clean');

        if ($this->input->post('brand_id'))
            $brand_id = $this->input->post('brand_id');

        // if operator id was not provided in uri attempt to guess from session
        if (!$brand_id)
        {
            $operator_id = $this->operator_model->get_operator_id();
            $operator = (array) $this->operator_model->get($operator_id);
            if (!$operator || !isset($operator['brand_id']))
            {
                // something's wrong! unable to load operator or operator's brand_id
                redirect($this->redirect_back());
            }

            $brand_id = $operator['brand_id'];
        }

        if (!$brand_id)
            redirect($this->redirect_back());

        $payload['brand']['id'] = $brand_id;
        $brand = (array) $this->brand_model->get($payload);
        if (!$brand) {
            // @TODO notify the user that there has been a problem loading this strategy
            redirect($this->redirect_back());
        }

        $data['brand'] = $brand;

        if ($this->form_validation->run() === FALSE)
        {
            //error
            log_message('debug', '==> 2');

            
            $this->template->build('brand_edit', $data);
            // redirect($this->redirect_back());
        }
        else
        {
            log_message('debug', '==> 3');

            // save strategy info
            //$this->load->model('advertisement/advertisement_model');
            //$data = $this->advertisement_model->save_advertisement($data);

            //$this->load->model('ion_auth_model');

            //$operator = $this->session->userdata('operator');

            //$change = $this->ion_auth_model->change_password($operator['id'], $this->input->post('old_password'), $this->input->post('new_password'));
            //$change = $this->ion_auth_model->change_password($identity, $this->input->post('old_password'), $this->input->post('new_password'));

            $payload['operator_id'] = $operator_id;
            $tmp_brand = $this->input->post('brand');
            $brand = array(
                'id' => $brand_id,
                'name' => isset($tmp_brand['name']) ? $tmp_brand['name'] : NULL,
                'description' => isset($tmp_brand['description']) ? $tmp_brand['description'] : NULL,
                'picture' => isset($tmp_brand['picture']) ? $tmp_brand['picture'] : NULL,
            );
            $payload['brand'] = $brand;
            $change = $this->brand_model->save_brand($payload);

            if ($change)
            {
                //if the password was successfully changed
                //$this->session->set_flashdata('message', $this->ion_auth->messages());
                // logout the user afterwards?
                log_message('debug', '==> 4');
                //$this->logout();
            }
            else
            {
                // notify the user something bad happened
                //$this->session->set_flashdata('message', $this->ion_auth->errors());
                //redirect('auth/change_password', 'refresh');
            }

            $this->template->build('brand_edit', $data);
            //redirect($this->redirect_back());
        }
    }
     
    
}