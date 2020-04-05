
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$answer_list = json_decode($row['answer_list'], true);
$score_detail = json_decode($row['score_detail'], true);
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('mark_lists')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/test/mark_lists">Danh sách bài test chấm điểm</a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['logs_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['logs_id']) ?>"/>
	<input  type="hidden" name="logs_id" value="<?php echo $row['logs_id'] ?>"/>
	<?php } ?>
</div>
<div class="row">
    <div class="col-sm-12 col-xs-12">
        <ul class="nav nav-tabs">
            <?php foreach($arrQuestion as $key => $item) { ?>
            <li role="presentation" class="active"><a id="detail-tab" href="#answer_<?php echo $key?>" role="tab" data-toggle="tab" aria-controls="test_detail" aria-expanded="false"><?php echo $item['title']?></a></li>
        	<?php } ?>
        </ul>
    </div>
</div>
<?php $index = 1; foreach($answer_list as $key => $answer) { ?>
<div class="row tab-pane" id="answer_<?php echo $key?>" <?php echo $index > 1 ? 'style="display:none"' : '' ?>>
	<div class="col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Answer</h2>
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
					<label class="control-label col-sm-2 col-xs-12">Đề bài:</label>
					<div class="col-sm-10 col-xs-12" style="background: #fff9f2; padding: 10px; ">
						<?php echo $arrQuestion[$key]['question_answer'][0]['content'] ?>
					</div>
                </div>
                <div class="form-group validation_original_cate">
					<label class="control-label col-sm-2 col-xs-12">Điểm</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<select name="result[<?php echo $key?>][score]" class="form-control" placeholder="Chọn điểm">
                            <?php for ($i = 0; $i <= 9; $i += 0.5) { ?>
                            	<option value="<?php echo $i; ?>" <?php echo $score_detail[$key]['score'] == $i ? 'selected' : ''?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
					</div>
					<input type="hidden" name="result[<?php echo $key?>][coefficient]" value="<?php echo $score_detail[$key]['coefficient'] ? : $index?>">
                </div>
                <div class="form-group ckeditor_detail">
					<label class="control-label col-sm-2 col-xs-12">Chữa bài</label>
					<div class="col-sm-10 col-xs-12">
						<textarea name="result[<?php echo $key?>][review]" class="form-control" placeholder="Chữa bài" rows="3"><?php echo $score_detail[$key]['review'] ? : $answer?></textarea>
					</div>
                </div>
                <div class="form-group ckeditor_detail">
					<label class="control-label col-sm-2 col-xs-12">Nhận xét</label>
					<div class="col-sm-10 col-xs-12">
						<textarea name="result[<?php echo $key?>][summary]" class="form-control" placeholder="Nhận xét" rows="3"><?php echo $score_detail[$key]['summary'] ?></textarea>
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
<?php $index++; } ?>
</form>
<script type="text/javascript">
$(document).ready(function() {
	////tab
    $('.nav-tabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show');
        var id_tab = $(this).attr('href');
        $('.tab-pane').hide();
        $(id_tab).show();
    });
	/** DATETIME **/
	$('#publish_time').datetimepicker({
		format: 'd/m/Y H:i:s',
		step: 5
	});
});
</script>