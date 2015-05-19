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
<script>
function fcheckall()
{
	var objID;

	objID = document.form1.elements;

	for (var i=0 ;i<objID.length;i++)
	{
		objID[i].checked = !objID[i].checked
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;路口参数配置</span></td>
										</tr>
									</table>
								</td>
                                <td><div align="right"><span class="STYLE1">      &nbsp;&nbsp;<img src="images/admin/add.gif" width="10" height="10" />&nbsp;&nbsp;<?php echo anchor('syst/add_sysset2/', '添加'); ?>&nbsp; &nbsp;</span><span class="STYLE1"> &nbsp;</span></div></td>
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
				<?php if (!empty($config_kakou)): ?>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">#</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">路口ID</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">路口名称</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">存储服务器IP</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">网关访问IP</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作</span></div></td>
				</tr>
				<?php $rownum = 0;?>
				<?php foreach ($config_kakou as $row): ?>
				<tr>
				    <td height="24" ><div align="center" class="STYLE23"><?php echo $rownum += 1; ?></div></td>	
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->KK_ID;?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->KK_NAME;?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->KK_IMAGE_SERVER;?></div></td>
                    <td height="20" ><div align="center" class="STYLE23"><?php echo $row->KK_GA_ACCESS_IP;?></div></td>
                    <td height="20" ><div align="center" class="STYLE23"><?php echo anchor('syst/edit_sysset2/'.$row->KK_ID,'修改')?> | <?php echo anchor('syst/del_sysset2/'.$row->KK_ID, '删除', 'onclick="return confirm(' . "'确定要删除？'" . ')"')?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>没有路口参数,请添加!</h3>
					</div></td>
				</tr>
				<?php endif; ?>
			</table><!--
			<p align="center" style="font-size:12px;color:blue">注意： 添加了报警点之后，要使其可接收报警信息，您必须在"关联报警点"中，进行相应的设置。</p>
			-->
		</td>
	</tr>
	</table>
</body>
</html>
