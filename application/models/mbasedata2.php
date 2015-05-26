<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mbasedata2 extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}

	//根据条件查询系统设置信息
	function getCfgKakou()
	{
		return $this->ora_db->query("select * from cfg_kakou");
	}

}
?>
