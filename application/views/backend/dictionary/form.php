<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/dictionary/index">Danh sách từ điển</a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['dict_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['dict_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $this->lang->line('common_mod_dictionary_index'); ?></small></h2>
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
					<label class="control-label col-md-2 col-sm-3 col-xs-12">Từ tiếng anh</label>
					<div class="col-md-10 col-sm-9 col-xs-12 validation_form">
						<input required type="text" name="word_en" value="<?php echo $row['word_en']; ?>" placeholder="Từ tiếng anh" class="form-control">
					</div>
                </div>
                <div class="form-group validation_name">
					<label class="control-label col-md-2 col-sm-3 col-xs-12">Phiên âm</label>
					<div class="col-md-10 col-sm-9 col-xs-12 validation_form">
						<input required type="text" name="trans" value="<?php echo $row['trans']; ?>" placeholder="Phiên âm" class="form-control">
					</div>
                </div>
                <div class="form-group ckeditor_detail" >
					<label class="control-label col-md-2 col-sm-3 col-xs-12">Nghĩa tiếng việt</label>
					<div class="col-md-10 col-sm-9 col-xs-12">
						<textarea name="word_vn" data-toolbar="simple" class="form-control" placeholder="Nghĩa tiếng việt" rows="3"><?php echo $row['word_vn']; ?></textarea>
					</div>
                </div>
                
                
               <div class="form-group">
					<label class="control-label col-md-2 col-sm-3 col-xs-12">Sound</label>
					<div class="col-md-10 col-sm-9 col-xs-12 filemanager_media">
						<img class="image_org" data-name="question_sound" data-type="sound" data-selected="<?php echo $row['sound']; ?>" src="<?php echo $this->config->item("img").'default_image.jpg'; ?>">
						<div class="sound_preview">
						<?php if ($row['sound']) {?>
			            	<audio controls>
								  <source src="<?php echo getFileLink($row['sound']); ?>" type="audio/mpeg">
									Your browser does not support the audio element.
							</audio>
		            	<?php } ?>
		            	</div>
						<i class="fa fa-remove sound_delete"></i>
						<input type="hidden" class="sound_input" name="sound" value="<?php echo $row['sound']; ?>" />
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
</form>
