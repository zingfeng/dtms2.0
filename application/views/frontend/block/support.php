<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="<?php echo ($params['class']) ? $params['class'] : 'support' ?>">
    <?php if ($params['title']) { ?>
        <h3 class="title"><?php echo $block['name'] ?></h3>
    <?php } ?>
    <ul>
    <?php foreach ($rows as $rows){?>
        <li class="item">
            <a rel="nofollow" href="ymsgr:sendim?<?php echo $rows['yahoo']?>"><img src="http://opi.yahoo.com/online?u=<?php echo $rows['yahoo']?>&amp;m=g&amp;t=5&amp;l=us" align="left" title="<?php echo $rows['job']?>"/></a><?php echo $rows['job']?>
            <a rel="nofollow" href="skype:<?php echo $rows['skype']?>?call"><img height="34" align="left" width="34" alt="<?php echo $rows['job']?>" style="border: none;" src="http://download.skype.com/share/skypebuttons/buttons/call_blue_transparent_34x34.png"></a>
        </li>
    <?}?>
    </ul>
</div>