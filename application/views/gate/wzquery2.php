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
										<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;Υ��������ѯ</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<div align="center">
		<form method="get" action="<?php echo site_url('gate/wzquery_ok'); ?>">
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
		            <td style="width:70px;font-size: 12px;">Υ������:</td>
					<td align="left" style="width:120px">
		                <select name="breakrule">
		                <option value="all" <?php if ($sel_breakrule=='all'){echo " selected";} ?>>����</option>
		                <?php foreach ($breakrule as $row): ?>
		                <option value="<?php echo "$row"; ?>" <?php if ($sel_breakrule==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
		                <?php endforeach; ?>
		                </select>
		          	</td>
					<td style="width:70px;font-size: 12px;">��¼״̬:</td>
					<td style="width:120px">
		                <select name="record">
		                <option value="all" <?php if ($sel_record=='all'){echo " selected";} ?>>����</option>
		                <?php foreach ($record as $row): ?>
		                <option value="<?php echo "$row"; ?>" <?php if ($sel_record==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
		                <?php endforeach; ?>
		                </select>
					 </td>
	          	</tr>
		      <tr>
		        <td style="font-size: 12px;">���ƺ���:</td>
	            <td>
	                <select name="number">
	                <?php foreach ($number as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_number==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
	              <input type="text" name="carnum" value="<?php echo $sel_carnum;?>" class="inp" style="width:125px;"/>
				</td>
				<td style="font-size: 12px;">������ɫ:</td>
				<td align="left" style="width:120px">
	                <select name="color">
	                <option value="all" <?php if ($sel_color=='all'){echo " selected";} ?>>����</option>
	                <?php foreach ($color as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_color==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
				</td>
				<td style="width:70px;font-size: 12px;">��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
				<td style="width:120px;font-size: 12px;">
				           ��С<input type="text" name="minspeed" value="<?php echo $sel_minspeed;?>" class="inp" size="2" />
				    &nbsp;���<input type="text" name="maxspeed" value="<?php echo $sel_maxspeed;?>" class="inp" size="2" />
				</td>
				<td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td style="font-size: 12px;">ʱ&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
	            <td align="left" colspan="6">
	                <input id="starttime" type="text" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_starttime;?>" style="width:150px"/>
	                <span>��</span>
	                <input id="endtime" type="text" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_endtime;?>" style="width:150px"/>
				</td>
				<td>
					<input class="BUTBLACK" type="submit" name="query_find" id="btnsubmit" value="��ѯ" title="��ѯ" style="width:50px"/>
				</td>
				</tr>
		    <tr align="center" ><td style="font-size: 12px;" colspan="7"><font color='blue'>��ʾ:���ƺ���֧��ģ����ѯ,��ȷ�����ַ�(��������,����)����"?"����;��������Ĳ�ȷ��λ,����һ��"*"����.<br />������ѡ��"-"�ɵ�����ѯ��ʶ�����ļ�¼��</font> </td>
		    </tr>
		    </table>
	    </form>
	</div>
	
	<div align="center">
	  <form method="post" action="<?php echo site_url('gate/showdetail'); ?>">
	  	    <?php if (!empty($car)): ?>
	    <div style="width:95%">
	        <div style="float:left"><span class="BLACK">��¼�� <?php echo $total_rows; ?>��     ��<?php echo $total_pages; ?> ҳ</span></div>
	        <div style="float:right"><span class="BLACK"><?php echo anchor('export/wz_exportexcel/?type_alias='. $sel_type_alias . '&record=' . $sel_record . '&breakrule=' . $sel_breakrule . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime . '&minspeed=' . $sel_minspeed . '&maxspeed=' . $sel_maxspeed, '����ѯ���������Excel-���ǰ'. $xls_num . '����'); ?></span></div>
	        <div style="float:right"><span class="BLACK"><?php echo anchor('export/get_imgs/?type_alias='. $sel_type_alias . '&record=' . $sel_record . '&breakrule=' . $sel_breakrule . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime . '&minspeed=' . $sel_minspeed . '&maxspeed=' . $sel_maxspeed, '����������ͼƬ-���ǰ' . $img_num . '�š�');?></span></div>
		</div>
		<table width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
			<tr>
			    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">#</span></div></td>
				<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">���ƺ���</span></div></td>
				<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">������ɫ</span></div></td>
				<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">ͨ��ʱ��</span></div></td>
			    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��ص�����</span></div></td>
			    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
			    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
			    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
			    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">Υ������</span></div></td>
			    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
			</tr>
			<?php $count = 0;?>
			<?php foreach ($car as $row): ?>
			<tr>
			    <?php $rownum = $offset + $count + 1;?>
			    <td height="24" ><div align="center" class="STYLE23"><?php echo $rownum; ?></div></td>
				<td height="24" ><div align="center" class="STYLE24"><?php echo $row->HPHM; ?></div></td>
				<td height="24" ><div align="center" class="STYLE23"><?php echo $row->HPYS; ?></div></td>
				<td height="24" ><div align="center" class="STYLE23"><?php echo $row->PASSTIME; ?></div></td>
				<td height="24" ><div align="center" class="STYLE23"><?php echo $row->WZDD; ?></div></td>
				<td height="24" ><div align="center" class="STYLE23"><?php echo $row->FXBH; ?></div></td>
				<td height="24" ><div align="center" class="STYLE23"><?php echo $row->CDBH; ?></div></td>
				<td height="24" ><div align="center" class="STYLE23"><?php echo $row->CLSD; ?></div></td>
				<td height="24" ><div align="center" class="STYLE23">
				    <?php if($row->CLBJ=='O')
				          {echo "����";}
				          elseif($row->CLBJ=='N'){echo "����";}
				          elseif($row->JLLX=='2' || $row->JLLX=='3'){echo "�����";}
				          elseif($row->JLLX=='4'){echo "����������ʻ";}
				          else{echo '';}
				    ?>
				</div></td>
				<td height="24" ><div align="center" class="STYLE23"><?php echo anchor('gate/wz_showdetail/?type_alias=' . $sel_type_alias . "&record=" . $sel_record . "&breakrule=" . $sel_breakrule . "&color=" . $sel_color . "&number=" . $sel_number . "&carnum=" . $sel_carnum . "&starttime=" . $sel_starttime . "&endtime=" . $sel_endtime . "&minspeed=" . $sel_minspeed. "&maxspeed=" . $sel_maxspeed . "&per_page=" . $offset . '&rownum=' . $rownum, '�鿴'); ?></div></td>
			</tr>
			<?php $count += 1;?>
			<?php endforeach; ?>
			<tr>
			<?php else: ?>
				<td height="24" bgcolor="#ffffff" class="STYLE23"><div align="center"><h3><?php echo $message;?></h3></div></td>
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
