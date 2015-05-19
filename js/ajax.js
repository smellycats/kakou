var xmlHttp;
function S_xmlhttprequest()
{
	if(window.ActiveXObject){
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.ActiveXObject){
		xmlHttp = new XMLHttpRequest();
		}
}
function show(id) {
	S_xmlhttprequest();
  	var url = <?php echo base_url() . "index.php/show/realshowdiv/"?>;
  	xmlHttp.open("POST", url+id, true);
  	xmlHttp.onreadystatechange = update;
  	xmlHttp.send();
}
function update() {
  	if (xmlHttp.readyState == 4) {
		var response = xmlHttp.responseText;
		if (response!="old")
			document.getElementById("mainRefresh").innerHTML=response;
 	}
}