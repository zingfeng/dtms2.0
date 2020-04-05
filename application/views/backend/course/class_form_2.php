
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['class_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['class_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<ul class="nav nav-tabs col-xs-12" role="tablist" style="margin-bottom: 20px;">
		<li class="active"><a href="javascript:;" role="tab" data-toggle="tab">Thông tin cơ bản</a></li>
	</ul>
	<div class="tab-content">
		<div class="col-sm-12 col-xs-12 tab-pane active" role="tabpanel">
			<div class="x_panel">
				<div class="x_title">
					<h2>Test kỹ năng</h2>
					<input  type="hidden" name="type" value="<?php echo $type ?>"/>
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
						<label class="control-label col-sm-2 col-xs-12">Tiêu đề</label>
						<div class="col-sm-10 col-xs-12 validation_form">
							<input required type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="Tiêu đề" class="form-control">
						</div>
	                </div>
	                <div class="form-group">
						<label class="control-label col-sm-2 col-xs-12">Bài Test</label>
						<div class="col-sm-10 col-xs-12">
							<select name="test[]" id="suggest_test" class="form-control" placeholder="Bài Test">\
								<?php foreach($data_test as $test){?>
	                            	<option value="<?php echo $test['test_id'];?>" selected><?php echo $test['title'];?></option>
	                            <?php }?>
							</select>
						</div>
	                </div>
	                <div class="form-group">
						<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_class_description"); ?></label>
						<div class="col-sm-10 col-xs-12">
							<textarea name="description" class="form-control" placeholder="<?php echo $this->lang->line("course_class_description"); ?>" rows="3"><?php echo $row['description']; ?></textarea>
						</div>
	                </div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>SEO AREA <small>Option</small></h2>
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_class_date_up"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input id="publish_time" type="text" name="publish_time" class="form-control" value="<?php echo ($row['publish_time']) ? date('d/m/Y H:i:s',$row['publish_time']) : date('d/m/Y H:i:s'); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_class_params"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12" id="course_params">
						<div id="option_add" class="row">
							<?php 
							$i = 1;
							if ($row['params'] && is_array($row['params'])) {
							foreach ($row['params'] as $key => $value) { ?>
							<div class="form-group" data-count="<?php echo $i; ?>">
								<div class="col-xs-6">
									<input type="text" name="params[<?php echo $i; ?>][key]" value="<?php echo $key; ?>" placeholder="<?php echo $this->lang->line("course_class_params_key"); ?>" class="form-control">
								</div>
								<div class="col-xs-6">
									<input type="text" name="params[<?php echo $i; ?>][value]" value="<?php echo $value; ?>" placeholder="<?php echo $this->lang->line("course_class_params_value"); ?>" class="form-control">
								</div>
							</div>
							<?php $i++; }
							}
							?>
							<div class="form-group" data-count="<?php echo $i; ?>">
								<div class="col-xs-6">
									<input type="text" name="params[<?php echo $i; ?>][key]" value="" placeholder="<?php echo $this->lang->line("course_class_params_key"); ?>" class="form-control">
								</div>
								<div class="col-xs-6">
									<input type="text" name="params[<?php echo $i; ?>][value]" value="" placeholder="<?php echo $this->lang->line("course_class_params_value"); ?>" class="form-control">
								</div>
							</div>
						</div>
						<p class="icon_plus"><i class="fa fa-plus" aria-hidden="true"></i></p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xs-12">
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_class_seo_title"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_title" value="<?php echo $row['seo_title']; ?>" placeholder="<?php echo $this->lang->line("course_class_seo_title"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_class_seo_keyword"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_keyword" value="<?php echo $row['seo_keyword']; ?>" placeholder="<?php echo $this->lang->line("course_class_seo_keyword"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_class_seo_description"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="seo_description" class="form-control" placeholder="<?php echo $this->lang->line("course_class_seo_description"); ?>" value="" rows="3"><?php echo $row['seo_description']; ?></textarea>
				
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
	/** DATETIME **/
	$('#publish_time').datetimepicker({
		format: 'd/m/Y H:i:s',
		step: 5
	});
	$( "#other_images" ).sortable();
	//suggest documents
	<?php if ($data_test) {?>
		<?php foreach($data_test as $data_test){?>
			var html = '<option selected value="<?php echo $data_test['test_id'] ?>"><?php echo $data_test['title'] ?></option>';
			$("#suggest_test").html(html);
			$("#suggest_test").val(<?php echo $data_test['test_id'] ?>);
		<?php } ?>
	<?php } ?>
	$("#suggest_test").select2({
		allowClear: true,
		placeholder: 'Chọn hoặc tìm tài liệu ...',
		ajax: {
			url: SITE_URL + "/test/suggest_test",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					term: params.term, // search term
					page: params.page,
				};
			},
			processResults: function (data, params) {
				console.log(data);
			  	params.page = params.page || 1;
			  	return {
					results: data.data,
					pagination: {
						more: data.option.nextpage
					}
			  	};
	  		},
	  		cache: true
		},
		minimumInputLength: 0,
		templateSelection: function(data) {
			if (typeof (data.item_id) != 'undefined') {
				$("#suggest_documents").val(data.item_id);
				// $("#suggest_documents option[value="+data.item_id+"]").attr("selected", "selected");
			}
			
			return data.text;
		}
	});
});
</script>