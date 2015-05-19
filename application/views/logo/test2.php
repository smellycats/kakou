<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title>无标题文档</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/magiczoom/magiczoom.css"; ?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/magiczoom/magiczoom.js";?>"></script>
</head>

<body>
	<a href="http://localhost/kakou_jquery/images/12.jpg" class="MagicZoom" id="zoom" rel = "show-title: false; drag-mode: false; zoom-height: 180px; zoom-width: 230px;zoom-position: right;zoom-distance: 0;"><img src="http://localhost/kakou_jquery/images/12.jpg" style="height:300px;" /></a>
	<input type="button" onclick="green();" value="test"/>
	<input type="button" onclick="MagicZoom.refresh();test3()" value="test3"/>
	<input type="button" onclick="test2();return false;" value="test2"/>
	<input type="button" onclick="change();MagicZoom.refresh();" value="change"/>
	<input type="button" onclick="green4();MagicZoom.refresh();" value="green4"/>
	<input type="button" onclick="green4_2();MagicZoom.refresh();" value="green4_2"/>
	<input type="button" onclick="green3();return false;" value="green3"/>

    <script type="text/javascript">
    
    function green(){
    	
    	MagicZoom.update('zoom', 'http://localhost/kakou_jquery/index.php/img/show_img?id=1', 'http://localhost/kakou_jquery/index.php/img/show_img?id=1', 'show-title: false; drag-mode: false');
    }

    function test3(){
    	//MagicZoom.refresh();
    	MagicZoom.update('zoom', 'http://localhost/kakou_jquery/images/12.jpg', 'http://localhost/kakou_jquery/images/12.jpg', 'show-title: false; drag-mode: false');
    }

    function green3(){
    	MagicZoom.refresh();
        var zoom = document.getElementById('zoom'); //get the reference to our zoom object
        zoom.href = 'http://localhost/kakou_jquery/images/12.jpg'; //change the big image
        zoom.rel = 'show-title: false; drag-mode: false; zoom-height: 180px; zoom-width: 230px;zoom-position: right;zoom-distance: 0;'
        zoom.firstChild.src = 'http://localhost/kakou_jquery/images/12.jpg'; //change the small image
        // refresh ALL zooms on the page
        MagicZoom.refresh();
    }

    function green4(){
    	//MagicZoom.refresh();
        var zoom = document.getElementById('zoom'); //get the reference to our zoom object
        zoom.href = 'http://localhost/kakou_jquery/images/12.jpg'; //change the big image
        zoom.rel = 'drag-mode: false; zoom-height: 230px; zoom-width: 230px; zoom-position: right; zoom-distance: 0;'; // enable zoom drag mode
        zoom.firstChild.src = 'http://localhost/kakou_jquery/images/12.jpg'; //change the small image
        // refresh ALL zooms on the page
        MagicZoom.refresh();
    }

    function green4_2(){
    	//MagicZoom.refresh();
        var zoom = document.getElementById('zoom'); //get the reference to our zoom object
        zoom.href = 'http://localhost/kakou_jquery/images/1.jpg'; //change the big image
        zoom.rel = 'drag-mode: false; zoom-height: 230px; zoom-width: 230px; zoom-position: right; zoom-distance: 0;'; // enable zoom drag mode
        zoom.firstChild.src = 'http://localhost/kakou_jquery/images/1.jpg'; //change the small image
        // refresh ALL zooms on the page
        MagicZoom.refresh();
    }

    function change(){
    	//MagicZoom.refresh();
        var zoom = document.getElementById('zoom'); //get the reference to our zoom object
        zoom.href = 'http://localhost/kakou_jquery/images/3.jpg'; //change the big image
        zoom.rel = 'drag-mode: false; zoom-height: 230px; zoom-width: 230px; zoom-position: right; zoom-distance: 0;'; // enable zoom drag mode
        zoom.firstChild.src = 'http://localhost/kakou_jquery/images/3.jpg'; //change the small image
        // refresh ALL zooms on the page
        MagicZoom.refresh();
    }

    function test2(){
    	//MagicZoom.refresh();
        var zoom = document.getElementById('zoom'); //get the reference to our zoom object
        zoom.href = 'http://localhost/kakou_jquery/index.php/img/show_img?id=1'; //change the big image
        zoom.rel = 'show-title: false; drag-mode: false; zoom-height: 180px; zoom-width: 230px;zoom-position: right;zoom-distance: 0;';
        zoom.firstChild.src = 'http://localhost/kakou_jquery/index.php/img/show_img?id=1'; //change the small image
        // refresh ALL zooms on the page
        MagicZoom.refresh();
    }
    function green5(){
    	//MagicZoom.refresh();
		MagicZoom.update('zoom', <?php echo "'".base_url(). 'index.php/img/show_img?id=1'."'"; ?>, <?php echo "'".base_url(). 'index.php/img/show_sl?id=1'."'"; ?>, 'show-title: false; drag-mode: false; zoom-height: 180px; zoom-width: 230px;zoom-position: right;zoom-distance: 0;');
		//MagicZoom.refresh();
    }

	</script>
</body>
</html>