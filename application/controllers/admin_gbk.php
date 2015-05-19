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
	// Used for registering and changing password form validation
	var $min_username = 4;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;
	
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
		#$this->load->library('MY_Session');
		//$this->output->enable_profiler(TRUE);
		
	}
	
	function kakou()
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
		$da['west'] = $data;
		$da['north']['head_title'] = '惠州市公安局治安卡口系统';
		
		$this->load->view('admin/main',$da);
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

	/* 后台顶部文件  */
	function top()
	{
		$this->load->view('admin/top');
	}

	/* 后台中间文件  */
	function center()
	{
		$this->load->view('admin/center');
	}

	/* 后台中间 左边文件 */
	 function left()
	{
		$role_id = $this->session->userdata('DX_role_id');
		
	    if($role_id == 1)
		{
			$data['f_datas'] = $this->Madmin->get_menu();
		}
		else
		{
			$data['f_datas'] = $this->Madmin->get_menu_by_prem($role_id);
		}

		$this->load->view('admin/left', $data);
		
	}

	/* 后台中间 左边文件 */
	 function left2()
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

		$this->load->view('admin/left2', $data);
		
	}

	/* 后台中间右边文件 */
	function right()
	{
		$this->load->view('admin/right');
	}

	/* 后台底部文件 */
	function bottom()
	{
		$this->load->view('admin/bottom');
	}

	/* 用户列表  */
	function user_list()
	{
		$data['get_user'] = $this->Madmin->get_user();

		$this->load->view('admin/user_list', $data);
	}

	/* 添加用户  */
	function add_user()
	{
		$this->load->view('admin/add_user');
	}

	/* 添加用户后台  */
	function add_user_ok()
	{
		$this->form_validation->set_rules('username', '用户名', 'required|unique[admin.name]');
		$this->form_validation->set_rules('password', '密码', 'required|min_length[6]|is_alpha');
		$this->form_validation->set_message('min_length', '%s长度必须超过6位.');
		$this->form_validation->set_message('required', '%s不能为空.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/add_user');
		}
		else
		{
			$arr['name'] = $this->input->post('username');
			$arr['password'] = md5($this->input->post('password'));
			$table = 'admin';
			$res = $this->db->insert($table, $arr);

			if ($res)
			{
				showmessage('添加用户成功', 'admin/user_list');
			}
			else
			{
				showmessage('操作失败，系统繁忙或着填写错误', 'admin/user_list');
			}
		}
	}

	/* 修改用户  */
	function edit_user()
	{
		$data['get_user_name'] = $this->Madmin->get_user_name($this->uri->segment(3));

		$this->load->view('admin/edit_user', $data);
	}

	/* 修改用户后台  */
	function edit_user_ok()
	{
		$arr['name'] = $this->input->post('username');
		$arr['password'] = md5($this->input->post('password'));
		$where['id'] = $this->input->post('id');
		$table = 'admin';
		$res = $this->db->update($table, $arr, $where);

		if ($res)
		{
			showmessage('修改用户信息成功', 'admin/user_list');
		}
		else
		{
			showmessage('操作失败，系统繁忙或着填写错误', 'admin/user_list');
		}
	}

	/* 删除 用户  */
	function del_user()
	{
		$where['id'] = $this->uri->segment(3);
		$table = 'admin';
		$res = $this->db->delete($table, $where);

		if ($res)
		{
			showmessage('删除用户成功', 'admin/user_list');
		}
		else
		{
			showmessage('操作失败，系统繁忙或着填写错误', 'admin/user_list');
		}
	}

	/* 修改密码  */
	function pwd()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation
			$val->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']');
			$val->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_new_password]');
			$val->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean');
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password')))
			{
				$data['auth_message'] = '你的密码已经修改成功.';
				$this->load->view($this->dx_auth->change_password_success_view, $data);
			}
			else
			{
				$this->load->view($this->dx_auth->change_password_view);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}

	/* 修改密码后台  */
	function pwd_ok()
	{
		$this->form_validation->set_rules('password', '密码', 'required|min_length[6]|is_alpha');
		$this->form_validation->set_message('min_length', '%s长度必须超过6位.');
		$this->form_validation->set_message('required', '%s不能为空.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/pwd');
		}
		else
		{
			$arr['password'] = md5($this->input->post('password'));
			$where['username'] = $this->session->userdata('DX_role_name');
			$table = 'users';
			$res = $this->db->update($table, $arr, $where);

			if ($res)
			{
				showmessage('修改密码成功', 'admin/pwd');
			}
			else
			{
				showmessage('修改失败，系统繁忙或着填写错误', 'admin/pwd');
			}
		}
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
	function exit_system()
	{
		//$array_items = array('manager' => '');

		//$this->session->unset_userdata($array_items);
		
		$this->dx_auth->logout();

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
	
    /**
     * 检查用户权限
     *
     * @access  public
     * @return  int
     */
     function check_rights()
     {
     	$function = $this->input->post('func',True);
     	
     	#$query = $this->Madmin->get_menu_by_name($function);
     	#$rights = $this->session->userdata('DX_role_right');
     	
     	#if($query->num_rows()==1 AND $this->session->userdata('DX_role_id')!=1 AND !in_array($query->row()->id,$rights))
		#{
		$result['res'] = False;
		
		echo json_encode($result);
		#} else
		#{
			#return 0;
		#}
     }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
?>
