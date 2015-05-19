<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>无标题文档</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/color.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jqzoom_ev-2.3/css/jquery.jqzoom.css"; ?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jqzoom_ev-2.3/js/jquery-1.6.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jqzoom_ev-2.3/js/jquery.jqzoom-core.js";?>"></script>
</head>

<body>
	<div id="p" class="easyui-panel">
	    <div class="clearfix">
	        <a id="a_jz" href=<?php echo '"'.base_url(). 'index.php/img/show_img?id=5'.'"'; ?> class="jqzoom"  rel="gal1"  title="triumph" >
	            <img id="img_jz" src=<?php echo '"'.base_url(). 'index.php/img/show_img?id=5'.'"'; ?>  style="height:400px;" />
	        </a>
	    </div>
			<a href="javascript:void(0)" id="prev" class="easyui-linkbutton" onclick="updateimg();return false;" style="width:90px">updateimg</a>
			<a href="javascript:void(0)" id="next" class="easyui-linkbutton" onclick="changeimg();return false;" style="width:90px">下一个</a>
			<a href="javascript:void(0)" id="next" class="easyui-linkbutton" onclick="test();return false;" style="width:90px">test</a>
	</div>

	<script type="text/javascript">

    function goUrl(x)
    {
    	history.go(-1);
    }
    
	var options = {
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false,
            zoomWidth: 260,
            zoomHeight: 260,
            position:'right',
            xOffset:5,
            yOffset:139
            }
    

	$(document).ready(function() {
		$('.jqzoom').jqzoom(options);
	});

	function initJqzoom() { 
	    $('.jqzoom').jqzoom(options); 
	}   

	function cleanJqzoom() {
	    // clean the data from jQZoom
	    $('.jqzoom').removeData('jqzoom');
	}

	function test()
	{
		imgurl = 'http://localhost/imgareaselect/imgs/7.jpg';
		
	    cleanJqzoom();

	    $("#a_jz").attr('href', imgurl);
	    $("#img_jz").attr('src', imgurl);

	    initJqzoom();
	}

    function updateimg()
    {
    	imgurl = 'http://localhost/imgareaselect/imgs/3.jpg';
    	//#$("#a_jz").unbind();
    	//#$("#img_jz").unbind();
    	cleanJqzoom();
    	//$(".jqZoomWindow").remove();
    	//$(".jqZoomPop").remove();
    	$("jqzoom img").unbind();
    	$("jqzoom").unbind();

    	$(".jqzoom img").attr("src",imgurl);
		$('.jqzoom').attr("href",imgurl);
		
		initJqzoom();
    }

    	function changeimg() {
			alert('123');
    		imgurl = 'http://localhost/imgareaselect/imgs/4.jpg';
    		
            $(".jqZoomWindow").remove();//关键操作1
            $(".jqZoomPup").remove(); //关键操作2
            
            $(".jqzoom img").attr("src",imgurl);
            $("jqzoom img").unbind(); //关键操作3
            $(".jqzoom").unbind(); //关键操作4

            $(".jqzoom").attr("href",imgurl).jqzoom(options); 
        }

	</script>
</body>
</html>