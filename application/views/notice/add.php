

<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/notice/add" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<div class="unit">
				<label>内容：</label>
				<textarea id="notice_add_content" name="content" style="width:200px;height:100px;" ></textarea>
			</div>
			<div class="unit">
				<label>状态：</label>
				<input id="notice_add_banned" name="banned" type="checkbox" value="1" />
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