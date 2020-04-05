<div class="ads">
    <?php if ($params['title'] == 1) { ?>
    <h2 class="title_block_ads"><?php echo $block['name']; ?></h2>
    <?php } ?>
    <?php $i = 1; foreach ($rows as $row){?>
    <div class="ads category center">
    	<a href="<?php echo $row['link']; ?>" title="<?php echo $row['name']; ?>">
        <img title="<?php echo $row['name'] ?>" src="<?php echo getimglink($row['images'],$params['thumb']) ?>" alt="<?php echo $row['name'] ?>">
    	</a>
    </div>
    <?php } ?>
</div>