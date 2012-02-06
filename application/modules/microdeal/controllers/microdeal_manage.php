<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Microdeal_Manage extends Authenticated_Controller {
    
    protected $_data = array();

    protected $_menu = array();

    protected $strategy_type = 'microdeal';

    protected $_notifications = array();
    
    
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->language('strategy/strategy', 'english');
        $this->load->language($this->strategy_type, 'english');

        $this->load->helper('form');
        $this->load->helper('url');

        $this->_menu['context'] = 'campaigns';
    }
    
    
    // public function index()
    // {
    //     $this->load->library('datatables');
    //     $this->datatables
    //         ->select('id, serial, status, user_id, purchased_time, strategy_id')
    //         ->from('coupon');

    //     $this->datatables->edit_column('id', '<a href="profiles/edit/$1">$2</a>', 'id, username');


    //     $data['result'] = $this->datatables->generate();
    //     //$data = null;

    //     $this->load->view('ajax', $data);

    //     //$this->_data['data'] = $ret;
    //     //$this->template->build('advertisement_list', $this->_data);
    // }


    /**
     * Strategy overview page
     * 
     * @param int $strategy_id
     * @param int $campaign_id
     */
    public function view($strategy_id = 0, $campaign_id = 0)
    {
        if (!$strategy_id || !is_numeric($strategy_id))
            redirect($this->redirect_back());

        if (!$campaign_id || !is_numeric($campaign_id))
            redirect($this->redirect_back());

        $this->_data['menu']['page'] = 'campaigns';

        // load strategy information
        $this->load->model('microdeal/microdeal_model');
        $data = $this->microdeal_model->microdeal_load($strategy_id);

        if (!$data) {
            // @TODO notify the user that there has been a problem loading this strategy
            redirect($this->redirect_back());
        }

        // $this->load->model('plan/plan_model');
        // $data['plans'] = $this->plan_model->get_dropdown();
        $data['campaign']['id'] = $campaign_id;

        $this->_data = array_merge($this->_data, $data);
        $this->template->build('microdeal_view', $this->_data);
    }



}