<?php

/**
 * Menu
 * 
 * Generic menu implementation
 * @author Liran Tal <liran.tal@gmail.com>
 *
 */
class Menu {
	

	/**
	 * @var object		CI's superglobal object
	 */
	private $_ci;
	
	
	public function __construct()
	{
		$this->_ci =& get_instance();
		log_message('debug', 'Menu Class Initialized');
	}
	
	public static function get_menu()
	{
		$a = Events::trigger('nav_primary_menu', null, 'array');
		//var_dump($a);
	
		$iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($a));
		echo PHP_EOL;
		
		foreach($iterator as $key=>$value)
		{
			echo $iterator->getDepth().PHP_EOL;
		    echo $key.' -- '.$value.'<br />';
		}
		
	}
	
}