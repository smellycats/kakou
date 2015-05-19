<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * 日志查询 模型
  * 
  *
  */

class Mlog2 extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	//获取用户信息
	function get_users_info()
	{
		return $this->db->get('users');
	}
	
	//获取用户操作日志
	function get_userlog($offset=0, $rows=0, $sort='desc', $order='id', $data)
	{
		if(!empty($data['username']) AND $data['username'] != '')
		{
			$this->db->where('uname',$data['username']);
		}
		if(!empty($data['starttime']) AND $data['starttime'] != '')
		{
			$this->db->where('czsj >=',$data['starttime']);
		}
		if(!empty($data['endtime']) AND $data['endtime'] != '')
		{
			$this->db->where('czsj <=', $data['endtime']);
		}
		
		$this->db->where('disabled', 0);
		
		if ($rows == 0){
			$this->db->select('count(*) as sum');
		} else {
			$this->db->limit($rows, $offset)->order_by('czsj','desc');
		}
		
		return $this->db->get('userlog');
	}
	
	//删除用户操作信息
	function del_userlog($data)
	{
		if(!empty($data['username']) AND $data['username'] != '')
		{
			$this->db->where('uname',$data['username']);
		}
		if(!empty($data['starttime']) AND $data['starttime'] != '')
		{
			$this->db->where('czsj >=',$data['starttime']);
		}
		if(!empty($data['endtime']) AND $data['endtime'] != '')
		{
			$this->db->where('czsj <=', $data['endtime']);
		}
		
		$da = array(
				'disabled' => 1
			);
		return $this->db->update('userlog', $da);
	}
	
	//添加用户操作
	function add_userlog($data)
	{
		return $this->db->insert('userlog', $data); 
		
	}
}
?>