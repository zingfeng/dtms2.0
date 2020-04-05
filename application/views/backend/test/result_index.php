<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pDelete = $this->permission->check_permission_backend('result_delete');
?>
<!-- page content -->
<div id="test_lists" class="page-lists">

	<div class="clearfix"></div>
	<form action="" method="GET">
	<div id="filter-data">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $this->lang->line("common_filter_submit"); ?></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content" style="display: none;">
				<div class="col-tn-12 col-xs-6 col-sm-3 form-group">
					<label class="control-label">Loại test</label>
					<select class="form-control" name="type">
						<option <?php if ($type == 'listening') echo 'selected'; ?> value="listening">Listening</option>
						<option <?php if ($type == 'reading') echo 'selected'; ?> value="reading">Reading</option>
						<option <?php if ($type == 'writing') echo 'selected'; ?> value="writing">Writing</option>
						<option <?php if ($type == 'speaking') echo 'selected'; ?> value="speaking">Speaking</option>
						<option <?php if ($type == 'fulltest') echo 'selected'; ?> value="fulltest">Fulltest</option>
					</select>
	            </div>
	            <div class="col-tn-12 col-xs-12 form-group">
	            	<button class="btn btn-primary reset" type="button"><?php echo $this->lang->line("common_reset"); ?></a>
					<button class="btn btn-success" type="submit"><?php echo $this->lang->line("common_filter_submit"); ?></button>
	            </div>
			</div>
		</div>
	</div>
	</form>
	<div class="clearfix"></div>
	<form class="ajax-delete-form" action="" method="POST">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Đánh giá kết quả <?php echo strtoupper($type) ?></h2>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
					<div class="table-responsive">
						<?php if ($rows) { ?>
						<table class="table table-striped jambo_table table-bordered">
							<thead id="checkbox_all">
								<tr class="headings">
									<?php if ($pDelete) { ?>
									<th width="20px">
										<input type="checkbox" class="inputCheckAll">
									</th>
									<?php } ?>
									<th class="column-title">Khoảng điểm</th>
									<th class="column-title">Kết quả</th>
									<th class="column-title">Gợi ý học tập</th>
									<th class="column-title">Thời gian tạo</th>
									<th class="column-title">Action</th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php 
								foreach ($rows as $key => $row) { ?>
								<tr>
									<?php if ($pDelete) { ?>
									<td class="a-center ">
										<input type="checkbox" value="<?php echo $row['id']; ?>" class="inputSelect" name="cid[]">
									</td>
									<?php } ?>
									<td><?php echo $row['score_min'].' - '.$row['score_max']; ?></td>
									<td>
										<?php echo $row['result']?>	
									</td>
									<td><?php echo $row['suggest']; ?></td>
									<td><?php echo date('d/m/Y H:i:s',$row['create_time']); ?></td>
									<td class="action last" align="center">
										<?php if ($this->permission->check_permission_backend('result_edit')) { ?>
										<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_edit"); ?>" href="<?php echo SITE_URL; ?>/test/result_edit/<?php echo $row['id']; ?>">
											<i class="fa fa-edit"></i>
										</a>
										<?php } ?>
										<?php if ($pDelete) { ?>
										<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['id']; ?>" href="javascript:void(0)" rel="nofollow">
											<i class="fa fa-trash"></i>
										</a>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php }else{?>
						<div class="no-result"><?php echo $this->lang->line("common_no_result"); ?></div>
						<?php } ?>
						<?php echo $paging; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="page-title scroll_action">
		<div class="title_left">
			<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
			<?php if ($this->permission->check_permission_backend('result_add')) {?>
				<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/test/result_add?type=<?php echo $type?>">Thêm nhận xét</a>
			<?php } ?>
		</div>
	</div>
	</form>
</div>
<?php if ($filter) {?>
<script type="text/javascript">
	var filtering = 1;
</script>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#log_start_time,#log_end_time").datetimepicker({
			format: 'd/m/Y H:i:s',
			step: 5
		});
	})
</script>