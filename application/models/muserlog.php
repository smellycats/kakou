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
	
	//获取用户信息
	function get_users()
	{
		return $this->db->get('users');
	}
	
	//获取用户操作日志
	function get_userlogs($offset=0, $limit=0, $sort='czsj', $order='desc', $data)
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
			$this->db->order_by($sort,$order);
		}
		
		return $this->db->get('userlog');;
	}
	
	//添加用户日志
	function add_userlog($data)
	{
		return $this->db->insert('userlog', $data); 
	}

	//编辑用户日志
	function edit_userlog($id, $data)
	{
		$this->db->where('id',$id);
		return $this->db->update('userlog',$data);
	}
	
}
?>