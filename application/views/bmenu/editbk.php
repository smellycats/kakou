<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<script defer="defer" type="text/javascript" src=<?php echo base_url() . "js/My97DatePicker/WdatePicker.js"; ?>></script>
<script type="text/javascript">
function comeback(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/gate/carquery_ok/?type_alias=' . $type_alias . "&lane=" . $lane . "&direction=" . $direction . "&color=" . $color . "&number=" . $number . "&carnum=" . $carnum . "&starttime=" . $starttime . "&endtime=" . $endtime . "&spcarnum=" . $spcarnum . "&per_page=" . $per_page .  '"'?>;
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;布控车辆详细信息</span></td>
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
<form method="post" action="<?php echo site_url('bmenu/edit_bk_info_ok'); ?>">
<div align="center">
 <table align="center" width="700px" border="1" cellspacing="0" bordercolor="#659DC2">
     <tr bgcolor="#e6e6e6"><td><input type="hidden" name="id" id="id" size=13 style="width:100px"  value="<?php echo $bkinfo->ID;?>" /></td></tr>
     <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" style="font-size: 12px;" >车牌号码:</td>
        <td bordercolor="#E6E6E6" ><input name="carnum"id="carnum" size=13 style="width:100px"  value="<?php echo str_replace('_', '?', $bkinfo->HPHM);?>"><span style="color:#f00">*</span>
        </td>
          <td bordercolor="#E6E6E6" style="font-size: 12px;">车牌颜色:</td><td bordercolor="#E6E6E6">
                <select name="color">
                <?php foreach ($color as $row): ?>
                <option value="<?php echo "$row"; ?>"<?php if ($bkinfo->HPYS==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
          </td>
      </tr>
      <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" style="font-size: 12px;">车辆类型:</td>
        <td bordercolor="#E6E6E6"><input id="cartype" name="cartype" style="width:140px" value="<?php echo $bkinfo->CLLX;?>"><span class="RED"><?php echo form_error('cartype'); ?></span></td>
        <td bordercolor="#E6E6E6" style="font-size: 12px;">布控原因:</td>
        <td bordercolor="#E6E6E6">
                <select name="reason">
                <?php foreach ($reason as $row): ?>
                <option value="<?php echo "$row"; ?>"<?php if ($bkinfo->BCXW==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
                <span style="color:#f00">*</span></td>
      </tr>
      <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" style="font-size: 12px;">布控人:</td>
        <td bordercolor="#E6E6E6"> <input style="color:#888" readonly id="user" name="user" value="<?php echo $bkinfo->BCDW; ?>" style="width:140px"></td>
        <td bordercolor="#E6E6E6" style="font-size: 12px;">联系人:</td>
        <td bordercolor="#E6E6E6"><input id="linkman" name="linkman" size=8 style="width:140px" value="<?php echo $bkinfo->LXMAN;?>"><span class="RED">*<?php echo form_error('linkman'); ?></span></td>
      </tr>
      <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" style="font-size: 12px;">布控时间: </td>
        <td bordercolor="#E6E6E6"><input id="starttime" name="starttime" value="<?php echo $bkinfo->BCSJ;?>" readonly style="color:#888;width:140px"></td>
        <td bordercolor="#E6E6E6" style="font-size: 12px;">电话:</td>
        <td bordercolor="#E6E6E6"><input id="telnum" name="telnum" size=12 style="width:140px" value="<?php echo $bkinfo->LXDH;?>"><span class="RED">*<?php echo form_error('telnum'); ?></span></td>
      </tr>

	   <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" style="font-size: 12px;">撤控审核人:</td>
        <td bordercolor="#E6E6E6"><input type="text" name="ckshr"  style="color:#888;width:140px" readonly="readonly" value="<?php echo $bkinfo->SHMAN;?>" /></td>
		<td bordercolor="#E6E6E6" style="font-size: 12px;">撤控原因:</td>
        <td bordercolor="#E6E6E6"><input type="text" name="ckreason"  style="color:#888;width:140px" readonly="readonly" value="<?php echo $bkinfo->CKYY;?>" /></td>
      </tr>
      
      <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" style="font-size: 12px;">案情简介:</td>
        <td colspan="3" bordercolor="#E6E6E6"><textarea name="introduction" id="introduction" style="WIDTH: 500px; HEIGHT: 60px"><?php echo $bkinfo->MEMO;?></textarea><span class="RED"><?php echo form_error('introduction'); ?></span></td>
      </tr>
      
	  <tr bgcolor="#e6e6e6">
		<td bordercolor="#e6e6e6"><input type="checkbox" name="lsbk" value="True" <?php echo $bkinfo->LK == 'T' ? 'checked="checked"' : ''?> >启用<br/><span style="color:blue">临时布控</span></td>
		<td colspan="3" bordercolor="#e6e6e6">
			接收信息的手机号 <span style="color:blue">(多个号码之间, 请用","分隔.)</span>:<br />
			<textarea id="mobiles" name="mobiles" style="width:460px; height:60px"><?php echo $bkinfo->MOBILES;?></textarea><br />
			<span style="color:blue">当勾选为临时布控时，报警信息只发送给上方设置的接收信息的手机号。</span>
		</td>
	  </tr>
	  
	  <tr align="center" bgcolor="#e6e6e6"></td></tr>
      <tr bgcolor="#e6e6e6">
        <td colspan="4" bordercolor="#E6E6E6" align="center" style="font-size: 12px;">
		<input type="submit" name="submit"  value="布控" <?php if ($ck_right == 0){echo 'disabled="disabled"';}else{echo '';}?>>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="goback" id="goback" value="返回" onclick="javascript:history.go(-1);" >&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
    </table>
	
	</div>
</form>
</table>
</body>
</html>


