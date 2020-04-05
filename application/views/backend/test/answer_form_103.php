
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
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
				    <label class="control-label col-sm-2 col-xs-12">Câu hỏi</label>
				    <div class="col-sm-10 col-xs-12">
				        <input type="text" name="params" required value="<?php echo ($row['params']) ? implode(json_decode($row['params'],TRUE),"\n") : ''; ?>" placeholder="Cẩu hỏi" class="form-control">
				    </div>
				</div>
			</div>
			<div class="x_content row">
                <div class="form-group">
				    <label class="control-label col-sm-2 col-xs-12">Options</label>
				    <div class="col-sm-10 col-xs-12">
				    	<?php //var_dump(json_decode($row['options'],TRUE)); ?>
				        <textarea require name="options" class="form-control" placeholder="Options" rows="7"><?php echo ($row['options']) ? implode(json_decode($row['options'],TRUE),"\n") : ''; ?></textarea>
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
		</div>
		<div class="x_panel">
			<div class="x_title">
				<h2>Đáp án</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content row">
				<?php 
				$i = 1;
				if ($arrResult) {
					foreach ($arrResult as $key => $rs) { ?>
						<div class="form-group validation_title col-sm-3">
							<label class="control-label">Câu: <?php echo $i; ?></label>
							<input type="text" name="answer[<?php echo $i; ?>]" value="<?php echo $rs['answer']; ?>" placeholder="Trả lời" class="form-control">
		                </div>
					<?php  $i++; }
				} else { ?>

				<div class="form-group validation_title col-sm-3">
					<label class="control-label">Câu: 1</label>
					<input type="text" name="answer[1]" value="" placeholder="Trả lời" class="form-control">
                </div>
					
				<?php } ?>
				
                
			</div>
		</div>
	</div>
</div>
</form>
