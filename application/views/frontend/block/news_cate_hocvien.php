<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$top1 = $rows[0]; ?>
<div class="goc_kn category">
    <h2 class="title_left"><?php echo $block['name'] ?></h2>
    <a href="<?php echo $cateDetail['share_url']; ?>" class="next_slide"><i class="fa fa-angle-right"></i></a>
    <a href="<?php echo $top1['share_url']?>">
        <img title="<?php echo $top1['title'] ?>" src="<?php echo getimglink($top1['images'],'size6',1); ?>" alt="<?php echo $top1['title'] ?>">
    </a>
    <div class="warp">
        <?php
        $i = 0;
        foreach ($rows as $rows){?>
        <div class="item <?php if($i == 0) echo 'active'; ?>">
            <div class="left">
                <strong><?php echo $rows['params']['ielts']; ?></strong>
                <span>IELTS</span>
            </div>
            <p>
                <a href="<?php echo $rows['share_url']; ?>"><?php echo $rows['title']?></a>
            </p>
        </div>
        <?php $i++; } ?>
        <a class="view-more" href="<?php echo $cateDetail['share_url']; ?>">Xem thêm &nbsp;<i class="fa fa-long-arrow-right"></i></a>
    </div>                    
</div>