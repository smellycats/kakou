<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>

</head>
<body>
<script type="text/javascript" src=<?php echo base_url() . "js/xhedit1.1.0/jquery/jquery-1.4.2.min.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/kakou.js"; ?>></script>
<script>
function changeBG(object, colorvalue)
{
	for (i=1; i<=10; i++)
		object.all['col_'+i].style.backgroundColor = colorvalue;

	return true;
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;���س�����ѯ</span></td>
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
        <form method="get" action="<?php echo site_url('bmenu/bkfind_search_ok'); ?>">
		<div align="center">
		<table align="center" width="100%" border="1" cellspacing="0" bordercolor="#639CBF">
          <tr>	
            <td bordercolor="#E6E6E6" bgcolor="#E6E6E6" class="BLACK">���س���:</td>
            <td bordercolor="#E6E6E6" bgcolor="#E6E6E6" class="BLACK"><input id="carnum" name="carnum" value="<?php echo $sel_carnum; ?>"></td>
            <td bordercolor="#E6E6E6" bgcolor="#E6E6E6" class="BLACK">������:</td>
            <td bordercolor="#E6E6E6" bgcolor="#E6E6E6" class="BLACK"><input id="bkr" name="bkr" value="<?php echo $sel_bkr; ?>"></td>
            <td bordercolor="#E6E6E6" bgcolor="#E6E6E6" class="BLACK">����ԭ��:</td>
            <td bordercolor="#E6E6E6" bgcolor="#E6E6E6" class="BLACK">
                <select name="reason">
                <?php foreach ($reason as $row): ?>
                <option value="<?php echo $row; ?>" <?php if ($sel_reason==$row){echo " selected";} ?>><?php echo $row; ?></option>
                <?php endforeach; ?>
                </select>
            <td bordercolor="#E6E6E6" bgcolor="#E6E6E6" class="BLACK">״̬:</td>
            <td bordercolor="#E6E6E6" bgcolor="#E6E6E6" class="BLACK">
                <select name="state">	
                <?php foreach ($state as $row): ?>
                <option value="<?php echo $row; ?>" <?php if ($sel_state==$row){echo " selected";} ?>><?php echo $row; ?></option>
                <?php endforeach; ?>
                </select>
            <td bordercolor="#E6E6E6" bgcolor="#E6E6E6" ><input name="submit" type="submit" id="submit" class="BUTBLACK14" title="��ѯ" value="��ѯ"></td>
          </tr>
        </table></div>
	    </form>
	</tr>
	<tr>
		<td><?php
			$attr = array('name'=>'form1');
			echo form_open('admin/del_article_all', $attr);
			?>
			<?php if (!empty($bk)): ?>
		  <div id="find-list">
		  	  <div style="float:left"><label class="BOLDBLACK">��¼�� <?php echo $total_rows; ?>��     ��<?php echo $total_pages; ?> ҳ</label></div>
		  	  <br>
			  <table width="100%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				    <td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">���</span></div></td>
					<td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">״̬</span></div></td>
					<td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">�ٿ�</span></div></td>
					<td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">���ƺ���</span></div></td>
					<td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">��ɫ</span></div></td>
					<td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">��������</span></div></td>
					<td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">����ʱ��</span></div></td>
					<td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">������</span></div></td>
					<td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">��ϵ��</span></div></td>
					<td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">����ԭ��</span></div></td>
				    <td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">����ԭ��</span></div></td>
				    <td height="28" bgcolor="#4e87d6" ><div align="center"><span class="LIST">����</span></div></td>
				</tr>
				<?php $rownum = 0;?>
				<?php foreach ($bk as $row): ?>
				<tr>
						<?php 
						if ($row->CLBJ =='T' && $row->CKBJ == 'F')
						{
							$color = 'RED';
							$state = '�Ѳ���';
						}
						else if ($row->CLBJ == 'T' && $row->CKBJ == 'T')
						{
							$color = 'GRAY';
							$state = '���ش����';
						}
						else if ($row->CLBJ == 'F' || $row->CLBJ == 'X' || $row->CLBJ == '')
						{
							$color = 'SKYBLUE';
							$state = '�ѳ���';
						}
						?>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $offset + $rownum + 1; ?></div></td>	
					<td height="24" ><div align="center" class="<?php echo $color;?>"><?php echo $state;?></div></td>
					<td height="24" ><div align="center" class="GREEN"><?php if($row->LK == 'T'){echo '�ٿ�';}?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php $carnum = str_replace('_', '?', $row->HPHM);echo anchor('bmenu/edit_bk_info/'.$row->ID,$carnum)?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->HPYS?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->CLLX?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->BCSJ?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->BCDW?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->LXMAN?></div></td>
					<td height="20" ><div align="center" class="STYLE23"><?php echo $row->BCXW?></div></td>
                    <td height="20" ><div align="center" class="STYLE23"><?php echo $row->CKYY?></div></td>
                    <td height="20" ><div align="center" class="<?php if ($ck_right == 0){echo 'STYLE28';}else{echo 'STYLE23';}?>">
                    <?php 
                    if ($ck_right == 0)
                    {
                    	echo '����';
                    }
                    else if ($row->CLBJ == 'T' && $row->CKBJ == 'T')
                    {
                    	echo anchor('bmenu/edit_bk_cksh/'.$row->ID,'�������');
                    }
                    else if($row->CLBJ == 'T' && $row->CKBJ == 'F')
                    {
                        echo anchor('bmenu/edit_bk_ck/'.$row->ID,'����');
                    }
                    else if ($row->CLBJ == 'F')
                    {
                    	echo anchor('bmenu/edit_bk_bk/'.$row->ID,'����');
                    }
                    ?>
                    <?php if ($role_id == 1){echo anchor('bmenu/del_bk/'.$row->ID, '| ɾ��', 'onclick="return confirm(' . "'ȷ��Ҫɾ����'" . ')"');}else{echo '';} ?>
                    </div></td>
				</tr>
				<?php $rownum += 1;?>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3></h3>
					</div></td>
				<?php endif; ?>
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
