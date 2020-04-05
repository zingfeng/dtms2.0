<?php
$state = ($this->input->get("redirect_uri")) ? '&state='.$this->input->get('redirect_uri') : '';
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash(),
);
?>
<section class="container m_height clearfix">
	<div class="warp_bg">
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->load->view('common/breadcrumb');?>

				<div class="box-login box_sign_in"> 
					<div class="head">
						<h2 class="heading-title">Đăng nhập tài khoản</h2>
					</div> 

					<form class="cd-form" method="POST">
						<p class="fieldset">
							<i class="fa fa-envelope"></i>
							<input class="full-width has-padding has-border" name="email" id="input_email" type="email" placeholder="Email đăng nhập" value="<?php echo $_POST['email']?>">
							<?php echo $this->form_validation->error('email'); ?>
						</p>

						<p class="fieldset">
							<i class="fa fa-key"></i>
							<input class="full-width has-padding has-border" type="password" id="input_password" name="password" placeholder="Mật khẩu">
							<?php echo $this->form_validation->error('password'); ?>
						</p>
						<!--
						<p class="fieldset">
							<input type="radio" id="remember-me" checked>
							<label for="remember-me">Nhớ mật khẩu</label>
						</p>-->

						<p class="fieldset">
							<input class="form_csrf" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
							<input class="full-width" type="submit" value="Đăng nhập">
						</p> 

						<p><a href="<?php echo SITE_URL; ?>/users/forgotpass">Quên mật khẩu?</a></p>
						<?php if(isset($error) && $error == 3) { ?>
							<div class="error">Thông tin đăng nhập không chính xác.</div>
						<?php } ?>
					</form>
					<div class="login_with"><em>Hoặc đăng nhập qua</em></div>
					<div class="socialconnect">
						<a href="https://www.facebook.com/dialog/oauth?client_id=<?php echo $this->config->item("facebook_app_id"); ?>&scope=email,public_profile&redirect_uri=<?php echo urlencode(SITE_URL.'/users/loginsocial/facebook') ; ?><?php echo  $state; ?>" class="facebook">Login with Facebook</a>
						<a href="https://accounts.google.com/o/oauth2/auth?client_id=<?php echo $this->config->item("google_app_id"); ?>&response_type=code&scope=email&redirect_uri=<?php echo urlencode(BASE_URL.'/users/loginsocial/google') ?><?php echo  $state; ?>" class="google">Login with Google</a>
					</div>
				</div>
			</div> 
		</div>          
	</div>
</section>