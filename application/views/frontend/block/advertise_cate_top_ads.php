<?php foreach ($rows as $row){?>
	<section id="top_ads" class="width_100">
		<a href="<?php echo site_url($row['link']) ?>"><img src="<?php echo getimglink($row['images']) ?>" alt="<?php echo $row['name'] ?>"></a> 
	</section>
<?php } ?>