<div class="warp_bg document_ielts mb20">
	<h2 class="title_box_category"><i class="icon icon-document"></i><?php echo $block['name'] ?></h2>
	<div class="nav_category hidden-xs">
		<?php 
		$i = 0;
		foreach ($arrCate as $key => $cate) { 
			if ($i > 0) echo ' / '; 
			?>
			<a href="<?php echo SITE_URL . $cate['share_url']; ?>"><?php echo $cate['name']; ?></a>
		<?php $i++; } ?>
		<!-- <span class="hidden-xs">|</span> -->
		<!-- <a class="active hidden-xs" href="<?php echo $cateDetail['share_url']; ?>">Xem tất cả</a> -->
	</div>
	<div class="row">
		<?php 
		foreach ($rows as $key => $newsCateData) { ?>
        <div class="col-md-6 col-sm-6 col-xs-6 col-tn-12">
            <h3><span><?php echo $arrCate[$key]['name']; ?></span></h3>
            <?php foreach($newsCateData as $document){?>
			<a href="<?php echo SITE_URL . $document['share_url']; ?>"><i class="fa fa-chevron-circle-right"></i><?php echo $document['title']; ?></a>
			<?php } ?>
        </div>
    	<?php } ?>
	</div>
</div>