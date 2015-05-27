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
		
		if ($offset == 0 and $limit == 0){
			$this->db->select('count(*) as sum');
		} else {
			$this->db->select('u.id');
			$this->db->select('r.name as rolename');
			$this->db->select('role_id');
			$this->db->select('username');
			$this->db->select('realname');
			$this->db->select('department');
			$this->db->select('created');
			$this->db->select('banned');
			$this->db->select('last_ip');
			$this->db->select('identity');
			$this->db->select('phone');
			$this->db->select('access_type');
			$this->db->select('access_count');
			$this->db->select('limit_login_address');
			$this->db->select('memo');

			$this->db->limit($limit, $offset);
			$this->db->order_by($sort, $order);
		}
		$this->db->where('disabled', 0);
		$this->db->where('r.del', 0);
		$this->db->join('roles as r', 'u.role_id=r.id');
		
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

