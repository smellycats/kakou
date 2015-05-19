<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou �ΰ����ڹ��������
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Gate extends Admin_Controller
{
	//����
	protected $lane = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');
	//����
	protected $direction = array('����', '����', '�ɶ�����', '��������', '��������', '�ɱ�����');
	//���ƺ���
	protected $number = array('R','?','-','WJ','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','³','ԥ','��','��','��','��','��','��','��','��','��','��','��','��','��','̨','��','��','��','��','��','��','��','��','��','��','��','��','��');
	//��������
    protected $alarmtype = array('����������','���Ƴ���','�������ɳ���','���س���');
    //Υ������
    protected $breakrule = array('����','����','�����','����������ʻ');
    
    protected $record = array('�Ѻ˶�', '�����','�Ѵ���');
    //����״̬
    protected $dispose = array('����δ����','���ƺ���ʶ�����','������ɫʶ�����','ͼ����','���´�','���´�','δ�ػ�','�ѽػ�','��񱻵�����','������Ƴ�','���ͨΥ����','����������ݲ���');
	
    protected $dispose2 = array('01'=>'����δ����',
								'02'=>'���ƺ���ʶ�����',
								'03'=>'������ɫʶ�����',
								'04'=>'ͼ����',
								'05'=>'���´�',
								'06'=>'���´�',
								'07'=>'δ�ػ�',
								'08'=>'�ѽػ�',
								'09'=>'��񱻵�����',
								'10'=>'������Ƴ�',
								'11'=>'���ͨΥ����',
								'12'=>'����������ݲ���'
								);
    //������ɫ
	protected $color = array('����','����','����','����','����');
	
	protected $msg1 = '��ѡ���ѯ����.';
	
	protected $msg2 = 'û�г�����¼��';
	
	protected $imgpath = array();
	
	//protected $imgpath = array('HDWJ-KKDATA1'=>'localhost:8082','HDWJ-KKDATA2'=>'localhost:8082',''=>'192.168.10.234:81');
	
	//protected $path = 'D:\SpreadData/';
	//ͼƬ������������
	//protected $imgs_num = 400;
	
	//��������
	protected $cartype = array(  '01' => '01:������������',
		                         '02' => '02:С����������',
		                         '03' => '03:ʹ����������',
		                         '04' => '04:�����������',
		                         '05' => '05:������������',
		                         '06' => '06:�⼮��������',
		                         '07' => '07:��������Ħ�к���', 
		                         '08' => '08:���Ħ�г�����',
		                         '09' => '09:ʹ��Ħ�г�����',
		                         '10' => '10:���Ħ�г�����',
		                         '11' => '11:����Ħ�г�����',
		                         '12' => '12:�⼮Ħ�г�����',
		                         '13' => '13:ũ�����䳵����',
		                         '14' => '14:����������',
		                         '15' => '15:�ҳ�����',
		                         '16' => '16:������������',
		                         '17' => '17:����Ħ�г�����',
		                         '18' => '18:������������',
		                         '19' => '19:����Ħ�г�����',
		                         '20' => '20:��ʱ�뾳��������',
		                         '21' => '21:��ʱ�뾳Ħ�г�����',
		                         '22' => '22:��ʱ��ʹ������',
		                         '23' => '23:������������',
		                         '24' => '24:����Ħ�к���',
		                         '99' => '99:��������',
		                         );
		
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('news');     //�Զ���news_helper
		$this->load->helper('kakou');    //�Զ���kakou_helper
		
		$this->load->library('DX_Auth');
		$this->load->library('form_validation');

		$this->load->model('Mgate');
		$this->load->model('Msyst');
		$this->load->model('Muser');
		
		$this->load->config('kakou');
						
		if (substr($this->session->userdata('ip_address'),0,3)=='192')
		{
			$this->imgpath = array('HDWJ-KKDATA1'=>'192.168.10.234:8888','HDWJ-KKDATA2'=>'192.168.10.235:8888',''=>'192.168.10.234:8888');
		}else {
			$this->imgpath = array('HDWJ-KKDATA1'=>'10.44.249.227:81','HDWJ-KKDATA2'=>'10.44.249.227:82',''=>'10.44.249.227:81');
		}
	}
	
	//���س�����ѯ��ͼ
	function carquery()
	{	
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;

		$data['lane']      = $this->lane;              //����
		$data['direction'] = $this->direction;         //����
		$data['number']    = $this->number;            //���ƺ���
		$data['color']     = $this->color;             //������ɫ
		$data['message']   = $this->msg1;
		
		$data['sel_carnum'] = '';
		$data['sel_type_alias'] = 'all';
		$data['sel_lane'] = 'all';
		$data['sel_direction'] = 'all';
		$data['sel_color'] = 'all';
		$data['sel_number'] = '?';
		$pastdate = strtotime("-2 hours");
        $data['sel_starttime'] = mdate("%Y-%m-%d %H:%i:%s",$pastdate);
        $data['sel_endtime'] = mdate("%Y-%m-%d %H:%i:%s");
        $data['sel_spcarnum'] = '';
        
		$okkval = implode(',',$data['okkval']);
		
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
		
		$config['base_url'] = site_url('gate/carquery/');
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

		$this->load->view('gate/carquery', $data);
	}
	
    //������ѯ��
    function carquery_ok()
    {
    	$this->_add_oplog('������ѯ.', 0);
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		//$data['last_query'] = $this->db->last_query();

		$data['role_id'] = $role_id;
		$data['lane']    = $this->lane;              //����
		$data['direction'] = $this->direction;    //����
		$data['number']    = $this->number;          //���ƺ���
		$data['color']     = $this->color;            //������ɫ
		$data['message']   = $this->msg2;
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //��ص�����
		
		$per_page = $this->input->get('per_page');      //ҳ��ƫ����
		
		if ($this->input->get('type_alias') == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else
		{
			$da['okkval'] = "'" . $this->input->get('type_alias') . "'";
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
        
        $data['sel_spcarnum'] = $this->input->get('spcarnum');
        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = str_replace('��', ',', $this->input->get('spcarnum'));
        	//$spcarnum = str_replace(' ', ',', $spcarnum);
        	$spcarnum = explode(",", $spcarnum);   //���⳵�ƺ�
            foreach ($spcarnum as $id=>$sp)
            {
            	$trim_sp = trim($sp);
        	    $da['sp'][$id] = "'" . $trim_sp . "'";
            }
            $da['spcarnum'] = implode(",",$da['sp']);
        }
        else 
        {
            $da['spcarnum'] = '';
        }
    
        $da['starttime'] = $this->input->get('starttime');   //��ʼʱ��
        $data['sel_starttime'] = $da['starttime'];
        $da['endtime'] = $this->input->get('endtime');       //����ʱ��
        $data['sel_endtime'] = $da['endtime'];
        
        //�滻�ַ���
        		
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($per_page == '' ? '0' : $per_page);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['car']         = $this->Mgate->get_car_by_condition($offset, $row_count, $da)->result();
		$data['total_rows']  = $this->Mgate->get_car_by_condition(0,0,$da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		$data['offset']      = $offset;
		$data['download_ip'] = $this->config->item('kakou_download_ip');
		$data['xls_num']     = $this->config->item('kakou_xls_num');
		$data['img_num']     = $this->config->item('kakou_img_num');
	
		$config['base_url'] = site_url() . "/gate/carquery_ok/?type_alias=$data[sel_type_alias]&lane=$da[lane]&direction=$da[direction]&color=$da[color]&number=$da[number]&carnum=$da[carnum]&starttime=$da[starttime]&endtime=$da[endtime]&spcarnum=$data[sel_spcarnum]";
		$config['total_rows'] = $data['total_rows'];
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

		$car_id = array();
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
		
		//�Ѳ�ѯ�õ��ĳ���id(20��)����������ӵ�session
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);
        
		$this->load->view('gate/carquery', $data);
		
    }

    //����Ȩ�޻�� ·�ڲ�����Ϣ 
    function _get_openkakou_by_perm2($role_id)
    {    
		$openkakou_all = $this->Msyst->get_config_kakou($sys)->result();
		
    	foreach ($openkakou_all as $id=>$kakou)
		{
		    $openkakou_all_to_arr[$id] = $kakou->ID;
		}
		
		$data = null;
		
		if($role_id == '1') //�ж��Ƿ����Ա������Ա������·�ڲ���Ȩ��
		{
		    foreach ($openkakou_all as $id=>$kakou)
		    {
		    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    	$data['okkval'][$id] = $kakou->TYPE_VALUE;
		    }
		}
		else  //�ǹ���Ա�û� Ҫ�ж�Ȩ��
		{
		    $openkakou_str = $this->Muser->get_role_by_id($role_id)->openkakou;
		    
		    if ($openkakou_str == '0' or $openkakou_str == '') {
		    	$data['openkakou'][0] = '';
		    	$data['okkval'][0] = '';
		    }else {
			    //�����л����ַ���ת��������
			    $openkakou_to_arr = explode(',', $openkakou_str);
			    //��Ȩ�޿��ں����п��ڵĽ���
			    //$openkakou = array_intersect($openkakou_to_arr,$openkakou_all_to_arr);
			    foreach ($openkakou_to_arr as $id=>$kakou)
			    {
			    	$data['openkakou'][$id] = $this->Msyst->get_config_info_by_id($kakou)->row()->TYPE_ALIAS;
			    	
			    	$data['okkval'][$id] = $this->Msyst->get_config_info_by_id($kakou)->row()->TYPE_VALUE;
			    }
			}
		}
		
		return $data;	
    }
    
    //����Ȩ�޻�� ·�ڲ�����Ϣ 
    function _get_openkakou_by_perm($role_id)
    {

		$sys['type_name']  = '��������';
		$sys['type_value'] = '';
		    
		$openkakou_all = $this->Msyst->get_config_info($sys)->result();
		
    	foreach ($openkakou_all as $id=>$kakou)
		{
		    $openkakou_all_to_arr[$id] = $kakou->ID;
		}
		
		$data = null;
		
		if($role_id == '1') //�ж��Ƿ����Ա������Ա������·�ڲ���Ȩ��
		{
		    foreach ($openkakou_all as $id=>$kakou)
		    {
		    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    	$data['okkval'][$id] = $kakou->TYPE_VALUE;
		    }
		}
		else  //�ǹ���Ա�û� Ҫ�ж�Ȩ��
		{
		    $openkakou_str = $this->Muser->get_role_by_id($role_id)->openkakou;
		    
		    if ($openkakou_str == '0' or $openkakou_str == '') {
		    	$data['openkakou'][0] = '';
		    	$data['okkval'][0] = '';
		    }else {
			    //�����л����ַ���ת��������
			    $openkakou_to_arr = explode(',', $openkakou_str);
			    //��Ȩ�޿��ں����п��ڵĽ���
			    //$openkakou = array_intersect($openkakou_to_arr,$openkakou_all_to_arr);
			    foreach ($openkakou_to_arr as $id=>$kakou)
			    {
			    	$data['openkakou'][$id] = $this->Msyst->get_config_info_by_id($kakou)->row()->TYPE_ALIAS;
			    	
			    	$data['okkval'][$id] = $this->Msyst->get_config_info_by_id($kakou)->row()->TYPE_VALUE;
			    }
			}
		}
		
		return $data;	
    }
	
	//���Բ�ѯ
	function slquery()
	{
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['lane'] = $this->lane;              //����
		$data['direction'] = $this->direction;    //����
		$data['number'] = $this->number;          //���ƺ���
		$data['color'] = $this->color;            //������ɫ
		$data['message'] = $this->msg1;
		
		$data['sel_type_alias'] = 'all';
		$data['sel_lane'] = 'all';
		$data['sel_direction'] = 'all';
		$data['sel_color'] = 'all';
		$data['sel_number'] = '?';
		$data['sel_carnum'] = '';
		$pastdate = strtotime("-2 hours");
        $data['sel_starttime'] = mdate("%Y-%m-%d %H:%i:%s",$pastdate);
        $data['sel_endtime'] = mdate("%Y-%m-%d %H:%i:%s");
        $data['sel_spcarnum'] = '';
        
        $data['img_base_url'] = $this->config->item('kakou_img_base_url');
		$data['imgpath'] = $this->imgpath;

		$okkval = implode(',',$data['okkval']);
		
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
		
		$config['base_url'] = site_url('gate/slquery/');
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

		$this->load->view('gate/slquery', $data);
	}
	
	function slquery_ok()
	{
		$this->_add_oplog('������ѯ.', 0);
		
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
		$data['lane'] = $this->lane;              //����
		$data['direction'] = $this->direction;    //����
		$data['number'] = $this->number;          //���ƺ���
		$data['color'] = $this->color;            //������ɫ
		$data['message'] = $this->msg2;
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //��ص�����
		
		$per_page   = $this->input->get('per_page');      //ҳ��ƫ����
		
		if ($this->input->get('type_alias') == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else
		{
			$da['okkval'] = "'" . $this->input->get('type_alias') . "'";
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
        $data['sel_spcarnum'] = $this->input->get('spcarnum');
        
        $data['img_base_url'] = $this->config->item('kakou_img_base_url');
		$data['xls_num']     = $this->config->item('kakou_xls_num');
		$data['img_num']     = $this->config->item('kakou_img_num');
		        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = explode(",", $this->input->get('spcarnum'));   //���⳵�ƺ�
            foreach ($spcarnum as $id=>$sp)
            {
        	    $da['sp'][$id] = "'" . $sp . "'";
            }
            $da['spcarnum'] = implode(",",$da['sp']);
        }
        else 
        {
            $da['spcarnum'] = '';
        }
    
        $da['starttime'] = $this->input->get('starttime');   //��ʼʱ��
        $data['sel_starttime'] = $this->input->get('starttime');
        $da['endtime'] = $this->input->get('endtime');       //����ʱ��
        $data['sel_endtime'] = $this->input->get('endtime');
        
        //�滻�ַ���
        		
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($per_page == '' ? '0' : $per_page);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		
		//����������ȡ������Ϣ
		$data['car'] = $this->Mgate->get_car_by_condition($offset, $row_count, $da)->result();
		$data['total_rows'] = $this->Mgate->get_car_by_condition(0,0,$da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		$data['offset'] = $offset;
		$data['download_ip'] = $this->config->item('kakou_download_ip');
		$data['imgpath'] = $this->imgpath;
		
		$config['base_url'] = site_url() . "/gate/slquery_ok/?type_alias=$data[sel_type_alias]&lane=$da[lane]&direction=$da[direction]&color=$da[color]&number=$da[number]&carnum=$da[carnum]&starttime=$da[starttime]&endtime=$da[endtime]&spcarnum=$data[sel_spcarnum]";
		$config['total_rows'] = $this->Mgate->get_car_by_condition(0,0,$da)->row()->SUM;
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

		$car_id = array();
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
		
		//�Ѳ�ѯ�õ��ĳ���id(20��)����������ӵ�session
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);
        
		$this->load->view('gate/slquery', $data);
				
	}
	
	
	//Υ����ѯ
	function wzquery()
	{	
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);

		$data['record'] = $this->record;                  //��¼״̬
		$data['breakrule'] = $this->breakrule;            //Υ������
		$data['number'] = $this->number;                  //���ƺ���
		$data['color'] = $this->color;                    //������ɫ
		$data['message'] = $this->msg1;
		
		$data['sel_type_alias'] = 'all';
		$data['sel_record'] = 'all';
		$data['sel_breakrule'] = 'all';
		$data['sel_color'] = 'all';
		$data['sel_number'] = '?';
		$data['sel_carnum'] = '';
		$pastdate = strtotime("-2 hours");
        $data['sel_starttime'] = mdate("%Y-%m-%d %H:%i:%s",$pastdate);
        $data['sel_endtime'] = mdate("%Y-%m-%d %H:%i:%s");
        $data['sel_endtime'] = mdate("%Y-%m-%d %H:%i:%s");
        $data['sel_minspeed'] = '';
        $data['sel_maxspeed'] = '';
        $data['sel_spcarnum'] = '';
        
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
		
		$config['base_url'] = site_url('gate/wzquery/');
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

		$this->load->view('gate/wzquery', $data);
	}
	
	function wzquery_ok()
	{
		$this->_add_oplog('Υ��������ѯ.', 1);
		
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
		$data['record']    = $this->record;               //��¼״̬
		$data['breakrule'] = $this->breakrule;             //Υ������
		$data['number']    = $this->number;                 //���ƺ���
		$data['color']     = $this->color;                   //������ɫ
		$data['message']   = $this->msg2;
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //��ص�����
		
		$per_page = $this->input->get('per_page');      //ҳ��ƫ����
		
		if ($this->input->get('type_alias') == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else
		{
			$da['okkval'] = "'" . $this->input->get('type_alias') . "'";
		}
		
		$da['record'] = $this->input->get('record');       //����
		$data['sel_record'] = $da['record'];
		$da['breakrule'] = $this->input->get('breakrule'); //����
        $data['sel_breakrule'] = $da['breakrule'];
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
        $da['minspeed'] = $this->input->get('minspeed');     //��С�ٶ�
        $data['sel_minspeed'] = $da['minspeed']; 
        $da['maxspeed'] = $this->input->get('maxspeed');     //����ٶ�
        $data['sel_maxspeed'] = $da['maxspeed'];
                
        //�滻�ַ���
        		
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($per_page == '' ? '0' : $per_page);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['car']         = $this->Mgate->get_breakrule_by_condition($offset, $row_count, $da)->result();
		$data['total_rows']  = $this->Mgate->get_breakrule_by_condition(0,0,$da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		$data['offset']      = $offset;
		$data['download_ip'] = $this->config->item('kakou_download_ip');
		$data['xls_num']     = $this->config->item('kakou_xls_num');
		$data['img_num']     = $this->config->item('kakou_img_num');
					
		$config['base_url'] = site_url() . "/gate/wzquery_ok/?type_alias=$data[sel_type_alias]&record=$da[record]&breakrule=$da[breakrule]&color=$da[color]&number=$da[number]&carnum=$da[carnum]&starttime=$da[starttime]&endtime=$da[endtime]&minspeed=$da[minspeed]&maxspeed=$da[maxspeed]";
		$config['total_rows'] = $data['total_rows'];
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
		
		$car_id = array();
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
		
		//�Ѳ�ѯ�õ��ĳ���id(20��)����������ӵ�session
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);

		$this->load->view('gate/wzquery', $data);
				
	}
	
	
	
	//����������ѯ
	function bjquery()
	{		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);

        $data['alarmtype'] = $this->alarmtype;          //��������
        $data['dispose']   = $this->dispose;            //����״̬
		$data['number']    = $this->number;             //���ƺ���
		$data['color']     = $this->color;              //������ɫ
		
		$data['sel_type_alias'] = 'all';
		$data['sel_alarmtype'] = 'all';
		$data['sel_dispose'] = 'all';
		$data['sel_color'] = 'all';
		$data['sel_number'] = '?';
		$data['sel_carnum'] = '';
		$pastdate = strtotime("-2 hours");
        $data['sel_starttime'] = mdate("%Y-%m-%d %H:%i:%s",$pastdate);
        $data['sel_endtime'] = mdate("%Y-%m-%d %H:%i:%s");
        $data['message'] = $this->msg1;
        
		$okkval = implode(',',$data['okkval']);
		
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
		
		$config['base_url'] = site_url('gate/bjquery/');
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

		$this->load->view('gate/bjquery', $data);
	}
	
	function bjquery_ok()
	{
		$this->_add_oplog('����������ѯ.', 2);
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
        $data['alarmtype'] = $this->alarmtype;          //��������
        $data['dispose']   = $this->dispose;            //����״̬
		$data['number']    = $this->number;             //���ƺ���
		$data['color']     = $this->color;              //������ɫ
		$data['message']   = $this->msg2;
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //��ص�����
		
		$per_page   = $this->input->get('per_page');      //ҳ��ƫ����
		
/*		if($role_id == '1')
		{
			$da['okkval'] = '';
		}*/
		if ($data['sel_type_alias'] == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else 
		{
			$da['okkval'] = "'" . $data['sel_type_alias'] . "'";
		}
		
		$da['alarmtype'] = $this->input->get('alarmtype');       //��������
		$data['sel_alarmtype'] = $da['alarmtype'];
		$da['dispose'] = $this->input->get('dispose');           //����״̬
        $data['sel_dispose'] = $da['dispose'];
		$da['color'] = $this->input->get('color');               //��ɫ
        $data['sel_color'] = $da['color'];
        
        $da['number'] = $this->input->get('number');       //���Ʊ��
        $data['sel_number'] =$da['number'];
        $da['carnum'] = trim($this->input->get('carnum')); //���ƺ���
        $data['sel_carnum'] =$da['carnum'];
    
        $da['starttime']     = $this->input->get('starttime');   //��ʼʱ��
        $data['sel_starttime'] = $da['starttime'];
        $da['endtime']       = $this->input->get('endtime');     //����ʱ��
        $data['sel_endtime'] = $da['endtime'];
                
        //�滻�ַ���  		
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($per_page == '' ? '0' : $per_page);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['car']         = $this->Mgate->get_alarmcar_by_condition($offset, $row_count, $da)->result();
		$data['total_rows']  = $this->Mgate->get_alarmcar_by_condition(0,0,$da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		$data['offset']      = $offset;
		$data['download_ip'] = $this->config->item('kakou_download_ip');
		$data['xls_num']     = $this->config->item('kakou_xls_num');
		$data['img_num']     = $this->config->item('kakou_img_num');
			
		$config['base_url'] = site_url() . "/gate/bjquery_ok/?type_alias=$data[sel_type_alias]&dispose=$da[dispose]&alarmtype=$da[alarmtype]&color=$da[color]&number=$da[number]&carnum=$da[carnum]&starttime=$da[starttime]&endtime=$da[endtime]";
		$config['total_rows'] = $data['total_rows'];
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
		
		$car_id = array();
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
		
		//�Ѳ�ѯ�õ��ĳ���id(20��)����������ӵ�session
		
		$data['carnum'] = array();
		foreach ($data['car'] as $c)
		{
			if (in_array($c->HPHM,$data['carnum']) == False)
			{
				$bcxw =  $this->Mgate->get_bcxw($c->HPHM)->row();
				$data['carnum'][$c->HPHM] = $bcxw==null?'':$bcxw->BCXW;
			}
		}

        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);
        
		$this->load->view('gate/bjquery', $data);
						
	}
	
	function showdetail2()
	{
		$id = $this->uri->segment(3);

		$data['cartype']   = $this->cartype;                             //��ó�������                                   
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['color']     = $this->color;
		$data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		//$data['pic_url']   = get_picurl($data['cardetail']->QMTP, $data['cardetail']->TJTP);
		$data['pic_url']   = get_picurl($this->config->item('kakou_img_base_url'), $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
		$this->load->view('gate/showdetail', $data);
	}
	
	//���Գ���ͨ����Ϣ
	//2013-7-24
	//function slshowdetail2()
/*	{
		$id = $this->uri->segment(3);

		$data['cartype']   = $this->cartype;                             //��ó�������                                   
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['color']     = $this->color;    
		$data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		$data['pic_url']   = get_picurl($this->config->item('kakou_img_base_url'), $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
		$this->load->view('gate/slshowdetail', $data);
	}*/
	
	function showdetail()
	{
	    $data = $this->input->get(NULL,True);
	    
	    if($data['rownum']!=1 AND $data['rownum'] <= $this->session->userdata('total_rows'))
	    {
	    	$data['per_page'] = $data['rownum']%20 == 0 ? ($data['rownum'] - 20) : ($data['rownum'] - $data['rownum']%20);
	    	
	    	$this->_get_car_data($data);
	    }
/*	    elseif($data['rownum']%20 == 0)
	    {
	    	$data['per_page'] -=20;
	    	$this->_get_car_data($data);
	    }*/
	    
	    $car_ids = $this->session->userdata('car_ids');
	    $id = $car_ids[$data['rownum']];
	    
	    $data['per_page'] == '' ? '0' : $data['per_page'];
		$data['option_cartype']   = $this->cartype;                             //��ó�������                                   
		$data['role_id']          = $this->session->userdata('DX_role_id');
		$data['option_color']     = $this->color;
		$data['cardetail']        = $this->Mgate->get_car_by_id($id)->row();
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']          = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
        //����Ƿ��к˶�Ȩ��
		$data['check_right'] = $this->_check_right();
		
		$this->load->view('gate/showdetail', $data);
	}

	function slshowdetail()
	{
	    $data = $this->input->get(NULL,True);
	    
	    if($data['rownum']!=1 AND $data['rownum'] <= $this->session->userdata('total_rows'))
	    {
	    	$data['per_page'] = $data['rownum']%20 == 0 ? ($data['rownum'] - 20) : ($data['rownum'] - $data['rownum']%20);
	    	
	    	$this->_get_car_data($data);
	    }
/*	    elseif($data['rownum']%20 == 0)
	    {
	    	$data['per_page'] -=20;
	    	$this->_get_car_data($data);
	    }*/
	    
	    $car_ids = $this->session->userdata('car_ids');
	    $id = $car_ids[$data['rownum']];
	    
	    $data['per_page'] == '' ? '0' : $data['per_page'];
		$data['option_cartype']   = $this->cartype;                             //��ó�������                                   
		$data['role_id']          = $this->session->userdata('DX_role_id');
		$data['option_color']     = $this->color;
		$data['cardetail']        = $this->Mgate->get_car_by_id($id)->row();
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']          = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
        //����Ƿ��к˶�Ȩ��
		$data['check_right'] = $this->_check_right();
		
		$this->load->view('gate/slshowdetail', $data);
	}
	
	function wz_showdetail2()
	{
		$id = $this->uri->segment(3);
		
		$data['cartype']   = $this->cartype;
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['breakrule'] = $this->breakrule;
		$data['color']     = $this->color;
		$data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		$data['pic_url']   = get_picurl($this->config->item('kakou_img_base_url'), $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
		$this->load->view('gate/wz_showdetail', $data);
	}
	
	function wz_showdetail()
	{
	    $data = $this->input->get(NULL,True);
	    
	    if($data['rownum']!=1 AND $data['rownum'] <= $this->session->userdata('total_rows'))
	    {
	    	$data['per_page'] = $data['rownum']%20 == 0 ? ($data['rownum'] - 20) : ($data['rownum'] - $data['rownum']%20);
	    	
	    	$this->_get_wzcar_data($data);
	    }
/*	    elseif($data['rownum']%20 == 0)
	    {
	    	$data['per_page'] -=20;
	    	$this->_get_car_data($data);
	    }*/
	    
	    $car_ids = $this->session->userdata('car_ids');
	    $id = $car_ids[$data['rownum']];
	    
	    $data['per_page'] == '' ? '0' : $data['per_page'];
		$data['option_cartype']   = $this->cartype;                             //��ó�������                                   
		$data['role_id']          = $this->session->userdata('DX_role_id');
		$data['option_breakrule'] = $this->breakrule;
		$data['option_color']     = $this->color;
		$data['cardetail']        = $this->Mgate->get_car_by_id($id)->row();
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']          = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
        //����Ƿ��к˶�Ȩ��
		$data['check_right'] = $this->_check_right();
				
		$this->load->view('gate/wz_showdetail', $data);
	}
	
	function bj_showdetail2()
	{
		$this->load->model('Mbmenu');
		
		$id = $this->uri->segment(3);
		
		$data['cartype']   = $this->cartype;
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['color']     = $this->color;
		$data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		$data['pic_url']   = get_picurl( $this->config->item('kakou_img_base_url'), $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
		$bm_data['carnum'] = $data['cardetail']->HPHM;
	    $bm_data['color']  = '';
	    $data['bmenu']     = $this->Mbmenu->get_bkcp_by_num($bm_data)->row();
	    
		$this->load->view('gate/bj_showdetail', $data);	
	}
	
	function bj_showdetail()
	{
		$this->load->model('Mbmenu');
		
	    $data = $this->input->get(NULL,True);
	    
	    if($data['rownum']!=1 AND $data['rownum'] <= $this->session->userdata('total_rows'))
	    {
	    	$data['per_page'] = $data['rownum']%20 == 0 ? ($data['rownum'] - 20) : ($data['rownum'] - $data['rownum']%20);
	    	
	    	$this->_get_bjcar_data($data);
	    }
/*	    elseif($data['rownum']%20 == 0)
	    {
	    	$data['per_page'] -=20;
	    	$this->_get_car_data($data);
	    }*/
	    
	    $car_ids = $this->session->userdata('car_ids');
	    $id = $car_ids[$data['rownum']];
	    
	    $data['per_page'] == '' ? '0' : $data['per_page'];
		$data['option_cartype']   = $this->cartype;                             //��ó�������                                   
		$data['role_id']          = $this->session->userdata('DX_role_id');
		$data['option_color']     = $this->color;
		$data['option_dispose']   = $this->dispose2;
		$data['cardetail']        = $this->Mgate->get_car_by_id($id)->row();
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']          = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		$data['sel_dispose']      = '����δ����';
		
		//���ݳ��ƺ����ȡ������������Ϣ
		$bm_data['carnum'] = $data['cardetail']->HPHM;
	    $bm_data['color']  = '';
	    $data['bmenu']     = $this->Mbmenu->get_bkcp_by_num($bm_data)->row();
	    //����Ƿ��к˶�Ȩ��
		$data['check_right'] = $this->_check_right();
			
		$this->load->view('gate/bj_showdetail', $data);
	}
	
	//����˶Թ��ĳ�����Ϣ
    function edit_showdetail()
    {
		$this->form_validation->set_rules('carnum', '���ƺ���', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_message('max_length', '%s���Ȳ��ܳ���20λ.');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		//$this->form_validation->set_message('is_unique', '%s�Ѿ�����.' );
		$this->form_validation->set_error_delimiters('<span>', '</span>');

		$id = $this->input->post('id');
		
		$data['option_cartype']   = $this->cartype;
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['option_color']     = $this->color;
		$data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		
		if($this->form_validation->run() == false)
		{
		    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		}
		else
		{
			$da['carnum'] = $this->input->post('carnum');
			$da['color']  = $this->input->post('color');
			
		    $res = $this->Mgate->edit_car_by_id($id, $da);
		    
		    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		}
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url'] = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
    	//$this->load->view('gate/showdetail', $data);
       	echo "<script language='JavaScript'>alert('�˶Գɹ�');window.history.go(-1);</script>";
    }
    
	//����˶Թ��ĳ�����Ϣ
	//2013-7-24
    function edit_sl_showdetail()
    {
		$this->form_validation->set_rules('carnum', '���ƺ���', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_message('max_length', '%s���Ȳ��ܳ���20λ.');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		//$this->form_validation->set_message('is_unique', '%s�Ѿ�����.' );
		$this->form_validation->set_error_delimiters('<span>', '</span>');

		$id = $this->input->post('id');
		
		$data['cartype']   = $this->cartype;
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['color']     = $this->color;
		$data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		
		if($this->form_validation->run() == false)
		{
		    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		}
		else
		{
			$da['carnum'] = $this->input->post('carnum');
			$da['color']  = $this->input->post('color');
			
		    $res = $this->Mgate->edit_car_by_id($id, $da);
		    
		    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		}
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']   = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
    	//$this->load->view('gate/slshowdetail', $data);
       	echo "<script language='JavaScript'>alert('�˶Գɹ�');window.history.go(-1);</script>";
    }
    
    function edit_wz_showdetail()
    {
		$this->form_validation->set_rules('carnum', '���ƺ���', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_message('max_length', '%s���Ȳ��ܳ���20λ.');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		//$this->form_validation->set_message('is_unique', '%s�Ѿ�����.' );
		$this->form_validation->set_error_delimiters('<span>', '</span>');

		$id = $this->input->post('id');
		
		$data['cartype']   = $this->cartype;
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['breakrule'] = $this->breakrule;
		$data['color']     = $this->color;
		$data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		
		if($this->form_validation->run() == false)
		{
		    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		}
		else
		{
			$da['carnum'] = $this->input->post('carnum');
			$da['color']  = $this->input->post('color');
			
		    $res = $this->Mgate->edit_car_by_id($id, $da);
		    
		    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		}
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']   = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
    	//$this->load->view('gate/wz_showdetail', $data);
       	echo "<script language='JavaScript'>alert('�˶Գɹ�');window.history.go(-1);</script>";
    }

    //�༭����������Ϣ
    function edit_bj_showdetail()
    {
		$this->form_validation->set_rules('carnum', '���ƺ���', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_message('max_length', '%s���Ȳ��ܳ���20λ.');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		//$this->form_validation->set_message('is_unique', '%s�Ѿ�����.' );
		$this->form_validation->set_error_delimiters('<span>', '</span>');

		$id = $this->input->post('id');
		
		$data['cartype']   = $this->cartype;
		$data['role_id']   = $this->session->userdata('DX_role_id');	
		$data['color']     = $this->color;
	    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		
		if($this->form_validation->run() == false)
		{
		    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		 
		   //$this->load->view('gate/showdetail', $data);
		}
		else
		{
			$da['carnum'] = $this->input->post('carnum');
			$da['color']  = $this->input->post('color');
			
		    $res = $this->Mgate->edit_car_by_id($id, $da);
		    
		    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();		    
		}
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']   = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
    	//$this->load->view('gate/bj_showdetail', $data);
       	echo "<script language='JavaScript'>alert('�˶Գɹ�');window.history.go(-1);</script>";
    }
    
    //ɾ������
    function del_showdetail()
    {
    	$id = $this->uri->segment(3);
    	
    	$res = $this->Mgate->del_car_by_id($id);
    	
/*    	if ($res)
		{
			showmessage('ɾ��������Ϣ�ɹ�', 'gate/carquery');
		}
		else
		{
			$uri = "gate/showdetail/" . $id;
			
			showmessage('����ʧ�ܣ�ϵͳ��æ������д����', $uri);
	    }*/
        if($res){
         	 echo "<script language='JavaScript'>alert('ɾ��������Ϣ�ɹ�');window.history.go(-1); </script>";
        }
        else{
             //�������ʧ�ܣ��򱨴�
             echo "<script language='JavaScript'>alert('����ʧ�ܣ�ϵͳ��æ������д����');window.history.back(-1);</script>";
        }
    }
 
    //ɾ��Υ�³���
    function del_wz_showdetail()
    {
    	$id = $this->uri->segment(3);
    	
    	$res = $this->Mgate->del_car_by_id($id);
    	
        if($res){
       		echo "<script language='JavaScript'>alert('ɾ��������Ϣ�ɹ�');window.history.go(-1); </script>";
        }
        else{
            //�������ʧ�ܣ��򱨴�
            echo "<script language='JavaScript'>alert('����ʧ�ܣ�ϵͳ��æ������д����');window.history.back(-1);</script>";
        }
    }

    //ɾ���������� 
    function del_bj_showdetail()
    {
    	$id = $this->uri->segment(3);
    	
    	$res = $this->Mgate->del_car_by_id($id);
    	
        if($res){
       		echo "<script language='JavaScript'>alert('ɾ��������Ϣ�ɹ�');window.history.go(-1); </script>";
        }
        else{
            //�������ʧ�ܣ��򱨴�
            echo "<script language='JavaScript'>alert('����ʧ�ܣ�ϵͳ��æ������д����');window.history.back(-1);</script>";
        }
    }
    
    //�������ݵ�Excel
    function exportexcel()
    {
    	ob_clean();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
          
        $excel_data = $this->_get_excel_data(-1, 0);
        $query = $excel_data['cars'];
/*        if(!$query)
        return false;*/
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("����ϵͳ����")
                                     ->setDescription("����ϵͳ���ɵĳ�����ѯ����");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '����ϵͳExcel���ݱ�'));
                    
        // Field names in the first row
        //$fields_name = array('���ƺ���','������ɫ','ͨ��ʱ��','��ص�����','����','����');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '���ƺ���', '��ɫ', 'ͨ��ʱ��', '��ص�����', '����', '����');
        
        $col = 0;
        foreach ($fields_condition as $field)
        {
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, iconv('gbk', 'utf-8', $field));
        	$col++;
        }
/*        $col = 0;
        foreach ($fields_name as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, iconv('gbk', 'utf-8', $field));
            $col++;
        }*/
 
        // Fetching the table data
        $row = 3;
        foreach($query->result() as $data)
        {   
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $data->$field));
                $col++;
            }
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //���ͱ���ǿ���û������ļ�
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }

    //�������ݵ�Excel
    function wz_exportexcel()
    {
    	ob_clean();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
          
        $excel_data = $this->_get_wz_excel_data(-1, 0);
        $query = $excel_data['cars'];
/*        if(!$query)
        return false;*/
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("����ϵͳ����")
                                     ->setDescription("����ϵͳ���ɵĳ�����ѯ����");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '����ϵͳExcel���ݱ�'));
                    
        // Field names in the first row
        //$fields_name = array('���ƺ���','������ɫ','ͨ��ʱ��','��ص�����','����','����');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH','CLSD');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '���ƺ���', '��ɫ', 'ͨ��ʱ��', '��ص�����', '����', '����', '����', 'Υ������');
        
        $col = 0;
        foreach ($fields_condition as $field)
        {
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, iconv('gbk', 'utf-8', $field));
        	$col++;
        }
/*        $col = 0;
        foreach ($fields_name as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, iconv('gbk', 'utf-8', $field));
            $col++;
        }*/
 
        // Fetching the table data
        $row = 3;
        foreach($query->result() as $data)
        {   
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $data->$field));
                $col++;
            }
            if($data->CLBJ=='O'){$wzlx = "����";}
            elseif($data->CLBJ=='N'){$wzlx = "����";}
			elseif($data->JLLX=='2' || $data->JLLX=='3'){$wzlx = "�����";}
			elseif($data->JLLX=='4'){$wzlx = "����������ʻ";}
			else{$wzlx = '';}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $wzlx));
					    
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //���ͱ���ǿ���û������ļ�
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    

  
    //�������ݵ�Excel
    function bj_exportexcel()
    {
    	ob_clean();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
          
        $excel_data = $this->_get_bj_excel_data(-1, 0);
        $query = $excel_data['cars'];
/*        if(!$query)
        return false;*/
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("����ϵͳ����")
                                     ->setDescription("����ϵͳ���ɵĳ�����ѯ����");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '����ϵͳExcel���ݱ�'));
                    
        // Field names in the first row
        //$fields_name = array('���ƺ���','������ɫ','ͨ��ʱ��','��ص�����','����','����');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH','CLSD');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '���ƺ���', '��ɫ', 'ͨ��ʱ��', '��ص�����', '����', '����', '��������', '����״̬', 'ȷ���û�');
        
        $col = 0;
        foreach ($fields_condition as $field)
        {
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, iconv('gbk', 'utf-8', $field));
        	$col++;
        }
