<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>�ޱ����ĵ�</title>
<style type="text/css">
<!--
body {
margin-left: 3px;
margin-top: 0px;
margin-right: 3px;
margin-bottom: 0px;
}
a{
text-decoration:none;
color: #344b50;
}
.STYLE1 { color: #e1e2e3; font-size: 12px; }
.STYLE1 a{ color:#fff; }
.STYLE6 {color: #000000; font-size: 12; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 { color: #344b50; font-size: 12px; }
.STYLE21 { font-size: 12px; color: #3b6375; }
.STYLE22 { font-size: 12px; color: #295568; }
-->
</style>
</head>
<body>
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
											<td width="94%" valign="bottom"><span class="STYLE1">&nbsp;�û���־</span></td>
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
			<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
				<tr>
				<?php if (!empty($users)): ?>
					<!--   <td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10"><a href="javascript:fcheckall()">ȫѡ</a> </span></div></td>  -->
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">ID</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">�û���</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">������ɫ</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">����¼IP</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">�û�״̬</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">����¼ʱ��</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">��������</span></div></td>
				</tr>
				<?php foreach ($users as $row): ?>
				<tr>
					<!--  <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo form_checkbox('id[]',$row->id)?></div></td> -->
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $row->id?></div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $row->username?></div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $row->role_name?></div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $row->last_ip?></div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
					<?php
					if ($row->banned == 1)
					{
						echo '����';
					}
					else
					{
						echo '����';
					}
					?>
					</div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo date('Y-m-d', strtotime($row->last_login))?></div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo date('Y-m-d', strtotime($row->created))?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>û���û�,�����!</h3>
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
					<td width="33%"><div align="left"><span class="STYLE22"><?php echo $this->pagination->create_links();?></span></div></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
