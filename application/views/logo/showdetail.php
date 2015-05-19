<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<link rel="stylesheet" href=<?php echo base_url() . "js/jqzoom_ev1.0.1/css/jqzoom.css"; ?> type="text/css" />
<title>无标题文档</title>

</head>
<body>
<script type="text/javascript" src=<?php echo base_url() . "js/My97DatePicker/WdatePicker.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/jQuery1.7.1/jquery-1.7.1.min.js"; ?>  ></script>
<script type="text/javascript" src=<?php echo base_url() . "js/jqzoom_ev1.0.1/js/jqzoom.pack.1.0.1.js"; ?> ></script>
<script type="text/javascript"><!--



$(document).ready(function(){  
    var options = {  
            zoomType: 'standard',  
            lens:true,  
            preloadImages: false,  
            alwaysOn:false,  
            zoomWidth: 260,  
            zoomHeight: 200,  
            xOffset:600,  
            yOffset:5,
            position:'right'  
            //...MORE OPTIONS  
    };  
    $('.jqzoom').jqzoom(options);  
}); 


function loadDataP(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/logo/showdetail/'. ($current_id-1) . '"'?>;
}

function loadDataN(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/logo/showdetail/'. ($current_id+1) . '"'?>;
}

function comeback(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/logo/lgquery_ok/' .  '"'?>;
}
--></script>

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
												<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;车辆通行记录</span></td>
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
	
	</table>

	<div class="clearfix" style="border:0px;float:left;width:100%;">
		<div id="imgframe" class="clearfix" style="float:left;width:70%;">
			<a class="jqzoom" rel="gall" href=<?php echo $pic_url; ?> target="_blank" title="观看放大图片窗口，右键保存">
				<img src=<?php echo $pic_url; ?> class="car" style="height:330px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left; width:900px; border-top:1px solid #eee;border-left:1px solid #eee; border-right: 1px solid #888; border-bottom: 1px solid #888;background-color:#fafafa;">
			<div style="float:left;width:300px;">
				<table width="100%" cellspacing="0" cellpadding="1px" style="padding: 0px 0px; background-color:#fafafa">
                    <tr style="font-size: 18px;"><td colspan="2" align="center" style="font-weight:bold;color:white;background-color:blue">车辆详细信息</td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">监控地点：</td><td class="BLACK14"><label><?php echo $places[$carinfo->cltx_place];?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车道编号：</td><td class="BLACK14"><label><?php echo $carinfo->cltx_lane;?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车道方向：</td><td class="BLACK14"><label><?php echo $direction[$carinfo->cltx_dire];?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">通过时间：</td><td class="BLACK14"><label><?php echo $carinfo->passtime;?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车牌号码：</td><td class="BLACK14"><label><?php echo $carinfo->cltx_hphm;?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车牌颜色：</td><td class="BLACK14"><label><?php echo $platecolor[$carinfo->cltx_color];?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车辆标志：</td><td class="BLACK14"><label><?php echo $carinfo->name;?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">品牌类型：</td><td class="BLACK14"><label><?php echo $carinfo->clpp;?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车辆类型：</td><td class="BLACK14"><label><?php echo $carinfo->cllx.$cllx[$carinfo->cllx];?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车身颜色：</td><td class="BLACK14"><label><?php echo $csys[$carinfo->csys];?></label></td></tr>
				</table>
			</div>
			
			<div style="float:left;width:300px;">
				<table width="100%" cellspacing="0" cellpadding="1px" style="padding: 0px 0px; background-color:#fafafa">
                    <tr style="font-size: 18px;"><td colspan="2" align="center" style="font-weight:bold;color:white;background-color:green">车管所信息</td></tr>
                    <?php if (!empty($vehicle_gd)): ?>
					<tr style="font-size: 14px;"><td class="BLACK14">所有人：    </td><td class="BLACK14"><label><?php echo $vehicle_gd->syr;?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">号牌种类：</td><td class="BLACK14"><label><?php echo $platetype[$vehicle_gd->hpzl];?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车辆标志：</td><td class="BLACK14"><label><?php echo $vehicle_gd->clpp1;?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">品牌类型：</td><td class="BLACK14"><label><?php echo $vehicle_gd->clxh;?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车辆类型：</td><td class="BLACK14"><label><?php echo $vehicle_gd->cllx.$cllx[$vehicle_gd->cllx];?></label></td></tr>
					<tr style="font-size: 14px;"><td class="BLACK14">车身颜色：</td><td class="BLACK14"><label><?php echo $csys[$vehicle_gd->csys];?></label></td></tr>
					<?php else: ?>
					<tr><td><span class="TITLE3"><?php echo '没有相关车辆信息';?></span></td></tr>
					<?php endif;?>
				</table>
			</div>

			<div style="float:left;width:300px; ">
				<table align="center" border="0" cellspacing="0" cellpadding="6" style="padding: 0px 0px;" >
					<tr>
						<td><input type="button" name="prev" id="prev" value="上一条"  <?php if($current_id <= 1){echo 'disabled="disabled";';}?>onclick="loadDataP()" /></td>
						<td><input type="button" name="next" id="next" value="下一条"  <?php if($current_id >= $this->session->userdata('total_rows')){echo 'disabled="disabled";';}?>onclick="loadDataN()" /></td>
						<td><input type="button" name="back" id="back" value="返回"  onclick="comeback()" /></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<input type="hidden" name="rid" id="rid" value="" />

</body>
</html>
