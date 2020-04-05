<div class="col-md-8 col-sm-8 col-xs-12">
    <?php echo $this->load->view('common/breadcrumb');?>
	
    <div class="row mt-15"> 
		<ul class="list-project">
			<?php foreach($arrNews as $row){?>
			<li class="col-md-4 col-sm-6 col-xs-6">
				<div class="shadow">
					<div class="image">
						<figure><img title="<?php echo $row['title'];?>" src="<?php echo getimglink($row['images'],'size4');?>" alt="<?php echo $row['title'];?>"/></figure>
					</div>
					<div class="caption">
						<h2><a href="<?php echo $row['share_url'];?>"><?php echo $row['title'];?></a></h2>
					</div>
				</div>	
			</li>
			<?php }?>
		
		</ul>
		
	</div>      

	<?php echo $paging;?>	
		
	<?php echo $this->load->get_block('content'); ?> 
 
</div>
<div class="col-md-4 col-sm-4 col-xs-12">
    <?php echo $this->load->get_block('right'); ?>
    <div class="sidebar-block"> 
        <div class="title-header-bl"><h2>FANPAGE</h2><span><i class="fa fa-angle-right arow"></i></span></div>
        <div class="fb-page" data-href="<?php echo $this->config->item('facebook');?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $this->config->item('facebook');?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->config->item('facebook');?>">Facebook</a></blockquote></div>
    </div><!--End-->
</div>