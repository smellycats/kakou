<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 实时显示管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Show extends Admin_Controller
{
	//方向
	protected $direction = array('进城', '出城', '由东往西', '由南往北', '由西往东', '由北往南');
	//车牌颜色
	protected $color = array('蓝牌','黄牌','白牌','黑牌','其他');
	//车辆类型
	protected $cartype = array(  '01' => '01:大型汽车号牌',
		                         '02' => '02:小型汽车号牌',
		                         '03' => '03:使馆汽车号牌',
		                         '04' => '04:领馆汽车号牌',
		                         '05' => '05:境外汽车号牌',
		                         '06' => '06:外籍汽车号牌',
		                         '07' => '07:两、三轮摩托号牌', 
		                         '08' => '08:轻便摩托车号牌',
		                         '09' => '09:使馆摩托车号牌',
		                         '10' => '10:领馆摩托车号牌',
		                         '11' => '11:境外摩托车号牌',
		                         '12' => '12:外籍摩托车号牌',
		                         '13' => '13:农用运输车号牌',
		                         '14' => '14:拖拉机号牌',
		                         '15' => '15:挂车号牌',
		                         '16' => '16:教练汽车号牌',
		                         '17' => '17:教练摩托车号牌',
		                         '18' => '18:试验汽车号牌',
		                         '19' => '19:试验摩托车号牌',
		                         '20' => '20:临时入境汽车号牌',
		                         '21' => '21:临时入境摩托车号牌',
		                         '22' => '22:临时行使车号牌',
		                         '23' => '23:警用汽车号牌',
		                         '24' => '24:警用摩托号牌',
		                         '99' => '99:其它号牌',
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
    
    //根据权限获得 路口参数信息 
    function _get_openkakou_by_perm2($role_id)
    {
		$this->load->model('Muser');

		$sys['type_name']  = '卡口名称';
		$sys['type_value'] = '';
		
		if($role_id == '1') //判断是否管理员，管理员有所有路口参数权限
		{
			$sys['kakou_id'] = 'all';
		}
		else  //非管理员用户 要判断权限
		{
		    $sys['kakou_id'] = $this->Muser->get_role_by_id($role_id)->openkakou;
		}
		$data['config_info'] = $this->Msyst->get_config_info3($sys)->result();
		
		return $data;
    }
    		
    //实时显示
	function kkmap()
	{
		//获取用户角色ID
		//$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
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
			showmessage('请选择监控地点或方向', 'show/kkmap');	
		}
		else 
		{
			$data['kakou'] = implode('|', $this->input->post('kk', TRUE));
			$data['direction'] = '';
		
			$this->load->view('show/realshow', $data);
		}
	}
	
	//实时显示模块
	function realshowdiv()
	{
		//获取用户角色ID
		$role_id = $this->session->userdata('DX_role_id');
		
		$pastdate = strtotime("-2 hours");
		$da['time_flag'] = mdate("%Y-%m-%d %h:%i:%s",$pastdate);

		$arr_kakou = explode('|', $this->input->get('kakou'));  //把提交的卡口字符串拆分成数组
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
	    	$data['msg'] = '最近3小时没有数据！';
	    	$this->load->view('show/realshowerror', $data);
	    }

		
	}
	
	//显示通行车辆信息
	function show_showdetail()
	{
		$this->load->model('Mgate');
		
		$id = $this->uri->segment(3);
		
		$data['cardetail']      = $this->Mgate->get_car_by_id($id)->row();
		$data['option_cartype'] = $this->cartype;                             //获得车辆类型                                   
		$data['role_id']        = $this->session->userdata('DX_role_id');
		$data['option_color']   = $this->color;
		$data['pic_url']        = get_picurl($this->imgpath[$data['cardetail']->TPWZ], $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		$data['check_right'] = $this->_check_right();
		
		$this->load->view('show/show_showdetail', $data);
	}

	//报警实时显示
	function bjmap()
	{
		//获取用户角色ID	
		//$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($this->session->userdata('DX_role_id'));
		
		$this->load->view('show/bjmap', $data);
	}
	
	function bj_realshow()
	{
		if($this->input->post('kk', TRUE) == '')
		{
			showmessage('请选择监控地点', 'show/kkmap');	
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
		//获取用户角色ID
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
	    	$data['msg'] = '最近2小时没有数据！';
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
		
		$this->form_validation->set_rules('carnum', '车牌号码', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_message('max_length', '%s长度不能超过20位.');
		$this->form_validation->set_message('required', '%s不能为空.');
		//$this->form_validation->set_message('is_unique', '%s已经存在.' );
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
	
    //编辑报警车辆信息
    function edit_show_bj_showdetail()
    {
    	$this->load->model('Mgate');
    	
		$this->form_validation->set_rules('carnum', '车牌号码', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_message('max_length', '%s长度不能超过20位.');
		$this->form_validation->set_message('required', '%s不能为空.');
		//$this->form_validation->set_message('is_unique', '%s已经存在.' );
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
    		showmessage("删除车辆信息成功",'show/kkmap');
    	}
    	else 
    	{
            showmessage('操作失败，系统繁忙或着填写错误','show/kkmap');
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
	
	//核对车辆信息
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
				//$info= '{"res":"已核对"}';
				$info = '已核对';
			}
			else{
				//$info= '{"res":"数据库出错"}';
				$info = '数据库出错';
			}
		}
		echo $info;
	}
	
	//判断是否有核对权限
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


