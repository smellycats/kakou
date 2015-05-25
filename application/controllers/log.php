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
		$this->load->model('Muser');
		$this->load->model('Muserlog');
				
		$this->load->config('kakou');
		//$this->output->enable_profiler(TRUE);
	}


}