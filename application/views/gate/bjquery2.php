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
										<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;报警车辆查询</span></td>
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

	<div align="center">
		<form method="get" action="<?php echo site_url('gate/bjquery_ok'); ?>">
	    	<table cellpadding="2" cellspacing="0" class="bg9cf align-left" id="findbox-input-table">
		      <tr align="center">
		        <td height="18" colspan="7" style="font-size: 12px;"><span class="STYLE13">车辆查询条件设置</span></td>
	          </tr>
		      <tr>
		        <td style="width:70px;font-size: 12px;">监控点名称:</td>
	            <td>
	                <select name="type_alias">
	                <option value="all" <?php if ($sel_type_alias=='all'){echo " selected";} ?>>所有</option>
	                <?php foreach ($okkval as $id=>$kakou): ?>
	                <option value=<?php echo '"'.$kakou.'"'; ?> <?php if ($sel_type_alias==$kakou){echo " selected";} ?>><?php echo $openkakou[$id]; ?></option>
	                <?php endforeach; ?>
	                </select>
				</td>
	            <td style="width:70px;font-size: 12px;">处理状态:</td>
				<td style="width:120px">
	                <select name="dispose">
	                <option value="all" <?php if ($sel_dispose=='all'){echo " selected";} ?>>所有</option>
	                <?php foreach ($dispose as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_dispose==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
	           </td>
	          </tr>
		      <tr>
		        <td style="font-size: 12px;">车牌号码:</td>
	            <td>
	                <select name="number">
	                <?php foreach ($number as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_number==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
	              <input type="text" name="carnum" value="<?php echo $sel_carnum;?>" class="inp" style="width:125px;"/>
				</td>
				<td style="font-size: 12px;">车牌颜色:</td>
				<td style="width:120px">
	                <select name="color">
	                <option value="all" <?php if ($sel_color=='all'){echo " selected";} ?>>所有</option>
	                <?php foreach ($color as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_color==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
				</td>
				<td style="font-size: 12px;">报警类型:</td>
				<td style="width:120px">
	                <select name="alarmtype">
	                <option value="all" <?php if ($sel_alarmtype=='all'){echo " selected";} ?>>所有</option>
	                <?php foreach ($alarmtype as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_alarmtype==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
				</td>
	           </tr>
		       <tr>
			        <td style="font-size: 12px;">时&nbsp;&nbsp;&nbsp;&nbsp;间:</td>
		            <td colspan="6">
		                <input id="starttime" type="text" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_starttime;?>" style="width:150px"/>
		                <label style="font-size: 12px;">到</label>
		                <input id="endtime" type="text" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_endtime;?>" style="width:150px"/>
					</td>
					<td>
						<input class="BUTBLACK" type="submit" name="query_find" id="btnsubmit" value="查询" title="查询" style="width:50px"/>
					</td>
				</tr>
			    <tr align="center" >
			    	<td style="font-size: 12px;" colspan="7">
			    	<font class="BLUE">提示:车牌号码支持模糊查询,不确定的字符(包括汉字,数字)请用"?"代替;多个连续的不确定位,可用一个"*"代替.<br />汉字栏选择"-"可单独查询无识别结果的记录。</font>
			    	</td>
			    </tr>
	    	</table>
	    </form>
	</div>
	
	<div align="center">
		<form method="post" action="<?php echo site_url('gate/bj_showdetail'); ?>">
		  	<?php if (!empty($car)): ?>
		    <div style="width:95%">
		        <div style="float:left"><span class="BLACK">记录数 <?php echo $total_rows; ?>条     共<?php echo $total_pages; ?> 页</span></div>
		        <div style="float:right"><span class="BLACK"><?php echo anchor('export/bj_exportexcel/?type_alias='. $sel_type_alias . '&dispose=' . $sel_dispose . '&alarmtype=' . $sel_alarmtype . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime , '【查询结果导出至Excel-最大前'. $xls_num . '条】'); ?></span></div>
		        <div style="float:right"><span class="BLACK"><?php echo anchor('export/get_imgs/?type_alias='. $sel_type_alias . '&dispose=' . $sel_dispose . '&alarmtype=' . $sel_alarmtype . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime , '【批量导出图片-最大前' . $img_num . '张】'); ?></span></div>	
			</div>
			<table width="95%" border="0" cellpadding="0" cellspacing="1" class="tab">
				<tr>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">序号</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">号牌号码</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">号牌颜色</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">通过时间</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">监控点名称</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">方向</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">车道</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">报警类型</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">处理状态</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">确认用户</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">操作</span></div></td>
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
						<?php if($row->CLBJ =='B')	{if($carnum[$row->HPHM] == ''){$STYLE="DARKRED";$CLBJ="布控";}else{$STYLE="GREEN";$CLBJ=$carnum[$row->HPHM];}}
					          #elseif($row->CLBJ=='L'){$CLBJ="布控";}
					          elseif($row->CLBJ=='T'){$STYLE="DARKRED";$CLBJ="套牌";}
					          elseif($row->CLBJ=='D'){$STYLE="DARKRED";$CLBJ="被盗抢";}
					          elseif($row->CLBJ=='S'){if($carnum[$row->HPHM] == ''){$STYLE="DARKRED";$CLBJ="便衣嫌疑";}else{$STYLE="GREEN";$CLBJ=$carnum[$row->HPHM];}}
					          #elseif($row->CLBJ=='O'){$CLBJ="超速";}   
					          else{echo '';}
					    ?>
					<td height="24" ><div align="center" class="<?php echo $STYLE;?>"><?php echo $CLBJ;?></div></td>
					<td height="24" ><div align="center" class="STYLE23">
					    <?php if($row->CFBM == '' || $row->CFBM == '01' || $row->CFBM=='警情未处理')
					          {echo "警情未处理";}
					          elseif($row->CFBM=='02'){echo "号牌号码识别错误";}
					          elseif($row->CFBM=='03'){echo "号牌颜色识别错误";}
					          elseif($row->CFBM=='04'){echo "图像不清";}
					          elseif($row->CFBM=='05'){echo "已下达";}
					          elseif($row->CFBM=='06'){echo "不下达";}
					          elseif($row->CFBM=='07'){echo "未截获";}
					          elseif($row->CFBM=='08'){echo "被盗抢车";}
					          elseif($row->CFBM=='09'){echo "查获套牌车";}
					          elseif($row->CFBM=='10'){echo "交通违法车";}
					          elseif($row->CFBM=='11'){echo "与黑名单数据不符";}
					          elseif($row->CFBM=='12'){echo "数据更新不及时";}        
					          else{echo '';}
					    ?>
					</div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->FKBM; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo anchor('gate/bj_showdetail/?type_alias=' . $sel_type_alias . "&dispose=" . $sel_dispose . "&alarmtype=" . $sel_alarmtype . "&color=" . $sel_color . "&number=" . $sel_number . "&carnum=" . $sel_carnum . "&starttime=" . $sel_starttime . "&endtime=" . $sel_endtime . "&per_page=" . $offset . '&rownum=' . $rownum, '查看'); ?></div></td>
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
