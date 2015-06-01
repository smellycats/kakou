<?php 
	if (!empty($role_name)){
?>
<script type="text/javascript">
	$(function(){
		$("#role_index_name").val('<?php echo $role_name; ?>');
		$("#role_index_name_pf").val('<?php echo $role_name; ?>');

	});
</script>
<?php
	}
?>
<form id="pagerForm" method="post" action="<?php echo site_url('role/view'); ?>">
	<input type="hidden" id="role_index_name_pf" name="role_index_name">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $numPerPage; ?>" />
	<input type="hidden" name="sort" value="<?php echo $orderField; ?>" />
	<input type="hidden" name="order" value="<?php echo $orderDirection; ?>" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('role/view'); ?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td style="width: 300px;">
					<label>角色名：</label>
					<input type="text" id="role_index_name" name="role_index_name" alt="请输入角色名" 
						maxlength="50" size="30" />
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
	<div class="panelBar">
		<ul class="toolBar">
			<li>
				<a class="add" href="<?php echo base_url(); ?>index.php/role/role_add_ip" 
					target="dialog" minable="true" rel="role_index_add" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="600" height="500" title="角色信息添加"><span>添加</span></a>
			</li>
			<li>
				<a class="edit" href="<?php echo base_url(); ?>index.php/role/role_edit_ip?rId={role_Id}" 
					target="dialog" minable="true" rel="role_index_edit" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="600" height="500" title="角色信息修改"><span>修改</span></a>
			</li>
			<li>
				<a class="delete" href="<?php echo base_url(); ?>index.php/role/role_delete?rId={role_Id}" 
					target="ajaxTodo" title="确定要删除吗?" ><span>删除</span></a>
			</li>
			<li class="line">line</li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="112">
		<thead>
			<tr>
				<th align="center" width="50px">#</th>
				<th align="center" 
					orderField="r.id" 
					<?php if($orderField == 'r.id'){ ?>class="<?php echo $orderDirection; ?>"<?php } ?>>角色名</th>
				<th align="center" width="90px">锁定</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if (empty($result)){
				?>
			<tr>
				<td colspan="8" style="color: red;">无任何记录！</td>
			</tr>	
				<?php
				} else {
					$js_var = 0;
					foreach ($result as $v) {
						$js_var ++;
					?>
			<tr align="center"  target="role_Id" rel="<?php echo $v['id']; ?>">
				<td><?php echo $js_var; ?></td>
				<td><?php echo $v['rolename']; ?></td>
				<td><?php echo $v['bannedname']; ?></td>
			</tr>		
					<?php	
					}
				}
			?>	
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option <?php if($numPerPage == 20){ ?>selected="selected"<?php } ?>>20</option>
				<option <?php if($numPerPage == 30){ ?>selected="selected"<?php } ?>>30</option>
				<option <?php if($numPerPage == 50){ ?>selected="selected"<?php } ?>>50</option>
			</select>
			<span>条，共<?php echo $totalPage;?>页，共<?php echo $total;?>条</span>
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $total;?>" 
				numPerPage="<?php echo $numPerPage; ?>" pageNumShown="5" 
				currentPage="<?php echo $page; ?>"></div>

	</div>
</div>
