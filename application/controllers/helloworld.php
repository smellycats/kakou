<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ������������
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

                   $this->load->library('layout',array('main'));//����layouts�µ�main�ļ�������д�����Ĳ����ļ�����$this->load->library('layout',array('hello'));��ʾ����layouts�µ�hello�����ļ���Ĭ��$this->load->library('layout')�����α�ʾ����Ĭ�ϵĲ����ļ�����layout��չ��Ĺ��췽�����Ѿ�������Ĭ�ϲ���main

          }    

           public function test() {        
					
           			$da = '132';
                    $data['test'] = 'ciģ��layout';      
                    $data['west'] = $this->load->view('west', $da, true);  

                    $this->layout->view('content', $data);     

           }

      }

?>
