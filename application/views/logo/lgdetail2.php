<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>无标题文档</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/color.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jqzoom_ev1.0.1/css/jqzoom.css"; ?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js";?>"></script>
</head>

<body>
	<div id="p" class="easyui-panel" style="width:100%;height:85%;padding:0px 10px 10px 10px;">
		<div id="imgframe" style="float:left;padding:5px 10px;">
			<a id="img_j" class="jqzoom" rel="gall" href="<?php echo base_url(). 'index.php/img/show_img?id=1'; ?>" target="_blank" title="观看放大图片窗口，右键保存">
				<img id="img_a" src="<?php echo base_url(). 'index.php/img/show_img?id=1'; ?>" class="car" style="height:500px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left;padding:5px 10px;">
			<table id="pg" style="width:300px"></table>
			<table id="pg2" style="width:300px" ></table>
		</div>
	</div>
	
	<div id="p2" class="easyui-panel" style="width:100%;height:15%;padding:0px 10px 10px 10px;">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="next()" style="width:90px">下一个</a>
	</div>

	<script type="text/javascript">
	$('#pg').propertygrid({
		url:'<?php echo base_url() . "index.php/basedata/get_carinfo_logo?id=11"."'";?>,
		method:'get',
		showGroup:true,
		showHeader:false,
		scrollbarSize:0
	});
	$('#pg2').propertygrid({
		url:'<?php echo base_url() . "index.php/basedata/get_cgs?hphm=粤WJV023"."'";?>,
		method:'get',
		showGroup:true,
		showHeader:false,
		scrollbarSize:0
	});

	$(document).ready(function(){  
	    var options = {  
	            zoomType: 'standard',  
	            lens:true,  
	            preloadImages: false,  
	            alwaysOn:false,  
	            zoomWidth: 260,  
	            zoomHeight: 200,  
	            xOffset:5,  
	            yOffset:280,
	            position:'right'
	            //...MORE OPTIONS  
	    };  
	    $('.jqzoom').jqzoom(options);  
	}); 

	var ids = <?php echo $ids;?>;
    function next(){
		var all = $('#pg').propertygrid('getData');
		alert(all['rows'][1]['value']);	 
    	$("#img_a").attr("src", "<?php echo base_url(). 'index.php/img/show_img?id=2'; ?>");
    	$("#img_j").attr("href", "<?php echo base_url(). 'index.php/img/show_img?id=2'; ?>");        
    }  

	</script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jQuery1.8.2/jquery-1.8.2.min.js"; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jqzoom_ev1.0.1/js/jqzoom.pack.1.0.1.js"; ?>"></script>
</body>
</html>