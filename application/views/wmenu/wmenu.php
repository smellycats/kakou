<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>�ޱ����ĵ�</title>
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
    <script>
    /*
         ��;��У��ip��ַ�ĸ�ʽ 
         ���룺strIP��ip��ַ
         ���أ����ͨ����֤����true,���򷵻�false��
   */
    function isIP(strIP)
    { 
        if (isNull(strIP)) return false; 
        var re=/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/g //ƥ��IP��ַ��������ʽ 
        if(re.test(strIP)) 
        { 
            if( RegExp.$1 <256 && RegExp.$2<256 && RegExp.$3<256 && RegExp.$4<256) return true; 
        } 
        return false; 
    } 
    </script>
<body>
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
											<td width="94%" valign="bottom"><span class="STYLE1">&nbsp;IP���ʿ���(ֻ��������IP����)</span></td>
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
			<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
				<tr>
				<?php if (!empty($ip_access)): ?>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">���ƺ���</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">״̬</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">����</span></div></td>
				</tr>
				<?php foreach ($ip_access as $ip): ?>
				<tr>	
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php if(!$ip->MAXIP){echo $ip->MINIP;}else{echo "$ip->MINIP" . " �� " . "$ip->MAXIP";}?></div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php if($ip->CLBJ == 'T'){ echo '������'; }else{echo  '�ѽ���';}?></div></td>
                    <td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21"><?php $ip->CLBJ == 'T'?$op='����':$op='����'; echo anchor('syst/banned_ipaccess/'.$ip->ID,$op)?>|<?php echo anchor('syst/del_ipaccess/'.$ip->ID,'ɾ��')?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>!</h3>
					</div></td>
				<?php endif; ?>
			</table>
			<p align="center" style="font-size:12px;color:blue">ע��: ���ֻ���ŵ���IP, ������һ�������������.</p>
			<form method="post" action="<?php echo site_url('syst/add_ipaccess'); ?>">
			<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#a8c7ce">
				<tr>
					<td width="100%" > <b>IP��Χ��</b>
						<label></label><input TYPE="text" name="minip" value="<?php echo set_value('minip'); ?>" /><?php echo form_error('minip'); ?>
						<label>- </label><input TYPE="text" name="maxip" value="<?php echo set_value('maxip'); ?>" /><?php echo form_error('maxip'); ?>
						<input name="submit" type='submit' value="���" />
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>

</table>
</body>
</html>

