<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msms extends CI_Model
{
	private $logo_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->logo_db = $this->load->database('logo_db', TRUE);
	}

	//��ȡ���ŷ��ͺ���
	function get_sms($offset,$rows,$sort,$order,$data)
	{
		if ($offset == 0 and $rows == 0){
			$this->logo_db->select('count(*) as sum');
		} else {
			$this->logo_db->select('*');
			$this->logo_db->where('banned',0);
			$this->logo_db->limit($rows, $offset);
		}
		return $this->logo_db->get('sms');
	}

	//��Ӷ��ŷ��ͺ���
	function add_sms($data)
	{
		return $this->logo_db->insert('sms',$data);
	}
	
	//�޸Ķ��ŷ��ͺ���
	function edit_sms($id, $data)
	{
		return $this->logo_db->where('id', $id)->update('sms', $data);
	}

	//��Ӷ��ŷ��ͺ���
	function del_sms($id)
	{
		$data['banned'] = 1;
		return $this->logo_db->where('id', $id)->update('sms', $data);
	}
	
	//����ID��ȡ������Ϣ
	function get_sms_by_id($id)
	{
		$this->logo_db->select('*');
		$this->logo_db->where('banned',0)->where('id',$id);
		return $this->logo_db->get('sms');
	}
	
}
?>
