<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlogo extends CI_Model
{
	private $logo_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->logo_db = $this->load->database('logo_db', TRUE);
	}

	//获取监控地点
	function get_places()
	{
		$this->logo_db->select('*')->order_by('order','asc');
		return $this->logo_db->get('places');
	}

}
?>
