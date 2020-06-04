// ================ CLASS =======================
function click_ok_class() {
    var status = $('#btn_ok_class').attr('status');
    if(status === 'insert'){
        insert_class();
    }else{
        edit_class();
    }


}

function load_edit_class(event) {
    $('#btn_ok_class').attr('status','edit');
    document.getElementById("class_code").disabled = true;

    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    // class_code: "TOECI"
    // class_id: "1"
    // list_teacher: "["1","2"]"
    // more_info: "ghdfgh"
    // time_end: "1893430800"
    // time_end_client: "2030-01-01T00:00"
    // time_start: "946659600"
    // time_start_client: "2000-01-01T00:00"
    // type: "giaotiep"


    $('#btn_ok_class').attr('class_id',info_live.class_id);

    $("#class_type").val(info_live.type);
    $("#class_code").val(info_live.class_code);
    $("#class_from_date").val(info_live.time_start_client);
    $("#class_to_date").val(info_live.time_end_client);
    $('#class_more_info').val(info_live.more_info);
    $('#location_class').val(info_live.id_location);
    $('#class_opening_date').val(info_live.opening_day);
    $('#level').val(info_live.level);

    var list_teacher = JSON.parse(info_live.list_teacher);
    $('#class_teacher').val(list_teacher).trigger('change');


    $('#insert_class_modal').modal('show');

    // var array_convert = [];
}

function ringthebell(event) {
    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    $('#modal-bell-title').text(info_live.class_code);
    $('#modal-bell-title').attr('data-query-class_id', info_live.class_id);
    $('#modal-bell-title').attr('data-query-class_code', info_live.class_code);

    $('#ringthebelltype').modal('show');
}

function ringthebelltype(event) {
    var class_id = $('#modal-bell-title').attr('data-query-class_id');
    var class_code = $('#modal-bell-title').attr('data-query-class_code');
    var obj = event.target;
    var type = obj.getAttribute('data-query-type');

    var r = confirm("Bạn muốn gửi thông báo về lớp học " + class_code +" qua Email cho Ms Hoa không ?");
    if (r === true) {
        $.post("/feedback/request",{
                optcod: 'ringthebell', // có thể include optcode này vào đâu ko ?
                token: 'abcd',
                type: type,
                class_id: class_id,
            },
            function (data, status) {
                console.log(data);
                $('#ringthebelltype').modal('hide');
                // make_effect_submit_done('btn_ok_class');
            });
    }
}

function calculator(event) {
    var obj = event.target;
    var info_live = obj.getAttribute('info');
    console.log("info_live");
    console.log(info_live);

    var r = confirm("Tính lại điểm Lớp học :\n" + "Mã lớp: " + info_live);
    if (r == true) {
        $.post("/feedback/mark_point_class",{
                class_code: info_live,
                ajax: 1,
            },
            function (data, status) {
                console.log(data);
                var data_live = JSON.parse(data);
                if ((data_live.status === 1)){
                    location.reload();
                }else{
                    alert('NOT OK ! - Không tính được điểm lớp: ' + info_live);
                }
            });
    } else {

    }
}

function load_del_class(event) {
    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    // class_code: "TOECI"
    // class_id: "1"
    // list_teacher: "["1","2"]"
    // more_info: "ghdfgh"
    // time_end: "1893430800"
    // time_end_client: "2030-01-01T00:00"
    // time_start: "946659600"
    // time_start_client: "2000-01-01T00:00"
    // type: "giaotiep"

    var r = confirm("Bạn có muốn xóa Lớp học :\n" + "Mã lớp: " + info_live.class_code +'\nKiểu: ' + info_live.type );
    if (r == true) {
        $.post("/feedback/request",{
                optcod: 'del_class', // có thể include optcode này vào đâu ko ?
                token: 'abcd',
                class_id: info_live.class_id,
            },
            function (data, status) {
                console.log(data);
                make_effect_submit_done('btn_ok_class'); // có bao gồm reload
            });
    } else {
        // txt = "You pressed Cancel!";
    }

}

