<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pDelete = $this->permission->check_permission_backend('delete')
?>
<!-- page content -->
<div id="cate_lists" class="page-lists">
	<div class="clearfix"></div>
	<form class="ajax-delete-form" action="" method="POST">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><?php echo $this->lang->line("users_roles_title"); ?></h2>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
					<div class="table-responsive">
						<?php if ($rows) { ?>
						<table class="table table-striped jambo_table table-bordered">
							<thead id="checkbox_all">
								<tr class="headings">
									<?php if ($pDelete) {?>
									<th width="20px">
										<input type="checkbox" class="inputCheckAll">
									</th>
									<?php } ?>
									<th class="column-title"><?php echo $this->lang->line("users_roles_name"); ?></th>
									<th class="column-title no-link last" width="95px;"><span class="nobr"><?php echo $this->lang->line("common_action"); ?></span></th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php 
								foreach ($rows as $key => $row) { ?>
								<tr>
									<td class="a-center ">
										<input type="checkbox" value="<?php echo $row['roles_id']; ?>" class="inputSelect" name="cid[]">
									</td>
									<td><?php echo $row['name']; ?></td>
									<td class="action last">
										<?php if ($this->permission->check_permission_backend('edit')) {?>
										<a title="<?php echo $this->lang->line("common_edit"); ?>" href="<?php echo SITE_URL; ?>/roles/edit/<?php echo $row['roles_id']; ?>">
											<i class="fa fa-edit"></i>
										</a>
										<?php } ?>
										<?php if ($this->permission->check_permission_backend('copy')) { ?>
										<a data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_copy"); ?>" href="<?php echo SITE_URL; ?>/roles/copy/<?php echo $row['roles_id']; ?>">
											<i class="fa fa-copy"></i>
										</a>
										<?php } ?>
										<?php if ($pDelete) {?>
										<a class="quick-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line("common_delete"); ?>" data-id="<?php echo $row['roles_id']; ?>" href="javascript:void(0)" rel="nofollow">
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
			<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/roles/add"><?php echo $this->lang->line("common_mod_role_add"); ?></a>
			<?php } ?>
			<?php if ($pDelete) {?>
			<button class="btn btn-success ajax-delete-button" type="submit"><?php echo $this->lang->line("common_delete"); ?></button>
			<?php } ?>
		</div>
	</div>
	</form>
</div>
