<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Muser2 extends CI_Model
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
	function get_roles($offset=0, $limit=0, $sort='r.id', $order='asc', $data)
	{	
		if ($data['rolename'] != ''){
			$this->db->like('name', $data['rolename']); 
		}
		$this->db->where('del',0);
		$this->db->join('boolname as b', 'r.disable=b.num', 'left');
		if ($offset == 0 and $limit == 0){
			$this->db->select('count(*) as sum');
		}else{
			$this->db->select('r.id,b.boolean_name as bannedname,name as rolename,rights,openkakou,disable');
			$this->db->limit($limit, $offset);
			$this->db->order_by($sort,$order);
		}
		return $this->db->get('roles as r');
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
	
	//获取角色列表
	function get_users($offset=0, $limit=0, $sort='u.id', $order='asc', $data)
	{	
		if ($data['username'] != ''){
			$this->db->like('username', $data['username']); 
		}
		if ($data['department'] != ''){
			$this->db->like('department', $data['department']); 
		}
		$this->db->where('disabled',0);
		$this->db->where('r.del',0);
		$this->db->join('roles as r', 'u.role_id=r.id');
		
		if ($offset == 0 and $limit == 0){
			$this->db->select('count(*) as sum');
		}else{
			$this->db->select('u.id,r.name as rolename,b.boolean_name as bannedname,role_id,username,realname,department,banned,last_ip,last_login,identity,phone,access_type,access_count,limit_login_address,memo');
			$this->db->join('boolname as b', 'u.banned=b.num', 'left');
			$this->db->limit($limit, $offset);
			$this->db->order_by($sort,$order);
		}
		
		return $this->db->get('users as u');
	}
	
	//根据角色id检查用户名字有没重复（除了自身）
    function is_rolename_available($role_id, $role_name)
    {
		$roid = $this->db->query("select * from roles where id !='$role_id' and name='$role_name' and del=0");
		
		return $roid->num_rows() == 0;
    }
    
    //根据用户名确认用户登录权限
	function check_user_entry_permission($username, $banned)
	{
		$this->db->where('username', $username);
		
		if($banned != '')
		{
			$this->db->where('banned', $banned);
		}
		
		return $this->db->get('users');
	}
	
	function get_user_by_name($username,$id=0)
	{
		$this->db->where('username',$username);
		$this->db->where('disabled',0);
		$this->db->where('id');
		return $this->db->get('users');
	}
	
	//用户名登录次数加1
	function user_access_count($user_id)
	{
		$res = $this->db->where('id', $user_id)->get('users')->row();
		$access_num = $res->access_count + 1;
		
		$data = array(
				'access_count'=> $access_num
				);
		return $this->db->where('id', $user_id)->update('users', $data);
	}
	
	//根据用户ID和密码查询
	function check_pwd($id,$pwd)
	{
		$this->db->where('id', $id);
		$this->db->where('password', $pwd);
		return $this->db->get('users');
	}
	
	//用户名登录次数加1
	function login_user_flag($da)
	{
		$res = $this->db->where('id', $da['user_id'])->get('users')->row();
		$access_num = $res->access_count + 1;
		
		$data = array(
				'access_count'=> $access_num,
				'last_login'  => $da['login_time'],
				'last_ip'     => $da['login_ip']
				);
		return $this->db->where('id', $da['user_id'])->update('users', $data);
	}
	
	//批量获取用户信息
	/*
	function get_users($offset, $row_count)
	{
		$this->db->select('users.*')->select('roles.name as role_name')->from('users')->where('disabled',0)->limit($row_count, $offset)->join('roles','users.role_id = roles.id');
		return $this->db->get();
	}*/
	
	//批量获取用户信息
	function get_users_num()
	{
		return $this->db->where('disabled',0)->get('users');
	}
	
	function get_user_by_condition($array)
	{
		return $this->db->where($array)->get('users');
	}
	//根据ID获取用户信息
	function get_user_by_id($id)
	{
		return $this->db->where('id',$id)->get('users');
	}
	
	//添加新用户
	function add_user($data)
	{
		return $this->db->insert('users',$data);
	}
	
	function edit_user($id,$data)
	{
		return $this->db->where('id', $id)->update('users', $data);
	}
	
	//根据ID删除用户
	function del_user_by_id($id)
	{
		return $this->db->where('id',$id)->set('disabled',1)->update('users');
	}
	
	//根据ID禁用用户
	function bann_user_by_id($id)
	{
		return $this->set('banned', 1)->update('users')->where('id',$id);
	}
	
	function change_password_by_id($id,$password)
	{
		$data = array('password' => $password);
		return $this->db->where('id', $id)->update('users', $data);
	}
	
	function find_user($offset,$row_count,$name)
	{
		$this->db->select('users.*');
		$this->db->select('roles.name as role_name');
		$this->db->from('users')->where('disabled',0);
		$this->db->like('username', $name);
		$this->db->limit($row_count, $offset)->join('roles','users.role_id = roles.id');
		return $this->db->get();
	}
	
	function find_user_num($name)
	{
		$this->db->select('count(id) as num');
		$this->db->from('users')->where('disabled',0);
		$this->db->like('username', $name);
		return $this->db->get();
	}
	
	function login($username,$password)
	{
		$this->db->select('users.id as user_id');
		$this->db->select('users.username as username');
		$this->db->select('roles.id as role_id');
		$this->db->select('roles.name as role_name');
		$this->db->select('roles.rights as role_right');
		$this->db->select('roles.openkakou as role_openkakou');
		$this->db->select('users.banned as u_banned');
		$this->db->select('users.disabled as u_disabled');
		$this->db->select('roles.disable as r_banned');
		$this->db->select('roles.del as r_disabled');
		
		$this->db->where('users.username',$username);
		$this->db->where('users.password',$password);
		$this->db->from('users');
		$this->db->join('roles','users.role_id = roles.id','left');
		
		return $this->db->get();
		//return $query;
	}
}
?>

