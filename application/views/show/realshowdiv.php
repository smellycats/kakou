<?php header("Content-Type:text/html;charset=gbk");  ?>
	<div class="clearfix" style="width:100%;">
	<?php if (!empty($newestdata)): ?>
		<div id="imgframe" class="clearfix" style="float:left;width:880px;;">
			<a class="jqzoom" rel="gall" href=<?php echo $pic_url; ?> target="_blank" title="�ۿ��Ŵ�ͼƬ���ڣ��Ҽ�����">
				<img src=<?php echo $pic_url; ?> class="car" style="height:330px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left; width:860px; border-top:1px solid #eee;border-left:1px solid #eee; border-right: 1px solid #888; border-bottom: 1px solid #888;background-color:#fafafa;">
			<div style="float:left;width:260px">
				<table width="100%" cellspacing="0" cellpadding="1px" style="padding: 0px 0px;">
                    <tr><td><input type="hidden" id="id" name="id" value="<?php echo $newestdata->ID;?>" /></td></tr>
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="color:white;background-color:blue">ʵʱ��������</td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">�������ƣ�</td><td class="STYLE23"><label><?php echo $newestdata->WZDD;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">������ţ�</td><td class="STYLE23"><label><?php echo $newestdata->CDBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">��������</td><td class="STYLE23"><label><?php echo $newestdata->FXBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">ͨ��ʱ�䣺</td><td class="STYLE23"><label><?php echo $newestdata->PASSTIME;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">���ƺ��룺</td><td class="STYLE23"><label style="font-family:arial,����;font-weight:bold;font-size:14px;color:blue"><?php echo $newestdata->HPHM;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">������ɫ��</td><td class="STYLE23"><label><?php echo $newestdata->HPYS;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">�����ٶȣ�</td><td class="STYLE23"><label><?php echo $newestdata->CLSD;?></label></td></tr>

				</table>
			</div>
	  <?php else: ?>
	  		<div align="center">
	  			<span class="TITLE2">
					û������!
				</span>
			</div>
      <?php endif; ?>
			<div style="float:left;width:600px">
			<table width="100%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($realdata)): ?>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��ɫ</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">ͨ��ʱ��</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��ص�</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">�ٶ�</span></div></td>
				</tr>
				<?php foreach ($realdata as $row): ?>
				<tr>
					<td height="20" bgcolor="#FFFFFF" class="STYLE24"><div align="center"><?php if($row->HPHM == ''){$hphm = '��';}else{$hphm = $row->HPHM;}echo anchor('show/show_showdetail/'.$row->ID, $hphm);?></div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->HPYS?></div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->PASSTIME?></div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->WZDD?></div></td> 
					<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->FXBH?></div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->CLSD?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>û������!</h3>
					</div></td>
				<?php endif; ?>
				</tr>
			</table>
			</div>
		</div>
	</div>