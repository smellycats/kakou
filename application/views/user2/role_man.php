<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;角色列表</span></td>
										</tr>
									</table>
								</td>
								<td><div align="right"><span class="STYLE1">      &nbsp;&nbsp;<img src="images/admin/add.gif" width="10" height="10" />&nbsp;&nbsp;<?php echo anchor('user/add_roles/', '添加'); ?>&nbsp; &nbsp;</span><span class="STYLE1"> &nbsp;</span></div></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table align="center" width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($roles)): ?>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">#</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">角色名</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作</span></div></td>
				</tr>
				<?php $count = 0;?>
				<?php foreach ($roles as $row): ?>
				<tr>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $offset + $count + 1; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->name; ?></div></td>
					<?php if ($row->name == 'Admin') ?>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->name == 'Admin'? '' : anchor('user/edit_role/' . $row->id, '修改'); ?>|<?php echo $row->name == 'Admin'? '' : anchor('user/del_role/' . $row->id, '删除', 'onclick="return confirm(' . "'确定要删除？'" . ')"'); ?></div></td>
				</tr>
				<?php $count += 1;?>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="24" bgcolor="#ffffff" class="STYLE19"><div align="center"><h3>暂无用户,请添加!</h3></div></td>
				<?php endif;?>
				</tr>
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
