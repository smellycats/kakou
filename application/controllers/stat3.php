<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ͳ�Ʒ���������
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
		$this->load->helper('date');

		$this->load->config('basedata');		
		//$this->load->Model('Mstat');
		//$this->output->enable_profiler(TRUE);
	}
	
	function carsumView()
	{
		$data['st']    = mdate('%Y-%m-%d 00:00:00');
		$data['et']    = mdate('%Y-%m-%d 23:59:59');
		$data['place'] = 'all';
		$data['fxbh']  = 'all';
		$data['hpys']  = 'all';

		$data['sel_place'] = array('�ݶ�','����');
		$data['sel_fxbh']  = $this->config->item('fxbh');
		$data['sel_hpys']  = $this->config->item('hpys');

		$this->load->view('stat/carsum',$data);
	}
	
	function wzsumView()
	{
		$data['st'] = mdate("%Y-%m-%d 00:00:00");
		$data['et'] = mdate("%Y-%m-%d 23:59:59");

		$this->load->view('stat/wzsum',$data);
	}
	
	function bjsumView()
	{
		$data['st'] = mdate("%Y-%m-%d 00:00:00");
		$data['et'] = mdate("%Y-%m-%d 23:59:59");

		$this->load->view('stat/bjsum',$data);
	}
	
	function loadData()
	{
		$data['st']    = $this->input->post('st', True);
		$data['et']    = $this->input->post('et', True);
		$data['place'] = $this->input->post('place') ? $this->input->post('place', True) : 'all';
		$data['fxbh']  = $this->input->post('fxbh') ? $this->input->post('fxbh', True) : 'all';
		$data['hpys']  = $this->input->post('hpys') ? $this->input->post('hpys', True) : '';
		$data['breakrule'] = $this->input->post('breakrule') ? $this->input->post('breakrule', True) : '';
		$data['alarmtype'] = $this->input->post('alarmtype') ? $this->input->post('alarmtype', True) : '';
		$data['dispose']   = $this->input->post('dispose') ? $this->input->post('dispose', True) : '';
		
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		$stat = array();
		if($data['place'] == 'all'){
			foreach ($openkakou as $id=>$kakou) {
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
	
	function test()
	{
		$data['title'] = array(
		                    '�л����񹲺͹��㶫ʡ�����лݳ���',
		                    '�л����񹲺͹��㶫ʡ�����лݳ���',
		                    '�л����񹲺͹��㶫ʡ�����лݳ���',
		                    'Apr',
		                    '�л����񹲺͹��㶫ʡ�����лݳ���',
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
