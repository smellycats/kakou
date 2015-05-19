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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;关联报警点</span></td>
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
			<table align="center" width="95%" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($computer)): ?>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">序号</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">路口机器IP地址</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">路口名称</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作</span></div></td>
				</tr>
				<?php $rownum = 0;?>
				<?php foreach ($computer as $row): ?>
				<tr>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $rownum += 1; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->COMPUTERNAME?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->ROADNAME?></div></td>
                    <td height="24" ><div align="center" class="STYLE23"><?php echo anchor('syst/edit_alarmrel/'.$row->COMPUTERNAME,'关联')?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>没有路口信息,请添加!</h3>
					</div></td>
			    </tr>
				<?php endif; ?>
			</table>
			<p align="center" style="font-size:12px;color:blue">如果卡口没有关联任何报警点，那么，此卡口的报警信息无法发送到任何报警点。</p>
            <p align="center" style="font-size:12px;color:blue">可以在下列设置中，设置您所需要的卡口与报警点的对映关系。</p>
            <p align="center" style="font-size:12px;color:blue">当然，报警点必须安装SPAlarmGate报警客户端，方能达到报警目的。</p>
		</td>
	</tr>
</table>
</body>
</html>
