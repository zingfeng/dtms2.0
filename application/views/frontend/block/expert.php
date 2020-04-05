<div class="row slide_expert mb20">
	<h2 class="title_box_category"><?php echo $block['name'] ?></h2>
	<div class="owl-carousel">
	  <?php
    	foreach ($rows as $rows){?>
	  <div class="item">
	  		<a href="<?php echo $rows['share_url']; ?>">
		  		<img title="" src="<?php echo getimglink($rows['images'],'size3',3);?>" alt="<?php echo $rows['name']; ?>">
		  	</a>
			<div class="overlay" onclick="location.href = '<?php echo SITE_URL . $rows['share_url']; ?>';">
			  <h3><?php echo $rows['name']; ?></h3>
			  <div class="desc">
			  <?php echo $rows['description']; ?>
			  </div>
			  <a class="view" href="<?php echo $rows['share_url']; ?>"><i class="fa fa-long-arrow-right"></i></a>
			</div>
	  </div>
	<?php } ?>
	         
	</div>            
</div>