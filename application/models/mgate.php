<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mgate extends CI_Model
{
	private $ora_db;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}

	//根据条件获取车辆信息
	public function getCltx($offset = 0, $limit = 0, $sort = 'id', $order = 'desc', $data)
	{
		$sqlstr = '';
		// 卡口地点
		if ($data['place'] == 'all') {
			$sqlstr = $sqlstr;
		}else {
			$sqlstr = $sqlstr . " AND KKBH = '$data[place]'";
		}
		// 车道编号
		if (isset($data['cdbh'])) {
			switch ($data['cdbh']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CDBH='$data[cdbh]'";
					break;
			}
		}
		// 方向
		if (isset($data['fxbh'])) {
			switch ($data['fxbh']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND FXBH='$data[fxbh]'";
					break;
			}
		}
		//车牌颜色
		if (isset($data['hpys'])) {
			switch ($data['hpys']) {
				case 'all':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPYS='$data[hpys]'";
					break;
			}
		}
		//特殊车牌号
		if (isset($data['spcarnum'])) {
			switch ($data['spcarnum']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND HPHM in ($data[spcarnum])";
					break;
			}
		}
		// 记录状态
		if (isset($data['record'])) {
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
		// 违法类型
		if (isset($data['breakrule'])) {
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
		// 报警类型
		if (isset($data['alarmtype'])) {
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
		// 案情处理
		if (isset($data['dispose'])) {
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
		// 最小速度
		if (isset($data['minspeed'])) {
			switch ($data['minspeed']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CLSD >= '$data[minspeed]'";
					break;
			}
		}
		// 最大速度
		if (isset($data['maxspeed'])) {
			switch ($data['maxspeed']) {
				case '':
					$sqlstr = $sqlstr;
					break;
				default:
					$sqlstr = $sqlstr . " AND CLSD <= '$data[maxspeed]'";
					break;
			}
		}
		// 开始时间
		$sqlstr = $sqlstr . " AND jgsj > to_date('$data[st]','yyyy-mm-dd hh24:mi:ss')";
         // 结束时间
		$sqlstr = $sqlstr . " AND jgsj < to_date('$data[et]','yyyy-mm-dd hh24:mi:ss')";

		switch ($data['number']) {
			case 'R':
				$sqlstr = $sqlstr . " and length(hphm) >= 2";
				break;
			case '?' || '？':
				$data['carnum'] == '' ? $sqlstr = $sqlstr : $sqlstr = $sqlstr . " AND HPHM LIKE '$data[platename]'";
				break;
			case '-':
				$sqlstr = $sqlstr . " AND (HPHM = '' OR HPHM = '-')";
			default:
				$sqlstr = $sqlstr . " AND HPHM LIKE '$data[platename]'";
		}

		if ($limit == 0) {
			return $this->ora_db->query("SELECT count(1) AS sum  FROM cltx WHERE 1=1 " . $sqlstr);
		} else {
			$max_count = $limit + $offset;
			
			return $this->ora_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime FROM (SELECT A.*, ROWNUM RN FROM (SELECT * FROM cltx WHERE 1=1 $sqlstr ORDER BY $sort $order) A WHERE ROWNUM <= $max_count)t WHERE RN > $offset" );
		}
	}
		
	//根据ID号获取卡口号
	function get_openkakou_by_id($role_id)
	{
		$this->db->get();
	}

	//根据ID获取车辆信息
	function getCltxById2($id)
	{
		return $this->ora_db->query("SELECT t.*,c.*,to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime from cltx t left join cfg_kakou c on t.kkbh=c.kk_id where t.ID='$id'");
	}
	
	//根据ID获取车辆信息
	function getCltxById($id)
	{
		return $this->ora_db->query("SELECT t.* , to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss')as passtime from cltx t where ID='$id'");
	}
	
	//根据ID修改车辆信息
	function setCltxById($id, $data)
	{
		$data['carnum'] = strtoupper($data['carnum']);
		
		return $this->ora_db->query("update cltx set hphm='$data[carnum]',hpys='$data[color]',hdgg='T' where id='$id'");
	}
	//根据ID修改处理结果信息
	function handle_by_id($id, $data)
	{
		return $this->ora_db->query("update cltx set CFBM='$data[dispose]',MEMO='$data[jyqk]',CFSJ='$data[cfsj]',FKBM='$data[user]' where id=$id");
	}
	
	/*
	//根据ID删除车辆信息
	function del_car_by_id($id)
	{
		return $this->ora_db->query("delete from cltx where id='$id'");
	} */
	
	function get_bcxw($carnum)
	{
		return $this->ora_db->query("select t.hphm,t.bcxw from bkcp t where hphm ='$carnum' and clbj='T'");
	}


}
?>
