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
			<table id="tt" title="<?php echo $title;?>" class="easyui-datagrid" style="width:600px;"
					url="<?php echo base_url() . 'index.php/syst/notice_data';?>" 
					toolbar="#tb" pagination="true" nowrap="false"
					singleSelect="true" rownumbers="true"  fitColumns="true">
				<thead>
					<tr>
						<th field="created" width="120" align="center">����ʱ��</th>
						<th field="content" width="200" align="center">����</th>
						<th field="banned" width="40" align="center" data-options="formatter:formatBanned">״̬</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width: 500px; padding: 10px 20px;"
	       closed="true" buttons="#dlg-buttons"> 
		<div style="padding:10px 60px 20px 60px">
		    <form id="ff" method="post">
		    	<table cellpadding="5">
		    		<tr>
		    			<td>����:</td>
		    			<td><input id="content" name="content" class="easyui-textbox" data-options="multiline:true" style="width:240px;height:120px" required = "required" data-options="
										validType:{
											length:[1,255]
										}
						    "></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>״̬:</td>
		    			<td>
		    				<input id="banned" name="banned" type="checkbox" value="1"></input>
		    				<a href="#" title="��ѡ����ù���" class="easyui-tooltip" position="right">��ʾ</a>
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
			var pager = $('#tt').datagrid().datagrid('getPager');	// get the pager of datagrid
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
        var selected_id;
        function add(){ 
            $('#dlg').dialog('open').dialog('setTitle','��ӹ���');            
            $('#ff').form('clear');
            selected_id = 0;
            url = '<?php echo base_url() . "index.php/syst/notice_add"."'";?>;        
        }
        
        function edit(){   
            var row = $('#tt').datagrid('getSelected');
            selected_id = row.id;
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','�༭����');
                $('#ff').form('clear'); 
                $('#ff').form('load',row);

                url = '<?php echo base_url() . "index.php/syst/notice_edit?id="."'";?>+row.id; 
            }
        }
        
        function remove() {
            var row = $('#tt').datagrid('getSelected');
            if (row) {
                $.messager.confirm('��ʾ��Ϣ', 'ȷ��Ҫɾ��?', function (r) {
                    if (r) {
                        $.post('<?php echo base_url() . "index.php/syst/notice_del"."'";?>, { id: row.id }, function (result) {
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
        		return '<span style="color:tomato;">����</span>';
        	} else {
        		return '<span style="color:green;">����</span>';
        	}
        }

	</script>
	
</body>
</html>