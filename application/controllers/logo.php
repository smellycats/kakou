<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 治安卡口管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Logo extends CI_Controller
{	
	protected $msg1 = '请选择查询条件.';
	
	protected $msg2 = '没有车辆记录！';
	
	protected $imgpath = array();

	
	//protected $imgpath = array('HDWJ-KKDATA1'=>'localhost:8082','HDWJ-KKDATA2'=>'localhost:8082',''=>'192.168.10.234:81');
	
	//protected $path = 'D:\SpreadData/';
	//图片批量下载数量
	//protected $imgs_num = 400;

		
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('news');     //自定义news_helper
		$this->load->helper('kakou');    //自定义kakou_helper
		
		$this->load->library('DX_Auth');
		$this->load->library('form_validation');
		$this->load->library('Lib_kakou');
		#$this->load->library('MY_Session');

		#$this->load->model('Mgate');
		#$this->load->model('Msyst');
		$this->load->model('Mlogo');
		$this->load->model('Msms');
		
		$this->load->config('basedata');
		//$this->load->config('kakou');
		
		//$this->output->enable_profiler(TRUE);
						
		if (substr($this->session->userdata('ip_address'),0,3)=='192')
		{
			$this->imgpath = array(0=>'192.168.10.234:8888',1=>'192.168.10.235:8888',''=>'192.168.10.234:8888');
		}else {
			$this->imgpath = array(0=>'10.44.249.227:81',1=>'10.44.249.227:82',''=>'10.44.249.227:81');
		}
	}
	
	function test2()
	{
		#$arr = $this->Mlogo->get_vehicle_gd_by_hphm('粤B2FU16')->result_array();
		#$data = array('userid'=>12,'carinfoid'=>24,'timeflag'=>'2014-11-07 12:34:56');
		#$time1 = mdate("%Y-%m-%d %H:%i:%s",strtotime("-1 hours"));
		#$time2 = mdate("%Y-%m-%d %H:%i:%s",strtotime("-20 seconds"));
		#$num = $this->Mlogo->get_carinfo_by_id(23)->row();
		#$arr = $this->Mlogo->get_full_carinfo_by_id(1)->result_array();
		#var_export($arr);
		$this->load->view('logo/test2');
		#if($num == 0){
			#$data = array('userid'=>13,'carinfoid'=>24,'timeflag'=>'2014-11-08 12:34:56');
		#}#
		#var_export($ar);
		/*
		$done = array();
		foreach($arr as $row)
		{
			$done[$row['code']] = $row['name'];
		}
		var_export($done);
		*/
		
	}

	function unlock()
	{
		$this->Mlogo->unlock();
	}
	
	function load_data2()
	{
		$this->session->set_userdata('places',   $this->Mlogo->get_places()->result_array());
		//$this->session->set_userdata('platetype',$this->Mlogo->get_platetype()->result_array());
		#$this->session->set_userdata('test', '123');
		#$this->session->set_userdata('logos',    $this->Mlogo->get_logos()->result_array());
		//$this->session->set_userdata('cartype',  $this->Mlogo->get_cartype()->result_array());
		//$this->session->set_userdata('bodycolor',$this->Mlogo->get_bodycolor()->result_array());
		#var_dump($this->session->userdata('logos'));
	}
	
    
    function _load_basedata()
    {
    	$data['platecolor'] = $this->config->item('platecolor');
    	$data['csys'] = $this->config->item('csys');
    	$data['number'] = $this->config->item('number');
    	$data['direction'] = $this->config->item('direction');
    	$data['lane'] = $this->config->item('lane');
    	$data['platetype'] = $this->config->item('hpzl');
    	$data['cllx']   = $this->config->item('cllx');
    	$data['places'] = $this->session->userdata('places');
    	$data['logos']  = array();
    	$data['places'] = array();
    	
    	$logos = $this->Mlogo->get_ppdm()->result_array();
    	foreach ($logos as $row){
    		$data['logos'][$row['code']]=$row['name'];
    	}
        $places = $this->Mlogo->get_places()->result_array();
    	foreach ($places as $row){
    		$data['places'][$row['id']]=$row['place'];
    	}
    	
    	return $data;
    }

	function showdetail()
	{
		$data = $this->_load_basedata();
	    #$data = $this->input->get(NULL,True);
	    $current_id = $this->uri->segment(3);
	    $data['current_id'] = $this->uri->segment(3);
	    if ($current_id < 1){
	    	$data['current_id'] = 1;
	    }elseif ($current_id > $this->session->userdata('total_rows')){
	    	$data['current_id'] = $this->session->userdata('total_rows');
	    }elseif ($current_id > $this->session->userdata('offset') and $current_id <= $this->session->userdata('offset')+$this->session->userdata('limit')){
	    	$data['current_id'] = $this->uri->segment(3);
	    }else{
	    	if($current_id <= $this->session->userdata('offset')){
	    		$offset = $this->session->userdata('offset') - $this->session->userdata('limit');
	    	}elseif($current_id > $this->session->userdata('offset')+$this->session->userdata('limit')){
	    		$offset = $this->session->userdata('offset') + $this->session->userdata('limit');
	    	}
	    	$getdata = $this->session->userdata('lgquery');
	    	$getdata['platename'] = format_carnum($getdata['number'],$getdata['carnum']);
			$data['carinfo']     = $this->Mlogo->get_carinfo($offset, $this->session->userdata('limit'), $getdata)->result();
			$data['total_rows']  = $this->Mlogo->get_carinfo(0,0,$getdata)->row()->sum;
			
			$car_id = array();
			foreach ($data['carinfo'] as $i=>$car)
			{
				$car_id[$i+$offset+1] = $car->id;
			}
			
			//把查询得到的车辆id(20个)和总行数添加到session
	        $this->session->set_userdata('car_ids', $car_id);
	        $this->session->set_userdata('offset', $offset);
	        $this->session->set_userdata('total_rows', $data['total_rows']);
	    }
	    
	    $car_ids = $this->session->userdata('car_ids');
	    $id = $car_ids[$data['current_id']];
	    
	    #$data['per_page'] == '' ? '0' : $data['per_page'];
		#$places = $this->session->userdata('places');
		$data['carinfo'] = $this->Mlogo->get_carinfo_by_id($id)->row();
		#var_dump($data['carinfo']->cltx_hphm);
		$data['vehicle_gd'] = $this->Mlogo->get_vehicle_gd_by_hphm($data['carinfo']->cltx_hphm)->row(); #广东车管信息
		#var_dump($data['vehicle_gd']);
		$imgp = $this->imgpath[$data['carinfo']->img_ip];
		$data['pic_url'] = get_picurl($imgp, 'SpreadData'.$data['carinfo']->img_disk, $data['carinfo']->img_path);
        //检查是否有核对权限
		
		$this->load->view('logo/showdetail', $data);
	}
    
    //根据权限获得 路口参数信息 
    function _get_openkakou_by_perm($role_id)
    {

		$sys['type_name']  = '卡口名称';
		$sys['type_value'] = '';
		    
		$openkakou_all = $this->Msyst->get_config_info($sys)->result();
		
    	foreach ($openkakou_all as $id=>$kakou)
		{
		    $openkakou_all_to_arr[$id] = $kakou->ID;
		}
		
		$data = null;
		
		if($role_id == '1') //判断是否管理员，管理员有所有路口参数权限
		{
		    foreach ($openkakou_all as $id=>$kakou)
		    {
		    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    	$data['okkval'][$id] = $kakou->TYPE_VALUE;
		    }
		}
		else  //非管理员用户 要判断权限
		{
		    $openkakou_str = $this->Muser->get_role_by_id($role_id)->openkakou;
		    
		    if ($openkakou_str == '0' or $openkakou_str == '') {
		    	$data['openkakou'][0] = '';
		    	$data['okkval'][0] = '';
		    }else {
			    //把序列化的字符串转换成数组
			    $openkakou_to_arr = explode(',', $openkakou_str);
			    //求权限卡口和所有卡口的交集
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
	
	function cmpquery2()
	{
		$role_id = 1;
		
		//根据权限获得路口参数信息 
		//$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;

		$data['message']   = $this->msg1;
		
		$data['cmpquery']['number'] = '?';
		$data['cmpquery']['carnum'] = '';
		$data['cmpquery']['place']  = 'all';
		$data['cmpquery']['direction']  = 'all';
		$data['cmpquery']['logo']       = 'all';
		$data['cmpquery']['confirm']    = 'all';
		$data['cmpquery']['clppflag']   = 'all';
		$data['cmpquery']['smsflag']    = 'all';
		$data['cmpquery']['starttime']  = mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
		$data['cmpquery']['endtime']    = mdate("%Y-%m-%d %H:%i:%s");

		$this->session->set_userdata('cmpquery',$data['cmpquery']);
		
	    $logos = $this->Mlogo->get_ppdm()->result_array();
    	foreach ($logos as $row){
    		$data['logos'][$row['code']]=$row['name'];
    	}
	    $places = $this->Mlogo->get_places()->result_array();
    	foreach ($places as $row){
    		$data['places'][$row['id']]=$row['place'];
    	}
    	$data['confirm']  = $this->config->item('confirm2');
    	$data['clppflag'] = $this->config->item('clppflag2');
    	$data['smsflag']  = $this->config->item('smsflag2');
    	
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$limit = 20;
		
		$data['row_count'] = $limit;
		$data['offset']    = $offset;
		
		$config['base_url'] = site_url('logo/cmpquery/');
		//$config['total_rows'] = $this->Mgate->get_car_all()->row()->SUM;
		$config['per_page'] = $limit;
		$config['uri_segment']    = 3;
		$config['full_tag_open']  = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '第一页';
		$config['last_link']  = '尾页';
		$config['next_link']  = '下一页';
		$config['prev_link']  = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('logo/cmpquery2', $data);
	}
	
    //车辆查询表单
    function cmpquery_ok()
    {
    	$data = $this->_load_basedata();
    	$data['confirm']  = $this->config->item('confirm2');
    	$data['clppflag'] = $this->config->item('clppflag2');
    	$data['smsflag']  = $this->config->item('smsflag2');
    	
		$role_id = 1;
		
		if($this->input->get('query_find')){
			$data['cmpquery'] = $this->input->get();
			$this->session->set_userdata('cmpquery',$data['cmpquery']);
		}else{
			$data['cmpquery'] = $this->session->userdata('cmpquery');
		}
		$getdata = $data['cmpquery'];
		$getdata['platename'] = format_carnum($getdata['number'],$getdata['carnum']);
		
		$data['message']   = $this->msg2;
		
		$per_page = $this->input->get('per_page');      //页面偏移量
        		
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($per_page == '' ? '0' : $per_page);
		// Number of record showing per page
		$limit = 20;
		// Get all users
		$data['carinfo']     = $this->Mlogo->get_confirm_carinfo($offset, $limit, $getdata)->result();
		$data['total_rows']  = $this->Mlogo->get_confirm_carinfo(0,0,$getdata)->row()->sum;
		$data['total_pages'] = intval($data['total_rows']/$limit)+1;
		$data['offset']      = $offset;
	
		$config['base_url']   = site_url() . "/logo/cmpquery_ok/?place=$getdata[place]&direction=$getdata[direction]&logo=$getdata[logo]&number=$getdata[number]&carnum=$getdata[carnum]&starttime=$getdata[starttime]&endtime=$getdata[endtime]&confirm=$getdata[confirm]&clppflag=$getdata[clppflag]&smsflag=$getdata[smsflag]";
		$config['total_rows'] = $data['total_rows'];
		$config['per_page']   = $limit;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'per_page';
		$config['full_tag_open']  = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '第一页';
		$config['last_link']  = '尾页';
		$config['next_link']  = '下一页';
		$config['prev_link']  = '上一页';

		$this->pagination->initialize($config);

		$car_id = array();
		foreach ($data['carinfo'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->id;
		}
		
		//把查询得到的车辆id(20个)和总行数添加到session
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('offset', $offset);
        $this->session->set_userdata('limit', $limit);
        $this->session->set_userdata('total_rows', $data['total_rows']);
        
		$this->load->view('logo/cmpquery', $data);
		
    }
	
	#实时比较选择列表
	function cmpselect()
	{
		$data['direction'] = $this->config->item('direction');
	    $data['places'] = array();
        $places = $this->Mlogo->get_places()->result_array();
    	foreach ($places as $row){
    		if ($row['id']==1){
    			$data['places'] = $data['places'];
    		}else{
    			$data['places'][$row['id']]=$row['place'];
    		}
    	}
    	
    	$this->load->view('logo/cmpselect', $data);
	}
	
	#实时比较
	function realcmp()
	{
		if($this->input->post('submit'))
		{
			#var_dump($this->input->post('kk'));
			if($this->input->post('kk') == ''){
				showmessage('请选择监控地点或方向', 'logo/cmpselect');
				return;	
			}else{
				$place_str = array_to_string($this->input->post('kk'));
				$dire = 'all';
			}
		}
		else 
		{
			$place_str = $this->input->get('place');
			$dire      = $this->input->get('direction');
		}

		#$userid= $this->session->userdata('DX_user_id');
	    $userid = 23;
		
		$data = $this->_load_basedata();
		
	    $res = $this->Mlogo->get_confirm($userid,$place_str,$dire);
	    
	    $se_data['dire']  = $dire;
		$se_data['place'] = $place_str;
		$this->session->set_userdata('realcmp',$se_data);
		
	    if ($res->num_rows() > 0){
			$data['carinfo'] = $res->row();
			$data['vehicle_gd'] = $this->Mlogo->get_vehicle_gd_by_hphm($data['carinfo']->cltx_hphm)->row(); #广东车管信息
	
			$this->session->set_userdata('realcmpid',$data['carinfo']->id);
			
			$imgp = $this->imgpath[$data['carinfo']->img_ip];
			$data['pic_url'] = get_picurl($imgp, 'SpreadData'.$data['carinfo']->img_disk, $data['carinfo']->img_path);
			
			$this->load->view('logo/realcmp', $data);
	    }
		else{
	    	#showmessage('最近1小时没有数据！', 'logo/waitcmp');
	    	$data['realcmp'] = $se_data;
	    	
	    	$this->load->view('logo/waitcmp', $data);
		}
	}
	
	function realcmp_ok()
	{
		$data['confirmflag'] = 1;
		$data['clppflag'] = $this->input->post('clppflag') ? 1:0;
		$data['smsflag']  = $this->input->post('smsflag') ? 1:0;
		
		$realcmp = $this->session->userdata('realcmp');
		$this->Mlogo->edit_confirm($this->session->userdata('realcmpid'),$data);
		
		redirect("/logo/realcmp?place=$realcmp[place]&direction=$realcmp[dire]", 'location', 301);
	}
	
	function waitcmp()
	{
		$data['realcmp'] = $this->session->userdata('realcmp');
		
		$this->load->view('logo/waitcmp', $data);
	}
	
	//比对车辆详细信息
	function cmpdetail2()
	{
		$data = $this->_load_basedata();
	    #$data = $this->input->get(NULL,True);
	    $current_id = $this->uri->segment(3);
	    $data['current_id'] = $this->uri->segment(3);
	    if ($current_id < 1){
	    	$data['current_id'] = 1;
	    }elseif ($current_id > $this->session->userdata('total_rows')){
	    	$data['current_id'] = $this->session->userdata('total_rows');
	    }elseif ($current_id > $this->session->userdata('offset') and $current_id <= $this->session->userdata('offset')+$this->session->userdata('limit')){
	    	$data['current_id'] = $this->uri->segment(3);
	    }else{
	    	if($current_id <= $this->session->userdata('offset')){
	    		$offset = $this->session->userdata('offset') - $this->session->userdata('limit');
	    	}elseif($current_id > $this->session->userdata('offset')+$this->session->userdata('limit')){
	    		$offset = $this->session->userdata('offset') + $this->session->userdata('limit');
	    	}
	    	$getdata = $this->session->userdata('cmpquery');
	    	$getdata['platename'] = format_carnum($getdata['number'],$getdata['carnum']);
			$data['carinfo']     = $this->Mlogo->get_carinfo($offset, $this->session->userdata('limit'), $getdata)->result();
			$data['total_rows']  = $this->Mlogo->get_carinfo(0,0,$getdata)->row()->sum;
			
			$car_id = array();
			foreach ($data['carinfo'] as $i=>$car)
			{
				$car_id[$i+$offset+1] = $car->id;
			}
			
			//把查询得到的车辆id(20个)和总行数添加到session
	        $this->session->set_userdata('car_ids', $car_id);
	        $this->session->set_userdata('offset', $offset);
	        $this->session->set_userdata('total_rows', $data['total_rows']);
	    }
	    
	    $car_ids = $this->session->userdata('car_ids');
	    $id = $car_ids[$data['current_id']];
	    $this->session->set_userdata('current_id', $data['current_id']);
	    
	    #$data['per_page'] == '' ? '0' : $data['per_page'];
		#$places = $this->session->userdata('places');
		$data['carinfo'] = $this->Mlogo->get_carinfo_by_id($id)->row();
		$sms_arr = $this->Msms->get_sms();
		$data['sms'] = $sms_arr->result_array();
		if ($sms_arr->num_rows()==0){
			$this->session->set_userdata('sms_id', 0);
		}else{
			$this->session->set_userdata('sms_id', $sms_arr->row()->id);
		}
		$data['vehicle_gd'] = $this->Mlogo->get_vehicle_gd_by_hphm($data['carinfo']->cltx_hphm)->row(); #广东车管信息
		
		$imgp = $this->imgpath[$data['carinfo']->img_ip];
		$data['pic_url'] = get_picurl($imgp, 'SpreadData'.$data['carinfo']->img_disk, $data['carinfo']->img_path);
        //检查是否有核对权限
		
		$this->load->view('logo/cmpdetail', $data);
	}
	
	function cmpdetail_ok()
	{
		$data['confirmflag'] = 1;
		$data['clppflag']    = $this->input->post('clppflag') ? 1:0;
		$current_id          = $this->session->userdata('current_id');
		
	    $car_ids = $this->session->userdata('car_ids');
	    $id = $car_ids[$current_id];
	    
		if ($this->input->post('smsflag')){
			$data['smsflag'] = 1;
			if($this->input->post('sms')){
				$this->_send_sms($this->input->post('sms'),$id);
			}
		}
		
		$this->Mlogo->edit_confirm($id,$data);
		
		redirect("/logo/cmpdetail/$current_id", 'location', 301);
	}
	
	function _send_sms($sms_id,$id)
	{
		$this->load->model('Msmshd');
		$sms_obj = $this->Msms->get_sms_by_id($sms_id);
		if ($sms_obj->num_rows() == 0){
			
		}else{
			$data['tel'] = $sms_obj->row()->tel;
			$info = $this->Mlogo->get_full_carinfo_by_id($id)->row();
			$data['content'] = $info->place.'_'.$info->passtime.'_'.$info->cltx_hphm;
			$this->Msmshd->send_sms($data);
		}
	}
	
	function realcmp2()
	{
		$data = $this->_load_basedata();
	    #$role_id = $this->session->userdata('DX_role_id');
	    $role_id = 23;
	    $res = $this->Mlogo->get_confirm($role_id);
	    if ($res->num_rows() > 0){
			$data['carinfo'] = $res->row();
			#var_dump($data['carinfo']);
			$data['vehicle_gd'] = $this->Mlogo->get_vehicle_gd_by_hphm($data['carinfo']->cltx_hphm)->row(); #广东车管信息
			#var_dump($data['vehicle_gd']);
			$imgp = $this->imgpath[$data['carinfo']->img_ip];
			$data['pic_url'] = get_picurl($imgp, 'SpreadData'.$data['carinfo']->img_disk, $data['carinfo']->img_path);
	        //检查是否有核对权限
			
			$this->load->view('logo/realcmp', $data);
	    }
		else{
	    	$data['msg'] = '最近1小时没有数据！';
	    	$this->load->view('logo/realshowerror', $data);
		}
	}
	
	function smsnum()
	{
		$this->sms_list();
	}
	
	function add_sms()
	{
		$this->load->model('Msms');
		
		$data['tel']  = $this->input->post('tel');
		$data['tel']  = str_replace(",", "，", $data['tel']);
		$data['mark'] = $this->input->post('mark');
		
		$this->Msms->add_sms($data);
		
		redirect("/logo/smsnum", 'location', 301);
		#$this->load->view('logo/smsnum');
	}

	function edit_sms()
	{
		$this->load->model('Msms');
		
		$data['tel']  = $this->input->post('tel');
		$data['tel']  = str_replace(",", "，", $data['tel']);
		$data['mark'] = $this->input->post('mark');
		$id = $this->input->post('id');
		
		$this->Msms->edit_sms($id,$data);
		
		redirect("/logo/smsnum", 'location', 301);
		#$this->load->view('logo/smsnum');
	}

	function del_sms()
	{
		$this->load->model('Msms');
		
		$id = (int) $this->uri->segment(3);
		
		$this->Msms->del_sms($id);
		#var_dump('del');
		redirect("/logo/smsnum", 'location', 301);
		#$this->load->view('logo/smsnum');
	}
	
	function _get_excel_data($offset = 0, $row_count = 1000)
	{
	    #$role_id = $this->session->userdata('DX_role_id');
	    $role_id = 1;
	    
		$data = $this->session->userdata('lgquery');
		
		$data['platename'] = format_carnum($data['number'],$data['carnum']);
        
        return $this->Mlogo->get_carinfo($offset, $row_count, $da);
	}
	
	function test4()
	{
		$data['title'] = '实时显示';
		$da['place'] = $this->input->get('ids', True);
		$this->session->set_userdata('realdetail', $da);
		
		$this->load->view('logo/test4',$data);
	}
	
	function test3()
	{
		#$res = $this->Mlogo->test2('%L31学%')->result_array();
		#var_dump($res);
		#echo json_encode($this->Mlogo->test(0,100)->result_array());
		$data['ids'] = '';
		$this->load->view('logo/test3',$data);
	}

	function lgquery2()
	{
		$data['lgquery']['number'] = '?';
		$data['lgquery']['carnum'] = '';
		$data['lgquery']['place']  = 0;
		$data['lgquery']['dire']   = 0;
		$data['lgquery']['lane']   = 0;
		$data['lgquery']['hpys']   = 0;
		$data['lgquery']['ppdm']   = '0';
		$data['lgquery']['cllx']   = '0';
		$data['lgquery']['csys']   = '0';
		$data['lgquery']['st']     = mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
		$data['lgquery']['et']     = mdate("%Y-%m-%d %H:%i:%s");
		
		$this->session->set_userdata('lgquery',$data['lgquery']);
		
		$this->load->view('logo/lgquery2',$data);
	}
	
	function test_se()
	{
		if($this->session->userdata('test')){
			echo 'true';
		}else {
			echo 'false';
			$this->session->set_userdata('test','test123');
		}
	}
	
	function lgquery()
	{
		//var_dump($this->session->all_userdata());
		session_start(); 
		#echo $_SESSION['name'];  
		if(isset($_SESSION["user"])){	
			echo $_SESSION["user"];
		}else {
			echo "session为空";
		}
		if ($this->session->userdata('lgquery')) {
			$data['lgquery'] = $this->session->userdata('lgquery');
		}else {
			$data['lgquery']['page']   = 1;
			$data['lgquery']['rows']   = 10;
			$data['lgquery']['sort']   = 'i.id';
		    $data['lgquery']['order']  = 'desc';
		    $data['lgquery']['offset'] = 0;
			$data['lgquery']['number'] = '?';
			$data['lgquery']['carnum'] = '';
			$data['lgquery']['place']  = 0;
			$data['lgquery']['dire']   = 0;
			$data['lgquery']['lane']   = 0;
			$data['lgquery']['hpys']   = 0;
			$data['lgquery']['ppdm']   = '0';
			$data['lgquery']['cllx']   = '0';
			$data['lgquery']['csys']   = '0';
			$data['lgquery']['st']     = mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
			$data['lgquery']['et']     = mdate("%Y-%m-%d %H:%i:%s");
			
			$this->session->set_userdata('lgquery',$data['lgquery']);
		}
		
		$data['title'] = '车标查询';
		
		$this->load->view('logo/lgquery',$data);
	}
	
	function load_lgquery()
	{	
		$data = $this->session->userdata('lgquery');
		#var_dump($data);
		$data['page']  = $this->input->post('page') ? intval($this->input->post('page')) : $data['page'];
		$data['rows']  = $this->input->post('rows') ? intval($this->input->post('rows')) : $data['rows'];
		$data['sort']  = $this->input->post('sort') ? strval($this->input->post('sort')) : $data['sort'];
	    $data['order'] = $this->input->post('order') ? strval($this->input->post('order')) : $data['order'];
	    $data['offset']= ($data['page']-1)*$data['rows'];

	    $data['place'] = $this->input->post('place') ? $this->input->post('place'): $data['place'];
		$data['lane']  = $this->input->post('lane')  ? $this->input->post('lane') : $data['lane'];
		$data['dire']  = $this->input->post('dire')  ? $this->input->post('dire') : $data['dire'];
		$data['hpys']  = $this->input->post('hpys')  ? $this->input->post('hpys') : $data['hpys'];
		$data['ppdm']  = $this->input->post('ppdm')  ? $this->input->post('ppdm') : $data['ppdm'];
		$data['cllx']  = $this->input->post('cllx')  ? $this->input->post('cllx') : $data['cllx'];
		$data['csys']  = $this->input->post('csys')  ? $this->input->post('csys') : $data['csys'];
		$data['st']    = $this->input->post('st')    ? $this->input->post('st') : $data['st'];
		$data['et']    = $this->input->post('et')    ? $this->input->post('et') : $data['et'];
		$data['number']= $this->input->post('number')? iconv("UTF-8","GBK//IGNORE",$this->input->post('number',True)) : $data['number'];
		$data['carnum']= $this->input->post('carnum')? iconv("UTF-8","GBK//IGNORE",$this->input->post('carnum',True)) : $data['carnum'];
		$data['platename'] = format_carnum($data['number'],$data['carnum']);
		//var_dump($data);
		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Mlogo->get_carinfo3($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array());
		$result['total'] = $this->Mlogo->get_carinfo3(0,0,$data['sort'],$data['order'],$data)->row()->sum;
		
		$data['total'] = $result['total'];
		$this->session->set_userdata('lgquery',$data);
		
		echo json_encode($result);
	}
	
	function cmpquery()
	{
		#var_dump($this->session->all_userdata());
		if ($this->session->userdata('cmpquery')) {
			$data['cmpquery'] = $this->session->userdata('cmpquery');
		}else {
			$data['cmpquery']['page']   = 1;
			$data['cmpquery']['rows']   = 10;
			$data['cmpquery']['sort']   = 'i.id';
		    $data['cmpquery']['order']  = 'desc';
		    $data['cmpquery']['offset'] = 0;
			$data['cmpquery']['number'] = '?';
			$data['cmpquery']['carnum'] = '';
			$data['cmpquery']['place']  = 0;
			$data['cmpquery']['dire']   = 0;
			$data['cmpquery']['ppdm']   = '0';
			$data['cmpquery']['smsflag']  = 'all';
			$data['cmpquery']['clppflag'] = 'all';
			$data['cmpquery']['confirm']  = 'all';
			$data['cmpquery']['st']     = mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
			$data['cmpquery']['et']     = mdate("%Y-%m-%d %H:%i:%s");
			
			$this->session->set_userdata('cmpquery',$data['cmpquery']);
		}
		
		$data['title'] = '匹配查询';
		
		$this->load->view('logo/cmpquery',$data);
	}
	
	function load_cmpquery()
	{	
		$data = $this->session->userdata('cmpquery');
		
		$data['page']  = $this->input->post('page') ? intval($this->input->post('page')) : $data['page'];
		$data['rows']  = $this->input->post('rows') ? intval($this->input->post('rows')) : $data['rows'];
		$data['sort']  = $this->input->post('sort') ? strval($this->input->post('sort')) : $data['sort'];
	    $data['order'] = $this->input->post('order') ? strval($this->input->post('order')) : $data['order'];
	    $data['offset']= ($data['page']-1)*$data['rows'];

	    $data['place'] = $this->input->post('place') ? $this->input->post('place'): $data['place'];
		$data['dire']  = $this->input->post('dire')  ? $this->input->post('dire') : $data['dire'];
		$data['ppdm']  = $this->input->post('ppdm')  ? $this->input->post('ppdm') : $data['ppdm'];
		$data['smsflag']  = $this->input->post('smsflag')  ? $this->input->post('smsflag') : $data['smsflag'];
		$data['clppflag'] = $this->input->post('clppflag') ? $this->input->post('clppflag') : $data['clppflag'];
		$data['confirm']  = $this->input->post('confirm')  ? $this->input->post('confirm') : $data['confirm'];
		$data['st']    = $this->input->post('st')    ? $this->input->post('st') : $data['st'];
		$data['et']    = $this->input->post('et')    ? $this->input->post('et') : $data['et'];
		$data['number']= $this->input->post('number')? iconv("UTF-8","GBK//IGNORE",$this->input->post('number',True)) : $data['number'];
		$data['carnum']= $this->input->post('carnum')? iconv("UTF-8","GBK//IGNORE",$this->input->post('carnum',True)) : $data['carnum'];
		$data['platename'] = format_carnum($data['number'],$data['carnum']);
		
		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Mlogo->get_confirm_carinfo3($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array());
		$result['total'] = $this->Mlogo->get_confirm_carinfo3(0,0,$data['sort'],$data['order'],$data)->row()->sum;
		
		$data['total'] = $result['total'];
		$this->session->set_userdata('cmpquery',$data);
		
		echo json_encode($result);
	}
	
	function test()
	{
		#Session_Start();
		#$_SESSION["name"]="fire";
		#echo $_SESSION["name"];
		$this->load->view('logo/test');
	}
	
	function lgdetail()
	{
		//$lgquery = $this->session->userdata('lgquery');
		//$offset = $lgquery['offset'];
		#var_dump($this->session->all_userdata());
		$data = $this->input->get(NULL);
		$data['id']    = intval($data['id']);
		$data['index'] = intval($data['index']);
		$data['ids']   = explode(',', $data['ids']);
		array_pop($data['ids']);
		foreach ($data['ids'] as $key=>$val){
			$data['ids'][$key] = intval($val);
		}
		$data['ids'] = json_encode($data['ids']);
		$data['title'] = '车辆详细信息';
		
		$this->load->view('logo/lgdetail',$data);
	}
	
	function cmpdetail()
	{
		//$lgquery = $this->session->userdata('lgquery');
		//$offset = $lgquery['offset'];
		$data = $this->input->get(NULL);
		$data['id']    = intval($data['id']);
		$data['index'] = intval($data['index']);
		$data['ids']   = explode(',', $data['ids']);
		array_pop($data['ids']);
		foreach ($data['ids'] as $key=>$val){
			$data['ids'][$key] = intval($val);
		}
		$data['ids'] = json_encode($data['ids']);
		$data['title'] = '车辆详细信息';
		
		$this->load->view('logo/cmpdetail',$data);
	}
	
	function lgdetail2()
	{
		$data = $this->input->get(NULL);
		$data['ids'] = explode(',', $data['ids']);
		array_pop($data['ids']);
		foreach ($data['ids'] as $key=>$val){
			$data['ids'][$key] = intval($val);
		}
		$data['ids'] = json_encode($data['ids']);
		$data['id']  = intval($data['id']);
		$data['title'] = '车辆详细信息';
		
		#var_dump($data);
		$this->load->view('logo/lgdetail',$data);
	}
	
	function get_lg_ids()
	{
		$offset = $this->input->post('offset');
		$rows   = $this->input->post('rows');
		
		$data = $this->session->userdata('lgquery');

		$rows = $this->Mlogo->get_carinfo3($offset,$rows,$data['sort'],$data['order'],$data)->result_array();

		$result["total"] = $this->Mlogo->get_carinfo3(0,0,$data['sort'],$data['order'],$data)->row()->sum;
		foreach ($rows as $key=>$val){
			$result['ids'][$key] = $val['id'];
		}
		$result['success'] = True;
		
		echo json_encode($result);
	}

	function get_cmp_ids()
	{
		$offset = $this->input->post('offset');
		$rows   = $this->input->post('rows');
		
		$data = $this->session->userdata('cmpquery');

		$rows = $this->Mlogo->get_confirm_carinfo3($offset,$rows,$data['sort'],$data['order'],$data)->result_array();

		$result['total'] = $this->Mlogo->get_confirm_carinfo3(0,0,$data['sort'],$data['order'],$data)->row()->sum;
		foreach ($rows as $key=>$val){
			$result['ids'][$key] = $val['id'];
		}
		$result['success'] = True;
		
		echo json_encode($result);
	}
	
	function real_select()
	{
		$data['title'] = '实时查询';
		
		$this->load->view('logo/realselect',$data);
	}
	
	function load_realselect()
	{
		$this->load->model('Muser2');
		$role_id = 1;
		$array = array();
		if ($role_id == 1){
			$array = array();
		}else{
			$role = $this->Muser2->get_role_by_id($role_id);
			$array = explode(',',$role->openkakou);
		}
		$query = $this->Mlogo->get_places_for_real($array);

		$result['rows']  = $this->lib_kakou->icon_to_utf8($query->result_array());
		$result['total'] = $query->num_rows();
		
		echo json_encode($result);
	}
	
	function real_detail()
	{
		$data['title'] = '实时显示';
		$da['place'] = $this->input->get('ids', True);
		$da['dire']  = 0;
		$da['clppflag'] = $this->input->get('clppflag', True);
		$this->session->set_userdata('realdetail', $da);
		
		$this->load->view('logo/realdetail',$data);
	}
	
	function load_real_detail()
	{
		$realdetail = $this->session->userdata('realdetail');
		$data['place'] = explode(',',$realdetail['place']);
		$data['dire']  = 0;
		$data['clppflag']  = $realdetail['clppflag'];
		//$data['dire']  = $this->input->get('dire') ? explode(',',$this->input->post('dire', True)) : 0;
		$pastdate = strtotime("-24 hours");
        $data['time'] = mdate("%Y-%m-%d %H:%i:%s",$pastdate);
        
		$query = $this->Mlogo->get_real_carinfo(0, 8, $data);
		$result['rows']  = $this->lib_kakou->icon_to_utf8($query->result_array());
		$result['total'] = $query->num_rows();
		
		echo json_encode($result);
	}
	
	function car_info()
	{
		$data['id'] = $this->input->get('id', True);
		
		$this->load->view('logo/carinfo',$data);
	}
	
	function sms_list()
	{
		$data['title'] = '短信编辑';
		 
		$this->load->view('logo/sms_list',$data);
	}
	
	//加载短信列表数据
	function sms_list_data()
	{
		$page = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$rows = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$sort = $this->input->post('sort') ? strval($this->input->post('sort')) : 'id';
	    $order = $this->input->post('order') ? strval($this->input->post('order')) : 'asc';
	    $offset = ($page-1)*$rows;
	 

		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Msms->get_sms($offset,$rows,$sort,$order,array())->result_array());
		$result['total'] = $this->Msms->get_sms(0,0,$sort,$order,array())->row()->sum;
		
		echo json_encode($result);
	}
	
	//添加短信
	function sms_add()
	{
		$data['tel']  = $this->input->post('tel',True);
		$data['mark'] = $this->input->post('mark',True);

		$result['success'] = $this->Msms->add_sms($data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','添加短信成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		
		echo json_encode($result);
	}
	
	//编辑短信
	function sms_edit()
	{
		$id = $this->input->get('id',True);

		$data['tel']  = $this->input->post('tel',True);
		$data['mark'] = $this->input->post('mark',True);

		
		$result['success'] = $this->Msms->edit_sms($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','编辑短信成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		
		echo json_encode($result);
	}
	
	//删除短信
	function sms_del()
	{
		$id = $this->input->post('id',True);
		$data['banned']  = 1;
		
		$result['success'] = $this->Msms->edit_sms($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','删除短信成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		
		echo json_encode($result);
	}
	
	function load_data()
	{
		$data = '{"total":28,"rows":[
	{"productid":"财经郎眼","productname":"Koi","unitcost":10.00,"status":"P","listprice":36.50,"attr1":"Large","itemid":"EST-1"},
	{"productid":"K9-DL-01","productname":"Dalmation","unitcost":12.00,"status":"P","listprice":18.50,"attr1":"Spotted Adult Female","itemid":"EST-10"},
	{"productid":"RP-SN-01","productname":"Rattlesnake","unitcost":12.00,"status":"P","listprice":38.50,"attr1":"Venomless","itemid":"EST-11"},
	{"productid":"RP-SN-01","productname":"Rattlesnake","unitcost":12.00,"status":"P","listprice":26.50,"attr1":"Rattleless","itemid":"EST-12"},
	{"productid":"RP-LI-02","productname":"Iguana","unitcost":12.00,"status":"P","listprice":35.50,"attr1":"Green Adult","itemid":"EST-13"},
	{"productid":"FL-DSH-01","productname":"Manx","unitcost":12.00,"status":"P","listprice":158.50,"attr1":"Tailless","itemid":"EST-14"},
	{"productid":"FL-DSH-01","productname":"Manx","unitcost":12.00,"status":"P","listprice":83.50,"attr1":"With tail","itemid":"EST-15"},
	{"productid":"FL-DLH-02","productname":"Persian","unitcost":12.00,"status":"P","listprice":23.50,"attr1":"Adult Female","itemid":"EST-16"},
	{"productid":"FL-DLH-02","productname":"Persian","unitcost":12.00,"status":"P","listprice":89.50,"attr1":"Adult Male","itemid":"EST-17"},
	{"productid":"AV-CB-01","productname":"Amazon Parrot","unitcost":92.00,"status":"P","listprice":63.50,"attr1":"Adult Male","itemid":"EST-18"}
]}';
		#var_dump($this->input->post(NULL));
		echo iconv("GBK","UTF-8//IGNORE",$data);#json_encode($data);
	}
	
}