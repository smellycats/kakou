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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;公告管理</span></td>
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
	    <form method="post" action="<?php echo site_url('syst/add_adv');?>" >
		<table align="center" border="0" cellspacing="1" cellpadding="6" style="width:450px">
			<tr style="background-color:#69c">
				<td colspan="2" align="center"><span style="font-weight:bold;color:white">添加公告</span></td>
			</tr>
			<tr>
				<td style="width:80px;">公告内容:</td>
				<td><textarea id="adv_content" name="adv_content" style="width:340px;height:80px"></textarea><span style="color:red"><?php echo form_error('adv_content'); ?></span></td>
			</tr>
			<tr>
				<td>显示顺序:</td>
				<td><input type="text" id="adv_pos" name="adv_pos" value="<?php echo $adv_pos;?>" style="width:40px"/><span style="color:red"><?php echo form_error('adv_pos'); ?></span></td>
			</tr>
	
			<tr>
				<td colspan="2" align="center"><input style="width:50px" type="submit" name="add" value="增 加" /></td>
			</tr>
		</table>
		</form>
	</tr>
	<tr>
		<td>
			<form method="post" action="<?php echo site_url('syst/edit_adv');?>" >
			<table align="center" width="95%" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($announcement)): ?>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">公告内容</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">显示顺序</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">状态</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作</span></div></td>
				</tr>
				<?php $rownum = 0;?>
				<?php foreach ($announcement as $row): ?>
				<?php if($row->DISABLE == 'F'){$net_color = 'STYLE27';$state='已启用';}else{$net_color = 'STYLE26';$state='已禁用';}?>
				<tr> 
					<td height="24" ><div align="center" class="STYLE23"><textarea style="width: 400px;height: 80px" name="adv_content"><?php echo $row->CONTENT; ?></textarea></div></td>
					<td height="24" ><div align="center" class="STYLE23"><input style="width: 40px" name="adv_pos" value="<?php echo $row->POSITION;?>"/></div></td>
					<td height="24" ><div align="center" class="<?php echo $net_color;?>"><?php echo $state;?></div></td>
                    <td height="24" ><div align="center" class="STYLE23">
                    <input type="submit" name="edit_adv" value="修改" />                 
                    | <?php 
                    if ($row->DISABLE == 'T')
                    {
                    	echo anchor('syst/turn_on_adv/'.$row->ID,'启用');
                    }
                    else if($row->DISABLE == 'F')
                    {
                        echo anchor('syst/turn_off_adv/'.$row->ID,'禁用');
                    } ?>
                    | <?php echo anchor('syst/del_adv/?id=' . $row->ID . '&adv_pos=' . $row->POSITION, '删除', 'onclick="return confirm(' . "'确定要删除？'" . ')"')?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>没有公告!</h3>
					</div></td>
			    </tr>
				<?php endif; ?>
			</table>
			</form>

		</td>
	</tr>
</table>
</body>
</html>
