<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;����������</span></td>
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
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">���</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">·�ڻ���IP��ַ</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">·������</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
				</tr>
				<?php $rownum = 0;?>
				<?php foreach ($computer as $row): ?>
				<tr>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $rownum += 1; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->COMPUTERNAME?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->ROADNAME?></div></td>
                    <td height="24" ><div align="center" class="STYLE23"><?php echo anchor('syst/edit_alarmrel/'.$row->COMPUTERNAME,'����')?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>û��·����Ϣ,�����!</h3>
					</div></td>
			    </tr>
				<?php endif; ?>
			</table>
			<p align="center" style="font-size:12px;color:blue">�������û�й����κα����㣬��ô���˿��ڵı�����Ϣ�޷����͵��κα����㡣</p>
            <p align="center" style="font-size:12px;color:blue">���������������У�����������Ҫ�Ŀ����뱨����Ķ�ӳ��ϵ��</p>
            <p align="center" style="font-size:12px;color:blue">��Ȼ����������밲װSPAlarmGate�����ͻ��ˣ����ܴﵽ����Ŀ�ġ�</p>
		</td>
	</tr>
</table>
</body>
</html>
