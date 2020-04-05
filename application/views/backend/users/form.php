<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index') && $this->router->method !='profile') {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/users/index"><?php echo $this->lang->line("common_mod_users_index"); ?></a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['user_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['user_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<div class="col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $this->lang->line("users_title"); ?></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content row">
				<div class="form-group validation_title">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_fullname"); ?></label>
					<div class="col-sm-9 col-xs-12 validation_form">
						<input required type="text" name="fullname" value="<?php echo $row['fullname']; ?>" placeholder="<?php echo $this->lang->line("users_fullname"); ?>" class="form-control">
					</div>
                </div>
            	<div class="form-group">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_email"); ?></label>
					<div class="col-sm-9 col-xs-12">
						<input <?php echo $row ? 'disabled' : ''?> type="text" name="email" value="<?php echo $row['email']; ?>" placeholder="<?php echo $this->lang->line("users_email"); ?>" class="form-control">
					</div>
                </div>
                <?php if($row) { ?>
                <div class="form-group validation_password">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_password"); ?></label>
					<div class="col-sm-9 col-xs-12 validation_form">
						<input type="password" autocomplete="off" name="password" value="" placeholder="<?php echo $this->lang->line("users_password"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group validation_password_confirm">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_password_confirm"); ?></label>
					<div class="col-sm-9 col-xs-12 validation_form">
						<input type="password" autocomplete="off" name="password_confirm" value="" placeholder="<?php echo $this->lang->line("users_password_confirm"); ?>" class="form-control">
					</div>
                </div>
                <?php }else{ ?>
            	<div class="form-group">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_password"); ?></label>
					<div class="col-sm-9 col-xs-12 validation_form">
						<input disabled placeholder="123456" class="form-control">
					</div>
                </div>
                <?php } ?>

                <?php if ($this->router->method != 'profile') { ?>
                <div class="form-group">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_active"); ?></label>
					<div class="col-sm-9 col-xs-12">
						<div class="checkbox">
							<label><input <?php echo empty($row) ? 'disabled' : '' ?> type="checkbox" value="1" <?php echo ($row['active'] == 1 || empty($row)) ? 'checked' : ''; ?> name="active"></label>						
						</div>
					</div>
                </div>
                <?php } ?>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>More Information</small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content row">
				<div class="form-group">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_sex"); ?></label>
					<div class="col-sm-9 col-xs-12">
						<div class="checkbox">
							<label><input <?php echo $row ? 'disabled' : '' ?> type="checkbox" value="1" <?php echo ($row['sex'] == 1) ? 'checked' : ''; ?> name="sex"></label>						
						</div>
					</div>
                </div>
				<div class="form-group">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_address"); ?></label>
					<div class="col-sm-9 col-xs-12">
						<input <?php echo $row ? 'disabled' : '' ?> type="text" name="address" value="<?php echo $row['address']; ?>" class="form-control" placeholder="<?php echo $this->lang->line("users_address"); ?>">
					</div>
                </div>
				<div class="form-group">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_phone"); ?></label>
					<div class="col-sm-9 col-xs-12">
						<input <?php echo $row ? 'disabled' : '' ?> type="text" name="phone" value="<?php echo $row['phone']; ?>" class="form-control" placeholder="<?php echo $this->lang->line("users_phone"); ?>">
					</div>
                </div>
				<div class="form-group">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_birthday"); ?></label>
					<div class="col-sm-9 col-xs-12">
						<input <?php echo $row ? 'disabled' : '' ?> type="text" id="birthday" name="birthday" value="<?php echo $row['birthday'] ? date('d/m/Y H:i:s',$row['birthday']) : ''; ?>" class="form-control">
					</div>
                </div>
                <?php if ($row['create_time']) {?>
				<div class="form-group">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_create_time"); ?></label>
					<div class="col-sm-9 col-xs-12">
						<input readonly="readonly" type="text" name="create_time" value="<?php echo date('d/m/Y H:i:s',$row['create_time']); ?>" class="form-control">
					</div>
                </div>
                <?php } ?>
                <?php if ($row['update_time']) {?>
				<div class="form-group">
					<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("users_update_time"); ?></label>
					<div class="col-sm-9 col-xs-12">
						<input readonly="readonly" type="text" name="update_time" value="<?php echo date('d/m/Y H:i:s',$row['update_time']); ?>" class="form-control">
					</div>
                </div>
                <?php } ?>
			</div>
		</div>
	</div>
</div>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		/** DATETIME **/
		$('#birthday').datetimepicker({
			format: 'd/m/Y H:i:s',
			step: 5
		});
	});
</script>
