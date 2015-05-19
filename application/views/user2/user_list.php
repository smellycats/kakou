<form id="pagerForm" method="post" action="<?php echo site_url('user/account_man'); ?>">
	<input type="hidden" name="status" value="${param.status}">
	<input type="hidden" name="keywords" value="${param.keywords}" />
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="${model.numPerPage}" />
	<input type="hidden" name="orderField" value="${param.orderField}" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('user/account_man'); ?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<label>用户名：</label>
					<input type="text" id="username" name="username" />
				</td>
				<td>
					<label>部门名称：</label>
					<input type="text" id="department" name="department" />
				</td>
			</tr>
		</table>
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
			</ul>
		</div>
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="<?php echo base_url(); ?>index.php/user/add" target="dialog" mask="false" height="250" width="300"><span>添加</span></a></li>
			<li><a class="delete" href="<?php echo base_url(); ?>index.php/user/delete/{sid_user}" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
			<li><a class="edit" href="<?php echo base_url(); ?>index.php/usdr/edit/{sid_user}" target="navTab"><span>修改</span></a></li>
			<li class="line">line</li>
			<li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="20">#</th>
				<th width="90">用户名</th>
				<th width="90">真实名</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($rows as $v) {
			?>
			<tr target="sid_user" rel="<?php echo $v['id']; ?>">
				<td>1</td>
				<td><?php echo $v['username']; ?></td>
				<td><?php echo $v['realname']; ?></td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20">20</option>
				<option value="50">50</option>
			</select>
			<span>条，共<?php echo $total;?>条</span>
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $total;?>" numPerPage="20" pageNumShown="5" currentPage="1"></div>

	</div>
</div>
