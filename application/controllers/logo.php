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

class Logo extends Admin_Controller
{
	private $imgpath = array();
		
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('news');     //自定义news_helper
		$this->load->helper('kakou');    //自定义kakou_helper
		
		$this->load->library('Lib_kakou');

		$this->load->model('Mlogo');
		$this->load->model('Mbasedata');
		
		$this->load->config('basedata');
		//$this->load->config('kakou');
		
		//$this->output->enable_profiler(TRUE);
						
		if (substr($this->session->userdata('ip_address'),0,3)=='192') {
			$this->imgpath = array(0=>'192.168.10.234:8888',1=>'192.168.10.235:8888',''=>'192.168.10.234:8888');
		} else {
			$this->imgpath = array(0=>'10.44.249.227:81',1=>'10.44.249.227:82',''=>'10.44.249.227:81');
		}
	}
	
    /**
     * 品牌查询
     * 
     * @return void
     */
	function lgquery()
	{
		$data['page']   = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows']   = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort']   = $this->input->post('sort') ? $this->input->post('sort') : 'i.id';
	    $data['order']  = $this->input->post('order') ? $this->input->post('order') : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];

		$data['number'] = $this->input->post('number') ? $this->input->post('number') : '？'; // '？'是中文字体
		$data['carnum'] = $this->input->post('carnum') ? $this->input->post('carnum') : '';
		$data['place']  = $this->input->post('place') ? $this->input->post('place') : 'all';
		$data['dire']   = $this->input->post('dire') ? $this->input->post('dire') : 'all';
		$data['hpys']   = $this->input->post('hpys') ? $this->input->post('hpys') : 'all';
		$data['ppdm']   = $this->input->post('ppdm') ? $this->input->post('ppdm') : 'all';
		$data['ppdm2']  = $this->input->post('ppdm2') ? $this->input->post('ppdm2') : 'all';
		$data['cllx']   = $this->input->post('cllx') ? $this->input->post('cllx') : 'all';
		$data['csys']   = $this->input->post('csys') ? $this->input->post('csys') : 'all';
		$data['hpys']   = $this->input->post('hpys') ? $this->input->post('hpys') : 'all';
		$data['st']     = $this->input->post('st') ? $this->input->post('st') : mdate("%Y-%m-%d %H:%i:%s", strtotime("-2 hours"));;
		$data['et']     = $this->input->post('et') ? $this->input->post('et') : mdate("%Y-%m-%d %H:%i:%s");
		$data['lane']   = 'all';
		$data['platename'] = h_create_platename($data['number'], $data['carnum']);

		$_SESSION['lgquery'] = $data;

		$data['result'] = $this->Mlogo->get_carinfo3($data['offset'], $data['rows'], $data['sort'], $data['order'], $data)->result_array();
		$data['total']  = $this->Mlogo->get_carinfo3(0, 0, $data['sort'], $data['order'], $data)->row()->sum;

		$data['title'] = '品牌查询';

		$data['sel_place']  = $this->Mbasedata->get_places()->result_array();
		$data['sel_dire']   = $this->Mbasedata->get_directions()->result_array();
		$data['sel_hpys']   = $this->Mbasedata->get_hpys()->result_array();
		$data['sel_ppdm']   = $this->Mbasedata->get_ppdm()->result_array();
		$data['sel_cllx']   = $this->Mbasedata->get_cllx()->result_array();
		$data['sel_number'] = $this->config->item('number');

		$this->load->view('logo/lgquery_view', $data);
	}

    /**
     * 品牌查询
     * 
     * @return void
     */
	function lgquery_detail()
	{
		$this->load->view('logo/lgquery_detail');
	}


	//比对查询
	function cmpquery()
	{
		$data['page']   = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows']   = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort']   = $this->input->post('sort') ? $this->input->post('sort') : 'i.id';
	    $data['order']  = $this->input->post('order') ? $this->input->post('order') : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];

		$data['number']   = $this->input->post('number') ? $this->input->post('number') : '？'; #‘？’是中文字体
		$data['carnum']   = $this->input->post('carnum') ? $this->input->post('carnum') : '';
		$data['place']    = $this->input->post('place') ? $this->input->post('place') : 'all';
		$data['dire']     = $this->input->post('dire') ? $this->input->post('dire') : 'all';
		$data['ppdm']     = $this->input->post('ppdm') ? $this->input->post('ppdm') : 'all';
		$data['ppdm2']    = $this->input->post('ppdm2') ? $this->input->post('ppdm2') : 'all';
		$data['confirm']  = $this->input->post(NULL) ? $this->input->post('confirm') : 'all';
		$data['clppflag'] = $this->input->post(NULL) ? $this->input->post('clppflag') : 'all';
		$data['smsflag']  = $this->input->post(NULL) ?  $this->input->post('smsflag') : 'all';
		$data['st']       = $this->input->post('st') ? $this->input->post('st') : mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));;
		$data['et']       = $this->input->post('et') ? $this->input->post('et') : mdate("%Y-%m-%d %H:%i:%s");
		$data['lane']     = 'all';
		$data['platename']= h_create_platename($data['number'],$data['carnum']);

		$_SESSION['cmpquery'] = $data;

		$data['result'] = $this->Mlogo->get_confirm_carinfo3($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array();
		$data['total'] = $this->Mlogo->get_confirm_carinfo3(0,0,$data['sort'],$data['order'],$data)->row()->sum;

		$data['title'] = '匹配查询';

		$data['sel_place'] = $this->Mbasedata->get_places()->result_array();
		$data['sel_dire'] = $this->Mbasedata->get_directions()->result_array();
		$data['sel_ppdm'] = $this->Mbasedata->get_ppdm()->result_array();
		$data['sel_number'] = $this->config->item('number');

		$this->load->view('logo/cmpquery_view', $data);
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
	
    /**
     * 实时信息查询
     * 
     * @return void
     */
	public function realSelectView()
	{
		$place_array = $_SESSION['role_id'] == 1 ? array() : $_SESSION['role_openkk'];
		$data['sel_places'] = $this->Mbasedata->getPlaces($place_array)->result_array();

		$data['title'] = '实时信息';

		$this->load->view('logo/real_select_view', $data);
	}

	public function select()
	{
		var_dump($this->input->post(NULL));
	}

}