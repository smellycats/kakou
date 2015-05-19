<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title><?php echo $this->config->item('title');?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/color.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css"?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js"?>"></script>
</head>

<body>
	<div id="p" class="easyui-panel" style="width:100%;">
		<table id="tt" class="easyui-datagrid" style="width:100%;">
			<thead>
				<tr>
					<th field="username" width="40" align="center">用户名</th>
					<th field="realname" width="40" align="center">真实名</th>
					<th field="rolename" width="40" align="center" sortable="true">所属角色</th>
					<th field="department" width="40" align="center">部门</th>
					<th field="last_ip" width="40" align="center">上次登录IP</th>
					<th field="last_login" width="50" align="center" sortable="true">上次登录时间</th>
					<th field="access_count" width="20" align="center" sortable="true">登录次数</th>
					<th field="banned" width="20" align="center" data-options="formatter:formatBanned">冻结</th>
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="tb" style="padding:3px 20px">
		<div align="right">
			<input id="rolename" class="easyui-textbox" data-options="prompt:'输入用户名'" style="width:120px;" />
			
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">查询</a>
		</div>
	</div>

	<div id="dlg" class="easyui-dialog" style="width: 700px; padding: 10px 20px;"
	       closed="true" maximizable="true" buttons="#dlg-buttons" > 
		<div style="padding:0px 40px 0px 40px">
		    <form id="ff" method="post">
		    	<table cellpadding="5">
		    		<tr>
		    			<td>用户名:</td>
		    			<td><input id="username" name="username" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
											username:['#username']
										}
						    "></input>
		    			</td>
		    			<td>姓名:</td>
		    			<td><input id="realname" name="realname" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20]
										}
						    "></input>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>角色:</td>
						<td><input id="role_id" name="role_id" class="easyui-combobox" required = "required" editable="false"
								url = "<?php echo base_url() . 'index.php/basedata/get_role';?>" 
								valueField="id" textField="text" ></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>身份证号码:</td>
		    			<td><input id="identity" name="identity" class="easyui-textbox" validType="length[0,32]"></input></td>
		    			<td>联系电话:</td>
		    			<td><input id="phone" name="phone" class="easyui-textbox" validType="length[0,32]"></input></td>
		    		</tr>
		    		<tr>
		    			<td>密码:</td>
		    			<td><input id="pwd" name="password" class="easyui-textbox" type="password" required = "required" validType="length[4,20]"></input></td>
		    			<td>确认密码:</td>
		    			<td><input id="pwd2" class="easyui-textbox" type="password" required = "required" validType="equals['#pwd']"></input></td>
		    		</tr>
		    		<tr>
		    			<td>单位:</td>
		    			<td><input id="department" name="department" class="easyui-textbox" validType="length[0,32]"></input></td>
		    			<td>用户状态:</td>
		    			<td><input id="banned" name="banned" type="checkbox" value="1"></input></td>
		    		</tr>
		    		<tr>
		    			<td>登录模式:</td>
		    			<td>
		    				<input id="access_type" name="access_type" type="radio" value="0" checked="checked"/>帐号密码&nbsp;<input type="radio" name="access_type" value="1"/>数字证书&nbsp;<input type="radio" name="access_type" value="2"/>混合模式
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>限制IP访问:</td>
		    			<td>
		    				<input id="limit_login_address" name="limit_login_address" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
		    			</td>
		    			<td>备注:</td>
		    			<td>
		    				<input id="memo" name="memo" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
		    			</td>
		    		</tr>
		    	</table>
		    </form>
	    </div>
	</div> 

	<div id="dlg2" class="easyui-dialog" style="width: 700px; padding: 10px 20px;"
	       closed="true" buttons="#dlg-buttons2"> 
		<div style="padding:0px 40px 0px 40px">
		    <form id="ff2" method="post">
		    	<table cellpadding="5">
		    		<tr>
		    			<td>用户名:</td>
		    			<td><input id="username2" name="username" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
											checkusername:['#username2']
										}
						    "></input>
		    			</td>
		    			<td>真实名:</td>
		    			<td><input id="realname" name="realname" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20]
										}
						    "></input>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>角色:</td>
						<td><input id="role_id" name="role_id" class="easyui-combobox" required = "required" editable="false"
								url = "<?php echo base_url() . 'index.php/basedata/get_role';?>" 
								valueField="id" textField="text" ></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>身份证号码:</td>
		    			<td><input id="identity" name="identity" class="easyui-textbox" validType="length[0,32]"></input></td>
		    			<td>联系电话:</td>
		    			<td><input id="phone" name="phone" class="easyui-textbox" validType="length[0,32]"></input></td>
		    		</tr>
		    		<tr>
		    			<td>单位:</td>
		    			<td><input id="department" name="department" class="easyui-textbox" validType="length[0,32]"></input></td>
		    			<td>用户状态:</td>
		    			<td><input id="banned" name="banned" type="checkbox" value="1"></input></td>
		    		</tr>
		    		<tr>
		    			<td>登录模式:</td>
		    			<td>
		    				<input id="access_type" name="access_type" type="radio" value="0" checked="checked"/>帐号密码&nbsp;<input type="radio" name="access_type" value="1"/>数字证书&nbsp;<input type="radio" name="access_type" value="2"/>混合模式
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>限制IP访问:</td>
		    			<td>
		    				<input id="limit_login_address" name="limit_login_address" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
		    			</td>
		    			<td>备注:</td>
		    			<td>
		    				<input id="memo" name="memo" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
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
    
	<div id="dlg-buttons2">  
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="save2()" style="width:90px">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:$('#dlg2').dialog('close')" iconcls="icon-cancel" style="width:90px">取消</a> 
    </div>
    		
	<script type="text/javascript">
		function doSearch(){ 
			$('#tt').datagrid('load',{ 
				rolename:$('#rolename').val()
			}); 
		} 

		$('#tt').datagrid({
			title:<?php echo "'".$title."'";?>,
			url:<?php echo "'" . base_url() . 'index.php/user/user_list_data' . "'";?>,
			method:'post',
			pagination:true, 
			singleSelect:true,
			rownumbers:true, 
			fitColumns:true,
			toolbar:"#tb",
			pageSize: 10,
			onDblClickRow: function(index, row) {
				editUser();
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
						addUser();
					}
				},{
					id:'btn_edit',
					text:'编辑',
					iconCls:'icon-edit-blue',
					handler:function(){
						editUser();
					}
				},{
					id:'btn_remove',
					text:'删除',
					iconCls:'icon-trash',
					handler:function(){
						delUser();
					}
				}]
			});			
		})
		
        var url; 
        function addUser(){       
            $('#dlg').dialog('open').dialog('setTitle','添加用户');            
            $('#ff').form('clear');            
            url = '<?php echo base_url() . "index.php/user/user_add"."'";?>;        
        }
        
        function editUser(){            
            var row = $('#tt').datagrid('getSelected');
           
            if (row){
                $('#dlg2').dialog('open').dialog('setTitle','编辑用户');
                $('#ff2').form('clear'); 
                $('#ff2').form('load',row);
                $('#role_id').combobox('setValue', row.role_id);

                url = '<?php echo base_url() . "index.php/user/user_edit?id="."'";?>+row.id; 
            }
        }

        function delUser() {
            var row = $('#tt').datagrid('getSelected');
            $("#btn_add").linkbutton("disable");
            if (row) {
                $.messager.confirm('提示信息', '确定要删除这个用户吗?', function (r) {
                    if (r) {
                        $.post('<?php echo base_url() . "index.php/user/user_del"."'";?>, { id: row.id }, function (result) {
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

        function save2() {
            $("#ff2").form("submit", {
                url: url,
                onsubmit: function () {
                    return $(this).form("validate");
                },
                success: function (res) {
                	var result = eval('(' + res + ')'); //json字符串转换成json对象
                    if (result.success) {
                        $("#dlg2").dialog("close");
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

        var res = true;
		// 密码一致验证
		$.extend($.fn.validatebox.defaults.rules, { 
			equals: {
			    validator: function(value,param){    
		            return value == $(param[0]).val();   
		        },        
		        message: '密码不一致.'
	        },
			username: {
			    validator: function(value,param){    
	                $.post('<?php echo base_url() . "index.php/user/username_exist"."'";?>, { username: value }, function (result) {
							res = !result.success;
	                    }, 'json');
                    return res;
		        },        
		        message: '用户名已经存在.'
	        },
			checkusername: {
			    validator: function(value,param){
	        		var row = $('#tt').datagrid('getSelected'); 
	                $.post('<?php echo base_url() . "index.php/user/username_exist"."'";?>, { id: row.id,username: value}, function (result) {
							res = !result.success;
	                    }, 'json');
                    return res;
		        },        
		        message: '用户名已经存在.'
	        }
        });

        function formatBanned(val,row)
        {
        	if (val == 1){
        		return '<span style="color:tomato;">是</span>';
        	} else {
        		return '否';
        	}
        }
	</script>
	
</body>
</html>