<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 系统设置控制器
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
	
	
	//回调函数检查报警IP地址是否重复
	function alarmip_check($alarm_ip)
	{
		$result = $this->Msyst->is_alarm_ip_available($alarm_ip);
		if ( ! $result)
		{
			$this->form_validation->set_message('alarmip_check', '报警点IP已经存在.');
		}
				
		return $result;
	}
	
	//报警点列表
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('syst/alarm_point', $data);
	}
	
	//添加报警点
	function add_alarmpoint()
	{
		$this->form_validation->set_rules('alarm_ip', '报警点IP', 'required|xss_clean|callback_alarmip_check');
		$this->form_validation->set_message('is_unique', '%s已经存在.' );
		$this->form_validation->set_message('required', '%s不能为空.');
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
	    	$config['first_link'] = '第一页';
    		$config['last_link'] = '尾页';
    		$config['next_link'] = '下一页';
    		$config['prev_link'] = '上一页';

	    	$this->pagination->initialize($config);

	    	$this->load->view('syst/alarm_point', $data);
		}
		else
		{
		    $res = $this->Msyst->create_alarmpoint($data);
		
    	    if ($res)
		    {
	     		showmessage('添加角色成功', 'syst/alarm_point');
	    	}
    		else
		    {
		    	showmessage('操作失败，系统繁忙或着填写错误', 'syst/alarm_point');
		    }
		}
	}
	
	
	//加载修改报警点信息页面
	function edit_alarmpoint()
	{
		$value = $this->uri->segment(3);
		
		//根据报警点IP获取alarm_point表的信息
		$data['alarm_point'] = $this->Msyst->get_alarmpoint_by_ip($value)->result();

		$this->load->view('syst/edit_alarmpoint', $data);
	}
	
	//修改报警点名称
	function edit_alarmpoint_ok()
	{
		$data['alarm_ip']   = $this->input->post('alarm_ip');
		$data['alarm_name'] = $this->input->post('alarm_name');
		
		$res = $this->Msyst->edit_alarmname($data);
	    	
		if ($res)
		{
			showmessage('修改报警点信息成功', 'syst/alarm_point');
		}
		else
		{
			showmessage('操作失败，系统繁忙或着填写错误', 'syst/alarm_point');
		}	
	}
	
	//删除报警点
	function del_alarmpoint()
	{
		$value = $this->uri->segment(3);
		
		$res = $this->Msyst->del_alarmpoint($value);
		
		if ($res)
		{
			showmessage('删除报警点成功', 'syst/alarm_point');
		}
		else
		{
			showmessage('操作失败，系统繁忙或着填写错误', 'syst/alarm_point');
		}
	}

	//系统信息设置列表
	function sysset2()
	{
		$sys['type_name']  = '卡口名称';
		$sys['type_value'] = '';

		$data['config_info'] = $this->Msyst->get_config_info($sys)->result();

		$this->load->view('syst/sysset', $data);
	}
	
	//系统信息设置列表
	function sysset()
	{
		$data['config_kakou'] = $this->Msyst->get_config_kakou()->result();

		$this->load->view('syst/sysset2', $data);
	}
	
	//加载“添加路口参数”视图
	function add_sysset()
	{
		$this->load->view('syst/add_sysset');
	}
	
	function add_sysset2()
	{
		$this->load->view('syst/add_sysset2');
	}
	
	//添加路口参数表单
	function add_sysset_ok()
	{
		$this->form_validation->set_rules('type_value', '路口名称', 'trim|required|xss_clean');
		$this->form_validation->set_rules('type_alias', '别名', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', '%s不能为空.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		$data['type_name']  = '卡口名称';
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
	     		showmessage('添加路口参数成功', 'syst/sysset');
	    	}
    		else
		    {
		    	showmessage('操作失败，系统繁忙或着填写错误', 'syst/sysset');
		    }
		}
	}
	
	//添加路口参数表单
	function add_sysset_ok2()
	{
		$this->form_validation->set_rules('kk_id', '路口ID', 'trim|required|xss_clean|callback_kkid_check');
		$this->form_validation->set_rules('kk_name', '路口名称', 'trim|required|xss_clean');
		$this->form_validation->set_rules('server_ip', '存储服务器IP', 'trim|required|xss_clean');
		$this->form_validation->set_rules('access_ip', '网关访问IP', 'trim|required|xss_clean');
		
		$this->form_validation->set_message('required', '%s不能为空.');
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
	     		showmessage('添加路口参数成功', 'syst/sysset');
	    	}
    		else
		    {
		    	showmessage('操作失败，系统繁忙或着填写错误', 'syst/sysset');
		    }
		}
	}
	
	//修改路口参数
	function edit_sysset()
	{
		$id = $this->uri->segment(3);
		
		$data['config_info'] = $this->Msyst->get_config_info_by_id($id)->row();
		
		$this->load->view('syst/edit_sysset', $data);
	}

	//修改路口参数
	function edit_sysset2()
	{
		$id = $this->uri->segment(3);
		
		$data = $this->Msyst->get_config_kakou_by_id($id)->row_array();
		
		$this->load->view('syst/edit_sysset2', $data);
	}
		
	//修改路口参数表单
	function edit_sysset_ok()
	{
		$this->form_validation->set_rules('type_value', '路口名称', 'trim|required|xss_clean');
		$this->form_validation->set_rules('type_alias', '别名', 'trim|required|xss_clean');
		$this->form_validation->set_rules('type_def', '卡口类型', 'integer');
		$this->form_validation->set_message('required', '%s不能为空.');
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
			$data['type_name']  = '卡口名称';
	    	$data['type_value'] = $this->input->post('type_value');
		    $data['type_alias'] = $this->input->post('type_alias');
		    $data['type_def']   = $this->input->post('type_def');
		    
		    $res = $this->Msyst->edit_sysset($data);
		
    	    if ($res)
		    {
	     		showmessage('修改路口参数成功', 'syst/sysset');
	    	}
    		else
		    {
		    	showmessage('操作失败，系统繁忙或着填写错误', 'syst/sysset');
		    }
		}
	}
	
	//修改路口参数表单
	function edit_sysset_ok2()
	{
		$this->form_validation->set_rules('kk_id', '路口ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('kk_name', '路口名称', 'trim|required|xss_clean');
		$this->form_validation->set_rules('server_ip', '存储服务器IP', 'trim|required|xss_clean');
		$this->form_validation->set_rules('access_ip', '网关访问IP', 'trim|required|xss_clean');
		
		$this->form_validation->set_message('required', '%s不能为空.');
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
	     		showmessage('修改路口参数成功', 'syst/sysset');
	    	}
    		else
		    {
		    	showmessage('操作失败，系统繁忙或着填写错误', 'syst/sysset');
		    }
		}
	}
	
	//回调函数检查角色名是否重复
	function kkid_check()
	{
		#var_dump('123');
		$result = $this->Msyst->is_kkid_available($this->input->post('kk_id'));
		if ( ! $result)
		{
			$this->form_validation->set_message('kkid_check', '路口ID已经存在.');
		}
				
		return $result;
	}
	
	//删除路口参数
	function del_sysset()
	{
		$id = $this->uri->segment(3);
		
		$res = $this->Msyst->del_sysset($id);
		
		if ($res)
		{
			showmessage('删除路口参数成功', 'syst/sysset');
		}
		else
		{
			showmessage('操作失败，系统繁忙或着填写错误', 'syst/sysset');
		}
	}
	
	//删除路口参数
	function del_sysset2()
	{
		$id = $this->uri->segment(3);
		
		$res = $this->Msyst->del_sysset2($id);
		
		if ($res)
		{
			showmessage('删除路口参数成功', 'syst/sysset');
		}
		else
		{
			showmessage('操作失败，系统繁忙或着填写错误', 'syst/sysset');
		}
	}
	
	//用户日志 
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
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('syst/usersum', $data);
	}
	
	//加载关联报警点视图
	function alarm_rel()
	{
		$data['computer'] = $this->Msyst->get_computer_all()->result();
		
		$this->load->view('syst/alarm_rel', $data);
	}
	
	//关联报警点
	function edit_alarmrel()
	{
		$kakou_ip = $this->uri->segment(3);
		
		$data['computer'] = $this->Msyst->get_computer_by_name($kakou_ip);
		
		$data['alarm_point'] = $this->Msyst->get_alarmpoint_all(0, 0)->result();
		
		//根据路口IP获得路口-报警点关联表的报警点IP
		$kktoalarm = $this->Msyst->get_kktoalarm_by_ip($kakou_ip)->result();
		//组织数据到一个数组中
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
	
	//修改路口-报警点关联表单
	function edit_alarmrel_ok()
	{
		$this->form_validation->set_rules('alarmpoint[]', '报警点名称', 'trim|xss_clean');
		
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
			showmessage('修改关联报警点成功', 'syst/alarm_rel');
		}
		else
		{
			showmessage('操作失败，系统繁忙或着填写错误', 'syst/alarm_rel');
		}
	}
	
	//IP访问控制
	function ip_access()
	{
		$data['ip_access'] = $this->Msyst->get_ip_access_all()->result();
		
		$this->load->view('syst/ip_access', $data);
	}
	
	//添加IP地址
	function add_ipaccess()
	{
		//$maxip = $this->input->post('maxip');
		$this->form_validation->set_rules('minip', '最小IP地址', 'trim|xss_clean|valid_ip|callback_emptyip_check');
		$this->form_validation->set_rules('maxip', '最大IP地址', 'trim|xss_clean|valid_ip');

		$this->form_validation->set_message('valid_ip', '不合法的IP地址！');
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
	    		showmessage('添加IP地址成功', 'syst/ip_access');
	    	}
	    	else
	    	{
    			showmessage('操作失败，系统繁忙或着填写错误', 'syst/ip_access');
		    }
		}
		
	}
	
	//回调函数检查是否IP为空
	function emptyip_check($minip)
	{
		$maxip = $this->input->post('maxip');
		
		if(($minip == '') && ($maxip == ''))
		{
		    $this->form_validation->set_message('emptyip_check', 'IP不能为空！');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	//IP地址是否启用
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
    		showmessage('操作失败，系统繁忙或着填写错误', 'syst/ip_access');
		}
	}
	
	//删除IP地址
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
    		showmessage('操作失败，系统繁忙或着填写错误', 'syst/ip_access');
		}
	}
	
	function sysstate()
	{
		$data['eqstate'] = $this->Msyst->get_eqstate_info()->result();
		
		$this->load->view('syst/sysstate', $data);
	}
	
	//公告管理
	function adv()
	{
		$data['announcement'] = $this->Msyst->get_adv_all()->result();
		$data['adv_pos'] = 0;
		
		$this->load->view('syst/adv', $data);
	}
	
	//添加公告
	function add_adv()
	{
		$this->form_validation->set_rules('adv_content', '公告内容', 'trim|required|xss_clean');
		$this->form_validation->set_rules('adv_pos', '显示顺序', 'trim|required|integer');
		
		$this->form_validation->set_message('required', '%s不能为空.');
	    $this->form_validation->set_message('integer', '%s必须为整数.');
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
				showmessage('添加公告成功！', 'syst/adv');
			
		    	$this->load->view('syst/adv');
			}
			else
			{
	    		showmessage('操作失败，系统繁忙或着填写错误', 'syst/adv');
			}
		}
		
 		#$this->load->view('syst/adv');
	}
	
	//启动公告
	function turn_on_adv()
	{
		$id = $this->uri->segment(3);
		
		$this->Msyst->turn_on_adv($id);
		
		redirect('syst/adv');
	}
	
	//禁用公告
	function turn_off_adv()
	{
		$id = $this->uri->segment(3);
		
		$this->Msyst->turn_off_adv($id);
		
		redirect('syst/adv');
	}
	
	//修改公告内容
	function edit_adv()
	{
		$this->form_validation->set_rules('adv_content', '公告内容', 'trim|required|xss_clean');
		$this->form_validation->set_rules('adv_pos', '显示顺序', 'trim|required|integer');
		
		$this->form_validation->set_message('required', '%s不能为空.');
	    $this->form_validation->set_message('integer', '%s必须为整数.');
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
				showmessage('修改公告成功！', 'syst/adv');
			
		    	$this->load->view('syst/adv');
			}
			else
			{
	    		showmessage('操作失败，系统繁忙或着填写错误', 'syst/adv');
			}
		}
	}
	//删除公告
	function del_adv()
	{
		$data['adv_id']  = $this->input->get('id');
		$data['adv_pos'] = $this->input->get('adv_pos');
		
		$res = $this->Msyst->del_adv_by_id($data);
			
		if($res)
		{
			showmessage('删除公告成功！', 'syst/adv');
			
		}
		else
		{
	    	showmessage('操作失败，系统繁忙或着填写错误', 'syst/adv');
		}
	}
	//下载
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
	
	//短信设置
	function edit_gsm()
	{
/*		$this->form_validation->set_rules('ipaddr', '信息机IP地址', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', '%s不能为空.');
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
				showmessage('保存短信设置成功！', 'syst/gsm');
		    	//$this->load->view('syst/gsm');
			}
			else
			{
	    		showmessage('操作失败，系统繁忙或着填写错误', 'syst/gsm');
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
			showmessage('保存短信设置成功！', 'syst/gsm');
	    	//$this->load->view('syst/gsm');
		}
		else
		{
    		showmessage('操作失败，系统繁忙或着填写错误', 'syst/gsm');
		}
	}
	
	//测试用方法
	function test()
	{
		showmessage('这个是测试', 'syst/ip_access');
	}
}