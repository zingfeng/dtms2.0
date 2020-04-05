<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$configBlock = $this->config->item("block"); 
$configDevice = $this->config->item("device");
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">    
    <button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
    <?php if ($this->permission->check_permission_backend('index')) {?>
    <a class="btn btn-primary" href="<?php echo SITE_URL; ?>/noti/index">Danh sách Noti</a>
    <?php } ?>
    <button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
    <?php if ($row['block_id']) { ?>
    <input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['block_id']) ?>"/>
    <?php } ?>
</div>
<div class="row">
    <div class="col-sm-8 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Noti</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content row">
                <div class="form-group validation_name">
                    <label class="control-label col-sm-2 col-xs-12">Tiêu đề</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input required type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="Tiêu đề của Noti" class="form-control">
                    </div>
                </div>
                <div class="form-group validation_ordering">
                    <label class="control-label col-sm-2 col-xs-12">Nội dung</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input type="text" name="content" value="<?php echo $row['content']; ?>" placeholder="Nội dung của Noti" class="form-control">
                    </div>
                </div>
                <div class="form-group validation_ordering">
                    <label class="control-label col-sm-2 col-xs-12">Link</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input type="text" name="link" value="<?php echo $row['link']; ?>" placeholder="Link" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12">Avarta</label>
                    <div class="col-sm-10 col-xs-12 filemanager_media">
                        <img class="image_org" data-name="news_image" data-type="image" data-selected="<?php echo $row['avarta']; ?>" src="<?php echo ($row['avarta']) ? getimglink($row['avarta'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
                        <i class="fa fa-remove image_delete"></i>
                        <input type="hidden" name="avarta" value="<?php echo $row['avarta']; ?>" />
                    </div>
                </div>

                <div id="block_option">
                    
                </div>
                <div class="form-group validation_module">
                    <label class="control-label col-sm-2 col-xs-12">Khóa học</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <?php
                            if (is_array($list_course) && (count($list_course) > 0)){
//                                var_dump($list_course);
                                $list_checked = array();
                                if (is_array(json_decode($row['course'],true))) $list_checked = json_decode($row['course'],true);

                                foreach ($list_course as $list_course_item) {
                                    $check = '';
                                    if (isset($list_checked[$list_course_item['course_id']])){
                                        $check = ' checked="checked" ';
                                    }
                                    echo '<div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="course['.$list_course_item['course_id'].']" '. $check.'  >
                                                <label class="custom-control-label" for="course['.$list_course_item['course_id'].']">'.$list_course_item['title'].'</label>
                                            </div>';
                                }

                            }

                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="col-sm-4 col-xs-12">-->
<!--        <div class="x_panel">-->
<!--            <div class="x_title">-->
<!--                <h2>--><?php //echo $this->lang->line("block_access"); ?><!--</h2>-->
<!--                <div class="clearfix"></div>-->
<!--            </div>-->
<!--            <div class="x_content row">-->
<!--                <div class="form-group">-->
<!--                    <div class="col-sm-12 col-xs-12">-->
<!--                        --><?php //
//                        if ($arrMenu){
//                        foreach ($arrMenu as $key => $arrMenu) {?>
<!--                        <h3>--><?php //echo $key; ?><!--</h3>-->
<!--                            --><?php //foreach ($arrMenu as $key => $menu) {?>
<!--                            <div class="checkbox">-->
<!--                                <label>-->
<!--                                    <input type="checkbox" --><?php //if (in_array($menu['menu_id'], $arrMenuAccess)) echo 'checked'; ?><!-- value="--><?php //echo $menu['menu_id']; ?><!--" name="access[]"/>--><?php //echo $menu['name']; ?>
<!--                                </label>-->
<!--                            </div>-->
<!--                            --><?php //} ?>
<!--                        --><?php //} } ?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
</form>
<script type="text/javascript">
    var configBlock = <?php echo json_encode($configBlock); ?>;
    var block_id = <?php echo (int) $row['id_noti']; ?>;
    //var row_module = '<?php //echo ($row['module']) ? $row['module'] : ''; ?>//';
</script>
<script type="text/javascript">
    $(document).ready(function(){
        block_form_script();
    })
</script>