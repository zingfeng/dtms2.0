

<div class="container" style="background: white">
    <h2 class="text-primary text-center">Phản hồi học viên qua điện thoại</h2>

    <div style="border: 1px solid #000000c7;    padding: 10px;">
        <h3 class="title">Thông tin lớp học</h3>
        <div class="row">
            <div class="col col-sm-6">
                <div class="form-group">
                    <label for="usr">Mã lớp</label>
                    <input type="text" class="form-control" id="class_code" <?php if(isset($class_code)) echo 'value="'.$class_code.'"  disabled'; ?> >
                </div>
            </div>

            <div id="info_class" class="col col-sm-6">
                <p style="font-weight: bold">Tổng số lần lấy phản hồi: <span id="max_times"><?php echo $max_times_feedback; ?></span></p>
                <p>Mảng đào tạo: <?php if (isset($type)) {
                        switch ($type){
                            case 'toeic':
                                $type = 'TOEIC';
                                break;
                            case 'ieltsfighter':
                                $type = 'Ielts Fighter';
                                break;
                            case 'ielts':
                                $type = 'Ielts Fighter';
                                break;
                            case 'aland':
                                $type = 'Aland';
                                break;
                            case 'giaotiep':
                                $type = 'Giao tiếp';
                                break;
                        }
                    }
                    echo $type

                    ?>
                </p>
                <p>Thông tin : <?php if (isset($more_info)) echo $more_info ?></p>
                <p>Địa điểm: <?php if (isset($info_location)) echo $info_location['name'].' - Khu vực: '.$info_location['area'] ?></p>
                <div>Giáo viên: <?php if (isset($list_info_teacher))
                    {
                        foreach ($list_info_teacher as $item) {
                            ?>
                                <p style="font-weight: bold">Họ tên: <?php echo $item['name']; ?></p>
                                <p style=""><?php echo $item['info']; ?></p>
                    <?php    }
                    }
0                    ?>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container"   >
    <div style="border: 1px solid #000000c7;    padding: 10px; margin: 10px 0">
        <div class="title"> Thêm phản hồi mới
            <button class="btn btn-sm btn-success" id="btn_add_card" onclick="ClickCard(event)" style="display: inline-block" id_card_now="1"> + </button>

            <button class="btn btn-sm btn-danger" onclick="toggle('add_area')" >Show/Hide</button>

        </div>

        <div class="row" id="add_area">

            <div class="col-sm-12 col-md-6" id="card1">
                <div class="add_card">
                    <div class="row">
                        <div class="col col-sm-4">
                            <div class="form-group">
                                <label for="usr">Lần lấy phản hồi</label>
                                <input type="number" class="form-control" min="1" max="6" step="1" id="times_feeder1" value="<?php
                                if ($max_times_feedback == 0){
                                    echo $max_times_feedback + 1 ;
                                }else{
                                    echo $max_times_feedback;
                                }
                                ?>">
                            </div>
                        </div>
                        <div class="col col-sm-8">
                            <div class="form-group">
                                <label for="usr">Tên người trả lời</label>
                                <input type="text" class="form-control" id="name_feeder1" >
                            </div>
                        </div>



                    </div>

                    <div class="form-group">
                        <label for="comment">Nhận xét</label>
                        <textarea class="form-control" rows="5" id="comment1"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="usr">Điểm</label>
                        <input type="number" step="0.5" min="0" max="10" class="form-control" id="point1">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-warning" onclick="SubmitCard(event)" id="submit1" id_card="1">Submit</button>
                    </div>
                </div>

            </div>



        </div>
    </div>

</div>

<div class="container">
    <div style="border: 1px solid #000000c7;    padding: 10px; margin: 10px 0">
        <div id="table_data_phone">
            <?php if (isset($table_phone_feedback)){
                echo $table_phone_feedback;
            }?>
        </div>
    </div>
</div>


<style>
    .title{
        font-size: 20px;
        font-weight: bold;
        border-left: 4px solid dodgerblue;
        margin-top: 15px;
        padding-left: 20px;
    }
    .add_card{
        padding: 15px 8px;
        /* border-bottom: 1px solid grey; */
        background: white;
        box-shadow: 0 8px 10px -5px rgba(0, 0, 0, .2), 0 16px 24px 2px rgba(0, 0, 0, .14), 0 6px 30px 5px rgba(0, 0, 0, .12);
        border-radius: 4px;
        margin: 15px;
    }
