<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pDelete = $this->permission->check_permission_backend('users_delete');
?>
<script src="<?php echo $this->config->item("theme"); ?>vendors/select2/dist/js/select2.full.min.js"></script>
<link href="<?php echo $this->config->item("theme"); ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<!-- page content -->
<div id="topic_lists" class="page-lists">
	<div class="clearfix"></div>
	<form class="ajax-delete-form" action="" method="POST">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><?php echo $this->lang->line('common_mod_course_user_index'); ?>: <?php echo $course_detail['title'];?></h2> 
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
									<th class="column-title"><?php echo $this->lang->line("course_user_name"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("course_user_email"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("course_user_phone"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("course_user_createtime"); ?></th>
									<th class="column-title">Số bài test đã làm</th>
									<th class="column-title">Điểm trung bình</th>
									<th class="column-title no-link last" width="70px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php foreach ($rows as $key => $row) { ?>
								<tr>
									<?php if ($pDelete) { ?>
									<td class="a-center ">
										<input type="checkbox" value="<?php echo $row['course_id'].'|'.$row['user_id']; ?>" class="inputSelect" name="cid[]">
									</td>
									<?php } ?>
									<td>
										<span data-toggle="modal"  data-target="#modal_user<?php echo $row['user_id']; ?>">
											<?php echo $row['fullname']; ?>
										</span>
									</td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['phone']; ?></td>
									<td><?php echo date('H:i d/m/Y', $row['create_time']); ?></td>
									<td><?php echo count($test_log[$row['user_id']]) ?></td>
									<td>
										<?php if(count($test_log[$row['user_id']])) { ?>
											<?php echo array_sum(array_column($test_log[$row['user_id']], 'score')) / count($test_log[$row['user_id']])?>
										<?php } ?>
									</td>
									<td class="action last">
										<?php if ($pDelete) { ?>
										<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['course_id'].'|'.$row['user_id']; ?>" href="javascript:void(0)" rel="nofollow">
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
			<button class="btn btn-primary" type="button" data-toggle="modal"  data-target="#modal_add_user"><?php echo $this->lang->line("course_user_add"); ?></button>
		</div>
	</div>
	</form>
</div>



<div class="modal fade" id="modal_add_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line("course_user_add"); ?></h4>
            </div>
            <div class="modal-body">
        		<form class="form-horizontal form-label-left ajax-submit-form" method="POST" action="<?php echo SITE_URL?>/course/users_add">
        			<input type="hidden" value="<?php echo $course_detail['course_id'];?>" name="course_id">
        			<div class="form-group">
						<label class="control-label col-sm-2 col-xs-12">Học viên</label>
						<div class="col-sm-10 col-xs-12">
							<select required multiple name="users[]" id="suggest_users" class="form-control" placeholder="Học viên"></select>


						</div>
	                </div>
	                <div class="form-group">
						<label class="control-label col-sm-2 col-xs-12"></label>
						<div class="col-sm-10 col-xs-12">
							<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
						</div>
	                </div>
        		</form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<?php foreach ($rows as $key => $row) { ?>
<div class="modal fade" id="modal_user<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabe<?php echo $row['user_id']; ?>l">Chi tiết các bài test</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên bài test</th>
                        <th>Kỹ năng</th>
                        <th>Kiểu bài test</th>
                        <th>Thời gian làm test</th>
                        <th>Điểm</th>
                        <th>Xem lại</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $stt_ = 1 ;

                    $arr_test_type_convert = array(
                            1 => 'Listening',
                            2 => 'Reading',
                            3 => 'Writing',
                            4 => 'Speaking',
                    );
                    foreach ($test_log[$row['user_id']] as $arr_test){
                        $type_test = 'Monotest';
                        if (isset($arr_test['timestamp_fulltest'])){
                            if ($arr_test['timestamp_fulltest'] > 0 ){
                                $type_test = "Fulltest";
                            }
                        }

                        echo '<tr>
                                    <td>'.$stt_.'</td>
                                    <td>'.$arr_test_name[$arr_test['test_id']] . '</td>                                    
                                    <td>'.$arr_test_type_convert[$arr_test['test_type']].'</td>
                                    <td>'.$type_test.'</td>
                                    <td>'.date('d/m/Y - H:i',$arr_test['end_time']).'</td>
                                    <td>'. $arr_test['score'].'</td>
                                    <td>
                                        <a class="btn" href="/test/review_result/'.$arr_test['logs_id'].'/'.$this->security->generate_token_post($arr_test['logs_id']).'"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>';

                        $stt_ ++ ;
                    }?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {
		//suggest teacher
		var initialTeacher = [];
		$("#suggest_users").select2({
			allowClear: true,
			width: '100%',
			placeholder: 'Chọn học viên ...',
			ajax: {
				url: SITE_URL + "/users/suggest",
				dataType: 'json',
				delay: 250,
				data: function (params) {
					return {
						term: params.term, // search term
						page: params.page,
					};
				},
				processResults: function (data, params) {
					console.log(data);
				  	params.page = params.page || 1;
				  	return {
						results: data.data,
						pagination: {
							more: data.option.nextpage
						}
				  	};
		  		},
		  		cache: true
			},
			minimumInputLength: 0,
			templateSelection: function(data) {
				if (typeof (data.item_id) != 'undefined') {
					$("#suggest_teacher option[value="+data.item_id+"]").attr("selected", "selected");
				}
				
				return data.text;
			}
		});
	});


</script>