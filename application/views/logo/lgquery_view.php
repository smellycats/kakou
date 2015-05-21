
<script type="text/javascript">
	$(function(){
		$("#lgquery_view_page_num").val(<?php echo '"' . $rows . '"'?>);
		$("#user_add_username").val(<?php echo '"'. $user['username'] .'"'?>);
		$("#user_add_realname").val(<?php echo '"'. $user['realname'] .'"'?>);
		$("#user_add_role_id").val(<?php echo '"'. $user['role_id'] .'"'?>);
		$("#user_add_identity").val(<?php echo '"'. $user['identity'] .'"'?>);
		$("#user_add_phone").val(<?php echo '"'. $user['phone'] .'"'?>);
		$("#user_add_department").val(<?php echo '"'. $user['department'] .'"'?>);
		$("#user_add_limit_login_address").val(<?php echo '"'. $user['limit_login_address'] .'"'?>);
		$("#user_add_memo").val(<?php echo '"'. $user['memo'] .'"'?>);
	});
</script>

<form id="pagerForm" method="post" action="<?php echo site_url('user/account_man'); ?>">

	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $rows; ?>" />
	<input type="hidden" name="sort" value="<?php echo $orderField; ?>" />
	<input type="hidden" name="order" value="<?php echo $orderDirection; ?>" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('logo/lgquery'); ?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<label>卡口地点：</label>
					<select class="combox" id="lgquery_view_place" name="lgquery_view_place" >
						<option value="all">所有</option>
						<?php foreach ($sel_place as $row): ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['place']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<label>方向：</label>
					<select class="combox" id="lgquery_view_dire" name="lgquery_view_dire" >
						<option value="all">所有</option>
						<?php foreach ($sel_dire as $row): ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['dire']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<label>号牌颜色：</label>
					<select class="combox" id="lgquery_view_hpys" name="lgquery_view_hpys" >
						<option value="all">所有</option>
						<?php foreach ($sel_hpys as $row): ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['color']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<label>车辆品牌：</label>
					<select class="combox" id="lgquery_view_ppdm" name="lgquery_view_ppdm" ref="lgquery_view_ppdm2" refUrl="<?php echo base_url('index.php/logo/get_ppdm2?ppdm=');?>{value}">
						<option value="all">所有</option>
						<?php foreach ($sel_ppdm as $row): ?>
						<option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>
						<?php endforeach; ?>
					</select>
					<select class="combox" id="lgquery_view_ppdm2" name="lgquery_view_ppdm2">
						<option value="all">请选择主品牌</option>
					</select>
				</td>
			<tr>
			<tr>
				<td>
					<span>开始时间：</span>
					<input type="text" id="st" name="st" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
				</td>
				<td>
					<span>结束时间：</span>
					<input type="text" id="lgquery_view_et" name="et" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
				</td>
				<td>
					<label>车牌号码：</label>
					<select class="combox" id="lgquery_view_number" name="lgquery_view_number">
						<option value="all">所有</option>
						<?php foreach ($sel_number as $row): ?>
						<option value="<?php echo $row; ?>"><?php echo $row; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<input type="text" id="lgquery_view_carnum" name="lgquery_view_carnum" value="" />
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
			<li>
				<a class="add" href="<?php echo base_url(); ?>index.php/user/user_add_view" 
					target="dialog" minable="true" rel="user_index_add" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="600" height="500" title="用户添加"><span>添加</span></a>
			</li>
			<li>
				<a class="edit" href="<?php echo base_url(); ?>index.php/user/user_edit_view?id={user_id}" 
					target="dialog" minable="true" rel="user_index_edit" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="600" height="500" title="用户编辑"><span>编辑</span></a>
			</li>
			<li>
				<a class="delete" href="<?php echo base_url(); ?>index.php/user/user_del?id={user_id}" 
					target="ajaxTodo" title="确定要删除吗?" ><span>删除</span></a>
			</li>
			<li class="line">line</li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="20">#</th>
				<th width="50">号牌号码</th>
				<th width="30">号牌颜色</th>
				<th width="80">经过时间</th>
				<th width="100">卡口地点</th>
				<th width="40">方向</th>
				<th width="60" orderField="ppdm"
				 	<?php if($orderField == 'ppdm'){echo 'class="'.$orderDirection.'"';}?>>车辆主品牌</th>
				<th width="100" orderField="clpp"
					<?php if($orderField == 'clpp'){echo 'class="'.$orderDirection.'"';}?>>车辆子品牌</th>
				<th width="50" orderField="cllx"
				    <?php if($orderField == 'cllx'){echo 'class="'.$orderDirection.'"';}?>>车辆类型</th>
				<th width="30">车身颜色</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = $offset + 1;?>
			<?php foreach ($result as $row): ?>
			<tr target="lgquery_id" rel="<?php echo $row['id']; ?>">
				<td><?php echo $index; ?></td>
				<td><?php echo $row['hphm']; ?></td>
				<td><?php echo $row['hpys']; ?></td>
				<td><?php echo $row['passtime']; ?></td>
				<td><?php echo $row['place']; ?></td>
				<td><?php echo $row['dire']; ?></td>
				<td><?php echo $row['clpp']; ?></td>
				<td><?php echo $row['clpp_son']; ?></td>
				<td><?php echo $row['cllx']; ?></td>
				<td><?php echo $row['csys']; ?></td>
			</tr>
			<?php $index += 1;?>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" id="lgquery_view_page_num" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20">20</option>
				<option value="50">50</option>
			</select>
			<span>条，共<?php echo $total_page;?>页，共<?php echo $total;?>条</span>
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $total;?>" 
				numPerPage="<?php echo $rows; ?>" pageNumShown="5" currentPage="<?php echo $page; ?>">
		</div>

	</div>
</div>
