<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<div id="add_article">
<h3><a></a></h3>
<form method="post" action="<?php echo site_url('bmenu/edit_bk_ck_ok'); ?>">
	<table>
		<tr><td><input type="hidden" name="id" id="id" value="<?php echo $bk->ID; ?>"/></td></tr>
		<tr><td>车牌号码为:<label class="BLUE"><?php echo $bk->HPHM;?></label>的车辆进入撤控状态</td></tr>
		<tr><td><label>撤控原因:</label><input type="text" name="ckreason" id="ckreason" value="<?php echo set_value('ckreason'); ?>"><?php echo form_error('ckreason'); ?></input></td></tr>
		<tr><td><input class="BUTBLACK14" type="submit" name="submit_ck" value="撤控" /></td></tr>
	</table>
</form>
</div>
</body>
</html>
