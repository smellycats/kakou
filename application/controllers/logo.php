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

class Logo extends CI_Controller
{	
	protected $msg1 = '请选择查询条件.';
	
	protected $msg2 = '没有车辆记录！';
	
	protected $imgpath = array();

	
	//protected $imgpath = array('HDWJ-KKDATA1'=>'localhost:8082','HDWJ-KKDATA2'=>'localhost:8082',''=>'192.168.10.234:81');
	
	//protected $path = 'D:\SpreadData/';
	//图片批量下载数量
	//protected $imgs_num = 400;

		
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('news');     //自定义news_helper
		$this->load->helper('kakou');    //自定义kakou_helper
		
		$this->load->library('DX_Auth');
		$this->load->library('form_validation');
		$this->load->library('Lib_kakou');
		#$this->load->library('MY_Session');

		#$this->load->model('Mgate');
		#$this->load->model('Msyst');
		$this->load->model('Mlogo');
		$this->load->model('Msms');
		$this->load->model('Mbasedata');
		
		$this->load->config('basedata');
		//$this->load->config('kakou');
		
		//$this->output->enable_profiler(TRUE);
						
		if (substr($this->session->userdata('ip_address'),0,3)=='192')
		{
			$this->imgpath = array(0=>'192.168.10.234:8888',1=>'192.168.10.235:8888',''=>'192.168.10.234:8888');
		}else {
			$this->imgpath = array(0=>'10.44.249.227:81',1=>'10.44.249.227:82',''=>'10.44.249.227:81');
		}
	}
	
	//品牌查询
	function lgquery()
	{
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort'] = $this->input->post('sort') ? $this->input->post('sort') : 'i.id';
	    $data['order'] = $this->input->post('order') ? $this->input->post('order') : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];

		$data['number'] = $this->input->post('number') ? $this->input->post('number') : '？'; #‘？’是中文字体
		$data['carnum'] = $this->input->post('carnum') ? $this->input->post('carnum') : '';
		$data['place'] = $this->input->post('place') ? $this->input->post('place') : 'all';
		$data['dire'] = $this->input->post('dire') ? $this->input->post('dire') : 'all';
		$data['hpys'] = $this->input->post('hpys') ? $this->input->post('hpys') : 'all';
		$data['ppdm'] = $this->input->post('ppdm') ? $this->input->post('ppdm') : 'all';
		$data['ppdm2'] = $this->input->post('ppdm2') ? $this->input->post('ppdm2') : 'all';
		$data['cllx'] = $this->input->post('cllx') ? $this->input->post('cllx') : 'all';
		$data['csys'] = $this->input->post('csys') ? $this->input->post('csys') : 'all';
		$data['hpys'] = $this->input->post('hpys') ? $this->input->post('hpys') : 'all';
		$data['st'] = $this->input->post('st') ? $this->input->post('st') : mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));;
		$data['et'] = $this->input->post('et') ? $this->input->post('et') : mdate("%Y-%m-%d %H:%i:%s");
		$data['lane'] = 'all';
		$data['platename'] = h_create_platename($data['number'],$data['carnum']);

		$_SESSION['lgquery'] = $data;

		$data['result'] = $this->Mlogo->get_carinfo3($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array();
		$data['total'] = $this->Mlogo->get_carinfo3(0,0,$data['sort'],$data['order'],$data)->row()->sum;

		$data['title'] = '品牌查询';

		$data['sel_place'] = $this->Mbasedata->get_places()->result_array();
		$data['sel_dire'] = $this->Mbasedata->get_directions()->result_array();
		$data['sel_hpys'] = $this->Mbasedata->get_hpys()->result_array();
		$data['sel_ppdm'] = $this->Mbasedata->get_ppdm()->result_array();
		$data['sel_number'] = $this->config->item('number');

		$this->load->view('logo/lgquery_view', $data);
	}

	//获取子品牌类型
	function get_ppdm2()
	{
		$ppdm = $this->input->get('ppdm', True);

		if ($ppdm == 'all') {
			$result = array(array('all', '请选择主品牌'));
		} else {
			$result = array(array('all', '所有子品牌'));
			$query = $this->Mbasedata->get_clpp2($ppdm);
			#$ppdm_list = array();
			foreach($query->result_array() as $row) {
				array_push($result,array($row['clpp2'], $row['name2']));
			}
		}

		echo json_encode($result);

	}
	
	function lgquery2()
	{
		//var_dump($this->session->all_userdata());
		session_start(); 
		#echo $_SESSION['name'];  
		if(isset($_SESSION["user"])){	
			echo $_SESSION["user"];
		}else {
			echo "session为空";
		}
		if ($this->session->userdata('lgquery')) {
			$data['lgquery'] = $this->session->userdata('lgquery');
		}else {
			$data['lgquery']['page']   = 1;
			$data['lgquery']['rows']   = 10;
			$data['lgquery']['sort']   = 'i.id';
		    $data['lgquery']['order']  = 'desc';
		    $data['lgquery']['offset'] = 0;
			$data['lgquery']['number'] = '?';
			$data['lgquery']['carnum'] = '';
			$data['lgquery']['place']  = 0;
			$data['lgquery']['dire']   = 0;
			$data['lgquery']['lane']   = 0;
			$data['lgquery']['hpys']   = 0;
			$data['lgquery']['ppdm']   = '0';
			$data['lgquery']['cllx']   = '0';
			$data['lgquery']['csys']   = '0';
			$data['lgquery']['st']     = mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
			$data['lgquery']['et']     = mdate("%Y-%m-%d %H:%i:%s");
			
			$this->session->set_userdata('lgquery',$data['lgquery']);
		}
		
		$data['title'] = '车标查询';
		
		$this->load->view('logo/lgquery',$data);
	}
}