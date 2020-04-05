<section class="container clearfix m_height">
	<?php echo $this->load->view('common/breadcrumb');?>
	<div class="row">
		<div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
			<div class="warp_bg mb20">
				<div class="detail_tin">
					<h1><?php echo $expertDetail['name'];?></h1>
					<div class="topDetail float_width">
						<div class="block_share right">
							<!--<a class="btn_facebook" rel="nofollow" href="javascript:;" title="Like bài viết"><i class="fa fa-facebook"></i></a>
							<a class="btn_twitter" rel="nofollow" href="javascript:;" title="twitter"><i class="fa fa-twitter"></i></a>
							<a class="btn_google" rel="nofollow" href="javascript:;" title="Google"><i class="fa fa-google-plus"></i></a>
							<a class="btn_print" rel="nofollow" href="javascript:;" title="Gửi email"><i class="fa fa-print"></i></a>-->
							<div class="fb-share-button" data-href="<?php echo SITE_URL.$newsDetail['share_url']?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url?>" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                    		<div class="fb-like" data-href="<?php echo SITE_URL.$newsDetail['share_url']?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
						</div>
					</div>   
					<div class="clearfix"></div>              
					<div class="lead" style="background-color: rgb(255, 255, 204); padding: 10px; margin: 10px 0"><?php echo html_entity_decode($expertDetail['description']);?></div> 
					<div id="news_detail">     
						<?php echo html_entity_decode($expertDetail['detail']);?>
					</div>	
					<!--<div class="social">
						<p>SHARE ON</p>
						<a href=""><i class="fa fa-facebook"></i></a>
						<a href=""><i class="fa fa-twitter"></i></a>
						<a href=""><i class="fa fa-google-plus"></i></a>
						<a href=""><i class="fa fa-youtube-play"></i></a>
					</div>-->

					<div class="block-comment-face"> 
						<div class="fb-comments" data-order-by="reverse_time" data-href="<?php echo $url?>" data-numposts="5" width="100%"></div>
					</div>

				</div>                                      
			</div>
		<?php echo $this->load->get_block('left_content'); ?>
	</div>

	<div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12 mb20">
		<?php echo $this->load->get_block('right'); ?>
	</div>                        
</div>
  
</section>