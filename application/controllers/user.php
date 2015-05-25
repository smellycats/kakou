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

class User extends Admin_Controller
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
		$this->load->model('Muser');
		//$this->load->model('Muser2');
		
		$this->load->config('kakou');
			
		$this->load->model('Mbasedata');
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		$this->view();
	}
	
	//加载用户列表视图
	function view()
	{
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort'] = $this->input->post('sort') ? strval($this->input->post('sort')) : 'access_count';
	    $data['order'] = $this->input->post('order') ? strval($this->input->post('order')) : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];
		
	    $data['username'] = $this->input->post('username') ? $this->input->post('username') : '';
	    $data['department'] = $this->input->post('department') ? $this->input->post('department') : '';

		$data['result'] = $this->Muser->get_users($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array();
		$data['total'] = $this->Muser->get_users(0,0,$data['sort'],$data['order'],$data)->row()->sum;

		$data['title'] = '用户列表';

		$this->load->view('user/view', $data);
	}
	
	//	用户添加界面显示
	function add_view() {
		$data['roles'] = $this->Muser->get_roles()->result_array();
		
		$this->load->view('user/add', $data);
	}
	
	//	用户编辑界面显示
	function edit_view() {
		$id = $this->input->get('id',True);
		
		$query = $this->Muser->get_user_by_id($id);

		$data['roles'] = $this->Muser->get_roles()->result_array();
		$data['user'] = $query->row_array();
		
		$this->load->view('user/edit', $data);
	}
	
	// 添加用户
	function add() 
	{
		$data['username'] = $this->input->post('username', True);
		$data['realname'] = $this->input->post('realname', True);
		$data['role_id'] = $this->input->post('role_id', True);
		$data['identity'] = $this->input->post('identity', True);
		$data['phone'] = $this->input->post('phone', True);
		$data['password'] = sha1($this->input->post('pwd'));
		$data['department'] = $this->input->post('dadepartment', True);
		$data['banned'] = $this->input->post('banned') ? $this->input->post('banned', True) : 0;
		$data['access_type'] = $this->input->post('access_type', True);
		$data['limit_login_address'] = $this->input->post('limit_login_address', True);
		$data['memo'] = $this->input->post('memo', True);
		
		$result = array();
		$array = array('username' => $data['username'], 'disabled' => 0);
		if ($this->Muser->get_user_by_condition($array)->num_rows > 0) {
			$result["statusCode"] = "300";
			$result["message"] = "用户名已经存在，请更改用户名！";
		} else {
			if ($this->Muser->add_user($data)) {
				$result["statusCode"] = "200";
				$result["message"] = "添加成功！";
	            $result["navTabId"] = "account_man";
	            $result["forwardUrl"] = base_url()."index.php/user/account_man";
	            $result["callbackType"] = "closeCurrent";
			} else {
				$result["statusCode"] = "300";
				$result["message"] = "添加失败，请稍后再试！";
			}
		}
		
		echo json_encode($result);
	}
	
	// 编辑用户
	function edit() 
	{	
		$id = $this->input->post('id',True);
		
		#$data['username'] = $this->input->post('user_edit_username', True);
		$data['realname'] = $this->input->post('realname', True);
		$data['role_id'] = $this->input->post('role_id', True);
		$data['identity'] = $this->input->post('identity', True);
		$data['phone'] = $this->input->post('phone', True);
		#$data['password'] = sha1($this->input->post('user_edit_pwd'));
		$data['department'] = $this->input->post('department', True);
		$data['banned'] = $this->input->post('banned') ? $this->input->post('banned', True) : 0;
		$data['access_type'] = $this->input->post('access_type', True);
		$data['limit_login_address'] = $this->input->post('limit_login_address', True);
		$data['memo'] = $this->input->post('memo', True);

		$query = $this->Muser->get_user_by_id($id);

		$result = array();
		if ($id == '1') {
			$result['statusCode'] = "300";
			$result['message'] = "admin用户无法编辑！"; 
		} elseif ($query->num_rows() <= 0) {
			$result['statusCode'] = "300";
			$result['message'] = "用户不存在！";
		} elseif ($query->row()->disabled == '1') {
			$result['statusCode'] = "300";
			$result['message'] = "用户不存在！"; 
		} else {
			if ($this->Muser->edit_user($id, $data)) {
				$result["statusCode"] = "200";
				$result["message"] = "编辑成功！";
	            $result["navTabId"] = "account_man";
	            $result["forwardUrl"] = base_url()."index.php/user/account_man";
	            $result["callbackType"] = "closeCurrent";
			} else {
				$result["statusCode"] = "300";
				$result["message"] = "编辑失败，请稍后再试！";
			}
		}
		
		echo json_encode($result);
	}
	
	function delete()
	{
		$this->del();
	}

	function remove()
	{
		$this->del();
	}

	// 删除用户
	function del()
	{
		$id = $this->input->get('id',True);
		
		$result = array();
		if ($id == 1){
			$result['statusCode'] = "300";
			$result['message'] = "Admin用户无法删除！"; 
		} else {
			$data['disabled'] = 1;
			if ($this->Muser->edit_user($id, $data)) {
				$result['statusCode'] = "200";
				$result['message'] = "删除成功！";
				$result["navTabId"] = "account_man";
			} else {
				$result['statusCode'] = "300";
				$result['message'] = "删除失败，请稍后再试！"; 
			}
		}
		echo json_encode($result);
	}

}