<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msms extends CI_Model
{
	private $logo_db;
    /**
     * Construct a muser instance
     *
     */
	public function __construct()
	{
		parent::__construct();
		
		$this->logo_db = $this->load->database('logo_db', TRUE);
	}

    /**
     * 获取短信发送号码
     * 
     * @param int $offset 偏移量
     * @param int $limit 行数
     * @param string $sort 排序字段
     * @param string $order 排序方向
     * @param array $data 查询数组
     * @return object
     */
	function getSms($offset = 0 ,$limit = 0, $sort = 'id' ,$order = 'desc', $data)
	{
		if ($limit == 0){
			$this->logo_db->select('count(*) as sum');
		} else {
			$this->logo_db->select('*');
			$this->logo_db->where('banned', 0);
			$this->logo_db->limit($limit, $offset);
		}

		return $this->logo_db->get('sms');
	}

    /**
     * 添加短信发送号码
     * 
     * @param array $data 短信信息
     * @return object
     */
	function addSms($data)
	{
		return $this->logo_db->insert('sms', $data);
	}

    /**
     * 编辑短信发送号码
     * 
     * @param int $id id编号
     * @param array $data 短信信息
     * @return object
     */
	function setSms($id, $data)
	{
		return $this->logo_db->where('id', $id)->update('sms', $data);
	}
	
    /**
     * 根据ID获取短信信息
     * 
     * @param int $id id编号
     * @return object
     */
	function getSmsById($id)
	{
		$this->logo_db->select('*');
		$this->logo_db->where('banned', 0);
		$this->logo_db->where('id', $id);

		return $this->logo_db->get('sms');
	}
	
}
?>
