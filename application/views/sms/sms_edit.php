<script type="text/javascript">
	$(function(){
		$("#sms_edit_id").val(<?php echo '"'. $id .'"'?>);
		$("#sms_edit_tel").val(<?php echo '"'. $tel .'"'?>);
		$("#sms_edit_mark").val(<?php echo '"'. $mark .'"'?>);
	});
</script>

<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/logo/sms_edit" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<div class="unit">
				<input id="sms_edit_id" name="id" type="hidden" />
				<label>电话号码：</label>
				<textarea id="sms_edit_tel" name="tel" style="width:180px;height:80px;" ></textarea>
			</div>
			<div class="unit">
				<label>备注：</label>
				<textarea id="sms_edit_mark" name="mark" style="width:180px;height:80px;" ></textarea>
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