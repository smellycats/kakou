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

<!--<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	-->
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
										<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;������ѯ</span></td>
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
		<form method="get" action="<?php echo site_url('logo/lgquery_ok'); ?>">
			<table cellpadding="2" cellspacing="0" class="bg9cf align-left" id="findbox-input-table">
				<tr align="center">
			      	<td height="18" colspan="7" style="font-size: 12px;"><span class="STYLE13">������ѯ��������</span></td>
		        </tr>
			    <tr>
			        <td style="width:70px;font-size: 12px;">��������:</td>
		            <td>
		                <select name="place">
		                <option value="all" <?php if ($lgquery['place']=='all'){echo " selected";} ?>>����</option>
		                <?php foreach ($places as $id=>$row): ?>
		                <option value="<?php echo $id; ?>" <?php if ($lgquery['place']==$id){echo " selected";} ?>><?php echo $row; ?></option>
		                <?php endforeach; ?>
		                </select>
					</td>
		            <td style="width:70px;font-size: 12px;">��&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
					<td>
		                <select name="lane">
		                <option value="all" <?php if ($lgquery['lane']=='all'){echo " selected";} ?>>����</option>
		                <?php foreach ($this->config->item('lane') as $row): ?>
		                <option value="<?php echo $row; ?>" <?php if ($lgquery['lane']==$row){echo " selected";} ?>><?php echo $row; ?></option>
		                <?php endforeach; ?>
		                </select>
		           </td>
					<td style="width:70px;font-size: 12px;">��&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
					<td >
		                <select name="direction">
		                <option value="all" <?php if ($lgquery['direction']=='all'){echo " selected";} ?>>����</option>
		                <?php foreach ($this->config->item('direction') as $id=>$row): ?>
		                <option value="<?php echo $id; ?>" <?php if ($lgquery['direction']==$id){echo " selected";} ?>><?php echo $row; ?></option>
		                <?php endforeach; ?>
		                </select>
					 </td>
					<td style="font-size: 12px;">������ɫ:</td>
					<td>
		                <select name="platecolor">
		                <option value="all" <?php if ($lgquery['platecolor']=='all'){echo " selected";} ?>>����</option>
		                <?php foreach ($this->config->item('platecolor') as $id=>$row): ?>
		                <option value="<?php echo $id; ?>" <?php if ($lgquery['platecolor']==$id){echo " selected";} ?>><?php echo $row; ?></option>
		                <?php endforeach; ?>
		                </select>
					</td>	
		        </tr>
		        
			    <tr>
			        <td style="width:70px;font-size: 12px;">������־:</td>
		            <td>
		                <select name="logo">
		                <option value="all" <?php if ($lgquery['logo']=='all'){echo " selected";} ?>>����</option>
		                <?php foreach ($logos as $id=>$row): ?>
		                <option value="<?php echo $id; ?>" <?php if ($lgquery['logo']==$id){echo " selected";} ?>><?php echo $row; ?></option>
		                <?php endforeach; ?>
		                </select>
					</td>
		            <td style="width:70px;font-size: 12px;">��������:</td>
					<td>
		                <select name="cllx">
		                <option value="all" <?php if ($lgquery['cllx']=='all'){echo " selected";} ?>>����</option>
		                <?php foreach ($this->config->item('cllx') as $id=>$row): ?>
		                <option value="<?php echo $id; ?>" <?php if ($lgquery['cllx']==$id){echo " selected";} ?>><?php echo $id.$row; ?></option>
		                <?php endforeach; ?>
		                </select>
		           </td>
					<td style="width:70px;font-size: 12px;">������ɫ:</td>
					<td >
		                <select name="csys">
		                <option value="all" <?php if ($lgquery['csys']=='all'){echo " selected";} ?>>����</option>
		                <?php foreach ($this->config->item('csys') as $id=>$row): ?>
		                <option value="<?php echo $id; ?>" <?php if ($lgquery['csys']==$id){echo " selected";} ?>><?php echo $row; ?></option>
		                <?php endforeach; ?>
		                </select>
					 </td>
		        </tr>
		        
			    <tr>
			        <td style="font-size: 12px;">ʱ&nbsp;&nbsp;&nbsp;&nbsp;��:</td>
		            <td colspan="3">
		                <input id="starttime" type="text" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $lgquery['starttime'];?>" style="width:150px"/>
		                <label style="font-size: 12px;">��</label>
		                <input id="endtime" type="text" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $lgquery['endtime'];?>" style="width:150px"/>
		            </td>
			        <td style="font-size: 12px;">���ƺ���:</td>
		            <td colspan="2">
		                <select name="number">
		                <?php foreach ($this->config->item('number') as $row): ?>
		                <option value="<?php echo $row; ?>" <?php if ($lgquery['number']==$row){echo " selected";} ?>><?php echo $row; ?></option>
		                <?php endforeach; ?>
		                </select>
		              <input type="text" name="carnum" value="<?php echo $lgquery['carnum'];?>" class="inp" style="width:125px;"/>
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
	    </form>
	</div>
	
	<div align="center">
	 	<form method="post" action="<?php echo site_url('gate/showdetail'); ?>">
		    <?php if (!empty($carinfo)): ?>
		    <table>
			    <div style="width:95%">
			        <div style="float:left"><span class="BLACK">��¼�� <?php echo $total_rows; ?>��     ��<?php echo $total_pages; ?> ҳ</span></div>
		        	<div style="float:right"><span class="BLACK"><?php echo anchor('export2/exportexcel', '����ѯ���������Excel-���ǰ' . $this->config->item('kakou_xls_num') . '����'); ?></span></div>
				</div>
			</table>
			<table width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">#</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">���ƺ���</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">������ɫ</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">ͨ��ʱ��</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��ص�����</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">������־</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">Ʒ������</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��������</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">������ɫ</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
				</tr>
				<?php $count = 0;?>
				<?php foreach ($carinfo as $row): ?>
				<tr>
				    <?php $rownum = $offset + $count + 1;?>
				    <td height="24" ><div align="center" class="STYLE23"><?php echo $rownum; ?></div></td>
					<td height="24" ><div align="center" class="STYLE24"><?php echo $row->cltx_hphm; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $platecolor[$row->cltx_color]; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->passtime; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $places[$row->cltx_place]; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->name; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->clpp; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $cllx[$row->cllx]; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $csys[$row->csys]; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $direction[$row->cltx_dire]; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->cltx_lane; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo anchor('logo/showdetail/'.$rownum, '�鿴') ?></div></td>
				</tr>
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
