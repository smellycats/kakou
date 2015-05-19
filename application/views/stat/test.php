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
			       contextButtonTitle:"ͼ�����˵�",
			       decimalPoint:".",
			       downloadJPEG:"����JPEGͼƬ",
			       downloadPDF:"����PDF�ļ�",
			       downloadPNG:"����PNG�ļ�",
			       downloadSVG:"����SVG�ļ�",
			       drillUpText:"���� {series.name}",
			       loading:"������",
			       months:["һ��","����","����","����","����","����","����","����","����","ʮ��","ʮһ��","ʮ����"],
			       noData:"û������",
			       numericSymbols: [ "ǧ" , "��" , "G" , "T" , "P" , "E"],
			       printChart:"��ӡͼ��",
			       resetZoom:"�ָ�����",
			       resetZoomTitle:"�ָ�ͼ��",
			       shortMonths: [ "Jan" , "Feb" , "Mar" , "Apr" , "May" , "Jun" , "Jul" , "Aug" , "Sep" , "Oct" , "Nov" , "Dec"],
			       thousandsSep:",",
			       weekdays: ["����һ", "���ڶ�", "������", "������", "������", "������", "������","������"]
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
	                text: '������ͳ��',
	                style: {
	                    color: '#4B79E5',
	                    fontFamily: 'Microsoft Yahei, Verdana, sans-serif',
	                    fontWeight: 'bold'
	                }
	            },
	            subtitle: {
	                text: '����:'+total+'��'
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
	                    text: '���� (��)'
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
	                    '<td style="padding:0"><b>{point.y} ��</b></td></tr>',
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
	                name: '������',
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
