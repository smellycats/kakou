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

class Syst extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('date');
		//$this->load->helper('news');
		
		//$this->load->library('DX_Auth');
		//$this->load->library('form_validation');
		
		$this->load->model('Mnotice');
				
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		role_man();
	}
	
	function sysset()
	{
		$data['title'] = '卡口地点设置'; 
		
		$this->load->view('syst/sysset',$data);
	}
	
	function notice()
	{
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort'] = $this->input->post('sort') ? strval($this->input->post('sort')) : 'created';
	    $data['order'] = $this->input->post('order') ? strval($this->input->post('order')) : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];

		$data['result'] = $this->Mnotice->get_notices($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array();
		$data['total'] = $this->Mnotice->get_notices(0,0,$data['sort'],$data['order'],$data)->row()->sum;

		$data['title'] = '公告列表';

		$this->load->view('notice/notice_view', $data);
	}
	
	function notice_add_view()
	{	
		$this->load->view('notice/notice_add');
	}
	
	function notice_edit_view()
	{
		$id = $this->input->get('id',True);
		
		$query = $this->Mnotice->get_notice_by_id($id);

		$data = $query->row_array();
		
		$this->load->view('notice/notice_edit', $data);	
	}

	function notice_add()
	{
		$data['content'] = $this->input->post('content', True);
		$data['banned'] = $this->input->post('banned') ? $this->input->post('banned') : 0;

		$data['created'] = mdate("%Y-%m-%d %H:%i:%s");
		$data['modified'] = mdate("%Y-%m-%d %H:%i:%s");

		$result = array();
		if ($this->Mnotice->add_notice($data)) {
			$result["statusCode"] = "200";
			$result["message"] = "公告添加完成！";
            $result["navTabId"] = "notice";
            $result["forwardUrl"] = base_url() . "index.php/syst/notice";
            $result["callbackType"] = "closeCurrent";
		} else {
			$result["statusCode"] = "300";
			$result["message"] = "公告添加失败，请稍后再试！";
		}
		
		echo json_encode($result);
	}
	

	function notice_edit()
	{
		$id = $this->input->post('id',True);

		$data['content'] = $this->input->post('content', True);
		$data['banned'] = $this->input->post('banned') ? $this->input->post('banned') : 0;

		$data['modified'] = mdate("%Y-%m-%d %H:%i:%s");

		$result = array();
		if ($this->Mnotice->edit_notice($id, $data)) {
			$result["statusCode"] = "200";
			$result["message"] = "公告编辑成功！";
            $result["navTabId"] = "notice";
            $result["forwardUrl"] = base_url() . "index.php/syst/notice";
            $result["callbackType"] = "closeCurrent";
		} else {
			$result["statusCode"] = "300";
			$result["message"] = "公告编辑失败，请稍后再试！";
		}
		
		echo json_encode($result);
	}

	function notice_del()
	{		
		$result['success'] = $this->Muser2->edit_user($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','删除卡口成功'): iconv('GBK','UTF-8','操作失败:数据库或未知错误');
		
		echo json_encode($result);
	}
	
}