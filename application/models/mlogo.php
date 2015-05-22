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
	
	//获取监控地点
	function get_places_by_perm($right)
	{
		$this->logo_db->select('*')->order_by('order','asc');
		$this->logo_db->where('banned',0);
		$this->logo_db->where_in('place',$right);
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
	
	function get_confirm_carinfo($offset=0, $limit=0, $data)
	{
		$this->logo_db->where('passtime >=',$data['starttime'])->where('passtime <=',$data['endtime']);
		#地点
		if($data['place']=='all'){
			$this->logo_db->where('i.cltx_place >=',0);
		}else{
			$this->logo_db->where('cltx_place',$data['place']);
		}
		#方向
		if($data['direction']=='all'){
			$this->logo_db->where('cltx_dire >=',0);
		}else{
			$this->logo_db->where('cltx_dire',$data['direction']);
		}
		
		#车标
		if($data['logo']=='all'){
			$data['logo'] = $data['logo'];
		}else{
			$this->logo_db->where('m.code',$data['logo']);
		}
		
		#确认信息
		if($data['confirm']=='all'){
			$this->logo_db->where('confirmflag >=',0);
		}else{
			$this->logo_db->where('confirmflag',intval($data['confirm']));
		}
		#短信确认
		if($data['smsflag']=='all'){
			$this->logo_db->where('smsflag >=',0);
		}else{
			$this->logo_db->where('smsflag',intval($data['smsflag']));
		}
		#车辆品牌确认
		if($data['clppflag']=='all'){
			$this->logo_db->where('clppflag >=',0);
		}else{
			$this->logo_db->where('clppflag',intval($data['clppflag']));
		}		
		
		#号牌号码
		if($data['number']=='R'){
			$this->logo_db->where('length(cltx_hphm) >=',2);
		}
		elseif($data['number']=='?'){
			if($data['carnum']==''){
				$data['carnum'] = $data['carnum'];
			}
			else{
				$this->logo_db->where('cltx_hphm like','%'.$data['carnum']);
			}
		}
		else{
			$this->logo_db->where('cltx_hphm like',$data['platename'].'%');
		}
		
		$this->logo_db->join('ppdm as m','i.ppdm = m.code');
		
		if ($limit==0){
			$this->logo_db->select('count(*) as sum');
			
			return $this->logo_db->get('carinfo as i');
		}else{
			$this->logo_db->select('i.*, m.code, m.name');
			$this->logo_db->order_by('i.id','desc');
			
			return $this->logo_db->get('carinfo as i',$limit,$offset);
		}
	}
	
	function get_confirm_carinfo3($offset=0, $limit=0, $sort='i.id', $order='desc', $data)
	{
		$this->logo_db->where('passtime >=',$data['st'])->where('passtime <=',$data['et']);
		#地点
		$data['place'] == 'all' ? $this->logo_db->where('i.cltx_place >=',0) : $this->logo_db->where('cltx_place',$data['place']);
		#方向
		$data['dire'] == 'all' ? $this->logo_db->where('cltx_dire >=',0) : $this->logo_db->where('cltx_dire',$data['dire']);
		#车标
		$data['ppdm'] == 'all' ? $this->logo_db->where('m.code >=',0) : $this->logo_db->where('m.code',$data['ppdm']);
		#车辆类型
		$data['confirm'] == 'all' ? $this->logo_db->where('i.confirmflag >=',0) : $this->logo_db->where('i.confirmflag',$data['confirm']);
		#车身颜色
		$data['smsflag'] == 'all' ? $this->logo_db->where('i.smsflag >=',0) : $this->logo_db->where('i.smsflag',$data['smsflag']);
		#车牌颜色
		$data['clppflag'] == 'all' ? $this->logo_db->where('i.clppflag >=',0) : $this->logo_db->where('i.clppflag',$data['clppflag']);
		
		#号牌种类
		$this->logo_db->where('i.hpzl >=',0);
		
		switch ($data['number']){
			case 'R':
				$this->logo_db->where('length(cltx_hphm) >=',2);
				break;
			case '?':
				$data['carnum'] == '' ? $data['carnum'] = $data['carnum'] : $this->logo_db->where('cltx_hphm like','%'.$data['carnum']);
				break;
			default:
				$this->logo_db->where('cltx_hphm like',$data['platename'].'%');
		}	
		
		$this->logo_db->join('ppdm as m','i.ppdm = m.code');
		
		if ($limit == 0){
			$this->logo_db->select('count(*) as sum');
			
			return $this->logo_db->get('carinfo as i');
		}else{
			$this->logo_db->select('i.id,i.passtime,i.cltx_hphm as hphm,i.cltx_lane as lane,i.clpp as clpp_son, m.code, m.name as clpp, p.place as place, s.color as hpys, c.name as cllx, d.dire as dire, y.name as csys,i.confirmflag as confirm,i.clppflag as clppflag,i.smsflag as smsflag');
			$this->logo_db->join('places as p','i.cltx_place = p.id','left');
			$this->logo_db->join('cllx as c','i.cllx = c.code','left');
			$this->logo_db->join('platecolor as s','i.cltx_color = s.id','left');
			$this->logo_db->join('directions as d','i.cltx_dire = d.id','left');
			$this->logo_db->join('csys as y','i.csys = y.code','left');
			$this->logo_db->order_by($sort,$order);
			
			return $this->logo_db->get('carinfo as i',$limit,$offset);
		}
	}
	
	function get_carinfo($offset=0, $limit=0, $data)
	{
		$this->logo_db->where('passtime >=',$data['starttime'])->where('passtime <=',$data['endtime']);
		#地点
		if($data['place']=='all'){
			$this->logo_db->where('i.cltx_place >=',0);
		}else{
			$this->logo_db->where('cltx_place',$data['place']);
		}
		#方向
		if($data['direction']=='all'){
			$this->logo_db->where('cltx_dire >=',0);
		}else{
			$this->logo_db->where('cltx_dire',$data['direction']);
		}
		#车道
		if($data['lane']=='all'){
			$this->logo_db->where('cltx_lane >=',0);
		}else{
			$this->logo_db->where('cltx_lane',$data['lane']);
		}
		#车牌颜色
		if($data['platecolor']=='all'){
			$this->logo_db->where('cltx_color >=',0);
		}else{
			$this->logo_db->where('cltx_color',$data['platecolor']);
		}
		
		#车标
		if($data['logo']=='all'){
			$data['logo'] = $data['logo'];
		}else{
			$this->logo_db->where('m.code',$data['logo']);
		}
		
		#车辆类型
		if($data['cllx']=='all'){
			$this->logo_db->where('i.cllx >=',0);
		}else{
			$this->logo_db->where('i.cllx',$data['cllx']);
		}
		#车身颜色
		if($data['csys']=='all'){
			$this->logo_db->where('csys >=',0);
		}else{
			$this->logo_db->where('csys',$data['csys']);
		}
		#号牌种类
		$this->logo_db->where('i.hpzl >=',0);
		
		if($data['number']=='R'){
			$this->logo_db->where('length(cltx_hphm) >=',2);
		}
		elseif($data['number']=='?'){
			if($data['carnum']==''){
				$data['carnum'] = $data['carnum'];
			}
			else{
				$this->logo_db->where('cltx_hphm like','%'.$data['carnum']);
			}
		}
		else{
			$this->logo_db->where('cltx_hphm like',$data['platename'].'%');
		}
		
		$this->logo_db->join('ppdm as m','i.ppdm = m.code');
		
		if ($limit==0){
			$this->logo_db->select('count(*) as sum');
			
			return $this->logo_db->get('carinfo as i');
		}else{
			$this->logo_db->select('i.*, m.code, m.name');
			$this->logo_db->order_by('i.id','desc');
			
			return $this->logo_db->get('carinfo as i',$limit,$offset);
		}
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
	
	function get_all_carinfo_by_id($id)
	{
		$this->logo_db->select('i.*, m.code, m.name as clpp_name, p.place as place_name, s.color as color_name, c.name as cllx_name, d.dire as dire_name, y.name as csys_name');
		$this->logo_db->join('ppdm as m','i.ppdm = m.code');
		$this->logo_db->join('places as p','i.cltx_place = p.id','left');
		$this->logo_db->join('cllx as c','i.cllx = c.code','left');
		$this->logo_db->join('platecolor as s','i.cltx_color = s.id','left');
		$this->logo_db->join('directions as d','i.cltx_dire = d.id','left');
		$this->logo_db->join('csys as y','i.csys = y.code','left');
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
	
	function get_confirm($userid,$place_str,$dire='all')
	{
		$this->load->helper('date');
		$time1 = mdate("%Y-%m-%d %H:%i:%s",strtotime("-1 hours"));
		$time2 = mdate("%Y-%m-%d %H:%i:%s",strtotime("-20 seconds"));
		
		#$this->logo_db->query('LOCK TABLES userconfirm READ');
		
		$this->logo_db->select('c.*');
		$this->logo_db->join('userconfirm as u','c.id = u.carinfoid','left');
		$this->logo_db->where('c.passtime >=', $time1);
		$this->logo_db->where_in('c.cltx_place',$place_str);
		if ($dire == 'all'){
			$dire = $dire;
		}else{
			$this->logo_db->where('c.cltx_dire',$dire);
		}
		$this->logo_db->where('c.confirmflag', 0);
		$this->logo_db->where("c.id not in (SELECT a.id from carinfo as a LEFT JOIN userconfirm as b on a.id = b.carinfoid where b.timeflag < '$time2')");
		$this->logo_db->order_by("c.passtime", "desc");
		$this->logo_db->limit(1);
		$res = $this->logo_db->get('carinfo as c');
		
		if($res->num_rows()>0){
			$row = $res->row();
			$this->logo_db->where('userid', $userid);
			$data = array(
                'timeflag'  => mdate("%Y-%m-%d %H:%i:%s"),
                'carinfoid' => $row->id
             );
			$this->logo_db->update('userconfirm', $data);
			
			return $this->get_carinfo_by_id($row->id);
		}else{
			return $res;
		}
		#$this->logo_db->query('UNLOCK TABLES');	
	}
	
	function unlock()
	{
		$this->logo_db->query('UNLOCK TABLES');
	}
	
	#根据用户ID获取用户确认表
	function get_userconfirm_by_userid($userid)
	{
		$this->logo_db->select('*')->where('userid',$userid);
		return $this->logo_db->get('userconfirm');
	}
	
	#编辑用户确认表
	function edit_userconfirm($userid,$data)
	{
		$this->logo_db->where('userid', $userid);
 		return $this->logo_db->update('userconfirm', $data);
	}
	
	#添加用户确认表
	function add_userconfirm($data)
	{
		$this->logo_db->insert('userconfirm',$data);
	}
	
	#修改车辆确认信息
	function edit_confirm($id,$data)
	{
		$this->logo_db->where('id', $id);
 		return $this->logo_db->update('carinfo', $data);
	}
	

	function get_carinfo3($offset=0, $limit=0, $sort='i.id', $order='desc', $data)
	{
		$this->logo_db->where('passtime >=',$data['st']); # 开始时间
		$this->logo_db->where('passtime <=',$data['et']); # 结束时间
		#地点
		$data['place'] == 'all' ? $this->logo_db->where('i.cltx_place >=',0) : $this->logo_db->where('cltx_place',$data['place']);
		#方向
		$data['dire'] == 'all' ? $this->logo_db->where('cltx_dire >=',0) : $this->logo_db->where('cltx_dire',$data['dire']);
		#车道
		$data['lane'] == 'all' ? $this->logo_db->where('cltx_lane >=',0) : $this->logo_db->where('cltx_lane',$data['lane']);
		#车牌颜色
		$data['hpys'] == 'all' ? $this->logo_db->where('cltx_color >=',0) : $this->logo_db->where('cltx_color',$data['hpys']);
		# 车辆品牌
		if ($data['ppdm'] == 'all') {
			$this->logo_db->where('ppdm2 >=','000000');
		} elseif ($data['ppdm2'] == 'all') {
			$this->logo_db->where('ppdm2 like',$data['ppdm'].'%');
		} else {
			$this->logo_db->where('ppdm2',$data['ppdm2']);
		}
		#车辆类型
		$data['cllx'] == 'all' ? $this->logo_db->where('i.cllx >=',0) : $this->logo_db->where('i.cllx',$data['cllx']);
		#车身颜色
		$data['csys'] == 'all' ? $this->logo_db->where('i.csys >=',0) : $this->logo_db->where('i.csys',$data['csys']);
		#号牌种类
		$this->logo_db->where('i.hpzl >=',0);
		
		switch ($data['number']){
			case 'R':
				$this->logo_db->where('length(cltx_hphm) >=',2);
				break;
			case '?' || '？':
				$data['carnum'] == '' ? $data['carnum'] = $data['carnum'] : $this->logo_db->where('cltx_hphm like','%'.$data['carnum']);
				break;
			default:
				$this->logo_db->where('cltx_hphm like',$data['platename'].'%');
		}	
		
		$this->logo_db->join('ppdm as m','i.ppdm = m.code');
		
		if ($limit == 0){
			$this->logo_db->select('count(*) as sum');
			
			return $this->logo_db->get('carinfo as i');
		}else{
			$this->logo_db->select('i.id,i.passtime,i.cltx_hphm as hphm,i.cltx_lane as lane,i.clpp as clpp_son, m.code, m.name as clpp, p.place as place, s.color as hpys, c.name as cllx, d.dire as dire, y.name as csys,i.img_ip,i.img_path,i.img_disk');
			$this->logo_db->join('places as p','i.cltx_place = p.id','left');
			$this->logo_db->join('cllx as c','i.cllx = c.code','left');
			$this->logo_db->join('platecolor as s','i.cltx_color = s.id','left');
			$this->logo_db->join('directions as d','i.cltx_dire = d.id','left');
			$this->logo_db->join('csys as y','i.csys = y.code','left');
			$this->logo_db->order_by($sort,$order);
			
			return $this->logo_db->get('carinfo as i',$limit,$offset);
		}
	}
	
	function test($offset,$limit,$sort='id',$order='asc',$data=array())
	{
		if ($limit == 0){
			$this->logo_db->select('count(*) as sum');
			if($data != array()){
				$this->logo_db->where($data); 
			}
			return $this->logo_db->get('logos');
		}else{
			$this->logo_db->select('*');
			if($data != array()){
				$this->logo_db->where($data); 
			}
			$this->logo_db->order_by($sort,$order);
			return $this->logo_db->get('logos',$limit,$offset);
		}
	}
	
	function test2($name='')
	{
		$this->logo_db->where('cltx_hphm like',$name);
		return $this->logo_db->get('carinfo');
	}
	
	function get_places_for_real($array=array())
	{
		$this->logo_db->select('id,config_id,place');
		if ($array == array()){
			$this->logo_db->where('id >', 1);
		}else{
			$this->logo_db->where_in('config_id',$array);
		}
		$this->logo_db->where('banned', 0);
		$this->logo_db->order_by('order','asc');
		return $this->logo_db->get('places');
	}
	
	function get_real_carinfo($offset=0,$limit=8,$data)
	{
		$this->logo_db->select('i.id,i.passtime,i.cltx_hphm as hphm,i.cltx_lane as lane,i.clpp as clpp_son, m.code, m.name as clpp, p.place as place, s.color as hpys, c.name as cllx, d.dire as dire, y.name as csys,i.clppflag as clppflag');
		$this->logo_db->where('passtime >=',$data['time']);
		$this->logo_db->where_in('cltx_place',$data['place']);
		$data['clppflag'] =='all' ? $this->logo_db->where('clppflag >=', 0) : $this->logo_db->where('clppflag',$data['clppflag']);
		$data['dire'] == 0 ? $data['dire'] = 0 : $this->logo_db->where_in('cltx_dire',$data['dire']);
		
		$this->logo_db->join('ppdm as m','i.ppdm = m.code');
		$this->logo_db->join('places as p','i.cltx_place = p.id','left');
		$this->logo_db->join('cllx as c','i.cllx = c.code','left');
		$this->logo_db->join('platecolor as s','i.cltx_color = s.id','left');
		$this->logo_db->join('directions as d','i.cltx_dire = d.id','left');
		$this->logo_db->join('csys as y','i.csys = y.code','left');
		$this->logo_db->order_by('i.id','desc'); 
		
		return $this->logo_db->get('carinfo as i',$limit,$offset);
	}
	
}
?>
