<div class="col-md-8 col-sm-8 col-xs-12">
    <?php echo $this->load->view('common/breadcrumb');?>
	<?php foreach($arrCate as $parent){?>
	<div class="col_box_test">
	    <div class="head-list-read"><h2><?php echo $parent['name'];?></h2></div>
		<?php if($parent['child']) { ?>
			<div class="row <?php echo $has_child ? 'box_mini_test' : ''?>">
			    <?php foreach($parent['child'] as $child){ ?>
			    	<?php if(!$child['child']) { ?>
			    		<div class="col-md-6">
						    <ul class="list_test">
								<li><div><a class="<?php echo $has_child ? 'title_test' : ''?>" href="<?php echo $child['share_url'] ?>"><?php echo $child['name'];?></a></div></li> 
							</ul>
						</div>  
			    	<?php }else { $child_skill = $child['child']; ?>
			    		<div class="title">
						     <h2><?php echo $child['name']?></h2>
							 <p>Chọn skill bạn muốn test để bắt đầu</p>
						</div>
			    	<?php } ?>
				<?php } ?>
			</div>	 
			<?php if($child_skill) { ?>
			<div class="row">
				<?php foreach($child_skill as $child){?>
				     <div class="col-md-6">
					    <ul class="list_test">
							 <li><div class="gray"><a href="<?php echo $child['share_url'] ?>"><?php echo $child['name'];?></a></div></li> 
						</ul>
					 </div>  
				<?php } ?>	
				<div class="col-md-6">
				    <ul class="list_test">
						 <li><div class="gray"><a href="javascript:void(0)">Hướng dẫn làm bài</a></div></li> 
					</ul>
			 	</div> 					 
			</div>
			<?php } ?>
		<?php } ?>
	</div><!-- End -->
	<?php }?>
	<?php echo $this->load->get_block('content'); ?> 
 
</div> 
<div class="col-md-4 col-sm-4 col-xs-12">
    <?php echo $this->load->get_block('right'); ?>
    <div class="sidebar-block"> 
        <div class="title-header-bl"><h2>FANPAGE</h2><span><i class="fa fa-angle-right arow"></i></span></div>
        <div class="fb-page" data-href="<?php echo $this->config->item('facebook');?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $this->config->item('facebook');?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->config->item('facebook');?>">Facebook</a></blockquote></div>
    </div><!--End-->
</div>