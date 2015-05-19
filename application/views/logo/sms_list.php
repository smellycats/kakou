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
			<table id="tt" title="<?php echo $title;?>" class="easyui-datagrid" style="width:700px;"
					url="<?php echo base_url() . 'index.php/logo/sms_list_data';?>" 
					toolbar="#tb" pagination="true" nowrap="false"
					singleSelect="true" rownumbers="true"  fitColumns="true">
				<thead>
					<tr>
						<th field="mark" width="200" align="center">��ע</th>
						<th field="tel" width="300" align="center">�绰</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<div id="dlg" class="easyui-dialog" style="width: 500px; padding: 10px 20px;"
	       closed="true" maximizable="true" buttons="#dlg-buttons" > 
		<div style="padding:0px 60px 0px 60px">
		    <form id="ff" method="post">
		    	<table cellpadding="5">
		    		<tr>
		    			<td>�绰:</td>
		    			<td><input id="tel" name="tel" class="easyui-textbox" required = "required"  style="width:240px;height:120px" data-options="
										validType:{
											length:[1,256]
										},
										multiline:true
						    "></input>
						<a href="#" title="�绰������','�ָ�" class="easyui-tooltip" position="right">��ʾ</a>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>��ע:</td>
		    			<td><input id="mark" name="mark" class="easyui-textbox" required = "required" style="width:240px;height:60px" data-options="
										validType:{
											length:[1,32]
										},
										multiline:true
						    "></input>
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

		$('#tt').datagrid({
			onDblClickRow: function(index, row) {
				edit();
			}
		});
		
		$(function(){
			var pager = $('#tt').datagrid('getPager');	// get the pager of datagrid
			pager.pagination({
				buttons:[{
					id:'btn_add',
					text:'���',
					iconCls:'icon-add',
					handler:function(){
						add();
					}
				},{
					id:'btn_edit',
					text:'�༭',
					iconCls:'icon-edit-blue',
					handler:function(){
						edit();
					}
				},{
					id:'btn_remove',
					text:'ɾ��',
					iconCls:'icon-trash',
					handler:function(){
						remove();
					}
				}]
			});			
		})
		
        var url; 
        function add(){       
            $('#dlg').dialog('open').dialog('setTitle','��Ӷ���');            
            $('#ff').form('clear');            
            url = '<?php echo base_url() . "index.php/logo/sms_add"."'";?>;        
        }
        
        function edit(){            
            var row = $('#tt').datagrid('getSelected');
           
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','�༭����');
                $('#ff').form('clear'); 
                $('#ff').form('load',row);
                $('#role_id').combobox('setValue', row.role_id);

                url = '<?php echo base_url() . "index.php/logo/sms_edit?id="."'";?>+row.id; 
            }
        }

        function remove() {
            var row = $('#tt').datagrid('getSelected');
            $("#btn_add").linkbutton("disable");
            if (row) {
                $.messager.confirm('��ʾ��Ϣ', 'ȷ��Ҫɾ����?', function (r) {
                    if (r) {
                        $.post('<?php echo base_url() . "index.php/logo/sms_del"."'";?>, { id: row.id }, function (result) {
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

	</script>
	
</body>
</html>