<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_Page extends Authenticated_Controller {

    protected $_data = array();

    protected $_menu = array();

    protected $_notifications = array();
    

    public function __construct()
    {
        parent::__construct();

        $this->load->language('app', 'english');

        $this->load->helper('form');
        $this->load->helper('url');

        $this->_menu['context'] = 'support';
    }
    
    
    public function index()
    {

        $this->template->build('contact_page', $this->_data);
    }

}