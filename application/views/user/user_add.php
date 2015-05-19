
<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/user/user_add" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<div class="unit">
				<label>用户名：</label>
				<input id="user_add_username" name="user_add_username" class="required" type="text" maxlength="16"/>
			</div>
			<div class="unit">
				<label>真实名：</label>
				<input id="user_add_realname" name="user_add_realname" type="text" maxlength="16" />
			</div>
			<div class="unit">
				<label>角色：</label>
				<select id="user_add_role_id" name="user_add_role_id" class="required combox">
					<?php foreach ($roles as $row): ?>
					<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="unit">
				<label>身份证号码：</label>
				<input id="user_add_identity" name="user_add_identity" type="text" maxlength="32" />
			</div>
			<div class="unit">
				<label>联系电话：</label>
				<input id="user_add_phone" name="user_add_phone" type="text" maxlength="16" />
			</div>
			<div class="unit">
				<label>密码：</label>
				<input id="user_add_pwd" name="user_add_pwd"  type="password" class="required alphanumeric" minlength="6" maxlength="20" alt="字母、数字、下划线 6-20位"/>		
			</div>
			<div class="unit">
				<label>确认密码：</label>
				<input name="user_add_pwd2"  type="password" class="required" equalto="#user_add_pwd"/>
			</div>
			<div class="unit">
				<label>单位：</label>
				<input id="user_add_dadepartment" name="user_add_dadepartment" type="text" maxlength="40" />
			</div>
			<div class="unit">
				<label>用户状态：</label>
				<input id="user_add_banned" name="user_add_banned" type="checkbox" value="1" />
				<span style="color:blue">锁定 (锁定帐户,使其无法登录系统)</span>
			</div>
			<div class="unit">
				<label>登录模式：</label>
				<input id="user_add_access_type" name="user_add_access_type" type="radio" value="0" checked="checked"/>账号密码<input type="radio" name="user_add_access_type" value="1"/>数字证书<input type="radio" name="user_add_access_type" value="2"/>混合模式
			</div>
			<div class="unit">
				<label>限制IP访问：</label>
				<textarea id="user_add_limit_login_address" name="user_add_limit_login_address" style="height:60px;" ></textarea>
			</div>
			<div class="unit">
				<label>备注：</label>
				<textarea id="user_add_memo" name="user_add_memo" style="height:60px;" ></textarea>
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