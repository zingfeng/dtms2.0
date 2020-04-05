<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="static_<?php echo $block['position'] ?>">
    <?php if ($params['title']) { ?>
        <h3 class="title"><?php echo $block['name'] ?></h3>
    <?php } ?>
    <div class="content">
        <?php echo html_entity_decode($block['content']) ?>
    </div>
</div>