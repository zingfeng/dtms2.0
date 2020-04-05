<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$configBlock = $this->config->item("block"); 
$configDevice = $this->config->item("device");
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">    
    <button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
    <?php if ($this->permission->check_permission_backend('index')) {?>
    <a class="btn btn-primary" href="<?php echo SITE_URL; ?>/block/index"><?php echo $this->lang->line("common_mod_block_index"); ?></a>
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
                <h2><?php echo $this->lang->line("block_title"); ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content row">
                <div class="form-group validation_name">
                    <label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("block_name"); ?></label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input required type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="<?php echo $this->lang->line("block_name"); ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group validation_ordering">
                    <label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("block_ordering"); ?></label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input type="text" name="ordering" value="<?php echo (int) $row['ordering']; ?>" placeholder="<?php echo $this->lang->line("block_ordering"); ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("block_publish"); ?></label>
                    <div class="col-sm-10 col-xs-12">
                        <div class="checkbox">
                            <label><input type="checkbox" value="1" <?php echo ($row['publish'] == 1 || !isset($row['publish'])) ? 'checked' : ''; ?> name="publish"></label>                       
                        </div>
                    </div>
                </div>
                <div class="form-group validation_module">
                    <label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("block_module"); ?></label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <select name="module" id="block_module" class="select2_single form-control" placeholder="<?php echo $this->lang->line("block_module"); ?>" tabindex="-1">
                            <option value=""><?php echo $this->lang->line("block_module"); ?></option>
                            <?php foreach ($configBlock as $key => $block) { ?>
                            <option <?php if ($row['module'] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $block['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div id="block_option">
                    
                </div>
                <div class="form-group validation_module">
                    <label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("common_device"); ?></label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <select name="device" class="form-control" placeholder="<?php echo $this->lang->line("common_device"); ?>">
                            <option value="0"><?php echo $this->lang->line("common_device_all"); ?></option>
                            <?php foreach ($configDevice as $key => $device) { ?>
                            <option <?php if ($row['device'] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $device; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo $this->lang->line("block_access"); ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content row">
                <div class="form-group">
                    <div class="col-sm-12 col-xs-12">
                        <?php 
                        if ($arrMenu){
                        foreach ($arrMenu as $key => $arrMenu) {?>
                        <h3><?php echo $key; ?></h3>
                            <?php foreach ($arrMenu as $key => $menu) {?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" <?php if (in_array($menu['menu_id'], $arrMenuAccess)) echo 'checked'; ?> value="<?php echo $menu['menu_id']; ?>" name="access[]"/><?php echo $menu['name']; ?>
                                </label>
                            </div>
                            <?php } ?>
                        <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
    var configBlock = <?php echo json_encode($configBlock); ?>;
    var block_id = <?php echo (int) $row['block_id']; ?>;
    var row_module = '<?php echo ($row['module']) ? $row['module'] : ''; ?>';
</script>
<script type="text/javascript">
    $(document).ready(function(){
        block_form_script();
    })
</script>