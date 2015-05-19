<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>�ޱ����ĵ�</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css"?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js"?>"></script>

</head>

<body>
	<div style="margin:20px 0;"></div>
	<div id="pnl" class="easyui-panel" title="<?php echo $title;?>" style="width:500px;">
		<div style="padding:10px 60px 20px 60px">
		    <form id="ff" method="post">
		    	<table cellpadding="7">
		    		<tr>
		    			<td>��ɫ��:</td>
		    			<td><input id="rolename" name="rolename" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20]
										}
						    "></input>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>����:</td>
		    			<td><input id="disable" name="disable" type="checkbox" value="1"></input><a href="#" title="������ɫ,���ᶳ��������ص��ʻ�" class="easyui-tooltip">��ʾ</a></td>
		    		</tr>
		    		<tr>
		    			<td>�˵�Ȩ��:</td>
		    			<td>
    						<select id="menu" name="menu[]" class="easyui-combotree" multiple style="width:200px;"></select> 
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>����Ȩ��:</td>
		    			<td>
    						<select id="place" name="place[]" class="easyui-combotree" multiple style="width:200px;"></select> 
		    			</td>
		    		</tr>
		    	</table>
		    </form>
		    <div style="text-align:center;padding:5px">
		    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">�ύ</a>
		    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">����</a>
		    </div>
	    </div>
	</div>
	
	<script type="text/javascript">
		function submitForm(){
			$('#ff').form('submit',{
				url:'<?php echo base_url() . 'index.php/user2/role_add_form';?>', 
				onSubmit:function(){
					return $(this).form('enableValidation').form('validate');
				},
				success:function(data){ 
					alert('123');
				}
			});
		}
		
		function clearForm(){	
			$('#ff').form('clear');
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

		////$('#menu').combotree('setValues', [12,13]);

	</script>
	
</body>
</html>