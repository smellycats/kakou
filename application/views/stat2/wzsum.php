<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>无标题文档</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/color.css"?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css"?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js"?>"></script>

</head>
<body>
	<script type="text/javascript" src="<?php echo base_url() . "js/Highcharts-4.0.1/js/highcharts.js"?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/Highcharts-4.0.1/js/modules/exporting.js"?>"></script>
	<div id="p" class="easyui-panel" style="width:100%;padding:0px 10px 10px 10px;">
		<div id="tb" style="padding:3px 20px">
			<div align="center">
				<span>开始时间:</span>
				<input id="st" class="easyui-datetimebox" required="true" value="<?php echo $st;?>" style="width:150px" />
				<span>结束时间:</span>
				<input id="et" class="easyui-datetimebox" required="true" value="<?php echo $et;?>" style="width:150px" />
				<span>卡口地点:</span>
				<input id="place" class="easyui-combobox"
						url = "<?php echo base_url() . 'index.php/basedata/get_place_logo';?>" 
						method = "get" valueField = "id" textField = "text" />
				<span>方向:</span>
				<input id="dire" class="easyui-combobox" style="width:80px"
						url = "<?php echo base_url() . 'index.php/basedata/get_dire';?>" 
						method = "get" valueField = "id" textField = "text" />	
				<span>车型:</span>
				<input id="carsize" class="easyui-combobox" style="width:60px"
						url = "<?php echo base_url() . 'index.php/basedata/get_carsize';?>" 
						method = "get" valueField = "id" textField = "text" />
				<span>违法类型:</span>
				<input id="breakrule" class="easyui-combobox" style="width:60px"
						url = "<?php echo base_url() . 'index.php/basedata/get_breakrule';?>" 
						method = "get" valueField = "id" textField = "text" />			
				<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">查询</a>
			</div>
		</div>
		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	</div>
	<script type="text/javascript">
		var title = [];
		var data = [];
		var total = 0;
		$(function () {
			Highcharts.setOptions({
			    lang:{
			       contextButtonTitle:"图表导出菜单",
			       decimalPoint:".",
			       downloadJPEG:"下载JPEG图片",
			       downloadPDF:"下载PDF文件",
			       downloadPNG:"下载PNG文件",
			       downloadSVG:"下载SVG文件",
			       drillUpText:"返回 {series.name}",
			       loading:"加载中",
			       months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
			       noData:"没有数据",
			       numericSymbols: [ "千" , "兆" , "G" , "T" , "P" , "E"],
			       printChart:"打印图表",
			       resetZoom:"恢复缩放",
			       resetZoomTitle:"恢复图表",
			       shortMonths: [ "Jan" , "Feb" , "Mar" , "Apr" , "May" , "Jun" , "Jul" , "Aug" , "Sep" , "Oct" , "Nov" , "Dec"],
			       thousandsSep:",",
			       weekdays: ["星期一", "星期二", "星期三", "星期三", "星期四", "星期五", "星期六","星期天"]
			    }
			});
			
	        $.post('<?php echo base_url() . "index.php/stat/load_data"."'";?>, { id: 1 }, function (result) {
	                title = result.title;
	                data = result.data
	                for(var i = 0; i < data.length; i++) {
	                	total += data[i];
	                }
	                loaddata();
	            }, 'json');      
		});
	
		function loaddata(){
	        $('#container').highcharts({
	            chart: {
	                type: 'column'
	            },
	            title: {
	                text: '违章统计',
	                style: {
	                    color: '#4B79E5',
	                    fontFamily: 'Microsoft Yahei, Verdana, sans-serif',
	                    fontWeight: 'bold'
	                }
	            },
	            subtitle: {
	                text: '总数:'+total+'辆'
	            },
	            legend: {
	                enabled: false
	            },
	            xAxis: {
	                labels: {
	            		rotation: -45,
	            		align: 'right',
	                    style: {
	            			fontSize: '13px',
	            			fontFamily: 'Microsoft Yahei, Verdana, sans-serif'
	                    }
	                },
	                categories: title
	            },
	            yAxis: {
	                min: 0,
	                title: {
	                    text: '车流 (辆)'
	                },
		            labels: {
		                style: {
	                		fontSize: '13px',
	                		fontFamily: 'Microsoft Yahei, Verdana, sans-serif'
		                }
		            }
	            },
	            tooltip: {
	                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                    '<td style="padding:0"><b>{point.y} 辆</b></td></tr>',
	                footerFormat: '</table>',
	                shared: true,
	                useHTML: true
	            },
	            plotOptions: {
	                column: {
	                    pointPadding: 0.2,
	                    borderWidth: 0
	                }
	            },
	            series: [{
	                name: '车流量',
	                data: data,
		            dataLabels: {
		                enabled: true,
		                rotation: -90,
		                color: '#FFFFFF',
		                align: 'right',
		                x: 4,
		                y: 10,
		                style: {
		                    fontSize: '13px',
		                    fontFamily: 'Microsoft YaheiVerdana, Verdana, sans-serif'
		                }
		            }
	            }],
	            exporting: {
	                enabled: false
	            }
	        });
		}
		function doSearch(){ 
            $.post('<?php echo base_url() . "index.php/stat/stat_data"."'";?>, { place: $('#place').combobox('getValue'),st:$('#st').combobox('getValue'),et:$('#et').combobox('getValue'),dire:$('#dire').combobox('getValue'),carsize:$('#carsize').combobox('getValue'),breakrule:$('#breakrule').combobox('getValue')}, function (result) {
                    title = result.title;
                    data = result.data
                    for(var i = 0; i < data.length; i++) {
                    	total += data[i];
                    }
                    loaddata();
                }, 'json');   
		} 
	</script>
</body>
</html>
