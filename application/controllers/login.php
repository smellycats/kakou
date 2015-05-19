<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Kakou 后台管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */
class Login extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();

		$this->load->helper('kakou');		
		//$this->output->enable_profiler(TRUE);
		
	}
	
	//超时
	function time_out()
	{
		showmessage3('登录超时，请重新登录', 'admin/exit_system');
	}
	
	/* 退出系统  */
	function exit_system()
	{
		//$array_items = array('manager' => '');

		//$this->session->unset_userdata($array_items);
		
		$this->dx_auth->logout();

		redirect('home/login');
	}
	
}