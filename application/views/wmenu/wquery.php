<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>

</head>
<body>
<script defer="defer" type="text/javascript" src=<?php echo base_url() . "js/My97DatePicker/WdatePicker.js"; ?>></script>
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;������������ѯ</span></td>
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
	<!--
	<tr>	<td><input id="d11" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" style="width:150px"/></td></tr>
	-->

	<div>
	<form method="get" action="<?php echo site_url('wmenu/wquery_ok'); ?>">
	  <div align="center">
	    <table align="center" border="1" cellpadding="2" cellspacing="0" bordercolor="#6AA3C6" class="bg9cf align-left" id="findbox-input-table">
	      <tr align="center" bordercolor="#E6E6E6">
	        <td height="18" colspan="7" style="font-size: 12px;" background="image/tb.gif"><span class="STYLE13">������ѯ��������</span></td>
          </tr>
	      <tr bordercolor="#E6E6E6">
	        <td style="width:70px;font-size: 12px;">��ص�����:</td>
            <td>
                <select name="type_alias">
                <option value="all" <?php if ($sel_type_alias=='all'){echo " selected";} ?>>����</option>
                <?php foreach ($openkakou as $kakou): ?>
                <option value="<?php echo "$kakou"; ?>" <?php if ($sel_type_alias==$kakou){echo " selected";} ?>><?php echo "$kakou"; ?></option>
                <?php endforeach; ?>
                </select>
			</td>
            <td style="width:70px;font-size: 12px;">��&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
			<td style="width:120px">
                <select name="lane">
                <option value="all" <?php if ($sel_lane=='all'){echo " selected";} ?>>����</option>
                <?php foreach ($lane as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_lane==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
           </td>
			<td style="width:70px;font-size: 12px;">��&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
			<td style="width:120px">
                <select name="direction">
                <option value="all" <?php if ($sel_direction=='all'){echo " selected";} ?>>����</option>
                <?php foreach ($direction as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_direction==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
			 </td>
			 <td>&nbsp;</td>
          </tr>
	      <tr bordercolor="#E6E6E6">
	        <td style="font-size: 12px;">���ƺ���:</td>
            <td>
                <select name="number">
                <?php foreach ($number as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_number==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
              <input type="text" name="carnum" value="<?php echo set_value('carnum')?>" class="inp" style="width:125px;"/>
              &nbsp;
			</td>
			<td style="font-size: 12px;">������ɫ:</td>
			<td colspan="3">
                <select name="color">
                <option value="all" <?php if ($sel_color=='all'){echo " selected";} ?>>����</option>
                <?php foreach ($color as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_color==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
			</td>
			<td>&nbsp;</td>
          </tr>
	      <tr bordercolor="#E6E6E6">
	        <td style="font-size: 12px;">ʱ&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
            <td colspan="6" font-size: 12px;>
                <input id="starttime" type="text" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy/M/d H:mm:ss',readOnly:true})" value="<?php echo $sel_starttime;?>" style="width:150px"/>
                <lable style="font-size: 12px;">��</lable>
                <input id="endtime" type="text" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy/M/d H:mm:ss',readOnly:true})" value="<?php echo $sel_endtime;?>" style="width:150px"/>
			<td align="right">
			<input type="submit" name="query_find" id="btnsubmit" value="��ѯ" title="��ѯ" style="width:50px"/>
			</td>
			</tr>
	    <tr align="center" bordercolor="#E6E6E6"><td style="font-size: 12px;" colspan="7"><font color='blue'>��ʾ:���ƺ���֧��ģ����ѯ,��ȷ�����ַ�(��������,����)����"?"����;��������Ĳ�ȷ��λ,����һ��"*"����.<br />������ѡ��"-"�ɵ�����ѯ��ʶ�����ļ�¼��</font> </td>
	    </tr>
	    </table></div>
	    </form>
	</div>
	
	<tr>
		<td>
		  <form method="post" action="<?php echo site_url('gate/showdetail'); ?>">
		  		<?php if (!empty($car)): ?>
		    <div id="find-list">
		        <div style="float:left"><label style="font-size:12px;color:#000000">��¼�� <?php echo $total_rows; ?>��     ��<?php echo $total_pages; ?> ҳ</label></div>
				<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tab">
					<tr>
					    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">���</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">���ƺ���</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">������ɫ</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">ͨ��ʱ��</span></div></td>
					    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��ص�����</span></div></td>
					    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
					    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
					    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
					</tr>
					<?php $rownum = 0;?>
					<?php foreach ($car as $row): ?>
					<tr>
					    <td height="24" ><div align="center" class="STYLE23"><?php echo $offset + $rownum + 1; ?></div></td>
						<td height="24" ><div align="center" class="STYLE24"><?php echo $row->HPHM; ?></div></td>
						<td height="24" ><div align="center" class="STYLE23"><?php echo $row->HPYS; ?></div></td>
						<td height="24" ><div align="center" class="STYLE23"><?php echo $row->PASSTIME; ?></div></td>
						<td height="24" ><div align="center" class="STYLE23"><?php echo $row->WZDD; ?></div></td>
						<td height="24" ><div align="center" class="STYLE23"><?php echo $row->FXBH; ?></div></td>
						<td height="24" ><div align="center" class="STYLE23"><?php echo $row->CDBH; ?></div></td>
						<td height="24" ><div align="center" class="STYLE23"><?php echo anchor('wmenu/wl_showdetail/'. $row->ID , '�鿴'); ?><?php if($role_id == '1'){echo '|'. anchor('gate/del_showdetail/' . $row->ID, 'ɾ��', 'onclick="return confirm(' . "'ȷ��Ҫɾ����'" . ')"');}else{echo '';} ?></div></td>
					</tr>
					<?php $rownum += 1;?>
					<?php endforeach; ?>
					<tr>
					<?php else: ?>
						<td height="20" bgcolor="#ffffff" class="STYLE19"><div align="center"><h3>û�г�����¼��</h3></div></td>
					<?php endif;?>
					</tr>
				</table>
			</div>
		  </form>
		</td>
	</tr>
	
	<tr>
		<td height="30">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="33%"><div align="center"><span class="STYLE22"><?php echo $this->pagination->create_links();?></span></div></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
