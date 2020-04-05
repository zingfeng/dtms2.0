<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pDelete = $this->permission->check_permission_backend('delete');
?>
<!-- page content -->
<div id="cate_lists" class="page-lists">
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
					<label class="control-label"><?php echo $this->lang->line("users_email"); ?></label>
					<input type="text" name="email" value="<?php echo $filter['email']; ?>" placeholder="<?php echo $this->lang->line("users_email"); ?>" class="form-control">
	            </div>
	            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
					<label class="control-label"><?php echo $this->lang->line("users_active"); ?></label>
					<select class="form-control" name="active">
						<option value=""><?php echo $this->lang->line("common_all"); ?></option>
						<option value="0" <?php if (isset($filter['active']) && $filter['active'] == 0) echo 'selected'; ?>><?php echo $this->lang->line("users_inactive"); ?></option>
						<option value="1" <?php if (isset($filter['active']) && $filter['active'] == 1) echo 'selected'; ?>><?php echo $this->lang->line("users_active"); ?></option>
					</select>
	            </div>
	            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
					<label class="control-label">Start Time</label>
					<input type="text" name="from_date" id="log_start_time" value="<?php echo date('d/m/Y H:i:s',$filter['from_date']); ?>" placeholder="Thời gian từ" class="form-control">
	            </div>
	            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
					<label class="control-label">End Time</label>
					<input type="text" name="to_date" id="log_end_time" value="<?php echo date('d/m/Y H:i:s',$filter['to_date']); ?>" placeholder="Thời gian kết thúc" class="form-control">
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
					<h2><?php echo $this->lang->line("common_mod_users_index"); ?></h2>
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
									<th class="column-title"><?php echo $this->lang->line("users_fullname"); ?></th>
									<th class="column-title" width="200px"><?php echo $this->lang->line("users_email"); ?></th>
									<th class="column-title" width="150px"><?php echo $this->lang->line("users_date_reg"); ?> </th>
									<th class="column-title" width="100px" align="center"><?php echo $this->lang->line("users_active"); ?> </th>
									<th class="column-title no-link last" width="70px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php 
								foreach ($rows as $key => $row) { ?>
								<tr>
									<?php if ($pDelete) { ?>
									<td class="a-center ">
										<input type="checkbox" value="<?php echo $row['user_id']; ?>" class="inputSelect" name="cid[]">
									</td>
									<?php } ?>
									<td><?php echo $row['fullname']; ?></td>
									
									<td><?php echo $row['email']; ?></td>
									<td><?php echo date('d/m/Y H:i:s',$row['create_time']); ?></td>
									<td align="center"><?php echo tmp_check_status($row['active']); ?></td>
									<td class="action last">
										<?php if ($this->permission->check_permission_backend('edit')) { ?>
										<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_edit"); ?>" href="<?php echo SITE_URL; ?>/users/edit/<?php echo $row['user_id']; ?>">
											<i class="fa fa-edit"></i>
										</a>
										<?php } ?>
										<?php if ($pDelete) { ?>
										<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['user_id']; ?>" href="javascript:void(0)" rel="nofollow">
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
			<?php if ($pDelete) { ?>
			<button class="btn btn-success ajax-delete-button" type="submit"><?php echo $this->lang->line("common_delete"); ?></button>
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