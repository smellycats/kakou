<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 系统设置控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Oplog extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('date');

		$this->load->model('Muserlog');
				
		$this->load->config('kakou');
		//$this->output->enable_profiler(TRUE);
	}
	
	//操作日志列表
	function view()
	{
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort'] = $this->input->post('sort') ? $this->input->post('sort') : 'czsj';
	    $data['order'] = $this->input->post('order') ? $this->input->post('order') : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];
		
		$data['st'] = $this->input->post('st') ? $this->input->post('st') : mdate('%Y-%m-%d %H:%i:%s',strtotime('-24 hours'));;
		$data['et'] = $this->input->post('et') ? $this->input->post('et') : mdate('%Y-%m-%d %H:%i:%s');
	    $data['uname'] = $this->input->post('uname') ? $this->input->post('uname') : '';

		$data['result'] = $this->Muserlog->get_userlogs($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array();
		$data['total'] = $this->Muserlog->get_userlogs(0,0,$data['sort'],$data['order'],$data)->row()->sum;

		$data['title'] = '操作日志列表';

		$this->load->view('userlog/oplog_view', $data);
	}


}