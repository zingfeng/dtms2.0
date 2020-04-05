<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pDelete = $this->permission->check_permission_backend('delete');
$configModule = $this->config->item("block");
$arrPosition = array();
foreach ($configModule as $k => $v) {
	$arrPosition = array_merge($arrPosition,$v['position']);
}
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
					<label class="control-label"><?php //echo $this->lang->line("block_module"); ?></label>
					<select class="form-control" name="module">
						<option value=""><?php echo $this->lang->line("block_module"); ?></option>
						<?php foreach ($configModule as $key => $module) { ?>
						<option value="<?php echo $key; ?>"><?php echo $module['name']; ?></option>
						<?php } ?>
					</select>
	            </div>
	            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
					<label class="control-label"><?php echo $this->lang->line("block_publish"); ?></label>
					<select class="form-control" name="publish">
						<option value=""><?php echo $this->lang->line("common_all"); ?></option>
						<option value="0" <?php if (isset($filter['publish']) && $filter['publish'] == 0) echo 'selected'; ?>><?php echo $this->lang->line("common_unpublish"); ?></option>
						<option value="1" <?php if (isset($filter['publish']) && $filter['publish'] == 1) echo 'selected'; ?>><?php echo $this->lang->line("common_publish"); ?></option>
					</select>
	            </div>
	            <div class="col-tn-12 col-xs-6 col-sm-3 form-group">
					<label class="control-label"><?php echo $this->lang->line("block_position"); ?></label>
					<select class="form-control" name="position">
						<option value=""><?php echo $this->lang->line("block_position"); ?></option>
						<?php foreach ($arrPosition as $key => $position) { ?>
						<option <?php if ($filter['position'] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $position; ?></option>
						<?php } ?>
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
					<h2><?php echo $this->lang->line("common_mod_block_index"); ?></h2>
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
									<th class="column-title" width="15px" >ID</th>
									<th class="column-title" width="150px">Tiêu đề</th>
									<th class="column-title" width="90px">Nội dung</th>
									<th class="column-title" width="70px">Link</th>
									<th class="column-title" width="90px">Avarta</th>
									<th class="column-title" width="90px">Người tạo</th>
									<th class="column-title" width="90px">Thời gian tạo</th>
									<th class="column-title" width="90p">Hành động</th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php
								foreach ($rows as $key => $row) { ?>
								<tr>
									<?php if ($pDelete) { ?>
									<td class="a-center ">
										<input type="checkbox" value="<?php echo $row['id_noti']; ?>" class="inputSelect" name="cid[]">
									</td>
									<?php } ?>
									<td><?php echo $row['id_noti']; ?></td>
									<td><?php echo $row['title']; ?></td>
									<td><?php echo $row['content']; ?></td>
									<td><a href="<?php echo $row['link']; ?>" target="_blank"><?php echo $row['link']; ?></a></td>
									<td> <img src="<?php echo ($row['avarta']) ? getimglink($row['avarta'],'size2') : $this->config->item("img").'default_image.jpg'; ?>" style="width: 50px;" /></td>
									<td><?php echo $row['creator']; ?></td>
									<td><?php echo date('d/m/y - H:i:s', $row['creat_time']); ?></td>
									<td class="action last">
										<?php if ($this->permission->check_permission_backend('edit')) { ?>
										<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_edit"); ?>" href="<?php echo SITE_URL; ?>/noti/edit/<?php echo $row['id_noti']; ?>">
											<i class="fa fa-edit"></i>
										</a>
										<?php } ?>
<!--										--><?php //if ($this->permission->check_permission_backend('copy')) { ?>
<!--										<a data-toggle="tooltip" data-placement="top" title="--><?php //echo $this->lang->line("common_copy"); ?><!--" href="--><?php //echo SITE_URL; ?><!--/block/copy/--><?php //echo $row['block_id']; ?><!--">-->
<!--											<i class="fa fa-copy"></i>-->
<!--										</a>-->
<!--										--><?php //} ?>
										<?php if ($pDelete) { ?>
										<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['id_noti']; ?>" href="javascript:void(0)" rel="nofollow">
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
			<?php if ($this->permission->check_permission_backend('add')) {?>
			<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/block/add"><?php echo $this->lang->line("common_mod_block_add"); ?></a>
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
