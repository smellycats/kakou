<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Right_Controller extends Admin_Controller {
 
    function __construct()
     {
         parent::__construct();
         
        $this->load->helper('url');
        
		//$this->load->library('DX_Auth');
		$this->load->model('Madmin');
		
		$this->_check_rights();
     }
     
    /**
     * 检查用户权限
     *
     * @access  protected
     * @return  void
     */
     protected function _check_rights()
     {
     	$control = $this->url->segment(2);
     	$function = $this->url->segment(3);
     	
     	$query = $this->madmin->get_menu_by_name($function);
     	$rights = $this->session->userdata('DX_role_right');
     	
     	if($query->num_rows()==1 AND $this->session->userdata('DX_role_id') !=1 AND !inarray($query->row()->id,$rights))
		{
			showmessage('没有访问权限', 'admin/right');
		}
     }
 }