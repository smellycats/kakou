<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/user/add" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone)">
		<div class="pageFormContent" layoutH="58">
			<div class="unit">
				<label>客户号：</label>
				<input type="text" class="required alphanumeric"  name="clientName">
			</div>
			
			<div class="unit">
				<label>客户名称：</label>
				<input type="text" class="required" name="clientItem">
			</div>
			
			<div class="unit">
				<label>客户类型：</label>
				<input type="text" class="required" name="clientDo">
			</div>
			
			<div class="unit">
				<label>等级：</label>
				<input type="text" class="required" name="clientLev">
			</div>
			
			
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
			</div>
	</form>
</div>
