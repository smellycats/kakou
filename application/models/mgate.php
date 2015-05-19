<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mgate extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}

	function get_car_all($offset = 0, $row_count = 0)
	{
		if ($offset >= 0 AND $row_count > 0)
	    {
			$max_count = $row_count+$offset;
			
			$query = $this->ora_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime FROM (SELECT A.*, ROWNUM RN FROM (SELECT * FROM cltx order by jgsj desc) A WHERE ROWNUM <= $max_count)t WHERE RN > $offset" );
		}
		else
		{
			//���ز�ѯ�������
			$query = $this->ora_db->query("select count(1) as sum  from cltx");
		}

		return $query;
		
	}
	
	//����������ȡ������Ϣ
	function get_car_by_condition($offset = 0, $row_count = 0, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		$sqlstr = '';
		
		if($data['okkval'] != '')   //��ص�
		{
			$sqlstr = $sqlstr . " AND KKBH IN ($data[okkval])";
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
		
		if($data['spcarnum'] != '')    //���⳵��
		{
			$sqlstr = $sqlstr . " AND HPHM in ($data[spcarnum])";
		}
        //���ƺ���
		elseif(strlen($data['carnum'])>=1 AND $data['number'] != '-' AND $data['number'] != 'R')  
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
        elseif($data['carnum'] == '' AND $data['number'] == '?')
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
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //����ʱ��
		{ 
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
		}
		
		if ($offset >= 0 AND $row_count > 0)
	    {
			$max_count = $row_count+$offset;
			
			$query = $this->ora_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime FROM (SELECT A.*, ROWNUM RN FROM (SELECT * FROM cltx where 1=1 " . $sqlstr . " order by jgsj desc) A WHERE ROWNUM <= $max_count)t WHERE RN > $offset" );
		}
		elseif($offset == -1)
		{
			$query = $this->ora_db->query("SELECT t.* , to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime FROM cltx t where 1=1 " . $sqlstr . " order by jgsj desc");
		}
		else
		{
			//���ز�ѯ�������
			$query = $this->ora_db->query("select count(1) as sum  from cltx where 1=1 " . $sqlstr);
		}
		
		return $query;
		
		//echo $this->db->last_query();
	}
	
	//����������ȡΥ�³�����Ϣ
	function get_breakrule_by_condition($offset = 0, $row_count = 0, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		$sqlstr = '';
		
		if($data['okkval'] != '')   //��ص�
		{
			$sqlstr = $sqlstr . " AND KKBH IN ($data[okkval])";
		}
		if ($data['record'] != '')      //��¼״̬
		{
			if($data['record'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['record'] == '�Ѻ˶�')
			{
				$sqlstr = $sqlstr . " AND HDGG='T'";
			}
			elseif($data['record'] == '�����')
			{
				$sqlstr = $sqlstr . " AND QBGG='T'";
			}
			elseif($data['record'] == '�Ѵ���')
			{
				$sqlstr = $sqlstr . " AND CFGG='T'";
			}
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
			else
			{
				$sqlstr = $sqlstr;
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
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //����ʱ��
		{ 
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
		}
		
		if($data['minspeed'] != '')            //��С�ٶ�
		{
			$sqlstr = $sqlstr . " AND CLSD >= '$data[minspeed]'";
		}
		if($data['maxspeed'] != '')              //����ٶ�
		{ 
			$sqlstr = $sqlstr . " AND CLSD <= '$data[maxspeed]'";
		}
		
		if ($offset >= 0 AND $row_count > 0)
	    {
			$max_count = $row_count+$offset;
			
			$query = $this->ora_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime FROM (SELECT A.*, ROWNUM RN FROM (SELECT * FROM cltx where 1=1 " . $sqlstr . " order by jgsj desc) A WHERE ROWNUM <= $max_count)t WHERE RN > $offset" );
		}
		elseif($offset == -1)
		{
			$query = $this->ora_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime FROM cltx t where 1=1 " . $sqlstr . " order by jgsj desc");
		}
		else
		{
			//���ز�ѯ�������
			$query = $this->ora_db->query("select count(1) as sum  from cltx where 1=1 " . $sqlstr);
		}
		
		return $query;
	}
	
	//����������ȡ����������Ϣ
	function get_alarmcar_by_condition($offset = 0, $row_count = 0, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		$sqlstr = '';
		
		if($data['okkval'] != '')   //��ص�
		{
			$sqlstr = $sqlstr . " AND c.KKBH IN ($data[okkval])";
		}
	    	
		if($data['alarmtype'] != '')    //��������
		{
			if($data['alarmtype'] == '����������')
			{
				$sqlstr = $sqlstr . " AND c.CLBJ='D'";
			}
			elseif($data['alarmtype'] == '���Ƴ���')
			{
				$sqlstr = $sqlstr . " AND c.CLBJ='T'";
			}
			elseif($data['alarmtype'] == '�������ɳ���')
			{
				$sqlstr = $sqlstr . " AND c.CLBJ='S'";
			}
			elseif($data['alarmtype'] == '���س���')
			{
				$sqlstr = $sqlstr . " AND c.CLBJ='B'";
			}
			else
			{
				$sqlstr = $sqlstr . "AND (c.CLBJ='D' OR c.CLBJ='T' OR c.CLBJ='S' OR c.CLBJ='B')";
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
				$sqlstr = $sqlstr . " AND (c.CFBM='' or c.CFBM is null) ";
			}
			elseif($data['dispose'] == '���ƺ���ʶ�����')
			{
				$sqlstr = $sqlstr . " AND (c.CFBM='$data[dispose]' OR c.CFBM='����ʶ�����' OR c.CFBM='ʶ�����')";
			}
			elseif($data['dispose'] == '������ɫʶ�����')
			{
				$sqlstr = $sqlstr . " AND (c.CFBM='$data[dispose]' OR c.CFBM='��ɫʶ�����')";
			}
			elseif($data['dispose'] == '����������ݲ���')
			{
				$sqlstr = $sqlstr . " AND (c.CFBM='$data[dispose]' OR c.CFBM='�ȶ����ݴ�')";
			}
			else
			{
				$sqlstr = $sqlstr . " AND c.CFBM='$data[dispose]'";
			}
		}	
		if ($data['color'] != '')      //��ɫ
		{
			if($data['color'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND c.HPYS='$data[color]'";
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
            
            $sqlstr = $sqlstr . " AND c.HPHM LIKE '$carnum'";
        }
	    elseif ($data['carnum'] == '' AND $data['number'] == '?')
        {
        	$sqlstr = $sqlstr;
        }
        elseif($data['carnum'] == '' AND $data['number'] != '-' AND $data['number'] != 'R')
        {
        	$sqlstr = $sqlstr . " AND c.HPHM LIKE '$data[number]%'";
        }
        elseif($data['number'] == '-')       
		{
			$sqlstr = $sqlstr . " AND (c.HPHM='' OR c.HPHM='-')";
		}
		elseif($data['number'] == 'R')
		{
			$sqlstr = $sqlstr . " and length(c.hphm)>=2";
		}
		
		if($data['starttime'] != '')            //��ʼʱ��
		{
			$sqlstr = $sqlstr . " AND c.jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //����ʱ��
		{ 
			//$sqlstr = $sqlstr . " AND jgsj<to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
			$sqlstr = $sqlstr . " AND c.jgsj < to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
		}
		
		if ($offset >= 0 AND $row_count > 0)
	    {
			$max_count = $row_count+$offset;
			
			$query = $this->ora_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime FROM (SELECT A.*, ROWNUM RN FROM (SELECT c.* FROM cltx c where 1=1 " . $sqlstr . " order by jgsj desc) A WHERE ROWNUM <= $max_count)t WHERE RN > $offset" );
		}
		elseif($offset == -1)
		{
			$query = $this->ora_db->query("SELECT c.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime FROM cltx c where 1=1 " . $sqlstr . " order by jgsj desc");
		}
		else
		{
			//���ز�ѯ�������
			$query = $this->ora_db->query("select count(1) as sum  from cltx c where 1=1 " . $sqlstr);
		}
		
		return $query;		
	}
		
	//����ID�Ż�ȡ���ں�
	function get_openkakou_by_id($role_id)
	{
		$this->db->get();
	}

	//����ID��ȡ������Ϣ
	function get_car_by_id($id)
	{
		return $this->ora_db->query("SELECT t.*,c.*,to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime from cltx t left join cfg_kakou c on t.kkbh=c.kk_id where t.ID='$id'");
	}
	
	//����ID��ȡ������Ϣ
	function get_car_by_id2($id)
	{
		return $this->ora_db->query("SELECT t.* , to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime from cltx t where ID='$id'");
	}
	
	//����ID�޸ĳ�����Ϣ
	function edit_car_by_id($id, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		return $this->ora_db->query("update cltx set hphm='$data[carnum]',hpys='$data[color]',hdgg='T' where id='$id'");
	}
	//����ID�޸Ĵ�������Ϣ
	function handle_by_id($id, $data)
	{
		return $this->ora_db->query("update cltx set CFBM='$data[dispose]',MEMO='$data[jyqk]',CFSJ='$data[cfsj]',FKBM='$data[user]' where id=$id");
	}
	
	function check_car_by_id($id,$data)
	{
		
	}
	
	//����IDɾ��������Ϣ
	function del_car_by_id($id)
	{
		return $this->ora_db->query("delete from cltx where id='$id'");
	}
	
	function get_bcxw($carnum)
	{
		return $this->ora_db->query("select t.hphm,t.bcxw from bkcp t where hphm ='$carnum' and clbj='T'");
	}


}
?>
