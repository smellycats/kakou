<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>�ޱ����ĵ�</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui-1.4.1/themes/" . $this->config->item('ui_themes') . "/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui-1.4.1/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui-1.4.1/themes/main.css"?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui-1.4.1/jquery.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui-1.4.1/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui-1.4.1/locale/easyui-lang-zh_CN_GBK.js"?>"></script>

</head>

<body>
	<div style="margin:20px 0;"></div>
	<div class="easyui-panel" title="<?php echo $title;?>" style="width:500px;">
		<div style="padding:10px 60px 20px 60px">
		    <form id="ff" method="post">
		    	<table cellpadding="7">
		    		<tr>
		    			<td>�û���(����):</td>
		    			<td><input id="username" name="username" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
										}
						    "></input>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>����:</td>
		    			<td><input id="realname" name="realname" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[1,20],
										}
						    "></input>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>���֤����:</td>
		    			<td><input id="identity" name="identity" class="easyui-textbox" validType="length[0,32]"></input></td>
		    		</tr>
		    		<tr>
		    			<td>��ϵ�绰:</td>
		    			<td><input id="phone" name="phone" class="easyui-textbox" validType="length[0,32]"></input></td>
		    		</tr>
		    		<tr>
		    			<td>����:</td>
		    			<td><input id="pwd" name="password" class="easyui-textbox" type="password" required = "required" validType="length[4,20]"></input></td>
		    		</tr>
		    		<tr>
		    			<td>ȷ������:</td>
		    			<td><input id="pwd2" class="easyui-textbox" type="password" required = "required" validType="equals['#pwd']"></input></td>
		    		</tr>
		    		<tr>
		    			<td>��λ:</td>
		    			<td><input id="department" name="department" class="easyui-textbox" validType="length[0,32]"></input></td>
		    		</tr>

		    		<tr>
		    			<td>��ɫ:</td>
						<td><input id="role_id" name="role_id" class="easyui-combobox" editable="false"
								url = "<?php echo base_url() . 'index.php/basedata/get_role';?>" 
								valueField="id" textField="text" ></input>
						</td>
		    		</tr>
		    		<tr>
		    			<td>�û�״̬:</td>
		    			<td><input id="banned" name="banned" type="checkbox" value="1"></input></td>
		    		</tr>
		    		<tr>
		    			<td>��¼ģʽ:</td>
		    			<td>
		    				<input id="access_type" name="access_type" type="radio" value="0" checked="checked"/>�ʺ�����&nbsp;<input type="radio" name="access_type" value="1"/>����֤��&nbsp;<input type="radio" name="access_type" value="2"/>���ģʽ
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>����IP����:</td>
		    			<td>
		    				<input id="limit_login_address" name="limit_login_address" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>��ע:</td>
		    			<td>
		    				<input id="memo" name="memo" class="easyui-textbox" data-options="multiline:true" value="" style="width:160px;height:60px"></input>
		    			</td>
		    		</tr> 
		    		<tr>
		    			<td>test</td>
		    			<td><input id="test" class="easyui-textbox" required = "required" data-options="
										validType:{
											length:[2,10],
											username:['#test']
										}
						    "></input>
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
				url:'<?php echo base_url() . 'index.php/user2/user_add_form';?>', 
				onSubmit:function(){
					return $(this).form('enableValidation').form('validate');
				},
				success:function(data){ 
					alert(data);
				}
			});
		}
		function clearForm(){
			$('#ff').form('clear');
		}

		var res = true;
		// ����һ����֤
		$.extend($.fn.validatebox.defaults.rules, { 
			equals: {
			    validator: function(value,param){    
		            return value == $(param[0]).val();   
		        },        
		        message: '���벻һ��.'
	        },
			username: {
			    validator: function(value,param){    
	                $.post('<?php echo base_url() . "index.php/user/username_exist"."'";?>, { username: value }, function (result) {
							res = !result.success;
	                    }, 'json');
	                //alert(res);
                    return res;
		        },        
		        message: '�û����Ѿ�����.'
	        }
        });
	</script>
	
</body>
</html>