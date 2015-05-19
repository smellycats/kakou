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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;车辆布控设置</span></td>
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
<form method="post" action="<?php echo site_url('bmenu/add_bk'); ?>">
<div align="center">
 <table align="center" width="700px" border="1" cellspacing="0" bordercolor="#659DC2">

	  <tr bgcolor="#e6e6e6">
		<td bordercolor="#e6e6e6">&nbsp;</td><td colspan="3" bordercolor="#e6e6e6" style="font-size: 12px;">
		<span class="BLUE" >注意: &nbsp;&nbsp;车牌号码支持模糊布控,不确定的字符(包括汉字,数字)请用"?"代替.</span>
		</td>
	  </tr>
 	  <tr align="center" bgcolor="#e6e6e6"><td colspan="4" bordercolor="#E6E6E6">&nbsp;</td>
 	  </tr>	
     <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" class="BLACK" >车牌号码:</td>
        <td bordercolor="#E6E6E6" class="BLACK">
                <select name="number">
                <?php foreach ($number as $row): ?>
                <option value="<?php echo "$row"; ?>"><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
            <input name="carnum"id="carnum" size=13 style="width:100px"  value="<?php echo set_value('carnum');?>"><span class="RED">*<?php echo form_error('carnum'); ?></span>
        </td>
          <td bordercolor="#E6E6E6" class="BLACK">车牌颜色:</td><td bordercolor="#E6E6E6">
                <select name="color">
                <?php foreach ($color as $row): ?>
                <option value="<?php echo "$row"; ?>"><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
          </td>
      </tr>
      <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" class="BLACK">车辆类型:</td>
        <td bordercolor="#E6E6E6" class="BLACK"><input id="cartype" name="cartype" style="width:140px" value="<?php echo set_value('cartype');?>"><span class="RED"><?php echo form_error('cartype'); ?></span></td>
        <td bordercolor="#E6E6E6" class="BLACK">布控原因:</td>
        <td bordercolor="#E6E6E6" class="BLACK">
                <select name="reason">
                <?php foreach ($reason as $row): ?>
                <option value="<?php echo "$row"; ?>"><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
                <span class="RED">*</span></td>
      </tr>
      <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" class="BLACK">布控人:</td>
        <td bordercolor="#E6E6E6" class="BLACK"> <input style="color:#888" readonly id="user" name="user" value="<?php echo $user; ?>" style="width:140px"></td>
        <td bordercolor="#E6E6E6" class="BLACK">联系人:</td>
        <td bordercolor="#E6E6E6" class="BLACK"><input id="linkman" name="linkman" size=8 style="width:140px" value="<?php echo set_value('linkman');?>"><span class="RED">*<?php echo form_error('linkman'); ?></span></td>
      </tr>
      <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" class="BLACK">布控时间: </td>
        <td bordercolor="#E6E6E6" class="BLACK"><input id="starttime" type="text" name="starttime" value="<?php echo $starttime;?>" readonly style="color:#888;width:140px"></td>
        <td bordercolor="#E6E6E6" class="BLACK">电话:</td>
        <td bordercolor="#E6E6E6" class="BLACK"><input id="telnum" name="telnum" size=12 style="width:140px" value="<?php echo set_value('telnum');?>"><span class="RED">*<?php echo form_error('telnum'); ?></span></td>
      </tr>

      <tr bgcolor="#e6e6e6">
        <td bordercolor="#E6E6E6" class="BLACK">案情简介:</td>
        <td colspan="3" bordercolor="#E6E6E6" class="BLACK"><textarea name="introduction" id="introduction" style="width: 500px; heigh: 60px"></textarea><span class="RED"><?php echo form_error('introduction'); ?></span></td>
      </tr>
      
	  <tr bgcolor="#e6e6e6">
		<td bordercolor="#e6e6e6" class="BLACK"><input type="checkbox" name="lsbk" value="True" >启用<br><span class="GREEN">临时布控</span></td>
		<td colspan="3" bordercolor="#e6e6e6" class="BLACK">
			接收信息的手机号 <span class="BLUE">(多个号码之间, 请用","分隔.)</span>:<br />
			<textarea id="mobiles" name="mobiles" style="width:500px; height:60px"></textarea><span class="RED"></span><br />
			<span class="BLUE">当勾选为临时布控时，报警信息只发送给上方设置的接收信息的手机号。</span>
		</td>
	  </tr>
	  
	  <tr align="center" bgcolor="#e6e6e6"></td></tr>
	<tr bgcolor="#e6e6e6">
        <td colspan="4" bordercolor="#E6E6E6" align="center">
			<input class="BUTBLACK14" type="submit" name="submit"  value="布控" onclick="return check();"/>&nbsp;&nbsp;&nbsp;&nbsp;
			<input class="BUTBLACK14"type="reset" name="重填" value="重填"/>&nbsp;&nbsp;&nbsp;&nbsp;		
		</td>
    </tr>
    </table>
	
	</div>
</form>
</table>
</body>
</html>


