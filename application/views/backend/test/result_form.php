<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$answer_list = json_decode($row['answer_list'], true);
$score_detail = json_decode($row['score_detail'], true);
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
	<div class="form-group">	
		<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
		<?php if ($this->permission->check_permission_backend('result')) {?>
		<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/test/result?type=<?php echo $type?>">Danh sách</a>
		<?php } ?>
		<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
		<?php if ($row['id']) { ?>
		<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['id']) ?>"/>
		<?php } ?>
		<input  type="hidden" name="type" value="<?php echo $type ?>"/>
	</div>
	<div class="row tab-pane">
		<div class="col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Đánh giá kết quả test</h2>
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
						<label class="control-label col-sm-2 col-xs-12">Điểm số từ</label>
						<div class="col-sm-4 col-xs-12">
							<input required type="number" step="0.5" min="0" max="9" name="score_min" value="<?php echo $row['score_min']; ?>" placeholder="Từ điểm" class="form-control">
						</div>
						<label class="control-label col-sm-2 col-xs-12">Đến</label>
						<div class="col-sm-4 col-xs-12">
							<input required type="number" step="0.5" min="0" max="9" name="score_max" value="<?php echo $row['score_max']; ?>" placeholder="Đến" class="form-control">
						</div>
	                </div>
	                <div class="form-group ckeditor_detail">
						<label class="control-label col-sm-2 col-xs-12">Kết quả</label>
						<div class="col-sm-10 col-xs-12">
							<textarea name="result" class="form-control" placeholder="Kết quả" rows="3"><?php echo $row['result']; ?></textarea>
						</div>
	                </div>
	                <div class="form-group ckeditor_detail">
						<label class="control-label col-sm-2 col-xs-12">Gợi ý học tập</label>
						<div class="col-sm-10 col-xs-12">
							<textarea name="suggest" class="form-control" placeholder="Gợi ý học tập" rows="3"><?php echo $row['suggest']; ?></textarea>
						</div>
	                </div>
				</div>
			</div>
		</div>
	</div>
</form>