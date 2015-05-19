<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mwmenu extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}

	//��ȡ��������Ϣ
	function get_whitelist_all()
	{
		return $this->ora_db->query("select * from WLCP where memo='B'");
	}
	
	//���ݳ��Ʋ�ѯ��������Ϣ
	function get_whilelist_by_num($carnum)
	{
		return $this->ora_db->query("select * from WLCP where HPHM='$carnum' and memo='B'");
	}
	
	//�޸İ�������Ϣ
	function edit_whilelist($id, $data)
	{
		return $this->ora_db->query("update WLCP set CLBJ='$data[check]' where ID='$id'");
	}
	
	//����IDɾ������������
	function del_whilelist_by_id($id)
	{
		return $this->ora_db->query("delete from WLCP where ID='$id'");
	}
	
	//��Ӱ�����
	function add_wl($data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		return $this->ora_db->query("Insert Into WLCP(HPHM,HPYS,CLBJ)Values('$data[carnum]','$data[color]','F')");
	}
	
	//���ݳ��ƺŲ��Ұ���������
	function find_wl_by_carnum($data)
	{
        return $this->ora_db->query("select * from WLCP where hphm like '$data[carnum]' and  memo='B' ORDER BY HPHM DESC");
	}
	
	//����������ѯ����������
	function get_wmenu_by_condition($offset = 0, $row_count = 0, $data)
	{
		$sqlstr = '';
		
		if($data['okkval'] != '')   //��ص�
		{
			$sqlstr = $sqlstr . " AND WZDD IN ($data[okkval])";
		}
		if ($data['lane'] != '')      //�������
		{
			if($data['lane'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND CDBH='$data[lane]'";
			}
		}
		if ($data['direction'] != '')  //����
		{
			if($data['direction'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND FXBH='$data[direction]'";
			}
		}
		if ($data['color'] != '')      //��ɫ
		{
			if($data['color'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND HPYS='$data[color]'";
			}
		}
		
        //���ƺ���
		if(strlen($data['carnum'])>=1 AND $data['number'] != '-' AND $data['number'] != 'R')  
        {
        	$data['number'] = str_replace('?', '%', $data['number']);
        	$data['number'] = str_replace('��', '%', $data['number']);
        	$data['number'] = str_replace('R', '%', $data['number']);
        	$data['carnum'] = str_replace('*', '%', $data['carnum']);
            $data['carnum'] = str_replace('?', '_', $data['carnum']);
            $data['carnum'] = str_replace('��', '_', $data['carnum']);
            
            if($data['number'] == 'all')
            {
            	$data['number'] = '%';
            }
            $carnum = "$data[number]" . "$data[carnum]";
            
            $sqlstr = $sqlstr . " AND HPHM LIKE '$carnum'";
        }
		elseif ($data['carnum'] == '' AND $data['number'] == '?')
        {
        	$sqlstr = $sqlstr;
        }
        elseif($data['carnum'] == '' AND $data['number'] != '-' AND $data['number'] != 'R')
        {
        	$sqlstr = $sqlstr . " AND HPHM LIKE '$data[number]%'";
        }
        elseif($data['number'] == '-')       
		{
			$sqlstr = $sqlstr . " AND (HPHM='' OR HPHM='-')";
		}
		elseif($data['number'] == 'R')
		{
			$sqlstr = $sqlstr . " and length(hphm)>=2";
		}
		
		if($data['starttime'] != '')            //��ʼʱ��
		{
			$sqlstr = $sqlstr . " AND jgsj > '$data[starttime]' ";
		}
		if($data['endtime'] != '')              //����ʱ��
		{ 
			$sqlstr = $sqlstr . " AND jgsj < '$data[endtime]'";
		}
		
		if ($offset >= 0 AND $row_count > 0)
	    {
			$max_count = $row_count+$offset;
			
			$query = $this->ora_db->query("SELECT t.*, jgsj as passtime FROM (SELECT A.*, ROWNUM RN FROM (SELECT * FROM wcltx where 1=1 " . $sqlstr . " order by id desc) A WHERE ROWNUM <= $max_count)t WHERE RN > $offset" );
		}
			else
		{
			//���ز�ѯ�������
			$query = $this->ora_db->query("select count(1) as sum  from wcltx where 1=1 " . $sqlstr);
		}
		
		return $query;
	}

	//����ID��ȡ������������Ϣ
	function get_wmenu_by_id($id)
	{
		return $this->ora_db->query("SELECT t.* , jgsj as passtime from wcltx t where ID='$id'");
	}
	
	//����ID�޸İ�����������Ϣ
	function edit_wmenu_by_id($id, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		return $this->ora_db->query("update wcltx set hphm='$data[carnum]',hpys='$data[color]',hdgg='T' where id='$id'");
	}
	
	//����IDɾ��������������Ϣ
	function del_wmenu_by_id($id)
	{
		return $this->ora_db->query("delete from wcltx where id='$id'");
	}

}
?>