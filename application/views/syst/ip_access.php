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
	<div id="p" class="easyui-panel" style="width:100%;padding:0px 150px 10px 150px;">
		<table id="tt" title="<?php echo $title;?>" class="easyui-datagrid" style="width:600px;"
				url="<?php echo base_url() . 'index.php/syst/ip_data';?>" 
				toolbar="#tb" pagination="true"
				singleSelect="true" rownumbers="true"  fitColumns="true">
			<thead>
				<tr>
					<th field="minip" width="100" align="center">起始IP</th>
					<th field="maxip" width="100" align="center">结束IP</th>
					<th field="banned" width="40" align="center" data-options="formatter:formatBanned">状态</th>
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width: 400px; padding: 10px 20px;"
	       closed="true" buttons="#dlg-buttons"> 
		<div style="padding:10px 60px 20px 60px">
		    <form id="ff" method="post">
		    	<table cellpadding="5">
		 		    <tr>	    		
		    			<td>起始IP:</td>
		    			<td><input id="minip" name="minip" class="easyui-textbox" required = "required" data-options="
										validType:{
											isip:['#minip']
										}
						    "></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>结束IP:</td>
		    			<td><input id="maxip" name="maxip" class="easyui-textbox" data-options="
										validType:{
											isip:['#maxip']
										}
						    "></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>状态:</td>
		    			<td>
		    				<input id="banned" name="banned" type="checkbox" value="1"></input>
		    				<a href="#" title="勾选后IP限制失效" class="easyui-tooltip" position="right">提示</a>
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
		$(function(){
			var pager = $('#tt').datagrid().datagrid('getPager');	// get the pager of datagrid
			pager.pagination({
				buttons:[{
					id:'btn_add',
					text:'添加',
					iconCls:'icon-add',
					handler:function(){
						add();
					}
				},{
					id:'btn_edit',
					text:'编辑',
					iconCls:'icon-edit-blue',
					handler:function(){
						edit();
					}
				},{
					id:'btn_remove',
					text:'删除',
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
            $('#dlg').dialog('open').dialog('setTitle','添加IP');            
            $('#ff').form('clear');
            selected_id = 0;
            url = '<?php echo base_url() . "index.php/syst/ip_add"."'";?>;        
        }
        
        function edit(){   
            var row = $('#tt').datagrid('getSelected');
            selected_id = row.id;
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','编辑IP');
                $('#ff').form('clear'); 
                $('#ff').form('load',row);

                url = '<?php echo base_url() . "index.php/syst/ip_edit?id="."'";?>+row.id; 
            }
        }
        
        function remove() {
            var row = $('#tt').datagrid('getSelected');
            if (row) {
                $.messager.confirm('提示信息', '确定要删除?', function (r) {
                    if (r) {
                        $.post('<?php echo base_url() . "index.php/syst/ip_del"."'";?>, { id: row.id }, function (result) {
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

		// 密码一致验证
		$.extend($.fn.validatebox.defaults.rules, { 
			isip: {
			    validator: function(value,param){    
            		var re =  /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/   
                	return re.test(value);
		        },        
		        message: 'IP格式不正确.'
	        }
		});

        function formatBanned(val,row)
        {
        	if (val == 1){
        		return '<span style="color:tomato;">禁用</span>';
        	} else {
        		return '<span style="color:green;">启用</span>';
        	}
        }

	</script>
	
</body>
</html>