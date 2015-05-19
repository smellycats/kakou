<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ϵͳ���ÿ�����
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
		$this->load->helper('form');
		$this->load->helper('news');
		
		$this->load->library('DX_Auth');
		$this->load->library('form_validation');
		
		$this->load->model('Msyst');
				
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		role_man();
	}
	
	
	//�ص�������鱨��IP��ַ�Ƿ��ظ�
	function alarmip_check($alarm_ip)
	{
		$result = $this->Msyst->is_alarm_ip_available($alarm_ip);
		if ( ! $result)
		{
			$this->form_validation->set_message('alarmip_check', '������IP�Ѿ�����.');
		}
				
		return $result;
	}
	
	//�������б�
	function alarm_point()
	{
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$row_count = 10;
		// Get all users
		$data['alarm_point'] = $this->Msyst->get_alarmpoint_all($offset, $row_count)->result();
		//$data['alarm_point'] = $this->Msyst->get_alarmpoint_all(0, 0)->result();
		$data['offset'] = $offset;
		
		$config['base_url'] = site_url('syst/alarm_point/');
		$config['total_rows'] = $this->Msyst->get_alarmpoint_all()->num_rows();
		$config['per_page'] = $row_count;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '��һҳ';
		$config['last_link'] = 'βҳ';
		$config['next_link'] = '��һҳ';
		$config['prev_link'] = '��һҳ';

		$this->pagination->initialize($config);

		$this->load->view('syst/alarm_point', $data);
	}
	
	//��ӱ�����
	function add_alarmpoint()
	{
		$this->form_validation->set_rules('alarm_ip', '������IP', 'required|xss_clean|callback_alarmip_check');
		$this->form_validation->set_message('is_unique', '%s�Ѿ�����.' );
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$data['alarm_ip'] = $this->input->post('alarm_ip');
		$data['alarm_name'] = $this->input->post('alarm_name');

		if ($this->form_validation->run() == FALSE)
		{
		    $this->load->library('pagination');
		
		    // Get offset and limit for page viewing
		    $offset = (int) $this->uri->segment(3);
		    // Number of record showing per page
	    	$row_count = 20;
    		// Get all users
	    	$data['alarm_point'] = $this->Msyst->get_alarmpoint_all($offset, $row_count)->result();
	    	//$data['alarm_point'] = $this->Msyst->get_alarmpoint_all(0, 0)->result();
		
	    	$config['base_url'] = site_url('syst/alarm_point/');
		    $config['total_rows'] = $this->Msyst->get_alarmpoint_all()->num_rows();
	    	$config['per_page'] = $row_count;
	     	$config['uri_segment'] = 3;
	    	$config['full_tag_open'] = '<p>';
	    	$config['full_tag_close'] = '</p>';
	    	$config['first_link'] = '��һҳ';
    		$config['last_link'] = 'βҳ';
    		$config['next_link'] = '��һҳ';
    		$config['prev_link'] = '��һҳ';

	    	$this->pagination->initialize($config);

	    	$this->load->view('syst/alarm_point', $data);
		}
		else
		{
		    $res = $this->Msyst->create_alarmpoint($data);
		
    	    if ($res)
		    {
	     		showmessage('��ӽ�ɫ�ɹ�', 'syst/alarm_point');
	    	}
    		else
		    {
		    	showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/alarm_point');
		    }
		}
	}
	
	
	//�����޸ı�������Ϣҳ��
	function edit_alarmpoint()
	{
		$value = $this->uri->segment(3);
		
		//���ݱ�����IP��ȡalarm_point�����Ϣ
		$data['alarm_point'] = $this->Msyst->get_alarmpoint_by_ip($value)->result();

		$this->load->view('syst/edit_alarmpoint', $data);
	}
	
	//�޸ı���������
	function edit_alarmpoint_ok()
	{
		$data['alarm_ip']   = $this->input->post('alarm_ip');
		$data['alarm_name'] = $this->input->post('alarm_name');
		
		$res = $this->Msyst->edit_alarmname($data);
	    	
		if ($res)
		{
			showmessage('�޸ı�������Ϣ�ɹ�', 'syst/alarm_point');
		}
		else
		{
			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/alarm_point');
		}	
	}
	
	//ɾ��������
	function del_alarmpoint()
	{
		$value = $this->uri->segment(3);
		
		$res = $this->Msyst->del_alarmpoint($value);
		
		if ($res)
		{
			showmessage('ɾ��������ɹ�', 'syst/alarm_point');
		}
		else
		{
			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/alarm_point');
		}
	}

	//ϵͳ��Ϣ�����б�
	function sysset2()
	{
		$sys['type_name']  = '��������';
		$sys['type_value'] = '';

		$data['config_info'] = $this->Msyst->get_config_info($sys)->result();

		$this->load->view('syst/sysset', $data);
	}
	
	//ϵͳ��Ϣ�����б�
	function sysset()
	{
		$data['config_kakou'] = $this->Msyst->get_config_kakou()->result();

		$this->load->view('syst/sysset2', $data);
	}
	
	//���ء����·�ڲ�������ͼ
	function add_sysset()
	{
		$this->load->view('syst/add_sysset');
	}
	
	function add_sysset2()
	{
		$this->load->view('syst/add_sysset2');
	}
	
	//���·�ڲ�����
	function add_sysset_ok()
	{
		$this->form_validation->set_rules('type_value', '·������', 'trim|required|xss_clean');
		$this->form_validation->set_rules('type_alias', '����', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$data['type_name']  = '��������';
		$data['type_value'] = $this->input->post('type_value');
		$data['type_alias'] = $this->input->post('type_alias');
		$data['type_def']   = $this->input->post('type_def');

		if ($this->form_validation->run() == FALSE)
		{
	    	$this->load->view('syst/sysset');
		}
		else
		{
		    $res = $this->Msyst->add_sysset($data);
		
    	    if ($res)
		    {
	     		showmessage('���·�ڲ����ɹ�', 'syst/sysset');
	    	}
    		else
		    {
		    	showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/sysset');
		    }
		}
	}
	
	//���·�ڲ�����
	function add_sysset_ok2()
	{
		$this->form_validation->set_rules('kk_id', '·��ID', 'trim|required|xss_clean|callback_kkid_check');
		$this->form_validation->set_rules('kk_name', '·������', 'trim|required|xss_clean');
		$this->form_validation->set_rules('server_ip', '�洢������IP', 'trim|required|xss_clean');
		$this->form_validation->set_rules('access_ip', '���ط���IP', 'trim|required|xss_clean');
		
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		if ($this->form_validation->run() == FALSE)
		{
		    $id = $this->input->post('kk_id');
		    
		    $data = $this->input->post(null);
		    
		    $this->load->view('syst/add_sysset2', $data);
		}
		else
		{
			$data = $this->input->post(null);
			
		    $res = $this->Msyst->add_sysset2($data);
		
    	    if ($res)
		    {
	     		showmessage('���·�ڲ����ɹ�', 'syst/sysset');
	    	}
    		else
		    {
		    	showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/sysset');
		    }
		}
	}
	
	//�޸�·�ڲ���
	function edit_sysset()
	{
		$id = $this->uri->segment(3);
		
		$data['config_info'] = $this->Msyst->get_config_info_by_id($id)->row();
		
		$this->load->view('syst/edit_sysset', $data);
	}

	//�޸�·�ڲ���
	function edit_sysset2()
	{
		$id = $this->uri->segment(3);
		
		$data = $this->Msyst->get_config_kakou_by_id($id)->row_array();
		
		$this->load->view('syst/edit_sysset2', $data);
	}
		
	//�޸�·�ڲ�����
	function edit_sysset_ok()
	{
		$this->form_validation->set_rules('type_value', '·������', 'trim|required|xss_clean');
		$this->form_validation->set_rules('type_alias', '����', 'trim|required|xss_clean');
		$this->form_validation->set_rules('type_def', '��������', 'integer');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		if ($this->form_validation->run() == FALSE)
		{
		    $id = $this->input->post('id');
		
		    $data['config_info'] = $this->Msyst->get_config_info_by_id($id)->row();
		
		    $this->load->view('syst/edit_sysset', $data);
		}
		else
		{
			$data['id']         = $this->input->post('id');
			$data['type_name']  = '��������';
	    	$data['type_value'] = $this->input->post('type_value');
		    $data['type_alias'] = $this->input->post('type_alias');
		    $data['type_def']   = $this->input->post('type_def');
		    
		    $res = $this->Msyst->edit_sysset($data);
		
    	    if ($res)
		    {
	     		showmessage('�޸�·�ڲ����ɹ�', 'syst/sysset');
	    	}
    		else
		    {
		    	showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/sysset');
		    }
		}
	}
	
	//�޸�·�ڲ�����
	function edit_sysset_ok2()
	{
		$this->form_validation->set_rules('kk_id', '·��ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kk_name', '·������', 'trim|required|xss_clean');
		$this->form_validation->set_rules('server_ip', '�洢������IP', 'trim|required|xss_clean');
		$this->form_validation->set_rules('access_ip', '���ط���IP', 'trim|required|xss_clean');
		
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		if ($this->form_validation->run() == FALSE)
		{
		    $id = $this->input->post('kk_id');
		
		    #$data['config_kakou'] = $this->Msyst->get_config_kakou_by_id($id)->row();
		    $data['KK_ID'] = $this->input->post('kk_id',True);
		    $data['KK_NAME'] = $this->input->post('kk_name',True);
		    $data['KK_IMAGE_SERVER'] = $this->input->post('server_ip',True);
		    $data['KK_GA_ACCESS_IP'] = $this->input->post('access_ip',True);
		
		    $this->load->view('syst/edit_sysset2', $data);
		}
		else
		{
			$data = $this->input->post(null);
		    
		    $res = $this->Msyst->edit_sysset2($data);
		
    	    if ($res)
		    {
	     		showmessage('�޸�·�ڲ����ɹ�', 'syst/sysset');
	    	}
    		else
		    {
		    	showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/sysset');
		    }
		}
	}
	
	//�ص���������ɫ���Ƿ��ظ�
	function kkid_check()
	{
		#var_dump('123');
		$result = $this->Msyst->is_kkid_available($this->input->post('kk_id'));
		if ( ! $result)
		{
			$this->form_validation->set_message('kkid_check', '·��ID�Ѿ�����.');
		}
				
		return $result;
	}
	
	//ɾ��·�ڲ���
	function del_sysset()
	{
		$id = $this->uri->segment(3);
		
		$res = $this->Msyst->del_sysset($id);
		
		if ($res)
		{
			showmessage('ɾ��·�ڲ����ɹ�', 'syst/sysset');
		}
		else
		{
			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/sysset');
		}
	}
	
	//ɾ��·�ڲ���
	function del_sysset2()
	{
		$id = $this->uri->segment(3);
		
		$res = $this->Msyst->del_sysset2($id);
		
		if ($res)
		{
			showmessage('ɾ��·�ڲ����ɹ�', 'syst/sysset');
		}
		else
		{
			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/sysset');
		}
	}
	
	//�û���־ 
	function usersum()
	{
		$this->load->library('pagination');
		
		$this->load->model('dx_auth/users', 'users');
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['users'] = $this->users->get_all($offset, $row_count)->result();
		
		$config['base_url'] = site_url('syst/usersum/');
		$config['total_rows'] = $this->users->get_all()->num_rows();
		$config['per_page'] = $row_count;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '��һҳ';
		$config['last_link'] = 'βҳ';
		$config['next_link'] = '��һҳ';
		$config['prev_link'] = '��һҳ';

		$this->pagination->initialize($config);

		$this->load->view('syst/usersum', $data);
	}
	
	//���ع�����������ͼ
	function alarm_rel()
	{
		$data['computer'] = $this->Msyst->get_computer_all()->result();
		
		$this->load->view('syst/alarm_rel', $data);
	}
	
	//����������
	function edit_alarmrel()
	{
		$kakou_ip = $this->uri->segment(3);
		
		$data['computer'] = $this->Msyst->get_computer_by_name($kakou_ip);
		
		$data['alarm_point'] = $this->Msyst->get_alarmpoint_all(0, 0)->result();
		
		//����·��IP���·��-�����������ı�����IP
		$kktoalarm = $this->Msyst->get_kktoalarm_by_ip($kakou_ip)->result();
		//��֯���ݵ�һ��������
		if($kktoalarm != null)
		{
	    	foreach ($kktoalarm as $id=>$alarmip)
    		{
	    		$data['kktoalarm'][$id] = $alarmip->ALARM_IP;
		    }
	    }
	    else 
	    {
	    	$data['kktoalarm'] = array();
	    }
		
		$this->load->view('syst/edit_alarmrel', $data);
	}
	
	//�޸�·��-�����������
	function edit_alarmrel_ok()
	{
		$this->form_validation->set_rules('alarmpoint[]', '����������', 'trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
		    $res=FALSE;
		}
		else
		{
			$alarm_ip = $this->input->post('alarmpoint');
			
			$res = $this->Msyst->edit_kktoalarm($this->input->post('kakou_ip'), $alarm_ip);
		}
		
		if ($res)
		{
			showmessage('�޸Ĺ���������ɹ�', 'syst/alarm_rel');
		}
		else
		{
			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/alarm_rel');
		}
	}
	
	//IP���ʿ���
	function ip_access()
	{
		$data['ip_access'] = $this->Msyst->get_ip_access_all()->result();
		
		$this->load->view('syst/ip_access', $data);
	}
	
	//���IP��ַ
	function add_ipaccess()
	{
		//$maxip = $this->input->post('maxip');
		$this->form_validation->set_rules('minip', '��СIP��ַ', 'trim|xss_clean|valid_ip|callback_emptyip_check');
		$this->form_validation->set_rules('maxip', '���IP��ַ', 'trim|xss_clean|valid_ip');

		$this->form_validation->set_message('valid_ip', '���Ϸ���IP��ַ��');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		if ($this->form_validation->run() == FALSE)
		{
		    $data['ip_access'] = $this->Msyst->get_ip_access_all()->result();
		
	    	$this->load->view('syst/ip_access', $data);
		}
		else
		{
			$minip = $this->input->post('minip');
			$maxip = $this->input->post('maxip');
			
			if($minip == '' && $maxip != '')
			{
				$data['minip'] = $maxip;
				$data['maxip'] = '';
			}
			else
			{
				$data['minip'] = $minip;
				$data['maxip'] = $maxip;
			}
			
			$res = $this->Msyst->add_ip_access($data);
			
		    if ($res)
	    	{
	    		showmessage('���IP��ַ�ɹ�', 'syst/ip_access');
	    	}
	    	else
	    	{
    			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/ip_access');
		    }
		}
		
	}
	
	//�ص���������Ƿ�IPΪ��
	function emptyip_check($minip)
	{
		$maxip = $this->input->post('maxip');
		
		if(($minip == '') && ($maxip == ''))
		{
		    $this->form_validation->set_message('emptyip_check', 'IP����Ϊ�գ�');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	//IP��ַ�Ƿ�����
	function banned_ipaccess()
	{
		$ipid = $this->uri->segment(3);
		
		$banned = $this->Msyst->get_ip_access_by_id($ipid)->row()->CLBJ  == 'T'? 'F' : 'T';
		
		$res = $this->Msyst->update_ip_access($ipid, $banned);
		
		if($res)
		{
			$data['ip_access'] = $this->Msyst->get_ip_access_all()->result();
		
	    	$this->load->view('syst/ip_access', $data);
		}
		else
		{
    		showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/ip_access');
		}
	}
	
	//ɾ��IP��ַ
	function del_ipaccess()
	{
		$ipid = $this->uri->segment(3);
		
		$res = $this->Msyst->del_ip_access($ipid);
		
		if($res)
		{
			$data['ip_access'] = $this->Msyst->get_ip_access_all()->result();
		
	    	$this->load->view('syst/ip_access', $data);
		}
		else
		{
    		showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/ip_access');
		}
	}
	
	function sysstate()
	{
		$data['eqstate'] = $this->Msyst->get_eqstate_info()->result();
		
		$this->load->view('syst/sysstate', $data);
	}
	
	//�������
	function adv()
	{
		$data['announcement'] = $this->Msyst->get_adv_all()->result();
		$data['adv_pos'] = 0;
		
		$this->load->view('syst/adv', $data);
	}
	
	//��ӹ���
	function add_adv()
	{
		$this->form_validation->set_rules('adv_content', '��������', 'trim|required|xss_clean');
		$this->form_validation->set_rules('adv_pos', '��ʾ˳��', 'trim|required|integer');
		
		$this->form_validation->set_message('required', '%s����Ϊ��.');
	    $this->form_validation->set_message('integer', '%s����Ϊ����.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		//$data['adv_content'] = $this->form_validation->set_value('adv_content');
		//$data['adv_pos']     = $this->form_validation->set_value('adv_pos');
		$data['adv_pos'] = $this->input->post('adv_pos');
		if ($this->form_validation->run() == False)
		{
			$data['announcement'] = $this->Msyst->get_adv_all()->result();
			
			$this->load->view('syst/adv', $data);
		}
		else 
		{
			$data['adv_content'] = $this->input->post('adv_content');
			$data['adv_pos']     = $this->input->post('adv_pos');
					
			$res = $this->Msyst->add_adv($data);
			
			if($res)
			{
				showmessage('��ӹ���ɹ���', 'syst/adv');
			
		    	$this->load->view('syst/adv');
			}
			else
			{
	    		showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/adv');
			}
		}
		
 		#$this->load->view('syst/adv');
	}
	
	//��������
	function turn_on_adv()
	{
		$id = $this->uri->segment(3);
		
		$this->Msyst->turn_on_adv($id);
		
		redirect('syst/adv');
	}
	
	//���ù���
	function turn_off_adv()
	{
		$id = $this->uri->segment(3);
		
		$this->Msyst->turn_off_adv($id);
		
		redirect('syst/adv');
	}
	
	//�޸Ĺ�������
	function edit_adv()
	{
		$this->form_validation->set_rules('adv_content', '��������', 'trim|required|xss_clean');
		$this->form_validation->set_rules('adv_pos', '��ʾ˳��', 'trim|required|integer');
		
		$this->form_validation->set_message('required', '%s����Ϊ��.');
	    $this->form_validation->set_message('integer', '%s����Ϊ����.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$data['adv_id']      = $this->input->post('id');	
		
		if ($this->form_validation->run() == False)
		{
			$data['announcement'] = $this->Msyst->get_adv_all()->result();
			$data['adv_pos'] = 0;
			
			$this->load->view('syst/adv', $data);
		}
		else 
		{
			$data['adv_content'] = $this->input->post('adv_content');
			$data['adv_pos']     = $this->input->post('adv_pos');
					
			$res = $this->Msyst->edit_adv_by_id($data);
			
			if($res)
			{
				showmessage('�޸Ĺ���ɹ���', 'syst/adv');
			
		    	$this->load->view('syst/adv');
			}
			else
			{
	    		showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/adv');
			}
		}
	}
	//ɾ������
	function del_adv()
	{
		$data['adv_id']  = $this->input->get('id');
		$data['adv_pos'] = $this->input->get('adv_pos');
		
		$res = $this->Msyst->del_adv_by_id($data);
			
		if($res)
		{
			showmessage('ɾ������ɹ���', 'syst/adv');
			
		}
		else
		{
	    	showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/adv');
		}
	}
	//����
	function downloads()
	{
		$this->load->view('syst/downloads');
	}

	function gsm()
	{
		$data['sm'] = $this->Msyst->get_sm_if()->row();
		#var_dump($data['sm']->TEL);
		$this->load->view('syst/gsm', $data);
	}
	
	//��������
	function edit_gsm()
	{
/*		$this->form_validation->set_rules('ipaddr', '��Ϣ��IP��ַ', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');*/
		
/*		if ($this->form_validation->run() == False)
		{	
			$data['sm'] = $this->Msyst->get_sm_if()->row();
			$this->load->view('syst/gsm', $data);
		}
		else 
		{
			$data = $this->input->post(NULL);
			
			$data['autosend'] = $this->input->post('autosend')== 'F'? 0 : $this->input->post('banned');
					
			$res = $this->Msyst->set_sm_if($data);
			
			if($res)
			{
				showmessage('����������óɹ���', 'syst/gsm');
		    	//$this->load->view('syst/gsm');
			}
			else
			{
	    		showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/gsm');
			}
			#$data['sm'] = $this->Msyst->get_sm_if()->row();
			#$this->load->view('syst/gsm',$data);
		}*/
		
		#$this->load->view('syst/gsm',$data);
		
		$data = $this->input->post(NULL);
		
		$data['autosend'] = $this->input->post('autosend')== 'T'? $this->input->post('autosend'):'F';
				
		$res = $this->Msyst->set_sm_if($data);
		
		if($res)
		{
			showmessage('����������óɹ���', 'syst/gsm');
	    	//$this->load->view('syst/gsm');
		}
		else
		{
    		showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'syst/gsm');
		}
	}
	
	//�����÷���
	function test()
	{
		showmessage('����ǲ���', 'syst/ip_access');
	}
}