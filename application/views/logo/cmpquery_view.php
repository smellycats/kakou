
<script type="text/javascript">
	$(function(){
		$("#cmpquery_view_page_num").val(<?php echo '"' . $rows . '"'?>);
		$("#cmpquery_view_place").val(<?php echo '"'. $place .'"'?>);
		$("#cmpquery_view_dire").val(<?php echo '"'. $dire .'"'?>);
		$("#cmpquery_view_ppdm").val(<?php echo '"'. $ppdm .'"'?>);
		$("#cmpquery_view_ppdm2").val(<?php echo '"'. $ppdm2 .'"'?>);
		$("#cmpquery_view_st").val(<?php echo '"'. $st .'"'?>);
		$("#cmpquery_view_et").val(<?php echo '"'. $et .'"'?>);
		$("#cmpquery_view_number").val(<?php echo '"'. $number .'"'?>);
		$("#cmpquery_view_carnum").val(<?php echo '"'. $carnum .'"'?>);
		$("#cmpquery_view_confirm").val(<?php echo '"'. $confirm .'"'?>);
		$("#cmpquery_view_clppflag").val(<?php echo '"'. $clppflag .'"'?>);
	});
</script>

<form id="pagerForm" method="post" action="<?php echo site_url('logo/cmpquery'); ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>" />
	<input type="hidden" name="rows" value="<?php echo $rows; ?>" />
	<input type="hidden" name="sort" value="<?php echo $sort; ?>" />
	<input type="hidden" name="order" value="<?php echo $order; ?>" />

	<input type="hidden" name="place" value="<?php echo $place; ?>" />
	<input type="hidden" name="dire" value="<?php echo $dire; ?>" />
	<input type="hidden" name="ppdm" value="<?php echo $ppdm; ?>" />
	<input type="hidden" name="ppdm2" value="<?php echo $ppdm2; ?>" />
	<input type="hidden" name="st" value="<?php echo $st; ?>" />
	<input type="hidden" name="et" value="<?php echo $et; ?>" />
	<input type="hidden" name="number" value="<?php echo $number; ?>" />
	<input type="hidden" name="carnum" value="<?php echo $carnum; ?>" />
	<input type="hidden" name="confirm" value="<?php echo $confirm; ?>" />
	<input type="hidden" name="clppflag" value="<?php echo $clppflag; ?>" />
</form>


<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php echo site_url('logo/cmpquery'); ?>" method="post">
	<div class="searchBar">
		<table class="searchContent">
			<tr>
				<td>
					<label>卡口地点：</label>
					<select class="combox" id="cmpquery_view_place" name="place" >
						<option value="all">所有</option>
						<?php foreach ($sel_place as $row): ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['place']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<label>方向：</label>
					<select class="combox" id="cmpquery_view_dire" name="dire" >
						<option value="all">所有</option>
						<?php foreach ($sel_dire as $row): ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['dire']; ?></option>
						<?php endforeach; ?>
					</select>
				</td>

				<td>
					<label>信息确认：</label>
					<select class="combox" id="cmpquery_view_confirm" name="confirm" >
						<option value="all">所有</option>
						<option value="0">未确认</option>
						<option value="1">已确认</option>
					</select>
				</td>
				<td>
					<label>品牌是否匹配：</label>
					<select class="combox" id="cmpquery_view_clppflag" name="clppflag" >
						<option value="all">所有</option>
						<option value="0">不匹配</option>
						<option value="1">匹配</option>
					</select>
				</td>
				<td></td>
			<tr>
			<tr>
				<td>
					<span>开始时间：</span>
					<input type="text" id="cmpquery_view_st" name="st" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
				</td>
				<td>
					<span>结束时间：</span>
					<input type="text" id="cmpquery_view_et" name="et" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true"/>
				</td>
				<td>
					<label>车辆品牌：</label>
					<select class="combox" id="cmpquery_view_ppdm" name="ppdm" ref="cmpquery_view_ppdm2" refUrl="<?php echo base_url('index.php/logo/get_ppdm2?ppdm=');?>{value}">
						<option value="all">所有</option>
						<?php foreach ($sel_ppdm as $row): ?>
						<option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>
						<?php endforeach; ?>
					</select>
					<select class="combox" id="cmpquery_view_ppdm2" name="ppdm2">
						<option value="all">请选择主品牌</option>
					</select>
				</td>
				<td>
					<label>车牌号码：</label>
					<select class="combox" id="cmpquery_view_number" name="number">
						<?php foreach ($sel_number as $row): ?>
						<option value="<?php echo $row; ?>"><?php echo $row; ?></option>
						<?php endforeach; ?>
					</select>
					<input type="text" id="cmpquery_view_carnum" name="carnum" size="10"/>
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
				<a class="edit" href="<?php echo base_url(); ?>index.php/logo/cmpquery_detail?id={cmpquery_id}" 
					target="dialog" minable="true" rel="cmpquery_index_detail" max="false" drawable="false" resizable="false" 
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
	<table class="table" width="100%" layoutH="138">
		<thead>
			<tr>
				<th width="20">#</th>
				<th width="40">号牌号码</th>
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
				<th width="60">品牌是否匹配</th>
				<th width="40">信息确认</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = $offset + 1; ?>
			<?php foreach ($result as $row): ?>
			<tr target="cmpquery_id" rel="<?php echo $row['id']; ?>">
				<td><?php echo $index; ?></td>
				<td><?php echo $row['hphm']; ?></td>
				<td><?php echo $row['hpys']; ?></td>
				<td><?php echo $row['passtime']; ?></td>
				<td><?php echo $row['place']; ?></td>
				<td><?php echo $row['dire']; ?></td>
				<td><?php echo $row['clpp']; ?></td>
				<td><?php echo $row['clpp_son']; ?></td>
				<td><?php echo $row['cllx']; ?></td>
				<td><?php $clppflag_dict = array('0'=>'<span style="color:orange">否</span>','1'=>'<span style="color:gray">是</span>'); echo $clppflag_dict[$row['clppflag']]; ?></td>
				<td><?php $confirm_dict = array('0'=>'<span style="color:gray">否</span>','1'=>'<span style="color:green">是</span>'); echo $confirm_dict[$row['confirm']]; ?></td>
			</tr>
			<?php $index += 1; ?>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" id="cmpquery_view_page_num" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
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
