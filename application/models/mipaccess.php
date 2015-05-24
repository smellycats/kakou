<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mipaccess extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	//获取列表
	function get_ipaccess($offset=0, $limit=0, $sort='id', $order='asc', $data)
	{	
		$this->db->where('del',0);
		if ($offset == 0 and $limit == 0){
			$this->db->select('count(*) as sum');
		}else{
			$this->db->select('*');
			$this->db->limit($limit, $offset);
			$this->db->order_by($sort,$order);
		}
		
		return $this->db->get('ip_access2');
	}
	
	//根据ID获取
	function get_ipaccess_by_id($id)
	{	
		$this->db->select('*');
		$this->db->where('id',$id);
		return $this->db->get('ip_access2');
	}
	
	//添加
	function add_ipaccess($data)
	{
		return $this->db->insert('ip_access2',$data);
	}
	
	//编辑
	function edit_ipaccess($id, $data)
	{
		$this->db->where('id',$id);
		return $this->db->update('ip_access2',$data);
	}
}