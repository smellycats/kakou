<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou Í¼Æ¬Éú³É¿ØÖÆÆ÷
 * 
 * @package     Watermark
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Img extends CI_Controller
{
		
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('kakou');
		#$this->load->model('Mgate');
		
		$this->load->library('Lib_kakou');
		
		$this->load->config('kakou');
	}
	
    function show_img()
    {	
     	header('Content-Type: image/jpeg');
     	$id = $this->input->get('id',True);
		#$car_info = $this->Mgate->get_car_by_id($id)->row();
		#$img_url  = get_picurl( $this->config->item('kakou_img_base_url'), $car_info->QMTP, $car_info->TJTP);
		$img_url = 'http://localhost/imgareaselect/imgs/' . $id .'.jpg';
		$this->config->item('wm_open') ? $this->lib_kakou->create_wm2($img_url,'1234','ËÀ·Ê×Ð') : $this->lib_kakou->create_img($img_url);
     	#$this->lib_kakou->create_wm2($img_url,'1234','ËÀ·Ê×Ð');
    }
    
    function show_sl()
    {
		/*
		File: thumbs.php
		Example: <img src="thumbs.php?filename=photo.jpg&amp;width=100&amp;height=100">
		*/
		 
		$id = $this->input->get('id',True);
		//$width = $this->input->get('id',True);
		//$height = $this->input->get('height',True);
		$width = 400;
		$height = 300;

		$img_url = 'http://localhost/imgareaselect/imgs/' . $id .'.jpg';
			 
		// Content type
		header('Content-type: image/jpeg');
		
		$this->lib_kakou->img_resize($img_url,$height);
    }
    
}