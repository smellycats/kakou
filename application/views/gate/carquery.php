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
	<div id="p" class="easyui-panel" style="width:100%;padding:0px 10px 10px 10px;">
		<table id="tt" title="<?php echo $title;?>" class="easyui-datagrid" style="width:100%;" toolbar="#tb" >
			<thead>
				<tr>
					<th field="hphm" width="80" align="center">号牌号码</th>
					<th field="hpys" width="50" align="center">号牌颜色</th>
					<th field="passtime" width="120" align="center">通过时间</th>
					<th field="place" width="120" align="center">卡口名称</th>
					<th field="dire" width="60" align="center">方向</th>
					<th field="lane" width="40" align="center">车道</th>
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="tb" style="padding:3px">
		<div align="center">
			<span>卡口名称:</span>
			<input id="place" class="easyui-combobox"
					url = "<?php echo base_url() . 'index.php/basedata/get_place_logo';?>" 
					method = "get" valueField = "id" textField = "text" />		
			<span>车道:</span>
			<input id="lane" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_lane';?>" 
					method = "get" valueField = "id" textField = "text" />		
			<span>方向:</span>
			<input id="dire" class="easyui-combobox" style="width:80px"
					url = "<?php echo base_url() . 'index.php/basedata/get_dire';?>" 
					method = "get" valueField = "id" textField = "text" panelHeight = "auto" />
			<span>号牌颜色:</span>
			<input id="hpys" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_hpys';?>" 
					method = "get" valueField = "id" textField = "text" panelHeight = "auto" />
		</div>
		<div align="center">
			<span>开始时间:</span>
			<input id="st" class="easyui-datetimebox" required="true" value="<?php echo $carquery['st'];?>" style="width:150px" />
			<span>结束时间:</span>
			<input id="et" class="easyui-datetimebox" required="true" value="<?php echo $carquery['et'];?>" style="width:150px" />
			<span>车牌号码:</span>
			<input id="number" class="easyui-combobox" style="width:50px"
					url = "<?php echo base_url() . 'index.php/basedata/get_number';?>" 
					method = "get" valueField = "id" textField = "text" />
			<input id="carnum" class="easyui-textbox" data-options="prompt:'输入车牌号码'" style="width:120px;" />
			<a href="#" title="车牌号码支持模糊查询,不确定的字符(包括汉字,数字)请用'?'代替;多个连续的不确定位,可用一个'*'代替;汉字栏选择'-'可单独查询无识别结果的记录" class="easyui-tooltip" position="bottom">提示</a>
			
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch();">查询</a>
		</div>
	</div>
	
	<script type="text/javascript">

		function doSearch(){ 
			$('#tt').datagrid('load',{ 
				place:$('#place').combobox('getValue'),
				lane:$('#lane').combobox('getValue'),
				dire:$('#dire').combobox('getValue'),
				hpys:$('#hpys').combobox('getValue'),
				st:$('#st').combobox('getValue'),
				et:$('#et').combobox('getValue'),
				number:$('#number').combobox('getValue'),
				carnum:$('#carnum').val()
			}); 
		} 

		$(function(){
			var pager = $('#tt').datagrid().datagrid('getPager');	// get the pager of datagrid
			pager.pagination({
				buttons:[{
					iconCls:'icon-search',
					handler:function(){
						showDetail();
					}
				},{
					iconCls:'icon-excel',
					handler:function(){
						exportExcel();
					}
				},{
					iconCls:'icon-pic',
					handler:function(){
						showDetail();
					}
				}]
			});			
		})
		
        function showDetail(){  
			var row = $('#tt').datagrid('getSelected');
			if (row){
				var alldata = $("#tt").datagrid("getRows");
				var index = $('#tt').datagrid('getRowIndex', row);
				var ids = '';
				for(var key in alldata){  
					ids += alldata[key].id+',';  
				} 
				
	            window.location.replace('<?php echo base_url() . "index.php/logo/lgdetail?"."'";?>+"ids="+ids+"&id="+row.id+"&index="+index);
			}     
        }  
		
		function exportExcel(){
			window.location.replace(<?php echo "'".base_url() ."index.php/export2/exportexcel"."'";?>);
		}
		
		$('#tt').datagrid({
			title:<?php echo "'".$title."'";?>,
			url:<?php echo "'".base_url() . 'index.php/logo/load_carquery'."'";?>,
			method:'post',
			pagination:true, 
			singleSelect:true,
			rownumbers:true, 
			fitColumns:true,
			toolbar:"#tb",
			onDblClickRow: function(index, row) {
				showDetail();
			}
		});
			
		function deleterow(target){
			$.messager.confirm('提示','确认删除?',function(r){
				if (r){
					$('#tt').datagrid('deleteRow', getRowIndex(target));
				}
			});
		}

	</script>

</body>
</html>