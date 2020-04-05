 <div class="warp_bg box_video category">
  	<h2 class="sub_title">Bí kíp từ cao thủ</h2>
  	<?php foreach($rows as $row) { ?>
  	<article class="art_item">
	    <div class="thumb_art">
	      	<a href="<?php echo $row['share_url']?>" title="<?php echo $row['title']?>">
	        	<span class="thumb_img thumb_5x3"><img title="<?php echo $row['title']?>" src="<?php echo getimglink($row['images'],'size1', 3) ?>" alt="<?php echo $row['title']?>"></span>
	      	</a>      
	    </div>
	    <div class="content">
	      	<h3 class="title_news">
	        	<a href="<?php echo $row['share_url']?>" title="<?php echo $row['title']?>"><?php echo $row['title']?></a>
	      	</h3>
	    </div>
  	</article>    
  	<?php } ?>                                                                                 
</div>     