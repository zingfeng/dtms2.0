<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!-- page content -->
<div id="build_top" class="page-lists">
    <div class="clearfix"></div>
    <form class="ajax-order-form" action="" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <select id="buildtop_position" name="position" class="form-control" tabindex="-1">
                        <?php foreach ($arrPosition as $key => $p) { ?>
                        <option <?php if ($position == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $p; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo $this->lang->line("news_special"); ?></h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table table-bordered" id="table_special">
                            <thead id="checkbox_all">
                                <tr class="headings">
                                    <th width="20px">
                                        <input type="checkbox" class="inputCheckAll">
                                    </th>
                                    <th class="column-title"><?php echo $this->lang->line("news_tags"); ?></th>
                                    <th class="column-title no-link last" align="center" width="60px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
                                </tr>
                            </thead>
                            <tbody id="checkbox_list">
                                <?php 
                                if ($rows) {
                                foreach ($rows as $key => $row) { ?>
                                <tr data-id="<?php echo $row['tag_id']; ?>">
                                    <td class="a-center ">
                                        <input type="checkbox" value="<?php echo $row['tag_id']; ?>" class="inputSelect" name="cid[]">
                                    </td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td class="action last" align="center">
                                        <a class="tmp-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['tag_id']; ?>" href="javascript:void(0)" rel="nofollow">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } 
                                }?>
                                <tr class="tr-empty" <?php if ($rows) echo 'style="display: none"' ?>>
                                    <td colspan="4"><?php echo $this->lang->line("common_no_result"); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo $this->lang->line("common_mod_news_index"); ?></h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <?php if ($latest) { ?>
                    <div class="row">
                        <div class="col-xs-7 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <input type="text" id="filter_keyword"  value="" placeholder="<?php echo $this->lang->line("common_search_text"); ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-3 col-xs-12">
                            <button class="btn btn-success buildtop-suggest-button" data-url="<?php echo SITE_URL; ?>/news/suggest_tags" type="button"><?php echo $this->lang->line("common_search_text"); ?></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="table-responsive" id="table_suggest">
                        <table class="table table-striped jambo_table table-bordered">
                            <thead id="checkbox_all">
                                <tr class="headings">
                                    <th class="column-title"><?php echo $this->lang->line("news_tags"); ?></th>
                                    <th class="column-title no-link last" align="center" width="60px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
                                </tr>
                            </thead>
                            <tbody id="checkbox_list">
                                <?php 
                                foreach ($latest as $key => $row) { ?>
                                <tr data-id="<?php echo $row['tag_id']; ?>">
                                    <td><?php echo $row['name']; ?></td>
                                    <td class="action last" align="center">
                                        <a class="tmp-add" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_add"); ?>" data-title="<?php echo $row['name']; ?>" data-id="<?php echo $row['tag_id']; ?>" href="javascript:void(0)" rel="nofollow">
                                            <i class="fa fa-exchange" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($showMore) {?>
                        <div class="show_more">
                            <button class="btn btn-primary" type="button"><?php echo $this->lang->line("common_read_more"); ?></button>
                        </div>
                        <?php } ?>
                    </div>
                    <?php }else{?>
                    <div class="no-result"><?php echo $this->lang->line("common_no_result"); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="page-title scroll_action">
        <div class="title_left">
            <button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
            <?php if ($this->permission->check_permission_backend('add')) {?>
            <button class="btn btn-primary tmp-delete-all" type="button"><?php echo $this->lang->line("common_delete"); ?></button>
            <?php } ?>
            <button class="btn btn-success ajax-order-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
        </div>
    </div>
    </form>
</div>
<?php if (isset($filter)) {?>
<script type="text/javascript">
    var filtering = 1;
</script>
<?php } ?>
<script type="text/javascript">
    var arrCate = <?php echo json_encode($arrCate); ?>
</script>
<script type="text/javascript">
$(document).ready(function(){
    buildtop_script();
    buildtop_tags_script();
})
</script>