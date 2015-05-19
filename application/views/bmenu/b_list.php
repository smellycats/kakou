<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>无标题文档</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/color.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css"?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js"?>"></script>
</head>

<body>
	<div id="p" class="easyui-panel" style="width:100%;padding:0px 10px 10px 10px;">
		<table id="tt" title="<?php echo $title;?>" class="easyui-datagrid" style="width:100%;padding:0px 10px 0px 10px;"
				url="<?php echo base_url() . 'index.php/bmenu/bk_data';?>" 
				toolbar="#tb" pagination="true"
				singleSelect="true" rownumbers="true"  fitColumns="true">
			<thead>
				<tr>
					<th field="username" width="40" align="center">状态</th>
					<th field="realname" width="40" align="center">临控</th>
					<th field="rolename" width="40" align="center">车牌号码</th>
					<th field="department" width="40" align="center">颜色</th>
					<th field="last_ip" width="40" align="center">车辆类型</th>
					<th field="last_login" width="50" align="center">布控时间</th>
					<th field="access_count" width="20" align="center">布控人</th>
					<th field="banned" width="20" align="center">联系人</th>
					<th field="banned" width="20" align="center">布控原因</th>
					<th field="banned" width="20" align="center">撤控原因</th>
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
		    			<td>车牌号码:</td>
		    			<td><input id="username" name="username" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
										}
						    "></input>
		    			</td>
		    			<td>车牌颜色:</td>
						<td><input id="cpys" name="cpys" class="easyui-combobox" editable="false"
								url = "<?php echo base_url() . 'index.php/basedata/get_bmenu_hpys';?>" 
								valueField="id" textField="text" ></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>车辆类型:</td>
		    			<td>
		    				<input id="username" name="username" class="easyui-textbox"></input>
		    			</td>
		    			<td>布控原因:</td>
						<td><input id="reason" name="reason" class="easyui-combobox" required = "required" editable="false"
								url = "<?php echo base_url() . 'index.php/basedata/get_reason1';?>" 
								valueField="id" textField="text" ></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>布控人:</td>
		    			<td>
		    				<input id="user" name="user" class="easyui-textbox" disabled="disabled"></input>
						</td>
		    			<td>联系人:</td>
		    			<td><input id="username" name="username" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
										}
						    "></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>布控时间:</td>
		    			<td><input id="starttime" name="starttime" class="easyui-datetimebox" value="" disabled="disabled" style="width:150px"></input></td>
		    			<td>电话:</td>
		    			<td><input id="telnum" name="telnum" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
										}
						    "></input>
						</td>		    		
					</tr>
		    		<tr>
		    			<td>案情简介:</td>
		    			<td>
		    				<input id="limit_login_address" name="limit_login_address" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>临时布控:</td>
		    			<td>
		    				<input id="banned" name="banned" type="checkbox" value="1"></input>
		    				<a href="#" title="当勾选为临时布控时，报警信息只发送给上方设置的接收信息的手机号" class="easyui-tooltip" position="right">提示</a>
		    			</td>
		    			<td>接收信息的手机号:</td>
		    			<td>
		    				<input id="memo" name="memo" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
		    				<a href="#" title="多个号码之间, 请用','分隔" class="easyui-tooltip" position="right">提示</a>
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
		function doSearch(){ 
			$('#tt').datagrid('load',{ 
				rolename:$('#rolename').val()
			}); 
		} 
		
		$(function(){
			var pager = $('#tt').datagrid().datagrid('getPager');	// get the pager of datagrid
			pager.pagination({
				buttons:[{
					iconCls:'icon-add',
					handler:function(){
						addBkcp();
					}
				},{
					iconCls:'icon-edit-blue',
					handler:function(){
						editUser();
					}
				},{
					iconCls:'icon-trash',
					handler:function(){
						delUser();
					}
				}]
			});			
		})
		
        var url; 
        function addBkcp(){       
            $('#dlg').dialog('open').dialog('setTitle','添加布控');            
            $('#ff').form('clear'); 
            $('#cpys').combobox('setValue', '无');    
            $('#reason').combobox('setValue', '请选择');
            $('#starttime').datetimebox('setValue', <?php echo "'".mdate("%Y-%m-%d %H:%i:%s")."'";?>);
            $('#user').textbox('setValue', 'admin');
            
            url = '<?php echo base_url() . "index.php/user/user_add"."'";?>;        
        }
        
        function editkcp(){            
            var row = $('#tt').datagrid('getSelected');
           
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','编辑用户');
                $('#ff').form('clear');
                $('#ff').form('load',row);
                $('#user').combobox('setValue', 'admin');

                url = '<?php echo base_url() . "index.php/user/user_edit?id="."'";?>+row.id; 
            }
        }

        function delUser() {
            var row = $('#tt').datagrid('getSelected');
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