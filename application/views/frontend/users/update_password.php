<?php 
    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash(),
    );
?>
<section class="container m_height clearfix">
    <div class="row">
        <div class="profile-user row_user"> 
        	<div class="col-md-8 col-sm-8">
        		<div class="profile-content">			
                    <div class="title-cate">
                        <span class="title">Đổi mật khẩu</span>
                    </div>
        			<div class="col-cd-form">
                        <form class="cd-form" id="updatepassword_form">
                            <div class="row">
                                <div class="col-md-3 col-sm-4"><p class="mt20">Mật khẩu cũ  (<span class="text-red"> * </span>)</p></div>
                                <div class="col-md-9 col-sm-8">
                                    <p class="fieldset">
                                        <i class="fa fa-user"></i>
                                        <input class="full-width has-padding has-border" id="input_old_password" name="old_password" type="password" placeholder="Mật khẩu cũ" value=""> 
                                    </p>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-3 col-sm-4"><p class="mt20">Mật khẩu mới  (<span class="text-red"> * </span>)</p></div>
                                <div class="col-md-9 col-sm-8">
                                    <p class="fieldset">
                                        <i class="fa fa-user"></i>
                                        <input class="full-width has-padding has-border" id="input_password" name="password" type="password" placeholder="Mật khẩu mới" value=""> 
                                    </p>
                                </div>
                            </div>          
                            <div class="row">
                                <div class="col-md-3 col-sm-4"><p class="mt20">Nhập lại mật khẩu  (<span class="text-red"> * </span>)</p></div>
                                <div class="col-md-9 col-sm-8">
                                <p class="fieldset">
                                    <i class="fa fa-phone"></i>
                                    <input class="full-width has-padding has-border" id="input_repassword" name="repassword" type="password" placeholder="Nhập lại mật khẩu" value=""> 
                                </p>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="col-md-3 col-sm-4"></div>							
                                <div class="col-md-9 col-sm-8">
        							<p class="fieldset">
                                        <input class="form_csrf" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
        								<input class="btn-edit" type="submit" value="Cập nhật">
        							</p> 
                                </div>
                             </div>   
                            </form>
                        </div>
        			
        		</div>
        	</div>
        	
        	<div class="col-md-4 col-sm-4">
        		<div class="profile-sidebar hidden-xs">
        			<!-- SIDEBAR USER TITLE -->
        			<div class="profile-usertitle">
        				<div class="profile-usertitle-name">
                            <?php echo $row['fullname'];?>
                        </div>
        				<div class="profile-usertitle-job">
        					Thành viên Vip
        				</div>
        			</div>
        			<!-- END SIDEBAR USER TITLE -->
        			<!-- SIDEBAR MENU -->
        			<div class="profile-usermenu">
        				<ul class="nav">
        					<li>
        						<a href="/thong-tin-ca-nhan.html"><i class="fa fa-user"></i>Thay đổi thông tin cá nhân </a>
        					</li>
        					<li class="active">
        						<a href="/doi-mat-khau.html"><i class="fa fa-lock"></i>Đổi mật khẩu </a>
        					</li>
        					<li>
        						<a href="/users/logout"><i class="fa fa-sign-out"></i>Đăng xuất</a>
        					</li>
        				</ul>
        			</div>
        			<!-- END MENU -->
        			<div class="box_ads_cate">
        				<img src="<?php echo $this->config->item('img');?>ad1.jpg" alt=""> 
        			</div><!--End-->
        		</div>
        	</div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        //Liên hệ
        $('#updatepassword_form').submit(function(){
            $('#updatepassword_form').validate({
                rules: {
                    old_password: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                    repassword: {
                        required: true,
                    },
                },
                messages: {
                    old_password: {
                        required: "Mật khẩu cũ không được để trống",
                    },
                    password: {
                        required: "Mật khẩu mới không được để trống",
                    },
                    repassword: {
                        required: "Nhập lại mật khẩu không được để trống",
                    },
                },
                highlight: function(element) {
                    $(element).addClass("has-error");
                },
                unhighlight: function(element) {
                    $(element).removeClass("has-error");
                },
                errorElement: "div",
            });
            if ($('#updatepassword_form').valid()) // check if form is valid
            {
                $.ajax({
                    type: 'post',
                    dataType : 'json',
                    url: '/doi-mat-khau.html',
                    data: $("#updatepassword_form").serializeArray(),
                    success: function (respon) {
                        if(respon.status == "success"){
                            message(respon.message);
                        } else {
                            $.each( respon.message, function( key, msg ) {
                                $('#input_'+key).addClass('has-error');
                                $('#input_'+key).after('<div id="'+key+'-error" class="error" for="'+key+'">'+msg+'</div>');
                            });
                        }
                        $(".form_csrf").val(respon.csrf_hash);
                    },
                    error: function(respon,code) {
                        
                    }
                });   
            }
            return false;
        });
    });
</script>