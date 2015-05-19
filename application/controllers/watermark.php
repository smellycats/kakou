<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou Êä³ö¿ØÖÆÆ÷
 * 
 * @package     Watermark
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Watermark extends CI_Controller
{
		
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('kakou');
        
		#$this->load->model('Mgate');
		
		$this->load->library('Lib_kakou');
		
		#$this->load->config('kakou');
	}
	
    function wm_img()
    {	
     	header('Content-Type: image/jpeg');
     	$id = $this->input->get('id',True);
		#$car_info = $this->Mgate->get_car_by_id($id)->row();
		#$img_url  = get_picurl( $this->config->item('kakou_img_base_url'), $car_info->QMTP, $car_info->TJTP);
		$img_url = 'http://localhost/imgareaselect/imgs/1.jpg';
		
     	$this->lib_kakou->create_wm2($img_url,'1234','ËÀ·Ê×Ğ');
    }
    
    
}