<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Test extends CI_Controller {
 
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

//$this->test_db = $this->load->database('test_db', TRUE);
//$this->ora_db = $this->load->database('oracle_db', TRUE);
}

	//��ʱ
	function time_out()
	{
		showmessage3('��¼��ʱ�������µ�¼', 'admin/exit_system');
	}

    //�������ݵ�Excel
    function exportexcel()
    {
    	ob_clean();
/*        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');	*/
        
/*        $role_id = $this->session->userdata('DX_role_id');
        $data = $this->_get_openkakou_by_perm($role_id);*/
        
      /*   $data['sel_type_alias'] = $this->input->get('type_alias');    //��ص�����
        
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

        $query = $this->Mgate->get_car_by_condition(0, 1000, $da);*/
        
        $query = $this->_get_excel_data();
        //$query = $this->db->query("select * from menu");
        //$query = mb_convert_encoding("gbk", "UTF-8", $query);
        
/*        if(!$query)
        return false;*/
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("����ϵͳ����")
                                     ->setDescription("����ϵͳ���ɵĳ�����ѯ����");
 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', iconv('gbk', 'utf-8', '����ϵͳExcel���ݱ�'))
                    ->setCellValue('B2', '����world!')
                    ->setCellValue('C1', 'Hello');
        // Field names in the first row
        $fields_name = array('���ƺ���','������ɫ','ͨ��ʱ��','��ص�����','����','����');
        $fields = array('HPHM','HPYS','PASSTIME','WZDD','FXBH','CDBH');
        //$fields = $query->list_fields();
        $col = 0;
        foreach ($fields_name as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, iconv('gbk','utf-8',$field));
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
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        
        $to_date =  mdate("%Y-%m-%d %h:%i:%s");
 
        //���ͱ���ǿ���û������ļ�
        header('Content-Type: application/vnd.ms-excel;charset=gbk');
        header('Content-Disposition: attachment;filename="kakou_excel.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
    
function excel()
{
ob_clean();

		//$sys['type_name']  = '��������';
		//$sys['type_value'] = '';
/*		    
		$openkakou_all = $this->Msyst->get_config_info($sys)->result();*/
$this->_get_excel_data();		
$this->load->database();
$query = $this->db->query("select * from menu");
// $query = mb_convert_encoding("gb2312", "UTF-8", $query);
if(!$query)
return false;
 
 
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setTitle("����ϵͳ����")
                             ->setDescription("����ϵͳ���ɵĳ�����ѯ����");
 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', iconv('gbk', 'utf-8', '����Hello'))
            ->setCellValue('B2', '����world!')
            ->setCellValue('C1', 'Hello');
// Field names in the first row
$fields = $query->list_fields();
$col = 0;
foreach ($fields as $field)
{
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 2, iconv('gbk','utf-8', $field));
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
 
$row++;
}
 
$objPHPExcel->setActiveSheetIndex(0);
 
$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 
//���ͱ���ǿ���û������ļ�
header('Content-Type: application/vnd.ms-excel;charset=UTF-8');
header('Content-Disposition: attachment;filename="PHPExcel_test.xls"');
header('Cache-Control: max-age=0');
 
$objWriter->save('php://output');

//$this->load->view('bmenu/index');
}
 
function test1()
{
	//index();
	$car = array('��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','³','ԥ','��','��','��','��','��','��','��','��','��','��','��','��','��','̨','��','��','��','��','��','��','��','��','��','��','��','��','��');  
	$letter=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$num=array('0','1','2','3','4','5','6','7','8','9');
	$extr = array('ѧ', '��');
	foreach ($letter as $id=>$low)
	{
		$upletter[$id] = strtoupper($low);
	}
	$all = array_merge($num, $upletter);
	
	foreach ($all as $a1)
	{
		foreach ($extr as $a2)
		{
			//$upword = strtoupper($l);
			$word = "'". $a1 . $a2 . "'";
			$this->db->query("insert into lexicon(word) values($word)");
		}
		//$upword = strtoupper($c);
		//$word = "'". $c . "'";
		//$upword = strtoupper($word);
		//$this->db->query("insert into lexicon(word) values($word)");
	}
	
	echo $this->db->last_query();
	
	$this->load->view('bmenu/index');
	
}

function test2()
{
	$id = 1586;
	
	$this->test_db->select('*');
	$this->test_db->where('id >=', $id);
	$this->test_db->where('id <', 10000);
	$query = $this->test_db->get('carlib');
	
	foreach ($query->result() as $row)
	{
		$carnum = $row->carnum;
		
		for($i=0;$i<(strlen($carnum)-2);$i++)
		{
			$section = mb_substr($carnum, $i, 2, 'gbk');
			
			$res= $this->test_db->select('*')->where('word',$section)->get('lexicon');
			
			if($res->num_rows()>0)
			{
				$lex_id = $res->row()->id;
				
				$this->test_db->query("insert into lex_car(lex_id, car_id, position) values($lex_id, $row->id, $i)");
			}
			else 
			{
				$this->test_db->query("insert into miss(miss_word, carlib_id) values('$section', $row->id)");
			}
		}
	}
	
	echo $this->test_db->query();
	
	$this->load->view('bmenu/index');
	
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

}