function load_get_link_class(event) {

    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    $("#class_from_date_get_link").val(info_live.time_start_client);
    $("#class_to_date_get_link").val(info_live.time_end_client);
    $("#number_student_get_link").val(info_live.number_student);

    var link_feedback = 'https://qlcl.imap.edu.vn/feedback/' + info_live.type + '?my_class=' + info_live.class_code;
    var link_feedback_ksgv1 = 'https://qlcl.imap.edu.vn/feedback/ksgv_lan1?my_class=' + info_live.class_code;
    var link_feedback_ksgv2 = 'https://qlcl.imap.edu.vn/feedback/ksgv_lan2?my_class=' + info_live.class_code;
    var link_feedback_slide = 'https://qlcl.imap.edu.vn/feedback/slide?my_class=' + info_live.class_code;
    var link_feedback_homthugopy = 'https://qlcl.imap.edu.vn/feedback/hom_thu_gop_y?type=' + info_live.type +'&my_class='+ info_live.class_code;
    var link_feedback_online = 'https://qlcl.imap.edu.vn/feedback/dao_tao_online?type=' + info_live.type +'&my_class='+ info_live.class_code;
    var link_feedback_luyende = 'https://qlcl.imap.edu.vn/form/luyen_de?my_class='+ info_live.class_code;
    var link_thicuoiky = 'https://qlcl.imap.edu.vn/form/thi_cuoi_ky?my_class='+ info_live.class_code;

    $('#modal_link_feedback').html(info_live.class_code);
    $('#modal_link_feedback').attr('class_id',info_live.class_id);
    $('#modal_link_feedback_2').html(info_live.class_code);

    $('#link_feedback').val(link_feedback);
    $('#link_feedback_slide').val(link_feedback_slide);
    $('#link_feedback_lan1').val(link_feedback_ksgv1);
    $('#link_feedback_lan2').val(link_feedback_ksgv2);

    $('#link_feedback_homthugopy').val(link_feedback_homthugopy);

    $('#link_feedback_online').val(link_feedback_online);
    $('#link_feedback_luyende').val(link_feedback_luyende);
    $('#link_thicuoiky').val(link_thicuoiky);

    $('#modal_get_link').modal('show');

    $('#link_feedback').select();

    captain.copyToClipboard(link_feedback);
    // alert('Link feedback: ' + link_feedback + '\nĐã copy vào Clipboard !');
}

function SaveFromDateToDateLink() {
    $("#btn_save_change_date").attr("disabled", true);
    var my_info = captain.getForm('box_edit_date');
    console.log("my_info");
    console.log(my_info);

    var class_id =  $('#modal_link_feedback').attr('class_id');

    // class_from_date_get_link: "2019-09-16T00:00"
    // class_to_date_get_link: "2019-12-20T00:00"

    $.post("/feedback/request",{
            optcod: 'edit_time_class', // có thể include optcode này vào đâu ko ?
            token: 'abcd',
            class_id: class_id,
            class_from_date: my_info.class_from_date_get_link,
            class_to_date: my_info.class_to_date_get_link,
            number_student: my_info.number_student_get_link,
        },
        function (data, status) {
            console.log(data);
            var data_live = JSON.parse(data);
            if ( (data_live.status === 'success') || (data.includes("success"))){
                location.reload();
                alert('Ok ! Thông tin thay đổi đã được cập nhật');
                $("#btn_save_change_date").attr("disabled", false);
            }else{
                alert('NOT OK ! - Thông tin thay đổi không được chấp nhận.');
            }
            // make_effect_submit_done('btn_ok_class');

        });
}

function ClickCopy() {
    var link_feedback = $('#link_feedback').val();
    captain.copyToClipboard(link_feedback);
    $('#link_feedback').select();
}

function ClickCopyFeedback() {
    var link_feedback_slide = $('#link_feedback_slide').val();
    captain.copyToClipboard(link_feedback_slide);
    $('#link_feedback_slide').select();
}

function ClickOpenLink() {
    var link_feedback = $('#link_feedback').val();
    openInNewTab(link_feedback);
}

function ClickOpenLinkFeedback() {
    var link_feedback = $('#link_feedback_slide').val();
    openInNewTab(link_feedback);
}


function openInNewTab(url) {
    var win = window.open(url, '_blank');
    win.focus();
}

