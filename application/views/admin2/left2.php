<!DOCTYPE html>
<head>
	<base href="<?php echo base_url(); ?>"/>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>无标题文档</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui-1.4.1/themes/metro/easyui.css"; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui-1.4.1/themes/icon.css"; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui-1.4.1/themes/main.css"; ?>" />
</head>

<body>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui-1.4.1/jquery.min.js"; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui-1.4.1/jquery.easyui.min.js"; ?>"></script>

	<div class="easyui-accordion" style="width:150px;">
		<?php if($f_datas != null): ?>
		<?php foreach ($f_datas as $f_data): ?>
		<div title="<?php echo $f_data['cname'];?>" style="overflow:auto;padding:10px;">
			<ul class="easyui-tree">
				<?php foreach ($f_data['childrens'] as $f_childrens_data):?>
				<li iconCls="icon-gears"><a class="e-link" href="<?php echo base_url();echo "index.php/";echo $f_data['name'];echo "/";echo $f_childrens_data['name'];echo "/"?>" target="rightFrame"><?php echo $f_childrens_data['cname'] ?></a></li>
				<?php endforeach;?>
			</ul>
		</div>	
		<?php endforeach;?>
		<?php endif;?>
	</div>
	
</body>
</html>