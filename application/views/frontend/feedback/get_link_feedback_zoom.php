<html>
<head>

    <title>Trang web lấy link feedback lớp học cho giáo viên</title>
    <link rel="shortcut icon" type="image/x-icon"
          href="https://www.anhngumshoa.com/theme/frontend/default/images/favicon.ico">
    <base href="/">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
          href="https://qlcl.imap.edu.vn/theme/frontend/default/css/fontAwesome/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="https://qlcl.imap.edu.vn/theme/frontend/default/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" href="theme/frontend/default/css/feedback.css" media="all">

    <style type="text/css">

    </style>
</head>
<body style="background-color: rgb(250,227,225);">

<div class="container">
    <div class="row">
        <div class="col-sm-0 col-md-2  "></div>

        <div class="col-sm-12 col-md-8  "
             style="/*max-width: 100%; width: 750px; margin: auto; */    background-color: white; padding: 0; ">
            <div style="background-color: transparent; padding: 10px; ">
                <h3 class="title_top">LẤY LINK FEEDBACK LỚP HỌC TRÊN NỀN TẢNG ZOOM</h3>
                <hr>
                <p>
                    Lưu ý: Link feedback này chỉ có hiệu lực trong ngày
                </p>
            </div>

            <div class="form-group" style="padding: 5px 20px; font-size: large;">
                <label for="class_info_feedback">1. Lựa chọn lớp học của bạn</label>
                <select class="form-control" name="" id="class_info_feedback">

                </select>
            </div>
            <div class="form-group" style="padding: 5px 20px; font-size: large;">
                <button class="btn btn-primary" id="btn_copy" onclick="Get_url_feedback()">2. Lấy link feedback</button>
            </div>
            <div>
                <div class="row">
                    <div style="">
                        <div class="col col-sm-12">
                            <div class="form-group" style="padding: 5px 20px; font-size: large;">
                                <label for="">3. Link Feedback</label>
                                <input type="text" class="form-control" id="link_feedback">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-group" style="padding: 5px 20px; font-size: large;">
                <button class="btn btn-primary" id="btn_copy" onclick="ClickCopy()">4. Copy link</button>
            </div>
        </div>


        <div class="col-sm-0 col-md-2 "></div>
    </div>

</div>


<div class="container">
    <h5>. </h5>
</div>

<script>
    function Get_url_feedback() {
        // Select value ruler quest

        var class_code = $('#class_info_feedback ').val();
        if (class_code === null){
            alert('Bạn cần chọn lớp học của mình trước');
            return null;
        }
        $.post("/feedback/get_url_fb_zoom",
            {
                class_code: class_code,
            },
            function (data, status) {
                console.log(data);
                data = JSON.parse(data);
                if (data['status'] === 'success') {
                    $('#link_feedback').val(data['url']);
                }
            });
    }

    $(document).ready(function () {
        ////////class_info_feedback

        $("#class_info_feedback").select2({
            allowClear: true,
            placeholder: 'Chọn hoặc tìm Lớp học',
            ajax: {
                url: "/request/suggest_class_code_zoom",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term, // search term
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.option.nextpage
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateSelection: function(data) {
                if (typeof (data.item_id) != 'undefined') {
                    $("#class_info_feedback").val(data.item_id);
                }

                return data.text;
            }
        });
    });

    function ClickCopy() {
        var copyText = document.getElementById("link_feedback");
        copyText.select();
        document.execCommand("copy");
        $('#link_feedback').select();

    }

</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

