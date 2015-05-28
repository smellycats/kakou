<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Madmin extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 根据id获得菜单数据
	 *
	 * @param int $id 菜单id
	 * @return object
	 */
	public function getMenuById($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->where('status', 1);

		return $this->db->get('menu');
	}

	/**
	 * 根据fid获得菜单数据
	 *
	 * @param int $fid 父菜单id
	 * @return object
	 */
	public function getMenuByFid($fid)
	{
		$this->db->select('*');
		$this->db->where('fid', $fid);
		$this->db->where('status', 1);
		$this->db->order_by('arrange', 'asc');

		return $this->db->get('menu');
	}

	/**
	 * 根据fid数组获得菜单数据
	 *
	 * @param array $fid_arr 父菜单id数组
	 * @return object
	 */
	public function getMenuByFidRight($fid, $right_arr)
	{
		$this->db->select('*');
		$this->db->where('fid', $fid);
		$this->db->where_in('id', $right_arr);
		$this->db->where('status', 1);
		$this->db->order_by('arrange', 'asc');

		return $this->db->get('menu');
	}

	/**
	 * 根据用户权限获取父菜单
	 *
	 * @param array $right_array 权限数组
	 * @return object
	 */
	public function getFidByRight($right_arr)
	{
		$this->db->select('fid');
		$this->db->where_in('id', $right_arr);
		$this->db->where('status', 1);
		$this->db->where('fid >', 0);
		$this->db->order_by('arrange', 'asc');
		$this->db->group_by('fid');

		return $this->db->get('menu');

	}

	/**
	 * 
	 * 根据菜单名获取菜单数据
	 *
	 * @param string $name 菜单名称
	 * @return object
	 */
	public function getMenuByName($name)
	{
		return $this->db->select('*')->where('name', $name)->get('menu');
	}
	
	/**
	 * 
	 * 根据角色id获取角色信息
	 *
	 * @param int $id 角色id编号
	 * @return object
	 */
	public function getRoleById($id)
	{
		return $this->db->select('*')->where('id', $id)->get('roles');
	}
	/**
	 * 
	 * 根据ID获取用户信息
	 *
	 * @param int $id id编号
	 * @return object
	 */
	public function getUserById($id)
	{
		return $this->db->where('id', $id)->get('users');
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
}

/* End of file madmin.php */
/* Location: ./application/models/madmin.php */
?>