function edit_class(){
    var my_info = captain.getForm('insert_class_modal');
    if (my_info.class_code.trim() === ''){
        alert('Bạn cần nhập mã lớp');
        return null;
    }

    // my_info.class_code
    if ( (my_info.class_code.includes("'") ) || (my_info.class_code.includes('"') )  || (my_info.class_code.includes(' ') ) ){
        alert('Mã lớp không được chứa dấu ngoặc đơn, ngoặc kép hoặc dấu cách');
        return null;
    }

    if (my_info.class_teacher.length < 1){
        alert('Bạn cần nhập giáo viên của lớp');
        return null;
    }

    make_effect_submitting('btn_ok_class');

    console.log("myinfo");
    console.log(my_info);

    var class_id = $('#btn_ok_class').attr('class_id');
    make_effect_submitting('btn_ok_teacher');

    $.post("/feedback/request",{
            optcod: 'edit_class', // có thể include optcode này vào đâu ko ?
            token: 'abcd',
            class_id: class_id,
            class_code: my_info.class_code,
            class_from_date: my_info.class_from_date,
            class_more_info: my_info.class_more_info,
            class_teacher: my_info.class_teacher,
            class_to_date: my_info.class_to_date,
            class_type: my_info.class_type,
            class_opening_date: my_info.class_opening_date,
            id_location: my_info.location_class,
            level: my_info.level,
        },
        function (data, status) {
            console.log(data);
            if(data != 1){
                alert(data);
            }else {
                alert('Thành công!');
                make_effect_submit_done('btn_ok_class');
            }
        });
}

function insert_class(){
    var my_info = captain.getForm('insert_class_modal');
    console.log("myinfo");
    console.log(my_info);

    if (my_info.class_teacher.length < 1){
        alert('Bạn cần nhập giáo viên của lớp');
        return null;
    }

    if (my_info.class_code.trim() === ''){
        alert('Bạn cần nhập mã lớp');
        return null;
    }

    if(/^[a-zA-Z0-9- ]*$/.test(my_info.class_code) == false) {
        alert('Mã lớp không được chứa ký tự đặc biệt!');
        return null;
    }

    // my_info.class_code
    if ( (my_info.class_code.includes("'") ) || (my_info.class_code.includes('"') )  || (my_info.class_code.includes(' ') ) ){
        alert('Mã lớp không được chứa dấu ngoặc đơn, ngoặc kép hoặc dấu cách');
        return null;
    }


    if (my_info.class_opening_date.trim() === ''){
        alert('Bạn cần nhập ngày khai giảng');
        return null;
    }
    make_effect_submitting('btn_ok_class');

    console.log("myinfo");
    console.log(my_info);

    $.post("/feedback/request",{
            optcod: 'insert_class', // có thể include optcode này vào đâu ko ?
            token: 'abcd',
            class_code: my_info.class_code,
            class_from_date: my_info.class_from_date,
            class_more_info: my_info.class_more_info,
            class_teacher: my_info.class_teacher,
            class_to_date: my_info.class_to_date,
            class_type: my_info.class_type,
            class_opening_date: my_info.class_opening_date,
            id_location: my_info.location_class,
        },
        function (data, status) {
            console.log(data);
            if(data != 1){
                alert(data);
            }else {
                alert('Thành công!');
                make_effect_submit_done('btn_ok_class');
            }
        });

}

//=================== LOCATION =======================
function click_ok_location() {
    var status = $('#btn_ok_location').attr('status');
    if(status === 'insert'){
        insert_location();
    }else{
        edit_location();
    }
}

function load_edit_location(event) {
    $('#btn_ok_location').attr('status','edit');

    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    $('#btn_ok_location').attr('location_id',info_live.id);

    $('#name_location_insert').val(info_live.name);
    $('#area').val(info_live.area).change();

    $('#insert_location_modal').modal('show');

    // var array_convert = [];
}

function load_del_location(event) {
    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    var r = confirm("Bạn có muốn xóa Location :\n" + "Tên: " + info_live.name +'\nKhu vực: ' + info_live.area );
    if (r == true) {
        $.post("/feedback/request",{
                optcod: 'del_location', // có thể include optcode này vào đâu ko ?
                token: 'abcd',
                id: info_live.id,
            },
            function (data, status) {
                console.log(data);
                make_effect_submit_done('btn_ok_location'); // có bao gồm reload
            });
    } else {
        // txt = "You pressed Cancel!";
    }

}

