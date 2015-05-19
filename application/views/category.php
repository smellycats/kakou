<div id="bodyBottom">
<!--news start -->
<!--news end -->
<!--services start -->
<div id="service">
<h2><?php foreach ($category_name as $row) echo $row->category_name; ?></h2>
<ul>
<?php foreach ($article_list as $row): ?>
<li><?php echo anchor('home/content/' . $row->id, $row->title); ?></li>
<?php endforeach; ?>
</ul>
<div id="page_style"><a><?php echo $this->pagination->create_links(); ?></a></div>
<br class="spacer" />
</div>
<!--services end -->
<!--member start -->
<!--member end -->
<br class="spacer" />
</div>
<!--bodyBottom end -->
