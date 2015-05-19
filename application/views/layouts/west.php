			<div class="easyui-accordion" data-options="fit:true,border:false">
				<?php if($f_datas != null): ?>
				<?php foreach ($f_datas as $f_data): ?>
				<div title="<?php echo $f_data['cname'];?>" style="overflow:auto;padding:10px;">
					<ul class="easyui-tree">
						<?php foreach ($f_data['childrens'] as $f_childrens_data):?>
						<li iconCls="icon-tool2"><a class="e-link" onclick="addTab('<?php echo $f_childrens_data['cname'];?>','<?php echo base_url(). "index.php/".$f_data['name']."/".$f_childrens_data['name']."/";?>')"><?php echo $f_childrens_data['cname'] ?></a></li>
						<?php endforeach;?>
					</ul>
				</div>	
				<?php endforeach;?>
				<?php endif;?>
			</div>