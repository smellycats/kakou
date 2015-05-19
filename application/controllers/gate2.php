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

class Gate extends Admin_Controller
{
	//车道
	protected $lane = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');
	//方向
	protected $direction = array('进城', '出城', '由东往西', '由南往北', '由西往东', '由北往南');
	//车牌号码
	protected $number = array('R','?','-','WJ','闽','粤','苏','浙','沪','京','津','冀','晋','蒙','辽','吉','黑','皖','赣','鲁','豫','鄂','湘','桂','琼','川','贵','云','藏','陕','甘','青','宁','新','台','渝','港','澳','军','海','空','沈','北','兰','济','南','成','广');
	//报警类型
    protected $alarmtype = array('被盗抢车辆','套牌车辆','便衣嫌疑车辆','布控车辆');
    //违规类型
    protected $breakrule = array('超速','逆行','闯红灯','不按车道行驶');
    
    protected $record = array('已核对', '已审核','已处罚');
    //处理状态
    protected $dispose = array('警情未处理','车牌号码识别错误','车牌颜色识别错误','图像不清','已下达','不下达','未截获','已截获','查获被盗抢车','查获套牌车','查获交通违法车','与黑名单数据不符');
	
    protected $dispose2 = array('01'=>'警情未处理',
								'02'=>'车牌号码识别错误',
								'03'=>'车牌颜色识别错误',
								'04'=>'图像不清',
								'05'=>'已下达',
								'06'=>'不下达',
								'07'=>'未截获',
								'08'=>'已截获',
								'09'=>'查获被盗抢车',
								'10'=>'查获套牌车',
								'11'=>'查获交通违法车',
								'12'=>'与黑名单数据不符'
								);
    //车牌颜色
	protected $color = array('蓝牌','黄牌','白牌','黑牌','其他');
	
	protected $msg1 = '请选择查询条件.';
	
	protected $msg2 = '没有车辆记录！';
	
	protected $imgpath = array();
	
	//protected $imgpath = array('HDWJ-KKDATA1'=>'localhost:8082','HDWJ-KKDATA2'=>'localhost:8082',''=>'192.168.10.234:81');
	
	//protected $path = 'D:\SpreadData/';
	//图片批量下载数量
	//protected $imgs_num = 400;
	
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
	
	//加载车辆查询视图
	function carquery()
	{	
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;

		$data['lane']      = $this->lane;              //车道
		$data['direction'] = $this->direction;         //方向
		$data['number']    = $this->number;            //车牌号码
		$data['color']     = $this->color;             //车牌颜色
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('gate/carquery', $data);
	}
	
