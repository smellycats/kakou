<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=gbk">
		<title>Highcharts Example</title>

	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.min.js"?>"></script>
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
	                text: '车流量统计',
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
	            }]
	        });
		}
		</script>
	</head>
	<body>
<script type="text/javascript" src="<?php echo base_url() . "js/Highcharts-4.0.1/js/highcharts.js"?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "js/Highcharts-4.0.1/js/modules/exporting.js"?>"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
