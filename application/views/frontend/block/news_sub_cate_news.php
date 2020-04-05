<?php
$arrHotNews = array_slice($rows, 0, 3);
$arrNews = array_slice($rows, 3, 7);
?>
<div class="warp_bg mb20">
	<h2 class="title_box_category"><i class="icon icon-new"></i><?php echo $block['name'] ?></h2>
	<div class="nav_category hidden-xs">
		<?php 
		$i = 0;
		foreach ($arrCate as $key => $cate) { 
			if ($i > 0) echo ' / '; 
			?>
			<a href="<?php echo SITE_URL . $cate['share_url']; ?>"><?php echo $cate['name']; ?></a>
		<?php $i++; } ?>
		<span class="hidden-xs">|</span>
		<a class="active hidden-xs" href="<?php echo $cateDetail['share_url']; ?>">Xem tất cả</a>
	</div>
	<div class="list_learn row">
		<?php foreach($arrHotNews as $row){?>
		<div class="col-md-4 col-sm-4 col-xs-6 col-tn-12 mb20">
		  <div class="ava">
			<a href="<?php echo SITE_URL . $row['share_url']; ?>" title="<?php echo $row['title']; ?>">
			  <span class="thumb_img thumb_5x3"><img title="<?php echo $row['title']; ?>" src="<?php echo getimglink($row['images'],'size1',3);?>" alt="<?php echo $row['title']; ?>"></span>
			</a>
		  </div>
		  <div class="content">
			<h3><a href="<?php echo SITE_URL . $row['share_url']; ?>" title="<?php echo $row['title']; ?>"><?php echo $row['title']; ?></a></h3>        
		  </div>
		</div>
		<?php } ?>      
		<div class="clearfix"></div>                                        
	</div>

	<div class="small_article">
		<?php 
		$i = 0;

		foreach($arrNews as $row){
			if ($i % 2 == 0 && $i != 0) echo '<div class="clearfix"></div>';
		?>
		<article class="art_item">
		  <div class="thumb_art">
			<a class="thumb_img thumb_5x3" href="<?php echo SITE_URL . $row['share_url']; ?>" title="<?php echo $row['title']; ?>">
			  <img src="<?php echo getimglink($row['images'],'size1',3);?>" alt="<?php echo $row['title']; ?>">
			</a>      
		  </div>
		  <div class="content">
			<h3 class="title_news">
			  <a href="<?php echo SITE_URL . $row['share_url']; ?>" title="<?php echo $row['title']; ?>"><?php echo $row['title']; ?></a>
			</h3>
			<span class="date"><?php echo date('d/m/Y',$row['publish_time']); ?></span>
		  </div>
		</article>
		<?php 
		$i ++;
		} ?>         
	</div>                    
</div>