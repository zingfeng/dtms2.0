<div class="col-md-8 col-sm-8 col-xs-12">
    <?php echo $this->load->view('common/breadcrumb');?>
	
	<div class="col_box_baihoc">
	    <div class="head-list-read"><h2><?php echo $name;?></h2></div>  
		<ul>
			<?php foreach($rows as $row){?>
		    <li><a href="<?php echo $row['share_url'];?>"><?php echo $row['title'];?></a></li>
		    <?php }?>
		</ul>
	</div><!-- End -->
	<?php echo $paging; ?>
	
	<?php echo $this->load->get_block('content'); ?> 
 
</div> 
<div class="col-md-4 col-sm-4 col-xs-12">
	<?php echo $this->load->view('test/block/right_class_name',array('row' => $classDetail)); ?>
    <?php echo $this->load->get_block('right'); ?>
    <div class="sidebar-block"> 
        <div class="title-header-bl"><h2>FANPAGE</h2><span><i class="fa fa-angle-right arow"></i></span></div>
        <div class="fb-page" data-href="<?php echo $this->config->item('facebook');?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $this->config->item('facebook');?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->config->item('facebook');?>">Facebook</a></blockquote></div>
    </div><!--End-->
</div>