<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>

</head>
<body>
<div id="edit_user">
<h2>�޸��û���ɫ</h2>
<form method="post" action="<?php echo site_url('user/edit_user_ok'); ?>">
	<table class="form_table">
		<?php foreach ($user as $us):?>
		<tr><td><input type="hidden" name="user_id" value="<?php echo $us->id; ?>"/></td></tr>
		<tr>
			<th>�ʺ����ƣ����ţ���</th>
	    	<td height="24"><input type="text" name="username" id="username" value="<?php echo $us->username; ?>" disabled="disabled"/></td>
		</tr>
		<tr>
			<th>��&nbsp;&nbsp;&nbsp;����</th>
			<td height="24">
				<input type="text" name="realname" id="realname" value="<?php echo $us->realname; ?>" /><span style="color:red">*</span><?php echo form_error('realname'); ?>
			</td>
		</tr>
		<tr>
			<th>���֤���룺</th>
			<td height="24">
				<input type="text" name="identity" id="identity" value="<?php echo $us->identity; ?>" /><span style="color:blue">����֤��/���ģʽ��¼����</span><?php echo form_error('identity'); ?>
			</td>
		</tr>
		<tr>
			<th>��ϵ�绰��</th>
			<td height="24">
				<input type="text" name="phone" id="phone" value="<?php echo $us->phone; ?>" /><?php echo form_error('phone'); ?>
			</td>
		</tr>	
		<tr>
			<th>��&nbsp;&nbsp;&nbsp;λ��</th>
			<td height="24"><input type="text" name="department" id="department" value="<?php echo $us->department; ?>" /><?php echo form_error('department'); ?></td>
		</tr>
		<tr>
			<th>��&nbsp;&nbsp;&nbsp;ɫ��</th>
			<td height="24">
				<select name="role_id">
				<?php foreach ($roles as $role): ?>
				<option value="<?php echo $role->id; ?>"<?php if ($us->role_id==$role->id){echo " selected";} ?>><?php echo $role->name; ?></option>
				<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th>�û�״̬��</th>
			<td height="24"><input type="checkbox" name="banned" id="banned" <?php echo $us->banned == '1' ? 'checked="checked"': ''?> value="1" /><span style="color:blue">���� (�����ʻ�,ʹ���޷���¼ϵͳ)</span> <?php echo form_error('banned'); ?></td>
		</tr>
		<tr>
			<th>����IP���ʣ�</th>
			<td height="24">
				<input type="text" name="limit_login_address" id="limit_login_address" value="<?php echo $us->limit_login_address; ?>" /><span style="color:blue">(���IP,����","�ָ�. ������,������.)</span><?php echo form_error('limit_login_address'); ?>
			</td>
		</tr>
		<tr>
			<th>��¼ģʽ��</th>
			<td height="24">
				<input type="radio" name="access_type" id="access_type" value="0" <?php if ($us->access_type == 0) echo 'checked'?>/>�ʺ�����&nbsp;<input type="radio" name="access_type" value="1" <?php if ($us->access_type == 1) echo 'checked'?>/>����֤��&nbsp;<input type="radio" name="access_type" value="2" <?php if ($us->access_type == 2) echo 'checked'?>/>���ģʽ
			</td>
		</tr>
		<tr>
			<th>��ע��</th>
			<td colspan="2">
				<textarea name="memo" id="memo" style="width:260px; height:60px"><?php echo $us->memo; ?></textarea>
			</td>
		</tr>
		<?php endforeach;?>
		<tr>
			<td><input type="submit" name="submit_user" value="�޸�����" />
			<input type="button" name="goback" value="����" onclick="javascript:history.go(-1);" /></td>
		</tr>
	</table>
</form>
</div>
</body>
</html>
