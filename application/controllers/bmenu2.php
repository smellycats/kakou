<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 黑名单管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Bmenu extends Admin_Controller
{
	//布控原因
	protected $reason1 = array('请选择','盗抢车辆','肇事逃逸','多次违章','其他');
	protected $reason2 = array('盗抢车辆','肇事逃逸','多次违章','其他');
	
	//处理状态
	protected $state1  = array('请选择','待审核','已审核','已撤控');
	protected $state2  = array('待审核','已审核','已撤控');
	
	//车牌号码
	protected $number = array('?','WJ','闽','粤','苏','浙','沪','京','津','冀','晋','蒙','辽','吉','黑','皖','赣','鲁','豫','鄂','湘','桂','琼','川','贵','云','藏','陕','甘','青','宁','新','台','渝','港','澳','军','海','空','沈','北','兰','济','南','成','广');
	//车牌颜色
	protected $color  = array('无','蓝牌','黄牌','白牌','黑牌');
	
	protected $reason = array('盗抢车辆','肇事逃逸','多次违章','其他');
	
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
	
	//加载黑名单视图
	function cpbk()
	{
		//车牌号码
		$data['number'] = $this->number;
		//车牌颜色
		$data['color'] = $this->color;
		//布控原因
		$data['reason'] = $this->reason;
		//登录用户
		$data['user'] = $this->session->userdata('DX_username');
		
		$datestring = "%Y-%m-%d %h:%i:%s";
		$data['starttime'] = date('Y-m-d H:i:s',time());
        $futuredate = strtotime("next month");
        $data['endtime'] = date('Y-m-d H:i:s',$futuredate);
		
		$this->load->view('bmenu/cpbk', $data);
	}
	
	//添加布控信息
	function add_bk()
	{
		$this->form_validation->set_rules('carnum', '车牌号码', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('cartype', '车辆类型', 'trim|xss_clean|max_length[16]');
		$this->form_validation->set_rules('linkman', '联系人', 'trim|required|xss_clean|max_length[20]');
		//$this->form_validation->set_rules('mobnum', '手机号码', 'trim|xss_clean|max_length[20]');
		$this->form_validation->set_rules('telnum', '电话', 'trim|required|xss_clean|max_length[20]');
		//$this->form_validation->set_rules('bktype', '布控类型', 'trim|xss_clean|max_length[20]');
		//$this->form_validation->set_rules('bkdepartment', '布控单位', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('introduction', '案情简介', 'trim|xss_clean|max_length[200]');
		$this->form_validation->set_rules('mobiles', '手机号', 'trim|xss_clean|max_length[800]');
		
		$this->form_validation->set_message('max_length', '字符超出额定位数.');
		$this->form_validation->set_message('required', '不能为空.');
		$this->form_validation->set_message('is_unique', '%s已经存在.' );
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$data['starttime'] = $this->input->post('starttime');
		#$data['endtime']  = $this->input->post('endtime');
		
		if($this->form_validation->run() == false)
		{
    		//车牌号码
	    	$data['number'] = $this->number;
	    	//车牌颜色
	    	$data['color'] = $this->color;
	    	//布控原因
	    	$data['reason'] = $this->reason;
	    	//登录用户
	    	$data['user'] = $this->session->userdata('DX_username');
		
	    	$this->load->view('bmenu/cpbk', $data);
		}
		else
		{
			$futuredate = strtotime("next month");

			$number = $this->input->post('number');
			$carnum = $this->input->post('carnum');
			$number = str_replace('?', '_', $number);
			$number = str_replace('？', '_', $number);
			$carnum = str_replace('?', '_', $carnum);
            $carnum = str_replace('？', '_', $carnum);
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
		    	showmessage('布控设置成功', 'bmenu/cpbk');
		    }
		    else 
		    {
		        showmessage('操作失败，系统繁忙或着填写错误', 'bmenu/cpbk');
		    }
		}
	}
	
	//布控查询视图
	function bkfind()
	{
	 	$data['sel_carnum'] = '';
	    $data['sel_bkr']    = '';
		$data['sel_reason'] = '请选择';
		$data['sel_state']  = '请选择';
        $da['carnum'] = '';
	    $da['bkr']    = '';
		$da['reason'] = '请选择';
		$da['state']  = '请选择';
				
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
		$config['first_link']     = '第一页';
		$config['last_link']      = '尾页';
		$config['next_link']      = '下一页';
		$config['prev_link']      = '上一页';

		//$this->pagination->initialize($config);
		
		//布控原因
		$data['reason'] = $this->reason1;
		//布控状态
		$data['state']  = $this->state1;
		
		$this->load->view('bmenu/bkfind', $data);
	}
	
	//布控查询搜索
	function bkfind_search()
	{
		$this->form_validation->set_rules('carnum', '车牌号码', 'trim|xss_clean|max_length[20]');
		$this->form_validation->set_rules('bkr', '布控人', 'trim|xss_clean|max_length[20]');
		
		$this->form_validation->set_message('max_length', '%s字符超出额定长度.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
	    if($this->form_validation->run() == false)
		{
	    	//布控原因
	    	$data['reason'] = $this->reason1;
	    	//布控状态
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
	    	//布控原因
	    	$da['reason'] = $this->reason1;
	    	//布控状态
	    	$da['state'] = $this->state1;
	    	
	    	$this->load->view('bmenu/bkfind', $da);
		}		
		
	}
	
	//根据条件查询布控信息
	function bkfind_search_ok()
	{
		//$this->form_validation->set_rules('carnum', '车牌号码', 'trim|xss_clean|max_length[20]');
		//$this->form_validation->set_rules('bkr', '布控人', 'trim|xss_clean|max_length[20]');
		
		//$this->form_validation->set_message('max_length', '%s字符超出额定长度.');
		//$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$this->_add_oplog('车辆布控查询.');
		
		$per_page = $this->input->get('per_page');           //页面偏移量
		
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
		$config['first_link']     = '第一页';
		$config['last_link']      = '尾页';
		$config['next_link']      = '下一页';
		$config['prev_link']      = '上一页';
	
		$this->pagination->initialize($config);
		//$data['bk'] = $this->Mbmenu->get_bk_all()->result();
		
		$data['reason'] = $this->reason1;
		$data['state']  = $this->state1;
		
		$data['ck_right'] = $this->_check_right();
			
		$this->load->view('bmenu/bkfind', $data);
	}
	
	
	//撤控
	function edit_bk_ck()
	{
		$id = $this->uri->segment(3);
		
		$data['bk'] = $this->Mbmenu->get_bkcp_by_id($id)->row();
	    
	    $this->load->view('bmenu/delbk', $data);
	}
	
	//提交撤控表单
	function edit_bk_ck_ok()
	{
		$this->form_validation->set_rules('ckreason', '撤控原因', 'trim|xss_clean|max_length[200]');		
		$this->form_validation->set_message('max_length', '%s不超过200位字符');
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
		    	showmessage('撤控操作成功,请等待审核!', 'bmenu/bkfind');
		    }
		    else 
		    {
		        showmessage('操作失败，系统繁忙或着填写错误', 'bmenu/bkfind');
		    }
		}
	}
	
	//撤控审核
	function edit_bk_cksh()
	{
		$data['user'] = $this->session->userdata('DX_username');
		
		$id = $this->uri->segment(3);
		
		$res = $this->Mbmenu->edit_bkcp_cksh($id, $data);
		
		if($res)
	    {
    	    showmessage('撤控审核成功!', 'bmenu/bkfind');
		}
	    else 
		{
            showmessage('操作失败，系统繁忙或着填写错误', 'bmenu/bkfind');
		}
		
	}
	
	//布控
	function edit_bk_bk()
	{
		$data['user'] = $this->session->userdata('DX_username');
		
		$id = $this->uri->segment(3);
		
		$res = $this->Mbmenu->edit_bkcp_bk($id, $data);
		
		if($res)
	    {
    	    showmessage('此车已进入布控状态!', 'bmenu/bkfind');
		}
	    else 
		{
            showmessage('操作失败，系统繁忙或着填写错误', 'bmenu/bkfind');
		}
	}
	
	//编辑布控信息
	function edit_bk_info()
	{   
		$data['id'] = $this->uri->segment(3);
	
		$data['bkinfo'] = $this->Mbmenu->get_bkcp_by_id($data['id'])->row();
	    //车牌颜色
	    $data['color'] = $this->color;
	    //布控原因
	    $data['reason'] = $this->reason2;
	    
	    $data['ck_right'] = $this->_check_right();
	    
		$this->load->view('bmenu/editbk', $data);
	}
	
	//提交编辑布控信息表单
	function edit_bk_info_ok()
	{  
		$id = $this->input->post('id');
		 
		$this->form_validation->set_rules('carnum', '车牌号码', 'trim|required|xss_clean|max_length[20]|callback_bk_carnum_check[' . $id . ']');
		$this->form_validation->set_rules('cartype', '车辆类型', 'trim|xss_clean|max_length[16]');
		$this->form_validation->set_rules('linkman', '布控联系人', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('telnum', '布控单位值班电话号码', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_rules('bktype', '布控类型', 'trim|xss_clean|max_length[20]');
		$this->form_validation->set_rules('introduction', '案情简介', 'trim|xss_clean|max_length[200]');
		$this->form_validation->set_rules('mobiles', '手机号', 'trim|xss_clean|max_length[800]');
		
		$this->form_validation->set_message('max_length', '字符超出额定位数.');
		$this->form_validation->set_message('required', '不能为空.');
		$this->form_validation->set_message('is_unique', '%s已经存在.' );
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$data['ck_right'] = $this->_check_right();
		if($this->form_validation->run() == false)
		{
			$data['bkinfo'] = $this->Mbmenu->get_bkcp_by_id($id)->row();
			$data['id'] = $id;
		    //车牌颜色
		    $data['color'] = $this->color;
		    //布控原因
		    $data['reason'] = $this->reason2;
	    	
		    $this->load->view('bmenu/editbk', $data);
		}
		else
		{
			$data['carnum'] = $this->input->post('carnum');
			$data['carnum'] = str_replace('?', '_', $data['carnum']);
            $data['carnum'] = str_replace('？', '_', $data['carnum']);
            			
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
		    	showmessage('布控信息修改成功', 'bmenu/bkfind');
		    }
		    else 
		    {
		        showmessage('操作失败，系统繁忙或着填写错误', 'bmenu/bkfind');
		    }
		}
	}
	
	//删除布控
	function del_bk()
	{
		$id = $this->uri->segment(3);
		
		$res = $this->Mbmenu->del_bkcp($id);
		
		if($res)
	    {
    	    showmessage('删除成功!', 'bmenu/bkfind');
		}
	    else 
		{
            showmessage('操作失败，系统繁忙或着填写错误', 'bmenu/bkfind');
		}
	}
	
	
	//回调函数检查布控车辆车牌号是否重复
	function bk_carnum_check($carnum,$id)
	{
		$carnum = str_replace('?', '_', $carnum);
        $carnum = str_replace('？', '_', $carnum);
        
        $result = $this->Mbmenu->check_carnum_unique($id, $carnum)->num_rows() == 0;
          		
		if (! $result)
		{
			$this->form_validation->set_message('bk_carnum_check', '布控车牌号已经存在.');
		}
				
		return $result;
	}
	
	//添加用户操作信息
	function _add_oplog($name)
	{
			$this->load->model('Mlog');
			
			$data['memo'] = $name . '布控号牌:(' . $this->input->get('carnum'). ').';
		    $data['memo'] = $data['memo'] . '布控人:(' . $this->input->get('bkr'). ')';
			$data['memo'] = $data['memo'] . '布控原因:(' .$this->input->get('reason'). ')';
			$data['memo'] = $data['memo'] . '状态:(' .$this->input->get('state'). ')';
			
			$data['czsj']     = mdate("%Y-%m-%d %H:%i:%s");
			$data['uname']    = $this->session->userdata('DX_username');
			$data['uip']      = $this->session->userdata('ip_address');
			$data['disabled'] = 0;
			
			$this->Mlog->add_userlog($data);
	}
	
	//判断是否有撤控权限
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
