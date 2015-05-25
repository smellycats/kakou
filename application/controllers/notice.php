<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 公告管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Notice extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('date');
		//$this->load->helper('news');
		
		$this->load->model('Mnotice');
				
		//$this->output->enable_profiler(TRUE);
	}
	
	function view()
	{
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort'] = $this->input->post('sort') ? $this->input->post('sort') : 'created';
	    $data['order'] = $this->input->post('order') ? $this->input->post('order') : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];

		$data['result'] = $this->Mnotice->get_notices($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array();
		$data['total'] = $this->Mnotice->get_notices(0,0,$data['sort'],$data['order'],$data)->row()->sum;

		$data['title'] = '公告列表';

		$this->load->view('notice/view', $data);
	}
	
	function add_view()
	{	
		$this->load->view('notice/add');
	}
	
	function edit_view()
	{
		$id = $this->input->get('id',True);
		
		$query = $this->Mnotice->get_notice_by_id($id);

		$data = $query->row_array();
		
		$this->load->view('notice/edit', $data);	
	}

	function add()
	{
		$data['content'] = $this->input->post('content', True);
		$data['banned'] = $this->input->post('banned') ? $this->input->post('banned') : 0;

		$data['created'] = mdate("%Y-%m-%d %H:%i:%s");
		$data['modified'] = mdate("%Y-%m-%d %H:%i:%s");

		$result = array();
		if ($this->Mnotice->add_notice($data)) {
			$result["statusCode"] = "200";
			$result["message"] = "添加成功！";
            $result["navTabId"] = "notice";
            $result["forwardUrl"] = base_url() . "index.php/notice/view";
            $result["callbackType"] = "closeCurrent";
		} else {
			$result["statusCode"] = "300";
			$result["message"] = "添加失败，请稍后再试！";
		}
		
		echo json_encode($result);
	}
	

	function edit()
	{
		$id = $this->input->post('id',True);

		$data['content'] = $this->input->post('content', True);
		$data['banned'] = $this->input->post('banned') ? $this->input->post('banned') : 0;

		$data['modified'] = mdate("%Y-%m-%d %H:%i:%s");

		$result = array();
		if ($this->Mnotice->edit_notice($id, $data)) {
			$result["statusCode"] = "200";
			$result["message"] = "编辑成功！";
            $result["navTabId"] = "notice";
            $result["forwardUrl"] = base_url() . "index.php/notice/view";
            $result["callbackType"] = "closeCurrent";
		} else {
			$result["statusCode"] = "300";
			$result["message"] = "编辑失败，请稍后再试！";
		}
		
		echo json_encode($result);
	}

	function del()
	{
		$id = $this->input->get('id',True);

		$result = array();
		$data['del'] = 1;
		if ($this->Mnotice->edit_notice($id, $data)) {
			$result['statusCode'] = "200";
			$result['message'] = "删除成功！";
			$result["navTabId"] = "notice";
		} else {
			$result['statusCode'] = "300";
			$result['message'] = "删除失败，请稍后再试！"; 
		}

		echo json_encode($result);
	}
	
}