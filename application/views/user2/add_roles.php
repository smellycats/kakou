<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>

</head>
<body>
<div id="add_article">
<h2>��ӽ�ɫ</h2>
<form method="post" action="<?php echo site_url('user/add_roles'); ?>">
<!--<p><label>��ɫ����</label><input type="text" name="rolename" id="rolename" value="<?php echo set_value('rolename'); ?>"><?php echo form_error('rolename'); ?></p>
<p><label for="role_disable">״&nbsp;&nbsp;&nbsp;̬��</label><input type="checkbox" name="role_disable" id="role_disable" />����<span style="font-size:12;color:blue">��������ɫ,���ᶳ��������ص��ʻ�.��</span></p>
			-->
			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<th> ��ɫ����</th>
					<td><input type="text" name="rolename" id="rolename" value="<?php echo set_value('rolename'); ?>" /><span style="color:red">*</span>���20λ�ַ�<?php echo form_error('rolename'); ?></td>
				</tr>
				<tr>
					<th> ״̬��</th>
					<td><input type="checkbox" name="role_disable" id="role_disable" />����<span style="font-size:12;color:blue">��������ɫ,���ᶳ��������ص��ʻ�.��</span></td>
				</tr>
                <tr>
					<th> �����Ȩ�ޣ�</th>
					<td>
                    	<ul class="attr_list">
							<?php foreach($rights as $key=>$v): ?>
                            <li><label class="attr"><input type="checkbox" <?php echo in_array($key, $rights_post) ? 'checked="checked"': ''?> value="<?php echo $key; ?>" name="rights_post[]"><?php echo $v; ?></label></li>
							<?php endforeach; ?>
                        </ul>
                    </td>
				</tr>
                <tr>
					<th> ���ſ��ڣ�</th>
					<td>
                    	<ul class="attr_list">
							<?php foreach($openkakou as $key=>$v): ?>
                            <li><label class="attr"><input type="checkbox" <?php echo in_array($key, $openkakou_post) ? 'checked="checked"': ''?> value="<?php echo $key; ?>" name="openkakou_post[]"><?php echo $v; ?></label></li>
							<?php endforeach; ?>
                        </ul>
                    </td>
				</tr>
				<tr>
					<th></th>
					<td>
						<input type="submit" name="submit_role" value="���" />
						<input type="button" name="goback" value="����" onclick="javascript:history.go(-1);" />
					</td>
				</tr>
			</table>
<!--<p><input type="submit" name="submit_role" value="���" /></p>
-->
</form>
</div>
</body>
</html>
