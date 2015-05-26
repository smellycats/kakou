<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Madmin extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * ��ò˵�����
	 */
	function get_menu()
	{
		//���menu��fidΪ0�����ݣ����뵽����$f_datas��
		$f_datas = $this->db->select('*')->from('menu')->where('fid',0)->where('status', '1')->order_by('arrange', 'asc')->get()->result_array();
		
		//��ÿһ��fidΪ0���Ӳ˵�����׷�ӵ�����$f_datas��childrens�������С�
		foreach($f_datas as $f_num => $f_data)
		{
			$f_datas[$f_num]['childrens'] = $this->db->select('*')->from('menu')->where('fid',$f_data['id'])->where('status', '1')->get()->result_array();
		}
		
		return $f_datas;
	}
	
	/**
	 * 
	 * ����Ȩ�޻�ȡ�˵�����
	 * @param unknown_type $role_id
	 */
	function get_menu_by_prem($role_id)
	{
		$rights = $this->db->select('*')->from('roles')->where('id',$role_id)->get()->row();
		
		if($rights != '')
		{
			$rights_to_arr = explode(',', $rights->rights);
			//��ȡ�˵�Ȩ�޵ĸ�ID
			$fid = $this->db->select('fid')->from('menu')->where_in('id', $rights_to_arr)->where('status', '1')->order_by('arrange', 'asc')->group_by('fid')->get()->result();

			foreach($fid as $num=>$f)
			{
				$fid_to_arr[$num] = $f->fid;
			}
			//����Ȩ�޻��menu��fid�����ݣ����뵽����$f_datas��
			$f_datas = $this->db->select('*')->from('menu')->where_in('id', $fid_to_arr)->get()->result_array();
		
			$right_datas = $this->db->select('*')->from('menu')->where_in('id', $rights_to_arr)->where('status', '1')->get()->result_array();
		
			foreach ($f_datas as $f_num => $f_data)
			{
				$f_datas[$f_num]['childrens'] = $this->db->select('*')->from('menu')->where('fid',$f_data['id'])->where_in('id', $rights_to_arr)->where('status', '1')->get()->result_array();
			}
		}
		else 
		{
			$f_datas = null;
		}
		
		return $f_datas;
	}
	
	function get_menu_by_name($name)
	{
		return $this->db->select('*')->from('menu')->where('name',$name)->get();
	}
	
	//����ID��ȡ�û���Ϣ
	function getUserById($id)
	{
		return $this->db->where('id',$id)->get('users');
	}
	
	//�༭�û�
	function edit_user($id, $data)
	{
		$this->db->where('id',$id);
		return $this->db->update('users',$data);
	}
}

/* End of file madmin.php */
/* Location: ./application/models/madmin.php */
?>
