<div class="owl-carousel" id="adv_slide_<?php echo $block['position']; ?>">
    <?php foreach ($rows as $key => $row) { ?>
    <div class="item">
        <a href="<?php echo site_url($row['link']) ?>"><img src="<?php echo getimglink($row['images']) ?>" alt="<?php echo $row['name'] ?>"></a>
    </div>       
    <?php } ?>             
</div>