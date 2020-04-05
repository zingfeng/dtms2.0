<div id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
			    <?php echo $this->load->view('common/breadcrumb');?> 
				
				<?php foreach ($arrVideo as $data) { ?>
					<?php if(!empty($data['list'])) { ?>
				        <div class="row"> 
						    <h1 class="col-md-12 title-list-video"><?php echo $data['name']?></h1>
							<ul class="list-video">
								<?php foreach($data['list'] as $row){?>
									<li>
										<div class="shadow">
											<div class="image">
												<div class="overlay"> 
													<div class="view-wrap">
													  <div class="view">
														<a class="shape" href="<?php echo $row['share_url'];?>"><i class="fa fa-play"></i></a>
													  </div>
													</div><!-- /.view-wrap -->
												</div><!-- /.overlay -->
												<figure><img src="<?php echo getimglink($row['images'],'size4');?>" alt="<?php echo $row['title'];?>"></figure>
											</div>
											<div class="caption">
												<h2><a href="<?php echo $row['share_url'];?>" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a></h2>
											</div>
										</div>	
									</li>
								<?php }?>
							</ul>
						</div>
					<?php } ?>
				<?php } ?>
					
				<?php echo $this->load->get_block('content'); ?> <!-- /.End --> 
			</div> 
			
			<div class="col-md-4 col-sm-4 col-xs-12">
			    <?php echo $this->load->get_block('right'); ?>
			    <div class="sidebar-block"> 
			        <div class="title-header-bl"><h2>FANPAGE</h2><span><i class="fa fa-angle-right arow"></i></span></div>
			        <div class="fb-page" data-href="<?php echo $this->config->item('facebook');?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $this->config->item('facebook');?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->config->item('facebook');?>">Facebook</a></blockquote></div>
			    </div><!--End-->
			</div>
        </div>
    </div>
</div>