function edit_location(){
    var my_info = captain.getForm('insert_location_modal');
    if (my_info.name_location_insert.trim() === ''){
        alert('Bạn cần điền tên cơ sở');
        return null;
    }
    // console.log("here");
    var location_id = $('#btn_ok_location').attr('location_id');
    make_effect_submitting('btn_ok_location');

    $.post("/feedback/request",{
            optcod: 'edit_location', // có thể include optcode này vào đâu ko ?
            token: 'abcd',
            id: location_id,
            name_location_insert: my_info.name_location_insert,
            area: my_info.area,
            brand: my_info.brand,
        },
        function (data, status) {
            console.log(my_info.brand, data);
            make_effect_submit_done('btn_ok_location');
        });
}

function insert_location(){
    var my_info = captain.getForm('insert_location_modal');
    if (my_info.name_location_insert.trim() === ''){
        alert('Bạn cần điền tên giáo viên');
        return null;
    }
    make_effect_submitting('btn_ok_location');

    $.post("/feedback/request",{
            optcod: 'insert_location', // có thể include optcode này vào đâu ko ?
            token: 'abcd',
            id: my_info.location_id,
            name_location_insert: my_info.name_location_insert,
            area: my_info.area,
            brand: my_info.brand,
        },
        function (data, status) {
            console.log(data);
            make_effect_submit_done('btn_ok_location');
        });
}

//=================== tuvan =======================
function click_ok_tuvan() {
    var status = $('#btn_ok_tuvan').attr('status');
    if(status === 'insert'){
        insert_tuvan();
    }else{
        edit_tuvan();
    }
}

function load_edit_tuvan(event) {
    $('#btn_ok_tuvan').attr('status','edit');

    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    $('#btn_ok_tuvan').attr('tuvan_id',info_live.id);

    $('#name_tuvan_insert').val(info_live.fullname);

    $('#username_tuvan_insert').val(info_live.username);
    $('#password_tuvan_insert').val(info_live.passwd);

    $('#location').val(info_live.id_location).change();
    $('#area').val(info_live.area).change();
    if ( (info_live.status === '0') || (info_live.status == 0)) {
        $('#tuvan_active_insert').prop('checked', false);
    }else{
        $('#tuvan_active_insert').prop('checked', true);
    }
    $('#insert_tuvan_modal').modal('show');
}

function load_del_tuvan(event) {
    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    var r = confirm("Bạn có muốn xóa Tư vấn viên :\n" + "Tên: " + info_live.fullname);
    if (r == true) {
        $.post("/feedback/request",{
                optcod: 'del_tuvan', // có thể include optcode này vào đâu ko ?
                token: 'abcd',
                id: info_live.id,
            },
            function (data, status) {
                console.log(data);
                make_effect_submit_done('btn_ok_tuvan'); // có bao gồm reload
            });
    } else {
        // txt = "You pressed Cancel!";
    }

}

function edit_tuvan(){
    var my_info = captain.getForm('insert_tuvan_modal');
    if (my_info.name_tuvan_insert.trim() === ''){
        alert('Bạn cần điền tên Tư vấn viên');
        return null;
    }
    if (my_info.username_tuvan_insert.trim() === ''){
        alert('Bạn cần điền Username');
        return null;
    }
    if (my_info.password_tuvan_insert.trim() === ''){
        alert('Bạn cần điền Password');
        return null;
    }

    // console.log("here");
    var tuvan_id = $('#btn_ok_tuvan').attr('tuvan_id');

    make_effect_submitting('btn_ok_tuvan');

    $.post("/feedback/request",{
            optcod: 'edit_tuvan', // có thể include optcode này vào đâu ko ?
            tuvan_id: tuvan_id,
            token: 'abcd',
            name_tuvan_insert: my_info.name_tuvan_insert,
            username_tuvan_insert: my_info.username_tuvan_insert,
            password_tuvan_insert: my_info.password_tuvan_insert,
            location: my_info.location,
            tuvan_active_insert: my_info.tuvan_active_insert,

        },
        function (data, status) {
            console.log(data);
            make_effect_submit_done('btn_ok_tuvan');
        });



}

