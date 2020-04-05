<div class="chuyen_muc category">
	<h2 class="title_left"><?php echo $block['name'] ?></h2>
	<ul>
		<?php foreach ($rows as $row){?>
	  	<li>
	  		<a href="<?php echo $row['link'] ?>" title="<?php echo $row['name'];?>">
	  			<img src="<?php echo getimglink($row['icon'],'size5',3); ?>" alt="<?php echo $row['name'];?>" style="margin-right: 10px;"><?php echo $row['name'];?>
	  		</a>
	  	</li>
	  	<?php } ?>
	</ul>
</div>