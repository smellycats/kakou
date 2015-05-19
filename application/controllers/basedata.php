<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 基础数据控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Basedata extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Lib_kakou');
		
		$this->load->helper('kakou');
		
		$this->load->model('Mbasedata');		
		$this->load->model('Muser2');
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function get_direction()
	{
		#$data = array('进城', '出城', '由东往西', '由南往北', '由西往东', '由北往南');
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'进城',
						"text"=>'进城'),
					array(
						"id"=>'出城',
						"text"=>'出城'),
					array(
						"id"=>'由东往西',
						"text"=>'由东往西'),
					array(
						"id"=>'由南往北',
						"text"=>'由南往北'),
					array(
						"id"=>'由西往东',
						"text"=>'由西往东'),
					array(
						"id"=>'由北往南',
						"text"=>'由北往南'),
					);
		echo json_encode($data);
	}
	
	function get_country()
	{
		#$data = array('进城', '出城', '由东往西', '由南往北', '由西往东', '由北往南');
		$data = array(
					array(
						"id"=>'1',
						"text"=>'中国',
						//"selected"=>True,
						),
					array(
						"id"=>'2',
						"text"=>'美国'
						),

					);
		$data[0]['selected'] = True;
		var_dump($data);
		echo json_encode($data);
	}
	
	//卡口地点
	function get_place_logo()
	{
		$role_id = 4;
		if ($role_id == 1)
		{
			$data = $this->Mbasedata->get_places()->result_array();
		} else {
			$role = $this->Muser2->get_role_by_id($role_id);
			$kakou_array = explode(",", $role->openkakou);
			$data = $this->Mbasedata->get_places_by_perm($kakou_array)->result_array();
		}

		$result = array();
		$result[0] = array('id' => 'all',
					 'text' => '所有',
					);
		
		foreach ($data as $key=>$val){
			$result[$key+1] = array('id' => $data[$key]['id'],
								  'text' => iconv("GBK","UTF-8//IGNORE",$data[$key]['place']),
								 );
		}
		
		$result[0]['selected'] = True;
		
		echo json_encode($result);
	}
	
	//车道
	function get_lane()
	{
		$data = array(
					array(
						"id" => 'all',
						"text" => '所有',
						),
					);
		FOR ($i = 1; $i <= 10; $i++) {
			$data[$i] = array("id"=>$i,"text"=>$i);
		}
		$data[0]['selected'] = True;
		
		echo json_encode($data);
	}
	
	#方向
	function get_dire()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'进城',
						"text"=>'进城'),
					array(
						"id"=>'出城',
						"text"=>'出城'),
					array(
						"id"=>'由东往西',
						"text"=>'由东往西'),
					array(
						"id"=>'由南往北',
						"text"=>'由南往北'),
					array(
						"id"=>'由西往东',
						"text"=>'由西往东'),
					array(
						"id"=>'由北往南',
						"text"=>'由北往南'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	#方向
	function get_dire_logo()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>2,
						"text"=>'进城'),
					array(
						"id"=>3,
						"text"=>'出城'),
					array(
						"id"=>4,
						"text"=>'由东往西'),
					array(
						"id"=>5,
						"text"=>'由南往北'),
					array(
						"id"=>6,
						"text"=>'由西往东'),
					array(
						"id"=>7,
						"text"=>'由北往南'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	#号牌颜色
	function get_hpys()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'蓝牌',
						"text"=>'蓝'),
					array(
						"id"=>'黄牌',
						"text"=>'黄'),
					array(
						"id"=>'白牌',
						"text"=>'白'),
					array(
						"id"=>'黑牌',
						"text"=>'黑'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	#LOGO号牌颜色
	function get_hpys_logo()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>2,
						"text"=>'蓝'),
					array(
						"id"=>3,
						"text"=>'黄'),
					array(
						"id"=>4,
						"text"=>'白'),
					array(
						"id"=>5,
						"text"=>'黑'),
					array(
						"id"=>1,
						"text"=>'其他'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	//车辆标志
	function get_ppdm()
	{
		$data = $this->Mbasedata->get_ppdm()->result_array();

		$result = array();
		$result[0] = array('id' => 'all',
					 'text' => '所有',
					);
		
		foreach ($data as $key=>$val){
			$result[$key+1] = array('id' => $data[$key]['code'],
								  'text' => iconv("GBK","UTF-8//IGNORE",$data[$key]['name']),
								 );
		}
		
		$result[0]['selected'] = True;
		
		echo json_encode($result);
	}
	
	//车辆类型
	function get_cllx_logo()
	{
		$data = $this->Mbasedata->get_cllx()->result_array();

		$result = array();
		$result[0] = array('id' => 'all',
					 	'text' => '所有',
						);
		
		foreach ($data as $key=>$val){
			$result[$key+1] = array('id' => $data[$key]['code'],
								  'text' => $data[$key]['code'].iconv("GBK","UTF-8//IGNORE",$data[$key]['name']),
								 );
		}
		
		$result[0]['selected'] = True;
		
		echo json_encode($result);
	}
	
	//车辆类型
	function get_csys_logo()
	{
		$data = $this->Mbasedata->get_csys()->result_array();

		$result = array();
		$result[0] = array('id' => 'all',
					 	'text' => '所有',
						);
		
		foreach ($data as $key=>$val){
			$result[$key+1] = array('id' => $data[$key]['code'],
								  'text' => iconv("GBK","UTF-8//IGNORE",$data[$key]['name']),
								 );
		}
		
		$result[0]['selected'] = True;
		
		echo json_encode($result);
	}
	
	function get_number()
	{
		$number = array('R','?','-','WJ','闽','粤','苏','浙','沪','京','津','冀','晋','蒙','辽','吉','黑','皖','赣','鲁','豫','鄂','湘','桂','琼','川','贵','云','藏','陕','甘','青','宁','新','台','渝','港','澳','军','海','空','沈','北','兰','济','南','成','广');

		foreach ($number as $key=>$val)
		{
			$data[$key]['id'] = $val;
			$data[$key]['text'] = $val;
		}
		
		$data[1]['selected'] = True;
		echo json_encode($data);
	}
	
	function get_carsize()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'大车',
						"text"=>'大车'),
					array(
						"id"=>'小车',
						"text"=>'小车'),
					array(
						"id"=>'其他',
						"text"=>'其他'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	function get_breakrule()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'超速',
						"text"=>'超速'),
					array(
						"id"=>'逆行',
						"text"=>'逆行'),
					array(
						"id"=>'闯红灯',
						"text"=>'闯红灯'),
					array(
						"id"=>'不按车道行驶',
						"text"=>'不按车道行驶'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	function get_record()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'已核对',
						"text"=>'已核对'),
					array(
						"id"=>'已审核',
						"text"=>'已审核'),
					array(
						"id"=>'已处罚',
						"text"=>'已处罚'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	function get_alarmtype()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'被盗抢车辆',
						"text"=>'被盗抢车辆'),
					array(
						"id"=>'套牌车辆',
						"text"=>'套牌车辆'),
					array(
						"id"=>'便衣嫌疑车辆',
						"text"=>'便衣嫌疑车辆'),
					array(
						"id"=>'布控车辆',
						"text"=>'布控车辆'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	function get_dispose()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'警情未处理',
						"text"=>'警情未处理'),
					array(
						"id"=>'车牌号码识别错误',
						"text"=>'车牌号码识别错误'),
					array(
						"id"=>'车牌颜色识别错误',
						"text"=>'车牌颜色识别错误'),
					array(
						"id"=>'图像不清',
						"text"=>'图像不清'),
					array(
						"id"=>'已下达',
						"text"=>'已下达'),
					array(
						"id"=>'不下达',
						"text"=>'不下达'),
					array(
						"id"=>'未截获',
						"text"=>'未截获'),
					array(
						"id"=>'已截获',
						"text"=>'已截获'),
								array(
						"id"=>'查获被盗抢车',
						"text"=>'查获被盗抢车'),
					array(
						"id"=>'查获套牌车',
						"text"=>'查获套牌车'),
					array(
						"id"=>'查获交通违法车',
						"text"=>'查获交通违法车'),
					array(
						"id"=>'与黑名单数据不符',
						"text"=>'与黑名单数据不符'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	function get_number2()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'R',
						"text"=>'R'),
					array(
						"id"=>'?',
						"text"=>'?'),
					array(
						"id"=>'WJ',
						"text"=>'WJ'),
					array(
						"id"=>'闽',
						"text"=>'闽'),
					array(
						"id"=>'粤',
						"text"=>'粤'),
					array(
						"id"=>'苏',
						"text"=>'苏'),
					array(
						"id"=>'浙',
						"text"=>'浙'),
					array(
						"id"=>'沪',
						"text"=>'沪'),
					array(
						"id"=>'京',
						"text"=>'京'),
					array(
						"id"=>'津',
						"text"=>'津'),
					array(
						"id"=>'冀',
						"text"=>'冀'),
					array(
						"id"=>'晋',
						"text"=>'晋'),
					array(
						"id"=>'蒙',
						"text"=>'蒙'),
					array(
						"id"=>'辽',
						"text"=>'辽'),
					array(
						"id"=>'吉',
						"text"=>'吉'),
					array(
						"id"=>'黑',
						"text"=>'黑'),
					array(
						"id"=>'粤',
						"text"=>'粤'),
					array(
						"id"=>'粤',
						"text"=>'粤'),
					array(
						"id"=>'粤',
						"text"=>'粤'),
					array(
						"id"=>'粤',
						"text"=>'粤'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	#角色
	function get_role()
	{
		$roles = $this->Muser2->get_roles_data()->result_array();

		$data = $this->lib_kakou->icon_to_utf8($roles);
		$data[0]['selected'] = True;
		
		echo json_encode($data);
	}
	
	#树形角色
	function tree_place_logo()
	{
		$roles = $this->Muser2->get_roles_data()->result_array();

		$data = $this->lib_kakou->icon_to_utf8($roles);
		$data[0]['selected'] = True;
		
		echo json_encode($data);
	}
	
	function _tree_fmt($tree,$state=False)
	{
		$data = array();
		foreach($tree as $key=>$val)
		{
			$data[$key]['id'] = $val['id'];
			$data[$key]['text'] = iconv('GBK','UTF-8',$val['cname']);
			if ($state == False){
				$data[$key]['state'] = 'closed';
			}else{
				$data[$key]['iconCls'] = 'icon-tool';
			}
		}
		return $data;
	}
	
	#树形菜单
	function tree_menu()
	{
		$menu = $this->Mbasedata->get_menu(0)->result_array();

		$data = $this->_tree_fmt($menu);
		foreach($data as $key=>$val)
		{
			$query = $this->Mbasedata->get_menu($val['id']);
			if ($query->num_rows()>=1){
				$data[$key]['children'] = $this->_tree_fmt($query->result_array(),True);
			}
		}
		
		echo json_encode($data);
	}
	
	#树形卡口地点
	function tree_place()
	{
		$data = array(
					0 => array('id'=>'001','text'=>'惠城区卡口')
					);
		$data2 = array(
					0 => array('id'=>1,'text'=>'淡水海关卡口','iconCls' => 'icon-place'),
					1 => array('id'=>2,'text'=>'新圩塘吓卡口','iconCls' => 'icon-place')
					);
		#$data = icon_to_utf8($place);
		
		$data[0]['children'] = $data2;
		
		echo json_encode($data);
	}
	
	//获取车标车辆信息
	function get_carinfo_logo()
	{
		$this->load->model('Mlogo');
		
		$id = $this->input->get('id',True);
		$data = $this->Mlogo->get_all_carinfo_by_id($id)->row_array();
		$group = '车辆信息';
		$rows = array( 
					   0 => array(
								'name'  => '卡口地点',
								'value' => iconv('GBK','UTF-8//IGNORE',$data['place_name']),
								'group' => $group
								),
					   1 => array(
								'name'  => '车牌号码',
								'value' => iconv('GBK','UTF-8//IGNORE',$data['cltx_hphm']),
								'group' => $group,
								),
					   2 => array(
								'name' => '经过时间',
								'value' => iconv('GBK','UTF-8//IGNORE',$data['passtime']),
					   			'group' => $group
					   			),
					   3 => array(
								'name' => '方向',
								'value' => iconv('GBK','UTF-8//IGNORE',$data['dire_name']),
					   			'group' => $group
					   			),
					   4 => array(
								'name'  => '车牌颜色',
								'value' => iconv('GBK','UTF-8//IGNORE',$data['color_name']),
								'group' => $group
								),
					   5 => array(
								'name' => '车道',
								'value' => $data['cltx_lane'],
					   			'group' => $group
					   			),
					   6 => array(
								'name' => '车辆标志',
								'value' => iconv('GBK','UTF-8//IGNORE',$data['clpp_name']),
					   			'group' => $group
					   			),
					   7 => array(
								'name' => '品牌类型',
								'value' => iconv('GBK','UTF-8//IGNORE',$data['clpp']),
					   			'group' => $group
					   			),
					   8 => array(
								'name'  => '车辆类型',
								'value' => iconv('GBK','UTF-8//IGNORE',$data['cllx'].$data['cllx_name']),
								'group' => $group
								),
					   9 => array(
								'name' => '车身颜色',
								'value' => iconv('GBK','UTF-8//IGNORE',$data['csys_name']),
					   			'group' => $group
					   			),
						);
		$result['tatal'] = count($rows);
		$result['rows'] = $rows;
		
		echo json_encode($result);
	}
	
	function get_cgs()
	{
		$this->load->model('Mcgs');
		
		#$get['hphm'] = iconv('UTF-8','GBK//IGNORE',$this->input->get('hphm'));
		$get['hphm'] = $this->input->get('hphm');
		#var_dump($get['hphm']);
		$query = $this->Mcgs->get_vehicle_gd_by_hphm($get);

		$group = '车管所信息';
		if ($query->num_rows == 0) {
			$rows = array( 
						   0 => array(
									'name'  => '车辆信息',
									'value' => '无',
									'group' => $group
									)
							);
		}else {
			$data = $query->row_array();
			$rows = array( 
						   0 => array(
									'name'  => '车辆品牌',
									'value' => iconv('GBK','UTF-8//IGNORE',$data['clpp1']),
									'group' => $group
									),
						   1 => array(
									'name'  => '详细品牌',
									'value' => iconv('GBK','UTF-8//IGNORE',$data['clpp2']),
									'group' => $group
									),
						   2 => array(
									'name'  => '车辆类型',
									'value' => iconv('GBK','UTF-8//IGNORE',$data['cllx_name']),
									'group' => $group
									),
						   3 => array(
									'name'  => '号牌种类',
									'value' => iconv('GBK','UTF-8//IGNORE',$data['hpzl_name']),
									'group' => $group
									),
						   4 => array(
									'name'  => '车身颜色',
									'value' => iconv('GBK','UTF-8//IGNORE',$data['csys_name']),
									'group' => $group
									),
						   5 => array(
									'name'  => '所有人',
									'value' => iconv('GBK','UTF-8//IGNORE',$data['syr']),
									'group' => $group
									),
								);
		}
		
		$result['tatal'] = count($rows);
		$result['rows'] = $rows;
		
		echo json_encode($result);
	}
	
	/*
	 * 
	 * 黑名单选项
	 */
	//布控原因
	function get_reason1()
	{
		$data = array(
					array(
						"id"=>'请选择',
						"text"=>'请选择'),
					array(
						"id"=>'盗抢车辆',
						"text"=>'盗抢车辆'),
					array(
						"id"=>'肇事逃逸',
						"text"=>'肇事逃逸'),
					array(
						"id"=>'多次违章',
						"text"=>'多次违章'),
					array(
						"id"=>'其他',
						"text"=>'其他'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	function get_reason2()
	{
		$data = array(
					array(
						"id"=>'盗抢车辆',
						"text"=>'盗抢车辆'),
					array(
						"id"=>'肇事逃逸',
						"text"=>'肇事逃逸'),
					array(
						"id"=>'多次违章',
						"text"=>'多次违章'),
					array(
						"id"=>'其他',
						"text"=>'其他'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	//处理状态
	function get_state1()
	{
		$data = array(
					array(
						"id"=>'请选择',
						"text"=>'请选择'),
					array(
						"id"=>'待审核',
						"text"=>'待审核'),
					array(
						"id"=>'已审核',
						"text"=>'已审核'),
					array(
						"id"=>'已撤控',
						"text"=>'已撤控'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	function get_bmenu_number()
	{
		$number = array('?','WJ','闽','粤','苏','浙','沪','京','津','冀','晋','蒙','辽','吉','黑','皖','赣','鲁','豫','鄂','湘','桂','琼','川','贵','云','藏','陕','甘','青','宁','新','台','渝','港','澳','军','海','空','沈','北','兰','济','南','成','广');

		foreach ($number as $key=>$val)
		{
			$data[$key]['id'] = $val;
			$data[$key]['text'] = $val;
		}
		
		$data[1]['selected'] = True;
		echo json_encode($data);
	}
	
	#号牌颜色
	function get_bmenu_hpys()
	{
		$data = array(
					array(
						"id"=>'无',
						"text"=>'无'),
					array(
						"id"=>'蓝牌',
						"text"=>'蓝牌'),
					array(
						"id"=>'黄牌',
						"text"=>'蓝牌'),
					array(
						"id"=>'白牌',
						"text"=>'蓝牌'),
					array(
						"id"=>'黑牌',
						"text"=>'蓝牌'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	//获取确认信息
	function get_confirm_logo()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'0',
						"text"=>'未确认'),
					array(
						"id"=>'1',
						"text"=>'已确认'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	//车辆类型是否匹配
	function get_clppflag_logo()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'0',
						"text"=>'不匹配'),
					array(
						"id"=>'1',
						"text"=>'匹配'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	//发送短信
	function get_smsflag_logo()
	{
		$data = array(
					array(
						"id"=>'all',
						"text"=>'所有'),
					array(
						"id"=>'0',
						"text"=>'未发送'),
					array(
						"id"=>'1',
						"text"=>'已发送'),
					);
					
		$data[0]['selected'] = True;
		echo json_encode($data);
	}
	
	function get_notice()
	{
		$data = $this->Mbasedata->get_notice()->result_array();

		$result = array();
		
		foreach ($data as $key=>$val){
			$result[$key] = array('id' => $data[$key]['id'],
								  'text' => iconv("GBK","UTF-8//IGNORE",$data[$key]['content']),
							);
		}
		
		echo json_encode($result);
	}
	
	function test()
	{
		$this->load->model('Madmin');
		$this->load->helper('url');
		$role_id = 1;
		
	    if($role_id == 1)
		{
			$data['f_datas'] = $this->Madmin->get_menu();
		}
		else
		{
			$data['f_datas'] = $this->Madmin->get_menu_by_prem($role_id);
		}
		$da['west'] = $data;
		
		$this->load->view('layouts/main',$da);
	}
	
	function test2()
	{
		$result = '{"rows":[{"id":469,"passtime":"2015-02-20 05:38:33","hphm":"\u7ca4469","lane":5,"clpp_son":"\u65e0","code":999,"clpp":"\u5176\u4ed6","place":"","hpys":"\u767d\u724c","cllx":"\u5176\u4ed6","dire":"\u51fa\u57ce","csys":"\u5176\u4ed6"},{"id":468,"passtime":"2015-02-20 01:37:39","hphm":"\u7ca4468","lane":5,"clpp_son":"\u4e30\u7530\u82b1\u51a0-1","code":31,"clpp":"\u4e30\u7530","place":"","hpys":"\u767d\u724c","cllx":"\u5c0f\u578b\u8f7f\u8f66","dire":"\u51fa\u57ce","csys":"\u84dd"},{"id":467,"passtime":"2015-02-20 01:37:39","hphm":"\u7ca4467","lane":5,"clpp_son":"\u6bd4\u4e9a\u8feaF3","code":12,"clpp":"\u6bd4\u4e9a\u8fea","place":"\u6de1\u6c34\u6d77\u5173\u5361\u53e3","hpys":"\u767d\u724c","cllx":"\u5c0f\u578b\u8f7f\u8f66","dire":"\u51fa\u57ce","csys":"\u9ed1"},{"id":466,"passtime":"2014-11-10 11:21:38","hphm":"\u7ca4WJV023","lane":5,"clpp_son":"\u660c\u6cb3\u798f\u745e\u8fbe-1","code":19,"clpp":"\u660c\u6cb3","place":"\u6de1\u6c34\u6d77\u5173\u5361\u53e3","hpys":"\u767d\u724c","cllx":"\u5c0f\u578b\u666e\u901a\u5ba2\u8f66","dire":"\u51fa\u57ce","csys":"\u84dd"},{"id":465,"passtime":"2014-10-29 22:26:37","hphm":"\u53f7\u724c\u6d4b\u8bd5","lane":5,"clpp_son":"\u90d1\u5dde\u65e5\u4ea7\u5546\u52a1\u8f66","code":96,"clpp":"\u5c3c\u6851","place":"\u6de1\u6c34\u6d77\u5173\u5361\u53e3","hpys":"\u767d\u724c","cllx":"\u5c0f\u578b\u5ba2\u8f66","dire":"\u51fa\u57ce","csys":"\u9ed1"},{"id":464,"passtime":"2014-10-29 22:26:35","hphm":"\u7ca4WJV023","lane":5,"clpp_son":"\u65e0","code":999,"clpp":"\u5176\u4ed6","place":"\u6de1\u6c34\u6d77\u5173\u5361\u53e3","hpys":"\u767d\u724c","cllx":"\u5176\u4ed6","dire":"\u51fa\u57ce","csys":"\u5176\u4ed6"},{"id":463,"passtime":"2014-10-29 22:26:34","hphm":"\u7ca4WJV023","lane":5,"clpp_son":"\u4e30\u7530\u82b1\u51a0-1","code":31,"clpp":"\u4e30\u7530","place":"\u6de1\u6c34\u6d77\u5173\u5361\u53e3","hpys":"\u767d\u724c","cllx":"\u5c0f\u578b\u8f7f\u8f66","dire":"\u51fa\u57ce","csys":"\u84dd"},{"id":462,"passtime":"2014-10-29 22:26:34","hphm":"\u53f7\u724c\u6d4b\u8bd5","lane":5,"clpp_son":"\u6bd4\u4e9a\u8feaF3","code":12,"clpp":"\u6bd4\u4e9a\u8fea","place":"\u6de1\u6c34\u6d77\u5173\u5361\u53e3","hpys":"\u767d\u724c","cllx":"\u5c0f\u578b\u8f7f\u8f66","dire":"\u51fa\u57ce","csys":"\u9ed1"},{"id":461,"passtime":"2014-10-29 22:26:33","hphm":"\u7ca4WJV023","lane":5,"clpp_son":"\u660c\u6cb3\u798f\u745e\u8fbe-1","code":19,"clpp":"\u660c\u6cb3","place":"\u6de1\u6c34\u6d77\u5173\u5361\u53e3","hpys":"\u767d\u724c","cllx":"\u5c0f\u578b\u666e\u901a\u5ba2\u8f66","dire":"\u51fa\u57ce","csys":"\u84dd"},{"id":460,"passtime":"2014-10-29 22:26:33","hphm":"\u53f7\u724c\u6d4b\u8bd5","lane":5,"clpp_son":"\u90d1\u5dde\u65e5\u4ea7\u5546\u52a1\u8f66","code":96,"clpp":"\u5c3c\u6851","place":"\u6de1\u6c34\u6d77\u5173\u5361\u53e3","hpys":"\u767d\u724c","cllx":"\u5c0f\u578b\u5ba2\u8f66","dire":"\u51fa\u57ce","csys":"\u9ed1"}],"total":"458"}';
		echo $result;
	}
	
	function get_clpp2()
	{
		$clpp = $this->input->get('clpp');
		
		$data = $this->Mbasedata->get_clpp2($clpp)->result_array();
		$result = array(array('all','所有子品牌'));
		foreach ($data as $row){
			array_push($result,array($row['clpp2'],$row['name2']));
		}
		/*
		$data = array(
						array('01','品牌1'),
						array('02','品牌2')
						); */
		
		echo json_encode($result);
	}
	
}