function insert_tuvan(){
    var my_info = captain.getForm('insert_tuvan_modal');
    if (my_info.name_tuvan_insert.trim() === ''){
        alert('Bạn cần điền tên Tư vấn viên');
        return null;
    }
    if (my_info.username_tuvan_insert.trim() === ''){
        alert('Bạn cần điền Username');
        return null;
    }
    if (my_info.password_tuvan_insert.trim() === ''){
        alert('Bạn cần điền Password');
        return null;
    }

    console.log("my_info");
    console.log(my_info);

    make_effect_submitting('btn_ok_tuvan');

    $.post("/feedback/request",{
            optcod: 'insert_tuvan', // có thể include optcode này vào đâu ko ?
            token: 'abcd',
            name_tuvan_insert: my_info.name_tuvan_insert,
            username_tuvan_insert: my_info.username_tuvan_insert,
            password_tuvan_insert: my_info.password_tuvan_insert,
            location: my_info.location,
            tuvan_active_insert: my_info.tuvan_active_insert,
        },
        function (data, status) {
            console.log(data);
            make_effect_submit_done('btn_ok_tuvan');
        });
}

function ClickActive_Deactive(event) {
    var obj = event.target;

    var action_status =  obj.getAttribute('action_status');

    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    $.post("/feedback/request",{
            optcod: 'tuvan_active', // có thể include optcode này vào đâu ko ?
            token: 'abcd',
            id: info_live.id,
            action_status: action_status,
        },
        function (data, status) {
            console.log(data);
            make_effect_submit_done('btn_ok_tuvan');
        });
}

function load_del_feedback_phone(event) {
    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    var r = confirm("Bạn có muốn xóa Feedbackphone :\n" + "ID: " + info_live);
    if (r == true) {
        $.post("/feedback/request",{
                optcod: 'del_feedbackphone', // có thể include optcode này vào đâu ko ?
                token: 'abcd',
                id: info_live,
            },
            function (data, status) {
                console.log(data);
                location.reload();
            });
    } else {
        // txt = "You pressed Cancel!";
    }
}

function load_del_feedback_form(event) {
    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    var r = confirm("Bạn có muốn xóa Feedback Form :\n" + "ID: " + info_live);
    if (r == true) {
        $.post("/feedback/request",{
                optcod: 'del_feedbackform', // có thể include optcode này vào đâu ko ?
                token: 'abcd',
                id: info_live,
            },
            function (data, status) {
                console.log(data);
                // location.reload();
            });
    } else {
        // txt = "You pressed Cancel!";
    }
}

// ================ TEACHER =======================
function click_ok_teacher() {
    var status = $('#btn_ok_teacher').attr('status');
    if(status === 'insert'){
        insert_teacher();
    }else{
        edit_teacher();
    }


}

function load_edit_teacher(event) {
    $('#btn_ok_teacher').attr('status','edit');

    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    $('#btn_ok_teacher').attr('teacher_id',info_live.teacher_id);


    $('#name_teacher_insert').val(info_live.name);
    $('#info_teacher_insert').val(info_live.info);
    $('#email_teacher_insert').val(info_live.email);
    $('#manager_email_insert').val(info_live.manager_email);

    if (info_live.giaotiep === '1'){
        var check = true;
    }else{
        var check = false;
    }
    $('#teacher_giaotiep_insert').prop('checked',check);

    if (info_live.toeic === '1'){
        var check = true;
    }else{
        var check = false;
    }
    $('#teacher_toeic_insert').prop('checked',check);


    if (info_live.ielts === '1'){
        var check = true;
    }else{
        var check = false;
    }
    $('#teacher_ielts_insert').prop('checked',check);

    if (info_live.aland === '1'){
        var check = true;
    }else{
        var check = false;
    }
    $('#teacher_aland_insert').prop('checked',check);



    $('#insert_teacher_modal').modal('show');

    // var array_convert = [];
}

