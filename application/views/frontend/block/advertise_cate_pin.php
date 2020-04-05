<?php foreach ($rows as $row){?>
	<div class="pinleft">
		<a href="<?php echo site_url($row['link']) ?>"><img src="<?php echo getimglink($row['images']) ?>" alt="<?php echo $row['name'] ?>" class="img-responsive"></a> 
	</div>
<?php } ?>