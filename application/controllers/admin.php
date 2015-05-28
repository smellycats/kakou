<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Kakou 后台管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */
class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('string');
		
		$this->load->model('Madmin');		
		
		$this->load->config('kakou');
		#$this->load->library('MY_Session');
		//$this->output->enable_profiler(TRUE);
		
	}

    /**
     * 后台首页
     * 
     * @return void
     */
	public function index()
	{		
	    if ($_SESSION['role_id'] == 1) {
			$data['f_datas'] = $this->_getMenu();
		} else {
			$data['f_datas'] = $this->_getMenuByRoleId($_SESSION['role_id']);
		}

		$this->load->view('admin/header',$data);
		$this->load->view('admin/index');
		$this->load->view('admin/footer');
	}

	private function _getMenu()
	{
		// 获得menu表fid为0的数据，存入到数组$f_datas。
		$f_datas = $this->Madmin->getMenuByFid(0)->result_array();
		// 遍历fid为0的子菜单数据添加到数组$f_datas的childrens子数组中。
		foreach($f_datas as $f_num => $f_data) {
			$f_datas[$f_num]['childrens'] = $this->Madmin->getMenuByFid($f_data['id'])->result_array();
		}

		return $f_datas;
	}
	
	/**
	 * 根据权限获取菜单数据
	 *
	 * @param int $role_id
	 * @return object
	 */
	function _getMenuByRoleId($role_id)
	{
		$rights = $this->Madmin->getRoleById($role_id)->row()->rights;
		
		if($rights != '') {
			$right_arr = explode(',', $rights);
			//获取菜单权限的父ID
			$fids = $this->Madmin->getFidByRight($right_arr)->result_array();
			// 根据权限获得menu表fid的数据，存入到数组$f_datas。
			foreach($fids as $id=>$row) {
				$f_datas[$id] = $this->Madmin->getMenuById($row['fid'])->row_array();
			}
			foreach ($f_datas as $f_num => $f_data) {

				$f_datas[$f_num]['childrens'] = $this->Madmin->getMenuByFidRight($f_data['id'], $right_arr)->result_array();
			}
		} else {
			$f_datas = null;
		}

		return $f_datas;
	}
	
    /**
     * 修改密码dialog
     * 
     * @return void
     */
	function password()
	{
		$this->load->view('admin/password');
	}
	
    /**
     * 修改密码
     * 
     * @return json
     */
	function setPassword()
	{
		$id = 1;
		$password_old = sha1($this->input->post('password_old'));
		$query = $this->Madmin->getUserById($id);
		if ($query->row()->password != $password_old) {
			$result['statusCode'] = '300';
			$result['message']    = '旧密码错误！';
		} else {
			$data['password'] = sha1($this->input->post('password_new'));
			if ($this->Madmin->setUser($id, $data)) {
				$result['statusCode']   = '200';
				$result['message']      = '修改密码完成！';
	            $result['callbackType'] = 'closeCurrent';
			} else {
				$result['statusCode'] = '300';
				$result['message']    = '修改密码失败，请稍后再试！';
			}
		}

		echo json_encode($result);
	}

    /**
     * 退出系统
     * 
     * @return void
     */
	function logout()
	{
		session_start();
		session_unset(); 
		session_destroy();
		
		redirect('home/index');
	}

	/* 退出系统  */
	function exit_system()
	{
		session_start();
		session_unset(); 
		session_destroy();
		
		redirect('home/login');
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
?>
