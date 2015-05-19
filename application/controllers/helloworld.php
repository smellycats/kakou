<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 待销案控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */
      class Helloworld extends CI_Controller {    

          public function __construct() {        

                   parent::__construct();    

                   $this->load->helper('url');

                   $this->load->library('layout',array('main'));//加载layouts下的main文件，可以写其他的布局文件，如$this->load->library('layout',array('hello'));表示加载layouts下的hello布局文件，默认$this->load->library('layout')不传参表示加载默认的布局文件，在layout扩展类的构造方法中已经设置了默认参数main

          }    

           public function test() {        
					
           			$da = '132';
                    $data['test'] = 'ci模拟layout';      
                    $data['west'] = $this->load->view('west', $da, true);  

                    $this->layout->view('content', $data);     

           }

      }

?>
