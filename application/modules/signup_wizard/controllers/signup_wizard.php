<?php
class Signup_Wizard extends Public_Controller {
    
    public $data;
    
    
    public function __construct()
    {
        parent::__construct();

        // require the ion auth library for registering user
		$this->load->library('ion_auth');
		$this->load->library('form_validation');

        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    
    public function index()
    {


		$ret = 'test';
        $data['data'] = $ret;
        $this->template->build('signup_wizard/signup_wizard', $data);
    }
    
    

	public function email_activation()
	{
		
	}

    public function create()
    {

		//validate form input
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'required|xss_clean|max_length[100]');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean|max_length[100]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean|max_length[100]');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

		// if validation is successful 
		if ($this->form_validation->run() === true)
		{
			// the username is a concatenation of the first_name and last_name fields
			$username = strtolower($this->input->post('first_name')) . strtolower($this->input->post('last_name'));
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$data['contact'] = array(
				'name' => ucfirst($this->input->post('first_name')) . ' ' . ucfirst($this->input->post('last_name')),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				// @TODO
				// maybe attempt to also fill in the city/state via geo location / ip resolving
			);

			$data['brand']['name'] = $this->input->post('brand_name');
			// @TODO fix the brand service to come from an actual item on the signup page
			$data['brand']['service_id'] = 1;
			$data['customer']['name'] = $this->input->post('brand_name');


			// attempt to create operator
			$this->load->model('ion_auth_model');
			$operator_id = $this->ion_auth_model->register($username, $password, $email);
			if (!$operator_id)
			{
				// failed to register user for some reason
				$this->session->set_flashdata('message', "User Creation Failed");
				return $this->template->build('signup_wizard/signup_wizard', $data);
			}

			$data['operator']['id'] = $operator_id;

			// attempt to create customer/contact/brand
			$this->load->model('signup_wizard/signup_wizard_model');
			$ret = $this->signup_wizard_model->register_brand($data);
			if (!$ret)
			{
				// something went wrong...


			}

			// email activation to user if required
			$this->email_activation();


			// successfully created the user
			$this->session->set_flashdata('message', "User Created");
			$data['message'] = $this->session->flashdata('message');
			$this->template->build('signup_wizard/signup_wizard', $data);
			//redirect("auth", 'refresh');

		}
		else
		{
			//display the create user form
			//set the flash data error message if there is one
			//$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->session->set_flashdata('message', "User creation failed");
			$data['message'] = $this->session->flashdata('message');

            $this->template->build('signup_wizard/signup_wizard', $data);
        }
        

	}

}