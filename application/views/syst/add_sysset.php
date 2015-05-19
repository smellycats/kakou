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
<h3><a>添加路口参数</a></h3>
<form method="post" action="<?php echo site_url('syst/add_sysset_ok'); ?>">
<p><label>路口名称：</label><input type="text" name="type_value" id="type_value" value="<?php echo set_value('type_value'); ?>"><?php echo form_error('type_value'); ?></p>
<p><label>别&nbsp;&nbsp;&nbsp;&nbsp;名：</label><input type="text" name="type_alias" id="type_alias" value="<?php echo set_value('type_alias'); ?>"><?php echo form_error('type_alias'); ?></p>
<p><label>卡口类型</label><input type="radio" name="type_def" value="0" checked/>卡口&nbsp;&nbsp;<input type="radio" name="type_def" value="1"/>电警</p>

<p><input type="submit" name="submit_sys" value="添加" /></p>
</form>
</div>
</body>
</html>
