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

class Log extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('news');
		
		$this->load->library('DX_Auth');
		$this->load->library('form_validation');
		
		$this->load->model('Mlog');
				
		//$this->output->enable_profiler(TRUE);
	}
	
	
	//获取用户日志信息
	function userlog()
	{
		$data['users_info'] = $this->Mlog->get_users_info()->result();

		$this->load->view('log/userlog', $data);
	}
	
	//用户操作日志列表
	function oplog()
	{
		$this->load->library('pagination');

		$da = '';
		$pastdate = strtotime("-2 hours");
		$data['username'] = '';
        $data['starttime'] = mdate("%Y-%m-%d %H:%i:%s",$pastdate);
        $data['endtime'] = mdate("%Y-%m-%d %H:%i:%s");
		
		// Get offset and limit for page viewing
		$offset = (int) $this->uri->segment(3);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['userlog'] = $this->Mlog->get_userlog($offset, $row_count, $da)->result();
		$data['offset'] = $offset;
		
		$config['base_url'] = site_url('log/oplog/');
		$config['total_rows'] = $this->Mlog->get_userlog(0, 0, $da);
		$config['per_page'] = $row_count;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('log/oplog', $data);
	}
	
	function search_oplog()
	{
		$this->load->library('pagination');
		
		$data['username']  = $this->input->get('username');
        $data['starttime'] = $this->input->get('starttime');
        $data['endtime']   = $this->input->get('endtime'); 
		
        $per_page = $this->input->get('per_page');      //页面偏移量
		// Get offset and limit for page viewing
		$offset = ($per_page == '' ? '0' : $per_page);
		// Number of record showing per page
		$row_count = 20;
		// Get all users
		$data['userlog'] = $this->Mlog->get_userlog($offset, $row_count, $data)->result();
		$data['offset'] = $offset;
		
		$config['base_url'] = site_url() . "/log/search_oplog/?username=$data[username]&starttime=$data[starttime]&endtime=$data[endtime]";
		$config['total_rows'] = $this->Mlog->get_userlog(0, 0, $data);
		$config['per_page'] = $row_count;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment']='per_page';
		//$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '第一页';
		$config['last_link'] = '尾页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';

		$this->pagination->initialize($config);

		$this->load->view('log/oplog', $data);
	}
	
	function del_oplog()
	{
		$data['username']  = $this->input->get('username');
        $data['starttime'] = $this->input->get('starttime');
        $data['endtime']   = $this->input->get('endtime'); 
        
        $res = $this->Mlog->del_userlog($data);
        
		if ($res)
		{
			showmessage('删除用户操作日志成功', 'log/oplog');
		}
		else
		{
			showmessage('操作失败，系统繁忙或着填写错误', 'log/oplog');
		}
	}

}