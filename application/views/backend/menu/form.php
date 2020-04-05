<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$menuConfig = $this->config->item("menu");
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/menu/index"><?php echo $this->lang->line("common_mod_menu_index"); ?></a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['menu_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['menu_id']) ?>"/>
	<?php } ?>
	<input type="hidden" name="item_id" id="menu_item_id" value="<?php echo $row['item_id']; ?>">
</div>
<div class="row">
	<div class="col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $this->lang->line("menu_title");?></small></h2>
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
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("menu_name"); ?> *</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input required type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="<?php echo $this->lang->line("menu_name"); ?>" class="form-control">
					</div>
				</div>
				<div class="form-group validation_module">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("menu_module"); ?></label>
					<div class="col-sm-10 col-xs-12 validation_form" >
						<select id="menu_module" data-module="<?php echo $row['item_mod']; ?>" data-id="<?php echo $row['item_id']; ?>" name="module" data-parent="<?php echo (int) $row['parent']; ?>" class="select2_single form-control" placeholder="<?php echo $this->lang->line("menu_module"); ?>" tabindex="-1">
							<option value=""><?php echo $this->lang->line("menu_module"); ?></option>
							<?php foreach ($menuConfig['module'] as $key => $action) { ?>
							<optgroup label="<?php echo $action['name']; ?>">
								<?php foreach ($action['action'] as $k => $v) {?>
									<option data-link="<?php echo $v['link']; ?>" data-type="<?php echo $v['type']; ?>" <?php if ($k == $row['item_mod']) echo 'selected'; ?> value="<?php echo $k; ?>"><?php echo $v['name']; ?></option>
								<?php } ?>
							</optgroup>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group validation_link" id="menu_link" style="display: none;">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("menu_link"); ?></label>
					<div class="col-sm-10 col-xs-12 validation_form input"></div>
				</div>
				<div class="form-group">
						<label class="control-label col-sm-2 col-xs-12">ICON</label>
						<div class="col-sm-10 col-xs-12 filemanager_media">
							<img class="image_org" data-name="news_image" data-type="image" data-selected="<?php echo $row['icon']; ?>" src="<?php echo ($row['icon']) ? getimglink($row['icon'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
							<i class="fa fa-remove image_delete"></i>
							<input type="hidden" name="icon" value="<?php echo $row['icon']; ?>" />
						</div>
	                </div>
				<?php if ($countChild == 0) { ?>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("menu_position"); ?></label>
					<div class="col-sm-10 col-xs-12" id="menu_position">
						<select name="position" class="form-control">
							<?php foreach ($menuConfig['position'] as $key => $value) { ?>
							<option <?php if ($row['position'] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<?php } ?>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("menu_parent"); ?></label>
					<div class="col-sm-10 col-xs-12" id="menu_parent" data-parent="<?php echo (int) $row['parent']; ?>">
						<select name="parent" class="select2_single form-control" placeholder="<?php echo $this->lang->line("menu_parent"); ?>" tabindex="-1">
							<option value="0"><?php echo $this->lang->line("menu_parent"); ?></option>
							<?php foreach ($arrMenu as $key => $menu) { ?>
							<option <?php if ($row['parent'] == $menu['menu_id']) echo 'selected'; ?> value="<?php echo $menu['menu_id']; ?>"><?php echo $menu['name']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("menu_ordering"); ?></label>
					<div class="col-sm-10 col-xs-12">
						<input type="text" name="ordering" value="<?php echo (int) $row['ordering']; ?>" placeholder="<?php echo $this->lang->line("news_cate_ordering"); ?>" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Nổi bật</label>
					<div class="col-sm-10 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" value="1" <?php echo $row['hot'] == 1 ? 'checked' : ''; ?> name="hot"></label>						
						</div>
					</div>
                </div>
				<div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("menu_target"); ?></label>
					<div class="col-sm-10 col-xs-12">
						<select name="target" class="form-control">
							<option <?php if ($row['target'] == '_parent') echo 'selected'; ?> value="_parent"><?php echo $this->lang->line("menu_target_parent"); ?></option>
							<option <?php if ($row['target'] == '_blank') echo 'selected'; ?> value="_blank"><?php echo $this->lang->line("menu_target_blank"); ?></option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
	<?php if ($data_suggest) {?>
		var data_suggest = <?php echo json_encode($data_suggest); ?>;
	<?php } ?>
	var menu_id = 0;
	<?php if ($row) { ?>
		menu_id = <?php echo $row['menu_id']; ?>;
	<?php } ?>
</script>
<script type="text/javascript">
	
	$(document).ready(function(){
		menu_form_script()
		$("#menu_module").change();
	})
	
</script>