function load_del_teacher(event) {
    var obj = event.target;
    var info = obj.getAttribute('info');
    var info_live = JSON.parse(info);
    console.log("info_live");
    console.log(info_live);

    var r = confirm("Bạn có muốn xóa Giảng viên :\n" + "Tên: " + info_live.name +'\nThông tin: ' + info_live.info );
    if (r == true) {
        $.post("/feedback/request",{
                optcod: 'del_teacher', // có thể include optcode này vào đâu ko ?
                token: 'abcd',
                teacher_id: info_live.teacher_id,
            },
            function (data, status) {
                console.log(data);
                make_effect_submit_done('btn_ok_teacher'); // có bao gồm reload
            });
    } else {
        // txt = "You pressed Cancel!";
    }

}

function edit_teacher(){
    var my_info = captain.getForm('insert_teacher_modal');
    if (my_info.name_teacher_insert.trim() === ''){
        alert('Bạn cần điền tên giáo viên');
        return null;
    }
    if (my_info.name_teacher_insert.trim() === ''){
        alert('Bạn cần điền email của giáo viên');
        return null;
    }
    // console.log("here");
    var teacher_id = $('#btn_ok_teacher').attr('teacher_id');
    // make_effect_submitting('btn_ok_teacher');

    $.post("/feedback/request",{
            optcod: 'edit_teacher', // có thể include optcode này vào đâu ko ?
            token: 'abcd',
            teacher_id: teacher_id,
            name_teacher_insert: my_info.name_teacher_insert,
            info_teacher_insert: my_info.info_teacher_insert,
            teacher_giaotiep_insert: my_info.teacher_giaotiep_insert,
            teacher_toeic_insert: my_info.teacher_toeic_insert,
            teacher_ielts_insert: my_info.teacher_ielts_insert,
            teacher_aland_insert: my_info.teacher_aland_insert,
            email_teacher_insert: my_info.email_teacher_insert,
            manager_email_insert: my_info.manager_email_insert,
        },
        function (data, status) {
            console.log(data);
            make_effect_submit_done('btn_ok_teacher');
        });



}

function insert_teacher(){
    var my_info = captain.getForm('insert_teacher_modal');
    if (my_info.name_teacher_insert.trim() === ''){
        alert('Bạn cần điền tên giáo viên');
        return null;
    }
    if (my_info.name_teacher_insert.trim() === ''){
        alert('Bạn cần điền email của giáo viên');
        return null;
    }

    make_effect_submitting('btn_ok_teacher');

    $.post("/feedback/request",{
        optcod: 'insert_teacher', // có thể include optcode này vào đâu ko ?
        token: 'abcd',
        teacher_giaotiep_insert: my_info.teacher_giaotiep_insert,
        teacher_ielts_insert: my_info.teacher_ielts_insert,
        teacher_toeic_insert: my_info.teacher_toeic_insert,
        teacher_aland_insert: my_info.teacher_aland_insert,
        info_teacher_insert: my_info.info_teacher_insert,
        name_teacher_insert: my_info.name_teacher_insert,
        email_teacher_insert: my_info.email_teacher_insert,
        manager_email_insert: my_info.manager_email_insert,
    },
    function (data, status) {
        console.log(data);
        make_effect_submit_done('btn_ok_teacher');
    });

}

//=================================================

function make_effect_submitting(id_btn){
    $('#' + id_btn).attr('disabled',true);
    var old_content = $('#' + id_btn).html();
    $('#' + id_btn).attr('old_content',old_content);
    $('#' + id_btn).html('Submitting');
}

function make_effect_submit_done(id_btn){
    $('#' + id_btn).attr('disabled',false);
    var old_content = $('#' + id_btn).attr('old_content');
    $('#' + id_btn).html(old_content);

    // hide all modal
    location.reload();
}



$(document).ready(function () {
    // bind event md bootstrap
    $('.select2_input').select2();
    $('#insert_class_modal').click(function () {
        document.getElementById("class_code").disabled = false;
    })
});

