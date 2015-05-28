
<script type="text/javascript">
	$(function(){
		$("#lgquery_view_page_num").val(<?php echo '"' . $rows . '"'?>);
		$("#lgquery_view_place").val(<?php echo '"'. $place .'"'?>);
		$("#lgquery_view_dire").val(<?php echo '"'. $dire .'"'?>);
		$("#lgquery_view_hpys").val(<?php echo '"'. $hpys .'"'?>);
		$("#lgquery_view_ppdm").val(<?php echo '"'. $ppdm .'"'?>);
		$("#lgquery_view_ppdm2").val(<?php echo '"'. $ppdm2 .'"'?>);
		$("#lgquery_view_cllx").val(<?php echo '"'. $cllx .'"'?>);
		$("#lgquery_view_st").val(<?php echo '"'. $st .'"'?>);
		$("#lgquery_view_et").val(<?php echo '"'. $et .'"'?>);
		$("#lgquery_view_number").val(<?php echo '"'. $number .'"'?>);
		$("#lgquery_view_carnum").val(<?php echo '"'. $carnum .'"'?>);
	});
</script>

<form id="pagerForm" method="post" action="<?php echo site_url('logo/lgquery'); ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $rows; ?>" />
	<input type="hidden" name="sort" value="<?php echo $sort; ?>" />
	<input type="hidden" name="order" value="<?php echo $order; ?>" />

	<input type="hidden" name="place" value="<?php echo $place; ?>" />
	<input type="hidden" name="dire" value="<?php echo $dire; ?>" />
	<input type="hidden" name="hpys" value="<?php echo $hpys; ?>" />
	<input type="hidden" name="ppdm" value="<?php echo $ppdm; ?>" />
	<input type="hidden" name="ppdm2" value="<?php echo $ppdm2; ?>" />
	<input type="hidden" name="cllx" value="<?php echo $cllx; ?>" />
	<input type="hidden" name="st" value="<?php echo $st; ?>" />
	<input type="hidden" name="et" value="<?php echo $et; ?>" />
	<input type="hidden" name="number" value="<?php echo $number; ?>" />
	<input type="hidden" name="carnum" value="<?php echo $carnum; ?>" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('logo/lgquery'); ?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<label>卡口地点：</label>
					<select class="combox" id="lgquery_view_place" name="place" >
						<option value="all">所有</option>
						<?php foreach ($sel_place as $row): ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['place']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<label>方向：</label>
					<select class="combox" id="lgquery_view_dire" name="dire" >
						<option value="all">所有</option>
						<?php foreach ($sel_dire as $row): ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['dire']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<label>号牌颜色：</label>
					<select class="combox" id="lgquery_view_hpys" name="hpys" >
						<option value="all">所有</option>
						<?php foreach ($sel_hpys as $row): ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['color']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<label>车辆类型：</label>
					<select class="combox" id="lgquery_view_cllx" name="cllx" >
						<option value="all">所有</option>
						<?php foreach ($sel_cllx as $row): ?>
						<option value="<?php echo $row['code']; ?>"><?php echo $row['code'] . $row['name']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td></td>
			<tr>
			<tr>
				<td>
					<span>开始时间：</span>
					<input type="text" id="lgquery_view_st" name="st" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
				</td>
				<td>
					<span>结束时间：</span>
					<input type="text" id="lgquery_view_et" name="et" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
				</td>
				<td>
					<label>车辆品牌：</label>
					<select class="combox" id="lgquery_view_ppdm" name="ppdm" ref="lgquery_view_ppdm2" refUrl="<?php echo base_url('index.php/logo/get_ppdm2?ppdm=');?>{value}">
						<option value="all">所有</option>
						<?php foreach ($sel_ppdm as $row): ?>
						<option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>
						<?php endforeach; ?>
					</select>
					<select class="combox" id="lgquery_view_ppdm2" name="ppdm2">
						<option value="all">请选择主品牌</option>
					</select>
				</td>
				<td>
					<label>车牌号码：</label>
					<select class="combox" id="lgquery_view_number" name="number">
						<?php foreach ($sel_number as $row): ?>
						<option value="<?php echo $row; ?>"><?php echo $row; ?></option>
						<?php endforeach; ?>
					</select>
					<input type="text" id="lgquery_view_carnum" name="carnum" size="10" />
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
				<a class="edit" href="<?php echo base_url(); ?>index.php/logo/lgquery_detail?id={lgquery_id}" 
					target="dialog" minable="true" rel="lgquery_index_detail" max="false" drawable="false" resizable="false" 
					maxable="true" mask="true" width="600" height="500" title="查看详细信息"><span>查看</span></a>
			</li>
			<li class="line">line</li>
			<li>
				<a class="icon" href="<?php echo base_url(); ?>index.php/export/export_excel" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a>
			</li>
			<li>
				<a class="icon" href="<?php echo base_url(); ?>index.php/export/export_img" target="dwzExport" targetType="navTab" title="实要导出这些图片吗?"><span>导出图片</span></a>
			</li>
		</ul>
	</div>
	<table class="table" width="100%" layoutH="145">
		<thead>
			<tr>
				<th width="20">#</th>
				<th width="50">号牌号码</th>
				<th width="30">号牌颜色</th>
				<th width="80">经过时间</th>
				<th width="100">卡口地点</th>
				<th width="40">方向</th>
				<th width="60" orderField="ppdm"
				 	<?php if($sort == 'ppdm'){echo 'class="'.$order.'"';}?>>车辆主品牌</th>
				<th width="100" orderField="clpp"
					<?php if($sort == 'clpp'){echo 'class="'.$order.'"';}?>>车辆子品牌</th>
				<th width="50" orderField="cllx"
					<?php if($sort == 'cllx'){echo 'class="'.$order.'"';}?>>车辆类型</th>
				<th width="30" orderField="csys"
					<?php if($sort == 'csys'){echo 'class="'.$order.'"';}?>>车身颜色</th>
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
			<?php $_SESSION['lgquery']['ids'] = array(); ?>
			<?php array_push($_SESSION['lgquery']['ids'], $row['id']); ?>
			<?php $index += 1; ?>
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
			<span>条，共<?php echo  ceil($total / $rows);?>页，共<?php echo $total;?>条</span>
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $total;?>" 
				numPerPage="<?php echo $rows; ?>" pageNumShown="5" currentPage="<?php echo $page; ?>">
		</div>

	</div>
</div>
