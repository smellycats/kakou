<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ������������
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Dxa extends Admin_Controller
{
	//����
	protected $lane = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');
	//����
	protected $direction = array('����', '����', '�ɶ�����', '��������', '��������', '�ɱ�����');
	//���ƺ���
	protected $number = array('R','?','-','WJ','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','³','ԥ','��','��','��','��','��','��','��','��','��','��','��','��','��','̨','��','��','��','��','��','��','��','��','��','��','��','��','��');
	//������ɫ
	protected $color = array('����','����','����','����','����');
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('news');
		$this->load->helper('date');
		$this->load->helper('kakou');    //�Զ���kakou_helper
				
		$this->load->library('DX_Auth');
		$this->load->library('form_validation');
		
		$this->load->model('Mdxa');
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);	
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		othercar();
	}
	
	//���ش�����������ͼ
	function othercar()
	{
		$data['color'] = $this->color;
		//$data[]
		$data['whilelist'] = $this->Mdxa->get_whitelist_all()->result();
		
		$this->load->view('dxa/othercar', $data);
	}
	
	//�������������
	function edit_wl_check()
	{
		$id = $this->uri->segment(3);
		
		$data['check'] = 'T';
		
		$this->Mdxa->edit_whilelist($id, $data);
		
	    $data['color'] = $this->color;
		
	    $data['whilelist'] = $this->Mdxa->get_whitelist_all()->result();
		
	    $this->load->view('dxa/othercar', $data);
	}
	
	//��Ӵ�������
	function add_wl_ok()
	{
		$this->form_validation->set_rules('carnum', '���ƺ���', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('color', '������ɫ', 'trim|required|xss_clean');
		$this->form_validation->set_message('max_length', '%s���Ȳ��ܳ���20λ.');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		if($this->form_validation->run() == false)
		{
		    $data['color'] = $this->color;
		
		    $data['whilelist'] = $this->Mdxa->get_whitelist_all()->result();
		
	    	$this->load->view('dxa/othercar', $data);
		}
		else
		{
			$data['carnum'] = $this->input->post('carnum');
			$data['color']  = $this->input->post('color');
			
		    $res = $this->Mdxa->add_wl($data);
		    
			if ($res)
			{
				showmessage('��Ӵ������ɹ�', 'dxa/othercar');
			}
			else
			{
				showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'dxa/othercar');
			}
		}
	}
	
	function find_wl()
	{
		$this->form_validation->set_rules('find_carnum', '���ƺ���', 'trim|xss_clean|max_length[10]');
		$this->form_validation->set_message('max_length', '%s���Ȳ��ܳ���10λ.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$carnum = $this->input->post('find_carnum');
		
		if($this->form_validation->run() == false || $carnum=='')
		{
		    $data['color'] = $this->color;
		
		    $data['whilelist'] = $this->Mdxa->get_whitelist_all()->result();
		
	    	$this->load->view('dxa/othercar', $data);
		}
		else
		{
			$data['carnum'] = $carnum;
			
			$data['whilelist'] = $this->Mdxa->find_wl_by_carnum($data)->result();
			
		    $data['color'] = $this->color;
		    
		    $this->load->view('dxa/othercar', $data);
		    
		}
	}
	
	//���ش�������ѯ��ͼ
	function ocquery()
	{
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
		//����
		$data['lane'] = $this->lane;
		//����
		$data['direction'] = $this->direction;
		//���ƺ���
		$data['number'] = $this->number;
		//������ɫ
		$data['color'] = $this->color;
		
		$data['sel_type_alias'] = 'all';
		$data['sel_lane'] = 'all';
		$data['sel_direction'] = 'all';
		$data['sel_color'] = 'all';
		$data['sel_number'] = '��';
		$pastdate = strtotime("-2 hours");
        //$data['sel_starttime'] = mdate("%Y/%m/%d %h:%i:%s",$pastdate);
        $data['sel_starttime'] = date('Y/n/j G:i:s',$pastdate);
        $data['sel_endtime'] = date('Y/n/j G:i:s',time());
        //$data['sel_endtime'] = mdate("%Y/%m/%d %h:%i:%s");
        //$data['sel_spcarnum'] = '';
        
		$okkval = implode(",",$data['okkval']);
		
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		//$data['car'] = $this->Mgate->get_car_all($offset, $row_count)->result();
		//$data['alarm_point'] = $this->Msyst->get_alarmpoint_all(0, 0)->result();
		
		$data['row_count'] = $row_count;
		$data['offset']    = $offset;
		
		$config['base_url'] = site_url('dxa/ocquery/');
		//$config['total_rows'] = $this->Mgate->get_car_all()->row()->SUM;
		$config['per_page'] = $row_count;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '��һҳ';
		$config['last_link'] = 'βҳ';
		$config['next_link'] = '��һҳ';
		$config['prev_link'] = '��һҳ';

		$this->pagination->initialize($config);

		$this->load->view('dxa/ocquery', $data);
	}
	
    //������������ѯ��
    function ocquery_ok()
    {
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
		
		$data['lane'] = $this->lane;           //����
		$data['direction'] = $this->direction; //����
		$data['number'] = $this->number;       //���ƺ���
		$data['color'] = $this->color;         //������ɫ
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //��ص�����
		
		$per_page   = $this->input->get('per_page');      //ҳ��ƫ����
		
		if($role_id == '1')
		{
			$da['okkval'] = '';
		}
		elseif ($data['sel_type_alias'] == 'all')
		{
			$da['okkval'] = implode(",",$data['okkval']);
		}else 
		{
			$da['okkval'] = "'" . $data['sel_type_alias'] . "'";
		}
		
		$da['lane'] = $this->input->get('lane');           //����
		$data['sel_lane'] = $da['lane'];
		$da['direction'] = $this->input->get('direction'); //����
        $data['sel_direction'] = $da['direction'];
		$da['color'] = $this->input->get('color');         //��ɫ
        $data['sel_color'] = $da['color'];
        
        $da['number'] = $this->input->get('number');       //���Ʊ��
        $data['sel_number'] =$da['number'];
        $da['carnum'] = trim($this->input->get('carnum')); //���ƺ���
        $data['sel_carnum'] =$da['carnum'];
        
    
        $da['starttime'] = $this->input->get('starttime');   //��ʼʱ��
        $data['sel_starttime'] = $da['starttime'];
        $da['endtime'] = $this->input->get('endtime');     //����ʱ��
        $data['sel_endtime'] = $da['endtime'];
        		
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($per_page == '' ? '0' : $per_page);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['car'] = $this->Mdxa->get_dxa_by_condition($offset, $row_count, $da)->result();
		$data['total_rows']  = $this->Mdxa->get_dxa_by_condition(0,0,$da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		$data['offset']      = $offset;
			
		$config['base_url'] = site_url() . "/dxa/ocquery_ok/?type_alias=$data[sel_type_alias]&lane=$da[lane]&direction=$da[direction]&color=$da[color]&number=$da[number]&carnum=$da[carnum]&starttime=$da[starttime]&endtime=$da[endtime]";
		$config['total_rows'] = $this->Mdxa->get_dxa_by_condition(0,0,$da)->row()->SUM;
		$config['per_page'] = $row_count;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment']='per_page';
		//$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '��һҳ';
		$config['last_link'] = 'βҳ';
		$config['next_link'] = '��һҳ';
		$config['prev_link'] = '��һҳ';

		$this->pagination->initialize($config);

		$this->load->view('dxa/ocquery', $data);
		
    }
    
    //ɾ�����������ó���
    function del_wl_set()
    {
    	$id = $this->uri->segment(3);
    	
    	$res = $this->Mdxa->del_whilelist_by_id($id);
    	
    	if ($res)
		{
			showmessage('ɾ��������������Ϣ�ɹ�', 'dxa/othercar');
		}
		else
		{
			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', 'dxa/othercar');
	    }
    }
    
	function wl_showdetail()
	{
		$id = $this->uri->segment(3);

		//$data['cartype']   = $this->cartype;                             //��ó�������                                   
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['color']     = $this->color;    
		$data['cardetail'] = $this->Mdxa->get_dxa_by_id($id)->row();
		$data['pic_url']   = get_picurl($data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
		$this->load->view('dxa/wl_showdetail', $data);
	}
    
	//����Ȩ�޻�� ·�ڲ�����Ϣ 
    function _get_openkakou_by_perm($role_id)
    {
		$this->load->model('Msyst');
		$this->load->model('Muser');
		
		if($role_id == '1') //�ж��Ƿ����Ա������Ա������·�ڲ���Ȩ��
		{
		    $sys['type_name']  = '��������';
		    $sys['type_value'] = '';
		    
		    //$openkakou = $this->Msyst->get_config_inof_typealias($sys)->result();
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
		    foreach ($openkakou as $id=>$kakou)
		    {
		    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    	$data['okkval'][$id] = "'" . $kakou->TYPE_VALUE . "'";
		    }
		}
		else  //�ǹ���Ա�û� Ҫ�ж�Ȩ��
		{
		    $openkakou = $this->Muser->get_role_by_id($role_id)->openkakou;
		    
		    //�����л����ַ���ת��������
		    $openkakou = explode(',', $openkakou);
		    
		    foreach ($openkakou as $id=>$kakou)
		    {
		    	$data['openkakou'][$id] = $this->Msyst->get_config_info_by_id($kakou)->row()->TYPE_ALIAS;
		    	
		    	$data['okkval'][$id] = "'" . $this->Msyst->get_config_info_by_id($kakou)->row()->TYPE_VALUE . "'";
		    }
		}
		
		return $data;	
    }
	
}
