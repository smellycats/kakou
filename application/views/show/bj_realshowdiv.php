<?php header("Content-Type:text/html;charset=gbk");  ?>
	<div class="clearfix" style="width:100%;">
	<?php if (!empty($newestdata)): ?>
		<div id="imgframe" class="clearfix" style="float:left;width:880px;;">
			<a class="jqzoom" rel="gall" href=<?php echo $pic_url;?> target="_blank" title="观看放大图片窗口，右键保存">
				<img src=<?php echo $pic_url; ?> class="car" style="height:330px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left; width:900px; border-top:1px solid #eee;border-left:1px solid #eee; border-right: 1px solid #888; border-bottom: 1px solid #888;background-color:#fafafa;">
			<div style="float:left;width:240px">
				<table width="100%" cellspacing="1" cellpadding="1px" style="padding: 0px 0px;">
                    <tr><td><input type="hidden" id="id" name="id" value="<?php echo $newestdata->ID;?>" /></td></tr>
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="color:white;background-color:red">现场抓拍数据</td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">卡口名称：</td><td class="STYLE23"><label><?php echo $newestdata->WZDD;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车道编号：</td><td class="STYLE23"><label><?php echo $newestdata->CDBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车道方向：</td><td class="STYLE23"><label><?php echo $newestdata->FXBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">通过时间：</td><td class="STYLE23"><label><?php echo $newestdata->PASSTIME;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车牌号码：</td><td class="STYLE23"><label style="font-family:arial,宋体;font-weight:bold;font-size:14px;color:blue"><?php echo $newestdata->HPHM;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车牌颜色：</td><td class="STYLE23"><label><?php echo $newestdata->HPYS;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车辆速度：</td><td class="STYLE23"><label><?php echo $newestdata->CLSD;?></label></td></tr>
				</table>
			</div>
	  <?php else: ?>
	  		<div align="center">
	  			<span class="TITLE2">
					没有数据!
				</span>
			</div>
      <?php endif; ?>
			<div style="float:left;width:260px">
				<table width="100%" cellspacing="1" cellpadding="1px" style="padding: 0px 0px;" >
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="color:white;background-color:red">黑名单库数据</td></tr>
					<?php if (!empty($bmenu)): ?>
					<tr style="font-size: 12px;"><td class="STYLE23">车牌号码：</td><td class="STYLE23"><label style="font-family:arial,宋体;font-weight:bold;font-size:16px;color:blue"><?php echo $bmenu->HPHM;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车牌颜色：</td><td class="STYLE23"><label><?php echo $bmenu->HPYS;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车辆类型：</td><td class="STYLE23"><label><?php echo $bmenu->CLLX;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">布控原因：</td><td class="STYLE23"><label><?php echo $bmenu->BCXW;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">布控时间：</td><td class="STYLE23"><label><?php echo $bmenu->BCSJ;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">报警联系人：</td><td class="STYLE23"><label><?php echo $bmenu->LXMAN;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">联系电话：</td><td class="STYLE23"><label><?php echo $bmenu->LXDH;?></label></td></tr>
					<tr style="font-size: 12px;height: 48px"><td class="STYLE23">案件描述：</td><td class="STYLE23"><label><?php echo $bmenu->MEMO;?></label></td></tr>
					<?php else: ?>
				    <tr>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>无法定位布控信息!</h3>
					</div></td>
					</tr>
					<?php endif; ?>
				</table>
			</div>
			
			<div style="float:left;width:400px">
				<table width="100%" border="0" cellpadding="0" cellspacing="1" >
					<tr>
					<?php if (!empty($realdata)): ?>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">号牌</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">颜色</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">通过时间</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">监控点</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">方向</span></div></td>
						<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">案件性质</span></div></td>
					</tr>
					<?php foreach ($realdata as $row): ?>
					<tr>
						<td height="20" bgcolor="#FFFFFF" class="STYLE24"><div align="center"><?php if($row->HPHM == ''){$hphm = '无';}else{$hphm = $row->HPHM;} echo anchor('show/show_bj_showdetail/' . $row->ID, $hphm);?></div></td>
						<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->HPYS?></div></td>
						<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->PASSTIME?></div></td>
						<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->WZDD?></div></td>
						<td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo $row->FXBH?></div></td>
	                    <td height="20" bgcolor="#FFFFFF" class="STYLE23"><div align="center"><?php echo "布控";?></div></td>
					</tr>
					<?php endforeach; ?>
					<tr>
					<?php else: ?>
						<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
							<h3>没有数据!</h3>
						</div></td>
					<?php endif; ?>
					</tr>
				</table>
			</div>
		</div>
	</div>