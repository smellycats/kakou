<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcgs extends CI_Model
{
	private $cgs_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->cgs_db = $this->load->database('cgs_db', TRUE);
	}
	
	#根据车牌号码查询广东车管信息
	function getVehicleGdByHphm($hphm, $hpys_id)
	{
		return $this->cgs_db->query("SELECT v.*,h.name AS hpzl_name,d.name AS cllx_name,c.code AS csys_code,c.name AS csys_name from vehicle_gd AS v
		 LEFT JOIN hpzl AS h ON v.hpzl = h.code
		 LEFT JOIN d_cllx AS d ON d.code = v.cllx
		 LEFT JOIN csys AS c ON SUBSTRING(v.csys,1,1) = c.code 
		 WHERE v.hphm = '$hphm' AND h.color_id='$hpys_id' AND h.banned = 0 ");
	}
}
?>
