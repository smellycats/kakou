<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mstat extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}

	//根据条件查询车辆流量 
	function get_carflow_by_condition($data)
	{
		$sqlstr = '';
		//监控地点
		if($data['place'] != 'all')
		{
			$sqlstr = $sqlstr . " AND KKBH ='$data[place]'";
		}
		//方向
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
		//车辆类型
		if ($data['cartype'] != '')
		{
			if($data['cartype'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['cartype'] == '大车')
			{
				$sqlstr = $sqlstr . " AND HPYS='黄牌'";
			}
			elseif($data['cartype'] == '小车')
			{
				$sqlstr = $sqlstr . " AND HPYS='蓝牌'";
			}
			elseif($data['cartype'] == '其他')
			{
				$sqlstr = $sqlstr . " AND HPYS!='黄牌' AND HPYS!='蓝牌'";
			}
		}
		
		//违法类型
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
		}
		
		//报警类型	
		if($data['alarmtype'] != '')
		{
			if($data['alarmtype'] == '被盗抢车辆')
			{
				$sqlstr = $sqlstr . " AND CLBJ='D'";
			}
			elseif($data['alarmtype'] == '套牌车辆')
			{
				$sqlstr = $sqlstr . " AND CLBJ='T'";
			}
			elseif($data['alarmtype'] == '便衣嫌疑车辆')
			{
				$sqlstr = $sqlstr . " AND CLBJ='S'";
			}
			elseif($data['alarmtype'] == '布控车辆')
			{
				$sqlstr = $sqlstr . " AND CLBJ='B'";
			}
			else
			{
				$sqlstr = $sqlstr . "AND CLBJ<>'F' AND CLBJ<>'O'";
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
				$sqlstr = $sqlstr . " AND (CFBM='' or CFBM is null) ";
			}
			elseif($data['dispose'] == '车牌号码识别错误')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='号码识别错误' OR CFBM='识别错误')";
			}
			elseif($data['dispose'] == '车牌颜色识别错误')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='颜色识别错误')";
			}
			elseif($data['dispose'] == '与黑名单数据不符')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='比对数据错')";
			}
			else
			{
				$sqlstr = $sqlstr . " AND CFBM='$data[dispose]'";
			}
		}	
		//开始时间
		if($data['st'] != '')
		{
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[st]','yyyy-mm-dd hh24:mi:ss')";
		}
		//结束时间
		if($data['et'] != '')
		{ 
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[et]','yyyy-mm-dd hh24:mi:ss')";
		}
		
		return $this->ora_db->query("select count(*) as RCount from CLTX where 1=1 ". $sqlstr);
	}

	//根据条件查询违法车流量 
	function get_breakrule_by_condition($data)
	{
		$sqlstr = '';
		
		if($data['okkval'] != '')   //监控地点
		{
			$sqlstr = $sqlstr . " AND KKBH ='$data[okkval]'";
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
		if ($data['cartype'] != '')      //车辆类型
		{
			if($data['cartype'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['cartype'] == '大车')
			{
				$sqlstr = $sqlstr . " AND HPYS='黄牌'";
			}
			elseif($data['cartype'] == '小车')
			{
				$sqlstr = $sqlstr . " AND HPYS='蓝牌'";
			}
			elseif($data['cartype'] == '其他')
			{
				$sqlstr = $sqlstr . " AND HPYS!='黄牌' AND HPYS!='蓝牌'";
			}
		}
		if($data['starttime'] != '')            //开始时间
		{
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //结束时间
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
		}
		
		return $this->ora_db->query("select count(*) as RCount from CLTX where 1=1 ". $sqlstr);
	}
	
	//根据条件查询报警车流量 
	function get_alarmcar_by_condition($data)
	{
		$sqlstr = '';
		
		if($data['okkval'] != '')   //监控地点
		{
			$sqlstr = $sqlstr . " AND KKBH ='$data[okkval]'";
		}

		if ($data['cartype'] != '')      //车辆类型
		{
			if($data['cartype'] == 'all')
			{
				$sqlstr = $sqlstr;
			}
			elseif($data['cartype'] == '大车')
			{
				$sqlstr = $sqlstr . " AND HPYS='黄牌'";
			}
			elseif($data['cartype'] == '小车')
			{
				$sqlstr = $sqlstr . " AND HPYS='蓝牌'";
			}
			elseif($data['cartype'] == '其他')
			{
				$sqlstr = $sqlstr . " AND HPYS!='黄牌' AND HPYS!='蓝牌'";
			}
		}
		if($data['starttime'] != '')            //开始时间
		{
			$sqlstr = $sqlstr . " AND jgsj>to_date('$data[starttime]','yyyy-mm-dd hh24:mi:ss')";
		}
		if($data['endtime'] != '')              //结束时间
		{ 
			//$sqlstr = $sqlstr . " AND jgsj<to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
			$sqlstr = $sqlstr . " AND jgsj < to_date('$data[endtime]','yyyy-mm-dd hh24:mi:ss')";
		}
		//报警类型	
		if($data['alarmtype'] != '')
		{
			if($data['alarmtype'] == '被盗抢车辆')
			{
				$sqlstr = $sqlstr . " AND CLBJ='D'";
			}
			elseif($data['alarmtype'] == '套牌车辆')
			{
				$sqlstr = $sqlstr . " AND CLBJ='T'";
			}
			elseif($data['alarmtype'] == '便衣嫌疑车辆')
			{
				$sqlstr = $sqlstr . " AND CLBJ='S'";
			}
			elseif($data['alarmtype'] == '布控车辆')
			{
				$sqlstr = $sqlstr . " AND CLBJ='B'";
			}
			else
			{
				$sqlstr = $sqlstr . "AND CLBJ<>'F' AND CLBJ<>'O'";
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
				$sqlstr = $sqlstr . " AND (CFBM='' or CFBM is null) ";
			}
			elseif($data['dispose'] == '车牌号码识别错误')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='号码识别错误' OR CFBM='识别错误')";
			}
			elseif($data['dispose'] == '车牌颜色识别错误')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='颜色识别错误')";
			}
			elseif($data['dispose'] == '与黑名单数据不符')
			{
				$sqlstr = $sqlstr . " AND (CFBM='$data[dispose]' OR CFBM='比对数据错')";
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