<?php
if ($total_row > 12 && $page == 1) {
	$top1 = array_shift($arrNews);	
	$top2 = array_slice($arrNews,0,2);
	$top3 = array_slice($arrNews,2,3);
	$arrNews = array_slice($arrNews,6);
}else{
	$top3 = array_slice($arrNews,0,3);
	$arrNews = array_slice($arrNews,3);
}
?>

<section class="container m_height clearfix dattt">
	<?php echo $this->load->view('common/breadcrumb');?>
	<div class="row">
		<div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
			<div class="warp_bg mb20">
				<?php if ($page == 1 && $top1) { ?>
					<!-- TOP NEW -->
					<section class="primary-new">
						<div class="big-new">
							<a href="<?php echo SITE_URL . $top1['share_url'];?>" title="<?php echo $top1['title'];?>">
								<img src="<?php echo getimglink($top1['images'],'size6');?>" alt="<?php echo $top1['title'];?>">
							</a>
							<div class="big-new__content">
								<h1 class="title">
									<a href="<?php echo SITE_URL . $top1['share_url'];?>" title="<?php echo $top1['title'];?>">
										<?php echo $top1['title'];?>
									</a>
								</h1>
								<p class="discription">
									<?php echo $top1['description'];?>
								</p>
							</div>
						</div>
						<?php if($top2) { ?>
							<div class="small-new">
								<?php $i==1;  foreach($top2 as $row) { ?>
									<div class="post-<?php echo $i?>">
										<a href="<?php echo SITE_URL . $row['share_url'];?>" title="<?php echo $row['title'];?>">
											<span class="thumb_img thumb_5x3"><img title="<?php echo $row['title'];?>" src="<?php echo getimglink($row['images'],'size1',3);?>" alt="<?php echo $row['title'];?>"></span>
										</a>
										<h2 class="small-new__title">
											<a href="<?php echo SITE_URL . $row['share_url'];?>" title="<?php echo $row['title'];?>">
												<?php echo cut_text($row['title'], 60);?>
											</a>
										</h2>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					</section>
					<!-- END TOP NEW -->
				<?php } ?>
			</div>
			<!-- LIST NEW -->
			<div class="list_learn row">
				<?php foreach($top3 as $row){?>
					<div class="col-md-4 col-sm-4 col-xs-6 col-tn-12 mb20">
						<div class="ava">
							<a href="<?php echo SITE_URL . $row['share_url'];?>" title="<?php echo $row['title'];?>">
								<span class="thumb_img thumb_5x3"><img title="<?php echo $row['title'];?>" src="<?php echo getimglink($row['images'],'size1',3);?>" alt="<?php echo $row['title'];?>"></span>
							</a>
							<!--<span class="notifi"><i class="fa fa-exclamation-triangle"></i>Khuyến mại HOT</span> -->
						</div>
						<div class="content">
							<h3><a href="<?php echo SITE_URL . $row['share_url'];?>" title="<?php echo $row['title'];?>"><?php echo cut_text($row['title'],70);?></a></h3>         
						</div>
					</div>
				<?php } ?>                                        
				
				<!-- END LIST NEW -->
				<?php foreach($arrNews as $row){?>
					<article class="art_item art_inner">
						<div class="thumb_art">
							<a class="thumb_img thumb_5x3" href="<?php echo SITE_URL . $row['share_url'];?>" title="<?php echo $row['title'];?>">
								<img src="<?php echo getimglink($row['images'],'size1',3);?>" alt="<?php echo $row['title'];?>">
							</a>      
						</div>
						<div class="content">
							<h3 class="title_news">
								<a href="<?php echo SITE_URL . $row['share_url'];?>" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a>
							</h3>
							<!--<span><i class="fa fa-clock-o"></i><?php echo convert_datetime($row['publish_time'],4);?></span>/<span><i class="fa fa-eye"></i> <?php echo $row['count_hit'];?></span>-->
							<p><?php echo $row['description'];?></p>
						</div>
					</article>   
				<?php } ?>                 
				<?php echo $paging; ?>
			</div>


			<?php echo $this->load->get_block('left_content'); ?>
		</div>

		<div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12 mb20">        
			<div class="category">
				<?php echo $this->load->view("block/contact")?>
			</div>
			<?php echo $this->load->get_block('right'); ?>
		</div>
	</div>   
</section>