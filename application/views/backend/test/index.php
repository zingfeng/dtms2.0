<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pDelete = $this->permission->check_permission_backend('delete');
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
					<label class="control-label">Nhóm</label>
					<select class="form-control" name="cate_id">
						<option value="">Nhóm</option>
						<?php foreach ($arrCate as $key => $cate) { ?>
						<option <?php if ($filter['cate_id'] == $cate['cate_id']) echo 'selected'; ?> value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['name']; ?></option>
						<?php } ?>
					</select>
	            </div>
	            <div class="col-tn-12 col-xs-12 form-group">
	            	<button class="btn btn-primary reset" type="button"><?php echo $this->lang->line("common_reset"); ?></button>
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
					<h2>Danh sách bài test</h2>
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
									<th class="column-title">Tên bài test</th>
									<th class="column-title" width="150px">Nhóm</th>
									<th class="column-title" width="80px">Xuất bản</th>
									<th class="column-title text-center" width="160px">Câu hỏi</th>
									<th class="column-title no-link last" align="center" width="150px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php 
								foreach ($rows as $key => $row) { ?>
								<tr>
									<?php if ($pDelete) { ?>
									<td class="a-center ">
										<input type="checkbox" value="<?php echo $row['test_id']; ?>" class="inputSelect" name="cid[]">
									</td>
									<?php } ?>
								<td><?php echo '<a href="'.$row['share_url'].'" >'.$row['title'].'</a>'; ?></td>
                                    <td>
                                        <a href="<?php echo $arrCate[$row['original_cate']]['share_url']; ?>">
                                            <?php echo $arrCate[$row['original_cate']]['name']; ?>
                                        </a>
                                    </td>
                                    <td align="center"><?php echo tmp_check_status($row['publish']); ?></td>
									<td align="center">
										<?php if ($this->permission->check_permission_backend('question_add')) { ?>
										<a title="Thêm chuyên đề" href="<?php echo SITE_URL; ?>/test/question_add?testid=<?php echo $row['test_id']; ?>">
											Thêm             |
										</a>
										<?php } ?>
										
										<?php if ($this->permission->check_permission_backend('question_index')) { ?>
										<a title="Thêm chuyên đề" href="<?php echo SITE_URL; ?>/test/question_index/<?php echo $row['test_id']; ?>">
											Xem
										</a>
										<?php } ?>
									</td>									
								
									<td class="action last" align="center">
										<?php if ($this->permission->check_permission_backend('edit')) { ?>
										<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_edit"); ?>" href="<?php echo SITE_URL; ?>/test/edit/<?php echo $row['test_id']; ?>">
											<i class="fa fa-edit"></i>
										</a>
										<?php } ?>
										<?php if ($this->permission->check_permission_backend('copy')) { ?>
										<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_copy"); ?>" href="<?php echo SITE_URL; ?>/test/copy/<?php echo $row['test_id']; ?>">
											<i class="fa fa-copy"></i>
										</a>
										<?php } ?>
										<?php if ($pDelete) { ?>
										<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['test_id']; ?>" href="javascript:void(0)" rel="nofollow">
											<i class="fa fa-trash"></i>
										</a>
										<?php } ?>
										<a data-toggle="tooltip" data-placement="top" title="Danh sách làm bài test" href="<?php echo SITE_URL; ?>/test/log_lists?test_id=<?php echo $row['test_id']; ?>" rel="nofollow">
											<i class="fa fa-users" aria-hidden="true"></i>
										</a>
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
			<?php if ($this->permission->check_permission_backend('add')) {?>
			<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/test/add">Thêm bài test</a>
			<?php } ?>
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