<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>

</head>
<body>
	<h3>ͼƬ��������</h3>
	<table align="center" cellspacing="0" cellpadding="6">
		<?php foreach ($imgdl as $row): ?>
		<tr>
			<td>���ص�ַ</td>	
			<td>
				<?php $serverip = array('192.');?>
				<?php if($row->WORK_RESULTS == Null or $row->WORK_RESULTS == '' or $row->WORK_RESULTS=='NEVER' or $row->WORK_RESULTS=='TIMEOUT' or substr($row->WORK_RESULTS, 0,5)=='ERROR'){echo '<span class="RED">���س���<span>';}else{echo '<a href="http://' . $imgip[$row->WORK_SERVER] . '/downloads/' . $row->WORK_RESULTS .'">' . $row->WORK_RESULTS . '</a>';}?> 	
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td>
				<input type="button" name="goback" value="����" onclick="javascript:history.go(-1);" />
			</td>
		</tr>
	</table>
</body>
</html>