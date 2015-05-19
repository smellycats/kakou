<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
margin-left: 0px;
margin-top: 0px;
margin-right: 0px;
margin-bottom: 0px;
}
.STYLE1 { font-size: 12px; color: #000000; }
.STYLE5 { font-size: 12 }
.STYLE7 { font-size: 12px; color: #FFFFFF; }
.STYLE7 a{ font-size: 12px; color: #FFFFFF; }
a img { border:none; }
-->
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="57" background="images/admin/main_03.gif">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="450" height="57" background="images/admin/main_01.png">&nbsp;</td>
					<td>&nbsp;</td>
					<td width="281" valign="bottom">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="33" height="27"><img src="images/admin/main_05.gif" width="33" height="27" /></td>
								<td width="248" background="images/admin/main_06.gif">
									<table width="225" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td height="17"><div align="right"><a href="<?php echo site_url() . '/user/pwd'; ?>" target="rightFrame"><img src="images/admin/pass.gif" width="69" height="17" /></a></div></td>
											<td><div align="right"><a href="<?php echo site_url() . '/admin/right'; ?>" target="rightFrame"><img src="images/admin/user.gif" width="69" height="17" /></a></div></td>
											<td><div align="right"><a href="<?php echo site_url() . '/home/exit_system'; ?>" target="_parent"><img src="images/admin/quit.gif" alt=" " width="69" height="17" /></a></div></td>
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
		<td height="40" background="images/admin/main_10.gif">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="194" height="40" >&nbsp;</td>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="21" class="STYLE7"><img src="images/admin/main_15.gif" width="19" height="14" /></td>
								<td width="35" class="STYLE7"><div align="center"><a href="javascript:history.go(-1);">后退</a></div></td>
								<td width="21" class="STYLE7"><img src="images/admin/main_17.gif" width="19" height="14" /></td>
								<td width="35" class="STYLE7"><div align="center"><a href="javascript:history.go(1);">前进</a></div></td>
								<td width="21" class="STYLE7"><img src="images/admin/main_19.gif" width="19" height="14" /></td>
								<td width="35" class="STYLE7"><div align="center"><a href="javascript:window.location.reload();" target="rightFrame">刷新</a></div></td>
								<td width="21" class="STYLE7"></td>
								<td width="35" class="STYLE7"><div align="center"></div></td>
							<td>&nbsp;</td>
							</tr>
						</table>
					</td>
					<td width="248" background="images/admin/main_11.gif">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="16%"><span class="STYLE5"></span></td>
								<td width="75%"><div align="center"><span class="STYLE7"></span></div></td>
								<td width="9%">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="30" background="images/admin/main_31.gif">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="8" height="30"><img src="images/admin/main_28.gif" width="8" height="30" /></td>
					<td width="147" background="images/admin/main_29.gif">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="24%">&nbsp;</td>
								<td width="43%" height="20" valign="bottom" class="BLACK14">管理菜单</td>
								<td width="33%">&nbsp;</td>
							</tr>
						</table>
					</td>
					<td width="39"><img src="images/admin/main_30.gif" width="39" height="30" /></td>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="20" valign="bottom"><span class="BLACK">当前登录用户：<?php echo $this->session->userdata('DX_username'); ?> &nbsp;</span></td>
								<td valign="bottom" class="BLACK"><div align="right"></div></td>
							</tr>
						</table>
					</td>
					<td width="17"><img src="images/admin/main_32.gif" width="17" height="30" /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
