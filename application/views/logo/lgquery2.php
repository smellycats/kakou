<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>无标题文档</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui-1.4.1/themes/" . $this->config->item('ui_themes') . "/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui-1.4.1/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui-1.4.1/themes/main.css"?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui-1.4.1/jquery.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui-1.4.1/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui-1.4.1/locale/easyui-lang-zh_CN.js"?>"></script>
	<script type="text/javascript">
		function doSearch(){ 
			$('#tt').datagrid('load',{ 
				place:$('#place').combobox('getValue'),
				lane:$('#lane').combobox('getValue'),
				dire:$('#dire').combobox('getValue'),
				hpys:$('#hpys').combobox('getValue'),
				ppdm:$('#ppdm').combobox('getValue'),
				cllx:$('#cllx').combobox('getValue'),
				csys:$('#csys').combobox('getValue'),
				st:$('#st').combobox('getValue'),
				et:$('#et').combobox('getValue'),
				number:$('#number').combobox('getValue'),
				carnum:$('#carnum').val(),
			}); 

			//alert($('#st').combobox('getValue'));
		} 

	</script>
</head>

<body>
	<table id="tt" class="easyui-datagrid" style="width:100%;"
			url="<?php echo base_url() . 'index.php/logo2/load_lgquery';?>" toolbar="#tb"
			title="车标查询" singleSelect="true" rownumbers="true" pagination="true">
		<thead>
			<tr>
				<th field="hphm" width="80" align="center">号牌号码</th>
				<th field="hpys" width="60" align="center">号牌颜色</th>
				<th field="passtime" width="150" align="center">通过时间</th>
				<th field="place" width="120" align="center">地点</th>
				<th field="clpp" width="80" align="center" sortable="true">车辆标志</th>
				<th field="clpp_son" width="120" align="center" sortable="true">品牌类型</th>
				<th field="cllx" width="100" align="center">车辆类型</th>
				<th field="csys" width="60" align="center">车身颜色</th>
				<th field="dire" width="60" align="center">方向</th>
				<th field="lane" width="40" align="center">车道</th>
				<th field="action" width="100" align="center" formatter="formatAction">操作</th>
			</tr>
		</thead>
	</table>
	
	<div id="tb" style="padding:3px">
		<div align="center">
			<span>地点:</span>
			<input id="place" class="easyui-combobox"
					url = "<?php echo base_url() . 'index.php/basedata/get_place_logo';?>" 
					method = "get" valueField = "id" textField = "text" />		
			<span>车道:</span>
			<input id="lane" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_lane';?>" 
					method = "get" valueField = "id" textField = "text" />		
			<span>方向:</span>
			<input id="dire" class="easyui-combobox" style="width:80px"
					url = "<?php echo base_url() . 'index.php/basedata/get_dire_logo';?>" 
					method = "get" valueField = "id" textField = "text" panelHeight = "auto" />
			<span>号牌颜色:</span>
			<input id="hpys" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_hpys_logo';?>" 
					method = "get" valueField = "id" textField = "text" panelHeight = "auto" />
		</div>
		<div align="center">
			<span>车辆标志:</span>
			<input id="ppdm" class="easyui-combobox" style="width:100px"
					url = "<?php echo base_url() . 'index.php/basedata/get_ppdm';?>" 
					method = "get" valueField = "id" textField = "text" />
			<span>车辆类型:</span>
			<input id="cllx" class="easyui-combobox" style="width:120px"
					url = "<?php echo base_url() . 'index.php/basedata/get_cllx_logo';?>" 
					method = "get" valueField = "id" textField = "text" />
			<span>车身颜色:</span>
			<input id="csys" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_csys_logo';?>" 
					method = "get" valueField = "id" textField = "text" />
		</div>
		<div align="center">
			<span>开始时间:</span>
			<input id="st" class="easyui-datetimebox" required="true" value="<?php echo $lgquery['st'];?>" style="width:150px" />
			<span>结束时间:</span>
			<input id="et" class="easyui-datetimebox" required="true" value="<?php echo $lgquery['et'];?>" style="width:150px" />
			<span>车牌号码:</span>
			<input id="number" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_number';?>" 
					method = "get" valueField = "id" textField = "text" />
			<input id="carnum" class="easyui-textbox" data-options="prompt:'输入车牌号码'" style="width:120px;" />
			
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">查询</a>
		</div>
	</div>
	
	<script type="text/javascript">
		function formatAction(value,row,index){
			var e = "<a href='"+"test/"+row.id+"' onclick='editrow(this)'>编辑</a>";
			var d = "<a href='"+"test/"+row.id+"' onclick='deleterow(this)'>删除</a>";
			return e+d;
		}
		function editrow(target){
			//$('#tt').datagrid('beginEdit', getRowIndex(target));
			alert('OK');
		}
		function deleterow(target){
			$.messager.confirm('Confirm','Are you sure?',function(r){
				if (r){
					$('#tt').datagrid('deleteRow', getRowIndex(target));
				}
			});
		}
	</script>

</body>
</html>