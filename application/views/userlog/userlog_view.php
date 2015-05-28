
<script type="text/javascript">
	$(function(){
		$("#userlog_view_page_num").val("<?php echo $rows; ?>");
	});
</script>

<form id="pagerForm" method="post" action="<?php echo site_url('userlog/view'); ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $rows; ?>" />
	<input type="hidden" name="sort" value="<?php echo $sort; ?>" />
	<input type="hidden" name="order" value="<?php echo $order; ?>" />

	<input type="hidden" name="username" value="<?php echo $username; ?>">
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('userlog/view'); ?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<label>用户名：</label>
					<input type="text" id="userlog_view_username" name="username" value="<?php echo $username; ?>" />
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
	<table class="table" width="100%" layoutH="88">
		<thead>
			<tr>
				<th width="10">#</th>
				<th width="90">用户名</th>
				<th width="90">所属角色</th>
				<th width="90" orderField="created"
					<?php if($sort == 'created'){echo 'class="'.$order.'"';}?>>创建时间</th>
				<th width="90">最后登录IP</th>
				<th width="90" orderField="last_login"
					<?php if($sort == 'last_login'){echo 'class="'.$order.'"';}?>>最后登录时间</th>
				<th width="40" orderField="access_count"
				    <?php if($sort == 'access_count'){echo 'class="'.$order.'"';}?>>登录次数</th>
				<th width="30">状态</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = $offset + 1;?>
			<?php foreach ($result as $row): ?>
			<?php $banned_dict = array('0'=>'<span style="color:green">启用</span>','1'=>'<span style="color:brown">禁用</span>');?>
			<tr target="this_id" rel="<?php echo $row['id']; ?>">
				<td><?php echo $index; ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['rolename']; ?></td>
				<td><?php echo $row['created']; ?></td>
				<td><?php echo $row['last_ip']; ?></td>
				<td><?php echo $row['last_login']; ?></td>
				<td><?php echo $row['access_count']; ?></td>
				<td><?php echo $banned_dict[$row['banned']]; ?></td>
			</tr>
			<?php $index += 1; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" id="userlog_view_page_num" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
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
