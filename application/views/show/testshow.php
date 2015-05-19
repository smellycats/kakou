 <script>
   var time = setInterval("func()",1000);
    var count = 10;
   function func(){
       if(count != 0){
           document.getElementById("div1").innerHTML = count;;
           count--;   //当count--放在if里面的时候，执行完就会结束。
       }else{
           document.getElementById("div1").innerHTML = "<font size='20' color='red'>over</font>";
           
        }
        //count--; //当count放在if外面的时候不断的继续执行setInterval函数
    } 
     // 上面的实例说明了setInterval函数是不断的周期的循环执行  那我们在看看setTimeout

  </script>
  <script language=javascript> 

setInterval("test()",1000);
function test()
{
	alert('Hello Word!PHP');
}
</script>

var xmlHttp;
function S_xmlhttprequest()
{
	alert ("浏览器不支持AJAX技术");
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.ActiveXObject){
		xmlHttp = new XMLHttpRequest();
		}
}
function show() {
	S_xmlhttprequest();
  	var url = <?php echo base_url() . "index.php/show/realshowdiv/"?>;
  	xmlHttp.open("POST", "http://127.0.0.1/kakou/index.php/show/realshowdiv/"+id, true);
  	xmlHttp.onreadystatechange = update;
  	xmlHttp.send();
}
function update() {
  	if (xmlHttp.readyState == 4) {
		var response = xmlHttp.responseText;
		if (response!="old")
			document.getElementById('mainRefresh').innerHTML=response;
 	}
}

setInterval("show()",1000);