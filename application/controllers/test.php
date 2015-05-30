<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Test extends CI_Controller
{
 
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		//$this->output->enable_profiler(TRUE);
		#$this->load->model('Mgate');
		$this->load->helper('date');
		$this->load->helper('kakou');
		#$this->load->model('Msyst');
		#$this->load->model('Muser');

		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		$this->load->library('Lib_kakou');

		session_start();

	//$this->test_db = $this->load->database('test_db', TRUE);
	//$this->ora_db = $this->load->database('oracle_db', TRUE);
	}



//¼�복�ƺ��뵽carlib
function test3()
{	
	$post_data = array(
		'username' => 'stclair2201',
		'password' => 'handan',
	);
	echo h_send_post('http://www.baidu.com/', $post_data);
}


function _get_excel_data()
{
	    $role_id = $this->session->userdata('DX_role_id');
        $data = $this->_get_openkakou_by_perm($role_id);
        
            	if($role_id == '1')
		{
			$da['okkval'] = '';
		}
		elseif ($data['sel_type_alias'] == 'all')
		{
			$da['okkval'] = implode(",",$data['okkval']);
		}else 
		{
			$da['okkval'] = "'" . $data['sel_type_alias'] . "'";
		}    
		
		$da['lane']      = $this->input->get('lane');           //����
		$da['direction'] = $this->input->get('direction');      //����
		$da['color']     = $this->input->get('color');          //��ɫ
        $da['number']    = $this->input->get('number');         //���Ʊ��
        $da['carnum']    = trim($this->input->get('carnum'));   //���ƺ���
        
        if($this->input->get('spcarnum') != '')
        {
        	$spcarnum = explode(",", $this->input->get('spcarnum'));   //���⳵�ƺ�
            foreach ($spcarnum as $id=>$sp)
            {
        	    $da['sp'][$id] = "'" . $sp . "'";
            }
            $da['spcarnum'] = implode(",",$da['sp']);
        }else 
        {
            $da['spcarnum'] = '';
        }
    
        $da['starttime'] = $this->input->get('starttime');   //��ʼʱ��
        $da['endtime'] = $this->input->get('endtime');       //����ʱ��

        return $this->Mgate->get_car_by_condition(0, 1000, $da);
}
   function _get_openkakou_by_perm($role_id)
    {

		$sys['type_name']  = '��������';
		$sys['type_value'] = '';
		    
		$openkakou_all = $this->Msyst->get_config_info($sys)->result();
		
    	foreach ($openkakou_all as $id=>$kakou)
		{
		    $openkakou_all_to_arr[$id] = $kakou->ID;
		}
		
		$data = null;
		
		if($role_id == '1') //�ж��Ƿ����Ա������Ա������·�ڲ���Ȩ��
		{
		    foreach ($openkakou_all as $id=>$kakou)
		    {
		    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    	$data['okkval'][$id] = "'" . $kakou->TYPE_VALUE . "'";
		    }
		}
		else  //�ǹ���Ա�û� Ҫ�ж�Ȩ��
		{
		    $openkakou_str = $this->Muser->get_role_by_id($role_id)->openkakou;
		    
		    //�����л����ַ���ת��������
		    $openkakou_to_arr = explode(',', $openkakou_str);
		    //��Ȩ�޿��ں����п��ڵĽ���
		    $openkakou = array_intersect($openkakou_to_arr,$openkakou_all_to_arr);
		    
		    foreach ($openkakou as $id=>$kakou)
		    {
		    	$data['openkakou'][$id] = $this->Msyst->get_config_info_by_id($kakou)->row()->TYPE_ALIAS;
		    	
		    	$data['okkval'][$id] = "'" . $this->Msyst->get_config_info_by_id($kakou)->row()->TYPE_VALUE . "'";
		    }
		}
		
		return $data;	
    }
    
    function show_img(){
    	header('Content-Type: image/jpeg');
    	$this->lib_kakou->create_wm('http://news.xinhuanet.com/ent/2012-12/08/124065861_11n.jpg','123','������');
    }
    
    
	function show_img2(){
    	header('Content-Type: image/jpeg');
    	$this->lib_kakou->create_wm2('http://news.xinhuanet.com/ent/2012-12/08/124065861_11n.jpg','123','������','127.0.0.1');
		
	}

	function helper_test()
	{
		$data = array('���','ţ��','�Ȼ�');
		echo h_arr_to_str($data);
	}

	function empty_test()
	{
		$arr = array();
		var_dump(empty($arr));
	}

	function place_test()
	{
		$this->load->model('Mbasedata');
		$arr = array('2','13');
		$res = $this->Mbasedata->getPlaces($arr)->result_array();
		var_dump($res);
	}

	function explode_test()
	{
		$str = '1,2,3';
		var_dump(explode(',', $str));
	}

	function show_session()
	{
		var_dump($_SESSION);
	}

	public function requests_test()
	{
		// First, include Requests
		include('requests/library/Requests.php');

		// Next, make sure Requests can load internal classes
		Requests::register_autoloader();

		// Now let's make a request!
		$request = Requests::post('http://httpbin.org/post', array(), array('mydata' => 'something'));

		// Check what we received
		var_dump($request);
	}

}

