<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 用户管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class User extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		#$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('kakou');
		
		$this->load->library('Lib_kakou');
		#$this->load->library('form_validation');
		$this->load->model('Muser2');
		
		$this->load->config('kakou');
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		role_man();
	}
	
	//检查用户名是否存在
	function username_exist()
	{
		$username = iconv('UTF-8','GBK',$this->input->post('username'));

		$array = array('username' => $username, 'disabled' => 0);
		if ($this->input->post('id')){
			$array['id !='] = $this->input->post('id');
		}
		$query = $this->Muser2->get_user_by_condition($array);
		$result['success'] = $query->num_rows >=1 ? True : False;
		
		echo json_encode($result);
	}
	
	//检查用户名是否存在
	function rolename_exist()
	{
		$rolename = iconv('UTF-8','GBK',$this->input->post('rolename'));

		$array = array('name' => $rolename, 'del' => 0);
		if ($this->input->post('id')){
			$array['id !='] = $this->input->post('id');
		}
		$query = $this->Muser2->get_role_by_condition($array);
		$result['success'] = $query->num_rows >=1 ? True : False;
		
		echo json_encode($result);
	}
	//添加角色
	function role_add()
	{
		$data['name']      = $this->input->post('rolename',True);
		$data['disable']   = $this->input->post('disable') ? $this->input->post('disable', True) : 0;
		$data['rights']    = $this->input->post('menu') ? implode(',',$this->input->post('menu', True)) : '';
		$data['openkakou'] = $this->input->post('place') ? implode(',',$this->input->post('place', True)) : '';
		
		$result['success'] = $this->Muser2->add_role($data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','添加角色成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		
		echo json_encode($result);
	}
	
	//加载角色列表视图
	function role_list()
	{		
		$data['title'] = '角色列表';
		 
		$this->load->view('user/role_list',$data);
	}
	
	//加载角色列表视图
	function role_man()
	{		
		$data['title'] = '角色列表';
		 
		$this->load->view('user/role_list',$data);
	}
	
	//加载角色列表视图
	function role_list2()
	{		
		$data['title'] = '角色列表';
		 
		$this->load->view('user/role_list2',$data);
	}
	
	//编辑角色
	function role_edit()
	{
		$role_id = $this->input->get('id',True);
		if ($role_id == 1)
		{
			$result['success'] = False;
			$result['msg'] = iconv('GBK','UTF-8','Admin角色拥有最高权限，无法编辑');
		}else {
			$data['name']      = $this->input->post('rolename',True);
			$data['disable']   = $this->input->post('disable') ? $this->input->post('disable', True) : 0;
			$data['rights']    = $this->input->post('menu') ? implode(',',$this->input->post('menu', True)) : 0;
			$data['openkakou'] = $this->input->post('place') ? implode(',',$this->input->post('place', True)) : 0;
			
			$result['success'] = $this->Muser2->edit_role($role_id,$data);
			$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','编辑角色成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		}
			
		echo json_encode($result);
	}
	
	//删除角色
	function role_del()
	{
		$role_id = $this->input->post('id',True);
		if ($role_id == 1)
		{
			$result['success'] = False;
			$result['msg'] = iconv('GBK','UTF-8','Admin角色无法删除');
		}else {
			$data['del'] = 1;
			$result['success'] = $this->Muser2->edit_role($role_id,$data);
			$result['msg'] = $result['success'] ? iconv('GBK','UTF-8','删除角色成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		}
			
		echo json_encode($result);
	}
	
	//角色列表数据
	function role_list_data()
	{
		$page = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$rows = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$sort = $this->input->post('sort') ? strval($this->input->post('sort')) : 'i.id';
	    $order = $this->input->post('order') ? strval($this->input->post('order')) : 'desc';
	    $offset = ($page-1)*$rows;
	    
	    $data = array();
	    $data['rolename'] =  $this->input->post('rolename') ? iconv('UTF-8','GBK',$this->input->post('rolename',True)) : '';

		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Muser2->get_roles($offset,$rows,$data)->result_array());
		$result['total'] = $this->Muser2->get_roles(0,0,$data)->row()->sum;
		
		echo json_encode($result);
	}
	
	//加载用户列表视图
	function user_list()
	{
		$data['title'] = iconv("GBK","UTF-8",'用户列表');

		$this->load->view('user/user_list',$data);
	}

	//加载用户列表视图
	function account_man()
	{
		$data['title'] = iconv("GBK","UTF-8",'用户列表');
		 
		$this->load->view('user/user_list',$data);
	}
	
	//加载用户列表数据
	function user_list_data()
	{
		$page = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$rows = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$sort = $this->input->post('sort') ? strval($this->input->post('sort')) : 'u.id';
	    $order = $this->input->post('order') ? strval($this->input->post('order')) : 'asc';
	    $offset = ($page-1)*$rows;
	    
	    $data = array();
	    $data['username'] =  $this->input->post('username') ? iconv('UTF-8','GBK',$this->input->post('username',True)) : '';

		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Muser2->get_users($offset,$rows,$sort,$order,$data)->result_array());
		$result['total'] = $this->Muser2->get_users(0,0,$sort,$order,$data)->row()->sum;
		
		echo json_encode($result);
	}
	
	//添加用户
	function user_add()
	{
		$data['username']  = $this->input->post('username',True);
		$data['realname']  = $this->input->post('realname',True);
		$data['password']  = sha1($this->input->post('password',True));
		$data['role_id']   = $this->input->post('role_id', True);
		$data['identity']  = $this->input->post('identity', True);
		$data['phone']     = $this->input->post('phone', True);
		$data['department']= $this->input->post('department', True);
		$data['banned']    = $this->input->post('banned') ? 1 : 0;
		$data['memo']      = $this->input->post('memo', True);
		$data['created']   = mdate("%Y-%m-%d %H:%i:%s");
		$data['access_type'] = $this->input->post('access_type', True);
		$data['limit_login_address'] = $this->input->post('limit_login_address', True);

		$result['success'] = $this->Muser2->add_user($data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','添加用户成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		
		echo json_encode($result);
	}
	
	//编辑用户
	function user_edit()
	{
		$id = $this->input->get('id',True);

		$data['username']  = $this->input->post('username', True);
		$data['realname']  = $this->input->post('realname', True);
		$data['role_id']   = $this->input->post('role_id', True);
		$data['identity']  = $this->input->post('identity', True);
		$data['phone']     = $this->input->post('phone', True);
		$data['department']= $this->input->post('department', True);
		$data['banned']    = $this->input->post('banned') ? 1 : 0;
		$data['memo']      = $this->input->post('memo', True);
		$data['access_type'] = $this->input->post('access_type', True);
		$data['limit_login_address'] = $this->input->post('limit_login_address', True);
		
		$result['success'] = $this->Muser2->edit_user($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','编辑用户成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		
		echo json_encode($result);
	}
	
	//删除用户
	function user_del()
	{
		$id = $this->input->post('id',True);
		if ($id == 1){
			$result['success'] = false;
			$result['msg']     = iconv('GBK','UTF-8','超级用户无法删除');		
		}else{
			$data['disabled']  = 1;
		
			$result['success'] = $this->Muser2->edit_user($id,$data);
			$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','删除用户成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		}
		
		echo json_encode($result);
	}
	
	function pwd_edit()
	{
		$id = 259;
		$old_password     = sha1($this->input->post('password',True));
		$data['password'] = sha1($this->input->post('password',True));
		
		$query = $this->Muser2->check_pwd($id,$old_password);
		if ($query->num_rows >= 1)
		{
			$result['success'] = $this->Muser2->edit_user($id,$data);
			$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','修改密码成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
			
		}else {
			$result['success'] = false;
			$result['msg']     = iconv('GBK','UTF-8','旧密码错误');
		}
		
		echo json_encode($result);
	}
	
	function pwd()
	{
		$data['message'] = '';
		$this->load->view('user/change_password',$data);
	}
		
	// ------------------------------------------------------------------------
	
	/**
     * 获取表单数据
     *
     * @access  private
     * @param   int
     * @return  array
     */
	private function _get_form_data()
	{
		//$data['parent_id'] = '0';
		$data['name'] = $this->input->post('rolename', TRUE);
		$data['disable'] = $this->input->post('role_disable', TRUE);
		$data['rights'] = array_to_string($this->input->post('rights_post', TRUE));
		$data['openkakou'] = array_to_string($this->input->post('openkakou_post', TRUE));
		return $data;
	}
	
	//回调函数检查角色名是否重复
	function rolename_check()
	{
		$result = $this->Muser->is_rolename_available($this->input->post('role_id'), $this->input->post('rolename'));
		if ( ! $result)
		{
			$this->form_validation->set_message('rolename_check', '角色名已经存在.');
		}
				
		return $result;
	}
	
	function test()
	{
		$data['title'] = '用户列表';
		 
		$this->load->view('user/test',$data);
	}
	
	function add_user3()
	{
		$data['title'] = '添加用户';
		$this->load->view('user/add_user3',$data);
	}	
}