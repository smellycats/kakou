
<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/admin/setPassword" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<div class="unit">
				<label>旧密码：</label>
				<input id="password_old" name="password_old" type="password" maxlength="20" />
			</div>
			<div class="unit">
				<label>新密码：</label>
				<input id="password_new" name="password_new"  type="password" class="required alphanumeric" minlength="6" maxlength="20" alt="字母、数字、下划线 6-20位"/>		
			</div>
			<div class="unit">
				<label>确认密码：</label>
				<input name="password_new2"  type="password" class="required" equalto="#password_new"/>
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