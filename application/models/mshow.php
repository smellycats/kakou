<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mshow extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}

	//����������ȡʵʱ����
	function get_realshow($data)
	{
		$sqlstr = 'SELECT * FROM CLTX WHERE 1=1 ';
		
		if($data['kakou'] != '')   //��ص�
		{
			$sqlstr = $sqlstr . " AND WZDD in ($data[kakou])";
		}
		if($data['okkval'] != '')   //��ص�
		{
			$sqlstr = $sqlstr . " AND KKBH in ($data[okkval])";
		}
		if($data['direction'] != '')   //����
		{
			$sqlstr = $sqlstr . " AND FXBH='$data[direction]'";
		}	
		
	    $sqlstr = $sqlstr . " AND JGSJ > to_date('$data[time_flag]','yyyy-mm-dd hh24:mi:ss')  ORDER BY ID DESC";
	    	

		return $this->ora_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as PASSTIME FROM ($sqlstr)t WHERE ROWNUM<=8" );
		
	}
	
	//����������ȡ����ʵʱ����
	function get_bjrealshow($data)
	{
		$sqlstr = "SELECT * FROM CLTX WHERE (CLBJ='B' OR CLBJ='D' OR CLBJ='S' OR CLBJ='T') ";
		
		if($data['kakou'] != '')   //��ص�
		{
			$sqlstr = $sqlstr . " AND WZDD in ($data[kakou])";
		}
		if($data['okkval'] != '')   //��ص�
		{
			$sqlstr = $sqlstr . " AND KKBH in ($data[okkval])";
		}
		
	    $sqlstr = $sqlstr . " AND JGSJ > to_date('$data[time_flag]','yyyy-mm-dd hh24:mi:ss')  ORDER BY ID DESC";    	

		return $this->ora_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime FROM ($sqlstr)t WHERE ROWNUM<=8" );
		
	}
}
?>
