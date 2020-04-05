<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$topic_type = $this->config->item("topic_course_type");
$pDelete = $this->permission->check_permission_backend('topic_delete');
?>
<!-- page content -->
<div id="topic_lists" class="page-lists">
	<div class="clearfix"></div>
	<form class="ajax-delete-form" action="" method="POST">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><?php echo $this->lang->line('common_mod_course_topic_index'); ?>: <?php echo $course_detail['title'];?></h2> 
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
									<th class="column-title"><?php echo $this->lang->line("course_topic_name"); ?></th>
									<th class="column-title" width="70px"><?php echo $this->lang->line("course_topic_ordering"); ?> </th>
									<th class="column-title" width="160px">Thêm tiết học </th>
									<th class="column-title" width="160px">Chấm điểm</th>
									<th class="column-title" width="160px">Kết quả của học viên</th>
									<th class="column-title no-link last" width="70px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php 
								foreach ($rows as $key => $row) { ?>
								<tr>
									<?php if ($pDelete) { ?>
									<td class="a-center ">
										<input type="checkbox" value="<?php echo $row['topic_id']; ?>" class="inputSelect" name="cid[]">
									</td>
									<?php } ?>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['ordering']; ?></td>
									<td align="center">
										<?php if ($this->permission->check_permission_backend('class_add')) { ?>
										<a title="Thêm tiết học" href="<?php echo SITE_URL; ?>/course/class_add/<?php echo $row['topic_id']; ?>">
											Thêm
										</a>
										<?php }?>
									</td>
									<td align="center">
									</td>
									<td align="center">
									</td>
									<td class="action last">
										<?php if ($this->permission->check_permission_backend('topic_edit')) { ?>
										<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_edit"); ?>" href="<?php echo SITE_URL; ?>/course/topic_edit/<?php echo $row['topic_id']; ?>">
											<i class="fa fa-edit"></i>
										</a>
										<?php } ?>
										<?php if ($pDelete) { ?>
										<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['topic_id']; ?>" href="javascript:void(0)" rel="nofollow">
											<i class="fa fa-trash"></i>
										</a>
										<?php } ?>
									</td>
									
								</tr>
								<?php if($row['class']){?>
									<?php foreach($row['class'] as $class){?>
									<tr>
										<?php if ($pDelete) { ?>
										<td></td>
										<?php } ?>
										<td><?php echo $class['title']; ?></td>
										<td></td>
										<td align="center">
										</td>
										<td align="center">
											<?php if ($this->permission->check_permission_backend('class_point') && $class['type'] == 2) { ?>
											<a title="Chấm điểm" href="<?php echo SITE_URL; ?>/course/class_point/<?php echo $class['class_id']; ?>">
												Chấm điểm
											</a>
											<?php }?>
										</td>
										<td align="center">
											<?php if ($this->permission->check_permission_backend('class_score') && $class['count_test']) { ?>
												<a data-toggle="modal" data-target="#modal_score" href="<?php echo SITE_URL; ?>/course/class_score/<?php echo $class['class_id']; ?>" data-remote="false">
													Điểm học viên
												</a>
											<?php }?>
										</td>
										<td class="action last">
											<?php if ($this->permission->check_permission_backend('topic_edit')) { ?>
											<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_edit"); ?>" href="<?php echo SITE_URL; ?>/course/class_edit/<?php echo $class['class_id']; ?>">
												<i class="fa fa-edit"></i>
											</a>
											<?php } ?>
											<?php if ($pDelete) { ?>
											<a class="quick-delete" data-toggle="tooltip" data-placement="top" data-type="class" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $class['class_id']; ?>" href="javascript:void(0)" rel="nofollow">
												<i class="fa fa-trash"></i>
											</a>
											<?php } ?>
										</td>
										
									</tr>
									<?php } ?>
								<?php } ?>
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
		<div class="title_left">
			<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
			<?php if ($pDelete) { ?>
			<button class="btn btn-success ajax-delete-button" type="submit"><?php echo $this->lang->line("common_delete"); ?></button>
			<?php } ?>
		</div>
	</div>
	</form>
</div>

<div class="modal fade" id="modal_score" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:1250px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Điểm học viên</h4>
            </div>
            <div class="modal-body">
        		
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$("#modal_score").on("show.bs.modal", function(e) {
	    var link = $(e.relatedTarget);
	    $(this).find(".modal-body").load(link.attr("href"));
	});
</script>