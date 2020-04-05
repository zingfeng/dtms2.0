 <div class="ads_right">
 	<?php $i = 1; foreach ($rows as $row){?>
    <div class="box_ads">
	    <a href="<?php echo site_url($row['link']) ?>">
		     <img src="<?php echo getimglink($row['images'],$params['thumb']) ?>" alt="<?php echo $row['name'] ?>">
		</a>
	</div>
	<?php $i++;}?>
</div><!-- /End --> 