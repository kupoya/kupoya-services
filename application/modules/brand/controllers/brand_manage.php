<?php
class Brand_Manage extends Authenticated_Controller {
    
    protected $_data = array();

    protected $_menu = array();

    protected $_notifications = array();
    
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->language('brand/brand', 'english');
        $this->load->language('operator/operator', 'english');

        $this->_menu['context'] = 'account';
    }
    
    
    public function index()
    {

        // @TODO this is a place holder for the main /brand URI but it's not functional yet
        // so forwarding to edit_brand
        redirect('brand/edit_brand');
        
        // $this->load->model('brand/brand_model');
        
        // $data['data'] = $ret;
        // $this->template->build('brand_list', $data);
    }
    

    public function edit_brand_picture()
    {

        $this->load->model('operator/operator_model');
        $this->load->model('brand/brand_model');

        $this->form_validation->set_rules('brand_id', 'Brand ID', 'required');
        //$this->form_validation->set_rules('brand_picture', 'Brand Picture', 'required');

        $success = FALSE;

        if ($this->form_validation->run() === FALSE)
        {
            // missing brand_id
            
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
                    $this->_notifications['error'][] = $this->lang->line("We apologize but we are unable to process brand logos at the moment");
                    
                    // error, could not create directory for some reason... 
                    $success = FALSE;
                    //redirect('brand/edit_brand#tab_');
                }
            }

            if (!$this->upload->do_upload('brand_picture'))
            {
                $this->_notifications['error'][] = $this->upload->display_errors();

                //redirect('brand/edit_brand#tab_logo');
                $success = FALSE;
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
                    //redirect('brand/edit_brand#tab_logo');
                    $success = FALSE;
                    $this->_notifications['error'][] = $this->lang->line('Could not process uploaded image');
                }

                //redirect('brand/edit_brand#tab_logo');
                $success = TRUE;
                $this->_notifications['success'][] = $this->lang->line('Settings saved');
            }

        }

        
        //$this->template->set('notifications', $this->_notifications);
        // we anyway need to do a re-load due to file upload so we don't rebuild
        
        $this->session->set_flashdata('notifications', $this->_notifications);
        redirect('brand/edit_brand#tab_logo', 'refresh');
        
    }
    
    public function edit_brand($brand_id = NULL)
    {
        $this->_menu['page'] = 'my_brands';
        $this->template->set('menu', $this->_menu);

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
            // @TODO notify the user that there has been a problem loading this brand
            $this->_notifications['error'][] = $this->lang->line('Cant load brand information');
            $this->session->set_flashdata('notifications', $this->_notifications);

            redirect($this->redirect_back());
        }

        $data['brand'] = $brand;

        if ($this->form_validation->run() === FALSE)
        {
            // post was probably not submitted or validation failed
            
            $this->_data = array_merge($this->_data, $data);
            $this->template->build('brand_edit', $this->_data);
        }
        else
        {
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
                $this->_notifications['success'][] = $this->lang->line('Settings saved');
            }
            else
            {
                // notify the user something bad happened
                $this->_notifications['error'][] = $this->lang->line('Can not save brand information');
            }

            //$this->session->set_flashdata('notifications', $this->_notifications);
            $this->template->set('notifications', $this->_notifications);

            $this->_data = array_merge($this->_data, $data);
            $this->template->build('brand_edit', $this->_data);
        }
    }


    public function edit_brand_profile() {
        
        $this->_menu['page'] = 'my_brands';
        $this->template->set('menu', $this->_menu);

        $this->template->build('brand_edit_profile', $this->_data);

    }



    public function edit_brand_info($brand_id = NULL)
    {

        $this->_menu['page'] = 'my_brands';
        $this->template->set('menu', $this->_menu);

        $this->load->model('operator/operator_model');
        $this->load->model('brand/brand_model');

        $this->form_validation->set_rules('brand[id]', 'Brand ID', 'required');
        
        $this->form_validation->set_rules('brand[name]', 'Brand Name', 'required|max_length[100]|xss_clean');
        //$this->form_validation->set_rules('brand[description]', 'Brand Description', 'max_length[512]|xss_clean');
        //$this->form_validation->set_rules('brand[picture]', 'Brand Picture', 'max_length[256]|xss_clean');
        
        //$this->form_validation->set_rules('contact[first_name]', 'Contact First Name', 'max_length[100]|xss_clean');
        //$this->form_validation->set_rules('contact[last_name]', 'Contact Last Name', 'max_length[100]|xss_clean');

        $this->form_validation->set_rules('contact[address]', 'Contact Address', 'required|max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[city]', 'Contact City', 'required|max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[state]', 'Contact State', 'required|max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[country]', 'Contact Contry', 'required|max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[phone]', 'Contact Phone', 'required|max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[fax]', 'Contact Phone', 'max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[website]', 'Contact Phone', 'max_length[100]|xss_clean');



        $contact = $this->input->post('contact');

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
            // @TODO notify the user that there has been a problem loading this brand
            $this->_notifications['error'][] = $this->lang->line('Cant load brand information');
            $this->session->set_flashdata('notifications', $this->_notifications);

            redirect($this->redirect_back());
        }

        $data['brand'] = $brand;

        // get the brand's contact info
        $this->load->model('contact/contact_model');
        $options['brand']['id'] = $data['brand']['id'];
        $options['contact']['id'] = $data['brand']['contact_id'];
        $contact_data = $this->contact_model->get($options);
        if ($contact_data)
        {
            $data['contact'] = (array) $contact_data;
        }


        if ($this->form_validation->run() === FALSE)
        {
            //if ($_SERVER['REQUEST_METHOD'] === 'POST')
            if ($this->input->server('REQUEST_METHOD') === 'POST')
            {
                // collect all errors
                $this->_notifications['error'][] = validation_errors();

                // save in the session for printing on page load
                $this->session->set_flashdata('notifications', $this->_notifications);

                redirect('brand/edit_brand_profile');
            }
            else
            {
                // post was probably not submitted or validation failed
                $this->_data = array_merge($this->_data, $data);
                //$this->template->build('brand_edit_info', $this->_data);
                $this->load->view('brand/brand_edit_info', $this->_data);
            }
        }
        else
        {
            $payload['operator_id'] = $operator_id;
            $tmp_brand = $this->input->post('brand');
            $brand = array(
                'id' => $brand_id,
                'name' => isset($tmp_brand['name']) ? $tmp_brand['name'] : NULL,
                'description' => isset($tmp_brand['description']) ? $tmp_brand['description'] : NULL,
                'picture' => isset($tmp_brand['picture']) ? $tmp_brand['picture'] : NULL,
            );
            $payload['brand'] = $brand;
            //$change = $this->brand_model->save_brand($payload);

            /**
             * Save brand's contact info
             */
            $contact['id'] = $data['brand']['contact_id'];

            $this->load->model('contact/contact_model');
            //$payload['brand'] = $operator;
            $payload['contact'] = $contact;
            $change = $this->contact_model->save_contact($payload);


            // attempt to save the uploaded file:
            if (isset($_FILES['brand_picture']['error']) && $_FILES['brand_picture']['error'] == 0)
            {
                $upload_config['upload_path'] = './files/'.$brand_id.'/';
                $upload_config['file_name'] = 'brand_logo.jpg';
                $upload_config['overwrite'] = TRUE;
                $upload_config['allowed_types'] = 'gif|jpg|png|jpeg';
                $upload_config['remove_spaces'] = TRUE;
                $upload_config['max_size'] = '250';
                $upload_config['max_width'] = '1024';
                $upload_config['max_height'] = '768';

                $this->load->library('upload', $upload_config);

                // check directory exists
                if (!is_dir($upload_config['upload_path']))
                {
                    // attempt to create path for the brand
                    if (!mkdir($upload_config['upload_path']))
                    {
                        $this->_notifications['error'][] = $this->lang->line("We apologize but we are unable to process company icons at the moment");
                        
                        // error, could not create directory for some reason... 
                        $success = FALSE;
                        //redirect('brand/edit_brand#tab_');
                    }
                }

                if (!$this->upload->do_upload('brand_picture'))
                {
                    $this->_notifications['error'][] = $this->upload->display_errors();
                    $success = FALSE;
                }
                else
                {
                    // update the brand record for the new picture uploaded
                    $upload_data = $this->upload->data();
                    $payload['brand']['id'] = $brand_id;
                    $payload['brand']['picture'] = substr($upload_config['upload_path'], 1).$upload_data['file_name'];
                    $ret = (array) $this->brand_model->save_brand($payload);

                    if (!$ret)
                    {
                        $success = FALSE;
                        $this->_notifications['error'][] = $this->lang->line('Could not process uploaded image');
                    }

                    $success = TRUE;
                }
            }

            if ($change || $success === TRUE)
            {
                $this->_notifications['success'][] = $this->lang->line('Settings saved');
            }
            else
            {
                // notify the user something bad happened
                $this->_notifications['error'][] = $this->lang->line('Can not save brand information');
            }



            $this->session->set_flashdata('notifications', $this->_notifications);
            //$this->template->set('notifications', $this->_notifications);

            $this->_data = array_merge($this->_data, $data);
            //$this->template->build('brand_edit_info', $this->_data);
            redirect('brand/edit_brand_profile', 'refresh');
        }

    }
     
    
}