<section class="slide_top_home mb10">
    <div class="container">
        <div class="sub_title"><i class="icon icon-host"></i><?php echo $block['name'] ?></div>
        <?php if ($rows) { ?>
        <div class="owl-carousel">
        	<?php foreach($rows as $row){?>
            <h4><a href="<?php echo $row['share_url']; ?>" title="this"><?php echo $row['title']; ?></a></h4>
         	<?php } ?>
        </div>
    	<?php } ?>
    </div>
</section>