<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msyst extends CI_Model
{
	private $ora_db;
	
	function __construct()
	{
		parent::__construct();
		
		$this->ora_db = $this->load->database('oracle_db', TRUE);
	}

	//获取报警点信息
	function get_alarmpoint_all($offset = 0, $row_count = 0)
	{
/*		if ($offset >= 0 AND $row_count > 0)
		{
			$query = $this->ora_db->query("SELECT * FROM alarm_point order by alarm_id desc limit $offset,$row_count");

		}
		else
		{
			$query = $this->ora_db->query("SELECT * FROM alarm_point");
		}*/
		
		if ($offset >= 0 AND $row_count > 0)
	    {
		/*	$this->ora_db->select("*", FALSE);
			$this->ora_db->order_by("alarm_ip", "ASC");*/
			
			//$query = $this->ora_db->get('alarm_point', $row_count, 40); 
			$max_count = $row_count+$offset;
			
			//$query = $this->ora_db->query("SELECT * FROM (select *, rownum rnum from alarm_point where rownum<$max_count) where rnum >=$offset");
			$query = $this->ora_db->query("SELECT * FROM (SELECT A.*, ROWNUM RN FROM (SELECT * FROM alarm_point) A WHERE ROWNUM <= $max_count)WHERE RN >= $offset");
		}
		else
		{
			//$query = $this->ora_db->get("alarm_point");
			$query = $this->ora_db->query("select * from alarm_point");
		}

		return $query;
	}
	
	//根据报警ip地址查询
	function get_alarmpoint_by_ip($alarm_ip)
	{
		return $this->ora_db->query("select * from alarm_point where alarm_ip='$alarm_ip'");
		
	}

	//新建报警点
	function create_alarmpoint($data)
	{
		return $this->ora_db->query("insert into alarm_point (alarm_ip,alarm_name) values('$data[alarm_ip]','$data[alarm_name]')");
		//$this->db->insert($this->_table, $data);
	}
	
	
	//检查报警点IP是否已经使用
	function is_alarm_ip_available($alarm_ip)
	{
		$alip = $this->ora_db->query("select * from alarm_point where alarm_ip='$alarm_ip'");
		
		return $alip->num_rows() == 0;
	}
	
	//删除报警点
	function del_alarmpoint($alarm_ip)
	{
		return $this->ora_db->query("delete from alarm_point where alarm_ip='$alarm_ip'");
	}

	//修改报警点名称
	function edit_alarmname($data)
	{
		return $this->ora_db->query("update alarm_point set alarm_name='$data[alarm_name]' where alarm_ip='$data[alarm_ip]'");
	}
	
	//根据条件查询系统设置信息
	function get_config_kakou()
	{
		return $this->ora_db->query("select * from cfg_kakou");
	}

	//根据条件查询系统设置信息
	function get_config_info4($data)
	{
		return $this->ora_db->query("select * from config_info where type_name = '$data' ORDER BY Type_ID ASC, Type_Alias DESC");
	}
	
	function get_config_info3($data)
	{
		$sql = " and where id in (" . $data['kakou_id']. ")";
		
		if($data['kakou_id'] == 'all')
		{
			$sql = '';
		}
		if($data['kakou_id'] == '')
		{
			$sql = " and where id in ('')";
		}
		return $this->ora_db->query("select * from config_info where Type_Name like '%$data[type_name]%'". $sql ." ORDER BY Type_ID ASC, Type_Alias DESC");
	}
	
	//根据条件查询系统设置信息
	function get_config_info2($data)
	{
		return $this->ora_db->query("select * from config_info where Type_Name like '%$data[type_name]%' and Type_value like '%$data[type_value]%'  ORDER BY Type_ID ASC, Type_Alias DESC");
	}
	
	//根据条件查询系统设置信息
	function get_config_info5($data)
	{
		return $this->ora_db->query("select * from config_info where Type_Name like '%$data[type_name]%' ORDER BY Type_ID ASC, Type_Alias DESC");
	}
	
	//根据条件查询系统设置信息
	function get_config_info($data)
	{
		return $this->ora_db->query("select i.id,k.kk_id as type_value,k.kk_name as type_alias from config_info i inner join cfg_kakou k on i.type_value=k.kk_id");
	}
	
	//根据条件查询系统设置信息 路口别名
	function get_config_inof_typealias($data)
	{
		return $this->ora_db->query("select type_alias from config_info where Type_Name like '%$data[type_name]%' and Type_value like '%$data[type_value]%'  ORDER BY Type_ID ASC, Type_Alias DESC");
	}
	
	//添加路口参数
	function add_sysset($data)
	{
		return $this->ora_db->query("Insert Into config_info(Type_Name,Type_Value,TYPE_def,type_alias)Values('$data[type_name]','$data[type_value]','$data[type_def]','$data[type_alias]')");
	}
	
	//添加路口参数
	function add_sysset2($data)
	{
		$this->db->trans_start();
		$this->ora_db->query("Insert into cfg_kakou(kk_id,kk_name,kk_image_server,kk_ga_access_ip)Values('$data[kk_id]','$data[kk_name]','$data[server_ip]','$data[access_ip]')");
		$this->ora_db->query("Insert Into config_info(Type_Name,Type_Value,TYPE_def,type_alias)Values('卡口名称','$data[kk_id]','0','$data[kk_name]')");
		return $this->db->trans_complete(); 
	}
	
	//检查是否存在路口ID
	function is_kkid_available($kk_id)
	{
		$kkid =  $this->ora_db->query("select * from cfg_kakou where kk_id='$kk_id'");
		
		return $kkid->num_rows() == 0;
	}
	
	//根据ID获取路口参数
	function get_config_info_by_id($id)
	{
		return $this->ora_db->query("select i.id,i.type_id,i.type_def,k.kk_id as type_value,k.kk_name as type_alias from config_info i inner join cfg_kakou k on i.type_value=k.kk_id where i.id='$id' ");
	}
	
	//根据ID获取路口参数
	function get_config_info_by_id2($id)
	{
		return $this->ora_db->query("select * from config_info where id='$id' ");
	}
	
	//根据ID获取路口参数
	function get_config_kakou_by_id($id)
	{
		return $this->ora_db->query("select * from cfg_kakou where kk_id='$id' ");
	}
	
	//修改路口参数
	function edit_sysset($data)
	{
		return $this->ora_db->query("update config_info set Type_Value='$data[type_value]',TYPE_def='$data[type_def]',type_alias='$data[type_alias]' where id='$data[id]' ");
	}
	
	//修改路口参数
	function edit_sysset2($data)
	{
		$this->db->trans_start();
		$this->ora_db->query("update cfg_kakou set kk_name='$data[kk_name]',kk_image_server='$data[server_ip]',kk_ga_access_ip='$data[access_ip]' where kk_id='$data[kk_id]' ");
		$this->ora_db->query("update config_info set type_alias='$data[kk_name]' where type_value='$data[kk_id]' ");
		return $this->db->trans_complete();
	}
	
	//删除路口参数
	function del_sysset($id)
	{
		return $this->ora_db->query("delete from config_info where id='$id'");
	}
	
	//删除路口参数
	function del_sysset2($id)
	{
		$this->db->trans_start();
		$this->ora_db->query("delete from cfg_kakou where kk_id='$id'");
		$this->ora_db->query("delete from config_info where type_value='$id'");
		return $this->db->trans_complete();
	}
	
	//获取所有路口信息
	function get_computer_all()
	{
		return $this->ora_db->query("select * from computers");
	}
	
	//根据路口机器IP地址获得一条路口信息
	function get_computer_by_name($computername)
	{
		return $this->ora_db->query("select * from computers where computername='$computername'")->row();
	}
	
	//根据路口机器IP查询路口-报警点关联信息
	function get_kktoalarm_by_ip($kakou_ip)
	{
		return $this->ora_db->query("select * from rel_kk_to_alarm where kakou_ip='$kakou_ip'");
	}
	
	//更新路口-报警点关联信息
	function edit_kktoalarm($kakou_ip, $alarm_ip)
	{
		$this->ora_db->query("delete from rel_kk_to_alarm where kakou_ip='$kakou_ip'");
		
		if(!empty($alarm_ip))
		{
			foreach ($alarm_ip as $ip)
			{
				$this->ora_db->query("insert into rel_kk_to_alarm (kakou_ip,alarm_ip) values('$kakou_ip', '$ip')");
			}
		}

		return TRUE;
	}
	
/*	//获得IP访问控制地址信息
	function get_ip_access_all()
	{
		return $this->ora_db->query("select * from ip_access ORDER BY ID DESC");
	}*/
	
	//获得IP访问控制地址信息
	function get_ip_access_all()
	{
		return $this->db->query("select * from ip_access ORDER BY ID DESC");
	}

	//获得开启的IP访问控制地址信息
	function get_ip_access_by_condition($bool)
	{
		return $this->ora_db->query("select * from ip_access where clbj='$bool' ORDER BY ID DESC");
	}
	
	//获得开启的IP访问控制地址信息_mysql
	function get_ip_access_by_condition_mysql($bool)
	{
		$sqlstr = ' 1=1';
		
		if($bool != '')
		{
			$sqlstr = $sqlstr . " AND CLBJ='$bool'";
		}
		return $this->db->query("select * from ip_access where " . $sqlstr);
	}
	
/*	//根据ID查询IP地址
	function get_ip_access_by_id($ipid)
	{
		return $this->ora_db->query("select * from ip_access where ID='$ipid'");
	}*/
	
	//根据ID查询IP地址_mysql
	function get_ip_access_by_id($ipid)
	{
		return $this->db->query("select * from ip_access where ID='$ipid'");
	}
	
/*	//添加IP地址
	function add_ip_access($data)
	{
		return $this->ora_db->query("Insert Into ip_access(ID, MINIP, MAXIP,CLBJ) values(ip_id.nextval, '$data[minip]', '$data[maxip]', 'F')");
	}*/
	
	//添加IP地址
	function add_ip_access($data)
	{
		return $this->db->query("Insert Into ip_access(MINIP, MAXIP,CLBJ) values('$data[minip]', '$data[maxip]', 'F')");
	}
/*	//跟新IP地址
	function update_ip_access($ipid, $banned)
	{
		return $this->ora_db->query("update ip_access set CLBJ='$banned' where ID='$ipid'");
	}*/
	
	//跟新IP地址
	function update_ip_access($ipid, $banned)
	{
		return $this->db->query("update ip_access set CLBJ='$banned' where ID='$ipid'");
	}
	
/*	//根据ID删除IP地址
	function del_ip_access($ipid)
	{
		return $this->ora_db->query("delete from ip_access where ID='$ipid'");
	}*/
	
	//根据ID删除IP地址_mysql
	function del_ip_access($ipid)
	{
		return $this->db->query("delete from ip_access where ID='$ipid'");
	}
	
	/*
	 * ip_access2表函数
	 */
	function get_ip_access2($offset=0, $rows=0, $data=array())
	{	
		$this->db->where('del',0);
		if ($rows == 0){
			$this->db->select('count(*) as sum');
		} else {
			$this->db->select('id,minip,maxip,banned');
			$this->db->limit($rows, $offset);
		}
		return $this->db->get('ip_access2');
	}
	
	//添加角色
	function add_ip_access2($data)
	{
		return $this->db->insert('ip_access2', $data);
	}
	
	//修改角色信息
	function edit_ip_access2($id, $data)
	{
		return $this->db->where('id', $id)->update('ip_access2', $data);
	}
	
	//删除角色
	function del_ip_access2($id)
	{
		return $this->db->where('id',$id)->set('del',1)->update('ip_access2');
	}
	
	//获取设备状态信息
	function get_eqstate_info2()
	{
		return $this->ora_db->query("select computers.roadname as kkname,eqstate.netstate,eqstate.computer,eqstate.rtime,eqstate.cdbh2,eqstate.cdbh1,eqstate.cdbh3,eqstate.cdbh4,eqstate.cdbh5,eqstate.cdbh6 from computers left join eqstate on roadname = kkname ORDER BY KKNAME DESC, CDBH2 ASC");
	}

	function get_eqstate_info()
	{
		return $this->ora_db->query("select t.*,to_char(rtime, 'yyyy-mm-dd hh24:mi:ss')as rtime2 from EQSTATE t ORDER BY t.KKNAME DESC, t.CDBH2 ASC");
	}
	
	//获取所有公告信息
	function get_adv_all()
	{
		return $this->ora_db->query("select * from kk_adv order by position asc");
	}
	
	function get_adv_by_disable()
	{
		return $this->ora_db->query("select * from kk_adv where disable = 'F' order by position asc");
	}
	
	
	//添加公告内容
	function add_adv($data)
	{
		$this->ora_db->query("update kk_adv set position=position+1 where position>='$data[adv_pos]'");
		
		return $this->ora_db->query("insert into kk_adv (content, position, disable) values('$data[adv_content]', '$data[adv_pos]', 'F')");
	}
	
	//根据ID更新公告内容
	function edit_adv_by_id($data)
	{
		return $this->ora_db->query("update kk_adv set content='$data[adv_content]',position='$data[adv_pos]' where id='$data[adv_id]'");
	}
	
	//根据ID启用公告
	function turn_on_adv($id)
	{
		return $this->ora_db->query("update kk_adv set disable='F' where id='$id'");
	}

	//根据ID禁用公告
	function turn_off_adv($id)
	{
		return $this->ora_db->query("update kk_adv set disable='T' where id='$id'");
	}
	
	//根据ID删除公告
	function del_adv_by_id($data)
	{
		$this->ora_db->query("update kk_adv set position=position-1 where position>'$data[adv_pos]'");
		
		return $this->ora_db->query("delete from kk_adv where id='$data[adv_id]'");
	}
	
	//获取短信信息
	function get_sm_if()
	{
		return $this->ora_db->query("select t.*,dbms_lob.substr(t.mobiles,32767,1) as tel from sm_if t where rownum<=1");
	}
	
	//设置短信信息
	function set_sm_if($data)
	{
		return $this->ora_db->query("update sm_if set MOBILES='$data[mobiles]',IF_IPADDR='$data[ip_addr]',IF_APICODE='$data[apicode]',IF_USER='$data[user]',IF_PASSWORD='$data[password]',IF_DBNAME='$data[dbname]',AUTO_SEND='$data[autosend]' where rownum<=1");
	}
}
?>