
<script type="text/javascript">
	 //遍历被选中CheckBox元素的集合 得到Value值    
	 function treeclick()  {    
		var oidStr=""; //定义一个字符串用来装值的集合    
		
		//jquery循环t2下的所有选中的复选框    
		$("#t2 input:checked").each(function(i,a){    
		    //alert(a.value);    
		    oidStr +=a.value+',';  //拼接字符串    
		});
		$("#real_select_places").val(oidStr.substring(0, oidStr.length - 1));
	 }    
</script>

<div id="resultBox"></div>
<div id="json_data"></div>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('logo/select'); ?>" method="post">
	<div id="t2" class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<label>品牌是否匹配：</label>
					<select class="combox" id="real_select_view_matchflag" name="matchflag" >
						<option value="all">所有</option>
						<option value="0">不匹配</option>
						<option value="1">匹配</option>
					</select>
				</td>
				<td>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div>
				</td>
			<tr>

		</table>
		<input id="real_select_places" name="places" type="hidden" />
		<ul class="tree treeFolder treeCheck expand" oncheck="treeclick">
			<li><a tname="place" tvalue="0">卡口地点</a>
				<ul>
					<?php foreach ($sel_places as $row): ?> 
					<li><a tname="place" tvalue="<?php echo $row['id']; ?>"><?php echo $row['place']; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
		</ul>
	
	</div>
	</form>
</div>