</style>
<script>
    function getMaxTimesNowFeedback() {
        var max_times = $('#max_times').html();
        if (max_times === ''){
            max_times = 0;
        }else{
            max_times = parseInt(max_times);
        }
        return max_times;
    }


    function ClickCard(event) {
        var obj = event.target;
        var id_card_now = obj.getAttribute('id_card_now');
        id_card_now = parseInt(id_card_now);
        var val_times_default = $('#times_feeder' + id_card_now).val();
        console.log("val_times_default");
        console.log(val_times_default);

        id_card_now ++;



        var text = 
            '<div class="col-sm-12 col-md-6" id="card**">' +
            '   <div class="add_card" >' +
                    '<div class="row">' +
                    '   <div class="col col-sm-4">' +
                        '<div class="form-group">' +
                        '       <label for="usr">Lần lấy phản hồi</label>' +
                        '     <input type="number" class="form-control" min="1" max="6" step="1" id="times_feeder**" value="'+ val_times_default + '" >' +
                        '</div>' +
                        '</div>' +
                    '<div class="col col-sm-8">' +
            '           <div class="form-group">' +
            '            <div class="form-group">' +
            '                <label for="usr">Tên người trả lời</label>' +
            '                <input type="text" class="form-control" id="name_feeder**">' +
            '            </div>' +
            '            </div>' +
            '            </div>' +
                    '</div>' +
            '            <div class="form-group">' +
            '                <label for="comment">Nhận xét</label>' +
            '                <textarea class="form-control" rows="5" id="comment**"></textarea>' +
            '            </div>' +
            '' +
            '            <div class="form-group">' +
            '                <label for="usr">Điểm</label>' +
            '                <input type="number" step="0.5" min="0" max="10" class="form-control" id="point**">' +
            '            </div>           ' +
            '' +
            '            <div class="form-group">' +
            '                <button class="btn btn-warning" onclick="SubmitCard(event)" id="submit**" id_card="**">Submit</button>' +
            '            </div>' +
            '' +
            '    </div>' +
            '        </div>';
        // console.log("text");
        // console.log(text);
        text = text.replace(/\*\*/g,id_card_now);
        obj.setAttribute('id_card_now',id_card_now);

        // console.log("text2");
        // console.log(text);

        $('#add_area').append(text);
    }

    function SubmitCard(event) {
        var obj = event.target;
        var id_card = obj.getAttribute('id_card');

        var name_feeder = $('#name_feeder' + id_card).val();
        var comment = $('#comment' + id_card).val();
        var point = $('#point' + id_card).val();
        var times_feeder = $('#times_feeder' + id_card).val();

        if ( (times_feeder > 6) || (times_feeder < 1) ){
            alert('Vui lòng nhập lần lấy phản hồi từ 1 đến 6');
            $('#times_feeder' + id_card).focus();
            return null;
        }


        if (point == ''){
            alert('Bạn chưa nhập điểm đánh giá của giáo viên');
            $('#point' + id_card).focus();
            return null;
        }

        if ( (point>10) || (point<0) ){
            alert('Vui lòng nhập điểm trong khoảng từ 0 - 10');
            $('#point' + id_card).focus();

            return null;
        }

        if (name_feeder.trim() === ''){
            alert('Bạn chưa nhập tên người làm feedback');
            $('#name_feeder' + id_card).focus();

            return null;
        }

        // ===========
        make_effect_submitting('submit' + id_card);

        $.post("/feedback/request",{
                optcod: 'insert_phone_feedback', // có thể include optcode này vào đâu ko ?
                token: 'abcd',
                class_code: $('#class_code').val(),
                name_feeder: name_feeder,
                point: point,
                comment: comment,
                times_feeder: times_feeder,
            },
            function (data, status) {
                console.log(data);

                if(data.substr(-2) ==='ok'){
                    refreshListPhoneFeedback();
                    $('#card' + id_card).css('display','none');
                    alert('Cập nhật thành công');
                }else{
                    alert(data);
                    $('#' + 'submit' + id_card).attr('disabled',false);
                    var old_content = $('#' + 'submit' + id_card).attr('old_content');
                    $('#' + 'submit' + id_card).html(old_content);
                }
            });




    }

    function refreshListPhoneFeedback() {
        $.post("/feedback/request",{
                optcod: 'refresh_table_phone_feedback', // có thể include optcode này vào đâu ko ?
                token: 'abcd',
                class_code: $('#class_code').val(),
            },
            function (data, status) {
                console.log(data);
                $('#table_data_phone').html(data);
            });

    }

    function toggle(id){
        $('#' + id).toggle();
    }

</script>

