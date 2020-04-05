<div>
	<?php foreach ($rows as $key => $row) { ?>
	<a href="<?php echo $row['link']; ?>" title="<?php echo $row['name']; ?>">
		<img title="<?php echo $row['name']; ?>" src="<?php echo getimglink($row['images'],$params['thumb']) ?>" alt="<?php echo $row['name']; ?>">
	</a>
	<?php } ?>
</div>