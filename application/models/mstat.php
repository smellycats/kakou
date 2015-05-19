<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mstat extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}

	//����������ѯ�������� 
	function get_carflow_by_condition($data)
	{
		$sqlstr = '';
		//��صص�
		if($data['place'] != 'all')
		{
			$sqlstr = $sqlstr . " AND KKBH ='$data[place]'";
		}
		//����
		if ($data['dire'] != '')
		{
			if($data['dire'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND FXBH='$data[dire]'";
			}
		}
		//��������
		if ($data['cartype'] != '')
		{
			if($data['cartype'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['cartype'] == '��')
			{
				$sqlstr = $sqlstr . " AND HPYS='����'";
			}
			elseif($data['cartype'] == 'С��')
			{
				$sqlstr = $sqlstr . " AND HPYS='����'";
			}
			elseif($data['cartype'] == '����')
			{
				$sqlstr = $sqlstr . " AND HPYS!='����' AND HPYS!='����'";
			}
		}
		
		//Υ������
		if($data['breakrule'] != '')
		{
			if($data['breakrule'] == 'all')
			{
				$sqlstr = $sqlstr . " AND (CLBJ='O' OR JLLX='2' OR JLLX='3' OR JLLX='4')";
			}
			elseif($data['breakrule'] == '����')
			{
				$sqlstr = $sqlstr . " AND CLBJ='O'";
			}
			elseif($data['breakrule'] == '����')
			{
				$sqlstr = $sqlstr . " AND (CLBJ='N')";
			}
			elseif($data['breakrule'] == '�����')
			{
				$sqlstr = $sqlstr . " AND (JLLX='2' OR JLLX='3')";
			}
			elseif($data['breakrule'] == '����������ʻ')
			{
				$sqlstr = $sqlstr . " AND JLLX='4'";
			}
		}
		
		//��������	
		if($data['alarmtype'] != '')
		{
			if($data['alarmtype'] == '����������')
			{
				$sqlstr = $sqlstr . " AND CLBJ='D'";
			}
			elseif($data['alarmtype'] == '���Ƴ���')
			{
				$sqlstr = $sqlstr . " AND CLBJ='T'";
			}
			elseif($data['alarmtype'] == '�������ɳ���')
			{
				$sqlstr = $sqlstr . " AND CLBJ='S'";
			}
			elseif($data['alarmtype'] == '���س���')
			{
				$sqlstr = $sqlstr . " AND CLBJ='B'";
			}
			else
			{
				$sqlstr = $sqlstr . "AND CLBJ<>'F' AND CLBJ<>'O'";
			}
		}
		
		//���鴦��	
		if($data['dispose'] != '')
		{
			if($data['dispose'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['dispose'] == '����δ����')
			{
				$sqlstr = $sqlstr . " AND (CFBM='' or CFBM is null) ";
			}
			elseif($data['dispose'] == '���ƺ���ʶ�����')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='����ʶ�����' OR CFBM='ʶ�����')";
			}
			elseif($data['dispose'] == '������ɫʶ�����')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='��ɫʶ�����')";
			}
			elseif($data['dispose'] == '����������ݲ���')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='�ȶ����ݴ�')";
			}
			else
			{
				$sqlstr = $sqlstr . " AND CFBM='$data[dispose]'";
			}
		}	
		//��ʼʱ��
		if($data['st'] != '')
		{
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[st]','yyyy-mm-dd hh24:mi:ss')";
		}
		//����ʱ��
		if($data['et'] != '')
		{ 
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[et]','yyyy-mm-dd hh24:mi:ss')";
		}
		
		return $this->ora_db->query("select count(*) as RCount from CLTX where 1=1 ". $sqlstr);
	}

	//����������ѯΥ�������� 
	function get_breakrule_by_condition($data)
	{
		$sqlstr = '';
		
		if($data['okkval'] != '')   //��صص�
		{
			$sqlstr = $sqlstr . " AND KKBH ='$data[okkval]'";
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
		if ($data['cartype'] != '')      //��������
		{
			if($data['cartype'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['cartype'] == '��')
			{
				$sqlstr = $sqlstr . " AND HPYS='����'";
			}
			elseif($data['cartype'] == 'С��')
			{
				$sqlstr = $sqlstr . " AND HPYS='����'";
			}
			elseif($data['cartype'] == '����')
			{
				$sqlstr = $sqlstr . " AND HPYS!='����' AND HPYS!='����'";
			}
		}
		if($data['starttime'] != '')            //��ʼʱ��
		{
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //����ʱ��
		{ 
			//$sqlstr = $sqlstr . " AND jgsj<to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
		}
		
		if($data['breakrule'] != '')
		{
			if($data['breakrule'] == 'all')
			{
				$sqlstr = $sqlstr . " AND (CLBJ='O' OR JLLX='2' OR JLLX='3' OR JLLX='4')";
			}
			elseif($data['breakrule'] == '����')
			{
				$sqlstr = $sqlstr . " AND CLBJ='O'";
			}
			elseif($data['breakrule'] == '����')
			{
				$sqlstr = $sqlstr . " AND (CLBJ='N')";
			}
			elseif($data['breakrule'] == '�����')
			{
				$sqlstr = $sqlstr . " AND (JLLX='2' OR JLLX='3')";
			}
			elseif($data['breakrule'] == '����������ʻ')
			{
				$sqlstr = $sqlstr . " AND JLLX='4'";
			}
		}
		
		return $this->ora_db->query("select count(*) as RCount from CLTX where 1=1 ". $sqlstr);
	}
	
	//����������ѯ���������� 
	function get_alarmcar_by_condition($data)
	{
		$sqlstr = '';
		
		if($data['okkval'] != '')   //��صص�
		{
			$sqlstr = $sqlstr . " AND KKBH ='$data[okkval]'";
		}

		if ($data['cartype'] != '')      //��������
		{
			if($data['cartype'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['cartype'] == '��')
			{
				$sqlstr = $sqlstr . " AND HPYS='����'";
			}
			elseif($data['cartype'] == 'С��')
			{
				$sqlstr = $sqlstr . " AND HPYS='����'";
			}
			elseif($data['cartype'] == '����')
			{
				$sqlstr = $sqlstr . " AND HPYS!='����' AND HPYS!='����'";
			}
		}
		if($data['starttime'] != '')            //��ʼʱ��
		{
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //����ʱ��
		{ 
			//$sqlstr = $sqlstr . " AND jgsj<to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
		}
		//��������	
		if($data['alarmtype'] != '')
		{
			if($data['alarmtype'] == '����������')
			{
				$sqlstr = $sqlstr . " AND CLBJ='D'";
			}
			elseif($data['alarmtype'] == '���Ƴ���')
			{
				$sqlstr = $sqlstr . " AND CLBJ='T'";
			}
			elseif($data['alarmtype'] == '�������ɳ���')
			{
				$sqlstr = $sqlstr . " AND CLBJ='S'";
			}
			elseif($data['alarmtype'] == '���س���')
			{
				$sqlstr = $sqlstr . " AND CLBJ='B'";
			}
			else
			{
				$sqlstr = $sqlstr . "AND CLBJ<>'F' AND CLBJ<>'O'";
			}
		}
		//���鴦��	
		if($data['dispose'] != '')
		{
			if($data['dispose'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['dispose'] == '����δ����')
			{
				$sqlstr = $sqlstr . " AND (CFBM='' or CFBM is null) ";
			}
			elseif($data['dispose'] == '���ƺ���ʶ�����')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='����ʶ�����' OR CFBM='ʶ�����')";
			}
			elseif($data['dispose'] == '������ɫʶ�����')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='��ɫʶ�����')";
			}
			elseif($data['dispose'] == '����������ݲ���')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='�ȶ����ݴ�')";
			}
			else
			{
				$sqlstr = $sqlstr . " AND CFBM='$data[dispose]'";
			}
		}	
		
		return $this->ora_db->query("select count(*) as RCount from CLTX where 1=1 ". $sqlstr);
	}
	
	function get_alias_by_bh($bh)
	{
		return $this->ora_db->query("select type_alias from config_info where type_value = '$bh'");
	}
}
?>