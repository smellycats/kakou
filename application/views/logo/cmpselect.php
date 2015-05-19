<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<script type="text/javascript" src=<?php echo base_url() . "js/xhedit1.1.0/jquery/jquery-1.4.2.min.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/kakou.js"; ?>></script>
<script>
function fcheckall()
{
	var objID;

	objID = document.form1.elements;

	for (var i=0 ;i<objID.length;i++)
	{
		objID[i].checked = !objID[i].checked
	}
}
</script>
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;实时比对选择列表</span></td>
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
	<tr>
		<td><?php
			$attr = array('name'=>'form1');
			echo form_open('logo/realcmp', $attr);
			?>
			<table align="center" width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($places)): ?>
					<td height="28" bgcolor="#4e87d6" class="LIST"><div align="center"><span class="STYLE11"><a href="javascript:fcheckall()">全选</a> </span></div></td>
					<td height="28" bgcolor="#4e87d6" class="LIST"><div align="center"><span class="STYLE11">监控地点</span></div></td>
					<td height="28" bgcolor="#4e87d6" class="LIST"><div align="center"><span class="STYLE11">方向</span></div></td>
				</tr>
				<?php foreach ($places as $id=>$row): ?>
				<tr>
					<td height="24" ><div align="center" class="STYLE23"><?php echo form_checkbox('kk[]',$id)?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row;?></div></td>

					<td height="24" ><div align="center" class="STYLE23">
					    <?php foreach($direction as $did=>$d)
					          {echo anchor('logo/realcmp?place='.$id . '&direction='.$did, $d . "  ");}?>
					</div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>没有可显示的监控点</h3>
					</div></td>
				<?php endif; ?>
				</tr>
				<tr>
					<td align="left">
						<input class="BUTBLACK" type="submit" name="submit" id="submit" value="按选中的监控点显示" title="按选中的监控点显示" style="width:150px"/>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>

</table>
</body>
</html>
