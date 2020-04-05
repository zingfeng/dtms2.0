<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<table class="table table-striped jambo_table table-bordered">
    <thead id="checkbox_all">
        <tr class="headings">
            <th class="column-title"><?php echo $this->lang->line("news_name"); ?></th>
            <th class="column-title" width="150px"><?php echo $this->lang->line("news_cate"); ?></th>
            <th class="column-title no-link last" align="center" width="60px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
        </tr>
    </thead>
    <tbody id="checkbox_list">
        <?php 
        foreach ($rows as $key => $row) { ?>
        <tr data-id="<?php echo $row['news_id']; ?>">
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['original_cate']; ?></td>
            <td class="action last" align="center">
                <a class="tmp-add" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_add"); ?>" data-title="<?php echo $row['title']; ?>" data-cate="<?php  echo $row['original_cate']; ?>" data-id="<?php echo $row['news_id']; ?>" href="javascript:void(0)" rel="nofollow">
                    <i class="fa fa-exchange" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php if ($showMore) {?>
<div class="show_more" data-cate="<?php echo $cate_id; ?>" data-keyword="<?php echo $keyword; ?>">
    <button class="btn btn-primary" type="button"><?php echo $this->lang->line("common_read_more"); ?></button>
</div>
<?php } ?>