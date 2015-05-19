<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title><?php echo $this->config->item('title');?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/color.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jqzoom_ev-2.3/css/jquery.jqzoom.css"; ?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jQuery1.7.1/jquery-1.7.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jqzoom_ev-2.3/js/jquery.jqzoom-core-pack.js";?>"></script>
</head>

<body>
	<div id="p" class="easyui-panel">
		<div style="padding:10px 200px 10px 20px;">
			<img id="img" style="height:300px;" src=""/> 
		</div>
		<div style="padding:5px 20px" align="right">
			<a href="javascript:void(0)" id="back" class="easyui-linkbutton" onclick="javascript:goUrl();return false;">返回</a>
		</div>
	</div>
	<div id="p2" class="easyui-panel" style="width:100%">
		<table id="tt" class="easyui-datagrid" style="width:100%;">
			<thead>
				<tr>
					<th field="hphm" width="80" align="center">号牌号码</th>
					<th field="hpys" width="50" align="center">号牌颜色</th>
					<th field="passtime" width="120" align="center">通过时间</th>
					<th field="place" width="160" align="center">地点</th>
					<th field="clpp" width="80" align="center" >车辆标志</th>
					<th field="clpp_son" width="120" align="center" >品牌类型</th>
					<th field="cllx" width="80" align="center">车辆类型</th>
					<th field="csys" width="50" align="center">车身颜色</th>
					<th field="dire" width="60" align="center">方向</th>
					<th field="lane" width="40" align="center">车道</th>
					<th field="clppflag" width="60" align="center" data-options="formatter:formatClppflag">车型匹配</th>
				</tr>
			</thead>
		</table>
	</div>
	
	
	<div id="dlg" class="easyui-dialog" width="100%" height="400px"
	       closed="true" maximizable="true" resizable="true"
	       buttons="#dlg-buttons">
		<div>
			<div class="clearfix">
		        <a href=<?php echo '"'.base_url(). 'index.php/img/show_img?id=5'.'"'; ?> class="jqzoom" id="jqzoom" rel="gal1" title="triumph" >
		            <img src=<?php echo '"'.base_url(). 'index.php/img/show_img?id=5'.'"'; ?> style="height:300px;" />
		        </a>
	        </div>
			<div style="float:left;"><table id="dlg_pg" style="width:300px"></table></div>
			<div style="float:left;"><table id="dlg_pg2" style="width:300px" ></table></div>
		</div>
	</div> 

	<div id="dlg-buttons">  
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')" iconcls="icon-cancel" style="width:90px">关闭</a> 
    </div> 
	
	<script type="text/javascript">
		var all = '';
		var current_id = 0;
		$(document).ready(function(){
			setInterval("flash()",2000);
		});

		function flash(){
            $.post('<?php echo base_url() . "index.php/logo/load_real_detail"."'";?>, { dire: 0}, function (result) {
                    if (result.rows.length > 0) {
	                    if (result.rows[0].id != current_id){
		                    //alert(current_id);
	                    	$('#tt').datagrid('loadData', result);
	    					$("#img").attr("src", <?php echo '"'.base_url(). 'index.php/img/show_img?id='.'"'; ?>+all[0].id);
	    					current_id = result.rows[0].id;
	                    }
                    } 
                }, 'json');
		}

		$('#tt').datagrid({
			title:<?php echo "'".$title."'";?>,
			url:<?php echo "'".base_url() . 'index.php/logo/load_real_detail'."'";?>,
			method:'get',
			singleSelect:true,
			rownumbers:true, 
			fitColumns:true,
			onLoadSuccess: function (data) {
				all = $("#tt").datagrid("getRows");
				if (all.length == 0){
                    $.messager.show({    
                        title: '提示信息',
                        msg: '没有实时数据！'
                    });
				}else {
					$("#img").attr("src", <?php echo '"'.base_url(). 'index.php/img/show_img?id='.'"'; ?>+all[0].id);
					current_id = all[0].id;
				}
			},
			onDblClickRow: function(index, row) {
	        	//window.location.replace(<?php echo "'".base_url() ."index.php/logo/car_info?id="."'";?>+row['id']);
				window.open(<?php echo "'".base_url() ."index.php/logo/car_info?id="."'";?>+row['id'],"_blank","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=yes, copyhistory=yes,channelmode=yes");
			}
		});

        function goUrl()
        {
        	window.location.replace(<?php echo "'".base_url() ."index.php/logo/real_select"."'";?>);
        }

        function formatClppflag(val,row)
        {
        	if (val == 1){
        		return '是';
        	} else {
        		return '<span style="color:tomato;">否</span>';
        	}
        }

	</script>

</body>
</html>