<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href=<?php echo base_url() . "style/kkstyle.css"; ?> type="text/css" />
<title>�ޱ����ĵ�</title>
	<script type="text/javascript" src=<?php echo '"'.base_url() . 'js/jQuery1.8.2/jquery-1.8.2.js"'; ?>></script>
	<script type="text/javascript">
		$(function () {
	    	
	    	// Radialize the colors
			Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
			    return {
			        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
			        stops: [
			            [0, color],
			            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
			        ]
			    };
			});
			
			// Build the chart
	        $('#container').highcharts({
	            chart: {
	                plotBackgroundColor: null,
	                plotBorderWidth: null,
	                plotShadow: false
	            },
	            title: {
	                text: <?php echo "'����:".$total."��'";?>
	            },
	            tooltip: {
	        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	            },
	            plotOptions: {
	                pie: {
	                    allowPointSelect: true,
	                    cursor: 'pointer',
	                    dataLabels: {
	                        enabled: true,
	                        color: '#000000',
	                        connectorColor: '#000000',
	                        formatter: function() {
	                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
	                        }
	                    }
	                }
	            },
	            series: [{
	                type: 'pie',
	                name: '����������',
	                data: [
	                    <?php echo $pie;?>
	                ]
	            }]
	        });
	    });
	</script>

</head>

<body>
	<script defer="defer" type="text/javascript" src=<?php echo base_url() . "js/My97DatePicker/WdatePicker.js"; ?>></script>
	<script src=<?php echo base_url() . "highcharts/js/highcharts.js"; ?>></script>
	<script src=<?php echo base_url() . "js/modules/exporting.js"; ?>></script>
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
												<td width="94%" valign="bottom"><span class="STYLE12">&nbsp;Υ��ͳ��</span></td>
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
	        <form method="post" action="<?php echo site_url('stat/wzsum_search2'); ?>">
			<div align="center">
			<table align="center" width="100%" border="1" cellspacing="0" bordercolor="#639CBF">
		      <tr bordercolor="#E6E6E6">
		        <td width="8%" bordercolor="#E6E6E6" style="font-size: 12px;"><span>��ʼʱ��:</span></td>
	            <td width="20%" bordercolor="#E6E6E6"><input id="starttime" name="starttime" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_starttime;?>"></td>
	            <td width="8%" bordercolor="#E6E6E6" style="font-size: 12px;"><span>����ʱ��:</span></td>
	            <td width="20%" bordercolor="#E6E6E6"><input id="endtime"  name="endtime" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $sel_endtime;?>"></td>
	            <td width="8%" bordercolor="#E6E6E6" style="font-size: 12px;"><span>�� ��:</span></td>
	            <td width="12%" bordercolor="#E6E6E6">
	                <select name="cartype">
	                <option value="all" <?php if ($sel_cartype=='all'){echo " selected";} ?>>����</option>
	                <?php foreach ($cartype as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_cartype==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
	            </td>
	            <td width="30%" align="center" bordercolor="#E6E6E6" style="font-size: 12px;">
	                <span>��ʾ��ʽ:</span>
	                <span>
	                <select name="viewtype">
	                <?php foreach ($viewtype as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_viewtype==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
	                </span></td>
			  </tr>
			  <tr>
	            <td bordercolor="#E6E6E6" style="font-size: 12px;"><span>·������:</span></td>
	            <td bordercolor="#E6E6E6">
	                <select name="type_alias">
	                <option value="all" <?php if ($sel_type_alias=='all'){echo " selected";} ?>>����</option>
	                <?php foreach ($okkval as $id=>$kakou): ?>
	                <option value=<?php echo '"'.$kakou.'"'; ?> <?php if ($sel_type_alias==$kakou){echo " selected";} ?>><?php echo $openkakou[$id]; ?></option>
	                <?php endforeach; ?>
	                </select>
	            </td>
	            <td bordercolor="#E6E6E6" style="font-size: 12px;"><span>Υ������:</span></td>
	            <td bordercolor="#E6E6E6">
	                <select name="breakrule">
	                <option value="all" <?php if ($sel_breakrule=='all'){echo " selected";} ?>>����</option>
	                <?php foreach ($breakrule as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_breakrule==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
	            </td>
	            <td bordercolor="#E6E6E6" style="font-size: 12px;"><span>����:</span></td>
	            <td bordercolor="#E6E6E6"> 
	                <select name="direction">
	                <option value="all" <?php if ($sel_direction=='all'){echo " selected";} ?>>����</option>
	                <?php foreach ($direction as $row): ?>
	                <option value="<?php echo "$row"; ?>" <?php if ($sel_direction==$row){echo " selected";} ?>><?php echo "$row"; ?></option>
	                <?php endforeach; ?>
	                </select>
	            <td align="center" bordercolor="#E6E6E6"><input class="BUTBLACK" type="submit" name="Submit" value="ͳ��"></td>
			  </tr>
	        </table></div>
		    </form>
		</tr>
	</table>
	<div id="container" style="min-width: 500px; height: 400px; margin: 0 auto; display:<?php echo $display;?>"></div>
</body>
</html>