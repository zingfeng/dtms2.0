<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('topic_index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/course/topic_index/<?php echo $course_id;?>"><?php echo $this->lang->line("common_mod_course_topic_index"); ?></a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['topic_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['topic_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-7 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $this->lang->line('common_mod_course_cate'); ?></small></h2>
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_topic_name"); ?> *</label>
					<div class="col-md-9 col-sm-9 col-xs-12 validation_form">
						<input required type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="<?php echo $this->lang->line("course_topic_name"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Giá tiền</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="price" value="<?php echo $row['price']; ?>" placeholder="Giá tiền" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Giá giảm</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="price_discount" value="<?php echo $row['price_discount']; ?>" placeholder="Giá giảm" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_topic_images"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12 filemanager_media">
						<img class="image_org" data-name="course_image" data-type="image" data-selected="<?php echo $row['images']; ?>" src="<?php echo ($row['images']) ? getimglink($row['images'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
						<i class="fa fa-remove image_delete"></i>
						<input type="hidden" name="images" value="<?php echo $row['images']; ?>" />
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_topic_ordering"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="ordering" value="<?php echo (int) $row['ordering']; ?>" placeholder="<?php echo $this->lang->line("course_topic_ordering"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_topic_description"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="description" class="form-control" placeholder="<?php echo $this->lang->line("course_topic_description"); ?>" rows="3"><?php echo $row['description']; ?></textarea>
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_seo_title"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_title" value="<?php echo $row['seo_title']; ?>" placeholder="<?php echo $this->lang->line("course_seo_title"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_seo_keyword"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_keyword" value="<?php echo $row['seo_keyword']; ?>" placeholder="<?php echo $this->lang->line("course_seo_keyword"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_seo_description"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="seo_description" class="form-control" placeholder="<?php echo $this->lang->line("course_seo_description"); ?>" value="" rows="3"><?php echo $row['seo_description']; ?></textarea>
				
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
</form>