    //车辆查询表单
    function carquery_ok()
    {
    	$this->_add_oplog('车辆查询.', 0);
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		//$data['last_query'] = $this->db->last_query();

		$data['role_id'] = $role_id;
		$data['lane']    = $this->lane;              //车道
		$data['direction'] = $this->direction;    //方向
		$data['number']    = $this->number;          //车牌号码
		$data['color']     = $this->color;            //车牌颜色
		$data['message']   = $this->msg2;
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //监控点名称
		
		$per_page = $this->input->get('per_page');      //页面偏移量
		
		if ($this->input->get('type_alias') == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else
		{
			$da['okkval'] = "'" . $this->input->get('type_alias') . "'";
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
        
        $data['sel_spcarnum'] = $this->input->get('spcarnum');
        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = str_replace('，', ',', $this->input->get('spcarnum'));
        	//$spcarnum = str_replace(' ', ',', $spcarnum);
        	$spcarnum = explode(",", $spcarnum);   //特殊车牌号
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
    
        $da['starttime'] = $this->input->get('starttime');   //开始时间
        $data['sel_starttime'] = $da['starttime'];
        $da['endtime'] = $this->input->get('endtime');       //结束时间
        $data['sel_endtime'] = $da['endtime'];
        
        //替换字符串
        		
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$car_id = array();
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
		
		//把查询得到的车辆id(20个)和总行数添加到session
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);
        
		$this->load->view('gate/carquery', $data);
		
    }

    //根据权限获得 路口参数信息 
    function _get_openkakou_by_perm2($role_id)
    {    
		$openkakou_all = $this->Msyst->get_config_kakou($sys)->result();
		
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
	
	//缩略查询
	function slquery()
	{
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['lane'] = $this->lane;              //车道
		$data['direction'] = $this->direction;    //方向
		$data['number'] = $this->number;          //车牌号码
		$data['color'] = $this->color;            //车牌颜色
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('gate/slquery', $data);
	}
	
	function slquery_ok()
	{
		$this->_add_oplog('车辆查询.', 0);
		
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
		$data['lane'] = $this->lane;              //车道
		$data['direction'] = $this->direction;    //方向
		$data['number'] = $this->number;          //车牌号码
		$data['color'] = $this->color;            //车牌颜色
		$data['message'] = $this->msg2;
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //监控点名称
		
		$per_page   = $this->input->get('per_page');      //页面偏移量
		
		if ($this->input->get('type_alias') == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else
		{
			$da['okkval'] = "'" . $this->input->get('type_alias') . "'";
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
        $data['sel_spcarnum'] = $this->input->get('spcarnum');
        
        $data['img_base_url'] = $this->config->item('kakou_img_base_url');
		$data['xls_num']     = $this->config->item('kakou_xls_num');
		$data['img_num']     = $this->config->item('kakou_img_num');
		        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = explode(",", $this->input->get('spcarnum'));   //特殊车牌号
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
    
        $da['starttime'] = $this->input->get('starttime');   //开始时间
        $data['sel_starttime'] = $this->input->get('starttime');
        $da['endtime'] = $this->input->get('endtime');       //结束时间
        $data['sel_endtime'] = $this->input->get('endtime');
        
        //替换字符串
        		
		$this->load->library('pagination');
		
		// Get offset and limit for page viewing
		$offset = ($per_page == '' ? '0' : $per_page);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		
		//根据条件获取车辆信息
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$car_id = array();
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
		
		//把查询得到的车辆id(20个)和总行数添加到session
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);
        
		$this->load->view('gate/slquery', $data);
				
	}
	
	
	//违法查询
	function wzquery()
	{	
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);

		$data['record'] = $this->record;                  //记录状态
		$data['breakrule'] = $this->breakrule;            //违法类型
		$data['number'] = $this->number;                  //车牌号码
		$data['color'] = $this->color;                    //车牌颜色
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('gate/wzquery', $data);
	}
	
	function wzquery_ok()
	{
		$this->_add_oplog('违法车辆查询.', 1);
		
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
		$data['record']    = $this->record;               //记录状态
		$data['breakrule'] = $this->breakrule;             //违法类型
		$data['number']    = $this->number;                 //车牌号码
		$data['color']     = $this->color;                   //车牌颜色
		$data['message']   = $this->msg2;
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //监控点名称
		
		$per_page = $this->input->get('per_page');      //页面偏移量
		
		if ($this->input->get('type_alias') == 'all')
		{
			$da['okkval'] = change_to_quotes($data['okkval']);
		}
		else
		{
			$da['okkval'] = "'" . $this->input->get('type_alias') . "'";
		}
		
		$da['record'] = $this->input->get('record');       //车道
		$data['sel_record'] = $da['record'];
		$da['breakrule'] = $this->input->get('breakrule'); //方向
        $data['sel_breakrule'] = $da['breakrule'];
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
        $da['minspeed'] = $this->input->get('minspeed');     //最小速度
        $data['sel_minspeed'] = $da['minspeed']; 
        $da['maxspeed'] = $this->input->get('maxspeed');     //最大速度
        $data['sel_maxspeed'] = $da['maxspeed'];
                
        //替换字符串
        		
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);
		
		$car_id = array();
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
		
		//把查询得到的车辆id(20个)和总行数添加到session
        $this->session->set_userdata('car_ids', $car_id);
        $this->session->set_userdata('total_rows', $data['total_rows']);

		$this->load->view('gate/wzquery', $data);
				
	}
	
	
	
	//报警车辆查询
	function bjquery()
	{		
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);

        $data['alarmtype'] = $this->alarmtype;          //报警类型
        $data['dispose']   = $this->dispose;            //处理状态
		$data['number']    = $this->number;             //车牌号码
		$data['color']     = $this->color;              //车牌颜色
		
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('gate/bjquery', $data);
	}
	
