<div class="container">
	<div class="col_ads_t row">
		<div class="title_advs"><?php echo $block['name'] ?></div>
		<div class="slide_advs">
			<?php $i = 1; foreach ($rows as $row){?>
			<div><a href="<?php echo site_url($row['link']) ?>" title="<?php echo $row['name'] ?>"><img alt="<?php echo $row['name'] ?>" title="<?php echo $row['name'] ?>" src="<?php echo getimglink($row['images'],$params['thumb']) ?>"></a></div>
			<?php $i++;}?>
		</div>
	</div>
</div>