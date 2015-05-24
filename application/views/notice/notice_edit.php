<script type="text/javascript">
	$(function(){
		$("#notice_edit_content").val(<?php echo '"'. $content .'"'?>);
		$("#notice_edit_banned").attr("checked",<?php echo $banned == '1' ? 'true' : 'false'; ?>);
	});	$("#notice_edit_id").val(<?php echo '"'. $id .'"'?>);
</script>

<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/syst/notice_edit" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<div class="unit">
				<input id="notice_edit_id" name="id" type="hidden" />
				<label>内容：</label>
				<textarea id="notice_edit_content" name="content" style="width:200px;height:100px;" ></textarea>
			</div>
			<div class="unit">
				<label>状态：</label>
				<input id="notice_edit_banned" name="banned" type="checkbox" value="1" />
				<span style="color:blue">勾选禁用公告</span>
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