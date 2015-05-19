<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
	<title><?php echo $this->config->item('title');?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/" . $this->config->item('ui_themes') . "/easyui.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/icon.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/color.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jquery-easyui/themes/main.css";?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "js/jqzoom_ev-2.3/css/jquery.jqzoom.css"; ?>" />
	<script type="text/javascript" src="<?php echo base_url() . "js/jQuery1.7.1/jquery-1.7.1.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/jquery.easyui.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jquery-easyui/locale/easyui-lang-zh_CN_GBK.js";?>"></script>
	<script type="text/javascript" src="<?php echo base_url() . "js/jqzoom_ev-2.3/js/jquery.jqzoom-core-pack.js";?>"></script>
</head>

<body>
	<div id="p" class="easyui-panel">
	    <div class="clearfix">
	        <a href=<?php echo '"'.base_url(). 'index.php/img/show_img?id=5'.'"'; ?> class="jqzoom" id="jqzoom" rel="gal1"  title="triumph" >
	            <img src=<?php echo '"'.base_url(). 'index.php/img/show_img?id=5'.'"'; ?>  style="height:400px;" />
	        </a>
	    </div>
	</div>
	<div id="p2" class="easyui-panel">
		<div style="float:left;"><table id="pg" style="width:300px"></table></div>
		<div style="float:left;"><table id="pg2" style="width:300px"></table></div>
		<div style="float:left;padding:10px 30px 30px 30px;" >
			<a href="javascript:void(0)" id="prev" class="easyui-linkbutton easyui-tooltip" title="上一页" onclick="prev();return false;" style="width:90px">上一页</a>
			<a href="javascript:void(0)" id="next" class="easyui-linkbutton easyui-tooltip" title="上一页" onclick="next();return false;" style="width:90px">下一页</a>
			<a href="javascript:void(0)" id="back" class="easyui-linkbutton" onclick="javascript:goUrl();return false;">返回</a>
		</div>
	</div>

	<script type="text/javascript">
	<?php $cmpquery = $this->session->userdata('cmpquery');?>
	var ids = <?php echo $ids;?>;
	var id = <?php echo $id;?>;
	var rows = <?php echo $cmpquery['rows'];?>;
	var total = <?php echo $cmpquery['total'];?>;
	var offset = <?php echo $cmpquery['offset']?>;
	var index = <?php echo $index;?>;
	
	$(document).ready(function() {
		updateimg();
		loaddata();
	});
	
    function next(){
        var next = index+1;
        if (next+offset >= total){
            alert('最后一页');
        }else if(next >= ids.length){
            $.post('<?php echo base_url() . "index.php/logo/get_cmp_ids"."'";?>, { offset: offset+rows, rows:rows}, function (result) {
                    if (result.success) {
                    	ids = result.ids;
                    	offset = offset+rows;
                    	id = ids[0];
                    	index = 0;
                    	updateimg();
                		loaddata(); 
                    } else {
                        $.messager.show({   // show error message  
                            title: '错误信息',
                            msg: result.msg
                        });
                    }
                }, 'json');
        }else{
        	id = ids[next];
        	index = next;
        	updateimg();
    		loaddata(); 
        }
    }  

    function prev(){
        var prev = index-1;
        if (prev+offset < 0){
            alert('最前一页');
        }else if(prev < 0){
            $.post('<?php echo base_url() . "index.php/logo/get_cmp_ids"."'";?>, { offset: offset-rows, rows:rows}, function (result) {
                    if (result.success) {
                    	ids = result.ids;
                    	offset = offset-rows;
                    	//rows = rows;
                    	id = ids[rows-1];
                    	index = rows-1;
                    	updateimg();
                		loaddata(); 
                    } else {
                        $.messager.show({   // show error message  
                            title: '错误信息',
                            msg: result.msg
                        });
                    }
                }, 'json');
        }else{
        	id = ids[prev];
        	index = prev;
        	updateimg();
    		loaddata(); 
        }
    }  

    function loaddata(){
        if (offset+index+1 >= total){
        	$("#next").linkbutton("disable");
        }else if(offset+index <= 0){
        	$("#prev").linkbutton("disable");
        }else{
        	$('#prev').linkbutton('enable');
        	$('#next').linkbutton('enable');
        }
    	$('#pg').propertygrid({
    		url:'<?php echo base_url() . "index.php/basedata/get_carinfo_logo?id=" . "'";?>+id,
    		method:'get',
    		showGroup:true,
    		showHeader:true,
    		scrollbarSize:0,
            onLoadSuccess: function (data) {
    			var all = $('#pg').propertygrid('getData');
    			$('#pg2').propertygrid({
    				url:'<?php echo base_url() . "index.php/basedata/get_cgs?hphm="."'";?>+all['rows'][1]['value'],
    				method:'get',
    				showGroup:true,
    				showHeader:true,
    				scrollbarSize:0
    			});
            }
    	});
    }

    function goUrl(x)
    {
		window.location.replace(<?php echo "'".base_url() ."index.php/logo/cmpquery"."'";?>);
    }

    function updateimg()
    {
    	imgurl = 'http://localhost/imgareaselect/imgs/1.jpg'
    	$(".jqZoomWindow").remove();
    	$(".jqZoomPop").remove();
    	$("jqzoom img").unbind();
    	$("jqzoom").unbind();

    	$(".jqzoom img").attr("src",imgurl);
		$('.jqzoom').attr("href",imgurl).jqzoom({
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false,
            zoomWidth: 260,
            zoomHeight: 260,
            xOffset:5,
            yOffset:139
        });
    	
    }

	</script>
</body>
</html>