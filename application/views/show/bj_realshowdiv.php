<?php header("Content-Type:text/html;charset=gbk");  ?>
	<div class="clearfix" style="width:100%;">
	<?php if (!empty($newestdata)): ?>
		<div id="imgframe" class="clearfix" style="float:left;width:880px;;">
			<a class="jqzoom" rel="gall" href=<?php echo $pic_url;?> target="_blank" title="�ۿ��Ŵ�ͼƬ���ڣ��Ҽ�����">
				<img src=<?php echo $pic_url; ?> class="car" style="height:330px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left; width:900px; border-top:1px solid #eee;border-left:1px solid #eee; border-right: 1px solid #888; border-bottom: 1px solid #888;background-color:#fafafa;">
			<div style="float:left;width:240px">
				<table width="100%" cellspacing="1" cellpadding="1px" style="padding: 0px 0px;">
                    <tr><td><input type="hidden" id="id" name="id" value="<?php echo $newestdata->ID;?>" /></td></tr>
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="color:white;background-color:red">�ֳ�ץ������</td></tr>
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
			<div style="float:left;width:260px">
				<table width="100%" cellspacing="1" cellpadding="1px" style="padding: 0px 0px;" >
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="color:white;background-color:red">������������</td></tr>
					<?php if (!empty($bmenu)): ?>
					<tr style="font-size: 12px;"><td class="STYLE23">���ƺ��룺</td><td class="STYLE23"><label style="font-family:arial,����;font-weight:bold;font-size:16px;color:blue"><?php echo $bmenu->HPHM;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">������ɫ��</td><td class="STYLE23"><label><?php echo $bmenu->HPYS;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">�������ͣ�</td><td class="STYLE23"><label><?php echo $bmenu->CLLX;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">����ԭ��</td><td class="STYLE23"><label><?php echo $bmenu->BCXW;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">����ʱ�䣺</td><td class="STYLE23"><label><?php echo $bmenu->BCSJ;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">������ϵ�ˣ�</td><td class="STYLE23"><label><?php echo $bmenu->LXMAN;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">��ϵ�绰��</td><td class="STYLE23"><label><?php echo $bmenu->LXDH;?></label></td></tr>
					<tr style="font-size: 12px;height: 48px"><td class="STYLE23">����������</td><td class="STYLE23"><label><?php echo $bmenu->MEMO;?></label></td></tr>
					<?php else: ?>
				    <tr>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>�޷���λ������Ϣ!</h3>
					</div></td>
					</tr>
					<?php endif; ?>
				</table>
			</div>
			
			<div style="float:left;width:400px">
				<table width="100%" border="0" cellpadding="0" cellspacing="1" >
					<tr>
					<?php if (!empty($realdata)): ?>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��ɫ</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">ͨ��ʱ��</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��ص�</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��������</span></div></td>
					</tr>
					<?php foreach ($realdata as $row): ?>
					<tr>
						<td height="20" bgcolor="#FFFFFF" class="STYLE24"><div align="center"><?php if($row->HPHM == ''){$hphm = '��';}else{$hphm = $row->HPHM;} echo anchor('show/show_bj_showdetail/' . $row->ID, $hphm);?></div></td>
						<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->HPYS?></div></td>
						<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->PASSTIME?></div></td>
						<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->WZDD?></div></td>
						<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->FXBH?></div></td>
	                    <td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo "����";?></div></td>
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