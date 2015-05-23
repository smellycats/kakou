
<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/logo/sms_add" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="158">
			<div class="unit">
				<label>电话号码：</label>
				<textarea id="sms_add_tel" name="tel" style="height:60px;" ></textarea>
			</div>
			<div class="unit">
				<label>备注：</label>
				<textarea id="sms_add_mark" name="mark" style="height:60px;" ></textarea>
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