<style type="text/css">
<!--
.STYLE1 {font-size: 12px}
-->
</style>
<table width="587" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#f3f3f3">
	<tr>
		<td bgcolor="#e7e7e7"><span class="STYLE1">提示操作</span></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#ffffff" style="font-size:12px"><?php echo $msg; ?></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#ffffff">
			<span class="STYLE1">
			<?php if($auto): ?>
			<script>
			function redirect($url)
			{
				location = $url;
			}
			setTimeout("redirect('<?php echo $goto; ?>');", 3000);
			</script>
			<a href="<?php echo $goto; ?>">如果您的浏览器没有自动跳转，请点这里继续</a>
			<?php endif; ?>
			</span>
		</td>
	</tr>
</table>
