<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	$options = @json_decode($row['options'],TRUE);
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['answer_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['answer_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<div class="col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Question Speaking</h2>
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
				    <label class="control-label col-sm-2 col-xs-12">Nội dung</label>
				    <div class="col-sm-10 col-xs-12 ckeditor_detail">
				        <textarea require name="content" class="form-control" placeholder="Nội dung" rows="11"><?php echo $row['content'] ?></textarea>
				    </div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2 col-sm-3 col-xs-12">Audio question</label>
				<div class="col-md-10 col-sm-9 col-xs-12 filemanager_media">
					<img class="image_org" data-name="question_sound" data-type="sound" data-selected="<?php echo $options['audio']; ?>" src="<?php echo $this->config->item("img").'default_image.jpg'; ?>">
					<div class="sound_preview">
					<?php if ($options['audio']) {?>
		            	<audio controls>
							  <source src="<?php echo getFileLink($options['audio']); ?>" type="audio/mpeg">
								Your browser does not support the audio element.
						</audio>
	            	<?php } ?>
	            	</div>
					<i class="fa fa-remove sound_delete"></i>
					<input type="hidden" class="sound_input" name="options[audio]" value="<?php echo $options['audio']; ?>" />
				</div>
            </div>
			<div class="x_content row">
                <div class="form-group">
				    <label class="control-label col-sm-2 col-xs-12">Gợi ý</label>
				    <div class="col-sm-10 col-xs-12 ckeditor_detail">
				        <textarea name="options[suggest]" class="form-control" placeholder="Gợi ý" rows="11"><?php echo $options['suggest'] ?></textarea>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
