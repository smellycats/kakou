<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Kakou ��̨���������
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
	
	//��ʱ
	function time_out()
	{
		showmessage3('��¼��ʱ�������µ�¼', 'admin/exit_system');
	}
	
	/* �˳�ϵͳ  */
	function exit_system()
	{
		//$array_items = array('manager' => '');

		//$this->session->unset_userdata($array_items);
		
		$this->dx_auth->logout();

		redirect('home/login');
	}
	
}