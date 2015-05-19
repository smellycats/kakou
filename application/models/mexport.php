<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mexport extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}
	
	//����������ȡ������Ϣ
	function get_carinfo($offset = 0, $row_count = 0, $data)
	{
		$data['carnum'] = trim(strtoupper($data['carnum']));
		
		$sqlstr = '';
		
		if ($data['okkval'] == '') {                            //��ص�-must
			$sqlstr = $sqlstr . " AND KKBH IN ('null')";
		}else {
			$sqlstr = $sqlstr . " AND KKBH IN ($data[okkval])";
		}
		
		if (isset($data['lane'])) {  //�������
			switch ($data['lane']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CDBH='$data[lane]'";
					break;
			}
		}
		
		if (isset($data['direction'])) {                        //����
			switch ($data['direction']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND FXBH='$data[direction]'";
					break;
			}
		}

		if (isset($data['color'])) {        //������ɫ-must
			switch ($data['color']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPYS='$data[color]'";
					break;
			}
		}
	
		if (isset($data['spcarnum'])) {      //���⳵�ƺ� 
			switch ($data['spcarnum']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPHM in ($data[spcarnum])";
					break;
			}
		}
		
		if (isset($data['record'])) {                                     //��¼״̬
			switch ($data['record']) {
				case 'all':
					break;
				case '�Ѻ˶�':
					$sqlstr = $sqlstr . " AND HDGG='T'";
					break;
				case '�����':
					$sqlstr = $sqlstr . " AND QBGG='T'";
					break;
				case '�Ѵ���':
					$sqlstr = $sqlstr . " AND CFGG='T'";
					break;
				default:
					$sqlstr = $sqlstr;
					break;					
			}
		}
		
		if(isset($data['breakrule'])) {                                 //Υ������
			switch ($data['breakrule']) {
				case 'all':
					$sqlstr = $sqlstr . " AND (CLBJ='O' OR JLLX='2' OR JLLX='3' OR JLLX='4')";
					break;
				case '����':
					$sqlstr = $sqlstr . " AND CLBJ='O'";
					break;
				case '����':
					$sqlstr = $sqlstr . " AND (CLBJ='N')";
					break;
				case '�����':
					$sqlstr = $sqlstr . " AND (JLLX='2' OR JLLX='3')";
					break;
				case '����������ʻ':
					$sqlstr = $sqlstr . " AND JLLX='4'";
					break;
				default:
					$sqlstr = $sqlstr;
					break;
			}
		}
		
		if(isset($data['alarmtype'])) {                          //��������
			switch ($data['alarmtype']) {
				case '����������':
					$sqlstr = $sqlstr . " AND CLBJ='D'";
					break;
				case '���Ƴ���':
					$sqlstr = $sqlstr . " AND CLBJ='T'";
					break;
				case '�������ɳ���':
					$sqlstr = $sqlstr . " AND CLBJ='S'";
					break;
				case '���س���':
					$sqlstr = $sqlstr . " AND CLBJ='B'";
					break;
				case 'all':
					$sqlstr = $sqlstr . "AND CLBJ<>'F' AND CLBJ<>'O' AND CLBJ<>'N'";
					break;
				default:
					$sqlstr = $sqlstr;
					break;
			}
		}
			
		if (isset($data['dispose'])) {     //���鴦��
			switch ($data['dispose']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				case '����δ����':
					$sqlstr = $sqlstr . " AND (CFBM='' or CFBM is null) ";
					break;
				case '���ƺ���ʶ�����':
					$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='����ʶ�����' OR CFBM='ʶ�����')";
					break;
				case '������ɫʶ�����':
					$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='��ɫʶ�����')";
					break;
				case '����������ݲ���':
					$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='�ȶ����ݴ�')";
					break;
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CFBM='$data[dispose]'";
					break;
			}
		}	
		
		if(isset($data['minspeed'])) {            //��С�ٶ�
			switch ($data['minspeed']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CLSD >= '$data[minspeed]'";
					break;
			}
			//$sqlstr = $sqlstr . " AND CLSD >= '$data[minspeed]'";
		}
		if(isset($data['maxspeed'])) {            //����ٶ�
			switch ($data['maxspeed']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CLSD <= '$data[maxspeed]'";
					break;
			}
			//$sqlstr = $sqlstr . " AND CLSD <= '$data[maxspeed]'";
		}
		
		if(isset($data['starttime'])) {           //��ʼʱ��
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if(isset($data['starttime'])) {           //����ʱ��
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
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
		
		//var_dump($this->db->last_query());
	}
	
	function set_cfg_session($offset = 0, $row_count = 1000, $data)
	{
		//����������ȡ������Ϣ
		$data['carnum'] = trim(strtoupper($data['carnum']));
		
		$sqlstr = '';
		
		if ($data['okkval'] == '') {                            //��ص�-must
			$sqlstr = $sqlstr . " AND KKBH IN (''null'')";
		}
		else {
			$sqlstr = $sqlstr . " AND KKBH IN ($data[okkval])";
		}
		
		if (isset($data['lane'])) {                            //�������
			switch ($data['lane']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CDBH=''$data[lane]''";
					break;
			}
		}
		
		if (isset($data['direction'])) {                        //����
			switch ($data['direction']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND FXBH=''$data[direction]''";
					break;
			}
		}

		if (isset($data['color'])) {        //������ɫ-must
			switch ($data['color']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPYS=''$data[color]''";
					break;
			}
		}
	
		if (isset($data['spcarnum'])) {      //���⳵�ƺ� 
			switch ($data['spcarnum']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPHM in ($data[spcarnum])";
					break;
			}
		}
		
		if (isset($data['record'])) {                                     //��¼״̬
			switch ($data['record']) {
				case 'all':
					break;
				case '�Ѻ˶�':
					$sqlstr = $sqlstr . " AND HDGG=''T''";
					break;
				case '�����':
					$sqlstr = $sqlstr . " AND QBGG=''T''";
					break;
				case '�Ѵ���':
					$sqlstr = $sqlstr . " AND CFGG=''T''";
					break;
				default:
					$sqlstr = $sqlstr;
					break;					
			}
		}
		
		if(isset($data['breakrule'])) {                                 //Υ������
			switch ($data['breakrule']) {
				case 'all':
					$sqlstr = $sqlstr . " AND (CLBJ=''O'' OR JLLX=''2'' OR JLLX=''3'' OR JLLX=''4'')";
					break;
				case '����':
					$sqlstr = $sqlstr . " AND CLBJ=''O''";
					break;
				case '����':
					$sqlstr = $sqlstr . " AND (CLBJ=''N'')";
					break;
				case '�����':
					$sqlstr = $sqlstr . " AND (JLLX=''2'' OR JLLX=''3'')";
					break;
				case '����������ʻ':
					$sqlstr = $sqlstr . " AND JLLX=''4''";
					break;
				default:
					$sqlstr = $sqlstr;
					break;
			}
		}
		
		if(isset($data['alarmtype'])) {                          //��������
			switch ($data['alarmtype']) {
				case '����������':
					$sqlstr = $sqlstr . " AND CLBJ=''D''";
					break;
				case '���Ƴ���':
					$sqlstr = $sqlstr . " AND CLBJ=''T''";
					break;
				case '�������ɳ���':
					$sqlstr = $sqlstr . " AND CLBJ=''S''";
					break;
				case '���س���':
					$sqlstr = $sqlstr . " AND CLBJ=''B''";
					break;
				case 'all':
					$sqlstr = $sqlstr . "AND CLBJ<>''F'' AND CLBJ<>''O'' AND CLBJ<>''N''";
					break;
				default:
					$sqlstr = $sqlstr;
					break;
			}
		}
			
		if (isset($data['dispose'])) {     //���鴦��
			switch ($data['dispose']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				case '����δ����':
					$sqlstr = $sqlstr . " AND (CFBM='''' or CFBM is null) ";
					break;
				case '���ƺ���ʶ�����':
					$sqlstr = $sqlstr . " AND (CFBM=''$data[dispose]'' OR CFBM=''����ʶ�����'' OR CFBM=''ʶ�����'')";
					break;
				case '������ɫʶ�����':
					$sqlstr = $sqlstr . " AND (CFBM=''$data[dispose]'' OR CFBM=''��ɫʶ�����'')";
					break;
				case '����������ݲ���':
					$sqlstr = $sqlstr . " AND (CFBM=''$data[dispose]'' OR CFBM=''�ȶ����ݴ�'')";
					break;
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CFBM=''$data[dispose]''";
					break;
			}
		}	
		
		if(isset($data['minspeed'])) {            //��С�ٶ�
			switch ($data['minspeed']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CLSD >= ''$data[minspeed]''";
					break;
			}
			//$sqlstr = $sqlstr . " AND CLSD >= '$data[minspeed]'";
		}
		if(isset($data['maxspeed'])) {            //����ٶ�
			switch ($data['maxspeed']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CLSD <= ''$data[maxspeed]''";
					break;
			}
			//$sqlstr = $sqlstr . " AND CLSD <= '$data[maxspeed]'";
		}
		
		if(isset($data['starttime'])) {           //��ʼʱ��
			$sqlstr = $sqlstr . " AND jgsj>to_date(''$data[starttime]'',''yyyy-mm-dd hh24:mi:ss'')";
		}
		if(isset($data['starttime'])) {           //����ʱ��
			$sqlstr = $sqlstr . " AND jgsj < to_date(''$data[endtime]'',''yyyy-mm-dd hh24:mi:ss'')";
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
            
            $sqlstr = $sqlstr . " AND HPHM LIKE ''$carnum''";
        }
        elseif($data['carnum'] == '' AND $data['number'] == '?')
        {
        	$sqlstr = $sqlstr;
        }
        elseif($data['carnum'] == '' AND $data['number'] != '-' AND $data['number'] != 'R')
        {
        	$sqlstr = $sqlstr . " AND HPHM LIKE ''$data[number]%''";
        }
        elseif($data['number'] == '-')       
		{
			$sqlstr = $sqlstr . " AND (HPHM='''' OR HPHM=''-'')";
		}
		elseif($data['number'] == 'R')
		{
			$sqlstr = $sqlstr . " and length(hphm)>=2";
		}
		
		if ($offset >= 0 AND $row_count > 0)
	    {
			$max_count = $row_count+$offset;
			
			$sqlstring = "SELECT t.* FROM (SELECT A.*, ROWNUM RN FROM (SELECT * FROM cltx where 1=1 " . $sqlstr . " order by jgsj desc) A WHERE ROWNUM <= $max_count)t WHERE RN > $offset";
		}
		
		$server = $this->_get_cfg_kakou()->result();
		$c = 1;
		$this->db->trans_start();
		foreach ($server as $s)
		{
			$num = $data['work_id'].strval($c);
			#var_dump("insert into cfg_session (s_id,s_start_time,s_timeout,s_account_name,work_id,work_type,work_content,work_finished,work_server,work_is_proc) values('$data[time]',2,'$data[user]',$num,'expima',$sqlstring,0,$s,0");
			$this->ora_db->query("insert into cfg_session (s_id,s_start_time,s_timeout,s_account_name,work_id,work_type,work_content,work_finished,work_server,work_is_proc) values('$data[sid]',to_date('$data[time]','yyyy-mm-dd hh24:mi:ss'),2,'$data[user]','$num','expima','$sqlstring',0,'$s->IP',0)");
			$c += 1;
		}
		$this->db->trans_complete();
		
	}
	
	function get_cfg_session($data)
	{
		return $this->ora_db->query("select * from cfg_session where s_start_time = to_date('$data[time]','yyyy-mm-dd hh24:mi:ss') and s_account_name='$data[user]'");
	}
	
	function _get_cfg_kakou()
	{
		return $this->ora_db->query("select distinct kk_image_server as ip from cfg_kakou");
	}
	
}