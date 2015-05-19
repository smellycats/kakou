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

class Log extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		//$this->load->helper('form');
		$this->load->helper('date');
		//$this->load->helper('news');
		$this->load->library('Lib_kakou');
		//$this->load->library('DX_Auth');
		//$this->load->library('form_validation');
		
		$this->load->model('Mlog2');
				
		$this->load->config('kakou');
		//$this->output->enable_profiler(TRUE);
	}
	
	//用户操作日志列表
	function oplog()
	{
		$data['title'] = '操作日志';
        $data['st'] = mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
        $data['et'] = mdate("%Y-%m-%d %H:%i:%s");

		$this->load->view('log/oplog', $data);
	}
	
	function oplog_data()
	{
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$data['sort'] = $this->input->post('sort') ? strval($this->input->post('sort')) : 'id';
	    $data['order'] = $this->input->post('order') ? strval($this->input->post('order')) : 'desc';
	    $data['offset'] = ($data['page']-1)*$data['rows'];

	    $data['username']  = $this->input->post('username') ? $this->input->post('username'): '';
		$data['starttime'] = $this->input->post('st')  ? $this->input->post('st') : mdate("%Y-%m-%d %H:%i:%s",strtotime("-2 hours"));
		$data['endtime']   = $this->input->post('et')  ? $this->input->post('et') : mdate("%Y-%m-%d %H:%i:%s");
		
		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Mlog2->get_userlog($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array());
		$result['total'] = $this->Mlog2->get_userlog(0,0,$data['sort'],$data['order'],$data)->row()->sum;
		
		$data['total'] = $result["total"];
		
		echo json_encode($result);
	}


}