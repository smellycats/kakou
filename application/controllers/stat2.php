<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ͳ�Ʒ���������
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Stat extends Admin_Controller
{
	//����
	protected $direction = array('����', '����', '�ɶ�����', '��������', '��������', '�ɱ�����');
	//ͼ������
	protected $viewtype = array('��״ͼ', 'Բ��ͼ');
	//Υ������
	protected $breakrule = array('����','����','�����','����������ʻ');
	//
	protected $alarmtype = array('����������','���Ƴ���','�������ɳ���','���س���');
	
	protected $dispose = array('����δ����','���ƺ���ʶ�����','������ɫʶ�����','ͼ����','���´�','���´�','δ�ػ�','�ѽػ�','��񱻵�����','������Ƴ�','���ͨΥ����','����������ݲ���');
	
	protected $cartype = array('��', 'С��' ,'����');
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('news');
		$this->load->helper('date');
		
		$this->load->library('DX_Auth');
		$this->load->library('form_validation');
		
		$this->load->model('Mstat');
		$this->load->model('Msyst');
				
		//$this->output->enable_profiler(TRUE);
	}
	
	//���س���ͳ����ͼ
	function carsum()
	{
		$this->load->model('Msyst');
		
		$sys['type_name']  = '��������';
		$sys['type_value'] = '';
		//���·�ڲ�����Ϣ 
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		
		foreach ($openkakou as $id=>$kakou)
	    {
	    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	    	$data['okkval'][$id] = $kakou->TYPE_VALUE;
		}
		$data['cartype']   = $this->cartype;
        $data['viewtype']  = $this->viewtype;
        $data['direction'] = $this->direction;
        
		$data['sel_type_alias'] = 'all';
		$data['sel_direction'] = 'all';
		
		$pastdate = strtotime("-1 day");
		$data['sel_starttime'] = mdate("%Y-%m-%d %H:%i:%s",$pastdate);
        $data['sel_endtime']   = mdate("%Y-%m-%d %H:%i:%s");
        $data['sel_cartype']   = 'all';
		$data['sel_viewtype']  = '��״ͼ';
		$data['sel_direction'] = 'all';
		
		$data['sel_graph'] = '';
		
		$data['total'] = 0;
		$data['name'] = "'��'";
		$data['rotation'] = -1;
		$data['align'] = "'right'";
		$data['count'] = 0;
		$data['display'] = 'none';
		
		$this->load->view('stat/carsum', $data);
	}
	
	function carsum_search()
	{
		$this->form_validation->set_rules('type_alias', '���ƺ���', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		if($this->form_validation->run() == false)
		{
			redirect('stat/carsum');
		}
		else
		{
			$da = $this->input->post(NULL,True);
			
		    $data['sel_starttime'] = $da['starttime'];
            $data['sel_endtime'] = $da['endtime'];			
            $data['sel_cartype'] = $da['cartype'];
		    $data['sel_viewtype'] = $da['viewtype'];	
		    $data['sel_type_alias'] = $da['type_alias'];
	    	$data['sel_direction'] = $da['direction'];
	    	
	    	if($da['viewtype'] == '��״ͼ')
	    	{
	    		$data['sel_graph'] = base_url() . "index.php/stat/jp1";
	    	}else 
	    	{
	    		$data['sel_graph'] = base_url() . "index.php/stat/jp2";
	    	}
	    	
	    	$this->load->model('Msyst');
	  		$sys['type_name']  = '��������';
		    $sys['type_value'] = '';
		    
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
			foreach ($openkakou as $id=>$kakou)
	        {
	    	    $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	    	    $data['okkval'][$id] = $kakou->TYPE_VALUE;
		    }
		    
	    	//���·�ڲ�����Ϣ 
	    	if($da['type_alias'] == 'all')
	    	{
	     	
	    	    foreach ($openkakou as $id=>$kakou)
	            {
	            	$da['openkakou'] = $kakou->TYPE_ALIAS;
	            	$jp_data['openkakou'][$id] = $da['openkakou'];
	            	$jp_data['count'][$id] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
	        	}
	    	}
	    	else
	    	{
	    		$da['openkakou'] =  $this->input->post('type_alias');
	    		$jp_data['openkakou'][0] = $this->input->post('type_alias');
	    		$jp_data['count'][0] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
	    	}
	    	
	    	$data['cartype'] = array('��', 'С��' ,'����');
            $data['viewtype'] = $this->viewtype;
            $data['direction'] = $this->direction;
            
			$data['datay'] = $jp_data['count'];
			$data['name']  = $jp_data['openkakou'];
			$data['total'] = 0.0;
			
			foreach($jp_data['count'] as $count)
			{
				$data['total'] += $count;
			}	
		
		   	if($da['viewtype'] == '��״ͼ')
	    	{
	    		$this->load->view('stat/jp1', $data);
	    	}
	    	else 
	    	{
	    		$this->load->view('stat/jp2', $data);
	    	}
	    	//$this->load->view('stat/carsum', $data);
		}
			
	}
	
	function carsum_search2()
	{
		$da = $this->input->post(NULL,True);
			
	    $data['sel_starttime'] = $da['starttime'];
        $data['sel_endtime'] = $da['endtime'];			
        $data['sel_cartype'] = $da['cartype'];
		$data['sel_viewtype'] = $da['viewtype'];	
		$data['sel_type_alias'] = $da['type_alias'];
	    $data['sel_direction'] = $da['direction'];
	    
	    $data['rotation'] = 0;
	    $data['align'] = "'center'";
	    
	    $this->load->model('Msyst');
	    	
	  	$sys['type_name']  = '��������';
		$sys['type_value'] = '';
		    
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		    
	    foreach ($openkakou as $id=>$kakou)
	    {
	    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	    	$data['okkval'][$id] = $kakou->TYPE_VALUE;
		}
		$da['alarmtype'] = '';
		$da['breakrule'] = '';
		$da['dispose'] = '';
		    
    	//���·�ڲ�����Ϣ 
    	if($da['type_alias'] == 'all')
    	{
    	    foreach ($openkakou as $id=>$kakou)
            {
            	$da['okkval'] = $kakou->TYPE_VALUE;
            	$jp_data['openkakou'][$id] = "'".$kakou->TYPE_ALIAS."'";
            	$jp_data['count'][$id] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
        	}
        	$data['rotation'] = -45;
        	$data['align'] = "'right'";
    	}
    	else
    	{
    		$da['okkval'] =  $this->input->post('type_alias');
    		$jp_data['openkakou'][0] = "'".$this->Mstat->get_alias_by_bh($this->input->post('type_alias'))->row()->TYPE_ALIAS."'";
    		$jp_data['count'][0] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
    	}
    	
    	$data['cartype'] = $this->cartype;
        $data['viewtype'] = $this->viewtype;
        $data['direction'] = $this->direction;

		$data['total'] = 0.0;
		$data['total'] = array_sum($jp_data['count']);
		
		$data['display'] = 'block';
		//$data['total'] = array_sum($jp_data['count']);
		if($da['viewtype'] == '��״ͼ')
		{
			$data['count'] = implode(',',$jp_data['count']);
			$data['name']  = implode(',',$jp_data['openkakou']);
			$this->load->view('stat/carsum', $data);
		}
		else {
			$data['pie'] = implode(',',$this->_return_per_data($jp_data['openkakou'],$jp_data['count'],$data['total']));
			//$data['name']  = $jp_data['openkakou'];
    		$this->load->view('stat/carsum_pie', $data);
		}
			
	}
	
	function _return_per_data($name,$count,$total)
	{
		//$a = array(1,2,3,3);
		//$total = array_sum($count);
		foreach($count as $id=>$item)
		{
			$per[$id] = $item == 0?0.0:round($item*100/$total,1);
		}
		if($d = (100 - array_sum($per)))
		{
			$per[array_search(max($per),$per)] += $d;
		}
		foreach($per as $id=>$p)
		{
			$pie[$id] = "[".$name[$id].",".strval($p)."]";
		}
		
		return $pie;
	}

	//����ͳ�Ʋ�ѯ
	//����ʹ��
/*	function carsum_search3()
	{
		//$this->load->library('jpgraph/Graph');
        //$this->load->library('jpgraph/BarPlot');	
        
		$this->form_validation->set_rules('type_alias', '���ƺ���', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		if($this->form_validation->run() == false)
		{
			redirect('stat/carsum');
		}
		else
		{
			$da = $this->input->post(NULL,True);
			
		    $data['sel_starttime'] = $da['starttime'];
            $data['sel_endtime'] = $da['endtime'];			
            $data['sel_cartype'] = $da['cartype'];
		    $data['sel_viewtype'] = $da['viewtype'];	
		    $data['sel_type_alias'] = $da['type_alias'];
	    	$data['sel_direction'] = $da['direction'];
	    	
	    	$data['sel_graph'] = '1';
	    
	    	
	    	$data['cartype'] = array('��', 'С��' ,'����');
            $data['viewtype'] = $this->viewtype;
            $data['direction'] = $this->direction;
            
	    	$this->load->model('Msyst');
	    	
	  		$sys['type_name']  = '��������';
		    $sys['type_value'] = '';
		    
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
			foreach ($openkakou as $id=>$kakou)
	        {
	    	    $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    }
	    	
	    	$this->load->view('stat/carsum', $data);
		}
			
	}*/
	
	//����Υ��ͳ����ͼ
	function wzsum()
	{
		$this->load->model('Msyst');
		
		$sys['type_name']  = '��������';
		$sys['type_value'] = '';
		//���·�ڲ�����Ϣ 
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		
		foreach ($openkakou as $id=>$kakou)
	    {
	    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	    	$data['okkval'][$id] = $kakou->TYPE_VALUE;
		}
		$data['cartype'] = $this->cartype;
        $data['viewtype'] = $this->viewtype;
        $data['direction'] = $this->direction;
        $data['breakrule'] = $this->breakrule;
        
		$data['sel_type_alias'] = 'all';
		$data['sel_direction'] = 'all';
		
		$pastdate = strtotime("-1 day");
		$data['sel_starttime'] = mdate("%Y-%m-%d %H:%i:%s",$pastdate);
        $data['sel_endtime'] = mdate("%Y-%m-%d %H:%i:%s");
        $data['sel_cartype'] = 'all';
		$data['sel_viewtype'] = '��״ͼ';
		$data['sel_direction'] = 'all';
		$data['sel_breakrule'] = 'all';
		$data['sel_graph'] = '';
		
		$data['total'] = 0;
		$data['name'] = "'��'";
		$data['rotation'] = -1;
		$data['align'] = "'right'";
		$data['count'] = 0;
		$data['display'] = 'none';
			
		$this->load->view('stat/wzsum', $data);
	}
	
	//Υ��ͳ�Ʋ�ѯ
	function wzsum_search()
	{
		$this->form_validation->set_rules('type_alias', '���ƺ���', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		if($this->form_validation->run() == false)
		{
			redirect('stat/wzsum');
		}
		else
		{
			$da = $this->input->post(NULL,True);
			
		    $data['sel_starttime'] = $da['starttime'];
            $data['sel_endtime']   = $da['endtime'];			
            $data['sel_cartype']   = $da['cartype'];
		    $data['sel_viewtype']  = $da['viewtype'];	
		    $data['sel_type_alias'] = $da['type_alias'];
	    	$data['sel_direction'] = $da['direction'];
	    	$data['sel_breakrule'] = $da['breakrule'];
	    	
	    	$this->load->model('Msyst');
	  		$sys['type_name']  = '��������';
		    $sys['type_value'] = '';
		    
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
			foreach ($openkakou as $id=>$kakou)
	        {
	    	    $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    }
	    	
	    	$data['cartype'] = $this->cartype;
            $data['viewtype'] = $this->viewtype;
            $data['direction'] = $this->direction;
            
            $data['sel_graph'] = '1';
            
            $this->load->view('stat/wzsum', $data);
		}
			
	}
	
	//Υ��ͳ�Ʋ�ѯ
	function wzsum_search2()
	{
			$da = $this->input->post(NULL,True);
			
		    $data['sel_starttime']  = $da['starttime'];
            $data['sel_endtime']    = $da['endtime'];			
            $data['sel_cartype']    = $da['cartype'];
		    $data['sel_viewtype']   = $da['viewtype'];	
		    $data['sel_type_alias'] = $da['type_alias'];
	    	$data['sel_direction']  = $da['direction'];
	    	$data['sel_breakrule']  = $da['breakrule'];
	    	
	    	$da['alarmtype'] = '';
			//$da['breakrule'] = '';
			$da['dispose'] = '';

	     	$data['rotation'] = 0;
	    	$data['align'] = "'center'";
	    	
	  		$sys['type_name']  = '��������';
		    $sys['type_value'] = '';
		    
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
			foreach ($openkakou as $id=>$kakou)
	        {
	    	    $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	    	    $data['okkval'][$id] = $kakou->TYPE_VALUE;
		    }

	    	//���·�ڲ�����Ϣ 
    	if($da['type_alias'] == 'all')
    	{
    	    foreach ($openkakou as $id=>$kakou)
            {
            	$da['okkval'] = $kakou->TYPE_VALUE;
            	$jp_data['openkakou'][$id] = "'".$kakou->TYPE_ALIAS."'";
            	$jp_data['count'][$id] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
        	}
        	$data['rotation'] = -45;
        	$data['align'] = "'right'";
    	}
    	else
    	{
    		$da['okkval'] =  $this->input->post('type_alias');
    		$jp_data['openkakou'][0] = "'".$this->Mstat->get_alias_by_bh($this->input->post('type_alias'))->row()->TYPE_ALIAS."'";
    		$jp_data['count'][0] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
    	}
    	
    	$data['cartype'] = $this->cartype;
        $data['viewtype'] = $this->viewtype;
        $data['direction'] = $this->direction;
        $data['breakrule'] = $this->breakrule;
            
        //$data['sel_graph'] = '1';
            
		$data['total'] = 0.0;
		$data['total'] = array_sum($jp_data['count']);
		$data['display'] = 'block';
		
		if($da['viewtype'] == '��״ͼ')
		{
			$data['count'] = implode(',',$jp_data['count']);
			$data['name']  = implode(',',$jp_data['openkakou']);
			$this->load->view('stat/wzsum', $data);
		}
		else {
			$data['pie'] = implode(',',$this->_return_per_data($jp_data['openkakou'],$jp_data['count'],$data['total']));
			//$data['name']  = $jp_data['openkakou'];
    		$this->load->view('stat/wzsum_pie', $data);
		}
			
	}

	//���ر���������ͼ
	function bjsum()
	{
		$this->load->model('Msyst');
		
		$sys['type_name']  = '��������';
		$sys['type_value'] = '';
		//���·�ڲ�����Ϣ 
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		
		foreach ($openkakou as $id=>$kakou)
	    {
	    	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	    	$data['okkval'][$id] = $kakou->TYPE_VALUE;
		}
		$data['cartype']   = $this->cartype;
        $data['viewtype']  = $this->viewtype;
        $data['alarmtype'] = $this->alarmtype;
        $data['dispose']   = $this->dispose;
        
		$data['sel_type_alias'] = 'all';
		$data['sel_direction'] = 'all';
		
		$pastdate = strtotime("-1 day");
		$data['sel_starttime'] = mdate("%Y-%m-%d %H:%i:%s",$pastdate);
        $data['sel_endtime'] = mdate("%Y-%m-%d %H:%i:%s");
        $data['sel_cartype'] = 'all';
		$data['sel_viewtype'] = '��״ͼ';
		$data['sel_direction'] = 'all';
		$data['sel_breakrule'] = 'all';
		$data['sel_graph'] = '';
		$data['sel_alarmtype'] = 'all';
		$data['sel_dispose'] = 'all';

		$data['total'] = 0;
		$data['name'] = "'��'";
		$data['rotation'] = -1;
		$data['align'] = "'right'";
		$data['count'] = 0;
		$data['display'] = 'none';
		
		$this->load->view('stat/bjsum', $data);
	}

	//����ͳ�Ʋ�ѯ
	function bjsum_search()
	{
		$this->form_validation->set_rules('type_alias', '���ƺ���', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_message('required', '%s����Ϊ��.');
		$this->form_validation->set_error_delimiters('<span>', '</span>');
		
		if($this->form_validation->run() == false)
		{
			redirect('stat/bjsum');
		}
		else
		{
			$da = $this->input->post(NULL,True);
			
		    $data['sel_starttime'] = $da['starttime'];
            $data['sel_endtime'] = $da['endtime'];			
            $data['sel_cartype'] = $da['cartype'];
		    $data['sel_viewtype'] = $da['viewtype'];	
		    $data['sel_type_alias'] = $da['type_alias'];
	    	$data['sel_alarmtype'] = $da['alarmtype'];
	    	$data['sel_dispose'] = $da['dispose'];
	    	
	    	$this->load->model('Msyst');
	  		$sys['type_name']  = '��������';
		    $sys['type_value'] = '';
		    
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
			foreach ($openkakou as $id=>$kakou)
	        {
	    	    $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    }
	    	
	    	$data['cartype']   = $this->cartype;
            $data['viewtype']  = $this->viewtype;
            $data['alarmtype'] = $this->alarmtype;
            $data['dispose']   = $this->dispose;
			
            $data['sel_graph'] = '1';
            
            $this->load->view('stat/bjsum', $data);
		}
			
	}
	
	//����ͳ�Ʋ�ѯ
	function bjsum_search2()
	{
		$da = $this->input->post(NULL,True);
			
		$data['sel_starttime']  = $da['starttime'];
        $data['sel_endtime']    = $da['endtime'];			
        $data['sel_cartype']    = $da['cartype'];
		$data['sel_viewtype']   = $da['viewtype'];	
		$data['sel_type_alias'] = $da['type_alias'];
	    $data['sel_alarmtype']  = $da['alarmtype'];
	    $data['sel_dispose']    = $da['dispose'];
	    	
	    $da['direction'] = '';
		$da['breakrule'] = '';
			//$da['dispose'] = '';

	    $data['rotation'] = 0;
	    $data['align'] = "'center'";
	    	
	  	$sys['type_name']  = '��������';
		$sys['type_value'] = '';
		    
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		    
		foreach ($openkakou as $id=>$kakou)
	    {
	   	   	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	   	   	$data['okkval'][$id] = $kakou->TYPE_VALUE;
		}

	    	//���·�ڲ�����Ϣ 
    	if($da['type_alias'] == 'all')
    	{
    	    foreach ($openkakou as $id=>$kakou)
            {
            	$da['okkval'] = $kakou->TYPE_VALUE;
            	$jp_data['openkakou'][$id] = "'".$kakou->TYPE_ALIAS."'";
            	$jp_data['count'][$id] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
        	}
        	$data['rotation'] = -45;
        	$data['align'] = "'right'";
    	}
    	else
    	{
    		$da['okkval'] =  $this->input->post('type_alias');
    		$jp_data['openkakou'][0] = "'".$this->Mstat->get_alias_by_bh($this->input->post('type_alias'))->row()->TYPE_ALIAS."'";
    		$jp_data['count'][0] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
    	}
    	
    	/* $data['cartype'] = $this->cartype;
        $data['viewtype'] = $this->viewtype;
        $data['direction'] = $this->direction;
        $data['breakrule'] = $this->breakrule; */
	    $data['cartype']   = $this->cartype;
        $data['viewtype']  = $this->viewtype;
        $data['alarmtype'] = $this->alarmtype;
        $data['dispose']   = $this->dispose;
            
        //$data['sel_graph'] = '1';
            
		$data['total'] = 0.0;
		$data['total'] = array_sum($jp_data['count']);
		$data['display'] = 'block';
		
		if($da['viewtype'] == '��״ͼ')
		{
			$data['count'] = implode(',',$jp_data['count']);
			$data['name']  = implode(',',$jp_data['openkakou']);
			$this->load->view('stat/bjsum', $data);
		}
		else {
			$data['pie'] = implode(',',$this->_return_per_data($jp_data['openkakou'],$jp_data['count'],$data['total']));
			//$data['name']  = $jp_data['openkakou'];
    		$this->load->view('stat/bjsum_pie', $data);
		}
			
	}
	
	//����ͼƬ
	function create_graph()
	{
		$da = $this->input->get(NULL,True);
			
		$data['sel_starttime'] = $da['starttime'];
        $data['sel_endtime'] = $da['endtime'];
        $data['sel_cartype'] = $da['cartype'];
		$data['sel_viewtype'] = $da['viewtype'];	
		$data['sel_type_alias'] = $da['type_alias'];
	    $data['sel_direction'] = $da['direction'];
	    $data['sel_breakrule'] = $da['breakrule'];
	    $data['sel_alarmtype'] = $da['alarmtype'];
	    $data['sel_dispose'] = $da['dispose'];
	    	
	    $this->load->model('Msyst');
	  	$sys['type_name']  = '��������';
		$sys['type_value'] = '';
		    
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		    
		$data['openkakou'] = array();
		    
		foreach ($openkakou as $id=>$kakou)
	    {
	        $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		}
		    
	    //���·�ڲ�����Ϣ 
    	if($da['type_alias'] == 'all')
    	{
    	    foreach ($openkakou as $id=>$kakou)
            {
            	$da['openkakou'] = $kakou->TYPE_ALIAS;
            	$jp_data['openkakou'][$id] = $da['openkakou'];
            	$jp_data['count'][$id] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
        	}
    	}
    	else
    	{
    		$da['openkakou'] =  $da['type_alias'];
    		$jp_data['openkakou'][0] = $da['type_alias'];
    		$jp_data['count'][0] = (double)$this->Mstat->get_carflow_by_condition($da)->row()->RCOUNT;
    	}
    	
    	$data['cartype'] = $this->cartype;
        $data['viewtype'] = $this->viewtype;
        $data['direction'] = $this->direction;
            
		$data['datay'] = $jp_data['count'];
		$data['name']  = $jp_data['openkakou'];
		$data['total'] = 0.0;
		
		foreach($jp_data['count'] as $count)
		{
			$data['total'] += $count;
		}	

	    if($da['viewtype'] == '��״ͼ')
    	{
    		$data['jpdata'] = $this->jp_bar($data);
    	}
    	else 
    	{
    		$data['jpdata'] = $this->jp_pie($data);
    	}
			
		$this->load->view('stat/create_graph', $data);
	}

	//������״ͼ
	function jp_bar($data)
	{            
		require_once ('jpgraph/jpgraph.php');
		require_once ('jpgraph/jpgraph_bar.php');
        
		$graph = new Graph(780,300,'auto');
		$graph->img->SetMargin(60,30,60,40);
		$graph->SetScale("textint");
		$graph->SetFrame(true,'blue',1);
		$graph->SetColor('lightblue');
		$graph->SetMarginColor('lightblue');
			
		// Add some grace to the top so that the scale doesn't
		// end exactly at the max value. 
		//$graph->yaxis->scale->SetGrace(20);
		
		// Setup X-axis labels
		//$a = $gDateLocale->GetShortMonth();
		//$a = array("����1","����2","����3","����4","����5","����6");
		$graph->xaxis->SetTickLabels($data['name']);
		$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD,10);
		$graph->xaxis->SetColor('darkblue','black');
		
		// Stup "hidden" y-axis by given it the same color
		// as the background
		$graph->yaxis->SetColor('white','darkblue');
		$graph->ygrid->SetColor('white');
		
		// Setup graph title ands fonts
		$title= "�ܼƣ�" . $data['total'] .  "��";
		$graph->title->Set($title);
		$graph->subtitle->SetFont(FF_SIMSUN,FS_BOLD,10);
		$graph->subtitle->Set('(��״ͳ��ͼ)');
		
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,16);
		$graph->xaxis->title->Set(" ");
		$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
		                              
		// Create a bar pot
		$bplot = new BarPlot($data['datay']);
		$bplot->SetFillColor('orange');
		$bplot->SetColor('darkblue');
		$bplot->SetWidth(0.5);
		$bplot->SetShadow('darkgray');
		
		// Setup the values that are displayed on top of each bar
		$bplot->value->Show();
		// Must use TTF fonts if we want text at an arbitrary angle
		//���������ͼ�ϵ����ִ�С
		$bplot->value->SetFont(FF_SIMSUN,FS_NORMAL,12);
		$bplot->value->SetFormat('%d ��');
		// Black color for positive values and darkred for negative values
		$bplot->value->SetColor("black","darkred");
		$graph->Add($bplot);
		
		// Finally stroke the graph
		return $graph->Stroke();
				
		//$this->load->view('stat/test1', $data);
	}
	
	//���ɱ�״ͼ
	function jp_pie($data)
	{
		require_once ('jpgraph/jpgraph.php');
		require_once ('jpgraph/jpgraph_pie.php');
		
		// Some data
		//$data = array(233334,133334,533334,633334,433334,333334);
		//$datax = array("����1","����2","����3","����4","����5","����6");
		
		// A new graph
		$graph = new PieGraph(780,300);
		$graph->SetShadow();
		
		// Setup title
		$title= "�ܼƣ�" . $data['total'] . "��";
		$graph->title->Set($title);
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,16);
		$graph->subtitle->SetFont(FF_SIMSUN,FS_BOLD,10);
		$graph->subtitle->Set('(��״ͳ��ͼ)');
		
		// The pie plot
		$p1 = new PiePlot($data['datay']);
		
		// Move center of pie to the left to make better room
		// for the legend
		$p1->SetCenter(0.35,0.5);
		
		// No border
		$p1->ShowBorder(false);
		
		// Label font and color setup
		$p1->value->SetFont(FF_SIMSUN,FS_BOLD,12);
		$p1->value->SetColor("darkred");
		
		// Use absolute values (type==1)
		$p1->SetLabelType(PIE_VALUE_ABS);
		
		// Label format
		$p1->value->SetFormat("%d");
		$p1->value->Show();
		
		// Size of pie in fraction of the width of the graph
		$p1->SetSize(0.3);
			
		// Legends
		foreach ($data['name'] as $id=>$x)
		{
			$data['name'][$id] = $x . " (%d)";
		}
		//$p1->SetLegends(array("May (%d)","June (%d)","July (%d)","Aug (%d)"));
		$graph -> legend -> SetFont(FF_SIMSUN,FS_NORMAL); 
		$p1->SetLegends($data['name']);
		$graph->legend->Pos(0.05,0.15);
		
		$graph->Add($p1);
		return $graph->Stroke();
	}
	
	function highcharts()
	{
		$this->load->view('stat/hc');
	}
}

