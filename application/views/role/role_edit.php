<script type="text/javascript">

	var role_editmenu_zTree;
	var role_editmenu_setting = {
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
			onCheck: role_editmenu_zTreeOnCheck
		}
	}

	function role_editmenu_zTreeOnCheck(event, treeId, treeNode) { 
		var nodes = role_editmenu_zTree.getCheckedNodes(true);
	    var strId = "";
	    for(var i=0; i<nodes.length; i++){
	    	if (strId == "") {
	    		strId += nodes[i].id;
	    	} else {
	    		strId += "," + nodes[i].id;
	    	}
	    }
	    $("#role_edit_menulimit").val(strId); 
	}
	
	var role_editmenu_zNodes =[
			<?php
				if (!empty($data_menus)) {
					for ($i=0; $i < count($data_menus); $i++) { 
			?>
			{id:"<?php echo $data_menus[$i]['id']; ?>", 
				pId:"<?php echo $data_menus[$i]['pId']; ?>", 
				<?php if (!empty($role['tree_menus']) && in_array($data_menus[$i]['id'], $role['tree_menus'])) { ?>
				checked: true,	
				<?php } else { ?>
				checked: false,		
				<?php } ?>
				name:"<?php echo $data_menus[$i]['name']; ?>"}<?php if (count($data_menus) != ($i+1)) { ?>,<?php } ?>

			<?php
					}
				}
			?>
			];

	var role_editplace_zTree;
	var role_editplace_setting = {
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
			onCheck: role_editplace_zTreeOnCheck
		}
	}

	function role_editplace_zTreeOnCheck(event, treeId, treeNode) { 
		var nodes = role_editplace_zTree.getCheckedNodes(true);
	    var strId = "";
	    for(var i=0; i<nodes.length; i++){
	    	if (strId == "") {
	    		strId += nodes[i].id;
	    	} else {
	    		strId += "," + nodes[i].id;
	    	}
	    }
	    $("#role_edit_placelimit").val(strId); 
	}
	
	var role_editplace_zNodes =[
			<?php
				if (!empty($data_places)) {
					for ($i=0; $i < count($data_places); $i++) { 
			?>
			{id:"<?php echo $data_places[$i]['id']; ?>", 
				pId:"<?php echo $data_places[$i]['pId']; ?>", 
				<?php if (!empty($role['tree_place']) && in_array($data_places[$i]['id'], $role['tree_place'])) { ?>
				checked: true,	
				<?php } else { ?>
				checked: false,		
				<?php } ?>
				name:"<?php echo $data_places[$i]['name']; ?>"}<?php if (count($data_places) != ($i+1)) { ?>,<?php } ?>

			<?php
					}
				}
			?>
			];		

	$(document).ready(function(){
		$("#role_edit_Name").val('<?php echo $role['name']; ?>');


		$.fn.zTree.init($("#role_editmenu_zTree"), role_editmenu_setting, role_editmenu_zNodes);
		role_editmenu_zTree = $.fn.zTree.getZTreeObj('role_editmenu_zTree');

		$.fn.zTree.init($("#role_editplace_zTree"), role_editplace_setting, role_editplace_zNodes);
		role_editplace_zTree = $.fn.zTree.getZTreeObj('role_editplace_zTree');
	});

</script>

<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/role/role_edit" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<dl>
				<dt style="width: 100px; text-align: right;">角色名：</dt>
				<dd>
					<input id="role_edit_Name" name="role_edit_Name" class="required" type="text" style="width: 280px;" maxlength="30"/>
					<input id="role_edit_Id" name="role_edit_Id" type="hidden" value="<?php echo $role['id']; ?>" />
				</dd>
			</dl>
			<dl style="width: 550px;" class="nowrap">
				<dt style="width: 100px; text-align: right;">锁定：</dt>
				<dd style="width: 400px;">
					<input id="role_edit_Disable" name="role_edit_Disable" type="checkbox" 
						<?php if ($role['disable'] == '1') { ?>checked="checked"<?php } ?> 
						value="1" />
				</dd>
			</dl>
			<dl style='width:500px;' class="nowrap">
				<dt style="width: 100px; text-align: right;">菜单权限：</dt>
				<dd style='width: 350px;'>
					<div style="width: 280px; overflow:auto; border:solid 1px #CCC; line-height:21px; background:#fff; height: 160px;">
						<ul id="role_editmenu_zTree" class="ztree"></ul>		
					</div>
					<input id="role_edit_menulimit" name="role_edit_menulimit" type="hidden" 
						value="<?php echo $role['rights']; ?>" />
				</dd>
			</dl>

			<dl style='width:500px;' class="nowrap">
				<dt style="width: 100px; text-align: right;">卡口权限：</dt>
				<dd style='width: 350px;'>
					<div style="width: 280px; overflow:auto; border:solid 1px #CCC; line-height:21px; background:#fff; height: 160px;">
						<ul id="role_editplace_zTree" class="ztree"></ul>		
					</div>
					<input id="role_edit_placelimit" name="role_edit_placelimit" class="" type="hidden" 
						value="<?php echo $role['openkakou']; ?>" />
				</dd>
			</dl>

		</div>
		<div class="formBar" style="text-align: center; position: relative;">
			<div style="clear: both; width: 95px; text-align: center; position: absolute; left: 50%; margin-left: -45px;">
				<div class="button" style="margin-right: 10px;">
					<div class="buttonContent">
						<button type="submit">修改</button>
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