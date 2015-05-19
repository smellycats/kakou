<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>无标题文档</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/bootstrap/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css"; ?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js"?>"></script>
</head>

<body class="easyui-layout">
	<div data-options="region:'north',border:false" style="height:60px;background:#666666;padding:10px">north region</div>
	<div data-options="region:'west',split:true,title:'菜单'" style="width:150px;"><?php echo $this->load->view('layouts/west2',$west); ?></div>
	<!-- <div data-options="region:'east',split:true,collapsed:true,title:'East'" style="width:100px;padding:10px;">east region</div>
	<div data-options="region:'south',border:false" style="height:50px;background:#A9FACD;padding:10px;">south region</div>
	-->
	<div data-options="region:'center'">
		<div id="tabs" class="easyui-tabs" >
			<div title="Home"></div>
		</div>
	</div>
	
	<script type="text/javascript">
	//点击菜单打开标签页
	function addTab(title, url){
		if ($('#tabs').tabs('exists', title)){
			$('#tabs').tabs('select', title);
		} else {
			var content = '<iframe src="'+url+'" frameborder="0" scrolling="auto" height = "100%" width = "100%"></iframe>';
			$('#tabs').tabs('add',{
				title:title,
				content:content,
				closable:true
			});
		}
	}
	//标签模块自适应父容器大小
	$(function(){ 
		　　$("#tabs").tabs({ 
		　　　　width:$("#tabs").parent().width(), 
		　　　　height:$("#tabs").parent().height() 
		　　}); 
		}); 
	</script>
</body>
</html>