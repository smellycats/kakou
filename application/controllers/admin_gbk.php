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
		$da['north']['head_title'] = '�����й������ΰ�����ϵͳ';
		
		$this->load->view('admin/main',$da);
	}

	/* ��̨��ҳ  */
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

	/* ��̨�����ļ�  */
	function top()
	{
		$this->load->view('admin/top');
	}

	/* ��̨�м��ļ�  */
	function center()
	{
		$this->load->view('admin/center');
	}

	/* ��̨�м� ����ļ� */
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

	/* ��̨�м� ����ļ� */
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

	/* ��̨�м��ұ��ļ� */
	function right()
	{
		$this->load->view('admin/right');
	}

	/* ��̨�ײ��ļ� */
	function bottom()
	{
		$this->load->view('admin/bottom');
	}

	/* �û��б�  */
	function user_list()
	{
		$data['get_user'] = $this->Madmin->get_user();

		$this->load->view('admin/user_list', $data);
	}

	/* ����û�  */
	function add_user()
	{
		$this->load->view('admin/add_user');
	}

	/* ����û���̨  */
	function add_user_ok()
	{
		$this->form_validation->set_rules('username', '�û���', 'required|unique[admin.name]');
		$this->form_validation->set_rules('password', '����', 'required|min_length[6]|is_alpha');
		$this->form_validation->set_message('min_length', '%s���ȱ��볬��6λ.');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
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
				showmessage('����û��ɹ�', 'admin/user_list');
			}
			else
			{
				showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'admin/user_list');
			}
		}
	}

	/* �޸��û�  */
	function edit_user()
	{
		$data['get_user_name'] = $this->Madmin->get_user_name($this->uri->segment(3));

		$this->load->view('admin/edit_user', $data);
	}

	/* �޸��û���̨  */
	function edit_user_ok()
	{
		$arr['name'] = $this->input->post('username');
		$arr['password'] = md5($this->input->post('password'));
		$where['id'] = $this->input->post('id');
		$table = 'admin';
		$res = $this->db->update($table, $arr, $where);

		if ($res)
		{
			showmessage('�޸��û���Ϣ�ɹ�', 'admin/user_list');
		}
		else
		{
			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'admin/user_list');
		}
	}

	/* ɾ�� �û�  */
	function del_user()
	{
		$where['id'] = $this->uri->segment(3);
		$table = 'admin';
		$res = $this->db->delete($table, $where);

		if ($res)
		{
			showmessage('ɾ���û��ɹ�', 'admin/user_list');
		}
		else
		{
			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'admin/user_list');
		}
	}

	/* �޸�����  */
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
				$data['auth_message'] = '��������Ѿ��޸ĳɹ�.';
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

	/* �޸������̨  */
	function pwd_ok()
	{
		$this->form_validation->set_rules('password', '����', 'required|min_length[6]|is_alpha');
		$this->form_validation->set_message('min_length', '%s���ȱ��볬��6λ.');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
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
				showmessage('�޸�����ɹ�', 'admin/pwd');
			}
			else
			{
				showmessage('�޸�ʧ�ܣ�ϵͳ��æ������д����', 'admin/pwd');
			}
		}
	}

	/* ��½��֤ҳ��  */
	function check_login()
	{

		$query = $this->Madmin->login_ok();

		if ($query)
		{
			$this->session->set_userdata('manager', $this->input->post('user'));
			showmessage('��½�ɹ�', 'admin/index');
		}
		else
		{
			showmessage('��½ʧ�ܣ�ϵͳ��æ������д����', 'home/index');
		}
	}

	/* �˳�ϵͳ  */
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
		
		 //�ֹ�ָ��������
		session_id('qnb2u4hd9mespi3vg4jm06deh5');
		session_start();
		//������$_SESSION['userid']���С�
		// ������������ȫû���õ���ܵ�session���ˡ�

		// ����ci�Ǹ�session�����������в�ͨ�ģ�ǰ������û�������ݿ��м�¼session��
	}
	
    /**
     * ����û�Ȩ��
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
