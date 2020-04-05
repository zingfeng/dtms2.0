
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
$test_type = $this->config->item("test_answer_type");
$test_type = $test_type[$type];
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['question_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['question_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<ul class="nav nav-tabs col-xs-12" role="tablist" style="margin-bottom: 20px;">
		<li class="active"><a href="#step1" role="tab" data-toggle="tab">Thông tin câu hỏi</a></li>
		<!--<li><a href="#step2" role="tab" data-toggle="tab">Tạo group</a></li>-->
	</ul>
	<div class="tab-content">
		<div id="step1" class="tab-pane active" role="tabpanel">
			<div class="col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Group câu hỏi</h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content row">
						<?php if ($parent_id > 0) { ?>
						<div class="form-group ckeditor_detail">
						    <label class="control-label col-sm-2 col-xs-12">Loại câu hỏi</label>
						    <div class="col-sm-10 col-xs-12">
						    	<?php if (!$row) { ?>
						        <select class="form-control" required name="type">
						        	<option value="0">Chọn loại câu hỏi</option>
						        	<?php foreach ($test_type as $key => $typeName) {?>
						        	<option <?php if ($row['type'] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $typeName; ?></option>
						        	<?php } ?>
						        </select>
						    	<?php } else {
						    	//var_dump($test_type,$row['type']); die;
						    	 ?>
						    	<input required type="text" disabled value="<?php echo $test_type[$row['type']]; ?>" placeholder="Tên câu hỏi" class="form-control">
						    	<?php } ?>
						    </div>
						</div>
						<?php } else { ?>
						<input type="hidden" name="type" value="<?php echo $type; ?>">
						<?php } ?>
						<div class="form-group validation_title">
							<label class="control-label col-sm-2 col-xs-12">Tên câu hỏi</label>
							<div class="col-sm-10 col-xs-12 validation_form">
								<input required type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="Tên câu hỏi" class="form-control">
							</div>
		                </div>
		                <div class="form-group">
							<label class="control-label col-sm-2 col-xs-12">Xuất bản</label>
							<div class="col-sm-10 col-xs-12">
								<div class="checkbox">
									<label><input type="checkbox" value="1" <?php echo ($row['publish'] == 1 || !isset($row['publish'])) ? 'checked' : ''; ?> name="publish"></label>						
								</div>
							</div>
		                </div>
		                <div class="form-group validation_title">
							<label class="control-label col-sm-2 col-xs-12">Thứ tự</label>
							<div class="col-sm-10 col-xs-12 validation_form">
								<input required type="text" name="ordering" value="<?php echo $row['ordering']; ?>" placeholder="Thứ tự" class="form-control">
							</div>
		                </div>
						<div class="form-group ckeditor_detail">
						    <label class="control-label col-sm-2 col-xs-12">Chi tiết</label>
						    <div class="col-sm-10 col-xs-12">
						        <textarea name="detail" class="form-control" placeholder="Chi tiết" rows="3"><?php echo $row['detail']; ?></textarea>
						    </div>
						</div>
						<?php if ($parent_id == 0) { ?>
						<div class="form-group validation_title">
							<label class="control-label col-sm-2 col-xs-12">Thời gian làm bài</label>
							<div class="col-sm-10 col-xs-12 validation_form">
								<input required type="text" name="test_time" value="<?php echo $row['test_time']; ?>" placeholder="Thời gian làm bài" class="form-control">
							</div>
		                </div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>

<script>
    $(document).ready(function () {

        CKEDITOR.addTemplates("default", {
            imagesPath: CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates") + "templates/images/"),
            templates: [
                {
                    title: "Question Explain",
                    image: "template1.gif",
                    description: "Giải thích câu hỏi",
                    html: '<p style="display: inline;">'
                        + '<span class="tilte_explain_question" style="display: inline; font-weight:bold; padding-right: 5px; padding-left: 5px; background-color: #ff8e3d; color:#463a41">1</span>'
                        + '<span class="content_explain_question" style="display: inline; padding-right: 5px; padding-left: 5px; background: #eeff00; ">Nội dung câu hỏi</span>'
                        + '</p>',


                },
            ]
        });
    });

</script>