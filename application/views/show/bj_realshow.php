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
setInterval("show()",2000);

function show() {
	
  	var url = "<?php echo base_url() . "index.php/show/bj_realshowdiv?kakou=" . $kakou . "&direction=";?>"
  	xmlHttp.open("POST", url, true);
  	xmlHttp.onreadystatechange = update;
  	xmlHttp.send();
}

function update() {
  	if (xmlHttp.readyState == 4) {
		var response = xmlHttp.responseText;
		if (response!="old")
			document.getElementById('mainRefresh').innerHTML=response;
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;报警实时显示</span></td>
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
    <center><div class="BUTBLUE24"><span>等待数据中....！</span></div></center>
</div>
</body>
</html>
