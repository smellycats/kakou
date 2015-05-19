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
	<script type="text/javascript" src="<?php echo base_url() . "js/jQuery1.8.2/jquery-1.8.2.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jqzoom_ev-2.3/js/jquery.jqzoom-core-pack.js";?>"></script>
</head>

<body>
	<div id="p" class="easyui-panel">
		<div style="padding:10px 200px 10px 20px;">
			<img id="img" style="height:300px;" src=""/> 
		</div>
	</div>
	<div id="p2" class="easyui-panel" style="width:100%;padding:0px 10px 10px 10px;">
		<table id="tt" class="easyui-datagrid" style="width:100%;">
			<thead>
				<tr>
					<th field="hphm" width="80" align="center">号牌号码</th>
					<th field="hpys" width="50" align="center">号牌颜色</th>
					<th field="passtime" width="120" align="center">通过时间</th>
					<th field="place" width="120" align="center">地点</th>
					<th field="clpp" width="80" align="center" >车辆标志</th>
					<th field="clpp_son" width="120" align="center" >品牌类型</th>
					<th field="cllx" width="100" align="center">车辆类型</th>
					<th field="csys" width="60" align="center">车身颜色</th>
					<th field="dire" width="60" align="center">方向</th>
					<th field="lane" width="40" align="center">车道</th>
				</tr>
			</thead>
		</table>
	</div>
	
	
	<div id="dlg" class="easyui-dialog" width="100%" height="100%"
	       closed="true" maximizable="true" resizable="true"
	       buttons="#dlg-buttons"> 
		<div id="dlg_p" class="easyui-panel">
			<div class="clearfix">
		        <a href="" class="jqzoom" id="jqzoom" rel="gal1" title="triumph" >
		            <img src="" style="height:300px;" />
		        </a>
	        </div>
		</div>
		
		<div id="dlg_p2" class="easyui-panel" style="padding:5px 5px 10px 20px;">
			<div style="float:left;"><table id="dlg_pg" style="width:300px"></table></div>
			<div style="float:left;"><table id="dlg_pg2" style="width:300px" ></table></div>
		</div>
	</div> 

	<div id="dlg-buttons">  
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')" iconcls="icon-cancel" style="width:90px">关闭</a> 
    </div> 
	
	<script type="text/javascript" src="<?php echo base_url() . "js/MagicZoom/js/ShopShow.js";?>"></script>
	<script type="text/javascript">
		var all = '';
		var current_id = 0;
		$(document).ready(function(){
			setInterval("flash()",2000);
		});

		function flash(){
            $.post('<?php echo base_url() . "index.php/logo/load_real_detail"."'";?>, { dire: 0}, function (result) {
                    alert(result.rows);
                    if (result.rows[0].id != current_id){
                    	$('#tt').datagrid('loadData', result);
    					$("#img").attr("src", <?php echo '"'.base_url(). 'index.php/img/show_img?id='.'"'; ?>+all[0].id);
    					current_id = result.rows[0].id;
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
					alert('没有实时数据！');
		            window.location.replace('<?php echo base_url() . "index.php/logo/real_select"."'";?>);
				}else {
					$("#img").attr("src", <?php echo '"'.base_url(). 'index.php/img/show_img?id='.'"'; ?>+all[0].id);
					current_id = all[0].id;
				}
			},
			onDblClickRow: function(index, row) {
				$('#dlg').dialog('open').dialog('setTitle','车辆信息');
				updateimg(row.id);
				$('#dlg_pg').propertygrid({
					url:<?php echo "'" . base_url() . "index.php/basedata/get_carinfo_logo?id=" . "'";?>+all[0].id,
					method:'get',
					showGroup:true,
					showHeader:false,
					scrollbarSize:0,
			        onLoadSuccess: function (data) {
						var allpg = $('#dlg_pg').propertygrid('getData');
						$('#dlg_pg2').propertygrid({
							url:'<?php echo base_url() . "index.php/basedata/get_cgs?hphm="."'";?>+allpg['rows'][1]['value'],
							method:'get',
							showGroup:true,
							showHeader:false,
							scrollbarSize:0
						});
			        }
				});
			}
		});

        function updateimg($id)
        {
            imgurl = 'http://localhost/imgareaselect/imgs/1.jpg'
            $(".jqZoomWindow").remove();
            $(".jqZoomPop").remove();
            $("jqzoom img").unbind();
            $("jqzoom").unbind();
            $(".jqzoom img").attr("src",imgurl);
        	$('.jqzoom').attr("href",imgurl).jqzoom({
                    zoomType: 'standard',
                    lens:true,
                    preloadImages: false,
                    alwaysOn:false,
                    zoomWidth: 260,
                    zoomHeight: 260,
                    xOffset:5,
                    yOffset:40
                });
        }

	</script>

</body>
</html>