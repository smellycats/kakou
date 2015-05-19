<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>无标题文档</title>
<style type="text/css">
*{
margin:0;
padding:0;
}
body {
margin-left: 3px;
background:#fff;
}
a{
text-decoration:none;
color: #344b50;
}
span{
color: red;
}
#add_sysset{
width:600px;
margin-top:5px;
font-size:12px;
margin-left:25px;
margin-bottom:5px;
}
#add_sysset h3{
font-size:14px;
padding-bottom:10px;
}
#add_sysset p{
margin-top:5px;
}
#roles_source,#article_author{
background:#fff;
border:1px solid #abc6dd;
width:100px;
height:20px;
}
input[type=submit]{
width:90px;
height:25px;
background:#efefef;
border:1px solid #abc6dd;
}
#article_title{
background:#fff;
border:1px solid #abc6dd;
width:400px;
height:20px;
}
</style>
</head>
<body>
<div id="add_sysset">
<h3><a>修改路口参数</a></h3>
	<form method="post" action="<?php echo site_url('syst/edit_sysset_ok'); ?>">
		<table class="form_table">
		<tr>
			<td>
				<input type="hidden" name="id" id="id" value="<?php echo $config_info->ID; ?>" />
			</td>
		</tr>
		<tr>
			<th>路口名称：</th>
			<td>
				<input type="text" name="type_value" id="type_value" value="<?php echo $config_info->TYPE_VALUE; ?>" /><?php echo form_error('type_value'); ?>
			</td>
		</tr>
		<tr>
			<th>别&nbsp;&nbsp;&nbsp;&nbsp;名：</th>
			<td>
				<input type="text" name="type_alias" id="type_alias" value="<?php echo $config_info->TYPE_ALIAS; ?>" /><?php echo form_error('type_alias'); ?>
			</td>
		</tr>
		<tr>
			<th>卡口类型：</th>
			<td>
				<input type="radio" name="type_def" value="0" <?php if ($config_info->TYPE_DEF == 0)echo 'checked'?>/>卡口&nbsp;&nbsp;<input type="radio" name="type_def" value="1" <?php if ($config_info->TYPE_DEF == 1)echo 'checked'?> />电警
		    </td>
		</tr>
		
		<tr>
			<td>
				<input type="submit" name="submit_sys" value="修改" />
			</td>
		</tr>
		
		</table>
	</form>
</div>
</body>
</html>
