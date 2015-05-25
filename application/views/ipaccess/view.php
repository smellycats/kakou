
<script type="text/javascript">
	$(function(){
		$("#ipaccess_view_page_num").val(<?php echo '"' . $rows . '"'?>);
	});
</script>

<form id="pagerForm" method="post" action="<?php echo site_url('syst/ip_access'); ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $rows; ?>" />
	<input type="hidden" name="sort" value="<?php echo $sort; ?>" />
	<input type="hidden" name="order" value="<?php echo $order; ?>" />
</form>


<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li>
				<a class="add" href="<?php echo base_url(); ?>index.php/ipaccess/add_view" 
					target="dialog" minable="true" rel="ipaccess_index_add" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="440" height="260" title="IP添加"><span>添加</span></a>
			</li>
			<li>
				<a class="edit" href="<?php echo base_url(); ?>index.php/ipaccess/edit_view?id={this_id}" 
					target="dialog" minable="true" rel="ipaccess_index_edit" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="440" height="260" title="IP编辑"><span>编辑</span></a>
			</li>
			<li>
				<a class="delete" href="<?php echo base_url(); ?>index.php/ipaccess/del?id={this_id}" 
					target="ajaxTodo" title="确定要删除吗?" ><span>删除</span></a>
			</li>
			<li class="line">line</li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="88">
		<thead>
			<tr>
				<th width="20">#</th>
				<th width="300">IP限制范围</th>
				<th width="30">状态</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = $offset + 1;?>
			<?php foreach ($result as $row): ?>
			<tr target="this_id" rel="<?php echo $row['id']; ?>">
				<td><?php echo $index; ?></td>
				<td><?php echo $row['minip'] . ' - ' . $row['maxip']; ?></td>
				<td><?php $banned_dict = array('0'=>'<span style="color:green">启用</span>','1'=>'<span style="color:orange">禁用</span>'); echo $banned_dict[$row['banned']]; ?></td>
			</tr>
			<?php $index += 1;?>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" id="notice_view_page_num" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20">20</option>
				<option value="50">50</option>
			</select>
			<span>条，共<?php echo ceil($total/$rows);?>页，共<?php echo $total;?>条</span>
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $total;?>" 
				numPerPage="<?php echo $rows; ?>" pageNumShown="5" currentPage="<?php echo $page; ?>">
		</div>

	</div>
</div>
