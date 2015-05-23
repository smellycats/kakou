
<script type="text/javascript">
	$(function(){
		$("#cmpquery_view_clppflag").val(<?php echo '"'. $clppflag .'"'?>);
	});
</script>

<form id="pagerForm" method="post" action="<?php echo site_url('logo/cmpquery'); ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $rows; ?>" />
	<input type="hidden" name="sort" value="<?php echo $sort; ?>" />
	<input type="hidden" name="order" value="<?php echo $order; ?>" />

	<input type="hidden" name="clppflag" value="<?php echo $clppflag; ?>" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('logo/cmpquery'); ?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<label>品牌是否匹配：</label>
					<select class="combox" id="cmpquery_view_clppflag" name="clppflag" >
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

	
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li>
				<a class="edit" href="<?php echo base_url(); ?>index.php/logo/cmpquery_detail?id={cmpquery_id}" 
					target="dialog" minable="true" rel="cmpquery_index_detail" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="600" height="500" title="查看详细信息"><span>查看</span></a>
			</li>

		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="22"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
				<th width="20">#</th>
				<th width="800">卡口地点</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = $offset + 1; ?>
			<?php foreach ($result as $row): ?>
			<tr target="real_select_id" rel="<?php echo $row['id']; ?>">
				<td><input name="ids" value="<?php echo $row['id']; ?>" type="checkbox"></td>
				<td><?php echo $index; ?></td>
				<td><?php echo $row['place']; ?></td>
			</tr>
			<?php $index += 1; ?>
			<?php endforeach; ?>
		</tbody>
	</table>

</div>
