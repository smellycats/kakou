<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
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
.styred { color: red; }
-->
</style>
</head>
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
											<td width="94%" valign="bottom"><span class="STYLE1">&nbsp;
											<?php
											echo anchor('admin/category_list/', '������ҳ');
											if ($get_category_name!=='')
											{
												foreach ($get_category_name as $row)
												{
													$category_name = explode("|", $row->category_name);
													$idlist = explode(",", $row->idlist);

													for ($i=0; $i<count($category_name)-1; $i++)
													{
														echo ' >> ' . anchor('admin/category_list/' . $idlist[$i+1], $category_name[$i]);
													}
												}
											}
											?>
											</span></td>
										</tr>
									</table>
								</td>
								<td><div align="right"><span class="STYLE1">      &nbsp;&nbsp;</span><span class="STYLE1"> &nbsp;</span></div></td>
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
					<?php if (!empty($get_category)): ?>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">ID</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">��������</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">����״̬</span></div></td>
					<td height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">����</span></div></td>
				</tr>
				<?php foreach ($get_category as $row): ?>
				<tr>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $row->id; ?></div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<?php
						$bb = explode("|", $row->category_name);
						echo anchor('admin/category_list/' . $row->id, $bb[count($bb)-2]); ?>
					</div></td>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo $row->lastflag; ?></div></td>
					<td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21"><?php echo anchor('admin/edit_category/' . $row->id, '�޸�'); ?>|<?php echo anchor('admin/del_category/' . $row->id, 'ɾ��'); ?></div></td>
				</tr>
				<?php endforeach; ?>
				<tr>
				<?php else: ?>
					<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">
						<h3>���޷���,�����!</h3>
					</div></td>
				<?php endif; ?>
				</tr>
			</table>
			<?php echo form_open('admin/add_category');?>
			<?php echo form_hidden('id',$id)?>
			<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#a8c7ce">
				<tr>
					<td width="100%" > <b>��ǰ��������ӷ��ࣺ</b>
						<input TYPE="text" size=17 name="class_name" value="<?php echo set_value('class_name'); ?>" />
						<select name="lastflag" size="1" id="lastflag">
							<option value="1" selected>�����б�</option>
							<option value="2">ͼƬ�б�</option>
							<option value="3">������ʾ</option>
							<option value="4">�м����</option>
						</select>
						<input name="submit" type='submit' value="�½�����" /><?php echo form_error('class_name'); ?>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
</body>
</html>
