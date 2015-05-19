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
#edit_alarmpoint{
width:600px;
margin-top:5px;
font-size:12px;
margin-left:25px;
margin-bottom:5px;
}
#edit_alarmpoint h3{
font-size:14px;
padding-bottom:10px;
}
#edit_alarmpoint p{
margin-top:5px;
}
#edit_alarmpoint p label{
padding-right:5px;
}
#edit_alarmpoint p label span a{
color:red;
margin-top:5px;
}
#article_source,#article_author{
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
<div id="edit_alarmpoint">
<h3><a>修改报警点名称</a></h3>
	<form method="post" action="<?php echo site_url('syst/edit_alarmpoint_ok'); ?>">
	<?php foreach ($alarm_point as $alp):?>
	    <table class="form_table">
			<tr>
				<th>报警点IP：</th>
				<td>
					<input type="text" name="alarm_ip" id="alarm_ip" value="<?php echo $alp->ALARM_IP; ?>" readonly="readonly"/>
				</td>
			</tr>
			<tr>
				<th>报警点名称：</th>
				<td>
					<input type="text" name="alarm_name" id="alarm_name" value="<?php echo $alp->ALARM_NAME; ?>" />
				</td>
			</tr>
		    <?php endforeach;?>
		    <tr>
		        <td>
		    		<input type="submit" name="submit_alarmpoint" value="修改内容" />
		    	</td>
		    </tr>
	    </table>
	</form>
</div>
</body>
</html>