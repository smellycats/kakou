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

class Export2 extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('kakou');
		$this->load->helper('date');

		$this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $this->load->library('Lib_Kakou');
        $this->load->library('download');

		$this->load->model('Mlogo');

		$this->load->config('kakou');

		if (substr($this->session->userdata('ip_address'),0,3)=='192')
		{
			$this->imgpath = array(0=>'192.168.10.234:8888',1=>'192.168.10.235:8888',''=>'192.168.10.234:8888');
		}else {
			$this->imgpath = array(0=>'10.44.249.227:81',1=>'10.44.249.227:82',''=>'10.44.249.227:81');
		}
	}
	
	function test2()
	{
		echo '123';
	}
    
	function _get_excel_data($offset = 0, $rows = 1000)
	{
	    #$role_id = $this->session->userdata('DX_role_id');
	    $role_id = 1;
	    
		$data = $this->session->userdata('lgquery');
		
        return $this->Mlogo->get_carinfo3($offset,$rows,$data['sort'],$data['order'],$data);
        //return $this->Mlogo->get_carinfo3($offset, $row_count, $data);
	}
	
	
    //�������ݵ�Excel
    function exportexcel()
    {
    	ob_clean();
          
        $query = $this->_get_excel_data(0, $this->config->item('kakou_xls_num'));
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("����ϵͳ����")
                                     ->setDescription("����ϵͳ���ɵĳ�����ѯ����");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '����ϵͳExcel���ݱ�'));
                    
        // Field names in the first row
        //$fields_name = array('���ƺ���','������ɫ','ͨ��ʱ��','��ص�����','����','����');
        $fields = array('hphm','hpys','passtime','place','dire','lane','clpp','clpp_son','cllx','csys');
        //$fields = $query->list_fields();
        
        $fields_condition = array( '���ƺ���', '��ɫ', 'ͨ��ʱ��', '��ص�����', '����', '����','������־','����Ʒ��','��������','������ɫ');
        
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
            	$content = $data->$field;
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
 	
    //��������ͼƬ
    function exportimg()
    {
    	#error_reporting(0); 
    	
    	$query = $this->_get_excel_data(0, 500);
    	$urls = array();
    	
    	foreach($query->result_array() as $row){
    		$imgurl = get_picurl($row['img_ip'], 'SpreadData'.$row['img_disk'], $row['img_path']);
    		array_push($urls, iconv('GB2312','UTF-8',$imgurl));
        }
		
        $post_data = array('key'=>'sx2767722',
        				   'urls'=>json_encode($urls)
        				   );
        var_dump($post_data);
		$zipfile = h_send_post($this->config->item('package_url'),$post_data);
		if ($zipfile){
			echo 'http://127.0.0.1/imgs/'.$zipfile;
		}else {
			echo 'NULL';
		}
        #echo json_encode($urls);
    }

    //��������ͼƬ
    function test()
    {
        //$query = $this->_get_excel_data(0, 500);
    	$urls = array('http://localhost/imgareaselect/imgs/1.jpg','http://localhost/imgareaselect/imgs/2.jpg');
    	/*
    	foreach($query->result_array() as $row){
    		$imgurl = get_picurl($row['img_ip'], 'SpreadData'.$row['img_disk'], $row['img_path']);
    		array_push($urls, iconv('GB2312','UTF-8',$imgurl));
        } */
		
        $post_data = array('key'=>'sx2767722',
        				   'urls'=>json_encode($urls)
        				   );
        var_dump(json_encode($post_data));
		$zipfile = h_send_json_post($this->config->item('package_url'),json_encode($post_data));
		if ($zipfile){
			echo 'http://127.0.0.1/imgs/'.$zipfile;
		}else {
			echo 'NULL';
		}
    }
    
}

