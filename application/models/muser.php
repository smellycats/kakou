<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Muser extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	
	function get_user_by_name($username)
	{
		return $this->db->where('username',$username)->get('users');
	}
	
	
	//��ȡ�û��б�
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
	
	//����ID��ȡ�û���Ϣ
	function get_user_by_id($id)
	{
		return $this->db->where('id',$id)->get('users');
	}
	
	//����������ȡ�û���Ϣ
	function get_user_by_condition($array)
	{
		return $this->db->where($array)->get('users');
	}
	
	//������û�
	function add_user($data)
	{
		return $this->db->insert('users',$data);
	}
	
	//�༭�û�
	function edit_user($id, $data)
	{
		$this->db->where('id',$id);
		return $this->db->update('users',$data);
	}
	
	/*
	//����IDɾ���û�
	function del_user_by_id($id)
	{
		return $this->db->where('id',$id)->set('disabled',1)->update('users');
	}
	
	//����ID�����û�
	function bann_user_by_id($id)
	{
		return $this->set('banned', 1)->update('users')->where('id',$id);
	} */
	
	//��ȡ��ɫ�б�
	function get_roles()
	{
		$this->db->select('id, name');
		$this->db->where('del',0);
		
		return $this->db->get('roles');
	} 
	

}
?>

