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
class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('news');
		$this->load->helper('string');
		
		$this->load->model('Madmin');
		
		$this->load->library('DX_Auth');			
		$this->load->library('form_validation');
		
		$this->load->config('kakou');
		#$this->load->library('MY_Session');
		//$this->output->enable_profiler(TRUE);
		
	}

	/* 后台首页  */
	function index()
	{
		$role_id = 1;
		
	    if($role_id == 1)
		{
			$data['f_datas'] = $this->Madmin->get_menu();
		}
		else
		{
			$data['f_datas'] = $this->Madmin->get_menu_by_prem($role_id);
		}

		$this->load->view('admin/header',$data);
		$this->load->view('admin/index');
		$this->load->view('admin/footer');
	}
	
	// 修改密码dialog
	function password()
	{
		$this->load->view('admin/password');
	}
	
	// 修改密码
	function change_pwd()
	{
		$id = 1;
		$password_old = sha1($this->input->post('password_old'));
		$query = $this->Madmin->get_user_by_id($id);
		if ($query->row()->password != $password_old) {
			$result["statusCode"] = "300";
			$result["message"] = "旧密码错误！";
		} else {
			$data['password'] = sha1($this->input->post('password_new'));
			if ($this->Madmin->edit_user($id, $data)) {
				$result["statusCode"] = "200";
				$result["message"] = "修改密码完成！";
	            #$result["navTabId"] = "passwor";
	            #$result["forwardUrl"] = base_url()."index.php/admin/passwor";
	            $result["callbackType"] = "closeCurrent";
			} else {
				$result["statusCode"] = "300";
				$result["message"] = "修改密码失败，请稍后再试！";
			}
		}		
		echo json_encode($result);
	}

	/* 登陆验证页面  */
	function check_login()
	{

		$query = $this->Madmin->login_ok();

		if ($query)
		{
			$this->session->set_userdata('manager', $this->input->post('user'));
			showmessage('登陆成功', 'admin/index');
		}
		else
		{
			showmessage('登陆失败，系统繁忙或着填写错误', 'home/index');
		}
	}
	
	/* 退出系统  */
	function logout()
	{
		//$array_items = array('manager' => '');

		//$this->session->unset_userdata($array_items);
		
		#$this->dx_auth->logout();
		session_start();
		session_unset(); 
		session_destroy();
		
		redirect('home/login');
	}

	/* 退出系统  */
	function exit_system()
	{
		//$array_items = array('manager' => '');

		//$this->session->unset_userdata($array_items);
		
		#$this->dx_auth->logout();
		session_start();
		session_unset(); 
		session_destroy();
		
		redirect('home/login');
	}
	
	function test()
	{
		#$this->Madmin->get_menu_by_prem(3);
		
		#echo $this->db->last_query();
		session_unset();
		session_destroy();
		
		 //手工指定并开启
		session_id('qnb2u4hd9mespi3vg4jm06deh5');
		session_start();
		//后面用$_SESSION['userid']就行。
		// 但是这样就完全没有用到框架的session类了。

		// 而且ci那个session类这样做是行不通的（前提是我没在有数据库中记录session）
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
?>
