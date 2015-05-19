<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mbasedata extends CI_Model
{
	private $logo_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->logo_db = $this->load->database('logo_db', TRUE);
		$this->db = $this->load->database('default', TRUE);
	}

	//获取监控地点
	function get_places()
	{
		$this->logo_db->select('*');
		$this->logo_db->where('banned',0);
		$this->logo_db->order_by('order','asc');
		
		return $this->logo_db->get('places');
	}
	
	//获取监控地点
	function get_places_by_perm($right)
	{
		$this->logo_db->select('*')->order_by('order','asc');
		$this->logo_db->where('banned',0);
		$this->logo_db->where_in('config_id',$right);
		
		return $this->logo_db->get('places');
	}
	
	//车牌类型
	function get_hpzl()
	{
		$this->logo_db->select('*');
		return $this->logo_db->get('hpzl');
	}
	
	//车标类型
	function get_logos()
	{
		$this->logo_db->select('*');
		return $this->logo_db->get('logos');
	}
	
	//品牌代码
	function get_ppdm()
	{
		$this->logo_db->select('*');
		return $this->logo_db->get('ppdm');
	}
	
	//车辆类型
	function get_cllx()
	{
		$this->logo_db->select('*');
		return $this->logo_db->get('cllx');
	}
	
	//车辆类型2
	function get_d_cllx()
	{
		$this->logo_db->select('*');
		return $this->logo_db->get('d_cllx');
	}
	
	//根据ID查询汽车品牌类型
	function get_caridmap_by_id($id)
	{
		$this->logo_db->select('*')->where('id',$id);
		return $this->logo_db->get('caridmap');
	}
	
	//车身类型
	function get_csys()
	{
		$this->logo_db->select('*');
		return $this->logo_db->get('csys');
	}
	

	
	#根据ID获取车辆信息
	function get_carinfo_by_id($id)
	{
		$this->logo_db->select('i.*, m.code, m.name');
		$this->logo_db->join('ppdm as m','i.ppdm = m.code');
		$this->logo_db->where('i.id',$id);
		return $this->logo_db->get('carinfo as i');
	}
	
	#根据ID获取车辆信息
	function get_full_carinfo_by_id($id)
	{
		$this->logo_db->select('i.*, p.place, m.code, m.name');
		$this->logo_db->join('ppdm as m','i.ppdm = m.code','left');
		$this->logo_db->join('places as p','i.cltx_place = p.id','left');
		$this->logo_db->where('i.id',$id);
		return $this->logo_db->get('carinfo as i');
	}
	
	#根据车牌号码查询广东车管信息
	function get_vehicle_gd_by_hphm($hphm)
	{
		$this->logo_db->select('v.*');
		$this->logo_db->join('hpzl as h','v.hpzl = h.code','left');
		$this->logo_db->where('v.hphm',$hphm);
		$this->logo_db->where('h.banned',0);
		return $this->logo_db->get('vehicle_gd as v');
	}
	
	#获取菜单
	function get_menu($fid=0)
	{
		$this->db->select('*');
		$this->db->where('fid',$fid);
		$this->db->where('status',1);
		$this->db->order_by('arrange');
		return $this->db->get('menu');
	}

	/*
	 * 公告函数
	 */
	//获取公告
	function get_notice()
	{	
		$this->db->select('id,created,modified,content,banned');
		$this->db->where('banned',0);
		$this->db->where('del',0);

		return $this->db->get('notice');
	}
	
	function get_clpp2($clpp)
	{	
		$this->logo_db->select('*');
		$this->logo_db->where('clpp1',$clpp);

		return $this->logo_db->get('clpp2_dict');
	}
}
?>
