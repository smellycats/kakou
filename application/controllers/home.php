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
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('Lib_Kakou');			
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('kakou');
		$this->load->helper('date');
		
		$this->load->model('Mhome');
		
		//$this->output->enable_profiler(TRUE);
	}

    /**
     * 登录页面
     * 
     * @return void
     */
	public function index()
	{
		$this->login();
	}

	public function login()
	{	
		$this->load->view('admin/login');
	}
	
	public function login_ok()
	{
		$data['page_title'] = '卡口系统';
		
		$val = $this->form_validation;
				
		$val->set_rules('username', '用户名', 'trim|required|xss_clean|');
		$val->set_rules('password', '密码', 'trim|required|xss_clean');
		$val->set_rules('remember', '记住登录状态', 'integer');
		    	
		$val->set_message('required', '%s不能为空.');
	
		$val->set_error_delimiters('<span>', '</span>');
			    
		$data['message'] = '';
		
		$query = $this->Mhome->getUserByName($this->input->post('username', True));

		if ($val->run() == False) {
			$this->load->view('admin/login', $data);
			exit;
		} 
		if ($query->num_rows() == 0) {
			$data['message'] = '用户名或密码错误';
			$this->load->view('admin/login', $data);
			exit;
		}
		if ($this->input->post('password') != sha1($query->row->password)) {
			$data['message'] = '用户名或密码错误';
			$this->load->view('admin/login', $data);
			exit;
		}
		// 检查用户IP
		if ($this->_checkIpAccess($this->session->userdata('ip_address')) == False) {
			$data['message'] = '限制IP登陆';
			$this->load->view('admin/login', $data);
			exit;
		}
		if ($query->row()->r_banned == 1) {
			$data['message'] = '用户所属角色已被冻结';	
			$this->load->view('admin/login', $data);
			exit;
		}
		if($query->row()->u_banned == 1){
			$data['message'] = '用户已被冻结';
			$this->load->view('admin/login', $data);
			exit;
		}
		// 保存session
		$this->_setSession($query->row());
		// 修改用户登录信息
		$da['last_ip']    = $this->session->userdata('ip_address');
		$da['last_login'] = mdate("%Y-%m-%d %H:%i:%s");
		$this->Mhome->loginPlus($query->row()->id, $da);
		// 添加登录日志
		$da2['ip']        = $this->session->userdata('ip_address');
		$da2['user_id']   = $query->row()->id;
		$da2['user_name'] = $query->row()->user_name;
		$this->Mhome->addAccessLog($da2);
				
		redirect('admin/index');
	}
	
	public function test()
	{
		$da['last_ip']    = '123';
		$da['last_login'] = mdate("%Y-%m-%d %H:%i:%s");
		$this->Mhome->userLoinAdd(299, $da);
	}
    
    /**
     * 登录页面
     * 
     * @param string $ip IP地址
     * @return bool
     */
    private function _checkIpAccess($ip)
    {
    	$is_access = False;
    	
    	$int_ip = h_ip_to_double($ip);
    	
    	$query = $this->Mhome->getIpAccess();
    	
    	if ($query->num_rows() == 0) {
    		$is_access = True;
    	} else {	
    		foreach ($query->result_array() as $row) {
    			$minip = h_ip_to_double($row['minip']);
    			$maxip = h_ip_to_double($row['maxip']);
    			
    			if($row['maxip']== '') {
					if($ip == $row['minip']) {
    					$is_access = True;
    				}
    			} elseif($row['minip'] != '' AND $int_ip >= $minip AND $int_ip <= $maxip) {
    				$is_access = True;
    			}
    		}
    	}

    	return $is_access;
    }

    /**
     * 设置session
     * 
     * @param object $data 用户对象
     * @return void
     */
	private function _setSession($data)
	{
		session_start();
		$_SESSION['logged_in']  = 1;
		$_SESSION['timestamp']  = time();
		$_SESSION['role_id']    = $data->role_id;
		$_SESSION['role_name']  = $data->role_name;
		$_SESSION['role_right'] = explode(',', $data->role_right);
		$_SESSION['role_openkk']= explode(',', $data->role_openkk);
		$_SESSION['user_id']    = $data->user_id;
		$_SESSION['user_name']  = $data->user_name;
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

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
?>
