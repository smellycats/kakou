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
<script type="text/javascript" src=<?php echo base_url() . "js/jqzoom_ev1.0.1/js/jquery-1.3.2.min.js"; ?>  ></script>
<script type="text/javascript" src=<?php echo base_url() . "js/jqzoom_ev1.0.1/js/jqzoom.pack.1.0.1.js"; ?> ></script>
<script type="text/javascript">

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
            position:'bottom'  
            //...MORE OPTIONS  
    };  
    $('.jqzoom').jqzoom(options);  
}); 

function confirmDel(){
	if(confirm("确定要删除？"))
	{
		window.location.href=<?php echo '"' . base_url() .  'index.php/' .'show/del_show_bj_showdetail/' . $cardetail->ID . '"'?>;
	}
	else
	{
		alert("你按了取消，那就是返回.");
	}
	window.history.back(-1);
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
												<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;报警车辆通行记录</span></td>
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

	<div class="clearfix" style="width:860px;">
		<div id="imgframe" class="clearfix" style="float:left;width:880px;">
			<a class="jqzoom" rel="gall" href=<?php echo $pic_url;?> target="_blank" title="观看放大图片窗口，右键保存">
				<img src=<?php echo $pic_url; ?> class="car" style="height:330px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left; width: 900px; border-top:1px solid #eee;border-left:1px solid #eee; border-right: 1px solid #888; border-bottom: 1px solid #888;background-color:#fafafa;">
			<div style="float:left;width: 240px">
				<table width="100%" cellspacing="0" cellpadding="1px" style="padding: 0px 0px;">
                    <tr><td><input type="hidden" id="id" name="id" value="<?php echo $cardetail->ID;?>" /></td></tr>
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="font-weight:bold;font-family:arial,宋体;color:white;background-color:red">现场抓拍数据</td></tr>
					<tr style="font-size: 12px;"><td>卡口名称：</td><td><label><?php echo $cardetail->WZDD;?></label></td></tr>
					<tr style="font-size: 12px;"><td>车道编号：</td><td><label><?php echo $cardetail->CDBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td>车道方向：</td><td><label><?php echo $cardetail->FXBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td>通过时间：</td><td><label><?php echo $cardetail->PASSTIME;?></label></td></tr>
					<tr style="font-size: 12px;"><td>车牌号码：</td><td><input id="carnum" name="carnum" style="font-family:arial,宋体;font-weight:bold;font-size:14px;color:blue" value="<?php echo $cardetail->HPHM;?>" /><?php echo form_error('carnum'); ?></td></tr>
					<tr style="font-size: 12px;"><td>车牌颜色：</td><td>
                    	<select name="color" id="color">
                        <?php foreach ($option_color as $row): ?>
                        <option value="<?php echo "$row"; ?>" <?php if ($cardetail->HPYS == $row){echo " selected";} ?>><?php echo "$row"; ?></option>
                        <?php endforeach; ?>
					    </select>
                    </td></tr>
					<tr style="font-size: 12px;"><td>车辆速度：</td><td><label><?php echo $cardetail->CLSD;?></label></td></tr>
					<tr style="font-size: 12px;"><td>记录状态: </td><td><label><?php if($cardetail->HDGG == 'T'){ echo "已核对";}?></label></td></tr>
				</table>
			</div>
			<div style="float:left;width:260px">
				<table width="100%" cellspacing="0" cellpadding="1px" style="padding: 0px 0px;">
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="font-weight:bold;font-family:arial,宋体;color:white;background-color:red">黑名单库数据</td></tr>
				<?php if (!empty($bmenu)): ?>
					<tr style="font-size: 12px;"><td>车牌号码：</td><td><label  style="font-family:arial,宋体;font-weight:bold;font-size:14px;color:blue"><?php echo $bmenu->HPHM;?></label></td></tr>
					<tr style="font-size: 12px;"><td>车牌颜色：</td><td><label><?php echo $bmenu->HPYS;?></label></td></tr>
					<tr style="font-size: 12px;"><td>车辆类型：</td><td><label><?php echo $bmenu->CLLX;?></label></td></tr>
					<tr style="font-size: 12px;"><td>布控原因：</td><td><label><?php echo $bmenu->BCXW;?></label></td></tr>
					<tr style="font-size: 12px;"><td>布控时间：</td><td><label><?php echo $bmenu->BCSJ;?></label></td></tr>
					<tr style="font-size: 12px;"><td>报警联系人：</td><td><label><?php echo $bmenu->LXMAN;?></label></td></tr>
					<tr style="font-size: 12px;"><td>联系电话：</td><td><label><?php echo $bmenu->LXDH;?></label></td></tr>
					<tr style="font-size: 12px;height: 48px"><td>案件描述：</td><td><label><?php echo $bmenu->MEMO;?></label></td></tr>
				<?php else: ?>
				    <tr>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>无法定位布控信息!</h3>
					</div></td>
					</tr>
				<?php endif; ?>
				</table>
			</div>
					
			<div style="float:left;width:260px">
				<table align="center" border="0" cellspacing="0" cellpadding="6" >
					<tr>
	                    <td><input type=<?php if($check_right == '1'){echo '"button"';}else {echo '"hidden"';}?> name="mod" id="mod" value="核对"  /></td>
						<td><input type=<?php if($role_id == '1'){echo '"button"';}else {echo '"hidden"';}?> name="del" id="del" value="删除" onclick="confirmDel();" /></td>
					</tr>
					<tr>
						<td><input type="button" name="back" id="back" value="返回" style="width:60px;padding-top:2px;" onclick="javascript:history.back();" /></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<input type="hidden" name="rid" id="rid" value="" />

</body>
</html>
