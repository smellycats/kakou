<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<script type="text/javascript" src=<?php echo base_url() . "js/jQuery1.7.1/jquery-1.7.1.min.js"; ?>  ></script>
<script type="text/javascript"><!--

function delsms(id){
	window.location.href='<?php echo base_url() .  'index.php/logo/del_sms/';?>' + id;
}

--></script>

	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td height="30">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="24" bgcolor="#353c44">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="6%" height="19" valign="bottom"><div align="center"><img src="images/admin/tb.gif" width="14" height="14" /></div></td>
												<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;短信发送号码</span></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	
	</table>

	<div class="clearfix" style="border:0px;float:left;width:100%;">
		<form method="post" action="<?php echo site_url('logo/add_sms'); ?>">
			<table align="center">
				<tr>
					<th>发送号码(以","号隔开)：</th>
					<td colspan="2">
						<textarea name=tel id="tel" style="width:260px; height:60px"></textarea>
					</td>
				</tr>
				<tr>
					<th>备注：</th>
					<td>
						<input type="text" name="mark" id="mark"></input>
					</td>
					<td>
						<input type="submit" name="submit" value="添加" />
					</td>
				</tr>
			</table>
		</form>
	</div>

	<div class="clearfix" style="border:0px;float:left;width:90%;">
		<?php if (!empty($tels)): ?>
		<?php $count = 0;?>
		<table align="center" width="60%" border="0" cellpadding="0" cellspacing="1" class="tab">
			<tr>
				<td height="24" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">#</span></div></td>
				<td height="24" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">电话号码</span></div></td>
				<td height="24" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">备注</span></div></td>
				<td height="24" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作</span></div></td>
			</tr>
			<?php foreach ($tels as $row):?>
			<tr>
				<form method="post" action="<?php echo site_url('logo/edit_sms'); ?>">
					<td height="24" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11"><?php echo $count+=1;?></span></div></td>
					<td><textarea name=tel id="tel" style="width:260px; height:60px"><?php echo $row['tel']; ?></textarea></td>
					<td><input type="text" name="mark" id="mark" value="<?php echo $row['mark']; ?>"></input></td>
					<td><input type="submit" name="submit" value="保存" /><input type="button" name="del" id="del" value="删除" onclick="delsms(<?php echo $row['id'];?>)"/></td>
					<td><input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>"></input></td>
				</form>
			</tr>
			<?php endforeach; ?>
			<tr>
			<?php else: ?>
				<td height="20" bgcolor="#ffffff" class="STYLE19"><div align="center"><h3><?php echo '没有短信号码！';?></h3></div></td>
			<?php endif;?>
			</tr>
			
		</table>
	</div>
</body>
</html>
