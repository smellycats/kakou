<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * 日志查询 模型
  * 
  *
  */

class Muserlog extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

    /**
     * 根据条件查询用户信息
     * 
     * @param int $offset 偏移量
     * @param int $limit 行数
     * @param string $sort 排序字段
     * @param string $order 排序方向
     * @param array $data 查询数组
     * @return object
     */
	public function getUsers($offset = 0, $limit = 0, $sort = 'u.id', $order = 'asc', $data)
	{	
		if ($data['username'] != ''){
			$this->db->like('username', $data['username']); 
		}
		
		if ($offset == 0 and $limit == 0){
			$this->db->select('count(*) as sum');
		} else {
			$this->db->select('u.id');
			$this->db->select('r.name as rolename');
			$this->db->select('role_id');
			$this->db->select('username');
			$this->db->select('realname');
			$this->db->select('department');
			$this->db->select('created');
			$this->db->select('banned');
			$this->db->select('last_ip');
			$this->db->select('last_login');
			$this->db->select('identity');
			$this->db->select('phone');
			$this->db->select('access_type');
			$this->db->select('access_count');
			$this->db->select('limit_login_address');
			$this->db->select('memo');

			$this->db->limit($limit, $offset);
			$this->db->order_by($sort, $order);
		}
		$this->db->where('disabled', 0);
		$this->db->where('r.del', 0);
		$this->db->join('roles as r', 'u.role_id=r.id');
		
		return $this->db->get('users as u');
	}
	
    /**
     * 获取用户操作日志
     * 
     * @param int $offset 偏移量
     * @param int $limit 行数
     * @param string $sort 排序字段
     * @param string $order 排序方向
     * @param array $data 查询数组
     * @return object
     */
	function getUserlogs($offset = 0, $limit = 0, $sort = 'czsj', $order = 'desc', $data)
	{
		if ($data['st'] != '') {
			$this->db->where('czsj >=',$data['st']);
		}
		if ($data['et'] != '') {
			$this->db->where('czsj <=', $data['et']);
		}
		if ($data['uname'] != '') {
			$this->db->where('uname', $data['uname']);
		}
		$this->db->where('disabled', 0);
		
		if ($offset == 0 AND $limit == 0) {	
			$this->db->select('count(*) as sum');
		} else {
			$this->db->select('*');
			$this->db->limit($limit, $offset);
			$this->db->order_by($sort, $order);
		}
		
		return $this->db->get('userlog');;
	}
	
    /**
     * 添加用户日志
     * 
     * @param array $data 数组
     * @return object
     */
	function addUserlog($data)
	{
		return $this->db->insert('userlog', $data); 
	}

    /**
     * 编辑用户日志
     * 
     * @param int $id id编号
     * @param array $data 数组
     * @return object
     */
	function setUserlog($id, $data)
	{
		return $this->db->where('id', $id)->update('userlog', $data);
	}
	
}
?>