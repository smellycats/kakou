
<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/syst/ipaccess_add" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<div class="unit">
				<label>起始IP：</label>
				<input id="ipaccess_add_minip" name="minip" type="text" class="required" />
			</div>
			<div class="unit">
				<label>结束IP：</label>
				<input id="ipaccess_add_maxip" name="maxip" type="text" />
			</div>
			<div class="unit">
				<label>状态：</label>
				<input id="ipaccess_add_banned" name="banned" type="checkbox" value="1" />
				<span style="color:blue">勾选禁用IP限制</span>
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