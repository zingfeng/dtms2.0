<?php
	$state = ($this->input->get("redirect_uri")) ? '&state='.$this->input->get('redirect_uri') : '';
	$csrf = array(
	    'name' => $this->security->get_csrf_token_name(),
	    'hash' => $this->security->get_csrf_hash(),
	);
?>
<div class="col-md-12">
	<div class="box-login box_sign_in"> 
		<div class="head">
			<h2 class="heading-title">Đăng nhập lớp học</h2>
		</div> 
		<form class="cd-form" id="login_class_form" method="POST">
			<?php if ($error == 1) { ?>
			<div class="alert alert-danger" role="alert">Đăng nhập không thành công</div>
			<?php } ?>
			<p class="fieldset">
				<i class="fa fa-envelope"></i>
				<input class="full-width has-padding has-border" name="username" id="input_email" type="text" placeholder="Username">
				<?php echo $this->form_validation->error('username'); ?>
			</p>

			<p class="fieldset">
				<i class="fa fa-key"></i>
				<input class="full-width has-padding has-border" type="password" id="input_password" name="password" placeholder="Mật khẩu">
				<?php echo $this->form_validation->error('password'); ?>
			</p>
			<p class="fieldset">
				<input class="form_csrf" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
				<input class="full-width" type="submit" name="class_submit" value="Đăng nhập">
			</p> 
		</form>
    </div> 
</div>