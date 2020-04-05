<div class="row">
    <div class="col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Tài liệu khóa học</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table table-bordered" id="table_special">
                        <thead>
                            <tr class="headings">
                                <th class="a-center ">
                                    <input type="checkbox" value="<?php echo $row['news_id']; ?>" class="inputSelect" name="cid[]">
                                </th>
                                <th class="column-title">Tài liệu</th>
                                <th class="column-title no-link last" align="center" width="60px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
                            </tr>
                        </thead>
                        <tbody id="checkbox_list">
                            <?php 
                            if ($rows) {
                            foreach ($rows as $key => $row) { ?>
                            <tr data-id="<?php echo $row['news_id']; ?>">
                                <input type="hidden" value="<?php echo $row['news_id']; ?>" class="inputSelect" name="document_id[]">
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $arrCate[$row['original_cate']]['name']; ?></td>
                                <td class="action last" align="center">
                                    <a class="tmp-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['news_id']; ?>" href="javascript:void(0)" rel="nofollow">
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
                <h2>Danh sách tài liệu</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <?php if ($arrDocs) { ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-xs-12">
                        <div class="form-group">
                            <select id="filter_cate" class="form-control">
                                <option value="0">Nhóm tài liệu</option>
                                <?php foreach ($arrCate as $key => $cate) { ?>
                                <option value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-7 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <input type="text" id="filter_keyword"  value="" placeholder="<?php echo $this->lang->line("common_search_text"); ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-5 col-sm-3 col-xs-12">
                        <button class="btn btn-success buildtop-suggest-button" data-url="<?php echo SITE_URL; ?>/news/suggest_news" type="button"><?php echo $this->lang->line("common_search_text"); ?></button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive" id="table_suggest">
                    <table class="table table-striped jambo_table table-bordered">
                        <thead id="checkbox_all">
                            <tr class="headings">
                                <th class="column-title">Tài liệu</th>
                                <th class="column-title no-link last" align="center" width="60px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
                            </tr>
                        </thead>
                        <tbody id="checkbox_list">
                            <?php 
                            foreach ($arrDocs as $key => $row) { ?>
                            <tr data-id="<?php echo $row['news_id']; ?>">
                                <td><?php echo $row['title']; ?></td>
                                <td class="action last" align="center">
                                    <a class="tmp-add" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_add"); ?>" data-title="<?php echo $row['title']; ?>" data-cate="<?php  echo $arrCate[$row['original_cate']]['name']; ?>" data-id="<?php echo $row['news_id']; ?>" href="javascript:void(0)" rel="nofollow">
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
<script type="text/javascript">
$(document).ready(function(){
    buildtop_script({type: 'tab',name: 'document_id'});
    buildtop_documents_script();
})
</script>