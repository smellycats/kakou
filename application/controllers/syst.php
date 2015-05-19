<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ϵͳ���ÿ�����
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Syst extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		//$this->load->helper('form');
		//$this->load->helper('news');
		
		//$this->load->library('DX_Auth');
		//$this->load->library('form_validation');
		
		$this->load->model('Msyst2');
				
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		role_man();
	}
	
	function sysset()
	{
		$data['title'] = '���ڵص�����';
		
		$this->load->view('syst/sysset',$data);
	}
	
	function config_data()
	{
		
	}
	
	function config_add()
	{
		$data['name']  = $this->input->post('name',True);
		$data['alias']  = $this->input->post('alias',True);
		$data['kk_type']  = sha1($this->input->post('kk_type',True));
	}
	
	function config_edit()
	{
		$id = $this->input->get('id',True);
		
		$data['name']  = $this->input->post('name',True);
		$data['alias']  = $this->input->post('alias',True);
		$data['kk_type']  = sha1($this->input->post('kk_type',True));	
	}
	
	function config_del()
	{		
		$result['success'] = $this->Muser2->edit_user($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','ɾ�����ڳɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
	
	function ip_access()
	{
		$data['title'] = 'IP��ַ����';
		
		$this->load->view('syst/ip_access',$data);
	}
	
	function ip_data()
	{
		$page = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$rows = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$sort = $this->input->post('sort') ? strval($this->input->post('sort')) : 'id';
	    $order = $this->input->post('order') ? strval($this->input->post('order')) : 'asc';
	    $offset = ($page-1)*$rows;

		$result['rows']  = $this->Msyst2->get_ip_access2($offset,$rows,$data=array())->result_array();
		$result['total'] = $this->Msyst2->get_ip_access2(0,0,$data=array())->row()->sum;
		
		echo json_encode($result);
	}
	
	function ip_add()
	{
		$data['minip']  = $this->input->post('minip',True);
		$data['maxip']  = $this->input->post('maxip',True);
		$data['banned'] = $this->input->post('banned',True);
		
		$result['success'] = $this->Msyst2->add_ip_access2($data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','���IP���óɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
	
	function ip_edit()
	{
		$id = $this->input->get('id',True);
		
		$data['minip']  = $this->input->post('minip',True);
		$data['maxip']  = $this->input->post('maxip',True);
		$data['banned']   = $this->input->post('banned') ? $this->input->post('banned',True) : 0;
	
		$result['success'] = $this->Msyst2->edit_ip_access2($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','�༭IP�ɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
	
	function ip_del()
	{
		$id = $this->input->post('id',True);
		$data['del'] = 1;
		$result['success'] = $this->Msyst2->edit_ip_access2($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','ɾ��IP�ɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
	
	function notice()
	{
		$data['title'] = '��������';
		
		$this->load->view('syst/notice',$data);
	}
	
	function notice_data()
	{
		$page = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$rows = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$sort = $this->input->post('sort') ? strval($this->input->post('sort')) : 'id';
	    $order = $this->input->post('order') ? strval($this->input->post('order')) : 'asc';
	    $offset = ($page-1)*$rows;

		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Msyst2->get_notice($offset,$rows,$data=array())->result_array());
		$result['total'] = $this->Msyst2->get_notice(0,0,$data=array())->row()->sum;
		
		echo json_encode($result);
	}
	
	function notice_add()
	{
		$data['created']  = mdate("%Y-%m-%d %H:%i:%s");
		$data['modified'] = $data['created'];
		$data['content']  = $this->input->post('content',True);
		$data['banned']   = $this->input->post('banned') ? $this->input->post('banned',True) : 0;
		
		$result['success'] = $this->Msyst2->add_notice($data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','��ӹ���ɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
	
	function notice_edit()
	{
		$id = $this->input->get('id',True);
		
		$data['modified'] = mdate("%Y-%m-%d %H:%i:%s");
		$data['content']  = $this->input->post('content',True);
		$data['banned']   = $this->input->post('banned') ? $this->input->post('banned',True) : 0;
	
		$result['success'] = $this->Msyst2->edit_notice($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','�༭����ɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
	
	function notice_del()
	{
		$id = $this->input->post('id',True);
		$data['del'] = 1;
		$result['success'] = $this->Msyst2->edit_notice($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','ɾ������ɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
	
	function alarm_point()
	{
		$data['title'] = '����������';
		
		$this->load->view('syst/alarm_point',$data);
	}
	
	function alarm_point_data()
	{
		$page = $this->input->post('page') ? intval($this->input->post('page')) : 1;
		$rows = $this->input->post('rows') ? intval($this->input->post('rows')) : 10;
		$sort = $this->input->post('sort') ? strval($this->input->post('sort')) : 'id';
	    $order = $this->input->post('order') ? strval($this->input->post('order')) : 'asc';
	    $offset = ($page-1)*$rows;

		$result['rows']  = $this->lib_kakou->icon_to_utf8($this->Msyst2->get_notice($offset,$rows,$data=array())->result_array());
		$result['total'] = $this->Msyst2->get_notice(0,0,$data=array())->row()->sum;
		
		echo json_encode($result);
	}
	
	function alarm_point_add()
	{
		$data['created']  = mdate("%Y-%m-%d %H:%i:%s");
		$data['modified'] = $data['created'];
		$data['content']  = $this->input->post('content',True);
		$data['banned']   = $this->input->post('banned') ? $this->input->post('banned',True) : 0;
		
		$result['success'] = $this->Msyst2->add_notice($data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','��ӹ���ɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
	
	function alarm_point_edit()
	{
		$id = $this->input->get('id',True);
		
		$data['modified'] = mdate("%Y-%m-%d %H:%i:%s");
		$data['content']  = $this->input->post('content',True);
		$data['banned']   = $this->input->post('banned') ? $this->input->post('banned',True) : 0;
	
		$result['success'] = $this->Msyst2->edit_notice($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','�༭����ɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
	
	function alarm_point_del()
	{
		$id = $this->input->post('id',True);
		$data['del'] = 1;
		$result['success'] = $this->Msyst2->edit_notice($id,$data);
		$result['msg']     = $result['success'] ? iconv('GBK','UTF-8','ɾ������ɹ�'): iconv('GBK','UTF-8','����ʧ��:���ݿ��δ֪����');
		
		echo json_encode($result);
	}
}