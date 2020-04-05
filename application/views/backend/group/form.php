<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
//var_dump($arrExpert); exit();
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/group/index">Danh sách lớp học</a>
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
				<h2>Lớp học</h2>
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
					<label class="control-label col-sm-2 col-xs-12">Tên lớp học *</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input required type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="Tên lớp học" class="form-control">
					</div>
                </div>
                <div class="form-group validation_name">
                    <label class="control-label col-sm-2 col-xs-12">Mã lớp học *</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input required type="text" name="code_class" value="<?php echo $row['code_class']; ?>" placeholder="Mã lớp học" class="form-control">
                    </div>
                </div>
                <div class="form-group validation_name">
                    <label class="control-label col-sm-2 col-xs-12">Giảng viên *</label>
                    <div class="col-sm-10 col-xs-12 validation_form">

                        <select  class="form-control" name="expert">
                            <?php
                            if (isset($arrExpert))
                            {
                            foreach ($arrExpert as $index => $expert_detail) {
                                $select_expert = '';
                                if ($row['expert'] == $expert_detail['expert_id'])
                                {$select_expert = 'selected="selected"';}
                                ?>
                                <option value="<?php echo $expert_detail['expert_id']; ?>" <?php echo $select_expert; ?>  ><?php echo $expert_detail['name']; ?></option>
                            <?php }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group validation_name">
                    <label class="control-label col-sm-2 col-xs-12">Đầu vào</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input  type="text" name="input_level" value="<?php echo $row['input_level']; ?>" placeholder="Đầu vào" class="form-control">
                    </div>
                </div>
                <div class="form-group validation_name">
                    <label class="control-label col-sm-2 col-xs-12">Đầu ra</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input  type="text" name="output_level" value="<?php echo $row['output_level']; ?>" placeholder="Đầu ra" class="form-control">
                    </div>
                </div>

                <div class="form-group validation_name">
                    <label class="control-label col-sm-2 col-xs-12">Ngày khai giảng</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input  type="date" name="date_start" value="<?php echo $row['date_start']; ?>" placeholder="Ngày khai giảng" class="form-control">
                    </div>
                </div>

                <div class="form-group validation_name">
                    <label class="control-label col-sm-2 col-xs-12">Ngày kết thúc</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input type="date" name="date_end" value="<?php echo $row['date_end']; ?>" placeholder="Ngày kết thúc" class="form-control">
                    </div>
                </div>

                <div class="form-group validation_name">
                    <label class="control-label col-sm-2 col-xs-12">Tư vấn support</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input type="text" name="support" value="<?php echo $row['support']; ?>" placeholder="Tư vấn support" class="form-control">
                    </div>
                </div>


                <div class="form-group validation_name">
					<label class="control-label col-sm-2 col-xs-12">Mục tiêu</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input type="text" name="target" value="<?php echo $row['target']; ?>" placeholder="Mục tiêu khóa học" class="form-control">
					</div>
                </div>


                <div class="form-group validation_username">
					<label class="control-label col-sm-2 col-xs-12">Tên đăng nhập *</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input required type="text" name="username" value="<?php echo $row['username']; ?>" placeholder="Tên đăng nhập" class="form-control">
					</div>
                </div>
				<div class="form-group validation_password">
					<label class="control-label col-sm-2 col-xs-12">Mật khẩu *</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input type="text" name="password" value="" placeholder="Mật khẩu" class="form-control">
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
</form>