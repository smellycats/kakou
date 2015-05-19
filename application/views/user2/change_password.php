<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<div id="change_password">
<h2>用户密码修改</h2>
<form method="post" action="<?php echo site_url('user/change_password_ok'); ?>">
	<table align="center" class="form_table">
		<tr>
			<th>旧密码：</th>
			<td height="24">
				<input type="password" name="old_password" id="old_password" value="<?php echo set_value('old_password'); ?>" /><span style="color:red">*<?php echo $message; ?></span>
			</td>
		</tr>
		<tr>
			<th>新密码：</th>
			<td height="24">
				<input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" /><span style="color:red">*<?php echo form_error('password'); ?></span>
			</td>
		</tr>
		<tr>
			<th>确认新密码：</th>
			<td height="24">
				<input type="password" name="passconf" id="passconf" value="<?php echo set_value('passconf'); ?>" /><span style="color:red">*<?php echo form_error('passconf'); ?></span>
			</td>
		</tr>

		<tr>
			<td>
				<input type="submit" name="submit_user" value="修改" />
			</td>
		</tr>
	</table>
</form>
</div>
</body>
</html>
