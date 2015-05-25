<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Muser extends CI_Model
{
    /**
     * Construct a muser instance
     *
     */
	public function __construct()
	{
		parent::__construct();
	}
	
    /**
     * ����������ѯ�û���Ϣ
     * 
     * @param int $offset ƫ����
     * @param int $limit ����
     * @param string $sort �����ֶ�
     * @param string $order ������
     * @param array $data ��ѯ����
     * @return object
     */
	public function getUsers($offset = 0, $limit = 0, $sort = 'u.id', $order = 'asc', $data)
	{	
		if ($data['username'] != ''){
			$this->db->like('username', $data['username']); 
		}
		if ($data['department'] != ''){
			$this->db->like('department', $data['department']); 
		}
		$this->db->where('disabled', 0);
		$this->db->where('r.del', 0);
		$this->db->join('roles as r', 'u.role_id=r.id');
		
		if ($offset == 0 and $limit == 0){
			$this->db->select('count(*) as sum');
		} else {
			$this->db->select('u.id,r.name as rolename,role_id,username,realname,department,created,banned,last_ip,last_login,identity,phone,access_type,access_count,limit_login_address,memo');
			$this->db->limit($limit, $offset);
			$this->db->order_by($sort, $order);
		}
		
		return $this->db->get('users as u');
	}

    /**
     * ����id��ȡ�û���Ϣ
     * 
     * @param int $id ���
     * @return object
     */
	public function getUserById($id)
	{
		return $this->db->where('id', $id)->get('users');
	}

    /**
     * ����������ȡ�û���Ϣ
     * 
     * @param array $array ��ѯ��������
     * @return object
     */
	public function getUserByCondition($array)
	{
		return $this->db->where($array)->get('users');
	}
	
    /**
     * ����û�
     * 
     * @param array $array �û���Ϣ����
     * @return object
     */
	public function addUser($data)
	{
		return $this->db->insert('users', $data);
	}
	
    /**
     * ����id�༭�û���Ϣ
     * 
     * @param int $id ���
     * @param array $array �û���Ϣ����
     * @return object
     */
	public function setUser($id, $data)
	{
		return $this->db->where('id', $id)->update('users', $data);
	}
	
    /**
     * ��ȡ��ɫ�б�
     * 
     * @return object
     */
	public function getSelRoles()
	{
		$this->db->select('id, name');
		$this->db->where('del', 0);
		
		return $this->db->get('roles');
	} 
	

}
?>

