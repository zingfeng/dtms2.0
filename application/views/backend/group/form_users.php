<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index_users')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/group/index_users/<?php echo $row['class_id']; ?>">Danh sách học viên</a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['class_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['class_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<div class="col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Thêm học viên lớp "<?php echo $row['name']; ?>"</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content row">
				<div class="form-group validation_name">
					<label class="control-label col-sm-2 col-xs-12">Email học viên</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input required type="text" name="email" value="" placeholder="Email" class="form-control">
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
</form>