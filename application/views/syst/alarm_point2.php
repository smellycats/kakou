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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;�������б�</span></td>
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
			<table align="center" width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($alarm_point)): ?>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">���</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">������IP</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����������</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
				</tr>
				<?php $count = 0;?>
				<?php foreach ($alarm_point as $row): ?>
				<tr>
				    <?php $rownum = $offset + $count + 1;?>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $rownum; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->ALARM_IP?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->ALARM_NAME?></div></td>
                    <td height="24" ><div align="center" class="STYLE23"><?php echo anchor('syst/edit_alarmpoint/'.$row->ALARM_IP, '�޸�')?> | <?php echo anchor('syst/del_alarmpoint/'.$row->ALARM_IP, 'ɾ��', 'onclick="return confirm(' . "'ȷ��Ҫɾ����'" . ')"')?></div></td>
				</tr>
				<?php $count += 1;?>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" ><div align="center">
						<h3>û�б�����,�����!</h3>
					</div></td>
				<?php endif; ?>
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
	<tr>
		<td>
			<p align="center" style="font-size:12px;color:blue">ע�⣺ ����˱�����֮��Ҫʹ��ɽ��ձ�����Ϣ����������"����������"�У�������Ӧ�����á�</p>
		</td>
	</tr>
	<tr>
		<form method="post" action="<?php echo site_url('syst/add_alarmpoint'); ?>">
		<table width="100%" border="0" cellpadding="1" cellspacing="0" >
			<tr>
				<td align="center" style="width:100%;font-size: 12px;"> <b>��ӱ����㣺</b>
					<label>������IP��</label><input TYPE="text" name="alarm_ip" value="<?php echo set_value('alarm_ip'); ?>" />
					<label>���������ƣ�</label><input TYPE="text" name="alarm_name" value="<?php echo set_value('alarm_name'); ?>" />
					<input name="submit" type='submit' value="���" /><?php echo form_error('alarm_ip'); ?>
				</td>
			</tr>
		</table>
		</form>
	</tr>
</table>
</body>
</html>
