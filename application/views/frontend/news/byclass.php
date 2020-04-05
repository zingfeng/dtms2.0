<?php
	$top1 = array_shift($rows);	
	$top2 = array_slice($rows,0,3);
	$top3 = array_slice($rows,3,3);
	$arrNews = array_slice($rows,6);
?>
<div class="col-md-8 col-sm-8 col-xs-12">
    <?php echo $this->load->view('common/breadcrumb');?>
    <div class="td_content_news">
		<div class="grid-left">		 
		   <ul>
				<li class="big">
					<a href="<?php echo $top1['share_url'];?>" title="<?php echo $top1['title'];?>"><img src="<?php echo getimglink($top1['images'],'size6');?>" alt="<?php echo $top1['title'];?>"></a>
					<h3><a href="<?php echo $top1['share_url'];?>" title="<?php echo $top1['title'];?>"><?php echo $top1['title'];?></a></h3>
					
					<p class="sapo"><?php echo $top1['description'];?></p>
				</li>
				<?php foreach($top2 as $row){?>
				<li class="small">
					<span class="icon"></span><a href="<?php echo $row['share_url'];?>" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a>		                 
				</li>
				<?php }?>
			</ul>
		</div>
		
		<div class="grid-right">
			<ul class="listcatright">
				<?php foreach($top3 as $row){?>
				 <li>
					 <a href="<?php echo $row['share_url'];?>" title="<?php echo $row['title'];?>"><img src="<?php echo getimglink($row['images'],'size4');?>" alt=""></a>
					 <h3><a href="<?php echo $row['share_url'];?>" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a></h3>
				 </li>
			 	<?php }?>
			</ul>
		</div> 
	</div><!-- /.End -->
	<div class="col_news_cm">
		<?php foreach($arrNews as $row){?>
		<div class="thumbnail-news">
			<figure><img src="<?php echo getimglink($row['images'],'size4');?>" alt="<?php echo $row['title'];?>"></figure>
			<div class="caption">
				<h3><a href="<?php echo $row['share_url'];?>"><?php echo $row['title'];?></a></h3>
				<!--<span class="date"><i class="fa fa-clock-o"></i> < ?php echo date('d/m/Y',$row['publish_time']);?></span>-->
				<p><?php echo $row['description'];?> </p> 
			</div>  
		</div>
		<?php }?>
		<?php echo $paging;?>
	</div>
    <?php echo $this->load->get_block('content'); ?> 
</div>
<div class="col-md-4 col-sm-4 col-xs-12">
    <?php echo $this->load->get_block('right'); ?>
    <div class="sidebar-block"> 
        <div class="title-header-bl"><h2>FANPAGE</h2><span><i class="fa fa-angle-right arow"></i></span></div>
        <div class="fb-page" data-href="<?php echo $this->config->item('facebook');?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $this->config->item('facebook');?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->config->item('facebook');?>">Facebook</a></blockquote></div>
    </div><!--End-->
</div>