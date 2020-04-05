<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pDelete = $this->permission->check_permission_backend('delete');
$arrBranch = array(
	1 => 'Cơ sở Hà Nội',
	2 => 'Cơ sở HCM',
	3 => 'Cơ sở Đà Nẵng',
	9 => "Khác"
)
?>
<!-- page content -->
<div id="contact_lists" class="page-lists">
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
						<label class="control-label"><?php echo $this->lang->line("contact_fullname"); ?></label>
						<input type="text" name="fullname" value="<?php echo $filter['fullname']; ?>" placeholder="<?php echo $this->lang->line("contact_fullname"); ?>" class="form-control">
		            </div>
		            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
						<label class="control-label">Loại</label>
						<select class="form-control" name="type">
							<option value="">Loại</option>
							<option value="1" <?php if ($filter['type'] == 1) echo 'selected'; ?>>Liên hệ</option>
                            <option value="2" <?php if ($filter['type'] == 2) echo 'selected'; ?>>Đăng ký tư vấn
                            </option>
                            <option value="3" <?php if ($filter['type'] == 3) echo 'selected'; ?>>Đăng ký làm test
                            </option>
                            <option value="4" <?php if ($filter['type'] == 4) echo 'selected'; ?>>Đăng ký offline
                            </option>
                            <option value="5" <?php if ($filter['type'] == 5) echo 'selected'; ?>>Đăng ký nhận tài
                                liệu
                            </option>
						</select>
		            </div>
		            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
						<label class="control-label">Start Time</label>
						<input type="text" name="from_date" id="contact_start_time" value="<?php echo date('d/m/Y H:i:s',$filter['from_date']); ?>" placeholder="Thời gian từ" class="form-control">
		            </div>
		            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
						<label class="control-label">End Time</label>
						<input type="text" name="to_date" id="contact_end_time" value="<?php echo date('d/m/Y H:i:s',$filter['to_date']); ?>" placeholder="Thời gian kết thúc" class="form-control">
		            </div>
		            <div class="col-tn-12 col-xs-12 form-group">
                        <a class="btn btn-warning" target="_blank"
                           href="<?php echo SITE_URL . "/contact/export" . (($this->input->get()) ? "?" . http_build_query($this->input->get()) : ''); ?>">Export</a>
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
					<h2><?php echo $this->lang->line("common_mod_contact_index"); ?></h2>
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
									<th class="column-title"><?php echo $this->lang->line("contact_fullname"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("contact_content"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("contact_email"); ?></th>
									<th class="column-title"><?php echo $this->lang->line("contact_phone"); ?> </th>
                                        <th class="column-title">Url đăng ký</th>
                                        <th class="column-title">Ngày sinh</th>
                                        <th class="column-title">Địa chỉ - Khu vực</th>
                                        <th class="column-title">Cơ sở - Địa điểm Offline</th>
									<th class="column-title"><?php echo $this->lang->line("contact_create_time"); ?> </th>
									<th class="column-title"><?php echo $this->lang->line("contact_type"); ?> </th>
									<th class="column-title"><?php echo $this->lang->line("contact_status"); ?> </th>
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
										<input type="checkbox" value="<?php echo $row['contact_id']; ?>" class="inputSelect" name="cid[]">
									</td>
									<?php } ?>
									<td><?php echo $row['fullname']; ?></td>
									<td class="content" id="contact-content-<?php echo $row['contact_id']; ?>">
										<div class="content_desc">
											<?php echo cut_text($row['content'],300); ?>
											<div class="readmore" data-toggle="collapse" data-id="<?php echo $row['contact_id']; ?>">
												<?php echo $this->lang->line("common_read_more"); ?><i class="fa fa-angle-double-right"></i>
											</div>	
										</div>						
										<div class="content_full" style="display: none;">
											<?php echo $row['content']; ?>
											<div class="collapse_button" data-id="<?php echo $row['contact_id']; ?>"><?php echo $this->lang->line("common_collapse"); ?><i class="fa fa-chevron-up"></i></div>
										</div>
									</td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['phone']; ?></td>
                                            <td title="<?php echo $row['url']; ?>"><?php echo $row['url']; ?></td>
                                            <td title="<?php echo $row['dateofbirth']; ?>"><?php
                                                if ($row['dateofbirth'] !== '0000-00-00') {
                                                    echo $row['dateofbirth'];
                                                }
                                                ?></td>
                                            <td><?php
                                                if (trim($row['address']) != '') {
                                                    echo 'Địa chỉ: ' . $row['address'] . '<br>';
                                                }
                                                if (trim($row['live_area']) != '') {
                                                    echo 'Khu vực: ' . $row['live_area'];
                                                }

                                                ?></td>
                                            <td><?php
                                                if (trim($arrBranch[$row['branch']]) != '') {
                                                    echo 'Chi nhánh: ' . $arrBranch[$row['branch']] . '<br>';
                                                }
                                                if (trim($arrOfflinePlace[$row['offline_place']]) != '') {
                                                    echo 'Địa điểm Offline: ' . $arrOfflinePlace[$row['offline_place']];
                                                }
                                                ?></td>

									<td><?php echo date('d/m/Y H:i:s',$row['create_time']); ?></td>
                                            <td><?php switch ($row['type']) {
                                                    case 1:
                                                        echo "Liên hệ";
                                                        break;
                                                    case 2:
                                                        echo "Đăng ký tư vấn";
                                                        break;
                                                    case 3:
                                                        echo "Đăng ký làm test";
                                                        break;
                                                    case 4:
                                                        echo "Đăng ký offline";
                                                        break;
                                                    case 5:
                                                        echo "Đăng ký nhận tài liệu";
                                                        break;
                                                } ?></td>
									<td align="center"><?php echo tmp_check_status($row['status']); ?></td>
									<?php if ($pDelete) { ?>
									<td class="action last">
										<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['contact_id']; ?>" href="javascript:void(0)" rel="nofollow">
											<i class="fa fa-trash"></i>
										</a>
									</td>
									<?php } ?>
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
			<?php if ($this->permission->check_permission_backend('cate_add')) {?>
			<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/news/cate_add"><?php echo $this->lang->line("common_mod_news_cate_add"); ?></a>
			<?php } ?>
			<button class="btn btn-success ajax-update-button" data-action="<?php echo SITE_URL; ?>/contact/edit" type="button"><?php echo $this->lang->line("contact_update_status"); ?></button>
			<?php if ($pDelete) { ?>
			<button class="btn btn-success ajax-delete-button" type="submit"><?php echo $this->lang->line("common_delete"); ?></button>
			<?php } ?>
		</div>
	</div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		contact_lists_script();
	})
	
</script>
<?php if ($filter) {?>
<script type="text/javascript">
	var filtering = 1;
</script>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#contact_start_time,#contact_end_time").datetimepicker({
			format: 'd/m/Y H:i:s',
			step: 5
		});

        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();

        $("#download_excel").click(function () {
            $.post("/admin/contact/export",
                {
                    from_date: from_date,
                    to_date: to_date,
                },
                function (data, status) {

                });
        });
	})
	
</script>