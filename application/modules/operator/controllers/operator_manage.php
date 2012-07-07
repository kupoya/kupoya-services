<?php
class Operator_Manage extends Authenticated_Controller {
    
    protected $_data = array();

    protected $_menu = array();

    protected $_notifications = array();

    
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->language('operator', 'english');

        $this->_menu['context'] = 'account';

        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    
    public function index()
    {
        
        // @TODO this is a place holder for the main /brand URI but it's not functional yet
        // so forwarding to edit_brand
        redirect('operator/view_contact');

        // //$this->load->model('operator/operator_model');
        
        // $data['data'] = $ret;
        // $this->template->build('operator_list', $data);
    }
    


    public function change_password($operator_id = NULL)
    {
        $this->_menu['page'] = 'profile';
        $this->template->set('menu', $this->_menu);

        $this->load->model('operator/operator_model');

        // if operator id was not provided in uri attempt to guess from session
        if (!$operator_id)
        {
            $operator_id = $this->operator_model->get_operator_id();
        }

        if (!$operator_id)
            redirect($this->redirect_back());

        //$data = $this->operator_model->load_operator(array('operator_id' => $operator_id));
        $data['operator'] = (array) $this->operator_model->get($operator_id);

        if (!$data) {
            // @TODO notify the user that there has been a problem loading this operator
            redirect($this->redirect_back());
        }

        $this->form_validation->set_rules('operator[id]', 'Operator ID', 'required');
        $this->form_validation->set_rules('old_password', 'Old password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_password_confirm]');
        $this->form_validation->set_rules('new_password_confirm', 'Confirm New Password', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            //error
            $this->template->build('operator_edit', $data);
        }
        else
        {
            // save strategy info
            //$this->load->model('advertisement/advertisement_model');
            //$data = $this->advertisement_model->save_advertisement($data);

            $this->load->model('ion_auth_model');

            //$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));
            $operator = $this->session->userdata('operator');

            $change = $this->ion_auth_model->change_password($operator['id'], $this->input->post('old_password'), $this->input->post('new_password'));
            //$change = $this->ion_auth_model->change_password($identity, $this->input->post('old_password'), $this->input->post('new_password'));

            if ($change)
            {
                //if the password was successfully changed
                //$this->session->set_flashdata('message', $this->ion_auth->messages());
                // logout the user afterwards?
                $this->_notifications['success'][] = $this->lang->line('Settings saved');
                //$this->logout();
            }
            else
            {
                // notify the user something bad happened
                //$this->session->set_flashdata('message', $this->ion_auth->errors());
                //redirect('auth/change_password', 'refresh');
                $this->_notifications['error'][] = $this->lang->line('operator:error:saving_password');
            }

            $this->session->set_flashdata('notifications', $this->_notifications);
            redirect('operator/change_password');
            //$this->template->build('operator_edit', $data);
        }

    }


    public function view_contact($operator_id = NULL)
    {
        $this->_menu['page'] = 'profile';
        $this->template->set('menu', $this->_menu);

        $this->load->model('operator/operator_model');

        $this->form_validation->set_rules('operator_id', 'Operator ID', 'required');
        //$this->form_validation->set_rules('contact[id]', 'Contact ID', 'required');
        $this->form_validation->set_rules('contact[name]', 'Contact ID', 'required|max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[first_name]', 'Contact First Name', 'max_length[100]|xss_clean');
        $this->form_validation->set_rules('contact[last_name]', 'Contact Last Name', 'max_length[100]|xss_clean');
        $this->form_validation->set_rules('contact[address]', 'Contact Address', 'max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[city]', 'Contact City', 'required|max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[state]', 'Contact State', 'max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[country]', 'Contact Contry', 'max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[phone]', 'Contact Phone', 'max_length[45]|xss_clean');
        $this->form_validation->set_rules('contact[gender]', 'Contact Gender', 'numeric');
        $this->form_validation->set_rules('contact[email]', 'Contact Email', 'max_length[80]|valid_email');

        $contact = $this->input->post('contact');

        if ($this->input->post('operator_id'))
            $operator_id = $this->input->post('operator_id');

        // if operator id was not provided in uri attempt to guess from session
        if (!$operator_id)
        {
            $operator_id = $this->operator_model->get_operator_id();
        }

        if (!$operator_id)
            redirect($this->redirect_back());

        $data = $this->operator_model->load_operator(array('operator_id' => $operator_id));
        if (!$data) {
            // @TODO notify the user that there has been a problem loading this operator
            redirect($this->redirect_back());
        }

        $operator = $data['operator'];

        // set contact id to the loaded operator's contact id
        $contact['id'] = $operator['contact_id'];

        if ($this->form_validation->run() === FALSE)
        {
            $this->template->build('operator_view_contact', $data);
            // redirect($this->redirect_back());
        }
        else
        {
            $this->load->model('contact/contact_model');
            $payload['operator'] = $operator;
            $payload['contact'] = $contact;
            $change = $this->contact_model->save_contact($payload);

            if ($change)
            {
                $this->_notifications['success'][] = $this->lang->line('Settings saved');
            }
            else
            {
                // notify the user something bad happened
                $this->_notifications['error'][] = $this->lang->line('operator:error:saving_profile_contact');
            }

            //$this->session->set_flashdata('notifications', $this->_notifications);
            //redirect('operator/view_contact');
            
            $this->template->set('notifications', $this->_notifications);
            $this->template->build('operator_view_contact', $data);
        }
    }
     
    
}