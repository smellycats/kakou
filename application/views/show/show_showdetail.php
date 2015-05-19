<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<link rel="stylesheet" href=<?php echo base_url() . "js/jqzoom_ev1.0.1/css/jqzoom.css"; ?> type="text/css" />
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
	 $("#mod").click(function(){
			$.ajax({
				type: "GET",
				url: <?php echo '"'.base_url() . "index.php/show/car_check".'"'; ?>,
				data: { id:<?php echo '"'.$cardetail->ID.'"';?>, carnum: $("#carnum").val(), color: $("#color option:selected").text() },
				success:function(data, st){
				$("#cCheck").val(data);
				}
			  });
	 });
	});

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
		window.location.href=<?php echo '"' . base_url() .  'index.php/show/del_show_showdetail/' . $cardetail->ID . '"'?>;
	}
	else
	{
		alert("你按了取消，那就是返回.");
	}
	window.history.back(-1);
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

	<div class="clearfix" style="width:860px;">
		<div id="imgframe" class="clearfix" style="float:left;width:880px;">
			<a class="jqzoom" rel="gall" href=<?php echo $pic_url; ?> target="_blank" title="观看放大图片窗口，右键保存">
				<img src=<?php echo $pic_url; ?> class="car" style="height:330px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left; width: 800px; border-top:1px solid #eee;border-left:1px solid #eee; border-right: 1px solid #888; border-bottom: 1px solid #888;background-color:#fafafa;">
			<div style="float:left;width:300px;">
				<table width="100%" cellspacing="0" cellpadding="1px" style="padding: 0px 0px; background-color:#fafafa">
                    <tr><td><input type="hidden" id="id" name="id" value="<?php echo $cardetail->ID;?>" /></td></tr>
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="font-weight:bold;color:white;background-color:blue">车辆详细信息</td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">监控地点：</td><td class="STYLE23"><label><?php echo $cardetail->WZDD;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车道编号：</td><td class="STYLE23"><label><?php echo $cardetail->CDBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车道方向：</td><td class="STYLE23"><label><?php echo $cardetail->FXBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">通过时间：</td><td class="STYLE23"><label><?php echo $cardetail->PASSTIME;?></label></td></tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车牌号码：</td>
					<td><input id="carnum" name="carnum" value="<?php echo $cardetail->HPHM;?>" class="STYLE24" /><?php echo form_error('carnum'); ?></td>
					</tr>
					<tr style="font-size: 12px;"><td class="STYLE23">车牌颜色：</td>
						<td>
						    <select name="color" id="color">
	                        <?php foreach ($option_color as $row): ?>
	                        <option value="<?php echo "$row"; ?>" <?php if ($cardetail->HPYS == $row){echo " selected";} ?>><?php echo $row; ?></option>
	                        <?php endforeach; ?>
						    </select>
						</td>
					</tr>
					<tr style="display:none;"><td>车辆速度：</td><td>&nbsp;</td></tr>
					<tr style="display:none;"><td>限速值：</td><td>&nbsp;</td></tr>

					<tr>
						<td style="font-size: 12px;">号牌种类：</td>
						<td>
						<select name="cartype" id="cartype" style="width:140px">
                        <?php foreach ($option_cartype as $id=>$row): ?>
                        <option value="<?php echo $id; ?>" <?php if($cardetail->HPYS == '黄牌' AND $id == '1'){echo 'selected';}elseif($cardetail->HPYS == '蓝牌' AND $id == '2'){echo 'selected';}elseif($cardetail->HPYS == '白牌' AND $id == '23'){echo 'selected';}elseif($cardetail->HPYS == '黑牌' AND $id == '2'){echo 'selected';}?>><?php echo "$row"; ?></option>
                        <?php endforeach; ?>
						</select>
						</td>
					</tr>
					<tr style="font-size: 12px;"><td>记录状态: </td><td><input style="border-width: 0" type="text" id="cCheck" readonly="readonly" <?php if($cardetail->HDGG == 'T'){ echo 'value="已核对"';}?> ></input></td></tr>
				</table>
			</div>

			<div style="float:left;width:480px; ">
				<table align="center" border="0" cellspacing="0" cellpadding="6" style="padding: 0px 0px;" >
					<tr>
	                    <td><input type=<?php if($check_right == '1'){echo '"button"';}else {echo '"hidden"';}?> name="mod" id="mod" value="核对"  /></td>
						<td><input type=<?php if($role_id == '1'){echo '"button"';}else {echo '"hidden"';}?> name="del" id="del" value="删除" onclick="confirmDel();" /></td>
					</tr>
					<tr><!--
						<td><input type="button" name="prev" id="prev" value="上一条"  <?php if($rownum == 1){echo 'disabled="disabled";';}?>onclick="loadDataP()" /></td>
						<td><input type="button" name="next" id="next" value="下一条"  <?php if($rownum == $this->session->userdata('total_rows')){echo 'disabled="disabled";';}?>onclick="loadDataN()" /></td>
						--><td><input type="button" name="back" id="back" value="返回"  onclick="javascript:history.back();" /></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<input type="hidden" name="rid" id="rid" value="" />

</body>
</html>
