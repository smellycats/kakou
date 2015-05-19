<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<link rel="stylesheet" href=<?php echo base_url() . "js/jqzoom_ev1.0.1/css/jqzoom.css"; ?> type="text/css">
<title>无标题文档</title>
<style type="text/css">
<!--
body {
margin-left: 3px;
margin-top: 0px;
margin-right: 3px;
margin-bottom: 0px;
}
a{
text-decoration:none;
color: #344b50;
}
.STYLE1 { color: #e1e2e3; font-size: 12px; }
.STYLE1 a{ color:#fff; }
.STYLE6 {color: #000000; font-size: 12; }
.STYLE10 {color: #000000; font-size: 12px; }
.STYLE19 { color: #344b50; font-size: 12px; }
.STYLE21 { font-size: 12px; color: #3b6375; }
.STYLE22 { font-size: 12px; color: #295568; }
-->
</style>
</head>
<body>
<script type="text/javascript" src=<?php echo base_url() . "js/My97DatePicker/WdatePicker.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/jqzoom_ev1.0.1/js/jquery-1.3.2.min.js"; ?>  ></script>
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
            xOffset:5,  
            yOffset:230,
            position:'left'  
            //...MORE OPTIONS  
    };  
    $('.jqzoom').jqzoom(options);  
}); 

function confirmDel(){
	if(confirm("确定要删除？"))
	{
		window.location.href=<?php echo '"' . base_url() .  'index.php/' .'gate/del_showdetail/' . $cardetail->ID . '"'?>;
	}
	else
	{
		alert("你按了取消，那就是返回.");
	}
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
											<td width="94%" valign="bottom"><span class="STYLE1">&nbsp;通行记录</span></td>
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
<form method="post" action="<?php echo site_url('gate/edit_showdetail'); ?>">
	<div class="clearfix" style="width:860px;">
		<div id="imgframe" name="imgframe" class="clearfix" style="float:left;width:550px;height:430px;">
			<a class="jqzoom" rel="gall" href=<?php echo base_url() . $cardetail->QMTP . "/" . $cardetail->TJTP; ?> target="_blank" title="观看放大图片窗口，右键保存">
				<img src=<?php echo base_url() . $cardetail->QMTP . "/" . $cardetail->TJTP; ?> class="car" style="width:550px;height:430px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left; width: 230px; border-top:1px solid #eee;border-left:1px solid #eee; border-right: 1px solid #888; border-bottom: 1px solid #888;">
			<div style="float:left;">
				<table width="100%" cellspacing="1" cellpadding="3px" style="padding: 0px 0px; background-color:#cccccc">
                    <input type="hidden" id="id" name="id" value="<?php echo $cardetail->ID;?>" />
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="font-weight:bold;font-family:arial,宋体;color:white;background-color:gray">白名单车辆详细信息</td></tr>
					<tr bgcolor="#fafafa" style="font-size: 12px;"><td>监控点名称：</td><td name="kkmc"><label><?php echo $cardetail->WZDD;?></label></td></tr>
					<tr bgcolor="#fafafa" style="font-size: 12px;"><td>车道编号：</td><td name="cdbh"><label><?php echo $cardetail->CDBH;?></label></td></tr>
					<tr bgcolor="#fafafa" style="font-size: 12px;"><td>车道方向：</td><td name="fxbh"><label><?php echo $cardetail->FXBH;?></label></td></tr>
					<tr bgcolor="#fafafa" style="font-size: 12px;"><td>通过时间：</td><td name="jgsj"><label><?php echo $cardetail->PASSTIME;?></label></td></tr>
					<tr bgcolor="#fafafa" style="font-size: 12px;"><td>车牌号码：</td>
					<td><input id="carnum" name="carnum" value="<?php echo $cardetail->HPHM;?>" class="STYLE24" /><?php echo form_error('carnum'); ?></td>
					</tr>
					<tr bgcolor="#fafafa" style="font-size: 12px;"><td>车牌颜色：</td>
					<td>
					    <SELECT name="color" id="color">
                        <?php foreach ($color as $row): ?>
                        <option value="<?php echo "$row"; ?>" <?php if ($cardetail->HPYS == $row){echo " selected";} ?>><?php echo "$row"; ?></option>
                        <?php endforeach; ?>
					    </SELECT>
					</td></tr>
					<tr bgcolor="#fafafa" name="clsd" style="display:none;"><td>车辆速度：</td><td name="v">&nbsp;</td></tr>
					<tr bgcolor="#fafafa" name="clxs" style="display:none;"><td>限速值：</td><td name="v">&nbsp;</td></tr>

					<tr bgcolor="#fafafa" style="font-size: 12px;"><td>记录状态: </td><td name="state"><label><?php if($cardetail->HDGG == 'T'){ echo "已核对";}?></label></td></tr>
				</table>
			</div>

			<div style="float:left;width:100%">
				<table border="0" cellspacing="0" cellpadding="6" >
				<tr bgcolor="#e6e6e6">
					<td><input type="submit" name="mod" id="mod" value="核对" style="width:60px;padding-top:2px;"></td><!--
					<td><div align="center" style="font-size: 14px; color: #3b6375;"><?php if($role_id == '1'){echo anchor('gate/del_showdetail/'.$cardetail->ID,'删除');}else{echo '';}?></div></td>
				--><td><input type=<?php if($role_id == '1'){echo '"button"';}else {echo '"hidden"';}?> name="del" id="del" value="删除" style="width:60px;padding-top:2px" onclick="confirmDel()"></td>
				</tr>
				<tr bgcolor="#e6e6e6">
					<td><input type="button" name="prev" id="prev" value="<上一条" style="width:60px;padding-top:2px;display:none;"/></td>
					<td><input type="button" name="next" id="next" value="下一条>" style="width:60px;padding-top:2px;display:none;"/></td>
					<td><input type="button" name="back" id="back" value="返回" style="width:60px;padding-top:2px;" onclick="javascript:history.back();"></td>
				</tr>
				</table>
			</div>
		</div>
	</div>
	<input type="hidden" name="rid" id="rid" value="" />
	</form>
</body>
</html>
