<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->config->item('title');?></title>

	<link href="<?php echo base_url('js/dwz/themes/default/style.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('js/dwz/themes/css/core.css');?>" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url('style/zTreeStyle/zTreeStyle.css');?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('js/jqzoom_ev-2.3/css/jquery.jqzoom.css'); ?>" rel="stylesheet" type="text/css" />
	<!--[if IE]>
	<link href="<?php echo base_url('js/dwz/themes/css/ieHack.css');?>" rel="stylesheet" type="text/css" />
	<![endif]-->

	<script src="<?php echo base_url('js/dwz/js/speedup.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('js/dwz/js/jquery-1.7.2.min.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('js/dwz/js/jquery.cookie.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('js/dwz/js/jquery.validate.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('js/dwz/js/jquery.bgiframe.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('js/dwz/dwz.min.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('js/dwz/js/dwz.regional.zh.js');?>" type="text/javascript"></script>

	<script src="<?php echo base_url('js/jquery.ztree.all-3.5.min.js');?>" type="text/javascript"></script>
	
	<script src="<?php echo base_url('js/jqzoom_ev-2.3/js/jquery.jqzoom-core-pack.js');?>" type="text/javascript"></script>

	<script src="<?php echo base_url('js/Highcharts-4.0.1/js/highcharts.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url('js/Highcharts-4.0.1/js/modules/exporting.js'); ?>" type="text/javascript"></script>

	<script type="text/javascript">
		function fleshVerify(){
			//重载验证码
			$('#verifyImg').attr("src", "<?php echo base_url('application/Public/verify/');?>"+(new Date().getTime()));
		}

		$(function(){
			DWZ.init("<?php echo base_url('js/dwz/dwz.frag.xml');?>", {
				//loginUrl:"<?php echo base_url('application/Public/login_dialog');?>", loginTitle:"登录",	// 弹出登录对话框
				loginUrl:"<?php echo base_url('index.php/home/login'); ?>",	//跳到登录页面
				// statusCode:{ok:1,error:0},
				statusCode:{ok:200, error:300, timeout:301},
				// keys:{statusCode:"status", message:"info"},
				keys: {statusCode:"statusCode", message:"message"},
				pageInfo:{pageNum:"page", numPerPage:"rows", orderField:"sort", orderDirection:"order"}, //【可选】
				debug:false,	// 调试模式 【true|false】
				callback:function(){
					initEnv();
					$("#themeList").theme({themeBase:"<?php echo base_url('public/dwz/themes');?>"});
				}
			});
		});

		function my_tr_dbltable(ed_url, d_Name, d_Id){
			if( ed_url != '' && d_Id != ""){
				$.pdialog.open(ed_url, d_Id, d_Name, 
								{max: false, minable: false, drawable: false, resizable: false, 
									maxable: true, mask: true, width: 600, height: 500});
			}
		}
	</script>
</head>
<body scroll="no">
<div id="layout">
	<div id="header">
		<div class="headerNav">
			<a class="logo">Logo</a>
			<ul class="nav">
				<li><a href="<?php echo base_url('index.php/admin/password'); ?>" target="dialog" mask="true">修改密码</a></li>
				<li><a href="<?php echo base_url('index.php/home/logout'); ?>">退出</a></li>
			</ul>
		</div>
	</div>
	<div id="leftside">
		<div id="sidebar_s">
			<div class="collapse">
				<div class="toggleCollapse"><div></div></div>
			</div>
		</div>
		<div id="sidebar">
			<div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>
			<div class="accordion" fillSpace="sideBar">
				<?php if($f_datas != null): ?>
				<?php foreach ($f_datas as $f_data): ?>
				<div class="accordionHeader">
					<h2><span>Folder</span><?php echo $f_data['cname'];?></h2>
				</div>
				<div class="accordionContent">
					<ul class="tree treeFolder">
						<?php foreach ($f_data['childrens'] as $f_childrens_data):?>
						<li><a href="<?php echo base_url(). "index.php/".$f_data['name']."/".$f_childrens_data['name']."/";?>" target="navTab" rel="<?php echo $f_childrens_data['name'];?>"><?php echo $f_childrens_data['cname'];?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
				<?php endforeach;?>
				<?php endif;?>
			</div>
		</div>
	</div>