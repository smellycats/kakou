<script type="text/javascript">

	var roleaddmenu_zTree;
	var roleaddmenu_setting = {
		check: {
			enable: true
			},
		data: {
			simpleData: {
				enable: true,
				idKey: "id",
				pIdKey: "pId"
			}
		},
		callback: {
			onCheck: roleaddmenu_zTreeOnCheck
		}
	}

	function roleaddmenu_zTreeOnCheck(event, treeId, treeNode) { 
		var nodes = roleaddmenu_zTree.getCheckedNodes(true);
	    var strId = "";
	    for(var i=0; i<nodes.length; i++){
	    	if (strId == "") {
	    		strId += nodes[i].id;
	    	} else {
	    		strId += "," + nodes[i].id;
	    	}
	    }
	    $("#roleadd_menulimit").val(strId); 
	}
	
	var roleaddmenu_zNodes =[
			<?php
				if (!empty($data_menus)) {
					for ($i=0; $i < count($data_menus); $i++) { 
			?>
			{id:"<?php echo $data_menus[$i]['id']; ?>", 
				pId:"<?php echo $data_menus[$i]['pId']; ?>", 
				name:"<?php echo $data_menus[$i]['name']; ?>"}<?php if (count($data_menus) != ($i+1)) { ?>,<?php } ?>

			<?php
					}
				}
			?>
			];

	var roleaddplace_zTree;
	var roleaddplace_setting = {
		check: {
			enable: true
			},
		data: {
			simpleData: {
				enable: true,
				idKey: "id",
				pIdKey: "pId"
			}
		},
		callback: {
			onCheck: roleaddplace_zTreeOnCheck
		}
	}

	function roleaddplace_zTreeOnCheck(event, treeId, treeNode) { 
		var nodes = roleaddplace_zTree.getCheckedNodes(true);
	    var strId = "";
	    for(var i=0; i<nodes.length; i++){
	    	if (strId == "") {
	    		strId += nodes[i].id;
	    	} else {
	    		strId += "," + nodes[i].id;
	    	}
	    }
	    $("#roleadd_placelimit").val(strId); 
	}
	
	var roleaddplace_zNodes =[
			<?php
				if (!empty($data_places)) {
					for ($i=0; $i < count($data_places); $i++) { 
			?>
			{id:"<?php echo $data_places[$i]['id']; ?>", 
				pId:"<?php echo $data_places[$i]['pId']; ?>", 
				name:"<?php echo $data_places[$i]['name']; ?>"}<?php if (count($data_places) != ($i+1)) { ?>,<?php } ?>

			<?php
					}
				}
			?>
			];		

	$(document).ready(function(){
		$.fn.zTree.init($("#roleaddmenu_zTree"), roleaddmenu_setting, roleaddmenu_zNodes);
		roleaddmenu_zTree = $.fn.zTree.getZTreeObj('roleaddmenu_zTree');

		$.fn.zTree.init($("#roleaddplace_zTree"), roleaddplace_setting, roleaddplace_zNodes);
		roleaddplace_zTree = $.fn.zTree.getZTreeObj('roleaddplace_zTree');
	});

</script>

<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/user/role_add" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<dl>
				<dt style="width: 100px; text-align: right;">角色名：</dt>
				<dd>
					<input id="roleadd_Name" name="roleadd_Name" class="required" type="text" style="width: 280px;" maxlength="30"/>
					
				</dd>
			</dl>
			<dl style="width: 550px;" class="nowrap">
				<dt style="width: 100px; text-align: right;">锁定：</dt>
				<dd style="width: 400px;">
					<input id="roleadd_Disable" name="roleadd_Disable" type="checkbox" value="1" />
				</dd>
			</dl>
			<dl style='width:500px;' class="nowrap">
				<dt style="width: 100px; text-align: right;">菜单权限：</dt>
				<dd style='width: 350px;'>
					<div style="width: 280px; overflow:auto; border:solid 1px #CCC; line-height:21px; background:#fff; height: 160px;">
						<ul id="roleaddmenu_zTree" class="ztree"></ul>		
					</div>
					<input id="roleadd_menulimit" name="roleadd_menulimit" type="hidden" />
				</dd>
			</dl>

			<dl style='width:500px;' class="nowrap">
				<dt style="width: 100px; text-align: right;">卡口权限：</dt>
				<dd style='width: 350px;'>
					<div style="width: 280px; overflow:auto; border:solid 1px #CCC; line-height:21px; background:#fff; height: 160px;">
						<ul id="roleaddplace_zTree" class="ztree"></ul>		
					</div>
					<input id="roleadd_placelimit" name="roleadd_placelimit" class="" type="hidden" />
				</dd>
			</dl>

		</div>
		<div class="formBar" style="text-align: center; position: relative;">
			<div style="clear: both; width: 95px; text-align: center; position: absolute; left: 50%; margin-left: -45px;">
				<div class="button" style="margin-right: 10px;">
					<div class="buttonContent">
						<button type="submit">添加</button>
					</div>
				</div>
				<div class="button">
					<div class="buttonContent">
						<button type="button" class="close">取消</button>
					</div>
				</div>
				<div style="clear: both;">
				</div>
			</div>
		</div>
	</form>
</div>