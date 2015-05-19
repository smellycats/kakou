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
				url="<?php echo base_url() . 'index.php/log/oplog_data';?>" 
				toolbar="#tb" pagination="true"
				singleSelect="true" rownumbers="true"  fitColumns="true">
			<thead>
				<tr>
					<th field="czsj" width="80" align="center">操作时间</th>
					<th field="uname" width="40" align="center">用户名</th>
					<th field="memo" width="300" align="center">操作记录</th>
					<th field="uip" width="60" align="center">IP</th>
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="tb" style="padding:3px 20px">
		<div align="center">
			<span>开始时间:</span>
			<input id="st" class="easyui-datetimebox" required="true" value="<?php echo $st;?>" style="width:150px" />
			<span>结束时间:</span>
			<input id="et" class="easyui-datetimebox" required="true" value="<?php echo $et;?>" style="width:150px" />
			<span>用户名:</span>
			<input id="username" class="easyui-textbox" data-options="prompt:'输入用户名'" style="width:120px;" />
			
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">查询</a>
		</div>
	</div>
    		
	<script type="text/javascript">
		function doSearch(){ 
			$('#tt').datagrid('load',{ 
				st:$('#st').datetimebox('getValue'),
				et:$('#et').datetimebox('getValue'),
				username:$('#username').val()
			}); 
		} 

	</script>
	
</body>
</html>