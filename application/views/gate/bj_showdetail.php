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
<script type="text/javascript" src=<?php echo base_url() . "js/My97DatePicker/WdatePicker.js"; ?> ></script>
<script type="text/javascript" src=<?php echo base_url() . "js/jQuery1.7.1/jquery-1.7.1.min.js"; ?> ></script>
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
	 $("#handle").click(function(){
			$.ajax({
				type: "GET",
				url: <?php echo '"'.base_url() . "index.php/gate/handle_info".'"'; ?>,
				data: { id:<?php echo '"'.$cardetail->ID.'"';?>, jyqk: $("#jyqk").val(), dispose: $("#dispose option:selected").text(),cfsj: $("#handle_time").val(), user: $("#handle_user").val()},
				dataType: "json",
				success:function(data){
				alert(data.info);
				//$("#info").text("123");
				//$("#handle_time").val("time");
				//$("#handle_user").val("fire");
				$("#info").html(data.meg);
				$("#handle_time").val(data.cfsj);
				$("#handle_user").val(data.user);
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

function changedisplay(obj, id){
	if (obj.value=='���´�')
	{
		document.getElementById(id).style.display='block';
	} else {
		document.getElementById(id).style.display='none';
	}
	return true;
}

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

function loadDataP(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/gate/bj_showdetail/?type_alias=' . $type_alias . "&dispose=" . $dispose . "&alarmtype=" . $alarmtype . "&color=" . $color . "&number=" . $number . "&carnum=" . $carnum . "&starttime=" . $starttime . "&endtime=" . $endtime . "&per_page=" . $per_page .  '&rownum=' . ($rownum-1) . '"'?>;
}

function loadDataN(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/gate/bj_showdetail/?type_alias=' . $type_alias . "&dispose=" . $dispose . "&alarmtype=" . $alarmtype . "&color=" . $color . "&number=" . $number . "&carnum=" . $carnum . "&starttime=" . $starttime . "&endtime=" . $endtime . "&per_page=" . $per_page .  '&rownum=' . ($rownum+1) . '"'?>;
}

function comeback(){
	window.location.href=<?php echo '"' . base_url() .  'index.php/gate/bjquery_ok/?type_alias=' . $type_alias . "&dispose=" . $dispose . "&alarmtype=" . $alarmtype . "&color=" . $color . "&number=" . $number . "&carnum=" . $carnum . "&starttime=" . $starttime . "&endtime=" . $endtime . "&per_page=" . $per_page . '&rownum=' . $rownum . '"'?>;
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
												<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;��������ͨ�м�¼</span></td>
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
		<div id="imgframe" style="float:left;width:880px;">
			<a class="jqzoom" rel="gall" href=<?php echo $pic_url; ?> target="_blank" title="�ۿ��Ŵ�ͼƬ���ڣ��Ҽ�����">
				<img src=<?php echo $pic_url; ?> class="car" style="height:330px;border:0px solid #b0b0b0" />
			</a>
		</div>
		<div style="float:left; width:900px; border-top:1px solid #eee;border-left:1px solid #eee; border-right: 1px solid #888; border-bottom: 1px solid #888;background-color:#fafafa;">
			<div style="float:left;width: 300px">
				<table width="100%" cellspacing="0" cellpadding="1px" style="padding: 0px 0px;">
                    <tr><td><input type="hidden" id="id" name="id" value="<?php echo $cardetail->ID;?>" /></td></tr>
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="font-weight:bold;color:white;background-color:red">�ֳ�ץ������</td></tr>
					<tr style="font-size: 12px;"><td>��صص㣺</td><td><label><?php echo $cardetail->WZDD;?></label></td></tr>
					<tr style="font-size: 12px;"><td>������ţ�</td><td><label><?php echo $cardetail->CDBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td>��������</td><td><label><?php echo $cardetail->FXBH;?></label></td></tr>
					<tr style="font-size: 12px;"><td>ͨ��ʱ�䣺</td><td><label><?php echo $cardetail->PASSTIME;?></label></td></tr>
					<tr style="font-size: 12px;"><td>���ƺ��룺</td><td><input id="carnum" name="carnum" style="font-weight:bold;font-size:14px;color:blue" value="<?php echo $cardetail->HPHM;?>" /><?php echo form_error('carnum'); ?></td></tr>
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
					<tr style="font-size: 12px;"><td>��¼״̬: </td><td><input style="border-width: 0" type="text" id="cCheck" readonly="readonly" <?php if($cardetail->HDGG == 'T'){ echo 'value="�Ѻ˶�"';}?> ></input></td></tr>
				</table>
			</div>
			<div style="border:0px;float:left;width:300px;">
				<table border="0" cellspacing="0" cellpadding="1px" width="100%" >
					<tr>
						<td colspan="2" align="left" style="font-weight:bold;color:white;background-color:blue">
						<div>
							<div style="margin-top:4px;float:left">��������Ϣ</div>
							<div style="float:right"><input type="submit" name="handle" id="handle" value="����"/></div>
						</div>
						</td>
					</tr>
					<tr>
						<td style="width:80px;">����״����</td>
						<td>
			                <select id="dispose" onchange="changedisplay(this,'jyqk_row');">
			                <?php foreach ($option_dispose as $id=>$row): ?>
			                <option value="<?php echo $row; ?>" <?php if($cardetail->CFBM == $row){echo " selected";} ?>><?php echo $row; ?></option>
			                <?php endforeach; ?>
			                </select>
			            </td>
					</tr>
			     	<tr>
			        	<td style="width:60px;">��Ҫ�����<span style="color:blue">������.</span></td>
			        	<td colspan="3" id="jyqk_row" style="display:<?php if($cardetail->CFBM == "���´�"){echo "block";}else{echo "none";}?>"><textarea id="jyqk" name="jyqk" style="width:100%;heigh: 800px" ><?php echo $cardetail->MEMO; ?></textarea><label class="RED" id="info"></label></td>
			        </tr>
					<tr><td>����ʱ�䣺</td><td><input style="border-width: 0" type="text" id="handle_time" readonly="readonly" value="<?php echo $cardetail->CFSJ; ?>"/></td></tr>
					<tr><td>������Ա��</td><td><input style="border-width: 0" type="text" id="handle_user" readonly="readonly" value="<?php echo $cardetail->FKBM; ?>"/></td></tr>
				</table>
			</div>	
			<div style="float:left;width:300px">
				<table align="center" border="0" cellspacing="0" cellpadding="6px" >
					<tr>
						<td><input type="submit" name="mod" id="mod" value="�˶�" /></td>
						<td><input type=<?php if($role_id == '1'){echo '"button"';}else {echo '"hidden"';}?> name="del" id="del" value="ɾ��"  onclick="confirmDel()"/></td>
					</tr>
					<tr>
						<td><input type="button" name="prev" id="prev" value="��һ��"  <?php if($rownum == 1){echo 'disabled="disabled";';}?>onclick="loadDataP()"/></td>
						<td><input type="button" name="next" id="next" value="��һ��"  <?php if($rownum == $this->session->userdata('total_rows')){echo 'disabled="disabled";';}?>onclick="loadDataN()"/></td>
						<td><input type="button" name="back" id="back" value="����"  onclick="comeback();"/></td>
					</tr>
				</table>
			</div>
		</div>
			<div style="float:left;width:300px">
				<table width="100%" cellspacing="0" cellpadding="1px" style="padding: 0px 0px;">
                    <tr style="font-size: 14px;"><td colspan="2" align="center" style="font-weight:bold;color:white;background-color:red">������������</td></tr>
				<?php if (!empty($bmenu)): ?>
					<tr style="font-size: 12px;"><td>���ƺ��룺</td><td><label  style="font-weight:bold;font-size:14px;color:blue;width:100px"><?php echo $bmenu->HPHM;?></label></td></tr>
					<tr style="font-size: 12px;"><td>������ɫ��</td><td><label><?php echo $bmenu->HPYS;?></label></td></tr>
					<tr style="font-size: 12px;"><td>�������ͣ�</td><td><label><?php echo $bmenu->CLLX;?></label></td></tr>
					<tr style="font-size: 12px;"><td>����ԭ��</td><td><label><?php echo $bmenu->BCXW;?></label></td></tr>
					<tr style="font-size: 12px;"><td>����ʱ�䣺</td><td><label><?php echo $bmenu->BCSJ;?></label></td></tr>
					<tr style="font-size: 12px;"><td>������ϵ�ˣ�</td><td><label><?php echo $bmenu->LXMAN;?></label></td></tr>
					<tr style="font-size: 12px;"><td>��ϵ�绰��</td><td><label><?php echo $bmenu->LXDH;?></label></td></tr>
					<tr style="font-size: 12px;height: 48px"><td>����������</td><td><label><?php echo $bmenu->MEMO;?></label></td></tr>
				<?php else: ?>
					<tr><td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>�޷���λ������Ϣ!</h3>
					</div></td></tr>
				<?php endif; ?>
				</table>
			</div>
	</div>

</body>
</html>
