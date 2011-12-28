<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package		CodeIgniter
* @author		Rick Ellis
* @copyright	Copyright (c) 2006, pMachine, Inc.
* @license		http://www.codeignitor.com/user_guide/license.html
* @link			http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* kupoya Application Helpers
*
* @package		CodeIgniter
* @subpackage	Helpers
* @category		Helpers
* @author       Liran Tal <liran.tal@gmail.com>
*/

// ------------------------------------------------------------------------

function kupoya_operator($info = NULL)
{
	$ci =& get_instance();
	
	$operator = $ci->session->userdata('operator');
	
	if (!$info)
		return $operator;

	if (isset($operator[$info]))
		return $operator[$info];

	return $operator;
}

