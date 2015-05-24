
<script type="text/javascript">
	$(function(){
		$("#user_view_page_num").val(<?php echo '"' . $rows . '"'?>);
	});
</script>

<form id="pagerForm" method="post" action="<?php echo site_url('user/account_man'); ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $rows; ?>" />
	<input type="hidden" name="sort" value="<?php echo $sort; ?>" />
	<input type="hidden" name="order" value="<?php echo $order; ?>" />

	<input type="hidden" name="username" value="<?php echo $username; ?>">
	<input type="hidden" name="department" value="<?php echo $department; ?>">
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('user/account_man'); ?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<label>用户名：</label>
					<input type="text" id="username" name="username" value="<?php echo $username;?>" />
				</td>
				<td>
					<label>部门名称：</label>
					<input type="text" id="department" name="department" value="<?php echo $department;?>" />
				</td>
				<td>
					<div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div>
				</td>
			</tr>
		</table>
		<!--
		<div class="subBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
			</ul>
		</div>
		-->
	</div>
	</form>
</div>
<div class="pageContent">
	<div class="panelBar">
		<ul class="toolBar">
			<li>
				<a class="add" href="<?php echo base_url(); ?>index.php/user/user_add_view" 
					target="dialog" minable="true" rel="user_index_add" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="600" height="450" title="用户添加"><span>添加</span></a>
			</li>
			<li>
				<a class="edit" href="<?php echo base_url(); ?>index.php/user/user_edit_view?id={user_id}" 
					target="dialog" minable="true" rel="user_index_edit" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="600" height="450" title="用户编辑"><span>编辑</span></a>
			</li>
			<li>
				<a class="delete" href="<?php echo base_url(); ?>index.php/user/user_del?id={user_id}" 
					target="ajaxTodo" title="确定要删除吗?" ><span>删除</span></a>
			</li>
			<li class="line">line</li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="115">
		<thead>
			<tr>
				<th width="20">#</th>
				<th width="90">用户名</th>
				<th width="90">真实名</th>
				<th width="90">所属角色</th>
				<th width="90" orderField="department" 
					<?php if($sort == 'department'){echo 'class="'.$order.'"';}?>>部门</th>
				<th width="40">登录模式</th>
				<th width="60">最后登录IP</th>
				<th width="80" orderField="last_login"
					<?php if($sort == 'last_login'){echo 'class="'.$order.'"';}?>>最后登录时间</th>
				<th width="40" orderField="access_count"
				    <?php if($sort == 'access_count'){echo 'class="'.$order.'"';}?>>登录次数</th>
				<th width="30">状态</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = $offset + 1;?>
			<?php foreach ($result as $row): ?>
			<?php $access_type_dict = array('0'=>'账号密码','1'=>'<span style="color:green">数字证书</span>','2'=>'<span style="color:purple">混合模式</span>');?>
			<?php $banned_dict = array('0'=>'<span style="color:green">启用</span>','1'=>'<span style="color:orange">禁用</span>','2'=>'<span style="color:blue">混合模式</span>');?>
			<tr target="user_id" rel="<?php echo $row['id']; ?>">
				<td><?php echo $index; ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['realname']; ?></td>
				<td><?php echo $row['rolename']; ?></td>
				<td><?php echo $row['department']; ?></td>
				<td><?php echo $access_type_dict[$row['access_type']]; ?></td>
				<td><?php echo $row['last_ip']; ?></td>
				<td><?php echo $row['last_login']; ?></td>
				<td><?php echo $row['access_count']; ?></td>
				<td><?php echo $banned_dict[$row['banned']]; ?></td>
			</tr>
			<?php $index += 1;?>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" id="user_view_page_num" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
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
