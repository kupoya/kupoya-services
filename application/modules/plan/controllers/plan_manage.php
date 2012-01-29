<?php
class Plan_Manage extends Authenticated_Controller {
    
    protected $_data = array();

    protected $_menu = array();

    protected $_notifications = array();

    
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->language('plan', 'english');

        $this->load->helper('form');
        $this->load->helper('url');

        $this->_menu['context'] = 'campaigns';
    }




    /**
     * Partial view for choosing plans
     * 
     * @param array $data array elements
     */
    public function _partial_plan_chooser($data = NULL)
    {
        if (!isset($data['plans']))
        {
            if (isset($data['strategy']['type']))
            {
                // get only free plans
                $this->load->model('plan/plan_model');
                $data['plans'] = $this->plan_model->get_dropdown($data['strategy']['type'], TRUE);
            }
            else
            {
                return FALSE;
            }
        }

        $this->load->view('view_partials/plan_chooser', $data);
    }


    /**
     * Redirects to the specific strategy type extended view
     * 
     * @param int $strategy_id
     * @param int $campaign_id
     */
    public function upgrade()
    {
        $plan = $this->input->post('plan');
        $strategy = $this->input->post('strategy');

        if (!isset($plan['id']) || !isset($strategy['id']))
        {

            // no plan id provided, 
            $this->_notifications['error'][] = 'Error upgrading plan';
            $this->session->set_flashdata('notifications', $this->_notifications);

            redirect($this->redirect_back());
        }

        $this->load->model('plan/plan_model');

        $payload['plan'] = $plan;
        $payload['strategy'] = $strategy;

        $ret = $this->plan_model->upgrade($payload);
        if (!$ret)
        {
            $this->_notifications['error'][] = 'Error upgrading plan';
            // @TODO show an error message to the user
        }
        else
        {
            $notifications['success'][] = 'Upgraded plan successfully!';            
        }

        $this->session->set_flashdata('notifications', $notifications);

        redirect($this->redirect_back());
    }


}