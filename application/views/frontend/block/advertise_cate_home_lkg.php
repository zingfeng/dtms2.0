<div class="lich_kg row">
	<?php foreach ($rows as $row){?>
	<div class="col-md-4 col-xs-4 pd_nonet">
		<div class="mshoa_toeic">
			<div class="banner-wrapper ">
			    <div class="title"><h2><?php echo $row['name'] ?></h2></div>
				<a href="<?php echo site_url($row['link']) ?>"><img src="<?php echo getimglink($row['images'],$params['thumb']) ?>" alt="<?php echo $row['name'] ?>" class="img-responsive"></a> 
			</div>
		</div>
	</div>
	<?php }?>
</div>