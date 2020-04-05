<div class="ads_article">
	<?php foreach ($rows as $key => $row) { ?>
	<article>
		<img title="<?php echo $row['name']; ?>" src="<?php echo getimglink($row['images'],$params['thumb']) ?>" alt="<?php echo $row['name']; ?>">
		<div class="content">
		  <h3><a href="<?php echo $row['link']; ?>" title="this"><?php echo $row['name']; ?></a></h3>
		  <p><?php echo $row['description']; ?></p>
		  <a class="view-more" href="<?php echo $row['link']; ?>">Xem thêm &nbsp;<i class="fa fa-long-arrow-right"></i></a>
		</div>  
	</article>
	<?php } ?>
</div>