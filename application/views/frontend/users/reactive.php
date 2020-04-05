<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
						<h2 class="heading-title">Kích hoạt tài khoản</h2>
					</div> 
			        <?php if ($error > 0) { ?>
			            <div class="alert alert-danger" role="alert">Kích hoạt không thành công</div>
			        <?php } ?>
					<form class="cd-form" id="login_form" method="POST" action="">
						<div class="alert alert-danger" role="alert">
							Mã kích họat đã được gửi tới email <b><?php echo $userData['email']; ?></b> của bạn. Vui lòng kiểm tra email và làm theo hướng dẫn
						</div>
						<p class="fieldset">
							<i class="fa fa-envelope"></i>
							<input class="full-width has-padding has-border" name="code" type="text" placeholder="Nhập code">
			                <?php echo $this->form_validation->error('code'); ?>
						</p>
						<p class="fieldset">
							<input class="form_csrf" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
							<input class="full-width" type="submit" value="Kích hoạt">
						</p> 
					</form>
			    </div> 
			</div>
		</div>
	</div>
</section>