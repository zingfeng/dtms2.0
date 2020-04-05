<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">    
    <button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
    <?php if ($this->permission->check_permission_backend('member_index')) {?>
    <a class="btn btn-primary" href="<?php echo SITE_URL; ?>/roles/member_index"><?php echo $this->lang->line("common_mod_role_member_index"); ?></a>
    <?php } ?>
    <button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
    <?php if ($row['member_id']) { ?>
    <input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['member_id']) ?>"/>
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
                <div class="form-group validation_email">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("users_email"); ?> *</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 validation_form">
                        <input required <?php if($row['email']) echo " disabled" ?> type="text" name="email" value="<?php echo $row['email']; ?>" placeholder="<?php echo $this->lang->line("users_email"); ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("users_roles_permission"); ?> *</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 validation_form">
                        <select name="role" class="form-control">
                            <?php foreach ($arrRoles as $key => $role) {?>
                                <option <?php if ($row['roles_id'] == $role['roles_id']) echo 'selected'; ?> value="<?php echo $role['roles_id']; ?>"><?php echo $role['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>