<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 待销案控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Dxa extends Admin_Controller
{
	//车道
	protected $lane = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');
	//方向
	protected $direction = array('进城', '出城', '由东往西', '由南往北', '由西往东', '由北往南');
	//车牌号码
	protected $number = array('R','?','-','WJ','闽','粤','苏','浙','沪','京','津','冀','晋','蒙','辽','吉','黑','皖','赣','鲁','豫','鄂','湘','桂','琼','川','贵','云','藏','陕','甘','青','宁','新','台','渝','港','澳','军','海','空','沈','北','兰','济','南','成','广');
	//车牌颜色
	protected $color = array('蓝牌','黄牌','白牌','黑牌','其他');
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('news');
		$this->load->helper('date');
		$this->load->helper('kakou');    //自定义kakou_helper
				
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
	
	//加载待销案设置视图
	function othercar()
	{
		$data['color'] = $this->color;
		//$data[]
		$data['whilelist'] = $this->Mdxa->get_whitelist_all()->result();
		
		$this->load->view('dxa/othercar', $data);
	}
	
	//待销案车辆审核
	function edit_wl_check()
	{
		$id = $this->uri->segment(3);
		
		$data['check'] = 'T';
		
		$this->Mdxa->edit_whilelist($id, $data);
		
	    $data['color'] = $this->color;
		
	    $data['whilelist'] = $this->Mdxa->get_whitelist_all()->result();
		
	    $this->load->view('dxa/othercar', $data);
	}
	
	//添加待销案表单
	function add_wl_ok()
	{
		$this->form_validation->set_rules('carnum', '车牌号码', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('color', '车牌颜色', 'trim|required|xss_clean');
		$this->form_validation->set_message('max_length', '%s长度不能超过20位.');
		$this->form_validation->set_message('required', '%s不能为空.');
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
				showmessage('添加待销案成功', 'dxa/othercar');
			}
			else
			{
				showmessage('操作失败，系统繁忙或着填写错误', 'dxa/othercar');
			}
		}
	}
	
	function find_wl()
	{
		$this->form_validation->set_rules('find_carnum', '车牌号码', 'trim|xss_clean|max_length[10]');
		$this->form_validation->set_message('max_length', '%s长度不能超过10位.');
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
	
	//加载待销案查询视图
	function ocquery()
	{
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
		//车道
		$data['lane'] = $this->lane;
		//方向
		$data['direction'] = $this->direction;
		//车牌号码
		$data['number'] = $this->number;
		//车牌颜色
		$data['color'] = $this->color;
		
		$data['sel_type_alias'] = 'all';
		$data['sel_lane'] = 'all';
		$data['sel_direction'] = 'all';
		$data['sel_color'] = 'all';
		$data['sel_number'] = '粤';
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('dxa/ocquery', $data);
	}
	
    //待销案车辆查询表单
    function ocquery_ok()
    {
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
		
		$data['lane'] = $this->lane;           //车道
		$data['direction'] = $this->direction; //方向
		$data['number'] = $this->number;       //车牌号码
		$data['color'] = $this->color;         //车牌颜色
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //监控点名称
		
		$per_page   = $this->input->get('per_page');      //页面偏移量
		
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
		
		$da['lane'] = $this->input->get('lane');           //车道
		$data['sel_lane'] = $da['lane'];
		$da['direction'] = $this->input->get('direction'); //方向
        $data['sel_direction'] = $da['direction'];
		$da['color'] = $this->input->get('color');         //颜色
        $data['sel_color'] = $da['color'];
        
        $da['number'] = $this->input->get('number');       //车牌编号
        $data['sel_number'] =$da['number'];
        $da['carnum'] = trim($this->input->get('carnum')); //车牌号码
        $data['sel_carnum'] =$da['carnum'];
        
    
        $da['starttime'] = $this->input->get('starttime');   //开始时间
        $data['sel_starttime'] = $da['starttime'];
        $da['endtime'] = $this->input->get('endtime');     //结束时间
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('dxa/ocquery', $data);
		
    }
    
    //删除待销案设置车辆
    function del_wl_set()
    {
    	$id = $this->uri->segment(3);
    	
    	$res = $this->Mdxa->del_whilelist_by_id($id);
    	
    	if ($res)
		{
			showmessage('删除待销案车辆信息成功', 'dxa/othercar');
		}
		else
		{
			showmessage('操作失败，系统繁忙或着填写错误', 'dxa/othercar');
	    }
    }
    
	function wl_showdetail()
	{
		$id = $this->uri->segment(3);

		//$data['cartype']   = $this->cartype;                             //获得车辆类型                                   
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['color']     = $this->color;    
		$data['cardetail'] = $this->Mdxa->get_dxa_by_id($id)->row();
		$data['pic_url']   = get_picurl($data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
		$this->load->view('dxa/wl_showdetail', $data);
	}
    
	//根据权限获得 路口参数信息 
    function _get_openkakou_by_perm($role_id)
    {
		$this->load->model('Msyst');
		$this->load->model('Muser');
		
		if($role_id == '1') //判断是否管理员，管理员有所有路口参数权限
		{
		    $sys['type_name']  = '卡口名称';
		    $sys['type_value'] = '';
		    
		    //$openkakou = $this->Msyst->get_config_inof_typealias($sys)->result();
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
		    foreach ($openkakou as $id=>$kakou)
		    {
		    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    	$data['okkval'][$id] = "'" . $kakou->TYPE_VALUE . "'";
		    }
		}
		else  //非管理员用户 要判断权限
		{
		    $openkakou = $this->Muser->get_role_by_id($role_id)->openkakou;
		    
		    //把序列化的字符串转换成数组
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
