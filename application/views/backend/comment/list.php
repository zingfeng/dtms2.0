<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pDelete = $this->permission->check_permission_backend('delete');
?>
<!-- page content -->
<div id="comment_lists" class="page-lists">
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
					<label class="control-label">Start Time</label>
					<input type="text" name="from_date" id="comment_start_time" value="<?php echo $filter['from_date'] ? date('d/m/Y H:i:s',$filter['from_date']) : ''; ?>" placeholder="Thời gian từ" class="form-control">
	            </div>
	            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
					<label class="control-label">End Time</label>
					<input type="text" name="to_date" id="comment_end_time" value="<?php echo $filter['to_date'] ? date('d/m/Y H:i:s',$filter['to_date']) : ''; ?>" placeholder="Thời gian kết thúc" class="form-control">
	            </div>
	            <div class="col-tn-12 col-xs-12 form-group">
                    <button class="btn btn-primary reset"
                            type="button"><?php echo $this->lang->line("common_reset"); ?></button>
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
					<h2><?php echo $this->lang->line("common_mod_comment_index"); ?></h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
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
									<th class="column-title"><?php echo $this->lang->line("comment_target"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("comment_content"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("comment_user"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("comment_create_time"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("comment_status"); ?> </th>
									<?php if ($pDelete) { ?>
									<th class="column-title no-link last" width="70px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php 
								foreach ($rows as $key => $row) { ?>
									<tr>
										<?php if ($pDelete) { ?>
										<td class="a-center ">
											<input type="checkbox" value="<?php echo $row['comment_id']; ?>" class="inputSelect" name="cid[]">
										</td>
										<?php } ?>
										<td>
											<?php echo get_target_comment($row); ?>
										</td>
										<td>
											<?php echo $row['content']?><br>
										</td>
										<td>
											Fullname: <b><?php echo $row['fullname']?></b><br> 
											Email: <b><?php echo $row['email']?></b>
										</td>
										<td><?php echo date("H:i d/m/Y", $row['time_creat'])?></td>
										<td align="center">
											<?php if ($this->permission->check_permission_backend('change_status')) {?>
												<a href="javascript:;" class="change_status" data-id="<?php echo $row['comment_id']; ?>" title="Đổi trạng thái">
													<?php echo tmp_check_status($row['status']); ?>
												</a>
											<?php }else{ ?>
												<?php echo tmp_check_status($row['status']); ?>
											<?php }?>
										</td>
										<?php if ($pDelete) { ?>
										<td class="action last">
											<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['comment_id']; ?>" href="javascript:void(0)" rel="nofollow">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<?php } ?>
									</tr>
									<?php if($row['child']) { ?>
										<?php foreach($row['child'] as $row) { ?>
											<tr>
												<?php if ($pDelete) { ?>
												<td class="a-center ">
													<input type="checkbox" value="<?php echo $row['comment_id']; ?>" class="inputSelect" name="cid[]">
												</td>
												<?php } ?>
												<td align="center">
													-----
												</td>
												<td style="width: 30%">
													-- <?php echo $row['content']?><br>
												</td>
												<td>
													Fullname: <b><?php echo $row['fullname']?></b><br> 
													Email: <b><?php echo $row['email']?></b>
												</td>
												<td><?php echo date("H:i d/m/Y", $row['time_creat'])?></td>
												<td align="center">
													<?php if ($this->permission->check_permission_backend('change_status')) {?>
														<a href="javascript:;" class="change_status" data-id="<?php echo $row['comment_id']; ?>" title="Đổi trạng thái">
															<?php echo tmp_check_status($row['status']); ?>
														</a>
													<?php }else{ ?>
														<?php echo tmp_check_status($row['status']); ?>
													<?php }?>
												</td>
												<?php if ($pDelete) { ?>
												<td class="action last">
													<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['comment_id']; ?>" href="javascript:void(0)" rel="nofollow">
														<i class="fa fa-trash"></i>
													</a>
												</td>
												<?php } ?>
											</tr>
										<?php }?>
									<?php } ?>
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
		$("#comment_start_time,#comment_end_time").datetimepicker({
			format: 'd/m/Y H:i:s',
			step: 5
		});

		$(".change_status").click(function () {
			var r = confirm("Bạn muốn đổi trạng thái của bình luận?");
			if (r == true) {
	            $.ajax({
					type: 'POST',
					url: "/admin/comment/change_status",
					data: {id: $(this).data('id')}, // serializes the form's elements.
					dataType: 'json',
					success: function(data)
					{
						if (data.status == 'success') {
							new PNotify({
								title: 'Success',
								text: data.message,
								type: 'success',
								styling: 'bootstrap3',
								delay: 2000,
								mouse_reset: false
							});
							$("#content_for_layout").html(data.html);
							lists_script();
						}
						else {
							new PNotify({
								title: 'Error',
								text: data.message,
								type: 'error',
								styling: 'bootstrap3',
								delay: 2000,
								mouse_reset: false
							});
						}
					},
					error: function(e){
				   		show_notify_error();
				   	}
				});
			}
            
        });
	});

</script>