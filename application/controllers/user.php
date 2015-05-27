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
    /**
     * Construct a user instance
     *
     */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('kakou');
		
		$this->load->library('Lib_kakou');

		$this->load->model('Muser');
		$this->load->model('Mbasedata');
		
		$this->load->config('kakou');
		//$this->output->enable_profiler(TRUE);
	}
	
    /**
     * 用户列表视图
     * 
     * @return void
     */
	public function view()
	{
		$data['page']   = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows']   = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort']   = $this->input->post('sort') ? $this->input->post('sort') : 'access_count';
	    $data['order']  = $this->input->post('order') ? $this->input->post('order') : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];
		
	    $data['username']   = $this->input->post('username') ? $this->input->post('username') : '';
	    $data['department'] = $this->input->post('department') ? $this->input->post('department') : '';

		$data['result'] = $this->Muser->getUsers($data['offset'], $data['rows'], $data['sort'], $data['order'], $data)->result_array();
		$data['total']  = $this->Muser->getUsers(0, 0, $data['sort'], $data['order'], $data)->row()->sum;

		$data['title'] = '用户列表';

		$this->load->view('user/view', $data);
	}
	
    /**
     * 用户添加视图
     * 
     * @return void
     */
	public function addView() {
		$data['sel_roles'] = $this->Muser->getSelRoles()->result_array();
		
		$this->load->view('user/add', $data);
	}

    /**
     * 用户编辑视图
     * 
     * @return void
     */
	public function editView() {
		$id = $this->input->get('id', True);
		
		$data['sel_roles'] = $this->Muser->getSelRoles()->result_array();
		$data['user']      = $this->Muser->getUserById($id)->row_array();
		
		$this->load->view('user/edit', $data);
	}
	
    /**
     * 添加用户
     * 
     * @return json
     */
	public function add() 
	{
		$data['username']    = $this->input->post('username', True);
		$data['realname']    = $this->input->post('realname', True);
		$data['role_id']     = $this->input->post('role_id', True);
		$data['identity']    = $this->input->post('identity', True);
		$data['phone']       = $this->input->post('phone', True);
		$data['password']    = sha1($this->input->post('pwd'));
		$data['department']  = $this->input->post('dadepartment', True);
		$data['banned']      = $this->input->post('banned') ? $this->input->post('banned', True) : 0;
		$data['access_type'] = $this->input->post('access_type', True);
		$data['memo']        = $this->input->post('memo', True);
		$data['limit_login_address'] = $this->input->post('limit_login_address', True);
		
		$result = array();
		$array = array('username' => $data['username'], 'disabled' => 0);
		$query = $this->Muser->getUserByCondition($array);
		if ($query->num_rows > 0) {
			$result['statusCode'] = '300';
			$result['message']    = '用户名已经存在，请更改用户名！';
		} else {
			if ($this->Muser->addUser($data)) {
				$result['statusCode']   = '200';
				$result['message']      = '添加成功！';
	            $result['navTabId']     = 'account_man';
	            $result['forwardUrl']   = base_url('index.php/user/view');
	            $result['callbackType'] = 'closeCurrent';
			} else {
				$result['statusCode'] = '300';
				$result['message']    = '添加失败，请稍后再试！';
			}
		}
		
		echo json_encode($result);
	}
	
    /**
     * 编辑用户
     * 
     * @return json
     */
	public function edit() 
	{	
		$id = $this->input->post('id', True);
		
		$data['realname']    = $this->input->post('realname', True);
		$data['role_id']     = $this->input->post('role_id', True);
		$data['identity']    = $this->input->post('identity', True);
		$data['phone']       = $this->input->post('phone', True);
		$data['department']  = $this->input->post('department', True);
		$data['banned']      = $this->input->post('banned') ? $this->input->post('banned', True) : 0;
		$data['access_type'] = $this->input->post('access_type', True);
		$data['memo']        = $this->input->post('memo', True);
		$data['limit_login_address'] = $this->input->post('limit_login_address', True);

		$query = $this->Muser->getUserById($id);

		$result = array();
		if ($id == '1') {
			$result['statusCode'] = '300';
			$result['message']    = 'admin用户无法编辑！'; 
		} elseif ($query->num_rows() <= 0) {
			$result['statusCode'] = '300';
			$result['message']    = '用户不存在！';
		} elseif ($query->row()->disabled == '1') {
			$result['statusCode'] = '300';
			$result['message']    = '用户不存在！'; 
		} else {
			if ($this->Muser->setUser($id, $data)) {
				$result['statusCode']   = '200';
				$result['message']      = '编辑成功！';
	            $result['navTabId']     = 'account_man';
	            $result['forwardUrl']   = base_url() . 'index.php/user/view';
	            $result['callbackType'] = 'closeCurrent';
			} else {
				$result['statusCode'] = '300';
				$result['message']    = '编辑失败，请稍后再试！';
			}
		}
		
		echo json_encode($result);
	}

    /**
     * 删除用户
     * 
     * @return json
     */
	public function del()
	{
		$id = $this->input->get('id', True);
		
		$result = array();
		if ($id == '1'){
			$result['statusCode'] = '300';
			$result['message']    = 'Admin用户无法删除！'; 
		} else {
			$data['disabled'] = 1;
			if ($this->Muser->setUser($id, $data)) {
				$result['statusCode'] = '200';
				$result['message']    = '删除成功！';
				$result['navTabId']   = 'account_man';
			} else {
				$result['statusCode'] = '300';
				$result['message']    = '删除失败，请稍后再试！'; 
			}
		}

		echo json_encode($result);
	}

}