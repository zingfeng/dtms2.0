<div class="warp_bg mb20">
	<h2 class="title_box_category"><i class="icon icon-book"></i><?php echo $block['name'] ?></h2>
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
	<div class="list_book row">
		<?php foreach($rows as $document){?>
			<div class="col-md-3 col-sm-3 col-xs-6 col-tn-12">
			  <div class="ava">
				<a class="thumb_img thumb_2x3" href="<?php echo SITE_URL . $document['share_url']; ?>" title="<?php echo $document['title']; ?>">
				  <img src="<?php echo getimglink($document['images'],'size2',3);?>" alt="<?php echo $document['title']; ?>">
				</a>
			  </div>
			  <div class="content">
				<h3><a href="<?php echo SITE_URL . $document['share_url']; ?>" title="<?php echo $document['title']; ?>"><?php echo $document['title']; ?></a></h3>
				<a class="down" href="<?php echo SITE_URL . $document['share_url']; ?>"><i class="fa fa-download"></i>Tải miễn phí</a>             
			  </div>
			</div>
		<?php } ?>                                                                
	</div>                   
</div>