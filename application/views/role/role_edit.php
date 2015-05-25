<script type="text/javascript">

	var roleeditmenu_zTree;
	var roleeditmenu_setting = {
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
			onCheck: roleeditmenu_zTreeOnCheck
		}
	}

	function roleeditmenu_zTreeOnCheck(event, treeId, treeNode) { 
		var nodes = roleeditmenu_zTree.getCheckedNodes(true);
	    var strId = "";
	    for(var i=0; i<nodes.length; i++){
	    	if (strId == "") {
	    		strId += nodes[i].id;
	    	} else {
	    		strId += "," + nodes[i].id;
	    	}
	    }
	    $("#roleedit_menulimit").val(strId); 
	}
	
	var roleeditmenu_zNodes =[
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

	var roleeditplace_zTree;
	var roleeditplace_setting = {
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
			onCheck: roleeditplace_zTreeOnCheck
		}
	}

	function roleeditplace_zTreeOnCheck(event, treeId, treeNode) { 
		var nodes = roleeditplace_zTree.getCheckedNodes(true);
	    var strId = "";
	    for(var i=0; i<nodes.length; i++){
	    	if (strId == "") {
	    		strId += nodes[i].id;
	    	} else {
	    		strId += "," + nodes[i].id;
	    	}
	    }
	    $("#roleedit_placelimit").val(strId); 
	}
	
	var roleeditplace_zNodes =[
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
		$("#roleedit_Name").val('<?php echo $role['name']; ?>');


		$.fn.zTree.init($("#roleeditmenu_zTree"), roleeditmenu_setting, roleeditmenu_zNodes);
		roleeditmenu_zTree = $.fn.zTree.getZTreeObj('roleeditmenu_zTree');

		$.fn.zTree.init($("#roleeditplace_zTree"), roleeditplace_setting, roleeditplace_zNodes);
		roleeditplace_zTree = $.fn.zTree.getZTreeObj('roleeditplace_zTree');
	});

</script>

<div class="pageContent">
	<form method="post" action="<?php echo base_url(); ?>index.php/user/role_edit" class="pageForm required-validate" 
		onsubmit="return iframeCallback(this, dialogAjaxDone);">
		<div id="pollxxPanel" class="pageFormContent" layoutH="58">
			<dl>
				<dt style="width: 100px; text-align: right;">角色名：</dt>
				<dd>
					<input id="roleedit_Name" name="roleedit_Name" class="required" type="text" style="width: 280px;" maxlength="30"/>
					<input id="roleedit_Id" name="roleedit_Id" type="hidden" value="<?php echo $role['id']; ?>" />
				</dd>
			</dl>
			<dl style="width: 550px;" class="nowrap">
				<dt style="width: 100px; text-align: right;">锁定：</dt>
				<dd style="width: 400px;">
					<input id="roleedit_Disable" name="roleedit_Disable" type="checkbox" 
						<?php if ($role['disable'] == '1') { ?>checked="checked"<?php } ?> 
						value="1" />
				</dd>
			</dl>
			<dl style='width:500px;' class="nowrap">
				<dt style="width: 100px; text-align: right;">菜单权限：</dt>
				<dd style='width: 350px;'>
					<div style="width: 280px; overflow:auto; border:solid 1px #CCC; line-height:21px; background:#fff; height: 160px;">
						<ul id="roleeditmenu_zTree" class="ztree"></ul>		
					</div>
					<input id="roleedit_menulimit" name="roleedit_menulimit" type="hidden" 
						value="<?php echo $role['rights']; ?>" />
				</dd>
			</dl>

			<dl style='width:500px;' class="nowrap">
				<dt style="width: 100px; text-align: right;">卡口权限：</dt>
				<dd style='width: 350px;'>
					<div style="width: 280px; overflow:auto; border:solid 1px #CCC; line-height:21px; background:#fff; height: 160px;">
						<ul id="roleeditplace_zTree" class="ztree"></ul>		
					</div>
					<input id="roleedit_placelimit" name="roleedit_placelimit" class="" type="hidden" 
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