<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Create_New_Campaign extends Authenticated_Controller {

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

        $this->template->build('create_new_campaign', $this->_data);
    }

}