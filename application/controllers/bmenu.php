<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 黑名单管理控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Bmenu extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		//$this->load->helper('form');
		//$this->load->helper('news');
        $this->load->helper('date');
        
		//$this->load->library('DX_Auth');
		//$this->load->library('session');
		//$this->load->library('form_validation');
		
		//$this->load->model('Mbmenu');
		
        $this->load->config('kakou');
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		cpbk();
	}
	
	//加载黑名单视图
	function cpbk()
	{
		$data['title'] = '车牌布控列表';
		
		$this->load->view('bmenu/b_list',$data);
	}

	//加载黑名单视图
	function test()
	{
		$data['title'] = '车牌布控列表';
		
		$this->load->view('bmenu/test',$data);
	}
}
