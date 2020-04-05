<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<!-- page content -->
<div id="contact_lists" class="page-lists">
	<div class="clearfix"></div>
	<form class="ajax-delete-form" action="" method="POST">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Subscribe</h2>
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
									<th class="column-title">Email</th>
									<th class="column-title" width="120px">Ngày đăng ký</th>
								</tr>
							</thead>
							<tbody id="checkbox_list">
								<?php 
								foreach ($rows as $key => $row) { ?>
								<tr>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo date('d/m/Y H:i:s',$row['create_time']); ?></td>
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
			<a target="_blank" class="btn btn-primary" href="<?php echo SITE_URL; ?>/contact/export_sub">Export</a>
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