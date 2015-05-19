<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * ���������� ģ��
  * 
  *
  */

class Mbmenu extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}
	
	//��ȡ���в�����Ϣ
	function get_bk_all()
	{
		return $this->ora_db->query("select * from BKCP");
	}
	
	//��鳵�ƺ����Ƿ�Ψһ
	function check_carnum_unique($id,$carnum)
	{
		$carnum = strtoupper($carnum);
		
		return $this->ora_db->query("select * from BKCP where HPHM='$carnum' and id != '$id'");
	}

	//���ݳ��ƺ����ѯ������Ϣ
	function get_bkcp_by_num($data)
	{
		$sqlstr = '';
		
		if($data['color'] != '')
		{
			$sqlstr = $sqlstr . " ADN HPYS='$data[color]'";
		}
		return $this->ora_db->query("select * from BKCP where HPHM='$data[carnum]'" . $sqlstr);
	}
	
	//����ID��ѯ������Ϣ
	function get_bkcp_by_id($id)
	{
		return $this->ora_db->query("select t.*,to_char(bclen, 'yyyy-mm-dd hh24:mi:ss')as starttime,bcsj as cktime from bkcp t where ID='$id'");
	}
	
	//����ID��ѯ������Ϣ
	function get_bkcp_by_id2($id)
	{
		return $this->ora_db->query("select ID,hphm,hpys,cllx,lxman,lxdh,memo,bcdw,bcxw,bcsj,CLBJ,CKBJ,lk,mobiles,cityname,bkdw,sjh,bklx,bclen as starttime,to_char(bcsj, 'yyyy-mm-dd hh24:mi:ss')as cktime,cltp1,cltp2,cltp3 from BKCP where ID='$id'");
	}
	
	//��Ӳ�����Ϣ
	function add_bkcp($data)
	{
	    $data['carnum'] = strtoupper($data['carnum']);
	    
        return $this->ora_db->query("Insert Into BKCP(ID,hphm,hpys,cllx,lxman,lxdh,memo,bcdw,bcxw,bcsj,CLBJ,CKBJ,lk,cityname,bkdw,sjh,bklx,bclen,mobiles)Values(bkcp_id.nextval,'$data[carnum]','$data[color]','$data[cartype]','$data[linkman]','$data[telnum]','$data[memo]','$data[user]','$data[reason]','$data[bkdate]','T','F','$data[lsbk]','','$data[bkdepartment]','$data[mobnum]','','','$data[mobiles]')");
	}
	
	//����IDɾ��������Ϣ
	function del_bkcp($id)
	{
		return $this->ora_db->query("DELETE FROM BKCP WHERE ID='$id'");
	}
	
	//����
	function edit_bkcp_ck($id, $data)
	{
		return $this->ora_db->query("update BKCP set CKBJ='T',CKYY='$data[ckreason]',bcsj='$data[date]' WHERE ID='$id'");
	}
	
	//�������
	function edit_bkcp_cksh($id, $data)
	{
		return $this->ora_db->query("update BKCP set CLBJ='F',CKBJ='F',SHMAN='$data[user]' WHERE id='$id'");
	}
	
	//����
	function edit_bkcp_bk($id, $data)
	{
		return $this->ora_db->query("update BKCP set CLBJ='T',SHMAN='$data[user]' WHERE id='$id'");
	}
	
	//����ID�༭������Ϣ
	function edit_bk_info($id, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
        return $this->ora_db->query("UPDATE BKCP SET hphm='$data[carnum]', hpys='$data[color]', cllx='$data[cartype]', lxman='$data[linkman]', lxdh='$data[telnum]', memo='$data[memo]', bcxw='$data[reason]', sjh='$data[mobnum]', lk='$data[lsbk]', mobiles='$data[mobiles]', bclen=to_date('$data[bclen]','yyyy-mm-dd hh24:mi:ss') WHERE ID='$id'");
	}
	
	//����������ѯ������Ϣ
	function search_bk($data)
	{	
		$data['carnum'] = strtoupper($data['carnum']);
		
		$sqlstr = "select * from BKCP where 1=1 ";
		
		if($data['carnum'] == '' && $data['bkr'] == '' && $data['reason'] == '��ѡ��' && $data['state'] == '��ѡ��')
		{
			$sqlstr = $sqlstr;
		}
		else if($data['carnum'] != '' && strlen($data['carnum'])<=2)
		{
			$sqlstr = $sqlstr . " and hphm like '$data[carnum]'";
		}
		else if(strlen($data['carnum'])>2)
		{
			$sqlstr = $sqlstr . " and hphm like '%$data[carnum]%'";
		}
		else if($data['bkr'] != '')
		{
			$sqlstr = $sqlstr . " and bcdw ='$data[bkr]'";
		}
		else if($data['reason'] != '��ѡ��')
		{
			$sqlstr = $sqlstr . " and bcxw ='$data[reason]'";;
		}
		else if($data['state'] == '�����')
		{
			$sqlstr = $sqlstr . " and (CLBJ='T' AND CKBJ='T')";
		}
		else if($data['state'] == '�Ѳ���')
		{
			$sqlstr = $sqlstr . " and (CLBJ='T' AND CKBJ='F')";
		}
		else if($data['state'] == '�ѳ���')
		{
			$sqlstr = $sqlstr . " and CLBJ ='F'";
		}
		
		$sqlstr = $sqlstr . " ORDER BY CLBJ DESC,BCSJ DESC";
		
        return $this->ora_db->query($sqlstr);
	}

	//����������ȡ������Ϣ
	function search_bk2($offset = 0, $row_count = 0, $data)
	{
		$upper_carnumber = strtoupper($data['carnum']);
		
		$sqlstr = '';

		if($data['carnum'] == '' && $data['bkr'] == '' && $data['reason'] == '��ѡ��' && $data['state'] == '��ѡ��')
		{
			$sqlstr = $sqlstr;
		}
		
		if($data['carnum'] != '' && strlen($data['carnum'])<=2)
		{
			$sqlstr = $sqlstr . " and hphm like '$data[carnum]' or hphm like '$upper_carnumber'";
		}
		else if(strlen($data['carnum'])>2)
		{
			$sqlstr = $sqlstr . " and hphm like '%$data[carnum]%' or hphm like '%$upper_carnumber%'";
		}
		
		if($data['bkr'] != '')
		{
			$sqlstr = $sqlstr . " and bcdw ='$data[bkr]'";
		}
		
		if($data['reason'] != '��ѡ��')
		{
			$sqlstr = $sqlstr . " and bcxw ='$data[reason]'";;
		}
		
		if($data['state'] == '�����')
		{
			$sqlstr = $sqlstr . " and (CLBJ='T' AND CKBJ='T')";
		}
		else if($data['state'] == '�Ѳ���')
		{
			$sqlstr = $sqlstr . " and (CLBJ='T' AND CKBJ='F')";
		}
		else if($data['state'] == '�ѳ���')
		{
			$sqlstr = $sqlstr . " and CLBJ ='F'";
		}
		
		if ($offset >= 0 AND $row_count > 0)
	    {
			$max_count = $row_count+$offset;
			
			$query = $this->ora_db->query("SELECT t.* FROM (SELECT A.*, ROWNUM RN FROM (select * from BKCP where 1=1" . $sqlstr . " ORDER BY CLBJ DESC,BCSJ DESC) A WHERE ROWNUM <= $max_count)t WHERE RN > $offset" );
		}
		else
		{
			//���ز�ѯ�������
			$query = $this->ora_db->query("select count(1) as sum  from BKCP where 1=1 " . $sqlstr);
		}
		
		return $query;

	}
	
}
?>