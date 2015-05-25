<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 角色管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Role extends Admin_Controller
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
		$this->load->model('Muser2');
		
		$this->load->config('kakou');
			
		$this->load->model('Mbasedata');
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		role_man();
	}
	

	function account_man3()
	{
		$this->view();
	}
	
	//加载用户列表视图
	function view()
	{
		$page = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$rows = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$sort = $this->input->post('_order') ? strval($this->input->post('_order')) : 'u.id';
	    $order = $this->input->post('_sort') ? strval($this->input->post('_sort')) : 'asc';
	    $offset = ($page-1)*$rows;
	    
	    $data['username'] = $this->input->post('username') ? $this->input->post('username') : '';
	    $data['department'] = $this->input->post('department') ? $this->input->post('department') : '';
		$data['result']  = $this->Muser2->get_users($offset,$rows,$sort,$order,$data)->result_array();
		$data['total'] = $this->Muser2->get_users(0,0,$sort,$order,$data)->row()->sum;
	    
		$data['title'] = '用户列表';
		$data['numPerPage'] = $rows;
		$data['page'] = $page;
		$data['orderField'] = $sort;
		$data['orderDirection'] = $order;

		$this->load->view('user/view',$data);
	}
	
	//	角色信息列表展示
	function role_man() {
		$page = $this->input->post('pageNum') ? intval($this->input->post('pageNum')) : 1;
		$rows = $this->input->post('numPerPage') ? intval($this->input->post('numPerPage')) : 20;
		$sort = $this->input->post('_order') ? strval($this->input->post('_order')) : 'r.id';
	    $order = $this->input->post('_sort') ? strval($this->input->post('_sort')) : 'desc';
	    

	    $rolename = $this->input->post('rolename_index');
		$data['rolename'] = $rolename ? $rolename : '';
	    $data['total'] = $this->Muser2->get_roles(0,0,$sort,$order,$data)->row()->sum;

	    $totalPage = $data['total'] % $rows == 0 ? $data['total']/$rows : (int)($data['total']/$rows) + 1;
	    if($page > $totalPage){
            $page = $totalPage;
        }
        if($page <= 0){
            $page = 1;
        }
        $offset = ($page-1)*$rows;
		if ($data['total'] > 0) {
			$data['result']  = $this->Muser2->get_roles($offset,$rows,$sort,$order,$data)->result_array();
		}

		$data['title'] = '角色列表';
		$data['numPerPage'] = $rows;
		$data['page'] = $page;
		$data['orderField'] = $sort;
		$data['orderDirection'] = $order;
		$data['totalPage'] = $totalPage;
		$data['rolename'] = str_replace("'", "\\'", $rolename);
		$this->load->view('user/role_man',$data);
	}

	//	角色添加界面显示
	function role_add_ip() {	
		$data = array();
		$menus = $this->Mbasedata->get_menu(0)->result_array();
		if (!empty($menus)) {
			$data_all_menus = array();
			$data_menus = $this->zTree_menu_fmt($menus);
			foreach ($data_menus as $data_menu) {
				$data_all_menus[] = $data_menu;
				$this->into_DatazTree($data_all_menus, $data_menu['id']);
			}
			$data['data_menus'] = $data_all_menus;
		}

		$places = $this->Mbasedata->get_places()->result_array();
		if (!empty($places)) {
			$data['data_places'] = $this->zTree_place_fmt($places);
		}


		// $this->load->view('user/role_add_ip',$data);
		$this->load->view('user/role_add', $data);
	}

	//	菜单权限递归遍历
	function into_DatazTree(&$data_all_menus, $Id){
		$menus = $this->Mbasedata->get_menu($Id)->result_array();
		if (!empty($menus)) {
			$data_menus = $this->zTree_menu_fmt($menus);
			foreach ($data_menus as $data_menu) {
				$data_all_menus[] = $data_menu;
				$this->into_DatazTree($data_all_menus, $data_menu['id']);
			}
		}
	}

	//	zTree格式化菜单权限
	function zTree_menu_fmt($data) {
		$data_zTree = array();
		foreach($data as $key=>$val) {
			$data_zTree[$key]['id'] = $val['id'];
			$data_zTree[$key]['pId'] = $val['fid'];
			$data_zTree[$key]['name'] = $val['cname'];
		}
		return $data_zTree;
	}

	//	zTree格式化卡口权限
	function zTree_place_fmt($data) {
		$data_zTree = array();
		foreach($data as $key=>$val) {
			$data_zTree[$key]['id'] = $val['id'];
			$data_zTree[$key]['pId'] = 0;
			$data_zTree[$key]['name'] = $val['place'];
		}
		return $data_zTree;
	}

	// 添加角色
	function role_add() {
		$data['name']      = $this->input->post('roleadd_Name',True);
		$data['disable']   = $this->input->post('roleadd_Disable') ? $this->input->post('roleadd_Disable', True) : 0;
		$data['rights']    = $this->input->post('roleadd_menulimit') ? $this->input->post('roleadd_menulimit', True) : '0';
		$data['openkakou'] = $this->input->post('roleadd_placelimit') ? $this->input->post('roleadd_placelimit', True) : '';
			
		$array = array('name' => $data['name'], 'del' => 0);
		if ($this->Muser2->get_role_by_condition($array)->num_rows > 0) {
			$op_result["statusCode"] = "300";
			$op_result["message"] = "角色名已经存在，请检查后重新提交！";
			echo json_encode($op_result);
			exit;
		}
		$op_result = array();
		if ($this->Muser2->add_role($data)) {
			$op_result["statusCode"] = "200";
			$op_result["message"] = "角色信息添加完成！";
            $op_result["navTabId"] = "role_man";
            $op_result["forwardUrl"] = base_url()."index.php/user/role_man";
            $op_result["callbackType"] = "closeCurrent";
		} else {
			$op_result["statusCode"] = "300";
			$op_result["message"] = "角色信息添加失败，请稍后再试！";
		}
		echo json_encode($op_result);
		exit;
	}

	//	角色信息修改界面显示
	function role_edit_ip() {
		$op_result = array();
		$data = array();
		$role_id = $this->input->get('rId',True);
		if (empty($role_id) || !ctype_digit($role_id)) {
			$op_result['statusCode'] = "300";
			$op_result['message'] = "提交数据存在错误，请检查后重新提交！"; 
			echo json_encode($op_result);
			exit;
		}

		if ($role_id == '1') {
			$op_result['statusCode'] = "300";
			$op_result['message'] = "Admin角色拥有最高权限，无法修改！"; 
			echo json_encode($op_result);
			exit;
		}

		$condition_role = array('id' => $role_id, 'del' => 0);
		$role_array = $this->Muser2->get_role_by_condition($condition_role)->result_array();
		if (empty($role_array)) {
			$op_result['statusCode'] = "300";
			$op_result['message'] = "角色信息不存在，请检查后重新提交！"; 
			echo json_encode($op_result);
			exit;
		}
		$role = $role_array[0];
		$role['name'] = str_replace('"', '\\"', str_replace("'", "\\'", $role['name']));
		if (!empty($role['rights'])) {
			$role['tree_menus'] = explode(",", $role['rights']);
		}
		if (!empty($role['openkakou'])) {
			$role['tree_place'] = explode(",", $role['openkakou']);
		}
		$data['role'] = $role;
		$menus = $this->Mbasedata->get_menu(0)->result_array();
		if (!empty($menus)) {
			$data_all_menus = array();
			$data_menus = $this->zTree_menu_fmt($menus);
			foreach ($data_menus as $data_menu) {
				$data_all_menus[] = $data_menu;
				$this->into_DatazTree($data_all_menus, $data_menu['id']);
			}
			$data['data_menus'] = $data_all_menus;
		}

		$places = $this->Mbasedata->get_places()->result_array();
		if (!empty($places)) {
			$data['data_places'] = $this->zTree_place_fmt($places);
		}
		$this->load->view('user/role_edit', $data);
	}

	// 修改角色
	function role_edit() {
		$op_result = array();
		$role_Id = $this->input->post('roleedit_Id',True);
		$data['name'] = $this->input->post('roleedit_Name',True);
		$data['disable'] = $this->input->post('roleedit_Disable') ? $this->input->post('roleedit_Disable', True) : 0;
		$data['rights'] = $this->input->post('roleedit_menulimit') ? $this->input->post('roleedit_menulimit', True) : '0';
		$data['openkakou'] = $this->input->post('roleedit_placelimit') ? $this->input->post('roleedit_placelimit', True) : '';

		if (empty($role_Id) || !ctype_digit($role_Id)) {
			$op_result['statusCode'] = "300";
			$op_result['message'] = "提交数据存在错误，请检查后重新提交！"; 
			echo json_encode($op_result);
			exit;
		}

		if ($role_Id == '1') {
			$op_result['statusCode'] = "300";
			$op_result['message'] = "Admin角色拥有最高权限，无法修改！"; 
			echo json_encode($op_result);
			exit;
		}

		$condition_role = array('id' => $role_Id, 'del' => 0);
		if ($this->Muser2->get_role_by_condition($condition_role)->num_rows() <= 0) {
			$op_result['statusCode'] = "300";
			$op_result['message'] = "修改的角色信息不存在，请检查后重新提交！"; 
			echo json_encode($op_result);
			exit;
		}

		if (!$this->Muser2->is_rolename_available($role_Id, $data['name'])) {
			$op_result['statusCode'] = "300";
			$op_result['message'] = "角色名已经存在，请检查后重新提交！"; 
			echo json_encode($op_result);
			exit;
		}

		if ($this->Muser2->edit_role($role_Id, $data)) {
			$op_result["statusCode"] = "200";
			$op_result["message"] = "角色信息修改完成！";
            $op_result["navTabId"] = "role_man";
            $op_result["forwardUrl"] = base_url()."index.php/user/role_man";
            $op_result["callbackType"] = "closeCurrent";

		} else {
			$op_result["statusCode"] = "300";
			$op_result["message"] = "角色信息修改失败，请稍后再试！";

		}
		echo json_encode($op_result);
		exit;
	}

	// 删除角色
	function role_delete() {
		$op_result = array();
		$role_id = $this->input->get('rId',True);
		if ($role_id == 1)
		{
			$op_result['statusCode'] = "300";
			$op_result['message'] = "Admin角色无法删除！"; 
			echo json_encode($op_result);
			exit;
		}
		$data['del'] = 1;
		if ($this->Muser2->edit_role($role_id, $data)) {
			$op_result['statusCode'] = "200";
			$op_result['message'] = "角色信息删除完成！";
			$op_result["navTabId"] = "role_man";
		} else {
			$op_result['statusCode'] = "300";
			$op_result['message'] = "角色删除失败，请稍后再试！"; 
		}
		echo json_encode($op_result);
		exit;
	}
	
	//加载用户列表视图
	function account_man()
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

		$this->load->view('user/user_view', $data);
	}
	
	//	用户添加界面显示
	function user_add_view() {
		$data['roles'] = $this->Muser->get_roles()->result_array();
		
		$this->load->view('user/user_add', $data);
	}
	
	//	用户编辑界面显示
	function user_edit_view() {
		$id = $this->input->get('id',True);
		
		$query = $this->Muser->get_user_by_id($id);

		$data['roles'] = $this->Muser->get_roles()->result_array();
		$data['user'] = $query->row_array();
		
		$this->load->view('user/user_edit', $data);
	}
	
	// 添加用户
	function user_add() 
	{
		$data['username'] = $this->input->post('user_add_username', True);
		$data['realname'] = $this->input->post('user_add_realname', True);
		$data['role_id'] = $this->input->post('user_add_role_id', True);
		$data['identity'] = $this->input->post('user_add_identity', True);
		$data['phone'] = $this->input->post('user_add_phone', True);
		$data['password'] = sha1($this->input->post('user_add_pwd'));
		$data['department'] = $this->input->post('user_add_dadepartment', True);
		$data['banned'] = $this->input->post('user_add_banned', True) ? $this->input->post('user_add_banned', True) : 0;
		$data['access_type'] = $this->input->post('user_add_access_type', True);
		$data['limit_login_address'] = $this->input->post('user_add_limit_login_address', True);
		$data['memo'] = $this->input->post('user_add_memo', True);
		
		$result = array();
		$array = array('username' => $data['username'], 'disabled' => 0);
		if ($this->Muser->get_user_by_condition($array)->num_rows > 0) {
			$result["statusCode"] = "300";
			$result["message"] = "用户名已经存在，请检查后重新提交！";
		} else {
			if ($this->Muser->add_user($data)) {
				$result["statusCode"] = "200";
				$result["message"] = "用户添加完成！";
	            $result["navTabId"] = "account_man";
	            $result["forwardUrl"] = base_url()."index.php/user/account_man";
	            $result["callbackType"] = "closeCurrent";
			} else {
				$result["statusCode"] = "300";
				$result["message"] = "用户添加失败，请稍后再试！";
			}
		}
		
		echo json_encode($result);
	}
	
	// 编辑用户
	function user_edit() 
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
				$result["message"] = "用户编辑成功！";
	            $result["navTabId"] = "account_man";
	            $result["forwardUrl"] = base_url()."index.php/user/account_man";
	            $result["callbackType"] = "closeCurrent";
			} else {
				$result["statusCode"] = "300";
				$result["message"] = "用户编辑失败，请稍后再试！";
			}
		}
		
		echo json_encode($result);
	}
	
	// 删除用户
	function user_del()
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
				$result['message'] = "用户删除成功！";
				$result["navTabId"] = "account_man";
			} else {
				$result['statusCode'] = "300";
				$result['message'] = "用户删除失败，请稍后再试！"; 
			}
		}
		echo json_encode($result);
	}

}