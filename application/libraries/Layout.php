<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout 
{
	public $layout;

    function __construct($params = array('main')) {//����������controller�м���������ʱ��˳������캯����������Ҫ���صĲ����ļ���������ĵ�����$this -> load -> library('**','**')�ĵڶ��������������������ܸ����캯�����Σ�Ҳ����Դ��ַ����ɣ���ʱ����������
        $this->layout = 'layouts' . DIRECTORY_SEPARATOR . $params[0];
    }
    
    function view($view, $data = null, $flag = false) {
         $ci = &get_instance();
         $data['content'] = $ci->load->view($view, $data, true);//����ĵ���������true��������������false�ͻ������Ĭ����false����thinkphp���display��assign���ƣ������õ���������������
        if ($flag) {
             $view = $ci->load->view($this->layout, $data, true);
             return $view;
         } else {
             $ci->load->view($this->layout, $data, false);
         }
     }
 }
 ?>
