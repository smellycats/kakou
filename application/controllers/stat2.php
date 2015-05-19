<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 统计分析控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Stat extends Admin_Controller
{
	//方向
	protected $direction = array('进城', '出城', '由东往西', '由南往北', '由西往东', '由北往南');
	//图表类型
	protected $viewtype = array('柱状图', '圆盘图');
	//违章类型
	protected $breakrule = array('超速','逆行','闯红灯','不按车道行驶');
	//
	protected $alarmtype = array('被盗抢车辆','套牌车辆','便衣嫌疑车辆','布控车辆');
	
	protected $dispose = array('警情未处理','车牌号码识别错误','车牌颜色识别错误','图像不清','已下达','不下达','未截获','已截获','查获被盗抢车','查获套牌车','查获交通违法车','与黑名单数据不符');
	
	protected $cartype = array('大车', '小车' ,'其他');
	
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
	
	//加载车辆统计视图
	function carsum()
	{
		$this->load->model('Msyst');
		
		$sys['type_name']  = '卡口名称';
		$sys['type_value'] = '';
		//获得路口参数信息 
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
		$data['sel_viewtype']  = '柱状图';
		$data['sel_direction'] = 'all';
		
		$data['sel_graph'] = '';
		
		$data['total'] = 0;
		$data['name'] = "'无'";
		$data['rotation'] = -1;
		$data['align'] = "'right'";
		$data['count'] = 0;
		$data['display'] = 'none';
		
		$this->load->view('stat/carsum', $data);
	}
	
	function carsum_search()
	{
		$this->form_validation->set_rules('type_alias', '车牌号码', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_message('required', '%s不能为空.');
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
	    	
	    	if($da['viewtype'] == '柱状图')
	    	{
	    		$data['sel_graph'] = base_url() . "index.php/stat/jp1";
	    	}else 
	    	{
	    		$data['sel_graph'] = base_url() . "index.php/stat/jp2";
	    	}
	    	
	    	$this->load->model('Msyst');
	  		$sys['type_name']  = '卡口名称';
		    $sys['type_value'] = '';
		    
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
			foreach ($openkakou as $id=>$kakou)
	        {
	    	    $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	    	    $data['okkval'][$id] = $kakou->TYPE_VALUE;
		    }
		    
	    	//获得路口参数信息 
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
	    	
	    	$data['cartype'] = array('大车', '小车' ,'其他');
            $data['viewtype'] = $this->viewtype;
            $data['direction'] = $this->direction;
            
			$data['datay'] = $jp_data['count'];
			$data['name']  = $jp_data['openkakou'];
			$data['total'] = 0.0;
			
			foreach($jp_data['count'] as $count)
			{
				$data['total'] += $count;
			}	
		
		   	if($da['viewtype'] == '柱状图')
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
	    	
	  	$sys['type_name']  = '卡口名称';
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
		    
    	//获得路口参数信息 
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
		if($da['viewtype'] == '柱状图')
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

	//车辆统计查询
	//正在使用
/*	function carsum_search3()
	{
		//$this->load->library('jpgraph/Graph');
        //$this->load->library('jpgraph/BarPlot');	
        
		$this->form_validation->set_rules('type_alias', '车牌号码', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_message('required', '%s不能为空.');
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
	    
	    	
	    	$data['cartype'] = array('大车', '小车' ,'其他');
            $data['viewtype'] = $this->viewtype;
            $data['direction'] = $this->direction;
            
	    	$this->load->model('Msyst');
	    	
	  		$sys['type_name']  = '卡口名称';
		    $sys['type_value'] = '';
		    
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
			foreach ($openkakou as $id=>$kakou)
	        {
	    	    $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		    }
	    	
	    	$this->load->view('stat/carsum', $data);
		}
			
	}*/
	
	//加载违法统计视图
	function wzsum()
	{
		$this->load->model('Msyst');
		
		$sys['type_name']  = '卡口名称';
		$sys['type_value'] = '';
		//获得路口参数信息 
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
		$data['sel_viewtype'] = '柱状图';
		$data['sel_direction'] = 'all';
		$data['sel_breakrule'] = 'all';
		$data['sel_graph'] = '';
		
		$data['total'] = 0;
		$data['name'] = "'无'";
		$data['rotation'] = -1;
		$data['align'] = "'right'";
		$data['count'] = 0;
		$data['display'] = 'none';
			
		$this->load->view('stat/wzsum', $data);
	}
	
	//违章统计查询
	function wzsum_search()
	{
		$this->form_validation->set_rules('type_alias', '车牌号码', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_message('required', '%s不能为空.');
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
	  		$sys['type_name']  = '卡口名称';
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
	
	//违章统计查询
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
	    	
	  		$sys['type_name']  = '卡口名称';
		    $sys['type_value'] = '';
		    
		    $openkakou = $this->Msyst->get_config_info($sys)->result();
		    
			foreach ($openkakou as $id=>$kakou)
	        {
	    	    $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	    	    $data['okkval'][$id] = $kakou->TYPE_VALUE;
		    }

	    	//获得路口参数信息 
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
		
		if($da['viewtype'] == '柱状图')
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

	//加载报警车辆视图
	function bjsum()
	{
		$this->load->model('Msyst');
		
		$sys['type_name']  = '卡口名称';
		$sys['type_value'] = '';
		//获得路口参数信息 
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
		$data['sel_viewtype'] = '柱状图';
		$data['sel_direction'] = 'all';
		$data['sel_breakrule'] = 'all';
		$data['sel_graph'] = '';
		$data['sel_alarmtype'] = 'all';
		$data['sel_dispose'] = 'all';

		$data['total'] = 0;
		$data['name'] = "'无'";
		$data['rotation'] = -1;
		$data['align'] = "'right'";
		$data['count'] = 0;
		$data['display'] = 'none';
		
		$this->load->view('stat/bjsum', $data);
	}

	//报警统计查询
	function bjsum_search()
	{
		$this->form_validation->set_rules('type_alias', '车牌号码', 'trim|required|xss_clean|max_length[20]');
		$this->form_validation->set_message('required', '%s不能为空.');
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
	  		$sys['type_name']  = '卡口名称';
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
	
	//报警统计查询
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
	    	
	  	$sys['type_name']  = '卡口名称';
		$sys['type_value'] = '';
		    
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		    
		foreach ($openkakou as $id=>$kakou)
	    {
	   	   	$data['openkakou'][$id] = $kakou->TYPE_ALIAS;
	   	   	$data['okkval'][$id] = $kakou->TYPE_VALUE;
		}

	    	//获得路口参数信息 
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
		
		if($da['viewtype'] == '柱状图')
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
	
	//创建图片
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
	  	$sys['type_name']  = '卡口名称';
		$sys['type_value'] = '';
		    
		$openkakou = $this->Msyst->get_config_info($sys)->result();
		    
		$data['openkakou'] = array();
		    
		foreach ($openkakou as $id=>$kakou)
	    {
	        $data['openkakou'][$id] = $kakou->TYPE_ALIAS;
		}
		    
	    //获得路口参数信息 
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

	    if($da['viewtype'] == '柱状图')
    	{
    		$data['jpdata'] = $this->jp_bar($data);
    	}
    	else 
    	{
    		$data['jpdata'] = $this->jp_pie($data);
    	}
			
		$this->load->view('stat/create_graph', $data);
	}

	//生成柱状图
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
		//$a = array("卡口1","卡口2","卡口3","卡口4","卡口5","卡口6");
		$graph->xaxis->SetTickLabels($data['name']);
		$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD,10);
		$graph->xaxis->SetColor('darkblue','black');
		
		// Stup "hidden" y-axis by given it the same color
		// as the background
		$graph->yaxis->SetColor('white','darkblue');
		$graph->ygrid->SetColor('white');
		
		// Setup graph title ands fonts
		$title= "总计：" . $data['total'] .  "辆";
		$graph->title->Set($title);
		$graph->subtitle->SetFont(FF_SIMSUN,FS_BOLD,10);
		$graph->subtitle->Set('(柱状统计图)');
		
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
		//这个是柱形图上的数字大小
		$bplot->value->SetFont(FF_SIMSUN,FS_NORMAL,12);
		$bplot->value->SetFormat('%d 辆');
		// Black color for positive values and darkred for negative values
		$bplot->value->SetColor("black","darkred");
		$graph->Add($bplot);
		
		// Finally stroke the graph
		return $graph->Stroke();
				
		//$this->load->view('stat/test1', $data);
	}
	
	//生成饼状图
	function jp_pie($data)
	{
		require_once ('jpgraph/jpgraph.php');
		require_once ('jpgraph/jpgraph_pie.php');
		
		// Some data
		//$data = array(233334,133334,533334,633334,433334,333334);
		//$datax = array("卡口1","卡口2","卡口3","卡口4","卡口5","卡口6");
		
		// A new graph
		$graph = new PieGraph(780,300);
		$graph->SetShadow();
		
		// Setup title
		$title= "总计：" . $data['total'] . "辆";
		$graph->title->Set($title);
		$graph->title->SetFont(FF_SIMSUN,FS_BOLD,16);
		$graph->subtitle->SetFont(FF_SIMSUN,FS_BOLD,10);
		$graph->subtitle->Set('(饼状统计图)');
		
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

