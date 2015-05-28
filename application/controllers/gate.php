<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 治安卡口管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Gate extends Admin_Controller
{
		
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		//$this->load->helper('form');
		$this->load->helper('date');
		//$this->load->helper('news');     //自定义news_helper
		$this->load->helper('kakou');    //自定义kakou_helper
		
		//$this->load->library('DX_Auth');
		//$this->load->library('form_validation');

		$this->load->model('Mgate');
		$this->load->model('Mbasedata2');
		//$this->load->model('Muser');
		
		$this->load->config('kakou');
		$this->load->config('basedata');

	}
	

	

	public function carquery_view()
	{
		$data['page']   = $this->input->post('page') ? intval($this->input->post('page', True)) : 1;
		$data['rows']   = $this->input->post('rows') ? intval($this->input->post('rows', True)) : 20;
		$data['sort']   = $this->input->post('sort') ? $this->input->post('sort', True) : 'jgsj';
	    $data['order']  = $this->input->post('order') ? $this->input->post('order', True) : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];
		
		$data['st']     = $this->input->post('st') ? $this->input->post('st', True) : mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));;
		$data['et']     = $this->input->post('et') ? $this->input->post('et', True) : mdate("%Y-%m-%d %H:%i:%s");
	    $data['place']  = $this->input->post('place') ? $this->input->post('place', True) : 'all';
	    $data['fxbh']   = $this->input->post('fxbh') ? $this->input->post('fxbh', True) : 'all';
		$data['cdbh']   = $this->input->post('cdbh') ? $this->input->post('cdbh', True) : 'all';
		$data['hpys']   = $this->input->post('hpys') ? $this->input->post('hpys', True) : 'all';
	    $data['number'] = $this->input->post('number') ? strtoupper($this->input->post('number'), True) : '？';
	    $data['carnum'] = $this->input->post('carnum') ? $this->input->post('carnum', True) : '';
	    $data['platename'] = h_create_platename($data['number'], $data['carnum']);

		$data['result'] = $this->Mgate->getCltx($data['offset'], $data['rows'], $data['sort'], $data['order'], $data)->result_array();
		$data['total']  = $this->Mgate->getCltx(0, 0, $data['sort'], $data['order'], $data)->row()->SUM;

		$data['title'] = '车辆查询';

		$data['sel_place']  = $this->Mbasedata2->getCfgKakou()->result_array();
		$data['sel_fxbh']   = $this->config->item('fxbh');
		$data['sel_cdbh']   = $this->config->item('cdbh');
		$data['sel_hpys']   = $this->config->item('hpys');
		$data['sel_number'] = $this->config->item('number');

		$this->load->view('gate/carquery_view', $data);
	}
	
	function load_carquery()
	{	
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$data['sort'] = $this->input->post('sort') ? strval($this->input->post('sort')) : 'i.id';
	    $data['order'] = $this->input->post('order') ? strval($this->input->post('order')) : 'desc';
	    $data['offset'] = ($data['page']-1)*$data['rows'];

	    $data['place'] = $this->input->post('place') ? $this->input->post('place'): 0;
		$data['lane']  = $this->input->post('lane')  ? $this->input->post('lane') : 0;
		$data['dire']  = $this->input->post('dire')  ? $this->input->post('dire') : 0;
		$data['hpys']  = $this->input->post('hpys')  ? $this->input->post('hpys') : 0;
		$data['st']    = $this->input->post('st')    ? $this->input->post('st') : mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
		$data['et']    = $this->input->post('et')    ? $this->input->post('et') : mdate("%Y-%m-%d %H:%i:%s");
		$data['number']= $this->input->post('number')? iconv("UTF-8","GBK//IGNORE",$this->input->post('number',True)) : '?';
		$data['carnum']= $this->input->post('carnum')? iconv("UTF-8","GBK//IGNORE",$this->input->post('carnum',True)) : '';
		$data['platename'] = format_carnum($data['number'],$data['carnum']);

		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Mlogo->get_carinfo3($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array());
		$result['total'] = $this->Mlogo->get_carinfo3(0,0,$data['sort'],$data['order'],$data)->row()->sum;
		
		$data['total'] = $result["total"];
		$this->session->set_userdata('carquery',$data);
		
		echo json_encode($result);
	}
	
	function wzquery()
	{
		if ($this->session->userdata('wzquery')) {
			$data['wzquery'] = $this->session->userdata('wzquery');
		}else {
			$data['wzquery']['number'] = '?';
			$data['wzquery']['carnum'] = '';
			$data['wzquery']['place']  = 0;
			$data['wzquery']['dire']   = 0;
			$data['wzquery']['lane']   = 0;
			$data['wzquery']['hpys']   = 0;
			$data['wzquery']['st']     = mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
			$data['wzquery']['et']     = mdate("%Y-%m-%d %H:%i:%s");
			
			$this->session->set_userdata('wzquery',$data['wzquery']);
		}
		
		$data['title'] = '违章查询';
		
		$this->load->view('gate/wzquery',$data);
	}
	
	function load_wzquery()
	{	
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$data['sort'] = $this->input->post('sort') ? strval($this->input->post('sort')) : 'i.id';
	    $data['order'] = $this->input->post('order') ? strval($this->input->post('order')) : 'desc';
	    $data['offset'] = ($data['page']-1)*$data['rows'];

	    $data['place'] = $this->input->post('place') ? $this->input->post('place'): 0;
		$data['lane']  = $this->input->post('lane')  ? $this->input->post('lane') : 0;
		$data['dire']  = $this->input->post('dire')  ? $this->input->post('dire') : 0;
		$data['hpys']  = $this->input->post('hpys')  ? $this->input->post('hpys') : 0;
		$data['st']    = $this->input->post('st')    ? $this->input->post('st') : mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
		$data['et']    = $this->input->post('et')    ? $this->input->post('et') : mdate("%Y-%m-%d %H:%i:%s");
		$data['number']= $this->input->post('number')? iconv("UTF-8","GBK//IGNORE",$this->input->post('number',True)) : '?';
		$data['carnum']= $this->input->post('carnum')? iconv("UTF-8","GBK//IGNORE",$this->input->post('carnum',True)) : '';
		$data['platename'] = format_carnum($data['number'],$data['carnum']);

		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Mlogo->get_carinfo3($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array());
		$result['total'] = $this->Mlogo->get_carinfo3(0,0,$data['sort'],$data['order'],$data)->row()->sum;
		
		$data['total'] = $result["total"];
		$this->session->set_userdata('wzquery',$data);
		
		echo json_encode($result);
	}
	
	function bjquery()
	{
		if ($this->session->userdata('bjquery')) {
			$data['bjquery'] = $this->session->userdata('bjquery');
		}else {
			$data['bjquery']['number'] = '?';
			$data['bjquery']['carnum'] = '';
			$data['bjquery']['place']  = 0;
			$data['bjquery']['dire']   = 0;
			$data['bjquery']['lane']   = 0;
			$data['bjquery']['hpys']   = 0;
			$data['bjquery']['st']     = mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
			$data['bjquery']['et']     = mdate("%Y-%m-%d %H:%i:%s");
			
			$this->session->set_userdata('bjquery',$data['bjquery']);
		}
		
		$data['title'] = '报警查询';
		
		$this->load->view('gate/bjquery',$data);
	}
	
	function load_bjquery()
	{	
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$data['sort'] = $this->input->post('sort') ? strval($this->input->post('sort')) : 'i.id';
	    $data['order'] = $this->input->post('order') ? strval($this->input->post('order')) : 'desc';
	    $data['offset'] = ($data['page']-1)*$data['rows'];

	    $data['place'] = $this->input->post('place') ? $this->input->post('place'): 0;
		$data['lane']  = $this->input->post('lane')  ? $this->input->post('lane') : 0;
		$data['dire']  = $this->input->post('dire')  ? $this->input->post('dire') : 0;
		$data['hpys']  = $this->input->post('hpys')  ? $this->input->post('hpys') : 0;
		$data['st']    = $this->input->post('st')    ? $this->input->post('st') : mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
		$data['et']    = $this->input->post('et')    ? $this->input->post('et') : mdate("%Y-%m-%d %H:%i:%s");
		$data['number']= $this->input->post('number')? iconv("UTF-8","GBK//IGNORE",$this->input->post('number',True)) : '?';
		$data['carnum']= $this->input->post('carnum')? iconv("UTF-8","GBK//IGNORE",$this->input->post('carnum',True)) : '';
		$data['platename'] = format_carnum($data['number'],$data['carnum']);

		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Mlogo->get_carinfo3($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array());
		$result['total'] = $this->Mlogo->get_carinfo3(0,0,$data['sort'],$data['order'],$data)->row()->sum;
		
		$data['total'] = $result["total"];
		$this->session->set_userdata('bjquery',$data);
		
		echo json_encode($result);
	}
	
	function test1()
	{
		$data['test'] = '这个是测试';
		$this->load->view('gate/test1', $data);
	}
	
	function get_clpp2()
	{
		$data = array('品牌1','品牌2');
	}
	
	function test2()
	{
		$this->load->model('Muser');
		
		$data = $this->Muser->get_role_by_id(10);
		$da = iconv("UTF-8","GBK",$data->name);
		var_dump($da);
	}
	
	function test3()
	{
		$data['sel_place'] = $this->Mbasedata2->getCfgKakou()->result_array();
		echo json_encode($data['sel_place']);
	}
	
}