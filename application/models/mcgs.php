<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcgs extends CI_Model
{
	private $cgs_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->cgs_db = $this->load->database('test_db', TRUE);
	}
	
	#根据车牌号码查询广东车管信息
	function get_vehicle_gd_by_hphm($data)
	{
		return $this->cgs_db->query("select v.*,h.name as hpzl_name,d.name as cllx_name,c.code as csys_code,c.name as csys_name from vehicle_gd as v
		 LEFT JOIN hpzl as h ON v.hpzl = h.code
		 LEFT JOIN d_cllx as d ON d.code = v.cllx
		 LEFT JOIN csys as c ON SUBSTRING(v.csys,1,1) = c.code 
		 WHERE v.hphm = '$data[hphm]' AND h.banned = 0 ");
	}
	
	#根据车牌号码查询广东车管信息
	function get_vehicle_gd($data)
	{
		$this->cgs_db->select('v.*,h.name as hpzl_name,d.name as cllx_name,c.code as csys_code,c.name as csys_name');
		$this->cgs_db->join('hpzl as h','v.hpzl = h.code','left');
		$this->cgs_db->join('d_cllx as d','d.code = v.cllx','left');
		$this->cgs_db->join('csys as c','SUBSTRING(v.csys,1,1) = c.code','left');
		$this->cgs_db->where('v.hphm',$data['hphm']);
		$this->cgs_db->where('h.banned',0);
		return $this->cgs_db->get('vehicle_gd as v');
	}
}
?>