	function bjquery_ok()
	{
		$this->_add_oplog('报警车辆查询.', 2);
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		$data['role_id'] = $role_id;
        $data['alarmtype'] = $this->alarmtype;          //报警类型
        $data['dispose']   = $this->dispose;            //处理状态
		$data['number']    = $this->number;             //车牌号码
		$data['color']     = $this->color;              //车牌颜色
		$data['message']   = $this->msg2;
		
		$data['sel_type_alias'] = $this->input->get('type_alias');    //监控点名称
		
		$per_page   = $this->input->get('per_page');      //页面偏移量
		
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
		
		$da['alarmtype'] = $this->input->get('alarmtype');       //报警类型
		$data['sel_alarmtype'] = $da['alarmtype'];
		$da['dispose'] = $this->input->get('dispose');           //处理状态
        $data['sel_dispose'] = $da['dispose'];
		$da['color'] = $this->input->get('color');               //颜色
        $data['sel_color'] = $da['color'];
        
        $da['number'] = $this->input->get('number');       //车牌编号
        $data['sel_number'] =$da['number'];
        $da['carnum'] = trim($this->input->get('carnum')); //车牌号码
        $data['sel_carnum'] =$da['carnum'];
    
        $da['starttime']     = $this->input->get('starttime');   //开始时间
        $data['sel_starttime'] = $da['starttime'];
        $da['endtime']       = $this->input->get('endtime');     //结束时间
        $data['sel_endtime'] = $da['endtime'];
                
        //替换字符串  		
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);
		
		$car_id = array();
		foreach ($data['car'] as $i=>$car)
		{
			$car_id[$i+$offset+1] = $car->ID;
		}
		
		//把查询得到的车辆id(20个)和总行数添加到session
		
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

		$data['cartype']   = $this->cartype;                             //获得车辆类型                                   
		$data['role_id']   = $this->session->userdata('DX_role_id');
		$data['color']     = $this->color;
		$data['cardetail'] = $this->Mgate->get_car_by_id($id)->row();
		//$data['pic_url']   = get_picurl($data['cardetail']->QMTP, $data['cardetail']->TJTP);
		$data['pic_url']   = get_picurl($this->config->item('kakou_img_base_url'), $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
		$this->load->view('gate/showdetail', $data);
	}
	
