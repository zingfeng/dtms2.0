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
                        <span class="title">Thông tin tài khoản</span>
                    </div>
                    <div class="box_info_user">
                        <ul class="list-items">
                            <li>
                              <span>Email:</span> <strong><?php echo $row['email'];?></strong>
                              <a href="#" class="text-primary"> <i class="fa fa-pencil"></i>Đổi Email</a>
                            </li>
                            <li><span>Số điện thoại:</span> <strong><?php echo $row['phone'];?></strong></li>
                            <li>
                              <span>Mật khẩu:</span> <span>********</span>
                              <a href="<?php echo SITE_URL.'/doi-mat-khau.html'; ?>" class="text-primary"><span class="icon-edit-blue"></span>  <i class="fa fa-pencil"></i>Đổi Mật khẩu</a>
                            </li>
                        </ul>
                    </div>
                    <div class="title-cate">
                        <span class="title">Thông tin cá nhân</span>
                    </div>
                    <div class="col-cd-form">
                        <form class="cd-form" id="profile_form">
                            <div class="row">
                                <div class="col-md-3 col-sm-4"><p class="mt20">Họ tên  (<span class="text-red"> * </span>)</p></div>
                                <div class="col-md-9 col-sm-8">
                                    <p class="fieldset">
                                        <i class="fa fa-user"></i>
                                        <input class="full-width has-padding has-border" id="input_fullname" name="fullname" type="text" placeholder="Họ và tên" value="<?php echo $row['fullname'];?>"> 
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-4"><p class="mt20">Email (<span class="text-red"> * </span>)</p></div>
                                <div class="col-md-9 col-sm-8">
                               <p class="fieldset"> 
                                   <i class="fa fa-envelope"></i>
                                   <input class="full-width has-padding has-border" disabled="disabled" type="text" value="<?php echo $row['email'];?>"> 
                               </p>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-3 col-sm-4"><p class="mt20">Giới tính (<span class="text-red"> * </span>)</p></div>
                                <div class="col-md-9 col-sm-8">
                                <p class="fieldselect">
                                    <i class="fa fa-angle-down"></i>
                                    <select name="sex" id="input_sex" class="full-width has-padding has-border">
                                        <option value="">Giới tính</option> 
                                        <option value="1" <?php echo ($row['sex'] == 1) ? "selected":"";?>>Nam</option>  
                                        <option value="2" <?php echo ($row['sex'] == 2) ? "selected":"";?>>Nữ</option>
                                        <option value="3" <?php echo ($row['sex'] == 3) ? "selected":"";?>>Khác</option>      
                                    </select>
                                </p>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-md-3 col-sm-4"><p class="mt20">Điện thoại  (<span class="text-red"> * </span>)</p></div>
                                <div class="col-md-9 col-sm-8">
                                <p class="fieldset">
                                    <i class="fa fa-phone"></i>
                                    <input class="full-width has-padding has-border" id="input_phone" name="phone" type="text" placeholder="Điện thoại" value="<?php echo $row['phone'];?>"> 
                                </p>
                                </div>
                            </div>
                             
                            <div class="row">
                                <div class="col-md-3 col-sm-4"><p class="mt20">Tỉnh/Thành phố (<span class="text-red"> * </span>)</p></div> 
                                <div class="col-md-9 col-sm-8">
                                <p class="fieldselect">
                                    <i class="fa fa-angle-down"></i>
                                    <select name="city_id" id="input_city_id" class="full-width has-padding has-border">
                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                        <?php foreach($arrCity as $city){?>   
                                        <option value="<?php echo $city['city_id'];?>" <?php echo ($city['city_id'] == $row['city_id']) ? "selected":"";?>><?php echo $city['name'];?></option>  
                                        <?php }?>
                                    </select>
                                </p>
                                </div>
                             </div>
                             
                             <div class="row">
                                <div class="col-md-3 col-sm-4"><p class="mt20">Địa chỉ</p></div>
                                <div class="col-md-9 col-sm-8">
                                <p class="fieldset">
                                    <i class="fa fa-map-marker"></i>
                                    <input class="full-width has-padding has-border" id="input_address" name="address" type="text" placeholder="Địa chỉ" value="<?php echo $row['address'];?>"> 
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
                        <div class="profile-userpic">
                            <img src="<?php echo $row['avatar']; ?>" class="img-responsive" alt="">
                        </div>

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
        					<li class="active">
        						<a href="/thong-tin-ca-nhan.html"><i class="fa fa-user"></i>Thay đổi thông tin cá nhân </a>
        					</li>
                            <li>
                                <a href="/thay-anh-dai-dien.html"> <i class="fa fa-picture-o" aria-hidden="true"></i>Thay đổi ảnh đại diện </a>
                            </li>

        					<li>
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
        $('#profile_form').submit(function(){
            $('#profile_form').validate({
                rules: {
                    fullname: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        number: true,
                    },
                    city_id: {
                        required: true,
                    },
                    sex: {
                        required: true,
                    },
                },
                messages: {
                    fullname: {
                        required: "Họ và tên không được để trống",
                    },
                    phone: {
                        required: "Số điện thoại không được để trống",
                        number: "Số điện thoại không đúng định dạng",
                    },
                    city_id: {
                        required: "Tỉnh/Thành Phố không được để trống",
                    },
                    sex:{
                        required: "Giới tính không được để trống",
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
            if ($('#profile_form').valid()) // check if form is valid
            {
                $.ajax({
                    type: 'post',
                    dataType : 'json',
                    url: '/thong-tin-ca-nhan.html',
                    data: $("#profile_form").serializeArray(),
                    success: function (respon) {
                        if(respon.status == "success"){
                            message(respon.message);
                        } else {
                            $.each( respon.message, function( key, msg ) {
                                $('#input_'+key).addClass('has-error');
                                $('#input_'+key).after('<label id="'+key+'-error" class="error" for="'+key+'">'+msg+'</label>');
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