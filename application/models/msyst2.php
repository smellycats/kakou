<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msyst2 extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/*
	 * IP���ú���
	 */
	//��ȡIP
	function get_ip_access2($offset=0, $rows=0, $data=array())
	{	
		$this->db->where('del',0);
		if ($rows == 0){
			$this->db->select('count(*) as sum');
		} else {
			$this->db->select('id,minip,maxip,banned');
			$this->db->limit($rows, $offset);
		}
		return $this->db->get('ip_access2');
	}
	
	//���IP
	function add_ip_access2($data)
	{
		return $this->db->insert('ip_access2', $data);
	}
	
	//�༭IP
	function edit_ip_access2($id, $data)
	{
		return $this->db->where('id', $id)->update('ip_access2', $data);
	}
	
	/*
	 * ���溯��
	 */
	//��ȡ����
	function get_notice($offset=0, $rows=0, $data=array())
	{	
		$this->db->where('del',0);
		if ($rows == 0){
			$this->db->select('count(*) as sum');
		} else {
			$this->db->select('id,created,modified,content,banned');
			$this->db->limit($rows, $offset);
		}
		return $this->db->get('notice');
	}
	
	//��ӹ���
	function add_notice($data)
	{
		return $this->db->insert('notice', $data);
	}
	
	//�༭����
	function edit_notice($id, $data)
	{
		return $this->db->where('id', $id)->update('notice', $data);
	}
	
	function get_notice_all()
	{	
		$this->db->select('id,created,modified,content,banned');
		$this->db->where('banned',0);
		$this->db->where('del',0);

		return $this->db->get('notice');
	}
	
	//��ÿ�����IP���ʿ��Ƶ�ַ��Ϣ_mysql
	function get_ip_access_by_condition_mysql($bool)
	{
		$sqlstr = ' 1=1';
		
		if($bool != '')
		{
			$sqlstr = $sqlstr . " AND CLBJ='$bool'";
		}
		return $this->db->query("select * from ip_access where " . $sqlstr);
	}
}
?>