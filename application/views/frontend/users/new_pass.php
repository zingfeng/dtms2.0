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
                <?php echo $this->load->view('common/breadcrumb');?>
            	
            	<div class="box-login box_sign_in"> 
            		<div class="head">
            			<h2 class="heading-title">Đặt lại mật khẩu</h2>
            		</div> 
             
            		<form class="cd-form" id="resetpass_form" method="post">
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
            				<input style="width:200px" class="full-width has-padding has-border" id="input_captcha" type="text"  placeholder="Mã bảo mật" name="captcha">
            				<span id="captcha"><?php echo $captcha;?></span>
            			</p>
            			<p class="fieldset">
                            <input class="form_csrf" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            				<input class="full-width has-padding" type="submit" value="Đồng ý">
            			</p>
            		</form>  
                </div> 
            </div> 
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function(){
        //Liên hệ
        $('#resetpass_form').submit(function(){
            $(this).find(".error").empty();
            $.ajax({
                type: 'post',
                dataType : 'json',
                data: $("#resetpass_form").serializeArray(),
                success: function (respon) {
                    if(respon.status == "success"){
                        window.location.replace(respon.redirect_uri);
                        $("#resetpass_form")[0].reset();
                    } else {
                        $.each( respon.message, function( key, msg ) {
                            $('#input_'+key).addClass('has-error');
                            if(key == "captcha"){
                                $('span[id="'+key+'"]').after('<div id="'+key+'-error" class="error" for="'+key+'">'+msg+'</div>');
                            }else{
                                $('#input_'+key).after('<div id="'+key+'-error" class="error" for="'+key+'">'+msg+'</div>');
                            }
                        });
                    }
                    $('#captcha').empty().append(respon.captcha);
                    $(".form_csrf").val(respon.csrf_hash);
                },
                error: function(respon,code) {
                    
                }
            }); 
            event.preventDefault();
            return false;  
        });
    });
</script>