<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="warp_bg category">
    <h2 class="title_left"><?php echo $block['name'] ?></h2>
    <a href="<?php echo $cateDetail['share_url']; ?>" class="next_slide"><i class="fa fa-angle-right"></i></a>
    <?php
    foreach ($rows as $rows){?>
    <article class="art_item">
      <div class="thumb_art">
        <a href="<?php echo $rows['share_url']; ?>" title="<?php echo $rows['title'] ?>">
          <span class="thumb_img thumb_5x3"><img title="<?php echo $rows['title'] ?>" src="<?php echo getimglink($rows['images'],'size1',3);?>" alt="<?php echo $rows['title'] ?>"></span>
        </a>      
      </div>
      <div class="content">
        <h3 class="title_news">
          <a href="<?php echo $rows['share_url']; ?>" title="<?php echo $rows['title'] ?>"><?php echo $rows['title'] ?></a>
        </h3>
        <!--<p>< ?php echo cut_text($rows['description'],180)?></p>-->
      </div>
    </article>
    <?php } ?>                                                                         
</div>