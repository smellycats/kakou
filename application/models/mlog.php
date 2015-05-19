<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * 日志查询 模型
  * 
  *
  */

class Mlog extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}
	
	//获取用户信息
	function get_users_info()
	{
		return $this->db->get('users');
	}
	
	//获取用户操作日志
	function get_userlog($offset = 0, $rows = 0, $data)
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
		
		if ($offset >= 0 AND $row_count > 0)
		{	
			$query = $this->db->limit($rows, $offset)->order_by('czsj','desc')->get('userlog');
		}
		else
		{
			$query = $this->db->from('userlog')->count_all_results();
		}
		
		return $query;
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
	
	function get_syslog($data)
	{
		$sqlstr = '';
		
		if ($data['kakou'] !='' AND $data['kakou'] != 'all')
		{
			$sqlstr = $sqlstr . " and kkmz='$data[kakou]'";
		}
		if ($data['jllx'] != '' AND $data['jllx'] != 'all')
		{
			$sqlstr = $sqlstr . " and jllx='$data[jllx]'";
		}
		
		return $this->ora_db->query("select * from syslog where gxsj >= '$data[starttime]' and gxsj <= '$data[endtime]'" . $sqlstr . " order by gxsj desc");
	}
}
?>