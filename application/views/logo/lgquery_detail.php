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
	imgurl = 'http://localhost/imgareaselect/imgs/1.jpg'
	$(".jqZoomWindow").remove();
	$(".jqZoomPop").remove();

	$("jqzoom img").unbind();
	$("jqzoom").unbind();
	$(".jqzoom img").attr("src",imgurl);
	$('.jqzoom').attr("href",imgurl).jqzoom(options);

});
</script>

<div class="pageContent">
	<div id="pollxxPanel" class="pageFormContent" layoutH="58">
	    <div class="unit">
	        <a href="" class="jqzoom" id="jqzoom" rel="gal1" title="img" >
	            <img src="" style="height:350px;" />
	        </a>
	    </div>
	</div>
	<div class="formBar">
		<ul>
			<li>
				<div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
			</li>
		</ul>
	</div>
</div>