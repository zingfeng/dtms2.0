<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/expert/index">Danh sách giáo viên</a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['expert_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['expert_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-7 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Giáo viên</small></h2>
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Tên giáo viên *</label>
					<div class="col-md-9 col-sm-9 col-xs-12 validation_form">
						<input required type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="Tên giáo viên" class="form-control">
					</div>
                </div>
                
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Ảnh</label>
					<div class="col-md-9 col-sm-9 col-xs-12 filemanager_media">
						<img class="image_org" data-name="category_image" data-type="image" data-selected="<?php echo $row['images']; ?>" src="<?php echo ($row['images']) ? getimglink($row['images'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
						<i class="fa fa-remove image_delete"></i>
						<input type="hidden" name="images" value="<?php echo $row['images']; ?>" />
					</div>
                </div>
                
                <div class="form-group ckeditor_detail" >
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Mô tả</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="description" data-toolbar="simple" class="form-control" placeholder="Mô tả" rows="3"><?php echo $row['description']; ?></textarea>
					</div>
                </div>
                <div class="form-group ckeditor_detail" >
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Chi Tiết</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="detail" class="form-control" placeholder="Chi tiết" rows="3"><?php echo $row['detail']; ?></textarea>
					</div>
                </div>
			</div>
		</div>
	</div>
	<div class="col-md-5 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>SEO AREA <small>Seo for category</small></h2>
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("common_seo_title"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_title" value="<?php echo $row['seo_title']; ?>" placeholder="<?php echo $this->lang->line("common_seo_title"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("common_seo_keyword"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_keyword" value="<?php echo $row['seo_keyword']; ?>" placeholder="<?php echo $this->lang->line("common_seo_keyword"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("common_seo_description"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="seo_description" class="form-control" placeholder="<?php echo $this->lang->line("common_seo_description"); ?>" value="" rows="3"><?php echo $row['seo_description']; ?></textarea>
				
					</div>
                </div>
          
			</div>
		</div>
	</div>
</div>
</form>
