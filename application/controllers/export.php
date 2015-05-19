<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kakou ���������
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
	
    //�������ݵ�Excel
    function exportexcel()
    {
    	ob_clean();
          
        $query = $this->_get_carinfo_data(0, $this->config->item('kakou_xls_num'));
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("����ϵͳ����")
                                     ->setDescription("����ϵͳ���ɵĳ�����ѯ����");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '����ϵͳExcel���ݱ�'));
                    
        // Field names in the first row
        //$fields_name = array('���ƺ���','������ɫ','ͨ��ʱ��','��ص�����','����','����');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '���ƺ���', '��ɫ', 'ͨ��ʱ��', '��ص�����', '����', '����');
        
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
        //���ͱ���ǿ���û������ļ�
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    
    //�������ݵ�Excel
    function wz_exportexcel()
    {
    	ob_clean();
          
        $query = $this->_get_carinfo_data(0, $this->config->item('kakou_xls_num'));
        //$query = $excel_data['cars'];
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("����ϵͳ����")
                                     ->setDescription("����ϵͳ���ɵĳ�����ѯ����");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '����ϵͳExcel���ݱ�'));
                    
        // Field names in the first row
        //$fields_name = array('���ƺ���','������ɫ','ͨ��ʱ��','��ص�����','����','����');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH','CLSD');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '���ƺ���', '��ɫ', 'ͨ��ʱ��', '��ص�����', '����', '����', '����', 'Υ������');
        
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
            if($data->CLBJ=='O'){$wzlx = "����";}
            elseif($data->CLBJ=='N'){$wzlx = "����";}
			elseif($data->JLLX=='2' || $data->JLLX=='3'){$wzlx = "�����";}
			elseif($data->JLLX=='4'){$wzlx = "����������ʻ";}
			else{$wzlx = '';}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $wzlx));
					    
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //���ͱ���ǿ���û������ļ�
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    

  
    //�������ݵ�Excel
    function bj_exportexcel()
    {
    	ob_clean();
          
        $query = $this->_get_carinfo_data(0, $this->config->item('kakou_xls_num'));
        //$query = $excel_data['cars'];
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("����ϵͳ����")
                                     ->setDescription("����ϵͳ���ɵĳ�����ѯ����");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '����ϵͳExcel���ݱ�'));
                    
        // Field names in the first row
        //$fields_name = array('���ƺ���','������ɫ','ͨ��ʱ��','��ص�����','����','����');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH','CLSD');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '���ƺ���', '��ɫ', 'ͨ��ʱ��', '��ص�����', '����', '����', '��������', '����״̬', 'ȷ���û�');
        
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
            
        	if($data->CLBJ =='B')   {$dispose = "�ٿ�";}
			elseif($data->CLBJ=='L'){$dispose = "����";}
			elseif($data->CLBJ=='T'){$dispose = "����";}
			elseif($data->CLBJ=='D'){$dispose = "������";}
			elseif($data->CLBJ=='S'){$dispose = "��������";}
			elseif($data->CLBJ=='O'){$dispose = "����";}   
			else{$dispose = '';}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, iconv('gbk','utf-8', $dispose));
			$col++;

        	if($data->CFBM == '' || $data->CFBM == '01' || $data->CFBM=='����δ����'){$alarmtype = "����δ����";}
			elseif($data->CFBM=='02'){$alarmtype = "���ƺ���ʶ�����";}
			elseif($data->CFBM=='03'){$alarmtype = "������ɫʶ�����";}
			elseif($data->CFBM=='04'){$alarmtype = "ͼ����";}
			elseif($data->CFBM=='05'){$alarmtype = "���´�";}
			elseif($data->CFBM=='06'){$alarmtype = "���´�";}
			elseif($data->CFBM=='07'){$alarmtype = "δ�ػ�";}
			elseif($data->CFBM=='08'){$alarmtype = "��������";}
			elseif($data->CFBM=='09'){$alarmtype = "������Ƴ�";}
			elseif($data->CFBM=='10'){$alarmtype = "��ͨΥ����";}
			elseif($data->CFBM=='11'){$alarmtype = "����������ݲ���";}
			elseif($data->CFBM=='12'){$alarmtype = "���ݸ��²���ʱ";}        
			else{$alarmtype = '';}
			$col++;
			
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %H-%i-%s");
 
        $file_name = "kakou_excel_" . (string)$to_date;
        //���ͱ���ǿ���û������ļ�
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="'. $file_name .'"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    
    //��������ͼƬ
    function export_imgs()
    {
		$time = mdate("%Y%m%d%H%i%s");
		$zipname = 'kakou_imgs' . $time;
		
		$ZipArchive = new ZipArchive();

		$ZipArchive->open($zipname.'.zip',ZipArchive::OVERWRITE);//����һ���յ�zip�ļ�

		$cars = $this->_get_carinfo_data(0, $this->config->item('kakou_img_num'))->result();
		
		foreach ($cars as $row) {
			$t_path = $this->path . $row->TJTP;
			
			$ZipArchive->addFile($t_path, basename($row->TJTP));
		}
		
		$ZipArchive->close();
		
        $dw = new download($zipname.'.zip');  //�½������ļ���
        $dw->getfiles();
        unlink($zipname.'.zip');  //������ɺ�Ҫ����ɾ��  
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