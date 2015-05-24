<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnotice extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	//获取公告列表
	function get_notices($offset=0, $limit=0, $sort='id', $order='asc', $data)
	{	
		$this->db->where('del',0);
		
		if ($offset == 0 and $limit == 0){
			$this->db->select('count(*) as sum');
		}else{
			$this->db->select('*');
			$this->db->limit($limit, $offset);
			$this->db->order_by($sort,$order);
		}
		
		return $this->db->get('notice');
	}
	
	//根据ID获取公告
	function get_notice_by_id($id)
	{
		return $this->db->where('id',$id)->get('notice');
	}
	
	//添加公告
	function add_notice($data)
	{
		return $this->db->insert('notice',$data);
	}
	
	//编辑公告
	function edit_notice($id, $data)
	{
		$this->db->where('id',$id);
		return $this->db->update('notice',$data);
	}
}