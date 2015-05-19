<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<?php header("Content-Type:text/html;charset=gbk");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />

<title>无标题文档</title>
</head>
<body>
<script type="text/javascript" src=<?php echo base_url() . "js/xhedit1.1.0/jquery/jquery-1.4.2.min.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/xmlHttpRequest.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/kakou.js"; ?>></script>
<script language="javascript" type="text/javascript">
setTimeout("realcmp()",3000);

function realcmp(){
	window.location.href=<?php echo '"' . base_url() . 'index.php/logo/realcmp?place=' . $realcmp['place'] . "&direction=" . $realcmp['dire'] . '"'?>;
}

function goback(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/logo/cmpselect' . '"'?>;
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;等待页面</span></td>
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
<div id ="mainRefresh">
    <center><div class="BUTBLUE24"><p>最近1小时没有数据,等待数据中....！</p></div></center>
    <center><input type="button" name="back" id="back" value="返回选择"  onclick="goback()" /></center>
</div>
</body>
</html>