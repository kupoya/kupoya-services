<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Asset Directory
|--------------------------------------------------------------------------
|
| The directory where all the assets are placed
|
|	/assets/
|
*/

$config['asset_dir'] = 'assets/';


/*
|--------------------------------------------------------------------------
| Application Asset Directory
|--------------------------------------------------------------------------
|
| Absolute path to your CodeIgniter application-wide assets directory 
| Typically this will be your APPATH, WITH a trailing slash:
|
|	/assets/
|
| Tip: if APPPATH_URI is not defined, use base_url() from 'url' helper
|
*/

$config['app_asset_dir'] = APPPATH_URI . $config['asset_dir'];

/*
|--------------------------------------------------------------------------
| Asset URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	/assets/
|
*/

$config['asset_url'] = config_item('base_url').APPPATH . 'assets/';

/*
|--------------------------------------------------------------------------
| Theme Asset Directory
|--------------------------------------------------------------------------
|
*/

//$config['theme_asset_dir'] = APPPATH_URI. 'themes/';
$config['theme_asset_dir'] = 'themes/';

/*
|--------------------------------------------------------------------------
| Theme Asset URL
|--------------------------------------------------------------------------
|
*/

$config['theme_asset_url'] = config_item('base_url').APPPATH.'themes/';

/*
|--------------------------------------------------------------------------
| Asset Sub-folders
|--------------------------------------------------------------------------
|
| Names for the img, js and css folders. Can be renamed to anything
|
|	/assets/
|
*/
$config['asset_img_dir'] = 'img';
$config['asset_js_dir'] = 'js';
$config['asset_css_dir'] = 'css';