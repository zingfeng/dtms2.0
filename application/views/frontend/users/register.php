<?php 
  $csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash(),
  );
?>
<section class="container m_height clearfix"> 
    <div class="warp_bg">
      <div class="row">
        <div class="col-md-12">
          <ul class="breadcrumbs">
            <li><a href="#">Trang chủ</a></li>
            <li><i class="fa fa-angle-double-right"></i> <a class="active" href="#">Đăng ký</a></li>
          </ul>

          <div class="box-login"> 
            <div class="col-md-4">
              <div class="head">
                <h2 class="heading-title">Đăng ký bằng</h2>
              </div> 
              <div class="socialconnect">
                <a href="https://www.facebook.com/dialog/oauth?client_id=<?php echo $this->config->item("facebook_app_id"); ?>&scope=email,public_profile&redirect_uri=<?php echo urlencode(BASE_URL.'/users/loginsocial/facebook') ; ?><?php echo  $state; ?>" class="facebook mrb_20">Sign up with Facebook</a>
                <a href="https://accounts.google.com/o/oauth2/auth?client_id=<?php echo $this->config->item("google_app_id"); ?>&response_type=code&scope=email&redirect_uri=<?php echo urlencode(BASE_URL.'/users/loginsocial/google') ?><?php echo  $state; ?>" class="google">Sign up with Google</a>
              </div>
            </div>

            <div class="col-md-1 txt_login_or">OR</div>

            <div class="col-md-7">
              <div class="head">
                <h2 class="heading-title">Đăng ký tài khoản mới</h2>
              </div> 
              
            <form class="cd-form" method="post" action="/users/register" id="register_form">
                <p class="fieldset">
                  <i class="fa fa-user"></i>
                  <input class="full-width has-padding has-border" id="input_fullname" name="fullname" placeholder="Họ và tên">
                  
                </p>

                <p class="fieldset">
                  <i class="fa fa-phone"></i>
                  <input class="full-width has-padding has-border" id="input_phone" name="phone" placeholder="Số điện thoại">
                  
                </p>

                <p class="fieldset">
                  <i class="fa fa-envelope"></i>
                  <input class="full-width has-padding has-border" id="input_email" name="email" type="email" placeholder="Email đăng ký">
                  
                </p>

                <p class="fieldset">
                  <i class="fa fa-key"></i>
                  <input class="full-width has-padding has-border" id="input_password" name="password" type="password" placeholder="Mật khẩu">
                  
                </p>
                <p class="fieldset">
                  <i class="fa fa-key"></i>
                  <input class="full-width has-padding has-border" id="input_repassword" type="password" name="repassword" placeholder="Nhập lại mật khẩu">
                  
                </p> 

                <p class="fieldset">
                  <i class="fa fa-lock"></i>
                  <input style="width:200px" name="captcha" id="input_captcha" class="full-width has-padding has-border" type="text" placeholder="Mã bảo mật">
                  <span id="captcha"><?php echo $captcha;?></span>
                </p>

                <p class="fieldset">
                  <input type="radio" id="input_accept-terms" name="accept-terms" value="1">
                  <label for="accept-terms">Tôi đồng ý với các <a href="javascript:;">Điều khoản</a> trên website</label>
                </p>
                <p class="fieldset">
                  <input class="form_csrf" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                  <input class="btn-edit" type="submit" value="Đăng ký">
                  <input class="btn-edit" type="reset" value="Làm lại">
                </p> 
              </form>
            </div>
          </div> 

        </div> 

      </div>          
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        //Liên hệ
        $('#register_form').submit(function(event) {
            //Inaction button submit
            $('input[type="submit"').attr('disabled', true);
            $(this).find(".error").empty();
            $.ajax({
                type: 'post',
                dataType : 'json',
                url: $(this).attr("action"),
                data: $("#register_form").serializeArray(),
                success: function (respon) {
                    if(respon.status == "success"){
                        window.location.replace(respon.redirect_uri);
                        $("#register_form")[0].reset();
                    } else {
                        $.each( respon.message, function( key, msg ) {
                          $('#input_'+key).addClass('has-error');
                          if(key == "captcha"){
                            $('span[id="'+key+'"]').after('<div id="'+key+'-error" class="error" for="'+key+'">'+msg+'</div>');
                          }else if(key == "accept-terms"){
                            $('label[for="'+key+'"]').after('<div id="'+key+'-error" class="error" for="'+key+'">'+msg+'</div>');
                          }else{
                            $('#input_'+key).after('<div id="'+key+'-error" class="error" for="'+key+'">'+msg+'</div>');
                          }
                        });
                    }
                    //Enable button submit
                    $('input[type="submit"').attr('disabled', false);
                    //Reload captcha
                    $('#captcha').empty().append(respon.captcha);
                    $(".form_csrf").val(respon.csrf_hash);
                },
                error: function(respon,code) {
                    //Enable button submit
                    $('input[type="submit"').attr('disabled', false);
                    //Reload captcha
                    $('#captcha').empty().append(respon.captcha);
                }
            });
            event.preventDefault();
            return false;
        });
    });
</script>