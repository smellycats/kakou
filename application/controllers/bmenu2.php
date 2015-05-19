<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ���������������
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Bmenu extends Admin_Controller
{
	//����ԭ��
	protected $reason1 = array('��ѡ��','��������','��������','���Υ��','����');
	protected $reason2 = array('��������','��������','���Υ��','����');
	
	//����״̬
	protected $state1  = array('��ѡ��','�����','�����','�ѳ���');
	protected $state2  = array('�����','�����','�ѳ���');
	
	//���ƺ���
	protected $number = array('?','WJ','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','³','ԥ','��','��','��','��','��','��','��','��','��','��','��','��','��','̨','��','��','��','��','��','��','��','��','��','��','��','��','��');
	//������ɫ
	protected $color  = array('��','����','����','����','����');
	
	protected $reason = array('��������','��������','���Υ��','����');
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('news');
        $this->load->helper('date');
        
		$this->load->library('DX_Auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		
		$this->load->model('Mbmenu');
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		cpbk();
	}
	
	//���غ�������ͼ
	function cpbk()
	{
		//���ƺ���
		$data['number'] = $this->number;
		//������ɫ
		$data['color'] = $this->color;
		//����ԭ��
		$data['reason'] = $this->reason;
		//��¼�û�
		$data['user'] = $this->session->userdata('DX_username');
		
		$datestring = "%Y-%m-%d %h:%i:%s";
		$data['starttime'] = date('Y-m-d H:i:s',time());
        $futuredate = strtotime("next month");
        $data['endtime'] = date('Y-m-d H:i:s',$futuredate);
		
		$this->load->view('bmenu/cpbk', $data);
	}
	
	//��Ӳ�����Ϣ
	function add_bk()
	{
		$this->form_validation->set_rules('carnum', '���ƺ���', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('cartype', '��������', 'trim|xss_clean|max_length[16]');
		$this->form_validation->set_rules('linkman', '��ϵ��', 'trim|required|xss_clean|max_length[20]');
		//$this->form_validation->set_rules('mobnum', '�ֻ�����', 'trim|xss_clean|max_length[20]');
		$this->form_validation->set_rules('telnum', '�绰', 'trim|required|xss_clean|max_length[20]');
		//$this->form_validation->set_rules('bktype', '��������', 'trim|xss_clean|max_length[20]');
		//$this->form_validation->set_rules('bkdepartment', '���ص�λ', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('introduction', '������', 'trim|xss_clean|max_length[200]');
		$this->form_validation->set_rules('mobiles', '�ֻ���', 'trim|xss_clean|max_length[800]');
		
		$this->form_validation->set_message('max_length', '�ַ������λ��.');
		$this->form_validation->set_message('required', '����Ϊ��.');
		$this->form_validation->set_message('is_unique', '%s�Ѿ�����.' );
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$data['starttime'] = $this->input->post('starttime');
		#$data['endtime']  = $this->input->post('endtime');
		
		if($this->form_validation->run() == false)
		{
    		//���ƺ���
	    	$data['number'] = $this->number;
	    	//������ɫ
	    	$data['color'] = $this->color;
	    	//����ԭ��
	    	$data['reason'] = $this->reason;
	    	//��¼�û�
	    	$data['user'] = $this->session->userdata('DX_username');
		
	    	$this->load->view('bmenu/cpbk', $data);
		}
		else
		{
			$futuredate = strtotime("next month");

			$number = $this->input->post('number');
			$carnum = $this->input->post('carnum');
			$number = str_replace('?', '_', $number);
			$number = str_replace('��', '_', $number);
			$carnum = str_replace('?', '_', $carnum);
            $carnum = str_replace('��', '_', $carnum);
			$data['carnum'] = "$number" . "$carnum";
			
			$data['color']   = $this->input->post('color');
			$data['cartype'] = $this->input->post('cartype');
			$data['linkman'] = $this->input->post('linkman');
			$data['mobnum']  = $this->input->post('mobnum');
			$data['telnum']  = $this->input->post('telnum');
			$data['bktype']  = $this->input->post('bktype');
			$data['bkdepartment'] = $this->input->post('bkdepartment');;
			$data['bkdate']  = $this->input->post('starttime');
			$data['bclen']   = $this->input->post('endtime');
			$data['memo']    = $this->input->post('introduction');
			$data['lsbk']    = $this->input->post('lsbk') == True? 'T':'F';
			$data['mobiles'] = $this->input->post('mobiles');
			$data['user']    = $this->session->userdata('DX_username');
			$data['reason']  = $this->input->post('reason');
			
			$res = $this->Mbmenu->add_bkcp($data);
			
		    if($res)
		    {
		    	showmessage('�������óɹ�', 'bmenu/cpbk');
		    }
		    else 
		    {
		        showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'bmenu/cpbk');
		    }
		}
	}
	
	//���ز�ѯ��ͼ
	function bkfind()
	{
	 	$data['sel_carnum'] = '';
	    $data['sel_bkr']    = '';
		$data['sel_reason'] = '��ѡ��';
		$data['sel_state']  = '��ѡ��';
        $da['carnum'] = '';
	    $da['bkr']    = '';
		$da['reason'] = '��ѡ��';
		$da['state']  = '��ѡ��';
				
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = 0;
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		//$data['bk']          = $this->Mbmenu->search_bk2($offset, $row_count, $da)->result();
		$data['total_rows']  = $this->Mbmenu->search_bk2(0,0,$da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		$data['offset']      = $offset;
	
		$config['base_url'] = site_url() . "/bmenu/bkfind/";
		$config['total_rows'] = $data['total_rows'];
		$config['per_page'] = $row_count;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment']='per_page';
		//$config['uri_segment'] = 3;
		$config['full_tag_open']  = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link']     = '��һҳ';
		$config['last_link']      = 'βҳ';
		$config['next_link']      = '��һҳ';
		$config['prev_link']      = '��һҳ';

		//$this->pagination->initialize($config);
		
		//����ԭ��
		$data['reason'] = $this->reason1;
		//����״̬
		$data['state']  = $this->state1;
		
		$this->load->view('bmenu/bkfind', $data);
	}
	
	//���ز�ѯ����
	function bkfind_search()
	{
		$this->form_validation->set_rules('carnum', '���ƺ���', 'trim|xss_clean|max_length[20]');
		$this->form_validation->set_rules('bkr', '������', 'trim|xss_clean|max_length[20]');
		
		$this->form_validation->set_message('max_length', '%s�ַ����������.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
	    if($this->form_validation->run() == false)
		{
	    	//����ԭ��
	    	$data['reason'] = $this->reason1;
	    	//����״̬
	    	$data['state'] = $this->state1;
		
	    	$data['bk'] = $this->Mbmenu->get_bk_all()->result();
		
	    	$this->load->view('bmenu/bkfind', $data);
		}
		else
		{
		    $data['carnum'] = $this->input->post('carnum');
		    $data['bkr']    = $this->input->post('bkr');
			$data['reason'] = $this->input->post('reason');
			$data['state']  = $this->input->post('state');
			
			$da['bk'] = $this->Mbmenu->search_bk($data)->result();
	    	//����ԭ��
	    	$da['reason'] = $this->reason1;
	    	//����״̬
	    	$da['state'] = $this->state1;
	    	
	    	$this->load->view('bmenu/bkfind', $da);
		}		
		
	}
	
	//����������ѯ������Ϣ
	function bkfind_search_ok()
	{
		//$this->form_validation->set_rules('carnum', '���ƺ���', 'trim|xss_clean|max_length[20]');
		//$this->form_validation->set_rules('bkr', '������', 'trim|xss_clean|max_length[20]');
		
		//$this->form_validation->set_message('max_length', '%s�ַ����������.');
		//$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$this->_add_oplog('�������ز�ѯ.');
		
		$per_page = $this->input->get('per_page');           //ҳ��ƫ����
		
		$data['reason'] = $this->reason1;
		$data['state']  = $this->state1;
		
	    $da['carnum'] = $this->input->get('carnum',True);
	    $da['bkr']    = $this->input->get('bkr',True);
		$da['reason'] = $this->input->get('reason',True);
		$da['state']  = $this->input->get('state',True);
		
    	$data['sel_carnum'] = $da['carnum'];
	    $data['sel_bkr']    = $da['bkr'];
		$data['sel_reason'] = $da['reason'];
		$data['sel_state']  = $da['state'];
		
		$data['role_id'] = $this->session->userdata('DX_role_id');
		
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($per_page == '' ? '0' : $per_page);
		// Number of record showing per page
		$row_count = 10;
		// Get all users
		$data['bk']          = $this->Mbmenu->search_bk2($offset, $row_count, $da)->result();
		$data['total_rows']  = $this->Mbmenu->search_bk2(0,0,$da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		$data['offset']      = $offset;
	
		$config['base_url'] = site_url() . "/bmenu/bkfind_search_ok/?carnum=$da[carnum]&bkr=$da[bkr]&reason=$da[reason]&state=$da[state]";
		$config['total_rows'] = $data['total_rows'];
		$config['per_page'] = $row_count;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment']='per_page';
		//$config['uri_segment'] = 3;
		$config['full_tag_open']  = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link']     = '��һҳ';
		$config['last_link']      = 'βҳ';
		$config['next_link']      = '��һҳ';
		$config['prev_link']      = '��һҳ';
	
		$this->pagination->initialize($config);
		//$data['bk'] = $this->Mbmenu->get_bk_all()->result();
		
		$data['reason'] = $this->reason1;
		$data['state']  = $this->state1;
		
		$data['ck_right'] = $this->_check_right();
			
		$this->load->view('bmenu/bkfind', $data);
	}
	
	
	//����
	function edit_bk_ck()
	{
		$id = $this->uri->segment(3);
		
		$data['bk'] = $this->Mbmenu->get_bkcp_by_id($id)->row();
	    
	    $this->load->view('bmenu/delbk', $data);
	}
	
	//�ύ���ر�
	function edit_bk_ck_ok()
	{
		$this->form_validation->set_rules('ckreason', '����ԭ��', 'trim|xss_clean|max_length[200]');		
		$this->form_validation->set_message('max_length', '%s������200λ�ַ�');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
 
		$id = $this->input->post('id');
		
		if($this->form_validation->run() == false)
		{
	    	$data['bk'] = $this->Mbmenu->get_bkcp_by_id($id)->row();
	        
	        $this->load-view('bmenu/delbk', $data);
		}
		else
		{
			$data['ckreason'] = $this->input->post('ckreason');
			$data['date'] = mdate("%Y/%m/%d %h:%i:%s");
			
			$res = $this->Mbmenu->edit_bkcp_ck($id, $data);
			
			if($res)
		    {
		    	showmessage('���ز����ɹ�,��ȴ����!', 'bmenu/bkfind');
		    }
		    else 
		    {
		        showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'bmenu/bkfind');
		    }
		}
	}
	
	//�������
	function edit_bk_cksh()
	{
		$data['user'] = $this->session->userdata('DX_username');
		
		$id = $this->uri->segment(3);
		
		$res = $this->Mbmenu->edit_bkcp_cksh($id, $data);
		
		if($res)
	    {
    	    showmessage('������˳ɹ�!', 'bmenu/bkfind');
		}
	    else 
		{
            showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'bmenu/bkfind');
		}
		
	}
	
	//����
	function edit_bk_bk()
	{
		$data['user'] = $this->session->userdata('DX_username');
		
		$id = $this->uri->segment(3);
		
		$res = $this->Mbmenu->edit_bkcp_bk($id, $data);
		
		if($res)
	    {
    	    showmessage('�˳��ѽ��벼��״̬!', 'bmenu/bkfind');
		}
	    else 
		{
            showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'bmenu/bkfind');
		}
	}
	
	//�༭������Ϣ
	function edit_bk_info()
	{   
		$data['id'] = $this->uri->segment(3);
	
		$data['bkinfo'] = $this->Mbmenu->get_bkcp_by_id($data['id'])->row();
	    //������ɫ
	    $data['color'] = $this->color;
	    //����ԭ��
	    $data['reason'] = $this->reason2;
	    
	    $data['ck_right'] = $this->_check_right();
	    
		$this->load->view('bmenu/editbk', $data);
	}
	
	//�ύ�༭������Ϣ��
	function edit_bk_info_ok()
	{  
		$id = $this->input->post('id');
		 
		$this->form_validation->set_rules('carnum', '���ƺ���', 'trim|required|xss_clean|max_length[20]|callback_bk_carnum_check[' . $id . ']');
		$this->form_validation->set_rules('cartype', '��������', 'trim|xss_clean|max_length[16]');
		$this->form_validation->set_rules('linkman', '������ϵ��', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('telnum', '���ص�λֵ��绰����', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('bktype', '��������', 'trim|xss_clean|max_length[20]');
		$this->form_validation->set_rules('introduction', '������', 'trim|xss_clean|max_length[200]');
		$this->form_validation->set_rules('mobiles', '�ֻ���', 'trim|xss_clean|max_length[800]');
		
		$this->form_validation->set_message('max_length', '�ַ������λ��.');
		$this->form_validation->set_message('required', '����Ϊ��.');
		$this->form_validation->set_message('is_unique', '%s�Ѿ�����.' );
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$data['ck_right'] = $this->_check_right();
		if($this->form_validation->run() == false)
		{
			$data['bkinfo'] = $this->Mbmenu->get_bkcp_by_id($id)->row();
			$data['id'] = $id;
		    //������ɫ
		    $data['color'] = $this->color;
		    //����ԭ��
		    $data['reason'] = $this->reason2;
	    	
		    $this->load->view('bmenu/editbk', $data);
		}
		else
		{
			$data['carnum'] = $this->input->post('carnum');
			$data['carnum'] = str_replace('?', '_', $data['carnum']);
            $data['carnum'] = str_replace('��', '_', $data['carnum']);
            			
			$data['color']   = $this->input->post('color');
			$data['cartype'] = $this->input->post('cartype');
			$data['linkman'] = $this->input->post('linkman');
			$data['mobnum']  = $this->input->post('mobnum');
			$data['telnum']  = $this->input->post('telnum');
			$data['bktype']  = $this->input->post('bktype');
			$data['bkdepartment'] = $this->input->post('bkdepartment');
			$data['memo']    = $this->input->post('introduction');
			$data['lsbk']    = $this->input->post('lsbk') == True? 'T':'F';
			$data['mobiles'] = $this->input->post('mobiles');
			$data['reason']  = $this->input->post('reason');
			$data['bkdate']  = $this->input->post('starttime');
			$data['bclen']   = $this->input->post('endtime');
			
			$res = $this->Mbmenu->edit_bk_info($id, $data);
			
		    if($res)
		    {
		    	showmessage('������Ϣ�޸ĳɹ�', 'bmenu/bkfind');
		    }
		    else 
		    {
		        showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'bmenu/bkfind');
		    }
		}
	}
	
	//ɾ������
	function del_bk()
	{
		$id = $this->uri->segment(3);
		
		$res = $this->Mbmenu->del_bkcp($id);
		
		if($res)
	    {
    	    showmessage('ɾ���ɹ�!', 'bmenu/bkfind');
		}
	    else 
		{
            showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'bmenu/bkfind');
		}
	}
	
	
	//�ص�������鲼�س������ƺ��Ƿ��ظ�
	function bk_carnum_check($carnum,$id)
	{
		$carnum = str_replace('?', '_', $carnum);
        $carnum = str_replace('��', '_', $carnum);
        
        $result = $this->Mbmenu->check_carnum_unique($id, $carnum)->num_rows() == 0;
          		
		if (! $result)
		{
			$this->form_validation->set_message('bk_carnum_check', '���س��ƺ��Ѿ�����.');
		}
				
		return $result;
	}
	
	//����û�������Ϣ
	function _add_oplog($name)
	{
			$this->load->model('Mlog');
			
			$data['memo'] = $name . '���غ���:(' . $this->input->get('carnum'). ').';
		    $data['memo'] = $data['memo'] . '������:(' . $this->input->get('bkr'). ')';
			$data['memo'] = $data['memo'] . '����ԭ��:(' .$this->input->get('reason'). ')';
			$data['memo'] = $data['memo'] . '״̬:(' .$this->input->get('state'). ')';
			
			$data['czsj']     = mdate("%Y-%m-%d %H:%i:%s");
			$data['uname']    = $this->session->userdata('DX_username');
			$data['uip']      = $this->session->userdata('ip_address');
			$data['disabled'] = 0;
			
			$this->Mlog->add_userlog($data);
	}
	
	//�ж��Ƿ��г���Ȩ��
	function _check_right()
	{
		if($this->session->userdata('DX_role_id') == 1 or in_array(44,$this->session->userdata('DX_role_right')))
		{
			return 1;
		}
		else{
			return 0;
		}
	}
}
