 <script>
   var time = setInterval("func()",1000);
    var count = 10;
   function func(){
       if(count != 0){
           document.getElementById("div1").innerHTML = count;;
           count--;   //��count--����if�����ʱ��ִ����ͻ������
       }else{
           document.getElementById("div1").innerHTML = "<font size='20' color='red'>over</font>";
           
        }
        //count--; //��count����if�����ʱ�򲻶ϵļ���ִ��setInterval����
    } 
     // �����ʵ��˵����setInterval�����ǲ��ϵ����ڵ�ѭ��ִ��  �������ڿ���setTimeout

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
	alert ("�������֧��AJAX����");
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