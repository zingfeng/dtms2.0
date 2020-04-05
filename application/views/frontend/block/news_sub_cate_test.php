<div class="col_toeic_online news_sub_cate_test"> 
	<div class="td_heading">
		<?php if ($params['title']) { ?>
		<h2><a href="javascript:;"><?php echo $block['name'] ?></a></h2>
		<?php } ?>
		<ul>
			<li class="btn-group-mobile dropdown">
				<button class="btn btn-default btn-pd dropdown-toggle" title="" data-toggle="dropdown" aria-expanded="false"><span><?php echo $rows[0]['name']; ?></span><span class="caret"></span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right">
					<?php $i = 1; foreach($rows as $cate){?>
					 <li <?php if ($i == 1) echo 'class="active"'; ?>><a role="tab" href="#toeic<?php echo $cate['cate_id'];?>" data-toggle="tab"><?php echo $cate['name'];?></a></li>
					 <?php $i++;}?>
				</ul>
			</li>
		</ul>
		<ul class="tabs-links">
			<?php $i = 1; foreach($rows as $cate){?>
			 <li class="<?php echo ($i == 1) ? 'active':'';?>"><a role="tab" href="#toeic<?php echo $cate['cate_id'];?>" data-toggle="tab"><?php echo $cate['name'];?></a></li>
			 <?php $i++;}?>
		</ul>
	</div>
	
    <div class="tab-content">	
    	<?php $i = 1; foreach($rows as $cate){?>
		<div class="tab-pane fade in <?php echo ($i == 1) ? 'active':'';?>" id="toeic<?php echo $cate['cate_id'];?>">		
			<?php if($cateSub[$cate['cate_id']]){?>			
			<ul class="tabs-links-folder">
				<?php foreach($cateSub[$cate['cate_id']] as $sub){?>
				 <li><a href="<?php echo $sub['share_url'];?>"><?php echo $sub['name'];?></a></li>
				 <?php }?>
			</ul>
			<?php }?>
			<?php if($cate['rows']){?>	
			<div class="row"> 
				<ul class="list-project">
					<?php 
					$i = 0;
					foreach($cate['rows'] as $row){
					if ($i != 0 && $i % 4 == 0) echo '<li class="clearfix hidden-xs hidden-sm"></li>';
					if ($i != 0 && $i % 3 == 0) echo '<li class="clearfix visible-sm"></li>';
					if ($i != 0 && $i % 2 == 0) echo '<li class="clearfix visible-xs"></li>';
					?>
					<li class="col-md-3 col-sm-4 col-xs-6">
						<div class="shadow">
							<div class="image">
			
								<figure><a href="<?php echo $row['share_url'];?>"><img title="<?php echo $row['title'];?>" src="<?php echo getimglink($row['images'],'size3');?>" alt="<?php echo $row['title'];?>"/></a></figure>
							</div>
							<div class="caption">
								<h2><a href="<?php echo $row['share_url'];?>"><?php echo $row['title'];?></a></h2>
							</div>
						</div>	
					</li>
					<?php $i++;}?>
				</ul>
			</div>
			<?php }?>    
		</div>
		<?php $i++;}?>
	</div><!-- /.End-tab --> 
	
</div><!-- /.End --> 
<?php
$html = <<<HTML
<script type="text/javascript">
	$(".dropdown-menu li a").click(function(){
	  	var selText = $(this).text();
	  	$(this).parents('.btn-group-mobile').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
	});
</script>
HTML;
$this->load->push_section('script','block_news_dropdown',$html);
?>