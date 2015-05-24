<script type="text/javascript">
	$(function(){
		$("#user_edit_id").val(<?php echo '"'. $user['id'] .'"'?>);
		$("#user_edit_username").val(<?php echo '"'. $user['username'] .'"'?>);
		$("#user_edit_realname").val(<?php echo '"'. $user['realname'] .'"'?>);
		$("#user_edit_role_id").val(<?php echo '"'. $user['role_id'] .'"'?>);
		$("#user_edit_identity").val(<?php echo '"'. $user['identity'] .'"'?>);
		$("#user_edit_phone").val(<?php echo '"'. $user['phone'] .'"'?>);
		$("#user_edit_department").val(<?php echo '"'. $user['department'] .'"'?>);
		$("#user_edit_banned").attr("checked",<?php echo $user['banned'] == '1' ? 'true' : 'false'; ?>);
		$(<?php echo '"'.'#at'.$user['access_type'].'"';?>).attr("checked","checked");
		$("#user_edit_limit_login_address").val(<?php echo '"'. $user['limit_login_address'] .'"'?>);
		$("#user_edit_memo").val(<?php echo '"'. $user['memo'] .'"'?>);
	});
</script>

<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/user/user_edit" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<div class="unit">
				<label>用户名：</label>
				<input id="user_edit_id" name="id" type="hidden" />
				<input id="user_edit_username" name="username" readonly="true" type="text" maxlength="16"/>
			</div>
			<div class="unit">
				<label>真实名：</label>
				<input id="user_edit_realname" name="realname" type="text" maxlength="16" />
			</div>
			<div class="unit">
				<label>角色：</label>
				<select id="user_edit_role_id" name="role_id" class="required combox">
					<?php foreach ($roles as $row): ?>
					<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="unit">
				<label>身份证号码：</label>
				<input id="user_edit_identity" name="identity" type="text" maxlength="32" />
			</div>
			<div class="unit">
				<label>联系电话：</label>
				<input id="user_edit_phone" name="phone" type="text" maxlength="16" />
			</div>
			<div class="unit">
				<label>单位：</label>
				<input id="user_edit_department" name="department" type="text" maxlength="40" />
			</div>
			<div class="unit">
				<label>用户状态：</label>
				<input id="user_edit_banned" name="banned" type="checkbox" value="1" />
				<span style="color:blue">锁定 (锁定帐户,使其无法登录系统)</span>
			</div>
			<div class="unit">
				<label>登录模式：</label>
				<input id="at0" name="access_type" type="radio" value="0" checked="checked"/>帐号密码<input id="at1" type="radio" name="access_type" value="1"/>数字证书<input id="at2" type="radio" name="access_type" value="2"/>混合模式
			</div>
			<div class="unit">
				<label>限制IP访问：</label>
				<textarea id="user_edit_limit_login_address" name="limit_login_address" style="width:180;height:80px;" ></textarea>
			</div>
			<div class="unit">
				<label>备注：</label>
				<textarea id="user_edit_memo" name="memo" style="width:180;height:80px;" ></textarea>
			</div>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>