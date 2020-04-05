<div class="box_doitac">
	<?php if ($params['title'] == 1) { ?>
    <h2 class="title_box_category"><?php echo $block['name']; ?></h2>
	<?php } ?>
    <div class="row">
        <?php $i = 1; foreach ($rows as $row){?>
        <div class="col-md-3 col-sm-3 col-xs-6 col-tn-12 mb20">
            <a href="<?php echo $row['link']; ?>" title="<?php echo $row['name']; ?>">
            <img class="sload" title="<?php echo $row['name'] ?>" src="<?php echo getimglink($row['images'],$params['thumb']) ?>" alt="<?php echo $row['name'] ?>">
            </a>
        </div>
        <?php } ?>
    </div>
</div>