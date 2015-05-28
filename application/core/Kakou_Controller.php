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

		$this->_checkLogin();
		$this->_checkRights();
     }
     
    /**
     * 检查用户是否登录
     *
     * @access private
     * @return void
     */
     private function _checkLogin()
     {
     	//Check if user has logon status of manager, redirect to home page if not
        if(isset($_SESSION['timestamp'])){
     		$time_lags = time() - $_SESSION['timestamp'];
     		if ($time_lags <= 1800) {    //30分钟超时
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
     * @access private
     * @return void
     */
     private function _checkRights()
     {
     	$control  = $this->uri->segment(1);
     	$function = $this->uri->segment(2);
     	
     	$query = $this->Madmin->getMenuByName($function);
     	
     	if($query->num_rows() == 1 AND $_SESSION['role_id'] != 1 AND !in_array($query->row()->id, $_SESSION['role_right'])) {
			show_error('No Right To Access', 500);
		}
     }

    /**
     * 登录超时
     *
     * @access private
     * @return json
     */
    private function _timeout()
    {
        $result['statusCode']   = '301';
        $result['message']      = '会话超时，请重新登录';
        $result['navTabId']     = '';
        $result['callbackType'] = '';
        $result['forwardUrl']   = '';
        
        echo json_encode($result);
        exit;
    }
 }