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
										<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;缩略车辆查询</span></td>
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
            <td style="width:70px;font-size: 12px;">车&nbsp;&nbsp;&nbsp;&nbsp;道:</td>
			<td>
                <select name="lane">
                <option value="all" <?php if ($sel_lane=='all'){echo " selected";} ?>>所有</option>
                <?php foreach ($lane as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_lane==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
           </td>
			<td style="width:70px;font-size: 12px;">方&nbsp;&nbsp;&nbsp;&nbsp;向:</td>
			<td >
                <select name="direction">
                <option value="all" <?php if ($sel_direction=='all'){echo " selected";} ?>>所有</option>
                <?php foreach ($direction as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_direction==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
			 </td>
			<td style="font-size: 12px;">车牌颜色:</td>
			<td>
                <select name="color">
                <option value="all" <?php if ($sel_color=='all'){echo " selected";} ?>>所有</option>
                <?php foreach ($color as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_color==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
			</td>	
          </tr>
	      <tr>
	        <td style="font-size: 12px;">时&nbsp;&nbsp;&nbsp;&nbsp;间:</td>
            <td colspan="3">
                <input id="starttime" type="text" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_starttime;?>" style="width:150px"/>
                <label style="font-size: 12px;">到</label>
                <input id="endtime" type="text" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_endtime;?>" style="width:150px"/>
            </td>
	        <td style="font-size: 12px;">车牌号码:</td>
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
	        <td style="font-size: 12px;">特定号牌:</td>
            <td colspan="6">
			  <input type="text" name="spcarnum" value="<?php echo $sel_spcarnum;?>" style="height:20px;width:430px"  /><span class="BLUE" >支持多个号牌,逗号分隔</span>
			</td>
			<td align="right">
			  <input class="BUTBLACK" type="submit" name="query_find" id="btnsubmit" value="查询" title="查询" style="width:50px"/>
			</td>
		  </tr>
	    <tr align="center">
	    	<td colspan="7">
	    		<font class="BLUE">提示:车牌号码支持模糊查询,不确定的字符(包括汉字,数字)请用"?"代替;多个连续的不确定位,可用一个"*"代替.<br />汉字栏选择"-"可单独查询无识别结果的记录。</font>
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
		        <div style="float:left"><span class="BLACK">记录数 <?php echo $total_rows; ?>条     共<?php echo $total_pages; ?> 页</span></div>
		        <div style="float:right"><span class="BLACK"><?php echo anchor('export/exportexcel/?type_alias='. $sel_type_alias . '&lane=' . $sel_lane . '&direction=' . $sel_direction . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime . '&spcarnum=' . $sel_spcarnum , '【查询结果导出至Excel-最大前'. $xls_num . '条】'); ?></span></div>
		        <div style="float:right"><span class="BLACK"><?php echo anchor('export/get_imgs/?type_alias='. $sel_type_alias . '&lane=' . $sel_lane . '&direction=' . $sel_direction . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime . '&spcarnum=' . $sel_spcarnum , '【批量导出图片-最大前'. $img_num . '条】'); ?></span></div>
		    </div>
			<table width="95%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
				<?php $picnum = 0;?>
				<?php $count = 0;?>
				<?php foreach ($car as $row): ?>
				<?php if($picnum % 4 === 0){echo "<tr>";}?>
				<?php $rownum = $offset + $count + 1;?>
				    <td>
			            <a href=<?php echo '"' . base_url() . 'index.php/gate/slshowdetail/?type_alias=' . $sel_type_alias . '&lane=' . $sel_lane . '&direction=' . $sel_direction . '&color=' . $sel_color . '&number=' . $sel_number . '&carnum=' . $sel_carnum . '&spcarnum=' .'&starttime=' . $sel_starttime . '&endtime=' . $sel_endtime . $sel_spcarnum . '&per_page=' . $offset . '&rownum=' . $rownum . '"' ; ?>> 
				            <img src=<?php echo 'http://'.$imgpath[$row->TPWZ].'/'. $row->QMTP . "/" . $row->TJTP;;?> style="width:224px;height:168px;border:1px solid #b0b0b0" alt="号牌:<?php echo $row->HPHM;?>&#10时间:<?php echo $row->PASSTIME;?>&#10卡口:<?php echo $row->WZDD;?>&#10方向:<?php echo $row->FXBH;?>"/>
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
