<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>�ޱ����ĵ�</title>

<style type="text/css">
a{color:#666;text-decoration:none}
ul {list-style-type:none;margin:0}
li{border:1px solid #F69;width:120px}
.selecthover{background-color:#F69}
.lihover{background-color:#F69}
</style>

</head>
<body>
<script type="text/javascript" src=<?php echo base_url() . "js/xhedit1.1.0/jquery/jquery-1.4.2.min.js"; ?>></script>

<script language="javascript">

$("li").click(function(){
	$(this).addClass("selecthover").siblings().removeClass("selecthover");
	}).hover(function(){
	$(this).addClass("lihover");
	},function () {
	$(this).removeClass("lihover");
})

</script>

		<ul id="Sub_Links">
		<li>
		<a href="#">���</a>
		</li>
		<li>
		<a href="#">������</a>
		</li>
		<li>
		<a href="#">ƴ��</a>
		</li>
		<li>
		<a href="#">̨���</a>
		</li>
		<li>
		<a href="#">ϴ����</a>
		</li>
		<li>
		<a href="#">��¯</a>
		</li>
		<li>
		<a href="#">����</a>
		</li>
		</ul>
		<br/>
		<ul id="Sub_Links">
		<li>
		<a href="#">���</a>
		</li>
		<li>
		<a href="#">������</a>
		</li>
		<li>
		<a href="#">ƴ��</a>
		</li>
		<li>
		<a href="#">̨���</a>
		</li>
		<li>
		<a href="#">ϴ����</a>
		</li>
		<li>
		<a href="#">��¯</a>
		</li>
		<li>
		<a href="#">����</a>
		</li>
		</ul>

</body>
</html>