	//缩略车辆通行信息
	//2013-7-24
	//function slshowdetail2()
/*	{
		$id = $this->uri->segment(3);

		$data['cartype']   = $this->cartype;                             //获得车辆类型                                   
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
		$data['option_cartype']   = $this->cartype;                             //获得车辆类型                                   
		$data['role_id']          = $this->session->userdata('DX_role_id');
		$data['option_color']     = $this->color;
		$data['cardetail']        = $this->Mgate->get_car_by_id($id)->row();
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']          = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
        //检查是否有核对权限
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
		$data['option_cartype']   = $this->cartype;                             //获得车辆类型                                   
		$data['role_id']          = $this->session->userdata('DX_role_id');
		$data['option_color']     = $this->color;
		$data['cardetail']        = $this->Mgate->get_car_by_id($id)->row();
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']          = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
        //检查是否有核对权限
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
		$data['option_cartype']   = $this->cartype;                             //获得车辆类型                                   
		$data['role_id']          = $this->session->userdata('DX_role_id');
		$data['option_breakrule'] = $this->breakrule;
		$data['option_color']     = $this->color;
		$data['cardetail']        = $this->Mgate->get_car_by_id($id)->row();
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']          = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
        //检查是否有核对权限
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
		$data['option_cartype']   = $this->cartype;                             //获得车辆类型                                   
		$data['role_id']          = $this->session->userdata('DX_role_id');
		$data['option_color']     = $this->color;
		$data['option_dispose']   = $this->dispose2;
		$data['cardetail']        = $this->Mgate->get_car_by_id($id)->row();
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url']          = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		$data['sel_dispose']      = '警情未处理';
		
		//根据车牌号码获取黑名单布控信息
		$bm_data['carnum'] = $data['cardetail']->HPHM;
	    $bm_data['color']  = '';
	    $data['bmenu']     = $this->Mbmenu->get_bkcp_by_num($bm_data)->row();
	    //检查是否有核对权限
		$data['check_right'] = $this->_check_right();
			
		$this->load->view('gate/bj_showdetail', $data);
	}
	
	//保存核对过的车牌信息
    function edit_showdetail()
    {
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
		$imgp = $this->imgpath[$data['cardetail']->TPWZ];
		$data['pic_url'] = get_picurl($imgp, $data['cardetail']->QMTP, $data['cardetail']->TJTP);
		
    	//$this->load->view('gate/showdetail', $data);
       	echo "<script language='JavaScript'>alert('核对成功');window.history.go(-1);</script>";
    }
    
	//保存核对过的车牌信息
	//2013-7-24
    function edit_sl_showdetail()
    {
		$this->form_validation->set_rules('carnum', '车牌号码', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_message('max_length', '%s长度不能超过20位.');
		$this->form_validation->set_message('required', '%s不能为空.');
		//$this->form_validation->set_message('is_unique', '%s已经存在.' );
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
       	echo "<script language='JavaScript'>alert('核对成功');window.history.go(-1);</script>";
    }
    
    function edit_wz_showdetail()
    {
		$this->form_validation->set_rules('carnum', '车牌号码', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_message('max_length', '%s长度不能超过20位.');
		$this->form_validation->set_message('required', '%s不能为空.');
		//$this->form_validation->set_message('is_unique', '%s已经存在.' );
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
       	echo "<script language='JavaScript'>alert('核对成功');window.history.go(-1);</script>";
    }

    //编辑报警车辆信息
    function edit_bj_showdetail()
    {
		$this->form_validation->set_rules('carnum', '车牌号码', 'required|xss_clean|max_length[20]');
		$this->form_validation->set_message('max_length', '%s长度不能超过20位.');
		$this->form_validation->set_message('required', '%s不能为空.');
		//$this->form_validation->set_message('is_unique', '%s已经存在.' );
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
       	echo "<script language='JavaScript'>alert('核对成功');window.history.go(-1);</script>";
    }
    
    //删除车辆
    function del_showdetail()
    {
    	$id = $this->uri->segment(3);
    	
    	$res = $this->Mgate->del_car_by_id($id);
    	
/*    	if ($res)
		{
			showmessage('删除车辆信息成功', 'gate/carquery');
		}
		else
		{
			$uri = "gate/showdetail/" . $id;
			
			showmessage('操作失败，系统繁忙或着填写错误', $uri);
	    }*/
        if($res){
         	 echo "<script language='JavaScript'>alert('删除车辆信息成功');window.history.go(-1); </script>";
        }
        else{
             //如果插入失败，则报错
             echo "<script language='JavaScript'>alert('操作失败，系统繁忙或着填写错误');window.history.back(-1);</script>";
        }
    }
 
    //删除违章车辆
    function del_wz_showdetail()
    {
    	$id = $this->uri->segment(3);
    	
    	$res = $this->Mgate->del_car_by_id($id);
    	
        if($res){
       		echo "<script language='JavaScript'>alert('删除车辆信息成功');window.history.go(-1); </script>";
        }
        else{
            //如果插入失败，则报错
            echo "<script language='JavaScript'>alert('操作失败，系统繁忙或着填写错误');window.history.back(-1);</script>";
        }
    }

    //删除报警车辆 
    function del_bj_showdetail()
    {
    	$id = $this->uri->segment(3);
    	
    	$res = $this->Mgate->del_car_by_id($id);
    	
        if($res){
       		echo "<script language='JavaScript'>alert('删除车辆信息成功');window.history.go(-1); </script>";
        }
        else{
            //如果插入失败，则报错
            echo "<script language='JavaScript'>alert('操作失败，系统繁忙或着填写错误');window.history.back(-1);</script>";
        }
    }
    
    //导出数据到Excel
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
        $objPHPExcel->getProperties()->setTitle("卡口系统数据")
                                     ->setDescription("卡口系统生成的车辆查询数据");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '卡口系统Excel数据表'));
                    
        // Field names in the first row
        //$fields_name = array('号牌号码','号牌颜色','通过时间','监控点名称','方向','车道');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '车牌号码', '颜色', '通过时间', '监控点名称', '方向', '车道');
        
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
        //发送标题强制用户下载文件
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }

    //导出数据到Excel
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
        $objPHPExcel->getProperties()->setTitle("卡口系统数据")
                                     ->setDescription("卡口系统生成的车辆查询数据");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '卡口系统Excel数据表'));
                    
        // Field names in the first row
        //$fields_name = array('号牌号码','号牌颜色','通过时间','监控点名称','方向','车道');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH','CLSD');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '车牌号码', '颜色', '通过时间', '监控点名称', '方向', '车道', '车速', '违章类型');
        
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
            if($data->CLBJ=='O'){$wzlx = "超速";}
            elseif($data->CLBJ=='N'){$wzlx = "逆行";}
			elseif($data->JLLX=='2' || $data->JLLX=='3'){$wzlx = "闯红灯";}
			elseif($data->JLLX=='4'){$wzlx = "不按车道行驶";}
			else{$wzlx = '';}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $wzlx));
					    
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //发送标题强制用户下载文件
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    

  
    //导出数据到Excel
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
        $objPHPExcel->getProperties()->setTitle("卡口系统数据")
                                     ->setDescription("卡口系统生成的车辆查询数据");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '卡口系统Excel数据表'));
                    
        // Field names in the first row
        //$fields_name = array('号牌号码','号牌颜色','通过时间','监控点名称','方向','车道');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH','CLSD');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '车牌号码', '颜色', '通过时间', '监控点名称', '方向', '车道', '报警类型', '处理状态', '确认用户');
        
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
            
        	if($data->CLBJ =='B')   {$dispose = "临控";}
			elseif($data->CLBJ=='L'){$dispose = "布控";}
			elseif($data->CLBJ=='T'){$dispose = "套牌";}
			elseif($data->CLBJ=='D'){$dispose = "被盗抢";}
			elseif($data->CLBJ=='S'){$dispose = "便衣嫌疑";}
			elseif($data->CLBJ=='O'){$dispose = "超速";}   
			else{$dispose = '';}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $dispose));
			$col++;

        	if($data->CFBM == '' || $data->CFBM == '01' || $data->CFBM=='警情未处理'){$alarmtype = "警情未处理";}
			elseif($data->CFBM=='02'){$alarmtype = "号牌号码识别错误";}
			elseif($data->CFBM=='03'){$alarmtype = "号牌颜色识别错误";}
			elseif($data->CFBM=='04'){$alarmtype = "图像不清";}
			elseif($data->CFBM=='05'){$alarmtype = "已下达";}
			elseif($data->CFBM=='06'){$alarmtype = "不下达";}
			elseif($data->CFBM=='07'){$alarmtype = "未截获";}
			elseif($data->CFBM=='08'){$alarmtype = "被盗抢车";}
			elseif($data->CFBM=='09'){$alarmtype = "查获套牌车";}
			elseif($data->CFBM=='10'){$alarmtype = "交通违法车";}
			elseif($data->CFBM=='11'){$alarmtype = "与黑名单数据不符";}
			elseif($data->CFBM=='12'){$alarmtype = "数据更新不及时";}        
			else{$alarmtype = '';}
			$col++;
			
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //发送标题强制用户下载文件
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    
    //导出车辆图片
    function export_imgs()
    {
    	$this->_get_imgs_zip('0');
    }
    
    //导出违章车辆图片
    function export_wz_imgs()
    {
    	$this->_get_imgs_zip('1');
    }
    
    //导出报警车辆图片
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
		
		$da['lane']      = $this->input->get('lane');           //车道
		$da['direction'] = $this->input->get('direction');      //方向
		$da['color']     = $this->input->get('color');          //颜色
        $da['number']    = $this->input->get('number');         //车牌编号
        $da['carnum']    = trim($this->input->get('carnum'));   //车牌号码
        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = explode(",", $this->input->get('spcarnum'));   //特殊车牌号
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
    
        $da['starttime'] = $this->input->get('starttime');   //开始时间
        $da['endtime']   = $this->input->get('endtime');       //结束时间
        
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
		
		$da['breakrule'] = $this->input->get('breakrule');      //违章
		$da['record']    = $this->input->get('record');         //方向
		$da['color']     = $this->input->get('color');          //颜色
        $da['number']    = $this->input->get('number');         //车牌编号
        $da['carnum']    = trim($this->input->get('carnum'));   //车牌号码
        $da['minspeed']  = $this->input->get('minspeed');
        $da['maxspeed']  = $this->input->get('maxspeed');
        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = explode(",", $this->input->get('spcarnum'));   //特殊车牌号
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
    
        $da['starttime'] = $this->input->get('starttime');   //开始时间
        $da['endtime']   = $this->input->get('endtime');       //结束时间
        
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
		
		$da['dispose']   = $this->input->get('dispose');        //处理状态
		$da['color']     = $this->input->get('color');          //颜色
        $da['number']    = $this->input->get('number');         //车牌编号
        $da['carnum']    = trim($this->input->get('carnum'));   //车牌号码
        $da['alarmtype'] = $this->input->get('alarmtype');     //报警类型
        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = explode(",", $this->input->get('spcarnum'));   //特殊车牌号
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
    
        $da['starttime'] = $this->input->get('starttime');   //开始时间
        $da['endtime']   = $this->input->get('endtime');     //结束时间
        
        $da['cars'] = $this->Mgate->get_alarmcar_by_condition($offset, $row_count, $da);
        
        return $da;
	}
	
	function _get_car_data($sel_da)
	{
		$this->load->model('Msyst');
		
		$role_id = $this->session->userdata('DX_role_id');
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		//$data['sel_type_alias'] = $this->input->get('type_alias');    //监控点名称
		
		//$per_page = $this->input->get('per_page');      //页面偏移量
		
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
        	$spcarnum = explode(",", $sel_da['spcarnum']);   //特殊车牌号
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
    
        
        //替换字符串
        		
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
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		//$data['sel_type_alias'] = $this->input->get('type_alias');    //监控点名称
		
		//$per_page = $this->input->get('per_page');      //页面偏移量
		
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
        	$spcarnum = explode(",", $sel_da['spcarnum']);   //特殊车牌号
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
    
        
        //替换字符串
        		
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
		
		//根据权限获得路口参数信息 
		$data = $this->_get_openkakou_by_perm($role_id);
		
		//$data['sel_type_alias'] = $this->input->get('type_alias');    //监控点名称
		
		//$per_page = $this->input->get('per_page');      //页面偏移量
		
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
	
	
	//核对车辆信息
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
		
		$comp = iconv('gbk','utf-8','已下达');
		if($this->input->get('dispose') == $comp AND $data['jyqk'] == '')
		{
			$da['meg'] = '简要情况不能为空';
			$da['info'] = '简要情况不能为空';
		}
		else{
			$res = $this->Mgate->handle_by_id($id, $data);
			if($res){
				$da['cfsj'] = $data['cfsj'];
				$da['user'] = $data['user'];
				$da['info'] = '保存成功';
			}
			else{
				$da['info'] = '数据库出错';
			}
		}
		$da['info'] = iconv('gbk','utf-8',$da['info']);
		$da['meg']  = iconv('gbk','utf-8',$da['meg']);
		echo json_encode($da);
	}
	
	//添加用户操作信息
	function _add_oplog($name,$type)
	{
		$this->load->model('Mlog');
			
		$type_alias = $this->input->get('type_alias');          //监控点名称
        $number     = $this->input->get('number');              //车牌编号
        $carnum     = trim($this->input->get('carnum'));        //车牌号码   
        $starttime  = $this->input->get('starttime');           //开始时间
        $endtime    = $this->input->get('endtime');              //结束时间
        
/*        $lane       = empty($this->input->get('lane'))? '' : $this->input->get('lane');                //车道
		$direction  = empty($this->input->get('direction'))? '' : $this->input->get('direction');      //方向
		$color      = empty($this->input->get('color'))? '' : $this->input->get('color');              //颜色   
        $spcarnum   = empty($this->input->get('spcarnum'))? '' : $this->input->get('spcarnum');        //特定牌号*/
        $lane       = $this->input->get('lane') == ''? '': '车道：('. $this->input->get('lane') . ').';              //车道
		$direction  = $this->input->get('direction') == ''? '': '方向：('. $this->input->get('direction') . ').';       //方向
		$color      = $this->input->get('color');           //颜色   
        $spcarnum   = $this->input->get('spcarnum');        //特定牌号 
        $record     = $this->input->get('record');
		$breakrule  = $this->input->get('breakrule');
        $minspeed   = $this->input->get('minspeed');
        $maxspeed   = $this->input->get('maxspeed');
        $alarmtype  = $this->input->get('alarmtype');          //报警类型
        $dispose    = $this->input->get('dispose');            //处理状态
        
        $data['memo'] = $name . '查询时间段:('.$starttime. '至' . $endtime . ').' . '查询卡口:(' . $type_alias . ').' . '车牌号码:(' .$number . $carnum . ').' . '颜色：('. $color . ').';
		if($type == 0)
		{
			$data['memo'] = $data['memo'] . '特定号牌：(' . $spcarnum . ').' . $lane . $direction;
		}
		elseif($type == 1)
		{
			$data['memo'] = $data['memo'] .'违法类型：('.$breakrule. ').'. '速度：('. $minspeed . '-' . $maxspeed . ').'; 
		}
		elseif($type == 2)
		{
		 	$data['memo'] = $data['memo'] . '报警类型：(' . $alarmtype . ').' . '处理状态：(' . $dispose . ').';
		}
		
		$data['czsj']     = mdate("%Y-%m-%d %H:%i:%s");
		$data['uname']    = $this->session->userdata('DX_username');
		$data['uip']      = $this->session->userdata('ip_address');
		$data['disabled'] = 0;
			
		$this->Mlog->add_userlog($data);
	}
	
	//获取车辆图片
	function get_car_imgs()
	{
		$excel_data = $this->_get_excel_data(0, 1000);
        $query = $excel_data['cars'];
        
        download_img($query->result());
	}
	
	//ZIP测试1
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
	
	//ZIP测试2
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

		$ZipArchive->open($zipname.'.zip',ZipArchive::OVERWRITE);//创建一个空的zip文件
		
		//$cars = $excel_data['cars']->result();
		
			
		$ZipArchive->addFile($file1, basename($file1));
		$ZipArchive->addFile($file2, basename($file2));
		
		$ZipArchive->close();
	}
	
    //批量下载图片
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

		$ZipArchive->open($zipname.'.zip',ZipArchive::OVERWRITE);//创建一个空的zip文件

		//type = 0:普通车辆; 1:违章车辆; 2:报警车辆.
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
		
        $dw = new download($zipname.'.zip');  //新建下载文件类
        $dw->getfiles();
        unlink($zipname.'.zip');  //下载完成后要进行删除  
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