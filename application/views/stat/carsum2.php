<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<!--<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
--><title>无标题文档</title>
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
.STYLE12 {font-weight:bold; color: #FFFFFF; font-size: 14px; }
.STYLE13 {font-weight:bold; color: #000000; font-size: 14px; }
.STYLE19 { color: #344b50; font-size: 12px; }
.STYLE21 { font-size: 12px; color: #3b6375; }
.STYLE22 { font-size: 12px; color: #295568; }
-->
</style>
</head>
<body>
<script defer="defer" type="text/javascript" src=<?php echo base_url() . "js/My97DatePicker/WdatePicker.js"; ?>></script>
<script language="javascript" type="text/javascript">

function changeBG(object, colorvalue)
{
	for (i=1; i<=10; i++)
		object.all['col_'+i].style.backgroundColor = colorvalue;

	return true;
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
											<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;车辆流量统计</span></td>
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
        <form method="post" action="<?php echo site_url('stat/carsum_search2'); ?>">
		<div align="center">
		<table align="center" width="100%" border="1" cellspacing="0" bordercolor="#639CBF">
	      <tr bordercolor="#E6E6E6">
	        <td width="8%" bordercolor="#E6E6E6" style="font-size: 12px;"><span>开始时间:</span></td>
            <td width="21%" bordercolor="#E6E6E6"><input id="starttime" name="starttime" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_starttime;?>"></td>
            <td width="8%" bordercolor="#E6E6E6" style="font-size: 12px;"><span>结束时间:</span></td>
            <td width="25%" bordercolor="#E6E6E6"><input id="endtime"  name="endtime" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_endtime;?>"></td>
            <td width="15%" align="center" bordercolor="#E6E6E6" style="font-size: 12px;">
                <span>车 型:
                <select name="cartype">
                <option value="all" <?php if ($sel_cartype=='all'){echo " selected";} ?>>所有</option>
                <?php foreach ($cartype as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_cartype==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
                </span>
            </td>
            <td width="30%" align="center" bordercolor="#E6E6E6" style="font-size: 12px;"><span>显示方式:</span>
                <span>
                <select name="viewtype">
                <?php foreach ($viewtype as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_viewtype==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
                </span></td>
		  </tr>
		  <tr>
            <td bordercolor="#E6E6E6" style="font-size: 12px;"><span>路口名称:</span></td>
            <td bordercolor="#E6E6E6">
                <select name="type_alias">
                <option value="all" <?php if ($sel_type_alias=='all'){echo " selected";} ?>>所有</option>
                <?php foreach ($openkakou as $kakou): ?>
                <option value="<?php echo "$kakou"; ?>" <?php if ($sel_type_alias==$kakou){echo " selected";} ?>><?php echo "$kakou"; ?></option>
                <?php endforeach; ?>
                </select>
            </td>
            <td bordercolor="#E6E6E6" style="font-size: 12px;"><span>方向:</span></td>
            <td colspan="2" bordercolor="#E6E6E6" style="font-size: 12px;">
                <select name="direction">
                <option value="all" <?php if ($sel_direction=='all'){echo " selected";} ?>>所有</option>
                <?php foreach ($direction as $row): ?>
                <option value="<?php echo "$row"; ?>" <?php if ($sel_direction==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
                <?php endforeach; ?>
                </select>
        <div align="center"></div></td>
            <td align="center" bordercolor="#E6E6E6"><input type="submit" name="Submit" value="统计"></td>
		  </tr>
        </table></div>
	    </form>
	</tr>
	<?php if($sel_graph != ''): ?>
	<div align="center">
		<img src="<?php echo base_url() . "index.php/stat/create_graph?starttime=" . $sel_starttime . "&endtime=" . $sel_endtime . "&cartype=" . $sel_cartype . "&viewtype=" . $sel_viewtype . "&type_alias=" . $sel_type_alias . "&direction=" . $sel_direction . "&breakrule=&alarmtype=&dispose="; ?>"></img>
	</div>
	<?php endif;?>
</table>

</body>
</html>