<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>�ޱ����ĵ�</title>
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
				<span>��ʼʱ��:</span>
				<input id="st" class="easyui-datetimebox" required="true" value="<?php echo $st;?>" style="width:150px" />
				<span>����ʱ��:</span>
				<input id="et" class="easyui-datetimebox" required="true" value="<?php echo $et;?>" style="width:150px" />
				<span>���ڵص�:</span>
				<input id="place" class="easyui-combobox"
						url = "<?php echo base_url() . 'index.php/basedata/get_place_logo';?>" 
						method = "get" valueField = "id" textField = "text" />
				<span>����:</span>
				<input id="dire" class="easyui-combobox" style="width:80px"
						url = "<?php echo base_url() . 'index.php/basedata/get_dire';?>" 
						method = "get" valueField = "id" textField = "text" />	
				<span>����:</span>
				<input id="carsize" class="easyui-combobox" style="width:60px"
						url = "<?php echo base_url() . 'index.php/basedata/get_carsize';?>" 
						method = "get" valueField = "id" textField = "text" />
				<span>Υ������:</span>
				<input id="breakrule" class="easyui-combobox" style="width:60px"
						url = "<?php echo base_url() . 'index.php/basedata/get_breakrule';?>" 
						method = "get" valueField = "id" textField = "text" />			
				<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">��ѯ</a>
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
	                text: 'Υ��ͳ��',
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
