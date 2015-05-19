<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<script type="text/javascript" src=<?php echo base_url() . "js/xhedit1.1.0/jquery/jquery-1.4.2.min.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/kakou.js"; ?>></script>

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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;用户列表</span></td>
										</tr>
									</table>
								</td>
								<td><div align="right"><span class="STYLE1">      &nbsp;&nbsp;<img src="images/admin/add.gif" width="10" height="10" />&nbsp;&nbsp;<?php echo anchor('user/add_user/', '添加'); ?>&nbsp; &nbsp;</span><span class="STYLE1"> &nbsp;</span></div></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<form method="get" action="<?php echo site_url('user/find_user'); ?>">
				<table width="100%" border="0" cellpadding="1" cellspacing="0" >
					<tr>
						<th align="center" class="BLACK">用户名：</th>
						<td>
							<input type="text" name="username" value="<?php echo $username; ?>" /><?php echo form_error('username'); ?>
						</td>
						<td>
							<input class="BUTBLACK" type="submit" name="Submit" id="submit" value="查询" title="查询" style="width:50px"/>
						</td>
					</tr>
				</table>
			</form>

			<table align="center" width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($users)): ?>			
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">#</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">帐号名称（警号）</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">姓名</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">所属角色</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">部门</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">用户状态</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">创建日期</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作</span></div></td>
				</tr>
				<?php $count = 0;?>
				<?php foreach ($users as $row): ?>
				<?php if ($row->banned == 1)
				      { 
				      	  $data['state'] = '禁用';
				      	  $data['style'] = 'STYLE26';
				      }
				      else
				      {
				      	  $data['state'] = '正常';
				      	  $data['style'] = 'STYLE27';	  
				      }
				?>
				<tr>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $offset + $count + 1?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->username?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->realname?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->role_name?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->department?></div></td>
					<td height="24" ><div align="center" class="<?php echo $data['style'];?>"><?php echo $data['state'];?></div></td>
                    <td height="24" ><div align="center" class="STYLE28"><?php echo date('Y-m-d', strtotime($row->created))?></div></td>
                    <td height="24" ><div align="center" class="STYLE23"><?php if($row->id != 1){ echo anchor('user/edit_user/'.$row->id,'修改');}?>|<?php if($row->id != 1){ echo anchor('user/del_user/'.$row->id, '删除', 'onclick="return confirm(' . "'确定要删除？'" . ')"');}?></div></td>
				</tr>
				<?php $count += 1;?>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>没有用户,请添加!</h3>
					</div></td>
				<?php endif; ?>
				</tr>
			</table>
			</form>
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
