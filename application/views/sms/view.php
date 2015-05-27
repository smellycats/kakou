
<script type="text/javascript">
	$(function(){
		$("#sms_view_page_num").val("<?php echo $rows; ?>");
	});
</script>

<form id="pagerForm" method="post" action="<?php echo site_url('sms/view'); ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $rows; ?>" />
	<input type="hidden" name="sort" value="<?php echo $sort; ?>" />
	<input type="hidden" name="order" value="<?php echo $order; ?>" />
</form>

<div class="pageHeader">
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li>
				<a class="add" href="<?php echo base_url(); ?>index.php/sms/addView" 
					target="dialog" minable="true" rel="sms_index_add" max="false" drawable="true" resizable="false" 
					maxable="true" mask="true" width="420" height="300" title="短信添加"><span>添加</span></a>
			</li>
			<li>
				<a class="edit" href="<?php echo base_url(); ?>index.php/sms/editView?id={this_id}" 
					target="dialog" minable="true" rel="sms_index_edit" max="false" drawable="true" resizable="false" 
					maxable="true" mask="true" width="420" height="300" title="短信编辑"><span>编辑</span></a>
			</li>
			<li>
				<a class="delete" href="<?php echo base_url(); ?>index.php/sms/del?id={this_id}" 
					target="ajaxTodo" title="确定要删除吗?" ><span>删除</span></a>
			</li>
			<li class="line">line</li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="88">
		<thead>
			<tr>
				<th width="20">#</th>
				<th width="600">电话号码</th>
				<th width="200">备注</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = $offset + 1;?>
			<?php foreach ($result as $row): ?>
			<tr target="this_id" rel="<?php echo $row['id']; ?>">
				<td><?php echo $index; ?></td>
				<td><?php echo $row['tel']; ?></td>
				<td><?php echo $row['mark']; ?></td>
			</tr>
			<?php $index += 1;?>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" id="sms_view_page_num" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20">20</option>
				<option value="50">50</option>
			</select>
			<span>条，共<?php echo ceil($total / $rows);?>页，共<?php echo $total; ?>条</span>
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $total; ?>" 
				numPerPage="<?php echo $rows; ?>" pageNumShown="5" currentPage="<?php echo $page; ?>">
		</div>

	</div>
</div>
