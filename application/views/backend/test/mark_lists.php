<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pDelete = $this->permission->check_permission_backend('delete');
$arrType = $this->config->item('test_type');
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
					<label class="control-label">Tên bài test</label>
					<input type="text" name="title" value="<?php echo $filter['keyword']; ?>" placeholder="Tên bài test" class="form-control">
	            </div>
				<div class="col-tn-12 col-xs-6 col-sm-3 form-group">
					<label class="control-label">Trạng thái</label>
					<select class="form-control" name="status">
						<option value="">Tất cả</option>
						<option <?php if ($filter['status'] == 1) echo 'selected'; ?> value="1">Chờ chấm điểm</option>
						<option <?php if ($filter['status'] == 2) echo 'selected'; ?> value="2">Đã hoàn thành</option>
					</select>
	            </div>
	            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
					<label class="control-label">Loại test</label>
					<select class="form-control" name="test_type">
						<option value="">Tất cả</option>
						<option <?php if ($filter['test_type'] == 3) echo 'selected'; ?> value="3">Writing</option>
						<option <?php if ($filter['test_type'] == 4) echo 'selected'; ?> value="4">Speaking</option>
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
					<h2>Danh sách bài test chấm điểm</h2>
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
									<th class="column-title">User</th>
									<th class="column-title">Bài test</th>
									<th class="column-title" width="160px">Điểm</th>
									<th class="column-title">Thời gian</th>
									<th class="column-title">Status</th>
									<th class="column-title">Action</th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php 
								foreach ($rows as $key => $row) { ?>
								<tr>
									<?php if ($pDelete) { ?>
									<td class="a-center ">
										<input type="checkbox" value="<?php echo $row['logs_id']; ?>" class="inputSelect" name="cid[]">
									</td>
									<?php } ?>
									<td><?php echo $row['fullname']; ?></td>
									<td>
										[<?php echo $arrType[$row['test_type']]; ?>]
										<?php if ($row['test_id']) {?><a href="<?php echo SITE_URL?>/test/edit/<?php echo $row['test_id'];?>"><?php echo $row['test_title']; ?></a><?php } else echo '-'; ?></td>
									<td><?php echo $row['score']; ?></td>
									<td><?php echo date('d/m/Y H:i:s',$row['start_time']); ?></td>
									<td>
										<?php echo super_tmp_check_status($row['status']);?>
									</td>
									<td>
										<?php if ($this->permission->check_permission_backend('mark_result')) {?>
											<a class="btn" href="<?php echo SITE_URL?>/test/mark_result/<?php echo $row['logs_id']; ?>"><i class="fa fa-bullseye" aria-hidden="true"></i> Chấm điểm</a>
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