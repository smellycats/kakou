<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title><?php echo $this->config->item('title');?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/color.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css"?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js"?>"></script>

</head>

<body>
	<div id="p" class="easyui-panel" style="width:100%;">
		<div align="center">
			<table id="tt" class="easyui-datagrid" style="width:700px;">
				<thead>
					<tr>
						<th field="rolename" width="50" align="center">角色名</th>
						<th field="bannedname" width="40" align="center">锁定</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	
	<div id="tb" style="padding:3px 20px">
		<div align="right">
			<input id="rolename" class="easyui-textbox" data-options="prompt:'输入角色名'" style="width:120px;" />
			
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">查询</a>
		</div>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width: 500px; padding: 10px 20px;"
	       closed="true" buttons="#dlg-buttons"> 
		<div style="padding:10px 60px 20px 60px">
		    <form id="ff" method="post">
		    	<table cellpadding="5">
		    		<tr>
		    			<td>角色名:</td>
		    			<td><input id="rolename" name="rolename" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
											rolename:['#rolename']
										}
						    "></input>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>锁定:</td>
		    			<td>
		    				<input id="disable" name="disable" type="checkbox" value="1"></input>
		    				<a href="#" title="锁定角色,将会冻结所有相关的帐户" class="easyui-tooltip" position="right">提示</a>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>菜单权限:</td>
		    			<td>
    						<select id="menu" name="menu[]" class="easyui-combotree" multiple style="width:200px;"></select> 
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>卡口权限:</td>
		    			<td>
    						<select id="place" name="place[]" class="easyui-combotree" multiple style="width:200px;"></select> 
		    			</td>
		    		</tr>
		    	</table>
		    </form>
	    </div>
	</div> 

	<div id="dlg-buttons">  
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="save()" style="width:90px">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')" iconcls="icon-cancel" style="width:90px">取消</a> 
    </div>
	
	<script type="text/javascript">
		$('#tt').datagrid({
			title:<?php echo "'".$title."'";?>,
			url:<?php echo "'".base_url() . 'index.php/user/role_list_data'."'";?>,
			method:'post',
			pagination:true, 
			singleSelect:true,
			rownumbers:true, 
			fitColumns:true,
			toolbar:"#tb",
			onDblClickRow: function(index, row) {
				editRole();
			}
		});

		$(function(){
			var pager = $('#tt').datagrid('getPager');	// get the pager of datagrid
			pager.pagination({
				buttons:[{
					id:'btn_add',
					text:'添加',
					iconCls:'icon-add',
					handler:function(){
						addRole();
					}
				},{
					id:'btn_edit',
					text:'编辑',
					iconCls:'icon-edit-blue',
					handler:function(){
						editRole();
					}
				},{
					id:'btn_remove',
					text:'删除',
					iconCls:'icon-trash',
					handler:function(){
						delRole();
					}
				}]
			});			
		})

		$(document).ready(function() {
            $.post('<?php echo base_url() . "index.php/admin/check_rights"."'";?>, { func: 'role_edit'}, function (result) {
                    if (!result.res) {
                    	$('#edit').linkbutton('disable');
                    } 
                }, 'json');

            $.post('<?php echo base_url() . "index.php/admin/check_rights"."'";?>, { func: 'role_del'}, function (result) {
                    if (!result.res) {
                    	$('#del').linkbutton('disable');
                    } 
                }, 'json');
		});
	
		function doSearch(){ 
			$('#tt').datagrid('load',{ 
				rolename:$('#rolename').val()
			}); 
		} 
		
        var url;
        var selected_id;
        function addRole(){       
            $('#dlg').dialog('open').dialog('setTitle','添加角色');            
            $('#ff').form('clear');
            selected_id = 0;
            url = '<?php echo base_url() . "index.php/user/role_add"."'";?>;        
        }        
        
        function editRole(){            
            var row = $('#tt').datagrid('getSelected');
            if (row){
            	selected_id = row.id;
                $('#dlg').dialog('open').dialog('setTitle','编辑角色');
                $('#ff').form('clear'); 
                $('#ff').form('load',row);

                try{
                	var m = row.rights.split(",");
                }
                catch(e)
                {
                    var m = new Array();
                    m[0] = row.rights;
                }
                try{
                	var p = row.openkakou.split(",");
                }
                catch(e)
                {
                    var p = new Array();
                    p[0] = row.openkakou;
                }

                $('#menu').combotree('setValues', m);
                $('#place').combotree('setValues', p);
                url = '<?php echo base_url() . "index.php/user/role_edit?id="."'";?>+row.id; 
            }
        }
        
        function delRole() {
            var row = $('#tt').datagrid('getSelected');
            if (row) {
                $.messager.confirm('提示信息', '确定要删除这个角色吗?', function (r) {
                    if (r) {
                        $.post('<?php echo base_url() . "index.php/user/role_del"."'";?>, { id: row.id }, function (result) {
                            if (result.success) {
                                $('#tt').datagrid('reload');    // reload the data  
                                $.messager.show({    
                                    title: '提示信息',
                                    msg: result.msg
                                });
                            } else {
                                $.messager.show({   // show error message  
                                    title: '错误信息',
                                    msg: result.msg
                                });
                            }
                        }, 'json');
                    }
                });
            }
        }  

        function save() {
            $("#ff").form("submit", {
                url: url,
                onsubmit: function () {
                    return $(this).form("validate");
                },
                success: function (res) {
                	var result = eval('(' + res + ')'); //json字符串转换成json对象
                    if (result.success) {
                        $("#dlg").dialog("close");
                        $("#tt").datagrid("load");
                        $.messager.show({
                            title: '提示信息',
                            msg: result.msg
                        });
                    }
                    else {
                        $.messager.show({   // show error message  
                            title: '错误信息',
                            msg: result.msg
                        });
                    }
                }
            });
        }

		$('#menu').combotree({    
			url:'<?php echo base_url().'index.php/basedata/tree_menu'?>',
			method:'get',
			onLoadSuccess : function(){
				$('#menu').combotree('collapseAll');
				}
			}); 

		$('#place').combotree({    
			url:'<?php echo base_url().'index.php/basedata/tree_place'?>',
			method:'get',
			onLoadSuccess : function(){
				$('#place').combotree('collapseAll');
				}
			}); 

        var res = true;
		// 密码一致验证
		$.extend($.fn.validatebox.defaults.rules, { 
			rolename: {
			    validator: function(value,param){    
	                $.post('<?php echo base_url() . "index.php/user/rolename_exist"."'";?>, { id: selected_id, rolename: value }, function (result) {
							res = !result.success;
	                    }, 'json');
                    return res;
		        },        
		        message: '用户名已经存在.'
	        }
    	});
	</script>
	
</body>
</html>