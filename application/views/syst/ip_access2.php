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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;IP访问控制(只允许下列IP访问)</span></td>
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
		<td>
			<table align="center" width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($ip_access)): ?>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">#</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">IP 允许范围</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">状态</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作</span></div></td>
				</tr>
				<?php $rownum = 0;?>
				<?php foreach ($ip_access as $ip): ?>
				<tr>
				    <?php if($ip->CLBJ == 'T')
				          { 
				          	  $data['state'] = '已启用';
				          	  $data['style'] = 'STYLE27';
				          }
				          else 
				          {
				          	  $data['state'] = '已禁用';
				          	  $data['style'] = 'STYLE26';
				          }
				    ?>
				    <td height="24" ><div align="center" class="STYLE23"><?php echo $rownum += 1; ?></div></td>	
					<td height="24" ><div align="center" class="STYLE23"><?php if(!$ip->MAXIP){echo $ip->MINIP;}else{echo "$ip->MINIP" . " ～ " . "$ip->MAXIP";}?></div></td>
					<td height="24" ><div align="center" class="<?php echo $data['style'];?>"><?php echo $data['state'];?></div></td>
                    <td height="24" ><div align="center" class="STYLE23"><?php $ip->CLBJ == 'T'?$op='禁用':$op='启用'; echo anchor('syst/banned_ipaccess/'.$ip->ID,$op)?> | <?php echo anchor('syst/del_ipaccess/'.$ip->ID, '删除', 'onclick="return confirm(' . "'确定要删除？'" . ')"')?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19">
					<div align="center">
						<h3>没有IP限制,请添加.</h3>
					</div>
					</td>
				</tr>
				<?php endif; ?>
			</table>
			<p align="center" style="font-size:12px;color:blue">注意: 如果只开放单个IP, 可在任一个输入框中输入.</p>
			<form method="post" action="<?php echo site_url('syst/add_ipaccess'); ?>">
			<table width="100%" border="0" cellpadding="1" cellspacing="0" >
				<tr>
					<td align="center" style="width:100%;font-size: 12px;"> <b>IP范围：</b>
						<label></label><input type="text" name="minip" value="<?php echo set_value('minip'); ?>" /><label style="color:red"><?php echo form_error('minip'); ?></label>
						<label>- </label><input type="text" name="maxip" value="<?php echo set_value('maxip'); ?>" /><label style="color:red"><?php echo form_error('maxip'); ?></label>
						<input name="submit" type='submit' value="添加" />
					</td>
				</tr>	
			</table>
			</form>
		</td>
	</tr>

</table>
</body>
</html>

