<?php
/**
 * Modules Manager
 *
 * @link    http://kupoya.com
 *
 * Description:
 * [describe]
 *
 * @package        kupoya
 * @copyright        Copyright (c) 2011 Liran Tal
 * @version        1.0
 */

/* PHP5 spl_autoload */
//spl_autoload_register('Modules::autoload');

class Modules_Manager {
    
    protected static $module_locations;
    protected $_ci;
    
    /**
     * @var unknown_type
     */
    protected $modules;
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        //parent::__construct();
        $this->_ci =& get_instance(); 
    }
    
    
    public static function get_modules_locations()
    {
        return $this->module_locations;
        
    }
    
    
    public function get_modules_path()
    {

        // @FIXME - use a dedicated configuration item for module locations as the way
        // that the original HMVC module provides is no good for us
        $module_locations = FCPATH.APPPATH.'modules';
        $this->module_locations[] = $module_locations;
        return $this->module_locations;
        
        
        
        // @FIXME - the following for now is disabled but should be fixed
        if (isset($this->module_locations))
            return $this->module_locations;
        
        $module_locations = $this->_ci->config->item('modules_locations');
        if (is_array($module_locations) && count($module_locations) > 0)
        {
            $this->module_locations = $module_locations;
        }
        else
        {
            $this->module_locations = array(
                APPPATH.'modules/' => '../modules/',
            );   
        }
        
        return $this->module_locations;
        
    }
    
    
    public function get_modules()
    {

        if (isset($this->modules) && is_array($this->modules) && count($this->modules) > 0)
        {
            return $this->modules;
        }
        
        // module locations are still unknown?
        if (!isset($this->module_locations))
        {
            // fetch module locations and make sure succeeded
            $module_locations = $this->get_modules_path();
            //var_dump($module_locations);
            if (!is_array($module_locations) || count($module_locations) === 0)
            {
                return false;
            }
            
        }
        
        
        $modules = array();
        foreach($this->module_locations as $location)
        {
            $modules_raw = glob($location.'/*');
            foreach($modules_raw as $module_path)
            {
                $parts = pathinfo($module_path);
                $modules[$parts['basename']] = $module_path;
            }
        }
        
        $this->modules = $modules;
        
        return $this->modules;
        
    }
    
}