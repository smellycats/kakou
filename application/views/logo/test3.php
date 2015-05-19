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
	<div id="p" class="easyui-panel" style="width:100%;padding:0px 150px 10px 150px;">
		<table id="tt" class="easyui-datagrid" style="width:900px;">
			<thead>
				<tr>
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="tb" style="padding:3px 20px">
		<div align="right">
			<input id="rolename" class="easyui-textbox" data-options="prompt:'输入角色名'" style="width:120px;" />
			
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">查询</a>
		</div>
	</div>

	
	<script type="text/javascript">
		function doSearch(){ 
			var rows = $('#tt').datagrid('getRows');
			alert(rows.length);
		} 

		var datalen = 0;

		var cardview = $.extend({}, $.fn.datagrid.defaults.view, { 
		    renderRow: function(target, fields, frozen, rowIndex, rowData){
				var cc = []; 
		    	if (rowIndex == 0){
			    	datalen = $('#tt').datagrid('getRows').length;
			    	alert(datalen);
			    	cc.push('<td colspan=' + fields.length + ' style="padding:5px;border:0;">');
			        cc.push('<a href="#" class="easyui-linkbutton"onclick="test('+fields['id']+')"><img src="http://localhost/kakou_jquery/index.php/img/show_sl?id=1" style="height:150px;float:left;padding: 0px 0px 0px 10px"></a>');
		    	}else if(datalen == 1){
		    		cc.push('</td>');
		    	}else{
			        if (!frozen){  
			            cc.push('<a href="#" class="easyui-linkbutton"onclick="test('+fields['id']+')"><img src="http://localhost/kakou_jquery/index.php/img/show_sl?id=1" style="height:150px;float:left;padding: 0px 0px 0px 10px"></a>');   
			        } 
		    	} 
		        return cc.join('');  
		    }  
		}); 
		
		$('#tt').datagrid({  
		    title:'DataGrid - CardView',
		    width:800, 
		    height:400,
		    toolbar:"#tb",
		    remoteSort:false,  
		    singleSelect:true,
		    striped:true,  
		    fitColumns:true,
		    url:<?php echo "'".'http://localhost/kakou_jquery/images/datagrid_data1.json' . "'"?>,  
		    columns:[[
		        {field:'itemid',title:'Item ID',width:80},  
		        {field:'productname',title:'Product ID',width:100,sortable:true},  
		        {field:'listprice',title:'List Price',width:80,align:'right',sortable:true},  
		        {field:'unitcost',title:'Unit Cost',width:80,align:'right',sortable:true},  
		        {field:'status',title:'Status',width:60,align:'center'}  
		    ]],  
		    view: cardview
		});  

		function test(a)
		{
			alert(4%4);
		}
					

	</script>
	
</body>
</html>