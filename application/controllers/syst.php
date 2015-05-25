<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 系统设置控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Syst extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('date');
		//$this->load->helper('news');
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		echo 'syst';
	}
	
	
}