<?php
/**
 * Strategy Widgets
 * 
 * Methods in this class provide access to functions providing partials like widgets, blocks, etc.
 * As such, they are accessed only view Modules:run() HMVC and *NOT* via a front-controller user accessed
 * URL (which is why these functions are prefixed with underscore (_) ).
 * 
 * This is done mainly for security reasons for now.
 */
class Strategy_Widgets extends Authenticated_Controller {
    
    protected $_data = array();

    protected $_menu = array();

    protected $_notifications = array();

    
    public function __construct()
    {
        parent::__construct();

        // $this->load->library('form_validation');

        $this->load->language('strategy', 'english');

        $this->load->helper('form');
        $this->load->helper('url');

        // $this->_menu['context'] = 'campaigns';
    }
    

    public function _get_strategy_widgets($data = NULL)
    {
        // @TODO probably needs to return *SOME* kind of view error..
        if (!$data)
            return FALSE;

        $this->load->view('widgets/strategy_widgets', $data);
    }


}