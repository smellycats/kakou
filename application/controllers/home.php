<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 登录管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */
class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('DX_Auth');
		$this->load->library('Lib_Kakou');			
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('news');
		$this->load->helper('kakou');
		$this->load->helper('date');
		
		//$this->load->model('Mhome');
		$this->load->model('Muser');
		$this->load->model('Msyst2');
		
		//$this->output->enable_profiler(TRUE);
	}

	/* 首页  */
	function index()
	{
		$this->login();
	}
	
	function login2()
	{
		$this->load->view('admin/login2');
	}
	
	function login3()
	{
		if( ! $this->_ip_access($this->input->ip_address()))
		{
			$data['message'] = '限制IP登陆';
		}
		else 
		{
		    $data['message'] = '';
		}
		
		$this->load->view('admin/login3', $data);
	}

	function login()
	{
		if( ! $this->_ip_access($this->input->ip_address()))
		{
			$data['message'] = '限制IP登陆';
		}
		else 
		{
		    $data['message'] = '';
		}
		#$data['adv'] = $this->Msyst->get_adv_by_disable()->result();
		
		$this->load->view('admin/login', $data);
	}
	
	function login_ok()
	{
		$data['page_title'] = '卡口系统';

		//$this->load->view('header', $data);
		
		if( $this->_ip_access($this->input->ip_address()) )
		{
		
			if ( ! $this->dx_auth->is_logged_in())
			{
				$val = $this->form_validation;
				
				$val->set_rules('username', '用户名', 'trim|required|xss_clean|');
		    	$val->set_rules('password', '密码', 'trim|xss_clean');
		    	$val->set_rules('remember', '记住登录状态', 'integer');
		    	
		    	$val->set_message('required', '%s不能为空.');
	
			    $val->set_error_delimiters('<span>', '</span>');
			    
			    $data['message'] = '';
		
				// Set captcha rules if login attempts exceed max attempts in config
/*				if ($this->dx_auth->is_max_login_attempts_exceeded())
				{
					$val->set_rules('captcha', 'Confirmation Code', 'trim|required|xss_clean|callback_captcha_check');
				}*/
				$query = $this->Muser->login($this->input->post('username'), sha1($this->input->post('password')));
				#var_dump($this->input->get('username'));
				if ($val->run() == False)
				{
					$this->load->view('admin/login', $data);
				}
				elseif ($query->num_rows() == 0)
				{
					$data['message'] = '用户名或密码错误';
					
					$this->load->view('admin/login', $data);
				}
				elseif ($query->num_rows() == 1 AND $query->row()->r_banned == NULL)
				{
					$data['message'] = '用户所属角色不存在';
					
					$this->load->view('admin/login', $data);
				}
				elseif ($query->row()->u_banned == 0 AND $query->row()->u_disabled == 0 AND $query->row()->r_banned == 0 AND $query->row()->r_disabled == 0)
				{
					$this->_set_session($query->row());
					
					$da['user_id'] = $this->session->userdata('DX_user_id');
					$da['login_ip'] = $this->session->userdata('ip_address');
					$da['login_time'] = mdate("%Y-%m-%d %H:%i:%s");
					$this->Muser->login_user_flag($da);
					
					showmessage('登录成功', 'admin/index');
				}
				elseif ($query->row()->r_disabled != 0)
				{					
					// Default is we don't show captcha until max login attempts eceeded
					//$data['show_captcha'] = FALSE;
					$data['message'] = '用户所属角色已经被删除';
					
					$this->load->view('admin/login', $data);
				}
				elseif($query->row()->u_disabled != 0)
				{
					$data['message'] = '用户已经被删除';
					$this->load->view('admin/login', $data);
				}
				elseif($query->row()->r_banned != 0 AND $query->row()->r_disabled == 0)
				{
					$data['message'] = '用户所属角色已经被冻结';
					$this->load->view('admin/login', $data);
				}
				elseif($query->row()->u_banned != 0 AND $query->row()->u_disabled == 0)
				{
					$data['message'] = '用户已经被冻结';
					$this->load->view('admin/login', $data);
				}
			}
			else
			{
				$query = $this->Muser->login($this->input->post('username'), sha1($this->input->post('password')));
				$this->_set_session($query->row());
				
				$da['user_id'] = $this->session->userdata('DX_user_id');
				$da['login_ip'] = $this->session->userdata('ip_address');
				$da['login_time'] = mdate("%Y-%m-%d %H:%i:%s");
				$this->Muser->login_user_flag($da);
				
				showmessage('登陆成功', 'admin/index');
				//$data
				//$this->Muser->user_access_count($this->session->userdata('DX_user_id'));
			}
		
		}
		else 
		{
			$data['message'] = '限制IP登陆';
				
			$this->load->view($this->dx_auth->login_view, $data);
		}
		
		//$this->load->view('admin/login');
	}
	
	function test()
	{
		$this->load->view('admin/login');
	}
	
	//回调函数检查用户名能否登录
    public function username_check($username)
    {
    	$this->load->model('Muser');
    	
    	//$exist = $this->Muser->check_user_entry_permission($username, '');
    	
    	//$banned = $this->Muser->check_user_entry_permission($username, 1);
    	
    	$query = $this->Muser->get_user_by_name_pass($username);
    	
        if ($query->num_rows() == 0 or $query->disabled !=0)
        {
        	$this->form_validation->set_message('username_check', '用户名不存在');
        	
            return FALSE;
        }
        elseif($query->banned != 0)
        {
        	$this->form_validation->set_message('username_check', '用户为锁定帐户,无法登录系统');
        	
            return FALSE;
        }
        elseif($this->Muser->get_role_by_id($exist->row()->role_id)->disable != 0)
        {
        	$this->form_validation->set_message('username_check', '用户所属角色已经冻结,无法登录系统');
        	
            return FALSE;
        }
        elseif($this->Muser->get_role_by_id($exist->row()->role_id)->disable != 0)
        {
        	$this->form_validation->set_message('username_check', '用户为锁定帐户,无法登录系统');
        	
            return FALSE;
        }
        else
        {
        	return TRUE;
        }
    }
    
    //判断IP地址是否在允许范围
    function _ip_access($ip)
    {	
    	$ip_allow = FALSE;
    	
    	$user_ip = ip_to_double($ip);
    	
    	$ip_access = $this->Msyst2->get_ip_access_by_condition_mysql('T');
    	
    	if($ip_access->num_rows()==0 || $ip == '127.0.0.1')
    	{
    		$ip_allow = TRUE;
    	}
    	else 
    	{	
    		foreach ($ip_access->result() as $row)
    		{
    			$minip = ip_to_double($row->MINIP);
    			$maxip = ip_to_double($row->MAXIP);
    			
    			if($row->MAXIP == '')
    			{
    				if($ip == $row->MINIP)
    				{
    					$ip_allow = TRUE;
    				}
    			}
    			elseif($row->MINIP != '' AND $user_ip >= $minip AND $user_ip <= $maxip)
    			{
    				$ip_allow = TRUE;
    			}
    		}
    	}
    	return $ip_allow;
    }
   
    //设置session
	function _set_session($data)
	{
		session_start();
		$_SESSION['logged_in'] = 1;
		
		$user = array(						
			'DX_user_id'		=> $data->user_id,
			'DX_username'		=> $data->username,
			'DX_role_id'		=> $data->role_id,		
			'DX_role_name'		=> $data->role_name,
			'DX_role_right'		=> explode(',',$data->role_right),
			'DX_role_openkakou' => $this->lib_kakou->openkakou2arr($data->role_id),		
			'DX_logged_in'		=> TRUE
		);

		$this->session->set_userdata($user);
	}
	
	function _get_role_data($role_id)
	{
		$data = $this->Muser->get_role_by_id($role_id);
		return $data;
	}
	
	//超时退出
	function time_out()
	{
		showmessage3('登录超时，请重新登录', 'home/exit_system');
	}

	/* 退出系统  */
	function exit_system()
	{	
		//$this->dx_auth->logout();
		session_start();
		session_unset(); 
		session_destroy();

		redirect('home/login');
	}
	
	//公告信息
	function get_notice()
	{
		#$this->load->model('Mbasedata');
		
		$data = $this->Msyst2->get_notice_all()->result_array();

		$result = array();
		
		foreach ($data as $key=>$val){
			$result[$key] = array('id' => $data[$key]['id'],
								  'text' => iconv("GBK","UTF-8//IGNORE",$data[$key]['content']),
							);
		}
		
		echo json_encode($result);
	}
	
	function user()
	{
		session_start();
		if(strstr($_SERVER["HTTP_USER_AGENT"], "MSIE 10.0")){
			echo 'IE 10';
		}
		/*
		 * strstr($_SERVER["HTTP_USER_AGENT"], "MSIE 8.0");
			strstr($_SERVER["HTTP_USER_AGENT"], "MSIE 7.0");
			strstr($_SERVER["HTTP_USER_AGENT"], "MSIE 6.0");
			strstr($_SERVER["HTTP_USER_AGENT"], "NetCaptor");
			strstr($_SERVER["HTTP_USER_AGENT"], "Netscape");
			strstr($_SERVER["HTTP_USER_AGENT"], "Lynx");
			strstr($_SERVER["HTTP_USER_AGENT"], "Opera");
			strstr($_SERVER["HTTP_USER_AGENT"], "Konqueror");
			strstr($_SERVER["HTTP_USER_AGENT"], "Mozilla/5.0");
			strstr($_SERVER["HTTP_USER_AGENT"], "Firefox");
			strstr($_SERVER["HTTP_USER_AGENT"], "Firefox/3");
			strstr($_SERVER["HTTP_USER_AGENT"], "Firefox/2");
			strstr($_SERVER["HTTP_USER_AGENT"], "Chrome");

		 */
		
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
?>
