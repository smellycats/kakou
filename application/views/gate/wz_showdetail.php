<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<link rel="stylesheet" href=<?php echo base_url() . "js/jqzoom_ev1.0.1/css/jqzoom.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>

</head>
<body>
<script type="text/javascript" src=<?php echo base_url() . "js/My97DatePicker/WdatePicker.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/jQuery1.7.1/jquery-1.7.1.min.js"; ?>  ></script>
<script type="text/javascript" src=<?php echo base_url() . "js/jqzoom_ev1.0.1/js/jqzoom.pack.1.0.1.js"; ?> ></script>
<script type="text/javascript">

$(document).ready(function(){
	 $("#mod").click(function(){
			$.ajax({
				type: "GET",
				url: <?php echo '"'.base_url() . "index.php/gate/car_check".'"'; ?>,
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
	if(confirm("ȷ��Ҫɾ����"))
	{
		window.location.href=<?php echo '"' . base_url() .  'index.php/' .'gate/del_showdetail/' . $cardetail->ID . '"'?>;
	}
	else
	{
		alert("�㰴��ȡ�����Ǿ��Ƿ���.");
	}
}

function loadData(){
	if(confirm("ȷ��Ҫɾ����"))
	{
		window.location.href=<?php echo '"' . base_url() .  'index.php/' .'gate/del_showdetail/' . $cardetail->ID . '"'?>;
	}
	else
	{
		alert("�㰴��ȡ�����Ǿ��Ƿ���.");
	}

}

function loadDataP(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/gate/wz_showdetail/?type_alias=' . $type_alias . "&record=" . $record . "&breakrule=" . $breakrule . "&color=" . $color . "&number=" . $number . "&carnum=" . $carnum . "&starttime=" . $starttime . "&endtime=" . $endtime . "&minspeed=" . $minspeed. "&maxspeed=" . $maxspeed . "&per_page=" . $per_page . '&rownum=' . ($rownum-1) . '"'?>;
}

function loadDataN(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/gate/wz_showdetail/?type_alias=' . $type_alias . "&record=" . $record . "&breakrule=" . $breakrule . "&color=" . $color . "&number=" . $number . "&carnum=" . $carnum . "&starttime=" . $starttime . "&endtime=" . $endtime . "&minspeed=" . $minspeed. "&maxspeed=" . $maxspeed . "&per_page=" . $per_page . '&rownum=' . ($rownum+1) . '"'?>;
}

function comeback(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/gate/wzquery_ok/?type_alias=' . $type_alias . "&record=" . $record . "&breakrule=" . $breakrule . "&color=" . $color . "&number=" . $number . "&carnum=" . $carnum . "&starttime=" . $starttime . "&endtime=" . $endtime . "&minspeed=" . $minspeed. "&maxspeed=" . $maxspeed . "&per_page=" . $per_page . '"'?>;
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;Υ�³���ͨ�м�¼</span></td>
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
	<div class="clearfix" style="width:100%;">
		<div id="imgframe" class="clearfix" style="float:left;width:880px;">
			<a class="jqzoom" rel="gall" href=<?php echo $pic_url; ?> target="_blank" title="�ۿ��Ŵ�ͼƬ���ڣ��Ҽ�����">
				<img src=<?php echo $pic_url; ?> class="car" style="height:330px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left; width:800px; border-top:1px solid #eee;border-left:1px solid #eee; border-right: 1px solid #888; border-bottom: 1px solid #888;background-color:#fafafa;">
			<div style="float:left;width:300px;">
				<table width="100%" cellspacing="0" cellpadding="1px" style="padding: 0px 0px;">
                    <tr><td><input type="hidden" id="id" name="id" value="<?php echo $cardetail->ID;?>" /></td></tr>
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="font-weight:bold;color:white;background-color:#551200">Υ�³�����ϸ��Ϣ</td></tr>
					<tr style="font-size: 12px;"><td>��صص㣺</td><td><label><?php echo $cardetail->WZDD;?></label></td></tr>
					<tr style="font-size: 12px;"><td>������ţ�</td><td><label><?php echo $cardetail->CDBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td>��������</td><td><label><?php echo $cardetail->FXBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td>ͨ��ʱ�䣺</td><td><label><?php echo $cardetail->PASSTIME;?></label></td></tr>
					<tr style="font-size: 12px;"><td>���ƺ��룺</td>
					<td><input id="carnum" name="carnum" value="<?php echo $cardetail->HPHM;?>" style="font-weight:bold;font-size:14px;color:blue;width:80px" /><?php echo form_error('carnum'); ?></td>
					</tr>
					<tr style="font-size: 12px;"><td>������ɫ��</td>
						<td>
						    <select name="color" id="color">
	                        <?php foreach ($option_color as $row): ?>
	                        <option value="<?php echo "$row"; ?>" <?php if ($cardetail->HPYS == $row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                        <?php endforeach; ?>
						    </select>
						</td>
					</tr>
					<tr style="font-size: 12px;"><td>�����ٶȣ�</td><td><label><?php echo $cardetail->CLSD;?></label></td></tr>
					<tr style="font-size: 12px;"><td>����ֵ��</td><td><label><?php echo $cardetail->CLXS;?></label></td></tr>
					
					<tr>
						<td style="font-size: 12px;">Υ�����ͣ�</td>
						<td>
							<select name="breakrule" id="breakrule" style="width:120px">
	                        <?php foreach ($option_breakrule as $row): ?>
	                        <option value="<?php echo $row; ?>" 
	                          <?php 
						          if($cardetail->CLBJ=='O')
						          {$br = '����';}
						          elseif($cardetail->CLBJ=='N'){$br = '����';}
						          elseif($cardetail->JLLX=='2' || $cardetail->JLLX=='3'){$br = '�����';}
						          elseif($cardetail->JLLX=='4'){$br = '����������ʻ';}
						          if($br == $row){echo " selected";}
	                          ?>><?php echo "$row"; ?></option>
	                        <?php endforeach; ?>
							</select>
						</td>
					</tr>
					
					<tr  >
						<td style="font-size: 12px;">�������ࣺ</td>
						<td>
						<select name="cartype" id="cartype" style="width:120px">
                        <?php foreach ($option_cartype as $id=>$row): ?>
                        <option value="<?php echo $id; ?>" <?php if($cardetail->HPYS == '����' AND $id == '1'){echo 'selected';}elseif($cardetail->HPYS == '����' AND $id == '2'){echo 'selected';}?>><?php echo $row; ?></option>
                        <?php endforeach; ?>
						</select>
						</td>
					</tr>
					<tr style="font-size: 12px;"><td>��¼״̬: </td><td><input style="border-width: 0" type="text" id="cCheck" readonly="readonly" <?php if($cardetail->HDGG == 'T'){ echo 'value="�Ѻ˶�"';}?> ></input></td></tr>
				</table>
			</div>

			<div style="float:left;width:480px">
				<table align="center" border="0" cellspacing="0" cellpadding="6" >
					<tr>
						<td><input type="submit" name="mod" id="mod" value="�˶�" /></td>
					    <td><input type=<?php if($role_id == '1'){echo '"button"';}else {echo '"hidden"';}?> name="del" id="del" value="ɾ��"  onclick="confirmDel()"/></td>
					</tr>
					<tr>
						<td><input type="button" name="prev" id="prev" value="��һ��"  <?php if($rownum == 1){echo 'disabled="disabled";';}?>onclick="loadDataP()" /></td>
						<td><input type="button" name="next" id="next" value="��һ��"  <?php if($rownum == $this->session->userdata('total_rows')){echo 'disabled="disabled";';}?>onclick="loadDataN()" /></td>
						<td><input type="button" name="back" id="back" value="����"  onclick="comeback()" /></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<input type="hidden" name="rid" id="rid" value="" />
</body>
</html>
