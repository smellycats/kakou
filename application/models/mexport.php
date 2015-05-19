<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mexport extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}
	
	//根据条件获取车辆信息
	function get_carinfo($offset = 0, $row_count = 0, $data)
	{
		$data['carnum'] = trim(strtoupper($data['carnum']));
		
		$sqlstr = '';
		
		if ($data['okkval'] == '') {                            //监控点-must
			$sqlstr = $sqlstr . " AND KKBH IN ('null')";
		}else {
			$sqlstr = $sqlstr . " AND KKBH IN ($data[okkval])";
		}
		
		if (isset($data['lane'])) {  //车道编号
			switch ($data['lane']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CDBH='$data[lane]'";
					break;
			}
		}
		
		if (isset($data['direction'])) {                        //方向
			switch ($data['direction']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND FXBH='$data[direction]'";
					break;
			}
		}

		if (isset($data['color'])) {        //车牌颜色-must
			switch ($data['color']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPYS='$data[color]'";
					break;
			}
		}
	
		if (isset($data['spcarnum'])) {      //特殊车牌号 
			switch ($data['spcarnum']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPHM in ($data[spcarnum])";
					break;
			}
		}
		
		if (isset($data['record'])) {                                     //记录状态
			switch ($data['record']) {
				case 'all':
					break;
				case '已核对':
					$sqlstr = $sqlstr . " AND HDGG='T'";
					break;
				case '已审核':
					$sqlstr = $sqlstr . " AND QBGG='T'";
					break;
				case '已处罚':
					$sqlstr = $sqlstr . " AND CFGG='T'";
					break;
				default:
					$sqlstr = $sqlstr;
					break;					
			}
		}
		
		if(isset($data['breakrule'])) {                                 //违法类型
			switch ($data['breakrule']) {
				case 'all':
					$sqlstr = $sqlstr . " AND (CLBJ='O' OR JLLX='2' OR JLLX='3' OR JLLX='4')";
					break;
				case '超速':
					$sqlstr = $sqlstr . " AND CLBJ='O'";
					break;
				case '逆行':
					$sqlstr = $sqlstr . " AND (CLBJ='N')";
					break;
				case '闯红灯':
					$sqlstr = $sqlstr . " AND (JLLX='2' OR JLLX='3')";
					break;
				case '不按车道行驶':
					$sqlstr = $sqlstr . " AND JLLX='4'";
					break;
				default:
					$sqlstr = $sqlstr;
					break;
			}
		}
		
		if(isset($data['alarmtype'])) {                          //报警类型
			switch ($data['alarmtype']) {
				case '被盗抢车辆':
					$sqlstr = $sqlstr . " AND CLBJ='D'";
					break;
				case '套牌车辆':
					$sqlstr = $sqlstr . " AND CLBJ='T'";
					break;
				case '便衣嫌疑车辆':
					$sqlstr = $sqlstr . " AND CLBJ='S'";
					break;
				case '布控车辆':
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
			
		if (isset($data['dispose'])) {     //案情处理
			switch ($data['dispose']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				case '警情未处理':
					$sqlstr = $sqlstr . " AND (CFBM='' or CFBM is null) ";
					break;
				case '车牌号码识别错误':
					$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='号码识别错误' OR CFBM='识别错误')";
					break;
				case '车牌颜色识别错误':
					$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='颜色识别错误')";
					break;
				case '与黑名单数据不符':
					$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='比对数据错')";
					break;
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CFBM='$data[dispose]'";
					break;
			}
		}	
		
		if(isset($data['minspeed'])) {            //最小速度
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
		if(isset($data['maxspeed'])) {            //最大速度
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
		
		if(isset($data['starttime'])) {           //开始时间
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if(isset($data['starttime'])) {           //结束时间
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
		}
		
        //车牌号码
		elseif(strlen($data['carnum'])>=1 AND $data['number'] != '-' AND $data['number'] != 'R')  
        {
        	$data['number'] = str_replace('?', '%', $data['number']);
        	$data['number'] = str_replace('？', '%', $data['number']);
        	$data['number'] = str_replace('R', '%', $data['number']);
        	$data['carnum'] = str_replace('*', '%', $data['carnum']);
            $data['carnum'] = str_replace('?', '_', $data['carnum']);
            $data['carnum'] = str_replace('？', '_', $data['carnum']);
            
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
			//返回查询结果行数
			$query = $this->ora_db->query("select count(1) as sum  from cltx where 1=1 " . $sqlstr);
		}
		
		return $query;
		
		//var_dump($this->db->last_query());
	}
	
	function set_cfg_session($offset = 0, $row_count = 1000, $data)
	{
		//根据条件获取车辆信息
		$data['carnum'] = trim(strtoupper($data['carnum']));
		
		$sqlstr = '';
		
		if ($data['okkval'] == '') {                            //监控点-must
			$sqlstr = $sqlstr . " AND KKBH IN (''null'')";
		}
		else {
			$sqlstr = $sqlstr . " AND KKBH IN ($data[okkval])";
		}
		
		if (isset($data['lane'])) {                            //车道编号
			switch ($data['lane']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CDBH=''$data[lane]''";
					break;
			}
		}
		
		if (isset($data['direction'])) {                        //方向
			switch ($data['direction']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND FXBH=''$data[direction]''";
					break;
			}
		}

		if (isset($data['color'])) {        //车牌颜色-must
			switch ($data['color']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPYS=''$data[color]''";
					break;
			}
		}
	
		if (isset($data['spcarnum'])) {      //特殊车牌号 
			switch ($data['spcarnum']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPHM in ($data[spcarnum])";
					break;
			}
		}
		
		if (isset($data['record'])) {                                     //记录状态
			switch ($data['record']) {
				case 'all':
					break;
				case '已核对':
					$sqlstr = $sqlstr . " AND HDGG=''T''";
					break;
				case '已审核':
					$sqlstr = $sqlstr . " AND QBGG=''T''";
					break;
				case '已处罚':
					$sqlstr = $sqlstr . " AND CFGG=''T''";
					break;
				default:
					$sqlstr = $sqlstr;
					break;					
			}
		}
		
		if(isset($data['breakrule'])) {                                 //违法类型
			switch ($data['breakrule']) {
				case 'all':
					$sqlstr = $sqlstr . " AND (CLBJ=''O'' OR JLLX=''2'' OR JLLX=''3'' OR JLLX=''4'')";
					break;
				case '超速':
					$sqlstr = $sqlstr . " AND CLBJ=''O''";
					break;
				case '逆行':
					$sqlstr = $sqlstr . " AND (CLBJ=''N'')";
					break;
				case '闯红灯':
					$sqlstr = $sqlstr . " AND (JLLX=''2'' OR JLLX=''3'')";
					break;
				case '不按车道行驶':
					$sqlstr = $sqlstr . " AND JLLX=''4''";
					break;
				default:
					$sqlstr = $sqlstr;
					break;
			}
		}
		
		if(isset($data['alarmtype'])) {                          //报警类型
			switch ($data['alarmtype']) {
				case '被盗抢车辆':
					$sqlstr = $sqlstr . " AND CLBJ=''D''";
					break;
				case '套牌车辆':
					$sqlstr = $sqlstr . " AND CLBJ=''T''";
					break;
				case '便衣嫌疑车辆':
					$sqlstr = $sqlstr . " AND CLBJ=''S''";
					break;
				case '布控车辆':
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
			
		if (isset($data['dispose'])) {     //案情处理
			switch ($data['dispose']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				case '警情未处理':
					$sqlstr = $sqlstr . " AND (CFBM='''' or CFBM is null) ";
					break;
				case '车牌号码识别错误':
					$sqlstr = $sqlstr . " AND (CFBM=''$data[dispose]'' OR CFBM=''号码识别错误'' OR CFBM=''识别错误'')";
					break;
				case '车牌颜色识别错误':
					$sqlstr = $sqlstr . " AND (CFBM=''$data[dispose]'' OR CFBM=''颜色识别错误'')";
					break;
				case '与黑名单数据不符':
					$sqlstr = $sqlstr . " AND (CFBM=''$data[dispose]'' OR CFBM=''比对数据错'')";
					break;
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CFBM=''$data[dispose]''";
					break;
			}
		}	
		
		if(isset($data['minspeed'])) {            //最小速度
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
		if(isset($data['maxspeed'])) {            //最大速度
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
		
		if(isset($data['starttime'])) {           //开始时间
			$sqlstr = $sqlstr . " AND jgsj>to_date(''$data[starttime]'',''yyyy-mm-dd hh24:mi:ss'')";
		}
		if(isset($data['starttime'])) {           //结束时间
			$sqlstr = $sqlstr . " AND jgsj < to_date(''$data[endtime]'',''yyyy-mm-dd hh24:mi:ss'')";
		}
		
        //车牌号码
		elseif(strlen($data['carnum'])>=1 AND $data['number'] != '-' AND $data['number'] != 'R')  
        {
        	$data['number'] = str_replace('?', '%', $data['number']);
        	$data['number'] = str_replace('？', '%', $data['number']);
        	$data['number'] = str_replace('R', '%', $data['number']);
        	$data['carnum'] = str_replace('*', '%', $data['carnum']);
            $data['carnum'] = str_replace('?', '_', $data['carnum']);
            $data['carnum'] = str_replace('？', '_', $data['carnum']);
            
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