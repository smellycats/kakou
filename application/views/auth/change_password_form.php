<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>无标题文档</title>
</head>
<body>
<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'		=> 'old_password',
	'size' 	=> 30,
	'value' => set_value('old_password')
);

$new_password = array(
	'name'	=> 'new_password',
	'id'		=> 'new_password',
	'size'	=> 30
);

$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'		=> 'confirm_new_password',
	'size' 	=> 30
);

?>

<fieldset>
<legend>用户密码修改</legend>
<?php echo form_open($this->uri->uri_string()); ?>

<?php echo $this->dx_auth->get_auth_error(); ?>

<dl>
	<dt><?php echo form_label('旧密码', $old_password['id']); ?></dt>
	<dd>
		<?php echo form_password($old_password); ?>
		<?php echo form_error($old_password['name']); ?>
	</dd>

	<dt><?php echo form_label('新密码', $new_password['id']); ?></dt>
	<dd>
		<?php echo form_password($new_password); ?>
		<?php echo form_error($new_password['name']); ?>
	</dd>

	<dt><?php echo form_label('确认新密码', $confirm_new_password['id']); ?></dt>
	<dd>
		<?php echo form_password($confirm_new_password); ?>
		<?php echo form_error($confirm_new_password['name']); ?>
	</dd>

	<dt></dt>
	<dd><?php echo form_submit('change', '修改密码'); ?></dd>
</dl>

<?php echo form_close(); ?>
</fieldset>

</body>
</html>