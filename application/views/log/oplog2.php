<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<script defer="defer" type="text/javascript" src=<?php echo base_url() . "js/My97DatePicker/WdatePicker.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/xhedit1.1.0/jquery/jquery-1.4.2.min.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/kakou.js"; ?>></script>
<script type="text/javascript">

function confirmDel(){
	if(confirm("确定要删除？"))
	{
		window.location.href=<?php echo '"' . base_url() .  'index.php/' .'log/del_oplog/?username='.$username .'&starttime=' . $starttime . '&endtime=' . $endtime . '"'?>;
	}
	else
	{
		alert("你按了取消，那就是返回.");
	}
}

</script>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td height="30">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="24" bgcolor="#353c44">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="6%" height="19" valign="bottom"><div align="center"><img src="images/admin/tb.gif" width="14" height="14" /></div></td>
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;用户操作记录</span></td>
										</tr>
									</table>
								</td>
                    
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<form method="get" action="<?php echo site_url('log/search_oplog'); ?>">
				<table width="100%" border="0" cellpadding="1" cellspacing="0" >
					<tr>
						<td align="center" style="font-size: 12px;"> <b>用户名：</b> </td>
							<td>
								<input type="text" name="username" value="<?php echo $username; ?>" /><?php echo form_error('username'); ?>
							</td>
							<td style="font-size: 12px;">时&nbsp;&nbsp;&nbsp;&nbsp;间:</td>
				            <td >
				                <input id="starttime" type="text" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $starttime;?>" style="width:150px"/>
				                <label style="font-size: 12px;">到</label>
				                <input id="endtime" type="text" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $endtime;?>" style="width:150px"/>
				            </td>
							<td>
								<input type="submit" name="Submit" id="submit" value="查询" title="查询" style="width:50px"/>
								<input type="button" name="del_userlog" value="删除" onclick="confirmDel()" />
							</td>
					</tr>
				</table>
			</form>
			
			<table align="center" width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($userlog)): ?>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">#</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作时间</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">用户名</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作记录</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">IP</span></div></td>
				</tr>
				<?php $count = 0;?>
				<?php foreach ($userlog as $row): ?>
				<tr>
				    <td height="24" ><div align="center" class="STYLE23"><?php echo $rownum = $offset + $count + 1; ?></div></td>	
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->czsj?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->uname;?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->memo;?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->uip;?></div></td>
				</tr>
				<?php $count += 1;?>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>没有用户操作数据！</h3>
					</div></td>
				</tr>
				<?php endif; ?>
			</table>
		</td>
	</tr>
	<tr>
		<td height="30">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="33%"><div align="center"><span class="STYLE22"><?php echo $this->pagination->create_links();?></span></div></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
