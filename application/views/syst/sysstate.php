<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;·���豸����״̬</span></td>
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
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">·������</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">IP</span></div></td>
					<td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">����</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">���ػ�</span></div></td>
				    <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">�����</span></div></td>
	                <td height="20" bgcolor="#4e87d6" class="STYLE6"><div align="center"><span class="STYLE11">��¼ʱ��</span></div></td>			
				</tr>
				<?php $rownum = 0;?>
				<?php foreach ($eqstate as $row): ?>
				<?php if($row->NETSTATE == '����'){$net_color = 'STYLE27';}else{$net_color = 'STYLE26';}?>
				<?php if($row->COMPUTER == '����'){$com_color = 'STYLE27';}else{$com_color = 'STYLE26';}?>
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
                    <?php if($status_set[2] == '����'){$status_color = 'green';}else{$status_color = 'red';}?>
                    <?php if($status_set[4] == '0'){$dir = '����'; }
                          elseif($status_set[4] == '1'){$dir = '����'; }
                          elseif($status_set[4] == '2'){$dir = '�ɶ�����'; }
                          elseif($status_set[4] == '3'){$dir = '��������'; }
                          elseif($status_set[4] == '4'){$dir = '��������'; }
                          elseif($status_set[4] == '5'){$dir = '�ɱ�����'; }
                          else{$dir = '';}?>
                    <?php $content = $content . $status_set[3] . ' ' . $dir . ' ����' . $status_set[0] . ' ' . '[' . $status_set[1] . '] =<span style="color:'. $status_color. '">' . $status_set[2] . '</span>' . '<br/>';?>	
                    <?php endforeach; ?>
                    <td height="24" ><div align="center" class="STYLE23"><?php echo $content;?></div></td>
                    <?php endif;?>
                    <td height="24" ><div align="center" class="STYLE23"><?php echo $row->RTIME2;?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>û��·���豸!</h3>
					</div></td>
			    </tr>
				<?php endif; ?>
			</table>
			<p align="center" style="font-size:12px;color:blue">*ά����֪</p>
            <p align="center" style="font-size:12px;color:blue">1.���ػ���ʾ"�޷�����",���鹤�ػ�����ϵͳ�Ƿ���������,�ϴ�����Ƿ������ϴ�.</p>
            <p align="center" style="font-size:12px;color:blue">2.���г������������ʾ"�޷�����"�����ػ���ʾ"����",����ǰ��·����������ػ������Ƿ�ͨ��.</p>
            <p align="center" style="font-size:12px;color:blue">3.���������������ʾ"�޷�����",��������������ػ�����,ͨ�����ػ�PING�����IP��ַ�ж�������Ƿ�����.</p>
		</td>
	</tr>
</table>
</body>
</html>
