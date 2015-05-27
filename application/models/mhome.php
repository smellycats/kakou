<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mhome extends CI_Model
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
     * 查询IP限制
     * 
     * @return object
     */
	public function getIpAccess()
	{	
		$this->db->where('del', 0);
		$this->db->where('banned', 0);
		
		return $this->db->get('ip_access2');
	}

    /**
     * 根据用户名获取用户信息
     * 
     * @param string $user_name 用户名
     * @return object
     */
	function getUserByName($user_name)
	{
		$this->db->select('u.id as user_id');
		$this->db->select('u.username as user_name');
		$this->db->select('u.password');
		$this->db->select('r.id as role_id');
		$this->db->select('r.name as role_name');
		$this->db->select('r.rights as role_right');
		$this->db->select('r.openkakou as role_openkk');
		$this->db->select('u.banned as u_banned');
		$this->db->select('u.disabled as u_del');
		$this->db->select('r.disable as r_banned');
		$this->db->select('r.del as r_del');
		
		$this->db->where('u.disabled', 0);
		$this->db->where('r.del', 0);
		$this->db->where('u.username',$user_name);

		$this->db->from('users as u');
		$this->db->join('roles as r','u.role_id = r.id', 'inner');
		
		return $this->db->get();
	}

    /**
     * 修改用户登录信息
     * 
     * @param array $data 用户信息
     * @return object
     */
	function loginPlus($id, $data)
	{
		return $this->db->query("UPDATE users SET last_ip = '$data[last_ip]',last_login = '$data[last_login]',access_count = access_count + 1 WHERE id = $id");
	}

    /**
     * 添加用户登录日志
     * 
     * @param array $data 用户登录信息
     * @return object
     */
	function addAccessLog($data)
	{
		return $this->db->insert('access_log', $data);
	}
	
}
?>

