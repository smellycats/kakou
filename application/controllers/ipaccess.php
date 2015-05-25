<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou IP限制控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Ipaccess extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('date');
		//$this->load->helper('news');
		
		$this->load->model('Mipaccess');
				
		//$this->output->enable_profiler(TRUE);
	}

	
	function view()
	{
		$data['page'] = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows'] = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort'] = $this->input->post('sort') ? $this->input->post('sort') : 'id';
	    $data['order'] = $this->input->post('order') ? $this->input->post('order') : 'asc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];

		$data['result'] = $this->Mipaccess->get_ipaccess($data['offset'],$data['rows'],$data['sort'],$data['order'],$data)->result_array();
		$data['total'] = $this->Mipaccess->get_ipaccess(0,0,$data['sort'],$data['order'],$data)->row()->sum;

		$data['title'] = 'IP限制列表';

		$this->load->view('ipaccess/view', $data);
	}
	
	function add_view()
	{	
		$this->load->view('ipaccess/add');
	}
	
	function edit_view()
	{
		$id = $this->input->get('id',True);
		
		$query = $this->Mipaccess->get_ipaccess_by_id($id);

		$data = $query->row_array();
		
		$this->load->view('ipaccess/edit', $data);	
	}

	function add()
	{
		$data['minip'] = $this->input->post('minip', True);
		$data['maxip'] = $this->input->post('maxip', True);
		$data['banned'] = $this->input->post('banned') ? $this->input->post('banned') : 0;

		$result = array();
		if ($this->Mipaccess->add_ipaccess($data)) {
			$result["statusCode"] = "200";
			$result["message"] = "添加成功！";
            $result["navTabId"] = "ip_access";
            $result["forwardUrl"] = base_url() . "index.php/syst/ip_access";
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

		$data['minip'] = $this->input->post('minip', True);
		$data['maxip'] = $this->input->post('maxip', True);
		$data['banned'] = $this->input->post('banned') ? $this->input->post('banned') : 0;

		$result = array();
		if ($this->Mipaccess->edit_ipaccess($id, $data)) {
			$result["statusCode"] = "200";
			$result["message"] = "编辑成功！";
            $result["navTabId"] = "ip_access";
            $result["forwardUrl"] = base_url() . "index.php/syst/ip_access";
            $result["callbackType"] = "closeCurrent";
		} else {
			$result["statusCode"] = "300";
			$result["message"] = "编辑失败，请稍后再试！";
		}
		
		echo json_encode($result);
	}

	function delete()
	{
		$this->del();
	}

	function remove()
	{
		$this->del();
	}

	function del()
	{		
		$id = $this->input->get('id',True);
		
		$result = array();
		$data['del'] = 1;
		if ($this->Mipaccess->edit_ipaccess($id, $data)) {
			$result['statusCode'] = "200";
			$result['message'] = "删除成功！";
			$result["navTabId"] = "ip_access";
		} else {
			$result['statusCode'] = "300";
			$result['message'] = "删除失败，请稍后再试！"; 
		}

		echo json_encode($result);
	}
	
}