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

class Sms extends Admin_Controller
{	

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('kakou');    //自定义kakou_helper

		$this->load->model('Msms');
		
		#$this->load->config('basedata');
		//$this->load->config('kakou');
		
		//$this->output->enable_profiler(TRUE);
	}

    /**
     * 短信设置视图
     * 
     * @return void
     */
	function view()
	{
		$data['page']   = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$data['rows']   = $this->input->post('rows') ? intval($this->input->post('rows')) : 20;
		$data['sort']   = $this->input->post('sort') ? $this->input->post('sort') : 'i.id';
	    $data['order']  = $this->input->post('order') ? $this->input->post('order') : 'desc';
		$data['offset'] = ($data['page'] - 1) * $data['rows'];

		$data['result'] = $this->Msms->getSms($data['offset'], $data['rows'], $data['sort'], $data['order'], $data)->result_array();
		$data['total']  = $this->Msms->getSms(0, 0, $data['sort'], $data['order'], $data)->row()->sum;

		$data['title'] = '短信编辑';

		$this->load->view('sms/view', $data);
	}

    /**
     * 短信添加dialog
     * 
     * @return void
     */
	function addView()
	{
		$this->load->view('sms/add');
	}

    /**
     * 短信编辑dialog
     * 
     * @return void
     */
	function editView()
	{
		$id = $this->input->get('id', True);
		
		$data = $this->Msms->getSmsById($id)->row_array();

		$this->load->view('sms/edit', $data);
	}


    /**
     * 添加短信
     * 
     * @return void
     */
	function add() 
	{
		$data['tel']  = str_replace('，', ',', $this->input->post('tel', True));
		$data['mark'] = $this->input->post('mark', True);
		
		$result = array();
		if ($this->Msms->addSms($data)) {
			$result['statusCode']   = '200';
			$result['message']      = '短信添加完成！';
            $result['navTabId']     = 'smsnum';
            $result['forwardUrl']   = base_url('index.php/sms/view');
            $result['callbackType'] = 'closeCurrent';
		} else {
			$result['statusCode'] = '300';
			$result['message']    = '短信添加失败，请稍后再试！';
		}
		
		echo json_encode($result);
	}
	
    /**
     * 编辑短信
     * 
     * @return void
     */
	function edit() 
	{	
		$id = $this->input->post('id',True);
		
		$data['tel']  = str_replace('，', ',', $this->input->post('tel', True));
		$data['mark'] = $this->input->post('mark', True);
		
		$result = array();
		if ($this->Msms->setSms($id, $data)) {
			$result['statusCode']   = '200';
			$result['message']      = '短信编辑成功！';
            $result['navTabId']     = 'smsnum';
            $result['forwardUrl']   = base_url('index.php/sms/view');
            $result['callbackType'] = 'closeCurrent';
		} else {
			$result['statusCode'] = '300';
			$result['message']    = '短信编辑失败，请稍后再试！';
		}
		
		echo json_encode($result);
	}
	
    /**
     * 删除短信
     * 
     * @return void
     */
	function del()
	{
		$id = $this->input->get('id', True);
		
		$result = array();
		$data['banned'] = 1;
		if ($this->Msms->setSms($id, $data)) {
			$result['statusCode'] = '200';
			$result['message']    = '短信删除成功！';
			$result['navTabId']   = 'smsnum';
		} else {
			$result['statusCode'] = '300';
			$result['message']    = '短信删除失败，请稍后再试！'; 
		}

		echo json_encode($result);
	}

}