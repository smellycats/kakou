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
	<div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="24" bgcolor="#353c44">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="6%" height="19" valign="bottom"><div align="center"><img src="images/admin/tb.gif" width="14" height="14" /></div></td>
										<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;���Գ�����ѯ</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<!--
	<tr>	<td><input id="d11" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" style="width:150px"/></td></tr>
	-->

	<div>
		<form method="get" action="<?php echo site_url('gate/slquery_ok'); ?>">
	  		<div align="center">
	    <table align="center" cellpadding="2" cellspacing="0" class="bg9cf align-left" id="findbox-input-table">
	      <tr align="center">
	        <td height="18" colspan="7" style="font-size: 12px;"><span class="STYLE13">������ѯ��������</span></td>
          </tr>
	      <tr>
	        <td style="width:70px;font-size: 12px;">��ص�����:</td>
            <td>
                <select name="type_alias">
                <option value="all" <?php if ($sel_type_alias=='all'){echo " selected";} ?>>����</option>
                <?php foreach ($okkval as $id=>$kakou): ?>
                <option value=<?php echo '"'.$kakou.'"'; ?> <?php if ($sel_type_alias==$kakou){echo " selected";} ?>><?php echo $openkakou[$id]; ?></option>
                <?php endforeach; ?>
                </select>
			</td>
            <td style="width:70px;font-size: 12px;">��&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
			<td>
                <select name="lane">
                <option value="all" <?php if ($sel_lane=='all'){echo " selected";} ?>>����</option>
                <?php foreach ($lane as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_lane==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
           </td>
			<td style="width:70px;font-size: 12px;">��&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
			<td >
                <select name="direction">
                <option value="all" <?php if ($sel_direction=='all'){echo " selected";} ?>>����</option>
                <?php foreach ($direction as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_direction==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
			 </td>
			<td style="font-size: 12px;">������ɫ:</td>
			<td>
                <select name="color">
                <option value="all" <?php if ($sel_color=='all'){echo " selected";} ?>>����</option>
                <?php foreach ($color as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_color==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
			</td>	
          </tr>
	      <tr>
	        <td style="font-size: 12px;">ʱ&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
            <td colspan="3">
                <input id="starttime" type="text" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_starttime;?>" style="width:150px"/>
                <label style="font-size: 12px;">��</label>
                <input id="endtime" type="text" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_endtime;?>" style="width:150px"/>
            </td>
	        <td style="font-size: 12px;">���ƺ���:</td>
            <td colspan="2">
                <select name="number">
                <?php foreach ($number as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_number==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
              <input type="text" name="carnum" value="<?php echo $sel_carnum;?>" class="inp" style="width:125px;"/>
			</td>
		  </tr>
	      <tr>
	        <td style="font-size: 12px;">�ض�����:</td>
            <td colspan="6">
			  <input type="text" name="spcarnum" value="<?php echo $sel_spcarnum;?>" style="height:20px;width:430px"  /><span class="BLUE" >֧�ֶ������,���ŷָ�</span>
			</td>
			<td align="right">
			  <input class="BUTBLACK" type="submit" name="query_find" id="btnsubmit" value="��ѯ" title="��ѯ" style="width:50px"/>
			</td>
		  </tr>
	    <tr align="center">
	    	<td colspan="7">
	    		<font class="BLUE">��ʾ:���ƺ���֧��ģ����ѯ,��ȷ�����ַ�(��������,����)����"?"����;��������Ĳ�ȷ��λ,����һ��"*"����.<br />������ѡ��"-"�ɵ�����ѯ��ʶ�����ļ�¼��</font>
	    	</td>
	    </tr>
	    </table>
	    </div>
	    </form>
	</div>
	
	<div align="center" >
		<form method="post" action="<?php echo site_url('gate/showdetail'); ?>">
		  	    <?php if (!empty($car)): ?>
		    <div style="width:95%">
		        <div style="float:left"><span class="BLACK">��¼�� <?php echo $total_rows; ?>��     ��<?php echo $total_pages; ?> ҳ</span></div>
		        <div style="float:right"><span class="BLACK"><?php echo anchor('export/exportexcel/?type_alias='. $sel_type_alias . '&lane=' . $sel_lane . '&direction=' . $sel_direction . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime . '&spcarnum=' . $sel_spcarnum , '����ѯ���������Excel-���ǰ'. $xls_num . '����'); ?></span></div>
		        <div style="float:right"><span class="BLACK"><?php echo anchor('export/get_imgs/?type_alias='. $sel_type_alias . '&lane=' . $sel_lane . '&direction=' . $sel_direction . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime . '&spcarnum=' . $sel_spcarnum , '����������ͼƬ-���ǰ'. $img_num . '����'); ?></span></div>
		    </div>
			<table width="95%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
				<?php $picnum = 0;?>
				<?php $count = 0;?>
				<?php foreach ($car as $row): ?>
				<?php if($picnum % 4 === 0){echo "<tr>";}?>
				<?php $rownum = $offset + $count + 1;?>
				    <td>
			            <a href=<?php echo '"' . base_url() . 'index.php/gate/slshowdetail/?type_alias=' . $sel_type_alias . '&lane=' . $sel_lane . '&direction=' . $sel_direction . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&spcarnum=' .'&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime . $sel_spcarnum . '&per_page=' . $offset . '&rownum=' . $rownum . '"' ; ?>> 
				            <img src=<?php echo 'http://'.$imgpath[$row->TPWZ].'/'. $row->QMTP . "/" . $row->TJTP;;?> style="width:224px;height:168px;border:1px solid #b0b0b0" alt="����:<?php echo $row->HPHM;?>&#10ʱ��:<?php echo $row->PASSTIME;?>&#10����:<?php echo $row->WZDD;?>&#10����:<?php echo $row->FXBH;?>"/>
			            </a>
			        </td>
			        <?php $picnum += 1;?>
			    <?php $count += 1;?>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#ffffff" class="STYLE19"><div align="center"><h3><?php echo $message;?></h3></div></td>
				<?php endif;?>
				</tr>
			</table>
		</form>
	</div>
	
	<div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="33%"><div align="center"><span class="STYLE22"><?php echo $this->pagination->create_links();?></span></div></td>
			</tr>
		</table>
	</div>
</body>
</html>
