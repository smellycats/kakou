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
			//返回查询结果行数
			$query = $this->ora_db->query("select count(1) as sum  from cltx");
		}

		return $query;
		
	}
	
	//根据条件获取车辆信息
	function get_car_by_condition($offset = 0, $row_count = 0, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		$sqlstr = '';
		
		if($data['okkval'] != '')   //监控点
		{
			$sqlstr = $sqlstr . " AND KKBH IN ($data[okkval])";
		}
		if ($data['lane'] != '')      //车道编号
		{
			if($data['lane'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND CDBH='$data[lane]'";
			}
		}
		if ($data['direction'] != '')  //方向
		{
			if($data['direction'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND FXBH='$data[direction]'";
			}
		}
		if ($data['color'] != '')      //颜色
		{
			if($data['color'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND HPYS='$data[color]'";
			}
		}
		
		if($data['spcarnum'] != '')    //特殊车牌
		{
			$sqlstr = $sqlstr . " AND HPHM in ($data[spcarnum])";
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
		
		if($data['starttime'] != '')            //开始时间
		{
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //结束时间
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
			//返回查询结果行数
			$query = $this->ora_db->query("select count(1) as sum  from cltx where 1=1 " . $sqlstr);
		}
		
		return $query;
		
		//echo $this->db->last_query();
	}
	
	//根据条件获取违章车辆信息
	function get_breakrule_by_condition($offset = 0, $row_count = 0, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		$sqlstr = '';
		
		if($data['okkval'] != '')   //监控点
		{
			$sqlstr = $sqlstr . " AND KKBH IN ($data[okkval])";
		}
		if ($data['record'] != '')      //记录状态
		{
			if($data['record'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['record'] == '已核对')
			{
				$sqlstr = $sqlstr . " AND HDGG='T'";
			}
			elseif($data['record'] == '已审核')
			{
				$sqlstr = $sqlstr . " AND QBGG='T'";
			}
			elseif($data['record'] == '已处罚')
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
			elseif($data['breakrule'] == '超速')
			{
				$sqlstr = $sqlstr . " AND CLBJ='O'";
			}
			elseif($data['breakrule'] == '逆行')
			{
				$sqlstr = $sqlstr . " AND (CLBJ='N')";
			}
			elseif($data['breakrule'] == '闯红灯')
			{
				$sqlstr = $sqlstr . " AND (JLLX='2' OR JLLX='3')";
			}
			elseif($data['breakrule'] == '不按车道行驶')
			{
				$sqlstr = $sqlstr . " AND JLLX='4'";
			}
			else
			{
				$sqlstr = $sqlstr;
			}
		}
		if ($data['color'] != '')      //颜色
		{
			if($data['color'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND HPYS='$data[color]'";
			}
		}
		

        //车牌号码
	    if(strlen($data['carnum'])>=1 AND $data['number'] != '-' AND $data['number'] != 'R')  
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
		
		if($data['starttime'] != '')            //开始时间
		{
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //结束时间
		{ 
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
		}
		
		if($data['minspeed'] != '')            //最小速度
		{
			$sqlstr = $sqlstr . " AND CLSD >= '$data[minspeed]'";
		}
		if($data['maxspeed'] != '')              //最大速度
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
			//返回查询结果行数
			$query = $this->ora_db->query("select count(1) as sum  from cltx where 1=1 " . $sqlstr);
		}
		
		return $query;
	}
	
	//根据条件获取报警车辆信息
	function get_alarmcar_by_condition($offset = 0, $row_count = 0, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		$sqlstr = '';
		
		if($data['okkval'] != '')   //监控点
		{
			$sqlstr = $sqlstr . " AND c.KKBH IN ($data[okkval])";
		}
	    	
		if($data['alarmtype'] != '')    //报警类型
		{
			if($data['alarmtype'] == '被盗抢车辆')
			{
				$sqlstr = $sqlstr . " AND c.CLBJ='D'";
			}
			elseif($data['alarmtype'] == '套牌车辆')
			{
				$sqlstr = $sqlstr . " AND c.CLBJ='T'";
			}
			elseif($data['alarmtype'] == '便衣嫌疑车辆')
			{
				$sqlstr = $sqlstr . " AND c.CLBJ='S'";
			}
			elseif($data['alarmtype'] == '布控车辆')
			{
				$sqlstr = $sqlstr . " AND c.CLBJ='B'";
			}
			else
			{
				$sqlstr = $sqlstr . "AND (c.CLBJ='D' OR c.CLBJ='T' OR c.CLBJ='S' OR c.CLBJ='B')";
			}
		}
		//案情处理	
		if($data['dispose'] != '')
		{
			if($data['dispose'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['dispose'] == '警情未处理')
			{
				$sqlstr = $sqlstr . " AND (c.CFBM='' or c.CFBM is null) ";
			}
			elseif($data['dispose'] == '车牌号码识别错误')
			{
				$sqlstr = $sqlstr . " AND (c.CFBM='$data[dispose]' OR c.CFBM='号码识别错误' OR c.CFBM='识别错误')";
			}
			elseif($data['dispose'] == '车牌颜色识别错误')
			{
				$sqlstr = $sqlstr . " AND (c.CFBM='$data[dispose]' OR c.CFBM='颜色识别错误')";
			}
			elseif($data['dispose'] == '与黑名单数据不符')
			{
				$sqlstr = $sqlstr . " AND (c.CFBM='$data[dispose]' OR c.CFBM='比对数据错')";
			}
			else
			{
				$sqlstr = $sqlstr . " AND c.CFBM='$data[dispose]'";
			}
		}	
		if ($data['color'] != '')      //颜色
		{
			if($data['color'] == 'all')
			{
				$sqlstr = $sqlstr;
			}else
			{
				$sqlstr = $sqlstr . " AND c.HPYS='$data[color]'";
			}
		}
		
        //车牌号码
	    if(strlen($data['carnum'])>=1 AND $data['number'] != '-' AND $data['number'] != 'R')  
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
		
		if($data['starttime'] != '')            //开始时间
		{
			$sqlstr = $sqlstr . " AND c.jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //结束时间
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
			//返回查询结果行数
			$query = $this->ora_db->query("select count(1) as sum  from cltx c where 1=1 " . $sqlstr);
		}
		
		return $query;		
	}
		
	//根据ID号获取卡口号
	function get_openkakou_by_id($role_id)
	{
		$this->db->get();
	}

	//根据ID获取车辆信息
	function get_car_by_id($id)
	{
		return $this->ora_db->query("SELECT t.*,c.*,to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime from cltx t left join cfg_kakou c on t.kkbh=c.kk_id where t.ID='$id'");
	}
	
	//根据ID获取车辆信息
	function get_car_by_id2($id)
	{
		return $this->ora_db->query("SELECT t.* , to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime from cltx t where ID='$id'");
	}
	
	//根据ID修改车辆信息
	function edit_car_by_id($id, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		return $this->ora_db->query("update cltx set hphm='$data[carnum]',hpys='$data[color]',hdgg='T' where id='$id'");
	}
	//根据ID修改处理结果信息
	function handle_by_id($id, $data)
	{
		return $this->ora_db->query("update cltx set CFBM='$data[dispose]',MEMO='$data[jyqk]',CFSJ='$data[cfsj]',FKBM='$data[user]' where id=$id");
	}
	
	function check_car_by_id($id,$data)
	{
		
	}
	
	//根据ID删除车辆信息
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
