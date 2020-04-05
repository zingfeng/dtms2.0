<?php echo $this->load->get_block('top_ads'); ?> 
<header>   
    <div class="header-top"> 
        <div class="container">
		    <div class="row"> 
				<div class="col-md-3 col-sm-4 col-xs-3">
					<div class="logo-IELTS" style="margin-top: 3px; height: 50px;">
						<a title="<?php echo $this->config->item('seo_title');?>" href="<?php echo SITE_URL;?>"><img src="<?php echo $this->config->item("img"); ?>logo.jpg" alt="<?php echo $this->config->item('seo_title');?>"  ></a>
					</div> <!-- /.logo -->
				</div>
				<div class="col-md-5 col-sm-4 txt_sologan hidden_mobile">CHUYÊN GIA LUYỆN THI TOEIC </div>
				<?php if(!$this->permission->hasIdentity()){?>
				<div class="col-md-4 col-sm-8 col-xs-9">
                     <div class="col-register"><a href="/dang-ky.html">Đăng ký</a> <a class="login" href="/dang-nhap.html">Đăng nhập</a></div>
				</div>
				<?php } else { $profile = $this->permission->getIdentity();?>
				<div class="col-md-4 col-sm-8 col-xs-9">
                    
						<div id="users_menu_shortcut" class="wrapper-dropdown-3" tabindex="1">
							<a href="<?php echo SITE_URL; ?>/users/profile" class="avatar-header">
								<img alt="" src="<?php echo $this->config->item('img');?>gv2.jpg">
							</a>
							<span><strong>Hi</strong>, <?php echo $profile['fullname'];?></span>
							<ul class="dropdown">
								<li><a href="<?php echo SITE_URL; ?>/users/profile"><i class="icon-truck"></i>Thông tin cá nhân </a></li>
                                <li><a href="<?php echo SITE_URL.'/thay-anh-dai-dien.html'; ?>"><i class="fa fa-picture-o"></i>Thay ảnh đại diện</a></li>
								<li><a href="<?php echo SITE_URL; ?>/users/updatepassword"><i class="icon-plane"></i>Đổi mật khẩu </a></li>
								<li><a href="<?php echo SITE_URL; ?>/users/logout"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
							</ul>
						</div>
					
				</div>
				<?php }?>
            </div>        
        </div>
   	</div><!--End_header_top-->
   	<?php echo $this->load->get_block('top'); ?> 
</header>