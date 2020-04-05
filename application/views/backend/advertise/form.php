<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/advertise/index"><?php echo $this->lang->line("common_mod_advertise_index"); ?></a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['adv_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['adv_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<div class="col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $this->lang->line('common_mod_advertise'); ?></h2>
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
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("adv_name"); ?> *</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input required type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="<?php echo $this->lang->line("adv_name"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group validation_images">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("adv_images"); ?></label>
					<div class="col-sm-10 col-xs-12 filemanager_media validation_form">
						<img class="image_org" data-name="adv_images" data-type="image" data-selected="<?php echo $row['images']; ?>" src="<?php echo ($row['images']) ? getimglink($row['images'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
						<i class="fa fa-remove image_delete"></i>
						<input type="hidden" name="images" value="<?php echo $row['images']; ?>" />
					</div>
                </div>
                <div class="form-group validation_link">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("adv_link"); ?></label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input required type="text" name="link" value="<?php echo $row['link']; ?>" placeholder="<?php echo $this->lang->line("adv_link"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group validation_cate_id">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("adv_cate"); ?></label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<select name="cate_id" class="select2_single form-control" placeholder="<?php echo $this->lang->line("adv_cate"); ?>" tabindex="-1">
                            <option value="0"><?php echo $this->lang->line("adv_cate"); ?></option>
                            <?php foreach ($arrCate as $key => $cate) { ?>
                            <option <?php if ($row['cate_id'] == $cate['cate_id']) echo 'selected'; ?> value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['name']; ?></option>
                            <?php } ?>
                        </select>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("adv_ordering"); ?></label>
					<div class="col-sm-10 col-xs-12">
						<input type="text" name="ordering" value="<?php echo (int) $row['ordering']; ?>" placeholder="<?php echo $this->lang->line("adv_ordering"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("adv_publish"); ?></label>
					<div class="col-sm-10 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" value="1" <?php echo ($row['publish'] == 1 || !isset($row['publish'])) ? 'checked' : ''; ?> name="publish"></label>
						</div>
					</div>
                </div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Mô tả</label>
					<div class="col-sm-10 col-xs-12">
						<textarea name="description" class="form-control" placeholder="Mô tả" rows="3"><?php echo $row['description']; ?></textarea>
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
</form>