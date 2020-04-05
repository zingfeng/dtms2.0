<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$menuConfig = $this->config->item("menu");
$pDelete = $this->permission->check_permission_backend('delete');
?>
<!-- page content -->
<div id="menu_lists" class="page-lists">
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
						<label class="control-label"><?php echo $this->lang->line("menu_position"); ?></label>
						<select class="form-control" name="position">
							<option value=""><?php echo $this->lang->line("menu_position"); ?></option>
							<?php foreach ($menuConfig['position'] as $key => $menu) { ?>
							<option <?php if ($filter['position'] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $menu; ?></option>
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
					<h2><?php echo $this->lang->line("common_mod_menu_index"); ?></h2>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
					<div class="table-responsive">
						<?php if ($rows) { ?>
						<?php foreach ($rows as $key => $rows) { ?>
						<h3 class="title"><?php echo $menuConfig['position'][$key]; ?></h3>
						<table class="table table-striped jambo_table table-bordered">
							<thead id="checkbox_all">
								<tr class="headings">
									<?php if ($pDelete) { ?>
									<th width="20px">
										<input type="checkbox" class="inputCheckAll">
									</th>
									<?php } ?>
									<th class="column-title"><?php echo $this->lang->line("menu_name"); ?></th>
									<th class="column-title" width="200px"><?php echo $this->lang->line("menu_link"); ?></th>
									<th class="column-title" width="120px"><?php echo $this->lang->line("menu_position"); ?></th>
									<th class="column-title" width="70px"><?php echo $this->lang->line("menu_ordering"); ?> </th>
									<th class="column-title no-link last" width="95px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php 
								foreach ($rows as $key => $row) { ?>
								<tr>
									<?php if ($pDelete) { ?>
									<td class="a-center ">
										<input type="checkbox" value="<?php echo $row['menu_id']; ?>" class="inputSelect" name="cid[]">
									</td>
									<?php } ?>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['link']; ?></td>
									<td><?php echo $row['position']; ?></td>
									<td><?php echo $row['ordering']; ?></td>
							
									<td class="action last">
										<?php if ($this->permission->check_permission_backend('edit')) { ?>
										<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_edit"); ?>" href="<?php echo SITE_URL; ?>/menu/edit/<?php echo $row['menu_id']; ?>">
											<i class="fa fa-edit"></i>
										</a>
										<?php } ?>
										<?php if ($this->permission->check_permission_backend('copy')) { ?>
										<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_copy"); ?>" href="<?php echo SITE_URL; ?>/menu/copy/<?php echo $row['menu_id']; ?>">
											<i class="fa fa-copy"></i>
										</a>
										<?php } ?>
										<?php if ($pDelete) { ?>
										<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['menu_id']; ?>" href="javascript:void(0)" rel="nofollow">
											<i class="fa fa-trash"></i>
										</a>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php } ?>
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
			<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/menu/add"><?php echo $this->lang->line("common_mod_menu_add"); ?></a>
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