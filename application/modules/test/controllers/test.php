<?php
class Test extends Authenticated_Controller {
	
	
	public function __construct() {
		parent::__construct();
	}
	
	
	public function index() {
	
		//Events::register('nav_primary_menu', array('Test', '_nav_primary_menu'));

	    
//	    $ret = $this->modules_manager->get_modules();
//	    $data['data'] = $ret;
		$this->template->build('test');
		
	}
	
	
	public static function _nav_primary_menu()
	{
		$menu = array(
			'title' => 'test',
			'target' => 'test/index',
			'childs' => array(
				'title' => 'test_2',
				'target' => 'test/index_2',
			),
		);
		
		return $menu;
	}
	
}