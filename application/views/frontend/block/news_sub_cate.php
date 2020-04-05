<div id="idtailieu" class="row">
    <?php if ($params['title']) { ?><h2 class="title_tailieu"><?php echo $block['name'] ?></h2><?php } ?>
    <div class="slide_tailieu">
	    <?php foreach($rows as $cate){?>
		<ul class="col-tailieu">
		    <h3><?php echo $cate['name'];?></h3>
	    	<?php foreach($cate['rows'] as $row){?>
			<li><a href="<?php echo $row['share_url'];?>"><?php echo $row['title'];?></a></li>
			<?php }?>
			
		</ul>
		<?php }?>
	</div>
</div><!-- /.End --> 