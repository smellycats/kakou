<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<div id="add_user">
<h2>添加用户</h2>
<form method="post" action="<?php echo site_url('user/add_user_ok'); ?>">
	<table class="form_table">
		<tr>
			<th>帐号名称（警号）：</th>
			<td height="24">
				<input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" /><span style="color:red">*</span><?php echo form_error('username'); ?>
			</td>
		</tr>
		<tr>
			<th>姓&nbsp;&nbsp;&nbsp;名：</th>
			<td height="24">
				<input type="text" name="realname" id="realname" value="<?php echo set_value('realname'); ?>" /><span style="color:red">*</span><?php echo form_error('realname'); ?>
			</td>
		</tr>
		<tr>
			<th>身份证号码：</th>
			<td height="24">
				<input type="text" name="identity" id="identity" value="<?php echo set_value('identity'); ?>" /><span style="color:blue">数字证书/混合模式登录必填</span><?php echo form_error('identity'); ?>
			</td>
		</tr>
		<tr>
			<th>联系电话：</th>
			<td height="24">
				<input type="text" name="phone" id="phone" value="<?php echo set_value('phone'); ?>" /><?php echo form_error('phone'); ?>
			</td>
		</tr>	
		<tr>
			<th>密&nbsp;&nbsp;&nbsp;码：</th>
			<td height="24">
				<input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" /><span style="color:red">*</span><?php echo form_error('password'); ?>
			</td>
		</tr>
		<tr>
			<th>确认密码：</th>
			<td height="24">
				<input type="password" name="passconf" id="passconf" value="<?php echo set_value('passconf'); ?>" /><span style="color:red">*</span><?php echo form_error('passconf'); ?>
			</td>
		</tr>
		<tr>
			<th>单&nbsp;&nbsp;&nbsp;位：</th>
			<td height="24">
				<input type="text" name="department" id="department" value="<?php echo set_value('department'); ?>" /><?php echo form_error('department'); ?>
			</td>
		</tr>
		<tr>
			<th>角&nbsp;&nbsp;&nbsp;色：</th>
			<td height="24">
				<select name="role_id">
				<?php foreach ($roles as $role): ?>
				<option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
				<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>用户状态：</th>
			<td height="20">
				<input type="checkbox" name="banned" id="banned" value="1" /><span style="color:blue">锁定 (锁定帐户,使其无法登录系统)</span> <?php echo form_error('banned'); ?>
			</td>
		</tr>
		<tr>
			<th>限制IP访问：</th>
			<td height="24">
				<input type="text" name="limit_login_address" id="limit_login_address" value="<?php echo set_value('limit_login_address'); ?>" /><span style="color:blue">(多个IP,请用","分隔. 不限制,请留空.)</span><?php echo form_error('limit_login_address'); ?>
			</td>
		</tr>
		<tr>
			<th>登录模式：</th>
			<td height="24">
				<input type="radio" name="access_type" id="access_type" value="0" checked="checked"/>帐号密码&nbsp;<input type="radio" name="access_type" value="1"/>数字证书&nbsp;<input type="radio" name="access_type" value="2"/>混合模式
			</td>
		</tr>
		<tr>
			<th>备注：</th>
			<td colspan="2">
				<textarea name="memo" id="memo" style="width:260px; height:60px"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" name="submit_user" value="添加用户" />
				<input type="button" name="goback" value="返回" onclick="javascript:history.go(-1);" />
			</td>
		</tr>
	</table>
</form>
</div>
</body>
</html>
