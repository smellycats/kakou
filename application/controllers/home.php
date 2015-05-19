<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ��¼���������
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

	/* ��ҳ  */
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
			$data['message'] = '����IP��½';
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
			$data['message'] = '����IP��½';
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
		$data['page_title'] = '����ϵͳ';

		//$this->load->view('header', $data);
		
		if( $this->_ip_access($this->input->ip_address()) )
		{
		
			if ( ! $this->dx_auth->is_logged_in())
			{
				$val = $this->form_validation;
				
				$val->set_rules('username', '�û���', 'trim|required|xss_clean|');
		    	$val->set_rules('password', '����', 'trim|xss_clean');
		    	$val->set_rules('remember', '��ס��¼״̬', 'integer');
		    	
		    	$val->set_message('required', '%s����Ϊ��.');
	
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
					$data['message'] = '�û������������';
					
					$this->load->view('admin/login', $data);
				}
				elseif ($query->num_rows() == 1 AND $query->row()->r_banned == NULL)
				{
					$data['message'] = '�û�������ɫ������';
					
					$this->load->view('admin/login', $data);
				}
				elseif ($query->row()->u_banned == 0 AND $query->row()->u_disabled == 0 AND $query->row()->r_banned == 0 AND $query->row()->r_disabled == 0)
				{
					$this->_set_session($query->row());
					
					$da['user_id'] = $this->session->userdata('DX_user_id');
					$da['login_ip'] = $this->session->userdata('ip_address');
					$da['login_time'] = mdate("%Y-%m-%d %H:%i:%s");
					$this->Muser->login_user_flag($da);
					
					showmessage('��¼�ɹ�', 'admin/index');
				}
				elseif ($query->row()->r_disabled != 0)
				{					
					// Default is we don't show captcha until max login attempts eceeded
					//$data['show_captcha'] = FALSE;
					$data['message'] = '�û�������ɫ�Ѿ���ɾ��';
					
					$this->load->view('admin/login', $data);
				}
				elseif($query->row()->u_disabled != 0)
				{
					$data['message'] = '�û��Ѿ���ɾ��';
					$this->load->view('admin/login', $data);
				}
				elseif($query->row()->r_banned != 0 AND $query->row()->r_disabled == 0)
				{
					$data['message'] = '�û�������ɫ�Ѿ�������';
					$this->load->view('admin/login', $data);
				}
				elseif($query->row()->u_banned != 0 AND $query->row()->u_disabled == 0)
				{
					$data['message'] = '�û��Ѿ�������';
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
				
				showmessage('��½�ɹ�', 'admin/index');
				//$data
				//$this->Muser->user_access_count($this->session->userdata('DX_user_id'));
			}
		
		}
		else 
		{
			$data['message'] = '����IP��½';
				
			$this->load->view($this->dx_auth->login_view, $data);
		}
		
		//$this->load->view('admin/login');
	}
	
	function test()
	{
		$this->load->view('admin/login');
	}
	
	//�ص���������û����ܷ��¼
    public function username_check($username)
    {
    	$this->load->model('Muser');
    	
    	//$exist = $this->Muser->check_user_entry_permission($username, '');
    	
    	//$banned = $this->Muser->check_user_entry_permission($username, 1);
    	
    	$query = $this->Muser->get_user_by_name_pass($username);
    	
        if ($query->num_rows() == 0 or $query->disabled !=0)
        {
        	$this->form_validation->set_message('username_check', '�û���������');
        	
            return FALSE;
        }
        elseif($query->banned != 0)
        {
        	$this->form_validation->set_message('username_check', '�û�Ϊ�����ʻ�,�޷���¼ϵͳ');
        	
            return FALSE;
        }
        elseif($this->Muser->get_role_by_id($exist->row()->role_id)->disable != 0)
        {
        	$this->form_validation->set_message('username_check', '�û�������ɫ�Ѿ�����,�޷���¼ϵͳ');
        	
            return FALSE;
        }
        elseif($this->Muser->get_role_by_id($exist->row()->role_id)->disable != 0)
        {
        	$this->form_validation->set_message('username_check', '�û�Ϊ�����ʻ�,�޷���¼ϵͳ');
        	
            return FALSE;
        }
        else
        {
        	return TRUE;
        }
    }
    
    //�ж�IP��ַ�Ƿ�������Χ
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
   
    //����session
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
	
	//��ʱ�˳�
	function time_out()
	{
		showmessage3('��¼��ʱ�������µ�¼', 'home/exit_system');
	}

	/* �˳�ϵͳ  */
	function exit_system()
	{	
		//$this->dx_auth->logout();
		session_start();
		session_unset(); 
		session_destroy();

		redirect('home/login');
	}
	
	//������Ϣ
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
