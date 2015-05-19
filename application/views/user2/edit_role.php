<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<div id="edit_role">
<h2>修改角色</h2>
<form method="post" action="<?php echo site_url('user/edit_role_ok'); ?>">
    <input type="hidden" name="role_id" id="role_id" value="<?php echo $role_id; ?>"/>
			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<th> 角色名：</th>
					<td><input type="text" name="rolename" id="rolename" value="<?php echo $rolename ?>"><label style="font-size:14px;color:blue">*最多20位字符</label><?php echo form_error('rolename'); ?></td>
				</tr>
				<tr>
					<th> 状态：</th>
					<td><input type="checkbox" name="role_disable" id="role_disable" <?php echo $role_disable == '1' ? 'checked="checked"': ''?>value="1">锁定<span  style="font-size:14px;color:blue">（锁定角色,将会冻结所有相关的帐户.）</span></td>
				</tr>
                <tr>
					<th> 允许的权限：</th>
					<td>
                    	<ul class="attr_list">
							<?php
							 //$role->rights = explode(',', $role->rights);
							 foreach($rights as $key=>$v): ?>
                            <li><label class="attr"><input type="checkbox" <?php echo in_array($key, $rights_post) ? 'checked="checked"': ''?> value="<?php echo $key ?>" name="rights_post[]"><?php echo $v; ?></label></li>
							<?php endforeach; ?>
                        </ul>
                    </td>
				</tr>
                <tr>
					<th> 开放卡口：</th>
					<td>
                    	<ul class="attr_list">
							<?php 
							 //$role->openkakou = explode(',', $role->openkakou);
							 foreach($openkakou as $key=>$v): ?>
                            <li><label class="attr"><input type="checkbox" <?php echo in_array($key, $openkakou_post) ? 'checked="checked"': ''?> value="<?php echo $key; ?>" name="openkakou_post[]"><?php echo $v; ?></label></li>
							<?php endforeach; ?>
                        </ul>
                    </td>
				</tr>
				<tr>
					<th></th>
					<td>
						<input type="submit" name="submit_role" value="修改" />
						<input type="button" name="goback" value="返回" onclick="javascript:history.go(-1);" />
					</td>
				</tr>
			</table>
<!--<p><input type="submit" name="submit_role" value="添加" /></p>
-->
</form>
</div>
</body>
</html>
