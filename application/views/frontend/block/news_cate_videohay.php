<?php $first = array_shift($rows); ?>
<div class="warp_bg box_video category">
  <h2 class="sub_title">Video hay cho bạn</h2>
  <article class="art_item art_big">
    <div class="thumb_art">
      <a href="<?php echo $first['share_url']?>" title="<?php echo $first['title']?>">
        <span class="thumb_img thumb_5x3"><img title="<?php echo $first['title']?>" src="<?php echo getimglink($first['images'],'size6', 3) ?>" alt="<?php echo $first['title']?>"></span>
        <span class="play"><i class="fa fa-youtube-play"></i></span>
      </a>      
    </div>
  </article>
  <?php if($rows) { ?>
  <div class="scrollbar-inner">
    <?php foreach($rows as $row) { ?>
    <article class="art_item">
      <div class="thumb_art">
        <a href="<?php echo $row['share_url']?>" title="<?php echo $row['title']?>">
          <span class="thumb_img thumb_5x3"><img title="<?php echo $row['title']?>" src="<?php echo getimglink($row['images'],'size1', 3) ?>" alt="<?php echo $row['title']?>"></span>
          <span class="play"><i class="fa fa-youtube-play"></i></span>
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
  <?php } ?>                                                                           
</div>