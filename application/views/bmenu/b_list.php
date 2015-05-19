<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>�ޱ����ĵ�</title>
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
					<th field="username" width="40" align="center">״̬</th>
					<th field="realname" width="40" align="center">�ٿ�</th>
					<th field="rolename" width="40" align="center">���ƺ���</th>
					<th field="department" width="40" align="center">��ɫ</th>
					<th field="last_ip" width="40" align="center">��������</th>
					<th field="last_login" width="50" align="center">����ʱ��</th>
					<th field="access_count" width="20" align="center">������</th>
					<th field="banned" width="20" align="center">��ϵ��</th>
					<th field="banned" width="20" align="center">����ԭ��</th>
					<th field="banned" width="20" align="center">����ԭ��</th>
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="tb" style="padding:3px 20px">
		<div align="right">
			<input id="rolename" class="easyui-textbox" data-options="prompt:'�����û���'" style="width:120px;" />
			
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">��ѯ</a>
		</div>
	</div>

	<div id="dlg" class="easyui-dialog" style="width: 700px; padding: 10px 20px;"
	       closed="true" maximizable="true" buttons="#dlg-buttons" > 
		<div style="padding:0px 40px 0px 40px">
		    <form id="ff" method="post">
		    	<table cellpadding="5">
		    		<tr>
		    			<td>���ƺ���:</td>
		    			<td><input id="username" name="username" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
										}
						    "></input>
		    			</td>
		    			<td>������ɫ:</td>
						<td><input id="cpys" name="cpys" class="easyui-combobox" editable="false"
								url = "<?php echo base_url() . 'index.php/basedata/get_bmenu_hpys';?>" 
								valueField="id" textField="text" ></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>��������:</td>
		    			<td>
		    				<input id="username" name="username" class="easyui-textbox"></input>
		    			</td>
		    			<td>����ԭ��:</td>
						<td><input id="reason" name="reason" class="easyui-combobox" required = "required" editable="false"
								url = "<?php echo base_url() . 'index.php/basedata/get_reason1';?>" 
								valueField="id" textField="text" ></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>������:</td>
		    			<td>
		    				<input id="user" name="user" class="easyui-textbox" disabled="disabled"></input>
						</td>
		    			<td>��ϵ��:</td>
		    			<td><input id="username" name="username" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
										}
						    "></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>����ʱ��:</td>
		    			<td><input id="starttime" name="starttime" class="easyui-datetimebox" value="" disabled="disabled" style="width:150px"></input></td>
		    			<td>�绰:</td>
		    			<td><input id="telnum" name="telnum" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
										}
						    "></input>
						</td>		    		
					</tr>
		    		<tr>
		    			<td>������:</td>
		    			<td>
		    				<input id="limit_login_address" name="limit_login_address" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>��ʱ����:</td>
		    			<td>
		    				<input id="banned" name="banned" type="checkbox" value="1"></input>
		    				<a href="#" title="����ѡΪ��ʱ����ʱ��������Ϣֻ���͸��Ϸ����õĽ�����Ϣ���ֻ���" class="easyui-tooltip" position="right">��ʾ</a>
		    			</td>
		    			<td>������Ϣ���ֻ���:</td>
		    			<td>
		    				<input id="memo" name="memo" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
		    				<a href="#" title="�������֮��, ����','�ָ�" class="easyui-tooltip" position="right">��ʾ</a>
		    			</td>
		    		</tr>
		    	</table>
		    </form>
	    </div>
	</div> 
	
	<div id="dlg-buttons">  
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="save()" style="width:90px">����</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')" iconcls="icon-cancel" style="width:90px">ȡ��</a> 
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
            $('#dlg').dialog('open').dialog('setTitle','��Ӳ���');            
            $('#ff').form('clear'); 
            $('#cpys').combobox('setValue', '��');    
            $('#reason').combobox('setValue', '��ѡ��');
            $('#starttime').datetimebox('setValue', <?php echo "'".mdate("%Y-%m-%d %H:%i:%s")."'";?>);
            $('#user').textbox('setValue', 'admin');
            
            url = '<?php echo base_url() . "index.php/user/user_add"."'";?>;        
        }
        
        function editkcp(){            
            var row = $('#tt').datagrid('getSelected');
           
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','�༭�û�');
                $('#ff').form('clear');
                $('#ff').form('load',row);
                $('#user').combobox('setValue', 'admin');

                url = '<?php echo base_url() . "index.php/user/user_edit?id="."'";?>+row.id; 
            }
        }

        function delUser() {
            var row = $('#tt').datagrid('getSelected');
            if (row) {
                $.messager.confirm('��ʾ��Ϣ', 'ȷ��Ҫɾ������û���?', function (r) {
                    if (r) {
                        $.post('<?php echo base_url() . "index.php/user/user_del"."'";?>, { id: row.id }, function (result) {
                            if (result.success) {
                                $('#tt').datagrid('reload');    // reload the data  
                                $.messager.show({    
                                    title: '��ʾ��Ϣ',
                                    msg: result.msg
                                });
                            } else {
                                $.messager.show({   // show error message  
                                    title: '������Ϣ',
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
                	var result = eval('(' + res + ')'); //json�ַ���ת����json����
                    if (result.success) {
                        $("#dlg").dialog("close");
                        $("#tt").datagrid("load");
                        $.messager.show({
                            title: '��ʾ��Ϣ',
                            msg: result.msg
                        });
                    }
                    else {
                        $.messager.show({   // show error message  
                            title: '������Ϣ',
                            msg: result.msg
                        });
                    }
                }
            });
        }

        function formatBanned(val,row)
        {
        	if (val == 1){
        		return '<span style="color:tomato;">��</span>';
        	} else {
        		return '��';
        	}
        }
	</script>
	
</body>
</html>