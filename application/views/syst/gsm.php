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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;���ű�������</span></td>
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
</table>
<div>
	<form method="post" action="<?php echo site_url('syst/edit_gsm');?>" >
		<table align="center" border="0" cellspacing="1" cellpadding="6" style="width:450px" bgcolor="#FFFFFF">
			<tr style="background-color:#69c">
				<td colspan="2" align="center"><span style="font-weight:bold;color:white">���ű�������</span></td>
			</tr>
			<tr>
				<td width:="100px;" class="BLACK">��Ϣ��IP��ַ:</td>
				<td><input type="text" id="ipaddr" name="ip_addr" value="<?php echo $sm->IF_IPADDR;?>" style="width:240px"/><span style="color:red"><?php echo form_error('ip_addr'); ?></span></td>
			</tr>
			<tr>
				<td class="BLACK">API�ӿڴ���:</td>
				<td><input type="text" id="apicode" name="apicode" value="<?php echo $sm->IF_APICODE;?>" style="width:240px"/><span style="color:red"><?php echo form_error('ip_addr'); ?></span></td>
			</tr>
			<tr>
				<td class="BLACK">�ӿ������û���:</td>
				<td><input type="text" id="user" name="user" value="<?php echo $sm->IF_USER;?>" style="width:240px"/><span style="color:red"><?php echo form_error('ip_addr'); ?></span></td>
			</tr>
			<tr>
				<td class="BLACK">�ӿ���������:</td>
				<td><input type="text" id="password" name="password" value="<?php echo $sm->IF_PASSWORD;?>" style="width:240px"/><span style="color:red"><?php echo form_error('ip_addr'); ?></span></td>
			</tr>
			<tr>
				<td class="BLACK">�ӿ����ݿ���:</td>
				<td><input type="text" id="dbname" name="dbname" value="<?php echo $sm->IF_DBNAME;?>" style="width:240px"/><span style="color:red"><?php echo form_error('ip_addr'); ?></span></td>
			</tr>
			<tr>
				<td class="BLACK">���ն��ŵ��ֻ���: </td>
				<td><textarea id="mobiles" name="mobiles" style="width:300px;height:80px"><?php echo $sm->TEL;?></textarea><span style="color:red"><?php echo form_error('ip_addr'); ?></span></td>
			</tr> 

			<tr>
				<td align="left" colspan="2"><input type="checkbox" id="autosend" name="autosend" <?php if($sm->AUTO_SEND=='T'){echo 'checked="checked"';}?> value="T"/><span class="BLACK">�Զ�����</span> <span class="BLUE">(��ѡ�������˹���Ԥ���Զ����Ͷ��ű�����)</span></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input class="BUTBLACK" type="submit" name="add" value="����" /></td>
			</tr>
		</table>
	</form>
</div>

</body>
</html>
