<section class="container clearfix m_height">
	<?php echo $this->load->view('common/breadcrumb');?>
	<div class="row">
		<div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
			<div class="warp_bg mb20">
				<div class="detail_tin">
					<h1><?php echo $newsDetail['title'];?></h1>
					<div class="topDetail float_width">
						<span class="spanDateTime fl">&nbsp;</span>
						<div class="block_share right">
							<div class="fb-share-button" data-href="<?php echo SITE_URL.$newsDetail['share_url']?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url?>" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                    		<div class="fb-like" data-href="<?php echo SITE_URL.$newsDetail['share_url']?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
							<!--<a class="btn_facebook" rel="nofollow" href="javascript:;" title="Like bài viết"><i class="fa fa-facebook"></i></a>
							<a class="btn_twitter" rel="nofollow" href="javascript:;" title="twitter"><i class="fa fa-twitter"></i></a>
							<a class="btn_google" rel="nofollow" href="javascript:;" title="Google"><i class="fa fa-google-plus"></i></a>
							<a class="btn_print" rel="nofollow" href="javascript:;" title="Gửi email"><i class="fa fa-print"></i></a>-->
						</div>
					</div>                  
					<p class="lead"><?php echo $newsDetail['description'];?></p>
					<div id="news_detail" class="ckeditor_reset_style">     
						<?php echo html_entity_decode($newsDetail['detail']);?>
						<?php echo $newsDetail['extra']?>
					</div>	
					<!--
					<div class="social">
						<p>SHARE ON</p>
						<a href=""><i class="fa fa-facebook"></i></a>
						<a href=""><i class="fa fa-twitter"></i></a>
						<a href=""><i class="fa fa-google-plus"></i></a>
						<a href=""><i class="fa fa-youtube-play"></i></a>
					</div>-->
					<div class="clearfix" style="border: 1px dotted #EDEDED; margin: 15px 0;"></div>


                    <?php
                    $data_content = array(
                        'type' => 2,
                        'target_id' => $target_id,
                    );
                    echo generateHtmlCommentBlock($data_content);
                    ?>


<!--					<div class="block-comment-face"> -->
<!--		                <div class="fb-comments" data-order-by="reverse_time" data-href="--><?php //echo SITE_URL.$newsDetail['share_url']?><!--" data-numposts="5" width="100%"></div>-->
<!--		                <div class="fb-share-button" data-href="--><?php //echo SITE_URL.$newsDetail['share_url']?><!--" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=--><?php //echo SITE_URL.$newsDetail['share_url']?><!--" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>-->
<!--		                <div class="fb-like" data-href="--><?php //echo SITE_URL.$newsDetail['share_url']?><!--" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>-->
<!--		            </div> End -->

				</div>                                      
			</div>



			<div class="ads center mb20">
				<?php echo $this->load->get_block('news_detail'); ?>
		 	</div>
		 <?php if($relate){?>
		 <!-- TIN QUAN TÂM --> 
		 <div class="warp_bg mb20 art_other">
			 <h2>Tin khác</h2>
			 <div class="list_learn">
				<div class="owl-carousel">
					<?php foreach($relate as $row) { ?>
					<div class="item">
						<div class="ava">
							<a href="<?php echo SITE_URL.$row['share_url']?>" title="<?php echo $row['title'];?>">
								<span class="thumb_img thumb_5x3"><img title="<?php echo $row['title'];?>" src="<?php echo getimglink($row['images'],'size4');?>" alt="<?php echo $row['title'];?>"></span>
							</a>
							<!--<span class="notifi"><i class="fa fa-exclamation-triangle"></i>Khuyến mại HOT</span>-->
						</div>
						<div class="content">
							<h3><a href="<?php echo SITE_URL.$row['share_url']?>" title=""><?php echo $row['title'];?></a></h3>         
						</div>
					</div>
					<?php } ?>
					                 
				</div>                                                
			</div>                     
		</div>
		<?php } ?>
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

<script type="text/javascript">
	$('iframe[src*="youtube.com"]').wrap('<div class="embed-responsive embed-responsive-16by9"/>');
    $('iframe[src*="youtube.com"]').addClass('embed-responsive-item');
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    	$(".detail_tin table").css('table-layout', 'fixed');
    	$(".detail_tin table td").css('width', 'auto').removeAttr("nowrap");
    }
</script>