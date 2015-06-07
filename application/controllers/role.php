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
		$this->load->model('Mrole');
		
		$this->load->config('kakou');
			
		$this->load->model('Mbasedata');
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		view();
	}
	

	
	
	//	角色信息列表展示
	function view()
	{
		$page = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$rows = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		// $sort = $this->input->post('sort') ? strval($this->input->post('sort')) : 'r.id';
		$sort = $this->input->post('sort') ? strval($this->input->post('sort')) : 'id';
	    $order = $this->input->post('order') ? strval($this->input->post('order')) : 'asc';
	    

	    $role_name = $this->input->post('role_index_name');
		$data['role_name'] = $role_name ? $role_name : '';
	    $data['total'] = $this->Mrole->get_roles(0,0,$sort,$order,$data)->row()->sum;

	    $totalPage = $data['total'] % $rows == 0 ? $data['total']/$rows : (int)($data['total']/$rows) + 1;
	    if($page > $totalPage){
            $page = $totalPage;
        }
        if($page <= 0){
            $page = 1;
        }
        $offset = ($page-1)*$rows;
		if ($data['total'] > 0) {
			$data['result']  = $this->Mrole->get_roles($offset,$rows,$sort,$order,$data)->result_array();
		}

		$data['title'] = '角色列表';
		$data['numPerPage'] = $rows;
		$data['page'] = $page;
		$data['orderField'] = $sort;
		$data['orderDirection'] = $order;
		$data['totalPage'] = $totalPage;
		$data['role_name'] = str_replace("'", "\\'", $role_name);
		$this->load->view('role/view',$data);
	}

	//	角色添加界面显示
	function role_add_ip()
	{	
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


		// $this->load->view('role/role_add_ip',$data);
		$this->load->view('role/role_add', $data);
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
		$data['name']      = $this->input->post('role_add_Name',True);
		$data['disable']   = $this->input->post('role_add_Disable') ? $this->input->post('role_add_Disable', True) : 0;
		$data['rights']    = $this->input->post('role_add_menulimit') ? $this->input->post('role_add_menulimit', True) : '0';
		$data['openkakou'] = $this->input->post('role_add_placelimit') ? $this->input->post('role_add_placelimit', True) : '';
		
		$result = array();	
		$array = array('name' => $data['name'], 'del' => 0);
		if ($this->Mrole->get_role_by_condition($array)->num_rows > 0) {
			$result["statusCode"] = "300";
			$result["message"] = "角色名已经存在，请检查后重新提交！";
		} else {
			if ($this->Mrole->add_role($data)) {
				$result["statusCode"] = "200";
				$result["message"] = "角色信息添加完成！";
	            $result["navTabId"] = "role_man";
	            $result["forwardUrl"] = base_url()."index.php/role/view";
	            $result["callbackType"] = "closeCurrent";
			} else {
				$result["statusCode"] = "300";
				$result["message"] = "角色信息添加失败，请稍后再试！";
			}	
		}
		echo json_encode($result);
	}

	//	角色信息修改界面显示
	function role_edit_ip() {
		$result = array();
		$data = array();
		$role_id = $this->input->get('rId',True);
		if (empty($role_id) || !ctype_digit($role_id)) {
			$result['statusCode'] = "300";
			$result['message'] = "提交数据存在错误，请检查后重新提交！"; 
			echo json_encode($result);
		} else {
			if ($role_id == '1') {
				$result['statusCode'] = "300";
				$result['message'] = "Admin角色拥有最高权限，无法修改！"; 
				echo json_encode($result);
			} else {
				$condition_role = array('id' => $role_id, 'del' => 0);
				$role_array = $this->Mrole->get_role_by_condition($condition_role)->result_array();
				if (empty($role_array)) {
					$result['statusCode'] = "300";
					$result['message'] = "角色信息不存在，请检查后重新提交！"; 
					echo json_encode($result);
				} else {
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
					$this->load->view('role/role_edit', $data);
				}
			}
		}
	}

	// 修改角色
	function role_edit() {
		$result = array();
		$role_Id = $this->input->post('role_edit_Id',True);
		$data['name'] = $this->input->post('role_edit_Name',True);
		$data['disable'] = $this->input->post('role_edit_Disable') ? $this->input->post('role_edit_Disable', True) : 0;
		$data['rights'] = $this->input->post('role_edit_menulimit') ? $this->input->post('role_edit_menulimit', True) : '0';
		$data['openkakou'] = $this->input->post('role_edit_placelimit') ? $this->input->post('role_edit_placelimit', True) : '';

		if (empty($role_Id) || !ctype_digit($role_Id)) {
			$result['statusCode'] = "300";
			$result['message'] = "提交数据存在错误，请检查后重新提交！";
		} else {
			if ($role_Id == '1') {
				$result['statusCode'] = "300";
				$result['message'] = "Admin角色拥有最高权限，无法修改！";
			} else {
				$condition_role = array('id' => $role_Id, 'del' => 0);
				if ($this->Mrole->get_role_by_condition($condition_role)->num_rows() <= 0) {
					$result['statusCode'] = "300";
					$result['message'] = "修改的角色信息不存在，请检查后重新提交！";
				} else {
					if (!$this->Mrole->is_rolename_available($role_Id, str_replace("'","''", $data['name']))) {
						$result['statusCode'] = "300";
						$result['message'] = "角色名已经存在，请检查后重新提交！"; 
					} else {
						if ($this->Mrole->edit_role($role_Id, $data)) {
							$result["statusCode"] = "200";
							$result["message"] = "角色信息修改完成！";
				            $result["navTabId"] = "role_man";
				            $result["forwardUrl"] = base_url()."index.php/role/view";
				            $result["callbackType"] = "closeCurrent";
						} else {
							$result["statusCode"] = "300";
							$result["message"] = "角色信息修改失败，请稍后再试！";

						}
					}
				}
			}	
		}
		echo json_encode($result);
	}

	// 删除角色
	function role_delete() {
		$result = array();
		$role_id = $this->input->get('rId',True);
		if ($role_id == 1){
			$result['statusCode'] = "300";
			$result['message'] = "Admin角色无法删除！"; 
			echo json_encode($result);
			exit;
		} else {
			$data['del'] = 1;
			if ($this->Mrole->edit_role($role_id, $data)) {
				$result['statusCode'] = "200";
				$result['message'] = "角色信息删除完成！";
				$result["navTabId"] = "role_man";
			} else {
				$result['statusCode'] = "300";
				$result['message'] = "角色删除失败，请稍后再试！"; 
			}
		}
		echo json_encode($result);
	}
}