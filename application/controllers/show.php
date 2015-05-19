<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ʵʱ��ʾ���������
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Show extends Admin_Controller
{
	//����
	protected $direction = array('����', '����', '�ɶ�����', '��������', '��������', '�ɱ�����');
	//������ɫ
	protected $color = array('����','����','����','����','����');
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

	protected $imgpath = array();
		                         	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('news');
		$this->load->helper('date');
		$this->load->helper('kakou');
		
		$this->load->library('DX_Auth');
		$this->load->library('form_validation');

		$this->load->model('Mshow');
		$this->load->model('Msyst');
		
		$this->load->config('kakou');
				
		if (substr($this->session->userdata('ip_address'),0,3)=='192')
		{
			$this->imgpath = array('HDWJ-KKDATA1'=>'192.168.10.234:8888','HDWJ-KKDATA2'=>'192.168.10.235:8888',''=>'192.168.10.234:8888');
		}else {
			$this->imgpath = array('HDWJ-KKDATA1'=>'10.44.249.227:81','HDWJ-KKDATA2'=>'10.44.249.227:82',''=>'10.44.249.227:81');
		}
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
    
    //����Ȩ�޻�� ·�ڲ�����Ϣ 
    function _get_openkakou_by_perm2($role_id)
    {
		$this->load->model('Muser');

		$sys['type_name']  = '��������';
		$sys['type_value'] = '';
		
		if($role_id == '1') //�ж��Ƿ����Ա������Ա������·�ڲ���Ȩ��
		{
			$sys['kakou_id'] = 'all';
		}
		else  //�ǹ���Ա�û� Ҫ�ж�Ȩ��
		{
		    $sys['kakou_id'] = $this->Muser->get_role_by_id($role_id)->openkakou;
		}
		$data['config_info'] = $this->Msyst->get_config_info3($sys)->result();
		
		return $data;
    }
    		
    //ʵʱ��ʾ
	function kkmap()
	{
		//��ȡ�û���ɫID
		//$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($this->session->userdata('DX_role_id'));
		
		$data['direction'] = $this->direction;
		//var_dump($data);
		
		$this->load->view('show/kkmap', $data);
	}

	function realshow()
	{
		$data['kakou'] = $this->input->get('kakou');
		
		$data['direction'] = $this->input->get('direction');
		
		$this->load->view('show/realshow', $data);
	}
	
	function realshow_post()
	{
		if($this->input->post('kk', TRUE) == '')
		{
			showmessage('��ѡ���صص����', 'show/kkmap');	
		}
		else 
		{
			$data['kakou'] = implode('|', $this->input->post('kk', TRUE));
			$data['direction'] = '';
		
			$this->load->view('show/realshow', $data);
		}
	}
	
	//ʵʱ��ʾģ��
	function realshowdiv()
	{
		//��ȡ�û���ɫID
		$role_id = $this->session->userdata('DX_role_id');
		
		$pastdate = strtotime("-2 hours");
		$da['time_flag'] = mdate("%Y-%m-%d %h:%i:%s",$pastdate);

		$arr_kakou = explode('|', $this->input->get('kakou'));  //���ύ�Ŀ����ַ�����ֳ�����
		#var_dump($arr_kakou);
		$da['direction'] = $this->input->get('direction');
		
		if ($role_id == 1) {
			$da['okkval'] = change_to_quotes($arr_kakou);
		}else {
			$da['okkval'] = change_to_quotes(array_intersect($this->session->userdata('DX_role_openkakou'),$arr_kakou));
		}
		$da['kakou'] = '';
		
		$query = $this->Mshow->get_realshow($da);
		#$this->load->view('show/realshowdiv', $data);
		if ($query->num_rows() > 0) {
			$data['newestdata'] = $query->row();
		    $data['realdata'] = $query->result();
		
	    	$data['kakou'] = $da['kakou'];
	    	$data['direction'] = $da['direction'];
	    	
	    	$data['pic_url']   = get_picurl($this->imgpath[$data['newestdata']->TPWZ], $data['newestdata']->QMTP, $data['newestdata']->TJTP);
	    	
		    $this->load->view('show/realshowdiv', $data);
	    }else {
	    	$data['msg'] = '���3Сʱû�����ݣ�';
	    	$this->load->view('show/realshowerror', $data);
	    }

		
	}
	
	//��ʾͨ�г�����Ϣ
	function show_showdetail()
	{
		$this->load->model('Mgate');
		
		$id = $this->uri->segment(3);
		
		$data['cardetail']      = $this->Mgate->get_car_by_id($id)->row();
		$data['option_cartype'] = $this->cartype;                             //��ó�������                                   
		$data['role_id']        = $this->session->userdata('DX_role_id');
		$data['option_color']   = $this->color;
		$data['pic_url']        = get_picurl($this->imgpath[$data['cardetail']->TPWZ], $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		$data['check_right'] = $this->_check_right();
		
		$this->load->view('show/show_showdetail', $data);
	}

	//����ʵʱ��ʾ
	function bjmap()
	{
		//��ȡ�û���ɫID	
		//$role_id = $this->session->userdata('DX_role_id');
		
		//����Ȩ�޻��·�ڲ�����Ϣ 
		$data = $this->_get_openkakou_by_perm($this->session->userdata('DX_role_id'));
		
		$this->load->view('show/bjmap', $data);
	}
	
	function bj_realshow()
	{
		if($this->input->post('kk', TRUE) == '')
		{
			showmessage('��ѡ���صص�', 'show/kkmap');	
		}
		else 
		{
			$data['kakou'] = implode('|', $this->input->post('kk', TRUE));
			
			$this->load->view('show/bj_realshow', $data);
		}
	}
	
	function bj_realshowdiv()
	{
		$this->load->model('Mbmenu');
		//��ȡ�û���ɫID
		$role_id = $this->session->userdata('DX_role_id');
		
		$pastdate = strtotime("-2 hours");
		$da['time_flag'] = mdate("%Y-%m-%d %h:%i:%s",$pastdate);

		$arr_kakou = explode('|', $this->input->get('kakou'));

			if ($role_id == 1) {
			$da['okkval'] = change_to_quotes($arr_kakou);
		}else {
			$da['okkval'] = change_to_quotes(array_intersect($this->session->userdata('DX_role_openkakou'),$arr_kakou));
		}
		$da['kakou'] = '';
		
		$query = $this->Mshow->get_bjrealshow($da);
		#$this->load->view('show/realshowdiv', $data);
		if ($query->num_rows() > 0) {
			$data['newestdata'] = $query->row();
		    $data['realdata'] = $query->result();
			$data['kakou'] = $da['kakou'];
			
		    $bm_data['carnum'] = $data['newestdata']->HPHM;
		    $bm_data['color']  = '';
		    $data['bmenu'] = $this->Mbmenu->get_bkcp_by_num($bm_data)->row();
	    	
	    	$data['pic_url']   = get_picurl($this->imgpath[$data['newestdata']->TPWZ], $data['newestdata']->QMTP, $data['newestdata']->TJTP);
	    	
		    $this->load->view('show/bj_realshowdiv', $data);
	    }else {
	    	$data['msg'] = '���2Сʱû�����ݣ�';
	    	$this->load->view('show/realshowerror', $data);
	    }
	    
	}
	
	function show_bj_showdetail()
	{
		$this->load->model('Mgate');
		$this->load->model('Mbmenu');
		
		$id = $this->uri->segment(3);
		
		$data['option_cartype']   = $this->cartype;
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['option_color']     = $this->color;
		$data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		$data['pic_url']   = get_picurl($this->imgpath[$data['cardetail']->TPWZ], $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
		$bm_data['carnum'] = $data['cardetail']->HPHM;
	    $bm_data['color']  = '';
	    $data['bmenu']     = $this->Mbmenu->get_bkcp_by_num($bm_data)->row();
	    $data['check_right'] = $this->_check_right();
	    
		$this->load->view('show/show_bj_showdetail', $data);	
	}
	
	function edit_show_showdetail()
	{
		$this->load->model('Mgate');
		
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
		$data['pic_url'] = get_picurl($this->imgpath[$data['cardetail']->TPWZ], $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
    	$this->load->view('show/show_showdetail', $data);
	}
	
    //�༭����������Ϣ
    function edit_show_bj_showdetail()
    {
    	$this->load->model('Mgate');
    	
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
		 
		   //$this->load->view('gate/showdetail', $data);
		}
		else
		{
			$da['carnum'] = $this->input->post('carnum');
			$da['color']  = $this->input->post('color');
			
		    $res = $this->Mgate->edit_car_by_id($id, $da);
		    
		    $data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();		    
		}
		$data['pic_url']   = get_picurl($this->imgpath[$data['cardetail']->TPWZ], $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
    	$this->load->view('show/show_bj_showdetail', $data);
    }
    
	function del_show_showdetail()
	{
		$this->load->model('Mgate');
		
	    $id = $this->uri->segment(3);
    	
    	$res = $this->Mgate->del_car_by_id($id);
    	
/*    	if($res)
    	{
    		showmessage("ɾ��������Ϣ�ɹ�",'show/kkmap');
    	}
    	else 
    	{
            showmessage('����ʧ�ܣ�ϵͳ��æ������д����','show/kkmap');
    	}*/
    	
	}
	
	function del_show_bj_showdetail()
	{
		$this->load->model('Mgate');
		
	    $id = $this->uri->segment(3);
    	
    	$res = $this->Mgate->del_car_by_id($id);

    	
	}
	
	function show_sha()
	{
		$data['hash'] = sha1('yqlfire');
		$data['ip'] = ip2long('1.0.0.1');
		$data['ip2'] = long2ip($data['ip']);
		
		$this->load->view('show/show_sha', $data);
	}
	
	//�˶Գ�����Ϣ
	function car_check(){
		$this->load->model('Mgate');
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


