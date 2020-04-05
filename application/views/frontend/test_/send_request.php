<?php
    $arrTestType = $this->config->item('test_type');
    $test_type = $arrTestType[$type];

    //Cơ sở đào tạo
    $arrBranch = $this->config->item("branch");
    $arrBranch = json_decode($arrBranch, TRUE);
    //Add other
    $arrBranch[] = array(
        'id' => 9,
        'label' => 'Khác',
        'name' => 'Khác'
    );
?>
<section class="result-speaking container clearfix m_height">
    <?php echo $this->load->view('common/breadcrumb');?>
    <div class="row">
        <div id="sidebar_left" class="col-md-8 col-sm-8 col-xs-8 col-tn-12">
            <div class="warp_bg">
                <div class="information">
                    <div class="information__title">
                        <?php echo $testDetail['title']; ?> - <?php echo $type; ?>
                    </div>
                    <div class="information__view">
                        <i class="fa fa-file-text-o"></i>
                        Số lần test: <span class="number-test"><?php echo $testDetail['total_hit']?></span>
                    </div>
                </div>
                <hr>
                <div class="result-notification">
                    <div class="result-notification__title">
                        Bài làm của bạn đã được lưu vào hệ thống.
                    </div>

                    <div class="result-notification__subtitle">
                        Bạn vui lòng điền đầy đủ thông tin, chúng tôi sẽ chấm và gửi kết quả sớm nhất.
                    </div>
                </div>

                <div class="form-information">
                    <form class="form" action="" id="send_request_form">
                        <div class="form-group" id="send_request_fullname">
                            <label class="form-group__label" for="name">Họ và tên:</label>
                            <input type="text" class="form-control form-group__input" id="fullname" placeholder="Nhập họ và tên"
                                name="fullname" value="<?php echo $profile['fullname'] ? : ''?>">
                        </div>
                        <div class="form-group" id="send_request_email">
                            <label class="form-group__label" for="phone-number">Email:</label>
                            <input type="text" class="form-control form-group__input" id="email"
                                placeholder="Nhập email" value="<?php echo $profile['email'] ? : ''?>" name="email">
                        </div>
                        <div class="form-group" id="send_request_phone">
                            <label class="form-group__label" for="phone-number">Số điện thoại:</label>
                            <input type="text" class="form-control form-group__input" id="phone-number"
                                placeholder="Nhập số điện thoại" name="phone">
                        </div>
                        <div class="form-group" id="send_request_address">
                            <label class="form-group__label" for="location">Địa chỉ của bạn:</label>
                            <select class="form-control form-group__input" id="address" name="address">
                                <option value="">Chọn Địa chỉ</option>
                                <option value="Hà Nội">Hà Nội</option>
                                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                <option value="Đà Nẵng">Đà Nẵng</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                        <div class="button-action">
                                <a type="submit" class="btn btn-primary button-action__primary" id="send_request_submit">Gửi yêu cầu chấm bài</a>
                                <a href="javascript:;" onclick="window.history.back();" class="btn btn-default button-action__secondary">Quay lại</a>
                        </div>
                        <!-- <div class="button-hint">
                            <a href="javascript:;" class="hint">
                                Xem gợi ý bài mẫu&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div> -->
                    </form>
                </div>

            </div>
        </div>

        <div id="sidebar_right" class="col-md-4 col-sm-4 col-xs-4 col-tn-12 mb20">
            <div class="category">
                <?php echo $this->load->view("block/contact")?>
            </div>
            <?php echo $this->load->get_block('right'); ?>
        </div>
    </div>
    <!-- TIN QUAN TÂM -->
    <div class="warp_bg mb20 art_other grid4">
        <h2>Các bài test khác</h2>
        <div class="list_learn list_learn_other">
            <div class="row">
                <?php foreach ($arrTestRelate as $key => $testDetail) {?>
                <div class="col-md-3 col-sm-3 col-xs-3 col-tn-12 mb10">
                    <div class="ava">
                      <a href="<?php echo $testDetail['share_url']; ?>" title="<?php echo $testDetail['title']; ?>">
                        <span class="thumb_img thumb_5x3"><img title="" src="<?php echo getimglink($testDetail['images'], 'size6'); ?>" alt=""></span>
                      </a>
                    </div>
                    <div class="content">
                      <h3><a href="#" title="">IELTS Fighter test1</a></h3>
                      <p>Reading</p>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
    <?php echo $this->load->get_block('left_content'); ?>
</section>

<script type="text/javascript">
    $("#send_request_submit").bind("click",function(e){
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $("#send_request_form");
        form.find(".error").remove();
        var url = form.attr('action');
        $(this).html('Đang gửi...').attr('disabled', true);
        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                    if (data.status == 'error') {
                        if(data.error_message){
                            alert(data.error_message);
                        }
                        if(data.message && typeof(data.message) != 'undefined'){
                            $.each( data.message, function( key, value ) {
                                $("#send_request_" + key).after('<div class="error text-left">' + value + '</div>');
                            });
                        }
                    }
                    else {
                        alert(data.message);
                        form.trigger("reset");
                        window.location.replace("<?php echo $redirect_url?>");
                    }
                    $(".form_csrf").val(data.csrf_hash);
                    $("#send_request_submit").html('Gửi yêu cầu chấm bài').attr('disabled', false);
               },
               dataType : 'json'
             });
    })
</script>