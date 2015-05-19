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
			<table id="tt" title="<?php echo $title;?>" class="easyui-datagrid" style="width:500px;"
					url="<?php echo base_url() . 'index.php/logo/load_realselect';?>" 
					toolbar="#tb" singleSelect="1" rownumbers="true" fitColumns="true">
				<thead>
					<tr>
						<th data-options="field:'ck',checkbox:true"></th>
						<th field="place" width="120" align="center">卡口地点</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	
	<div id="tb" style="padding:3px;padding:5px 20px" align="right">
		<span>车辆类型是否匹配:</span>
		<input id="clppflag" class="easyui-combobox" style="width:80px"
				url = "<?php echo base_url() . 'index.php/basedata/get_clppflag_logo';?>" 
				method = "get" valueField = "id" textField = "text" />
		<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="realshow();">查看</a>
	</div>	
	
	<script type="text/javascript">
		function realshow(){
			var obj = $('#tt').datagrid('getSelections');
			var config_ids = '';
			var array = [];
			for (var p in obj){
				array[p] = obj[p]['config_id'];
			}
			config_ids = array.join(",");
			//alert($('#clppflag').combobox('getValue'));
			if (config_ids == ''){
                $.messager.show({    
                    title: '提示信息',
                    msg: '请选择卡口地点.'
                });
			}else {
            	window.location.replace('<?php echo base_url() . "index.php/logo/real_detail?"."'";?>+"ids="+config_ids+"&clppflag="+$('#clppflag').combobox('getValue'));
			}
		} 

	</script>

</body>
</html>