// captain
var captain = {
    aboutMe: function(){
        console.log("Im Captain. Read Document about me in https:// ");
    },
    getValById: function(id){
        var tagName = $('#' + id).get(0).tagName.toLowerCase();
        switch (tagName) {
            case "input":
                var type = $('#' + id).attr('type').toLowerCase();
                if (type === 'radio'){
                    // ========== gom value ntn ?

                }
                if (type === 'checkbox'){
                    return $('#' + id).prop('checked');
                }
                return $('#' + id).val();
            case "select":
                // Trả về giá trị value của thẻ đã selected
                // mutiply sẽ trả về 1 array
                var caption_get = $('#' + id).attr('caption_get');

                if ( ( typeof caption_get !== 'undefined' ) && (caption_get.trim().toLowerCase() === 'text' ) ){
                    // mutiply
                    var multiple = $('#' + id).attr('multiple');
                    var res = [];
                    $("#" + id + " > option").each(function() {
                        if (this.selected  == true){
                            res.push(this.text);
                        }
                    });

                    if (res.length === 1){
                        if ( ( multiple === 'multiple' ) || (multiple === true) ){
                            return res;
                        }else{
                            return res[0];
                        }
                    }

                    // return $('#' + id).children("option:selected").text();
                    return res;
                }
                return $('#' + id).val();

            case 'textarea':
                return $('#' + id).val();
            default:
                return $('#' + id).html();
        }
    },
    getForm: function(id_div, arr_tag, arr_id_more){
        var arr_tag_available = ['input', 'textarea', 'p', 'h1', 'h2','h3','h4','h5','h6'];

        if (typeof arr_tag === 'undefined'){
            arr_tag = ['input','textarea']; // default
        }

        var res = [];

        for (var i = 0; i < arr_tag.length; i++) {
            var mono = arr_tag[i];

            if (! arr_tag_available.includes(mono)){
                continue;
            }

            if (mono === 'input') {
                $("#" +id_div + " :" + mono).each(function () {
                    var id = $(this).attr('id');

                    if (( typeof id === 'undefined') || ( id === '' )) {
                        var name = $(this).attr('name');
                        if (( typeof name === 'undefined') || ( name === '' )){
                            id = captain.genIdElement(15);
                            $(this).attr('id',id);
                            res[id] = captain.getValById(id);
                        }else{
                            // id = name;
                            res[name] = captain.getValById(id);
                        }
                    }
                    res[id] = captain.getValById(id);
                });
            }else{

                $("#" +id_div).find('textarea').each(function () {
                    var id = $(this).attr('id');
                    if (( typeof id === 'undefined') || ( id === '' )) {
                        var name = $(this).attr('name');
                        if (( typeof name === 'undefined') || ( name === '' )){
                            id = captain.genIdElement(15);
                            $(this).attr('id',id);
                            res[id] = captain.getValById(id);
                        }else{
                            // id = name;
                            res[name] = captain.getValById(id);
                        }
                    }
                    res[id] = captain.getValById(id);
                });

            }

        }

        if (typeof arr_id_more !== 'undefined'){
            if (typeof arr_id_more === 'string'){
                arr_id_more = [arr_id_more];
            }
            for (var k = 0; k < arr_id_more.length; k++) {
                var mono_id = arr_id_more[k];
                res[mono_id] = captain.getValById(id);
            }
        }
        return res;
    },
    genIdElement: function(length){
        if (typeof length === 'undefined'){
            length = 10;
        }
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    },
    inArray: function(value,arr){
        return arr.includes(value);
    },
    // ============ Code 30.07 below
    merge: function (obj_total,obj1, obj2) {

        // Object.assign(my_info, plus1, plus2); // Thêm obj plus1 và plus 2 vào obj my_info
        // console.log("my_info");
        // console.log(my_info);
        //

    },
    copyToClipboard: function (val_copy) {
        // Cần show thẻ input trước rồi mới có thể set data
        if ($('#captain_copy_to_clipboard').length === 0){
            $('body').append('<input type="text" value="" id="captain_copy_to_clipboard" style="height: 0px; visibility: hidden!important">');
        }else{
            $('#captain_copy_to_clipboard').css('display','block');
        }

        // Cần show thẻ input trước rồi mới có thể set data
        $('#captain_copy_to_clipboard').val(val_copy);
        var copyText = document.getElementById("captain_copy_to_clipboard");
        copyText.select();
        document.execCommand("copy");
        $('#captain_copy_to_clipboard').css('display','none !important');
    },
};



function ClickOpenLink__(id_target) {
    var link = $('#' + id_target).val();
    openInNewTab(link);
}
function ClickCopy__(id_target) {
    var link = $('#' + id_target).val();
    captain.copyToClipboard(link);
    $('#' + id_target).select();
}

