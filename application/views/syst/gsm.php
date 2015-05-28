<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url() ;?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jqzoom_ev-2.3/css/jquery.jqzoom.css"; ?>" />
<script src="<?php echo base_url('js/dwz/js/jquery-1.7.2.min.js');?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() . "js/jqzoom_ev-2.3/js/jquery.jqzoom-core-pack.js";?>"></script> 
</head>

<body>

	<div id="p">
	    <div class="clearfix">
	        <a href=<?php echo '"'.base_url(). 'index.php/img/show_img?id=5'.'"'; ?> class="jqzoom" id="jqzoom" rel="gal1"  title="triumph" >
	            <img src=<?php echo '"'.base_url(). 'index.php/img/show_img?id=5'.'"'; ?>  style="height:400px;" />
	        </a>
	    </div>
	</div>

	<script type="text/javascript">
	var options = {
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false,
            zoomWidth: 260,
            zoomHeight: 260,
            xOffset:5,
            yOffset:139
            }
	
	$(document).ready(function() {
		alert('123');
    	imgurl = 'http://localhost/imgareaselect/imgs/1.jpg'
    	$(".jqZoomWindow").remove();
    	$(".jqZoomPop").remove();

    	$("jqzoom img").unbind();
    	$("jqzoom").unbind();
    	$(".jqzoom img").attr("src",imgurl);
		$('.jqzoom').attr("href",imgurl).jqzoom(options);

	});
	</script>

</body>
</html>
