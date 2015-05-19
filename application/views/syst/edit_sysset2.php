<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<div id="edit_sysset">
	<h3>修改路口参数</h3>
	<form method="post" action="<?php echo site_url('syst/edit_sysset_ok2'); ?>">
		<table align="center">
		<tr>
			<th>路口ID：</th>
			<td>
				<input type="text" name="kk_id" id="kk_id" value="<?php echo $KK_ID; ?>" readonly="readonly" /><span class="RED"><?php echo form_error('kk_id'); ?></span>
			</td>
		</tr>
		<tr>
			<th>路口名称：</th>
			<td>
				<input type="text" name="kk_name" id="kk_name" value="<?php echo $KK_NAME; ?>" /><span class="RED"><?php echo form_error('kk_name'); ?></span>
			</td>
		</tr>
		<tr>
			<th>存储服务器IP：</th>
			<td>
				<input type="text" name="server_ip" id="server_ip" value="<?php echo $KK_IMAGE_SERVER; ?>" /><span class="RED"><?php echo form_error('server_ip'); ?></span>
		    </td>
		</tr>
		<tr>
			<th>网关访问IP：</th>
			<td>
				<input type="text" name="access_ip" id="access_ip" value="<?php echo $KK_GA_ACCESS_IP; ?>" /><span class="RED"><?php echo form_error('access_ip'); ?></span>
		    </td>
		</tr>	
		<tr>
			<td>
				<input class="BUTBLACK" type="submit" name="submit_sys" value="修改" />
			</td>
			<td>
				<input class="BUTBLACK" type="button" name="goback" value="返回" onclick="javascript:history.go(-1);" />
			</td>
		</tr>
		
		</table>
	</form>
</div>
</body>
</html>
