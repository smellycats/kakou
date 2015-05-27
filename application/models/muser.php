<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Muser extends CI_Model
{
    /**
     * Construct a muser instance
     *
     */
	public function __construct()
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
		if ($data['department'] != ''){
			$this->db->like('department', $data['department']); 
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
     * 根据id获取用户信息
     * 
     * @param int $id 编号
     * @return object
     */
	public function getUserById($id)
	{
		return $this->db->where('id', $id)->get('users');
	}

    /**
     * 根据条件获取用户信息
     * 
     * @param array $array 查询条件数组
     * @return object
     */
	public function getUserByCondition($array)
	{
		return $this->db->where($array)->get('users');
	}
	
    /**
     * 添加用户
     * 
     * @param array $array 用户信息数组
     * @return object
     */
	public function addUser($data)
	{
		return $this->db->insert('users', $data);
	}
	
    /**
     * 根据id编辑用户信息
     * 
     * @param int $id 编号
     * @param array $array 用户信息数组
     * @return object
     */
	public function setUser($id, $data)
	{
		return $this->db->where('id', $id)->update('users', $data);
	}
	
    /**
     * 获取角色列表
     * 
     * @return object
     */
	public function getSelRoles()
	{
		$this->db->select('id, name');
		$this->db->where('del', 0);
		
		return $this->db->get('roles');
	} 
	

}
?>

