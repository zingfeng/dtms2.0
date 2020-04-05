
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
				<h2>Chọn đáp án đúng</h2>
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
				    <label class="control-label col-sm-2 col-xs-12">Đề bài</label>
				    <div class="col-sm-10 col-xs-12 ckeditor_detail">
				        <textarea require name="content" class="form-control" placeholder="Nội dung" rows="5"><?php echo $row['content'] ?></textarea>
				    </div>
				</div>
			</div>
			<div class="x_content row">
                <div class="form-group">
				    <label class="control-label col-sm-2 col-xs-12">Idea</label>
				    <div class="col-sm-10 col-xs-12 ckeditor_detail">
				        <textarea require name="options[idea]" class="form-control" placeholder="Idea" rows="7"><?php echo $options['idea']; ?></textarea>
				    </div>
				</div>
			</div>
			<div class="x_content row">
                <div class="form-group">
				    <label class="control-label col-sm-2 col-xs-12">Ví dụ</label>
				    <div class="col-sm-10 col-xs-12 ckeditor_detail">
				        <textarea require name="options[sample]" class="form-control" placeholder="Idea" rows="7"><?php echo $options['sample']; ?></textarea>
				    </div>
				</div>
			</div>
			<div class="x_content row">
                <div class="form-group">
				    <label class="control-label col-sm-2 col-xs-12">Thứ tự</label>
				    <div class="col-sm-10 col-xs-12">
				        <input type="text" name="ordering" value="<?php echo (int) $row['ordering']; ?>" placeholder="Thứ tự" class="form-control">
				    </div>
				</div>
			</div>
			<div class="x_content row">
	                
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-3 col-xs-12">Từ vựng</label>
					<div class="col-md-10 col-sm-9 col-xs-12">
						<input id="news_tag" type="text" class="tags form-control" value="" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$('#news_tag').tagsInput({
			width: 'auto',
			autocomplete_url:'<?php echo SITE_URL; ?>/dictionary/suggest',
			autocomplete:{selectFirst:true,width:'100px',autoFill:true},
			minChars : 2,
			delimiter: [',',';'],
			removeWithBackspace: false,
			trimValue: true,
			beforeTagAdded: function(event, ui) {
		      if ($.inArray(ui.tagLabel, currentlyValidTags) == -1) {
		        return false;
		      }
		    }
			//onTagExists: true
		});
		<?php
		if ($arrTag) { 
		foreach ($arrTag as $key => $tag) {
		?>
		$('#news_tag').addTag({id: <?php echo $tag['dict_id']; ?>,value: '<?php echo $tag['word_en']; ?>'});
		<?php }
		} ?>
	});
</script>
