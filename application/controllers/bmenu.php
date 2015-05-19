<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ���������������
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
	
	//���غ�������ͼ
	function cpbk()
	{
		$data['title'] = '���Ʋ����б�';
		
		$this->load->view('bmenu/b_list',$data);
	}

	//���غ�������ͼ
	function test()
	{
		$data['title'] = '���Ʋ����б�';
		
		$this->load->view('bmenu/test',$data);
	}
}
