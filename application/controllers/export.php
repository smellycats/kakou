<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou 输出控制器
 * 
 * @package     Kakou
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Fire
 *
 */

class Export extends Admin_Controller
{
	protected $imgip = array('192.168.10.234'=>'192.168.10.234:8888','192.168.10.235'=>'192.168.10.235:8888');
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('kakou');
		$this->load->helper('date');

		$this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $this->load->library('Lib_Kakou');
        $this->load->library('download');
        
		$this->load->model('Mexport');
		$this->load->model('Msyst');

		$this->load->config('kakou');

		if (substr($this->session->userdata('ip_address'),0,3)!='192')
		{
			$this->imgip = array('192.168.10.234'=>'10.44.249.227:81','192.168.10.235'=>'10.44.249.227:82');
		}
	}
	
	
	function _get_carinfo_data($offset = 0, $row_count = 1000)
	{
	    $da = $this->input->get(NULL,True);
	    
	    if ($this->input->get('role_id') == True) {
	    	$da['okkval'] = change_to_quotes($this->lib_kakou->openkakou2arr($this->input->get('role_id')));
	    }
		elseif ($this->input->get('type_alias') == 'all') {
			$da['okkval'] = change_to_quotes($this->session->userdata('DX_role_openkakou'));
		}
		else {
			$da['okkval'] = "'" . $this->input->get('type_alias'). "'";
		}
        
        if(isset($da['spcarnum'])){
        	if($da['spcarnum'] != ''){
        		$da['spcarnum'] = change_to_quotes(trim_arr($this->input->get('spcarnum')));
        	}
        }
        
        return $this->Mexport->get_carinfo($offset, $row_count, $da);
	}
	
    //导出数据到Excel
    function exportexcel()
    {
    	ob_clean();
          
        $query = $this->_get_carinfo_data(0, $this->config->item('kakou_xls_num'));
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("卡口系统数据")
                                     ->setDescription("卡口系统生成的车辆查询数据");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '卡口系统Excel数据表'));
                    
        // Field names in the first row
        //$fields_name = array('号牌号码','号牌颜色','通过时间','监控点名称','方向','车道');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '车牌号码', '颜色', '通过时间', '监控点名称', '方向', '车道');
        
        $col = 0;
        foreach ($fields_condition as $field)
        {
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, iconv('gbk', 'utf-8', $field));
        	$col++;
        }

        $row = 3;
        foreach($query->result() as $data)
        {   
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $data->$field));
                $col++;
            }
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //发送标题强制用户下载文件
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    
    //导出数据到Excel
    function wz_exportexcel()
    {
    	ob_clean();
          
        $query = $this->_get_carinfo_data(0, $this->config->item('kakou_xls_num'));
        //$query = $excel_data['cars'];
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("卡口系统数据")
                                     ->setDescription("卡口系统生成的车辆查询数据");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '卡口系统Excel数据表'));
                    
        // Field names in the first row
        //$fields_name = array('号牌号码','号牌颜色','通过时间','监控点名称','方向','车道');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH','CLSD');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '车牌号码', '颜色', '通过时间', '监控点名称', '方向', '车道', '车速', '违章类型');
        
        $col = 0;
        foreach ($fields_condition as $field)
        {
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, iconv('gbk', 'utf-8', $field));
        	$col++;
        }

        $row = 3;
        foreach($query->result() as $data)
        {   
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $data->$field));
                $col++;
            }
            if($data->CLBJ=='O'){$wzlx = "超速";}
            elseif($data->CLBJ=='N'){$wzlx = "逆行";}
			elseif($data->JLLX=='2' || $data->JLLX=='3'){$wzlx = "闯红灯";}
			elseif($data->JLLX=='4'){$wzlx = "不按车道行驶";}
			else{$wzlx = '';}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $wzlx));
					    
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //发送标题强制用户下载文件
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    

  
    //导出数据到Excel
    function bj_exportexcel()
    {
    	ob_clean();
          
        $query = $this->_get_carinfo_data(0, $this->config->item('kakou_xls_num'));
        //$query = $excel_data['cars'];
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("卡口系统数据")
                                     ->setDescription("卡口系统生成的车辆查询数据");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '卡口系统Excel数据表'));
                    
        // Field names in the first row
        //$fields_name = array('号牌号码','号牌颜色','通过时间','监控点名称','方向','车道');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH','CLSD');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '车牌号码', '颜色', '通过时间', '监控点名称', '方向', '车道', '报警类型', '处理状态', '确认用户');
        
        $col = 0;
        foreach ($fields_condition as $field)
        {
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, iconv('gbk', 'utf-8', $field));
        	$col++;
        }
 
        // Fetching the table data
        $row = 3;
        foreach($query->result() as $data)
        {   
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $data->$field));
                $col++;
            }
            
        	if($data->CLBJ =='B')   {$dispose = "临控";}
			elseif($data->CLBJ=='L'){$dispose = "布控";}
			elseif($data->CLBJ=='T'){$dispose = "套牌";}
			elseif($data->CLBJ=='D'){$dispose = "被盗抢";}
			elseif($data->CLBJ=='S'){$dispose = "便衣嫌疑";}
			elseif($data->CLBJ=='O'){$dispose = "超速";}   
			else{$dispose = '';}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $dispose));
			$col++;

        	if($data->CFBM == '' || $data->CFBM == '01' || $data->CFBM=='警情未处理'){$alarmtype = "警情未处理";}
			elseif($data->CFBM=='02'){$alarmtype = "号牌号码识别错误";}
			elseif($data->CFBM=='03'){$alarmtype = "号牌颜色识别错误";}
			elseif($data->CFBM=='04'){$alarmtype = "图像不清";}
			elseif($data->CFBM=='05'){$alarmtype = "已下达";}
			elseif($data->CFBM=='06'){$alarmtype = "不下达";}
			elseif($data->CFBM=='07'){$alarmtype = "未截获";}
			elseif($data->CFBM=='08'){$alarmtype = "被盗抢车";}
			elseif($data->CFBM=='09'){$alarmtype = "查获套牌车";}
			elseif($data->CFBM=='10'){$alarmtype = "交通违法车";}
			elseif($data->CFBM=='11'){$alarmtype = "与黑名单数据不符";}
			elseif($data->CFBM=='12'){$alarmtype = "数据更新不及时";}        
			else{$alarmtype = '';}
			$col++;
			
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //发送标题强制用户下载文件
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    
    //批量下载图片
    function export_imgs()
    {
		$time = mdate("%Y%m%d%H%i%s");
		$zipname = 'kakou_imgs' . $time;
		
		$ZipArchive = new ZipArchive();

		$ZipArchive->open($zipname.'.zip',ZipArchive::OVERWRITE);//创建一个空的zip文件

		$cars = $this->_get_carinfo_data(0, $this->config->item('kakou_img_num'))->result();
		
		foreach ($cars as $row) {
			$t_path = $this->path . $row->TJTP;
			
			$ZipArchive->addFile($t_path, basename($row->TJTP));
		}
		
		$ZipArchive->close();
		
        $dw = new download($zipname.'.zip');  //新建下载文件类
        $dw->getfiles();
        unlink($zipname.'.zip');  //下载完成后要进行删除  
    }
    
    function get_imgs()
    {
	    $da = $this->input->get(NULL,True);

		if ($this->input->get('type_alias') == 'all') {
			$da['okkval'] = change_to_quotes2($this->session->userdata('DX_role_openkakou'));
		}
		else {
			$da['okkval'] = "''" . $this->input->get('type_alias'). "''";
		}
        
        if(isset($da['spcarnum'])){
        	if($da['spcarnum'] != ''){
        		$da['spcarnum'] = change_to_quotes2(trim_arr($this->input->get('spcarnum')));
        	}
        }
        
        $da['time'] = mdate("%Y-%m-%d %H:%i:%s");
        $datetime 	= mdate("%Y%m%d%H%i%s");
        $da['sid']  = $this->session->userdata('session_id');
        $da['user'] = $this->session->userdata('DX_username');
        $da['work_id'] = strval($datetime).$da['user'];
        $da['sid']  = $this->session->userdata('session_id');
        
        #$server = $this->Mexport->get_cfg_kakou()->result();
        $this->Mexport->set_cfg_session(0, $this->config->item('kakou_img_num'), $da);
        //sleep(15);
        
        for($i=1;;$i++)
        {
        	$flag = True;
        	$res = $this->Mexport->get_cfg_session($da)->result();
        	foreach ($res as $r)
        	{
        		if ($r->WORK_FINISHED == 0) {
        			$flag = False;
        			break;
        		}
        	}
        	
        	if ($flag == True or $i > 120){
        		break;
        	}
        	sleep(1);
        }
        $data['imgdl'] = $res;
		$data['imgip'] = $this->imgip;
        #$data['imgdl']['server'] = 'test';
        #$data['server'][0] = '10.1.1.1';
        //var_dump($res);
        $this->load->view('export/imgdownload',$data);
        //$cs = $this->Mexport->get_cfg_session($da['work_id']);*/
        
    	#$time = mdate("%Y%m%d%H%i%s");
    	#$cars = $this->_get_carinfo_data(0, $this->config->item('kakou_img_num'))->result();
    }
    
     function test()
     {
     	$this->load->view('export/test');
     }
    
    
}