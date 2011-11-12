<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
	Copyright (c) 2011 Lonnie Ezell

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:
	
	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.
	
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

/*
	Class: Base_Controller
	
	This controller provides a controller that your controllers can extend
	from. This allows any tasks that need to be performed sitewide to be 
	done in one place.
	
	Since it extends from MX_Controller, any controller in the system
	can be used in the HMVC style, using modules::run(). See the docs 
	at: https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/wiki/Home
	for more detail on the HMVC code used in Bonfire.
	
	Extends:
		MX_Controller
		
	Package:
		MY_Controller
*/
class Base_Controller extends MX_Controller {

	/*
		Var: $previous_page
		
		Stores the previously viewed page's complete URL.
	*/
	protected $previous_page;
	
	/*
		Var: $requested_page
		
		Stores the page requested. This will sometimes be
		different than the previous page if a redirect happened
		in the controller.
	*/
	protected $requested_page;
	
	//--------------------------------------------------------------------
	
	public function __construct() 
	{
	    
	    parent::__construct();
	    //$this->load->library('Modules_Manager');
	    
		/*
		Events::trigger('before_controller', get_class($this));
	
		parent::__construct();
		
		// Dev Bar?
		if (ENVIRONMENT == 'development')
		{
			$this->load->library('Console');
			
			if (!$this->input->is_cli_request() && config_item('site.show_profiler'))
			{
				$this->output->enable_profiler(true);
			}
		}
		
		$this->lang->load('application');

		$this->load->driver('cache', array('adapter' => 'file'));
		
		$this->previous_page = $this->session->userdata('previous_page');
		$this->requested_page = $this->session->userdata('requested_page');
		
		// check if the app is installed
		$site_title = config_item('site.title');
		if (empty($site_title))
		{
			redirect('/install');
		}
		
		// Pre-Controller Event
		Events::trigger('after_controller_constructor', get_class($this));
		*/
	}
	
	//--------------------------------------------------------------------
	
}

/**
 * 
 * Dummy class
 * @TODO remove this probably
 *
 */
class MY_Controller extends Base_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
}
  

// End Base_Controller class

//--------------------------------------------------------------------

/*
	Class: Public_Controller
	
	This class provides a common place to handle any tasks that need to
	be done for all public-facing controllers.
	
	Extends:
		Base_Controller
*/
class Public_Controller extends Base_Controller {
	
	
	public function __construct() 
	{
		parent::__construct();

		$this->load->library('menu/menu');

		// decide on theme to show up
		$theme = 'admin';

		$this->asset->set_theme($theme);
		$this->template->set_theme($theme);

		// template settings
		$this->template->set_layout('admin');
		
	}
	
}

// End Public_Controller class

//--------------------------------------------------------------------

/*
	Class: Authenticated_Controller
	
	Provides a base class for all controllers that must check user login
	status. 
	
	Extends:
		Base_Controller
*/
class Authenticated_Controller extends Base_Controller {

	

	/**
	 * Logged In 
	 * 
	 * Checkes whether user is logged in or not.
	 * If user is not logged in, redirect to the login page, otherwise return true; 
	 * 
	 */
	public function logged_in()
	{
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}

		return true;
	}


	/**
	 * Redirect back 
	 * 
	 * Resolve the URL to send the user back if accessed a non-existing uri
	 * 
	 * @param string $redirect_to
	 * 	by default this is NULL and redirection will be resolved to base_url(), otherwise resolving will return
	 * 	$redirect_to
	 * @return string $to
	 * 	redirect back to the 
	 */
	public function redirect_back($redirect_to = NULL)
	{
		// go back from where you got here
		if (isset($_SERVER['HTTP_REFERER']))
			return $_SERVER['HTTP_REFERER'];

		if (isset($redirect_to))
			return $redirect_to;
		else
			return $this->uri->segment(1, base_url());
	}
	
	public function __construct()
	{
		parent::__construct();
		
		Events::trigger('system:authenticated:before');
		
		// decide on theme to show up
		$theme = 'admin';

		$this->asset->set_theme($theme);
		$this->template->set_theme($theme);

		// template settings
		$this->template->set_layout('admin');

		// menu system
		$this->load->library('menu/menu');

		// load necessary libraries for an authenticated user
		$this->load->library('session');
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->database();
		// load necessary helpers
		$this->load->helper('url');
		// require user to be logged in to the system
		$this->logged_in();


		//$this->template->set_partial('header', 'layouts/partials/header');
		//$this->template->set_partial('footer', 'layouts/partials/footer');

		//Asset::add_asset('css', css('1.css', 'test'), 'test');
		//Asset::add_asset('css', css('2.css', 'test'), 'test');
		//Asset::add_asset('js', js('3.js', 'test'), 'test');
		
		//$this->template->build('test');
		/*
		
		$this->load->database();
		$this->load->library('session');
		
		$this->load->model('activities/Activity_model', 'activity_model', true);
		
		// Auth setup
		$this->load->model('users/User_model', 'user_model');
		$this->load->library('users/auth');
		$this->load->model('permissions/permission_model');
		$this->load->model('roles/role_permission_model');
		$this->load->model('roles/role_model');
		
		// Make sure we're logged in.
		$this->auth->restrict();
		
		// Load additional libraries
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;	// Hack to make it work properly with HMVC
		*/
	}

}



/*
	Class: Admin_Controller
	
	This class provides a base class for all admin-facing controllers. 
	It automatically loads the form, form_validation and pagination
	helpers/libraries, sets defaults for pagination and sets our 
	Admin Theme.
	
	Extends:
		Authenticated_controller	
*/

class Admin_Controller extends Authenticated_Controller {
	
	//--------------------------------------------------------------------
	
	public function __construct() 
	{
		/*
		parent::__construct();
		
		$this->lang->load('application');
		$this->load->helper('application');
		
		$this->load->library('pagination');
		
		// Pagination config
		$this->pager = array();
		$this->pager['full_tag_open']	= '<div class="pagination">';
		$this->pager['full_tag_close']	= '</div>';
		$this->pager['next_link'] 		= 'Next &raquo;';
		$this->pager['prev_link'] 		= '&laquo; Previous';
		
		$this->limit = $this->config->item('site.list_limit');
		
		// Basic setup
		Template::set_theme('admin');
		Assets::add_css(array('ui.css', 'notifications.css', 'buttons.css'));
		*/
	}
	
	//--------------------------------------------------------------------
	
}

// End Admin_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */