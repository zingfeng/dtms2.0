<?php
$arrBranch = $this->config->item("branch");
$arrBranch = json_decode($arrBranch, TRUE);
// var_dump($arrBranch);exit;

$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash(),
);

?>
<section class="banner_folder clearfix">
    <img class="bg" src="<?php echo $this->config->item('img') ?>/graphics/bg-lienhe.jpg" alt="">
    <div class="container">
        <div class="text_post">
            <img src="<?php echo $this->config->item('img') ?>/graphics/lien-he.png" alt="">
        </div>
    </div>
</section>
<section class="container clearfix">
    <ul class="breadcrumbs">
        <li><a href="#">Trang chủ</a></li>
        <li><i class="fa fa-angle-double-right"></i> <a class="active" href="#">Liên hệ</a></li>
    </ul>
    <div class="map_address">
        <div class="relative">
            <div class="address">
                <h2 class="title_news">
                    <strong>Hệ thống</strong>
                    <span>Cơ sở Aland IELTS</span>
                </h2>
                <div class="scrollbar-inner">
                    <?php foreach ($arrBranch as $key => $branch) { ?>
                        <div data-iframe-map="<?php echo $branch['iframe_map']; ?>"
                             class="div_branch  item <?php echo $key == 0 ? 'active' : '' ?>">
                            <strong>Cơ sở <?php echo $key + 1 ?>:</strong>
                            <p><?php echo $branch['label'] ?></p>
                            <p><?php echo $branch['address'] ?></p>
                            <p>SĐT: <?php echo $branch['phone'] ?></p>
                            <p class="hidden"><?php echo str_replace(';', '<br>', $branch['time_open']); ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php $first = $arrBranch[0]; ?>
            <div class="map">
                <div class="warp">
                    <iframe id="google_map_target" src="<?php
                    if (isset($first['iframe_map']) && (trim($first['iframe_map']) !== '')) {
                        echo $first['iframe_map'];
                    }
                    ?>" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                    <div class="item">
                        <strong id="label_iframe_map"><?php echo $first['label'] ?></strong>
                        <strong id="time_open_iframe_map"><?php
                            if (isset($first['time_open']) && (trim($first['time_open']) !== '')) {
                                echo 'Giờ mở cửa: ' . str_replace(';', '<br>', $first['time_open']);
                            }
                            ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact_us clearfix">
    <div class="container">
        <h2>Liên hệ với chúng tôi</h2>
        <h3>Để được tư vấn hoàn toàn miễn phí</h3>
        <form class="form" id="contact_form" action="<?php echo SITE_URL; ?>/contact/tuvan">
            <div class="form-group left width_50">
                <input type="text" name="fullname" class="form-control" placeholder="Họ và tên*">
            </div>
            <div class="form-group right width_50">
                <input type="text" name="phone" class="form-control" id="" placeholder="Số điện thoại*">
            </div>
            <div class="form-group left width_50">
                <input type="text" name="email" class="form-control" id="" placeholder="Email*">
            </div>
            <div class="form-group right width_50">
                <select class="form-control" name="branch">
                    <option value="0">Chọn cơ sở</option>
                    <?php foreach ($arrBranch as $key => $branch) { ?>
                        <option value="<?php echo $branch['id']; ?>"><?php echo $branch['label']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <input class="form_csrf" type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>"/>

            <div class="form-group">
                <textarea class="form-control" name="content" rows="4" placeholder="Nội dung"></textarea>
            </div>

            <div class="form-group" id="term">
                <input style="float: left; margin: 2px" type="checkbox" class="checkbox" value="1"  name="agree" id="agree" >
                <i></i>
                <span>Tôi đồng ý với các điều khoản của Aland English</span>
            </div>

            <div class="form-group">
                <a class="send" href="javascript:;" id="contact_submit">Gửi</a>
            </div>
        </form>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        jQuery('.scrollbar-inner').scrollbar();

        //Liên hệ
        $('#contact_submit').click(function () {
            $('#contact_form').validate({
                rules: {
                    fullname: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        number: true,
                    },
                    // email: {
                    //     required: true,
                    //     email: true,
                    // },
                    agree: {
                        required: true
                    }
                },
                messages: {
                    fullname: {
                        required: "Họ và tên không được để trống",
                    },
                    phone: {
                        required: "Số điện thoại không được để trống",
                        number: "Số điện thoại không đúng định dạng",
                    },
                    email: {
                        required: "Email không được để trống",
                        email: "Email không đúng định dạng",
                    },
                    agree: {
                        required: "Bạn phải đồng ý với các điều khoản của Aland English",
                    },
                },
                highlight: function (element) {
                    $(element).addClass("has-error");
                },
                unhighlight: function (element) {
                    $(element).removeClass("has-error");
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "agree" )
                        error.insertAfter("#term span");
                    else
                        error.insertAfter(element);
                }
            });
            var form = $("#contact_form");
            var url = form.attr('action');

            if ($('#contact_form').valid()) // check if form is valid
            {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: url,
                    data: $("#contact_form").serialize(),
                    success: function (data) {
                        if (data.status == 'error') {
                            $.each(data.message, function (key, value) {
                                $("#contact_support_" + key).append('<div class="error text-left">' + value + '</div>');
                            });
                        } else {
                            alert("Đăng ký thành công");
                            form.trigger("reset");
                        }
                        $(".form_csrf").val(data.csrf_hash);
                    },


                    error: function (respon, code) {

                    }
                });
            }
            return false;
        });

        // Click Gg Map
        $('.div_branch').click(function (event) {
            var obj = event.target;
            var nodeName = obj.nodeName;
            if (nodeName.toUpperCase() !== 'DIV') {
                var obj = obj.parentNode;
            }

            //  Xử lý active
            $(".div_branch").each(function () {
                $(this).removeClass('active');
            });
            obj.className += " active";

            // Cập nhật data iframe
            var data_iframe_map = obj.getAttribute('data-iframe-map');
            $('#google_map_target').attr('src', data_iframe_map);
            var label_this = obj.firstElementChild.nextElementSibling.innerHTML;
            var time_open_this = obj.lastElementChild.innerHTML;
            $('#label_iframe_map').html(label_this);

            if (time_open_this.trim() !== '') {
                $('#time_open_iframe_map').html('Giờ mở cửa: ' + time_open_this);
            } else {
                $('#time_open_iframe_map').html('');
            }


        });


    });
</script>