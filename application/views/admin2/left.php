<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>无标题文档</title>
<style type="text/css"><!--
<!--
body {
margin:0px;
padding:0px;
font-size: 12px;
}
#navigation {
margin:0px;
padding:0px;
width:147px;
}
#navigation a.head {
cursor:pointer;
background:url(images/admin/main_34.gif) no-repeat scroll;
display:block;
font-weight:bold;
margin:0px;
padding:5px 0 5px;
text-align:center;
font-size:12px;
text-decoration:none;
}
#navigation ul {
border-width:0px;
margin:0px;
padding:0px;
text-indent:0px;
}
#navigation li {
list-style:none; display:inline;
}
#navigation li li a {
display:block;
font-size:12px;
text-decoration: none;
text-align:center;
padding:3px;
}
#navigation li li a:hover {
background:url(images/admin/tab_bg.gif) repeat-x;
border:solid 1px #adb9c2;
}

-->
</style>
</head>
<body>

<script type="text/javascript" src="<?php echo base_url() . "js/jquery_news/jquery.js"?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "js/jquery_news/chili-1.7.pack.js"?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "js/jquery_news/jquery.easing.js"?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "js/jquery_news/jquery.dimensions.js"?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "js/jquery_news/jquery.accordion.js"?>"></script>
<script language="javascript">
jQuery().ready(function()
{
	jQuery('#navigation').accordion(
	{
		header: '.head',
		navigation1: true,
		event: 'click',
		fillSpace: true,
		animated: 'bounceslide'
	});
});
</script>
	<div style="height:100%;">
		<?php if($f_datas != null): ?>
		<ul id="navigation">
		<?php foreach ($f_datas as $f_data): ?>
			<li> <a class="head"><?php echo $f_data['cname']?></a>
				<ul>
				<?php foreach ($f_data['childrens'] as $f_childrens_data):?>
					<li><a href="<?php echo base_url();echo "index.php/";echo $f_data['name'];echo "/";echo $f_childrens_data['name'];echo "/"?>" target="rightFrame"><?php echo $f_childrens_data['cname'] ?></a></li>
				<?php endforeach;?>
				</ul>
	    <?php endforeach;?>
	
		</ul> 
		<?php else: ?>
			<td height="20" bgcolor="#ffffff" class="STYLE19"><div align="center"><h3>你没有任何菜单权限！</h3></div></td>
		<?php endif;?>
	</div>
</body>
</html>