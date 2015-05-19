<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>无标题文档</title>
</head>

<body>
<script type="text/javascript" src=<?php echo base_url() . "js/xhedit1.1.0/jquery/jquery-1.4.2.min.js"; ?>></script>
<script type="text/javascript" src=<?php echo base_url() . "js/kakou.js"; ?>></script>

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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;路口设备运行状态</span></td>
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
	<tr>
		<td>
			<table align="center" width="95%" cellpadding="0" cellspacing="1" class="tab">
				<tr>
				<?php if (!empty($eqstate)): ?>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">#</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">路口名称</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">IP</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">网络</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">工控机</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">摄像机</span></div></td>
	                <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">记录时间</span></div></td>			
				</tr>
				<?php $rownum = 0;?>
				<?php foreach ($eqstate as $row): ?>
				<?php if($row->NETSTATE == '正常'){$net_color = 'STYLE27';}else{$net_color = 'STYLE26';}?>
				<?php if($row->COMPUTER == '正常'){$com_color = 'STYLE27';}else{$com_color = 'STYLE26';}?>
				<tr> 
					<td height="24" ><div align="center" class="STYLE23"><?php echo $rownum += 1; ?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->KKNAME;?></div></td>
					<td height="24" ><div align="center" class="STYLE23"><?php echo $row->CDBH2;?></div></td>
                    <td height="24" ><div align="center" class="<?php echo $net_color;?>"><?php echo $row->NETSTATE;?></div></td>
                    <td height="24" ><div align="center" class="<?php echo $com_color;?>"><?php echo $row->COMPUTER;?></div></td>
                    <?php $camera_set = explode('###', $row->CDBH1);?>
                    <?php if($row->CDBH1 != ''): ?>
                    <?php $content = '';?>
                    <?php foreach ($camera_set as $camera):?>
                    <?php $status_set = explode('|', $camera);?>
                    <?php if($status_set[2] == '正常'){$status_color = 'green';}else{$status_color = 'red';}?>
                    <?php if($status_set[4] == '0'){$dir = '出城'; }
                          elseif($status_set[4] == '1'){$dir = '进城'; }
                          elseif($status_set[4] == '2'){$dir = '由东往西'; }
                          elseif($status_set[4] == '3'){$dir = '由南往北'; }
                          elseif($status_set[4] == '4'){$dir = '由西往东'; }
                          elseif($status_set[4] == '5'){$dir = '由北往南'; }
                          else{$dir = '';}?>
                    <?php $content = $content . $status_set[3] . ' ' . $dir . ' 车道' . $status_set[0] . ' ' . '[' . $status_set[1] . '] =<span style="color:'. $status_color. '">' . $status_set[2] . '</span>' . '<br/>';?>	
                    <?php endforeach; ?>
                    <td height="24" ><div align="center" class="STYLE23"><?php echo $content;?></div></td>
                    <?php endif;?>
                    <td height="24" ><div align="center" class="STYLE23"><?php echo $row->RTIME2;?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>没有路口设备!</h3>
					</div></td>
			    </tr>
				<?php endif; ?>
			</table>
			<p align="center" style="font-size:12px;color:blue">*维护须知</p>
            <p align="center" style="font-size:12px;color:blue">1.工控机显示"无法连接",请检查工控机操作系统是否运行正常,上传软件是否正常上传.</p>
            <p align="center" style="font-size:12px;color:blue">2.所有车道摄象机都显示"无法连接"但工控机显示"正常",请检查前端路口相机到工控机网络是否通畅.</p>
            <p align="center" style="font-size:12px;color:blue">3.单个车道摄象机显示"无法连接",请检查摄象机到工控机网络,通过工控机PING摄象机IP地址判断摄象机是否正常.</p>
		</td>
	</tr>
</table>
</body>
</html>
