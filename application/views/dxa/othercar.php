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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;待销车辆设置</span></td>
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

	        <form id="form2" name="form2" method="post" action="<?php echo site_url('dxa/find_wl'); ?>">
			<table width="100%" border="0" cellpadding="0" cellspacing="1" >
			<tr align="center">
			    <td style="font-size: 14px;">
	                            车牌号码: <input type="text" name="find_carnum" value="<?php echo set_value('find_carnum'); ?>"  style="width:180px;height:18px">
			          	<input type="submit" name="find" value="查找">
			
			    </td>
			</tr>
            </table>
            </form>
            
			<form method="post" action="<?php echo site_url('dxa/add_wl_ok'); ?>">
				<table width="100%" border="0" cellpadding="1" cellspacing="0" >
					<tr>
						<td align="center" width="100%" style="font-size: 12px;"> <b>车牌号码：</b>
							<label></label><input TYPE="text" name="carnum" value="<?php echo set_value('carnum'); ?>" /><?php echo form_error('carnum'); ?>
							<label>车牌颜色：</label>
							<select name="color">
	                        <?php foreach ($color as $row): ?>
	                        <option value="<?php echo "$row"; ?>"><?php echo "$row"; ?></option>
	                        <?php endforeach; ?>
	                        </select>
							<input name="submit" type='submit' value="添加" />
						</td>
					</tr>
				</table>
			</form>
    
			<table align="center" width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($whilelist)): ?>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">序号</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">车牌号码</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">车牌颜色</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">状态</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作</span></div></td>
				</tr>
				<?php $rownum = 0;?>
				<?php foreach ($whilelist as $wl): ?>
				<?php if($wl->CLBJ == 'T')
				      {
				      	  $data['state'] = '已审核';
				      	  $data['style'] = 'STYLE27';
				      }
				      else
				      { 
				          $data['state'] = '未审核';
				          $data['style'] = 'STYLE26';
				      }
				?>
				<tr>
				    <td height="24" ><div align="center" class="STYLE23"><?php echo $rownum += 1; ?></div></td>	
					<td height="24" ><div align="center" class="STYLE24 "><?php echo $wl->HPHM;?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $wl->HPYS;?></div></td>
                    <td height="24" ><div align="center" class="<?php echo $data['style'];?>"><?php echo $data['state'];?></div></td>
                    <td height="24" ><div align="center" class="STYLE23"><?php if($wl->CLBJ == 'F'){echo anchor('dxa/edit_wl_check/'.$wl->ID,'审核');}else{echo '<lable style="color: #344b50; font-size: 12px;">已审核</lable>';}?> | <?php echo anchor('dxa/del_wl_set/'.$wl->ID, '删除', 'onclick="return confirm(' . "'确定要删除？'" . ')"')?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="24" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>没有相关车牌信息。</h3>
					</div></td>
				</tr>
				<?php endif; ?>
			</table>
			
		</td>
	</tr>

</table>
</body>
</html>

