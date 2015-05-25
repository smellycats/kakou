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

class Userlog extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('date');

		$this->load->model('Muser');
		$this->load->model('Muserlog');
				
		$this->load->config('kakou');
		//$this->output->enable_profiler(TRUE);
	}
	
	//用户日志列表
	function view()
	{
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort'] = $this->input->post('sort') ? strval($this->input->post('sort')) : 'access_count';
	    $data['order'] = $this->input->post('order') ? strval($this->input->post('order')) : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];
		
	    $data['username'] = $this->input->post('username') ? $this->input->post('username') : '';
	    $data['department'] = '';

		$data['result'] = $this->Muser->getUsers($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array();
		$data['total'] = $this->Muser->getUsers(0,0,$data['sort'],$data['order'],$data)->row()->sum;

		$data['title'] = '用户列表';

		$this->load->view('userlog/userlog_view', $data);
	}


}