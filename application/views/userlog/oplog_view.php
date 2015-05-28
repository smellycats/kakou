
<script type="text/javascript">
	$(function(){
		$("#oplog_view_page_num").val("<?php echo $rows; ?>");
		$("#oplog_view_st").val("<?php echo $st; ?>");
		$("#oplog_view_et").val("<?php echo $et; ?>");
		$("#oplog_view_uname").val("<?php echo $uname; ?>");
	});
</script>

<form id="pagerForm" method="post" action="<?php echo site_url('oplog/view'); ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $rows; ?>" />
	<input type="hidden" name="sort" value="<?php echo $sort; ?>" />
	<input type="hidden" name="order" value="<?php echo $order; ?>" />

	<input type="hidden" name="st" value="<?php echo $st; ?>" />
	<input type="hidden" name="st" value="<?php echo $st; ?>" />
	<input type="hidden" name="uname" value="<?php echo $uname; ?>" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('oplog/view'); ?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<span>开始时间：</span>
					<input type="text" id="oplog_view_st" name="st" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
				</td>
				<td>
					<span>结束时间：</span>
					<input type="text" id="oplog_view_et" name="et" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
				</td>
				<td>
					<label>用户名：</label>
					<input type="text" id="oplog_view_uname" name="uname" />
				</td>
				<td>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div>
				</td>
			</tr>
		</table>
	</div>
	</form>
</div>
<div class="pageContent">
	<table class="table" width="100%" layoutH="88" nowrap="false">
		<thead>
			<tr>
				<th width="20">#</th>
				<th width="110">时间</th>
				<th width="100">用户名</th>
				<th width="600">操作</th>
				<th width="90">IP</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = $offset + 1;?>
			<?php foreach ($result as $row): ?>
			<tr target="this_id" rel="<?php echo $row['id']; ?>">
				<td><?php echo $index; ?></td>
				<td><?php echo $row['czsj']; ?></td>
				<td><?php echo $row['uname']; ?></td>
				<td><?php echo $row['memo']; ?></td>
				<td><?php echo $row['uip']; ?></td>
			</tr>
			<?php $index += 1; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" id="oplog_view_page_num" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20">20</option>
				<option value="50">50</option>
			</select>
			<span>条，共<?php echo ceil($total / $rows); ?>页，共<?php echo $total; ?>条</span>
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $total; ?>" 
				numPerPage="<?php echo $rows; ?>" pageNumShown="5" currentPage="<?php echo $page; ?>">
		</div>

	</div>
</div>
