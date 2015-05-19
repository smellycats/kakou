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
<h3><a>关联报警点</a></h3>
<form method="post" action="<?php echo site_url('syst/edit_alarmrel_ok'); ?>">
			<table class="form_table">
				<col width="150px" />
				<col />
		    	<tr>
					<th> 路口名称(卡口点)：</th>
					<td><input type="hidden"  value="<?php echo $computer->COMPUTERNAME; ?>" name="kakou_ip" /><?php echo "[$computer->COMPUTERNAME]" . " - " ."$computer->ROADNAME"; ?></td>
				</tr>
		    	<tr>
					<th> 关联的报警点：</th>
					<td>
                    	<ul class="attr_list">
							<?php 
							 foreach($alarm_point as $point): ?>
                            <li><label class="attr"><input type="checkbox" <?php echo in_array($point->ALARM_IP, $kktoalarm) ? 'checked="checked"' : '' ?> value="<?php echo $point->ALARM_IP; ?>" name="alarmpoint[]" /><?php echo "[$point->ALARM_IP]" . " - " ."$point->ALARM_NAME"; ?></label></li>
							<?php endforeach; ?>
                        </ul>
                    </td>
   				</tr>
				<tr>
					<th></th>
					<td>
						<input type="submit" name="submit_alarmrel" value="保存" />
					</td>
				</tr>
            </table>
</form>

</div>
</body>
</html>
