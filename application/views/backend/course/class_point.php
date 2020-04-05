<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$topic_type = $this->config->item("topic_course_type");
?>
<!-- page content -->
<div id="topic_lists" class="page-lists">
	<div class="clearfix"></div>
	<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Bảng điểm học viên: <?php echo $row['title'];?></h2> 
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
					<div class="table-responsive">
						<?php if ($users) { ?>
							<input type="hidden" name="test_id" value="<?php echo $test['test_id']?>">
							<table class="table table-striped jambo_table table-bordered">
								<thead id="checkbox_all">
									<tr class="headings">
										<th width="20px">
											STT
										</th>
										<th class="column-title" width="200px">Tên học viên </th>
										<th class="column-title" width="160px">Điểm</th>
									</tr>
								</thead>
								<tbody id="checkbox_list">
									<?php 
									foreach ($users as $key => $row) { ?>
									<tr>
										<td class="a-center ">
											<?php echo $key+1 ?>
										</td>
										<td><?php echo $row['fullname']; ?></td>
										<td><input type="number" step="0.5" min="0" max="9" name="point[<?php echo $row['user_id']?>]" value="<?php echo $row['point']; ?>" placeholder="Điểm học viên" class="form-control"></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						<?php }else{?>
						<div class="no-result"><?php echo $this->lang->line("common_no_result"); ?></div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="page-title scroll_action">
		<div class="form-group">	
			<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
			<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
		</div>
	</div>
	</form>
</div>