/*        $col = 0;
        foreach ($fields_name as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 3, iconv('gbk', 'utf-8', $field));
            $col++;
        }*/
 
        // Fetching the table data
        $row = 3;
        foreach($query->result() as $data)
        {   
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $data->$field));
                $col++;
            }
            
        	if($data->CLBJ =='B')   {$dispose = "�ٿ�";}
			elseif($data->CLBJ=='L'){$dispose = "����";}
			elseif($data->CLBJ=='T'){$dispose = "����";}
			elseif($data->CLBJ=='D'){$dispose = "������";}
			elseif($data->CLBJ=='S'){$dispose = "��������";}
			elseif($data->CLBJ=='O'){$dispose = "����";}   
			else{$dispose = '';}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $dispose));
			$col++;

        	if($data->CFBM == '' || $data->CFBM == '01' || $data->CFBM=='����δ����'){$alarmtype = "����δ����";}
			elseif($data->CFBM=='02'){$alarmtype = "���ƺ���ʶ�����";}
			elseif($data->CFBM=='03'){$alarmtype = "������ɫʶ�����";}
			elseif($data->CFBM=='04'){$alarmtype = "ͼ����";}
			elseif($data->CFBM=='05'){$alarmtype = "���´�";}
			elseif($data->CFBM=='06'){$alarmtype = "���´�";}
			elseif($data->CFBM=='07'){$alarmtype = "δ�ػ�";}
			elseif($data->CFBM=='08'){$alarmtype = "��������";}
			elseif($data->CFBM=='09'){$alarmtype = "������Ƴ�";}
			elseif($data->CFBM=='10'){$alarmtype = "��ͨΥ����";}
			elseif($data->CFBM=='11'){$alarmtype = "����������ݲ���";}
			elseif($data->CFBM=='12'){$alarmtype = "���ݸ��²���ʱ";}        
			else{$alarmtype = '';}
			$col++;
			
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //���ͱ���ǿ���û������ļ�
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    
    //��������ͼƬ
    function export_imgs()
    {
    	$this->_get_imgs_zip('0');
    }
    
    //����Υ�³���ͼƬ
    function export_wz_imgs()
    {
    	$this->_get_imgs_zip('1');
    }
    
    //������������ͼƬ
    function export_bj_imgs()
    {
    	$this->_get_imgs_zip('2');
    }
    
	function _get_excel_data($offset = 0, $row_count = 1000)
	{
	    $role_id = $this->session->userdata('DX_role_id');
        $data = $this->_get_openkakou_by_perm($role_id);

		if($this->input->get('type_alias') == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else 
		{
			$da['okkval'] = "'" . $this->input->get('type_alias'). "'";
		}
		
		$da['lane']      = $this->input->get('lane');           //����
		$da['direction'] = $this->input->get('direction');      //����
		$da['color']     = $this->input->get('color');          //��ɫ
        $da['number']    = $this->input->get('number');         //���Ʊ��
        $da['carnum']    = trim($this->input->get('carnum'));   //���ƺ���
        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = explode(",", $this->input->get('spcarnum'));   //���⳵�ƺ�
            foreach ($spcarnum as $id=>$sp)
            {
        	    $da['sp'][$id] = "'" . $sp . "'";
            }
            $da['spcarnum'] = implode(",",$da['sp']);
        }
        else
        {
            $da['spcarnum'] = '';
        }
    
        $da['starttime'] = $this->input->get('starttime');   //��ʼʱ��
        $da['endtime']   = $this->input->get('endtime');       //����ʱ��
        
        $da['cars'] = $this->Mgate->get_car_by_condition($offset, $row_count, $da);
        
        return $da;
	}

	function _get_wz_excel_data($offset = 0, $row_count = 1000)
	{
	    $role_id = $this->session->userdata('DX_role_id');
        $data = $this->_get_openkakou_by_perm($role_id);

		if($this->input->get('type_alias') == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else 
		{
			$da['okkval'] = "'" . $this->input->get('type_alias'). "'";
		}
		
		$da['breakrule'] = $this->input->get('breakrule');      //Υ��
		$da['record']    = $this->input->get('record');         //����
		$da['color']     = $this->input->get('color');          //��ɫ
        $da['number']    = $this->input->get('number');         //���Ʊ��
        $da['carnum']    = trim($this->input->get('carnum'));   //���ƺ���
        $da['minspeed']  = $this->input->get('minspeed');
        $da['maxspeed']  = $this->input->get('maxspeed');
        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = explode(",", $this->input->get('spcarnum'));   //���⳵�ƺ�
            foreach ($spcarnum as $id=>$sp)
            {
        	    $da['sp'][$id] = "'" . $sp . "'";
            }
            $da['spcarnum'] = implode(",",$da['sp']);
        }
        else
        {
            $da['spcarnum'] = '';
        }
    
        $da['starttime'] = $this->input->get('starttime');   //��ʼʱ��
        $da['endtime']   = $this->input->get('endtime');       //����ʱ��
        
        $da['cars'] = $this->Mgate->get_breakrule_by_condition($offset, $row_count, $da);
        
        return $da;
	}

	function _get_bj_excel_data($offset = 0, $row_count = 1000)
	{
	    $role_id = $this->session->userdata('DX_role_id');
        $data = $this->_get_openkakou_by_perm($role_id);

		if($this->input->get('type_alias') == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else 
		{
			$da['okkval'] = "'" . $this->input->get('type_alias'). "'";
		}
		
		$da['dispose']   = $this->input->get('dispose');        //����״̬
		$da['color']     = $this->input->get('color');          //��ɫ
        $da['number']    = $this->input->get('number');         //���Ʊ��
        $da['carnum']    = trim($this->input->get('carnum'));   //���ƺ���
        $da['alarmtype'] = $this->input->get('alarmtype');     //��������
        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = explode(",", $this->input->get('spcarnum'));   //���⳵�ƺ�
            foreach ($spcarnum as $id=>$sp)
            {
        	    $da['sp'][$id] = "'" . $sp . "'";
            }
            $da['spcarnum'] = implode(",",$da['sp']);
        }
        else
        {
            $da['spcarnum'] = '';
        }
    
        $da['starttime'] = $this->input->get('starttime');   //��ʼʱ��
        $da['endtime']   = $this->input->get('endtime');     //����ʱ��
        
        $da['cars'] = $this->Mgate->get_alarmcar_by_condition($offset, $row_count, $da);
        
        return $da;
	}
	
	function _get_car_data($sel_da)
	{
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		//$data['sel_type_alias'] = $this->input->get('type_alias');    //��ص�����
		
		//$per_page = $this->input->get('per_page');      //ҳ��ƫ����
		
		if($role_id == '1' and $sel_da['type_alias'] == 'all')
		{
			$sel_da['okkval'] = '';
		}
		elseif ($sel_da['type_alias'] == 'all')
		{
			$sel_da['okkval'] = implode(",",$data['okkval']);
		}
		else 
		{
			$sel_da['okkval'] = "'" . $sel_da['type_alias'] . "'";
		}
        
        if($sel_da['spcarnum'] != '')
        {
        	$spcarnum = explode(",", $sel_da['spcarnum']);   //���⳵�ƺ�
            foreach ($spcarnum as $id=>$sp)
            {
        	    $da['sp'][$id] = "'" . $sp . "'";
            }
            $sel_da['spcarnum'] = implode(",",$da['sp']);
        }
        else
        {
            $sel_da['spcarnum'] = '';
        }
    
        
        //�滻�ַ���
        		
		//$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($sel_da['per_page'] == '' ? '0' : $sel_da['per_page']);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['car']         = $this->Mgate->get_car_by_condition($offset, $row_count, $sel_da)->result();
		$data['total_rows']  = $this->Mgate->get_car_by_condition(0,0,$sel_da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		//$data['offset']      = $offset;
		

		$car_id = array();
		
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);
    
		//$this->load->view('gate/carquery', $data);	
	}
	
	function _get_wzcar_data($sel_da)
	{
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		//$data['sel_type_alias'] = $this->input->get('type_alias');    //��ص�����
		
		//$per_page = $this->input->get('per_page');      //ҳ��ƫ����
		
		if($role_id == '1' and $sel_da['type_alias'] == 'all')
		{
			$sel_da['okkval'] = '';
		}
		elseif ($sel_da['type_alias'] == 'all')
		{
			$sel_da['okkval'] = implode(",",$data['okkval']);
		}
		else 
		{
			$sel_da['okkval'] = "'" . $sel_da['type_alias'] . "'";
		}
/*        
        if($sel_da['spcarnum'] != '')
        {
        	$spcarnum = explode(",", $sel_da['spcarnum']);   //���⳵�ƺ�
            foreach ($spcarnum as $id=>$sp)
            {
        	    $da['sp'][$id] = "'" . $sp . "'";
            }
            $sel_da['spcarnum'] = implode(",",$da['sp']);
        }
        else
        {
            $sel_da['spcarnum'] = '';
        }*/
    
        
        //�滻�ַ���
        		
		//$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($sel_da['per_page'] == '' ? '0' : $sel_da['per_page']);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['car']         = $this->Mgate->get_breakrule_by_condition($offset, $row_count, $sel_da)->result();
		$data['total_rows']  = $this->Mgate->get_breakrule_by_condition(0,0,$sel_da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		//$data['offset']      = $offset;
		

		$car_id = array();
		
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);
    
		//$this->load->view('gate/carquery', $data);	
	}

	function _get_bjcar_data($sel_da)
	{
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		//$data['sel_type_alias'] = $this->input->get('type_alias');    //��ص�����
		
		//$per_page = $this->input->get('per_page');      //ҳ��ƫ����
		
		if($role_id == '1' and $sel_da['type_alias'] == 'all')
		{
			$sel_da['okkval'] = '';
		}
		elseif ($sel_da['type_alias'] == 'all')
		{
			$sel_da['okkval'] = implode(",",$data['okkval']);
		}
		else 
		{
			$sel_da['okkval'] = "'" . $sel_da['type_alias'] . "'";
		}

		
		// Get offset and limit for page viewing
		$offset = ($sel_da['per_page'] == '' ? '0' : $sel_da['per_page']);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['car']         = $this->Mgate->get_alarmcar_by_condition($offset, $row_count, $sel_da)->result();
		$data['total_rows']  = $this->Mgate->get_alarmcar_by_condition(0,0,$sel_da)->row()->SUM;
		$data['total_pages'] = intval($data['total_rows']/$row_count)+1;
		//$data['offset']      = $offset;
		

		$car_id = array();
		
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);
    
		//$this->load->view('gate/carquery', $data);	
	}
	
	
	//�˶Գ�����Ϣ
	function car_check(){
		$id     = $this->input->get('id');
		$da['carnum'] = iconv('utf-8', 'gbk', $this->input->get('carnum'));
		$da['color']  = iconv('utf-8', 'gbk', $this->input->get('color'));
		
		header("Content-Type:text/html;charset=gbk");
		header("Cache-Control:no-cache");
		
		$info="";
		if($da['carnum'] == '')
		{
			//$info= '{"res":" "}';
			$info = '';
		}
		else{
			$res = $this->Mgate->edit_car_by_id($id, $da);
			if($res){
				//$info= '{"res":"�Ѻ˶�"}';
				$info = '�Ѻ˶�';
			}
			else{
				//$info= '{"res":"���ݿ����"}';
				$info = '���ݿ����';
			}
		}
		echo $info;
	}
	
	function handle_info(){
		$id = $this->input->get('id');
		$data['dispose'] = iconv('utf-8', 'gbk', $this->input->get('dispose'));
		$data['jyqk']    = iconv('utf-8', 'gbk', $this->input->get('jyqk'));
		$data['user']    = $this->session->userdata('DX_username');
		$data['cfsj']    = mdate("%Y-%m-%d %H:%i:%s");

/*		header("Content-Type:text/html;charset=gbk");
		header("Cache-Control:no-cache");*/
		
		$da['cfsj'] = iconv('utf-8', 'gbk', $this->input->get('cfsj'));
		$da['user'] = iconv('utf-8', 'gbk', $this->input->get('user'));
		$da['info'] = '';
		$da['meg'] = '';
		
		$comp = iconv('gbk','utf-8','���´�');
		if($this->input->get('dispose') == $comp AND $data['jyqk'] == '')
		{
			$da['meg'] = '��Ҫ�������Ϊ��';
			$da['info'] = '��Ҫ�������Ϊ��';
		}
		else{
			$res = $this->Mgate->handle_by_id($id, $data);
			if($res){
				$da['cfsj'] = $data['cfsj'];
				$da['user'] = $data['user'];
				$da['info'] = '����ɹ�';
			}
			else{
				$da['info'] = '���ݿ����';
			}
		}
		$da['info'] = iconv('gbk','utf-8',$da['info']);
		$da['meg']  = iconv('gbk','utf-8',$da['meg']);
		echo json_encode($da);
	}
	
	//����û�������Ϣ
	function _add_oplog($name,$type)
	{
		$this->load->model('Mlog');
			
		$type_alias = $this->input->get('type_alias');          //��ص�����
        $number     = $this->input->get('number');              //���Ʊ��
        $carnum     = trim($this->input->get('carnum'));        //���ƺ���   
        $starttime  = $this->input->get('starttime');           //��ʼʱ��
        $endtime    = $this->input->get('endtime');              //����ʱ��
        
/*        $lane       = empty($this->input->get('lane'))? '' : $this->input->get('lane');                //����
		$direction  = empty($this->input->get('direction'))? '' : $this->input->get('direction');      //����
		$color      = empty($this->input->get('color'))? '' : $this->input->get('color');              //��ɫ   
        $spcarnum   = empty($this->input->get('spcarnum'))? '' : $this->input->get('spcarnum');        //�ض��ƺ�*/
        $lane       = $this->input->get('lane') == ''? '': '������('. $this->input->get('lane') . ').';              //����
		$direction  = $this->input->get('direction') == ''? '': '����('. $this->input->get('direction') . ').';       //����
		$color      = $this->input->get('color');           //��ɫ   
        $spcarnum   = $this->input->get('spcarnum');        //�ض��ƺ� 
        $record     = $this->input->get('record');
		$breakrule  = $this->input->get('breakrule');
        $minspeed   = $this->input->get('minspeed');
        $maxspeed   = $this->input->get('maxspeed');
        $alarmtype  = $this->input->get('alarmtype');          //��������
        $dispose    = $this->input->get('dispose');            //����״̬
        
        $data['memo'] = $name . '��ѯʱ���:('.$starttime. '��' . $endtime . ').' . '��ѯ����:(' . $type_alias . ').' . '���ƺ���:(' .$number . $carnum . ').' . '��ɫ��('. $color . ').';
		if($type == 0)
		{
			$data['memo'] = $data['memo'] . '�ض����ƣ�(' . $spcarnum . ').' . $lane . $direction;
		}
		elseif($type == 1)
		{
			$data['memo'] = $data['memo'] .'Υ�����ͣ�('.$breakrule. ').'. '�ٶȣ�('. $minspeed . '-' . $maxspeed . ').'; 
		}
		elseif($type == 2)
		{
		 	$data['memo'] = $data['memo'] . '�������ͣ�(' . $alarmtype . ').' . '����״̬��(' . $dispose . ').';
		}
		
		$data['czsj']     = mdate("%Y-%m-%d %H:%i:%s");
		$data['uname']    = $this->session->userdata('DX_username');
		$data['uip']      = $this->session->userdata('ip_address');
		$data['disabled'] = 0;
			
		$this->Mlog->add_userlog($data);
	}
	
	//��ȡ����ͼƬ
	function get_car_imgs()
	{
		$excel_data = $this->_get_excel_data(0, 1000);
        $query = $excel_data['cars'];
        
        download_img($query->result());
	}
	
	//ZIP����1
	function get_zip()
	{
		$this->load->library('zip');
		
		$excel_data = $this->_get_excel_data();
		$cars = $excel_data['cars']->result();
		
		foreach ($cars as $row)
		{
			$total_path = $this->path . $row->TJTP;
			
			$this->zip->read_file($total_path);
			echo $total_path;
		}
		$time = mdate("%Y-%m-%d-%H-%i-%s");
		
		$this->zip->download('kakou_imgs_' . $time . '.zip');	
	}
	
	//ZIP����2
	function get_zip2()
	{
		//$this->load->library('zip');
		
		//$this->zip->read_file('F:\test1.jpg');
		//$this->zip->read_file('F:\test2.jpg');		
		//$this->zip->read_file('F:\test7.gif');
		//$this->zip->read_file('F:\test8.gif');
		//$this->zip->read_file('D:\SpreadData/ImageFile/20130115/09/10.44.240.2/01/160002000.jpg');
		//$this->zip->read_file('D:\SpreadData\ImageFile\20130115\09\10.44.240.2\01\160003000.jpg');

/*		$path = 'D:\SpreadData/'; 
		$path2 = 'F:\test8.gif'; */
		$file1 = 'F:\test1.gif'; 
		$file2 = 'F:\test2.gif'; 
		$this->load->library('download');
		
		$time = mdate("%Y%m%d%H%i%s");
		$zipname = 'kakou_imgs' . $time;
		
		$ZipArchive = new ZipArchive();

		$ZipArchive->open($zipname.'.zip',ZipArchive::OVERWRITE);//����һ���յ�zip�ļ�
		
		//$cars = $excel_data['cars']->result();
		
			
		$ZipArchive->addFile($file1, basename($file1));
		$ZipArchive->addFile($file2, basename($file2));
		
		$ZipArchive->close();
	}
	
    //��������ͼƬ
	function _get_imgs_zip($type)
	{
/*		$path = 'D:\SpreadData/'; 
		$path2 = 'F:\test8.gif';
		$file1 = 'ImageFile/20130115/09/10.44.240.2/01/160002000.jpg'; 
		$file2 = 'ImageFile\20130115\09\10.44.240.2\01\160003000.jpg'; */
		$this->load->library('download');
		
		$img_num = $this->config->item('kakou_img_num');
		
		$time = mdate("%Y%m%d%H%i%s");
		$zipname = 'kakou_imgs' . $time;
		
		$ZipArchive = new ZipArchive();

		$ZipArchive->open($zipname.'.zip',ZipArchive::OVERWRITE);//����һ���յ�zip�ļ�

		//type = 0:��ͨ����; 1:Υ�³���; 2:��������.
		if ($type == '0')
		{
			$excel_data = $this->_get_excel_data(0, $img_num);
		}
		elseif ($type == '1')
		{
			$excel_data = $this->_get_wz_excel_data(0, $img_num);
		}
		elseif ($type == '2')
		{
			$excel_data = $this->_get_bj_excel_data(0, $img_num);
		}
		
		$cars = $excel_data['cars']->result();
		
		foreach ($cars as $row)
		{
			$t_path = $this->path . $row->TJTP;
			
			$ZipArchive->addFile($t_path, basename($row->TJTP));
			
			//echo $t_path;
		}
		
		$ZipArchive->close();
		
        $dw = new download($zipname.'.zip');  //�½������ļ���
        $dw->getfiles();
        unlink($zipname.'.zip');  //������ɺ�Ҫ����ɾ��  
	}
	
	function test()
	{
		$this->load->view('gate/test1');
	}
	
	function test2()
	{
		$url = 'http://localhost:8082/kakou/SpreadDataG/ImageFile/20130115/09/10.44.240.2/01/160000000.jpg';
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL, $url);
		curl_setopt ($curl, CURLOPT_HEADER, false);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($curl);
		curl_close($curl);
		file_put_contents(basename($url),$result);

	}
	
	function test3()
	{
		$zip = new ZipArchive;
		$res = $zip->open('test.zip', ZipArchive::CREATE);
		
		if ($res === TRUE) {
		    $zip->addFromString('test.txt', 'file content goes here');
		    $zip->close();
		    echo 'ok';
		} else {
		    echo 'failed';
		}
	}
	
	//�ж��Ƿ��к˶�Ȩ��
	function _check_right()
	{
		if($this->session->userdata('DX_role_id') == 1 or in_array(43,$this->session->userdata('DX_role_right')))
		{
			return 1;
		}
		else{
			return 0;
		}
	}

	
}