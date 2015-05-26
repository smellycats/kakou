<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {
 
    function __construct()
     {
         parent::__construct();
         
        $this->load->helper('url');
        $this->load->helper('kakou');
        
		$this->load->library('Lib_kakou');
		
		$this->load->model('Madmin');
		
		//$this->output->enable_profiler(TRUE);
		session_start();

        //$this->_timeout();
		//$this->_check_login();
		//$this->_check_rights();
		
     }
     
    /**
     * 检查用户是否登录
     *
     * @access  protected
     * @return  void
     */
     protected function _check_login()
     {
     	//Check if user has logon status of manager, redirect to home page if not
        if(isset($_SESSION['timestamp'])){
     		$time_lags = time() - $_SESSION['timestamp'];
     		if ($time_lags <= 1800){    //半小时
     			$_SESSION['timestamp'] = time();
     		} else {
     			$this->_timeout();
     		}
     	} else{
     		$this->_timeout();
     	}
     }
    /**
     * 检查用户权限
     *
     * @access  protected
     * @return  void
     */
     protected function _check_rights()
     {
     	$control = $this->uri->segment(1);
     	$function = $this->uri->segment(2);
     	
     	$query = $this->Madmin->get_menu_by_name($function);
     	$rights = $this->session->userdata('DX_role_right');
     	
     	if($query->num_rows()==1 AND $this->session->userdata('DX_role_id')!=1 AND !in_array($query->row()->id,$rights))
		{
			show_error('No Right to Access',500);
		}
     }

    function _timeout()
    {
        $result["statusCode"] = "301";
        $result["message"] = "会话超时，请重新登录";
        $result["navTabId"] = "";
        $result["callbackType"] = "";
        $result["forwardUrl"] = "";
        
        echo json_encode($result);
        exit;
    }
 }