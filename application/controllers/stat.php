<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 统计分析控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Stat extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		
		$this->load->library('Lib_kakou');
		
		//$this->load->Model('Mstat');
		//$this->output->enable_profiler(TRUE);
	}
	
	function test()
	{
		$this->load->view('stat/test');
	}
	
	function carsum()
	{
		$data['st'] = mdate("%Y-%m-%d 00:00:00");
		$data['et'] = mdate("%Y-%m-%d 23:59:59");

		$this->load->view('stat/carsum',$data);
	}
	
	function wzsum()
	{
		$data['st'] = mdate("%Y-%m-%d 00:00:00");
		$data['et'] = mdate("%Y-%m-%d 23:59:59");

		$this->load->view('stat/wzsum',$data);
	}
	
	function bjsum()
	{
		$data['st'] = mdate("%Y-%m-%d 00:00:00");
		$data['et'] = mdate("%Y-%m-%d 23:59:59");

		$this->load->view('stat/bjsum',$data);
	}
	
	function stat_data()
	{
		$data['place'] = $this->input->post('place') ? $this->input->post('place') : 'all';
		$data['dire']  = $this->input->post('dire') ? $this->input->post('dire') : '';
		$data['st']    = $this->input->post('st');
		$data['et']    = $this->input->post('et');
		$data['cartype']   = $this->input->post('carsize') ? $this->input->post('carsize') : '';
		$data['breakrule'] = $this->input->post('breakrule') ? $this->input->post('breakrule') : '';
		$data['alarmtype'] = $this->input->post('alarmtype') ? $this->input->post('alarmtype') : '';
		$data['dispose']   = $this->input->post('dispose') ? $this->input->post('dispose') : '';
		
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		$stat = array();
		if($data['place'] == 'all'){
			foreach ($openkakou as $id=>$kakou)
	        {
	        	$stat['title'][$id] = $kakou->TYPE_ALIAS;
	            $stat['data'][$id]  = (double)$this->Mstat->get_carflow_by_condition($data)->row()->RCOUNT;
	        }
		}else {
			$stat['title'][0] = $data['place'];
	    	$stat['data'][0] = (double)$this->Mstat->get_carflow_by_condition($data)->row()->RCOUNT;
		}
	
		$result = $this->lib_kakou->icon_to_utf8($data);
		echo json_encode($result);
	}
	
	function load_data()
	{
		$data['title'] = array(
		                    '中华人民共和国广东省惠州市惠城区',
		                    '中华人民共和国广东省惠州市惠城区',
		                    '中华人民共和国广东省惠州市惠城区',
		                    'Apr',
		                    '中华人民共和国广东省惠州市惠城区',
		                    'Jun',
		                    'Jul',
		                    'Aug',
		                    'Sep',
		                    'Oct',
		                    'Nov',
		                    'Dec'
		                );
		$data['data'] = array(49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4);
		
		$result = $this->lib_kakou->icon_to_utf8($data);
		echo json_encode($result);
	}
}

