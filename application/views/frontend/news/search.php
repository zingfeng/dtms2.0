<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="news_list">
    <div class="mod_title"><?php echo $this->lang->line('search_keyword_for').'"'.$keyword.'"'?> <span><?php echo $total?><?php echo $this->lang->line('search_result')?></span></div>
    <div class="main_content">
    <?php if (!empty($rows)){
        $i = 1;
        foreach ($rows as $rows){?>
        <div class="item fl <?php if ($i % 2 == 1) echo 'left '; if ($i <= 2) echo 'first'?>">
            <div class="border_left">
            <?php
            if ($rows['images'] != ''){
                echo anchor('news/detail/0/'.$rows['news_id'].'/'.set_alias_link($rows['title']),img(array('src' => $api_resize.$rows['images'],'align' => 'left','rel'=>$rows['title'])));  
            }
            ?>
            <?php echo anchor('news/detail/0/'.$rows['news_id'].'/'.set_alias_link($rows['title']),$rows['title'],'class="title"'); ?>
            <div class="description"><?php echo cut_text($rows['description'],200)?></div>
            </div>
        </div>
        <?php $i ++;
        }
    }
    echo $paging;
    ?>
    </div>
</div>