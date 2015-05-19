<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>

</head>
<body>
<div id="add_user">
<h2>����û�</h2>
<form method="post" action="<?php echo site_url('user/add_user_ok'); ?>">
	<table class="form_table">
		<tr>
			<th>�ʺ����ƣ����ţ���</th>
			<td height="24">
				<input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" /><span style="color:red">*</span><?php echo form_error('username'); ?>
			</td>
		</tr>
		<tr>
			<th>��&nbsp;&nbsp;&nbsp;����</th>
			<td height="24">
				<input type="text" name="realname" id="realname" value="<?php echo set_value('realname'); ?>" /><span style="color:red">*</span><?php echo form_error('realname'); ?>
			</td>
		</tr>
		<tr>
			<th>���֤���룺</th>
			<td height="24">
				<input type="text" name="identity" id="identity" value="<?php echo set_value('identity'); ?>" /><span style="color:blue">����֤��/���ģʽ��¼����</span><?php echo form_error('identity'); ?>
			</td>
		</tr>
		<tr>
			<th>��ϵ�绰��</th>
			<td height="24">
				<input type="text" name="phone" id="phone" value="<?php echo set_value('phone'); ?>" /><?php echo form_error('phone'); ?>
			</td>
		</tr>	
		<tr>
			<th>��&nbsp;&nbsp;&nbsp;�룺</th>
			<td height="24">
				<input type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" /><span style="color:red">*</span><?php echo form_error('password'); ?>
			</td>
		</tr>
		<tr>
			<th>ȷ�����룺</th>
			<td height="24">
				<input type="password" name="passconf" id="passconf" value="<?php echo set_value('passconf'); ?>" /><span style="color:red">*</span><?php echo form_error('passconf'); ?>
			</td>
		</tr>
		<tr>
			<th>��&nbsp;&nbsp;&nbsp;λ��</th>
			<td height="24">
				<input type="text" name="department" id="department" value="<?php echo set_value('department'); ?>" /><?php echo form_error('department'); ?>
			</td>
		</tr>
		<tr>
			<th>��&nbsp;&nbsp;&nbsp;ɫ��</th>
			<td height="24">
				<select name="role_id">
				<?php foreach ($roles as $role): ?>
				<option value="<?php echo $role->id; ?>"><?php echo $role->name; ?></option>
				<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>�û�״̬��</th>
			<td height="20">
				<input type="checkbox" name="banned" id="banned" value="1" /><span style="color:blue">���� (�����ʻ�,ʹ���޷���¼ϵͳ)</span> <?php echo form_error('banned'); ?>
			</td>
		</tr>
		<tr>
			<th>����IP���ʣ�</th>
			<td height="24">
				<input type="text" name="limit_login_address" id="limit_login_address" value="<?php echo set_value('limit_login_address'); ?>" /><span style="color:blue">(���IP,����","�ָ�. ������,������.)</span><?php echo form_error('limit_login_address'); ?>
			</td>
		</tr>
		<tr>
			<th>��¼ģʽ��</th>
			<td height="24">
				<input type="radio" name="access_type" id="access_type" value="0" checked="checked"/>�ʺ�����&nbsp;<input type="radio" name="access_type" value="1"/>����֤��&nbsp;<input type="radio" name="access_type" value="2"/>���ģʽ
			</td>
		</tr>
		<tr>
			<th>��ע��</th>
			<td colspan="2">
				<textarea name="memo" id="memo" style="width:260px; height:60px"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" name="submit_user" value="����û�" />
				<input type="button" name="goback" value="����" onclick="javascript:history.go(-1);" />
			</td>
		</tr>
	</table>
</form>
</div>
</body>
</html>
