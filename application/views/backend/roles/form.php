<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$permission = $this->config->item('admin_role');
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">    
    <button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
    <?php if ($this->permission->check_permission_backend('index')) {?>
    <a class="btn btn-primary" href="<?php echo SITE_URL; ?>/roles/index"><?php echo $this->lang->line("common_mod_role_index"); ?></a>
    <?php } ?>
    <button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
    <?php if ($row['roles_id']) { ?>
    <input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['roles_id']) ?>"/>
    <?php } ?>
</div>
<div class="row">
    <div class="col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Design <small>different form elements</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content row">
                <div class="form-group validation_name">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("users_roles_name"); ?> *</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 validation_form">
                        <input required type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="<?php echo $this->lang->line("users_roles_name"); ?>" class="form-control">
                    </div>
                </div>
                <?php foreach ($permission as $key => $role) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $role['name'] ?></label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <select name="permission[<?php echo $key; ?>]" class="form-control" tabindex="-1">
                            <option value="0">None</option>
                            <?php foreach ($role['permission'] as $k => $per) { ?>
                            <option <?php if ($row['permission'][$key] == $k) echo 'selected'; ?> value="<?php echo $k; ?>"><?php echo $per['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</form>