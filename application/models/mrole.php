<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mrole extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
		$this->db = $this->load->database('default', TRUE);
	}

    /**
     * 格式化数组成ASSOC方式
     *
     * @access  private
     * @param   array
     * @param   string
     * @param   string
     * @return  array
     */
	private function _re_parse_array($array, $key, $value)
	{
		$data = array();
		foreach ($array as $v)
		{
			$data[$v->$key] = $v->$value;	
		}
		return $data;
	}
	
	//获取角色列表
	// function get_roles($offset=0, $limit=0, $data)
	// {	
	// 	if ($data['rolename'] != ''){
	// 		$this->db->like('name', $data['rolename']); 
	// 	}
	// 	$this->db->where('del',0);
	// 	$this->db->join('boolname as b', 'r.disable=b.num', 'left');
		
	// 	if ($offset == 0 and $limit == 0){
	// 		$this->db->select('count(*) as sum');
	// 	}else{
	// 		$this->db->select('r.id,b.boolean_name as bannedname,name as rolename,rights,openkakou,disable');
	// 		$this->db->limit($limit, $offset);
	// 		$this->db->order_by('r.id','asc');
	// 	}
	// 	return $this->db->get('roles as r');
	// }

	//获取角色列表
	// function get_roles($offset=0, $limit=0, $sort='r.id', $order='asc', $data)
	function get_roles($offset=0, $limit=0, $sort='id', $order='asc', $data)
	{	
		if ($data['role_name'] != ''){
			$this->db->like('name', $data['role_name']); 
		}
		$this->db->where('del',0);
		// $this->db->join('boolname as b', 'r.disable=b.num', 'left');
		if ($offset == 0 and $limit == 0){
			$this->db->select('count(*) as sum');
		}else{
			// $this->db->select('r.id,b.boolean_name as bannedname,name as rolename,rights,openkakou,disable');
			$this->db->select('id,name as rolename,rights,openkakou,disable');
			$this->db->limit($limit, $offset);
			$this->db->order_by($sort, $order);
		}
		// return $this->db->get('roles as r');
		return $this->db->get('roles');
	}
	
	
	function get_roles_data()
	{
		$this->db->select('id,name as text');
		
		return $this->db->where('del',0)->get('roles');
	}
	/*
	function get_roles_num()
	{
		return $this->db->where('del',0)->get('roles');
	}*/
	
	//添加角色
	function add_role($data)
	{
		return $this->db->insert('roles', $data);
	}
	
	//修改角色信息
	function edit_role($id, $data)
	{
		return $this->db->where('id', $id)->update('roles', $data);
	}
	
	//删除角色
	function del_role($id)
	{
		return $this->db->where('id',$id)->set('del',1)->update('roles');
	}
	
    /**
     * 根据用户组ID获取用户信息
     *
     * @access  public
     * @param   int
     * @return  object
     */
	function get_role_by_id($id)
	{
		return $this->db->where('id', $id)->get('roles')->row();
	}
	
	function get_role_by_condition($array)
	{
		return $this->db->where($array)->get('roles');
	}
	
	//根据角色id检查用户名字有没重复（除了自身）
    function is_rolename_available($role_id, $role_name)
    {
		$roid = $this->db->query("select * from roles where id !='$role_id' and name='$role_name' and del=0");
		
		return $roid->num_rows() == 0;
    }
}
?>

