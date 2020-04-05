$(document).ready(function () {
    // get comment
    var t = makeid(20);
    $(".comment-interact").each(function () {
        var data = $(this).attr("data-content");
        $.post("/Comment/getComment?t=" + t,
            {
                data: data,
            },
            function (data, status) {
                $('#comment_block').append(data);
                bind_event_cmt_all();

                if ( $('#no_user_capacity').length > 0 ) {
                    $('.btn_like_cmt').css('display','none');
                    // Thay redirect link
                    var link = 'https://www.aland.edu.vn/users/login?redirect_uri=' + window.location.href;
                    $('#btn_log_in_cmt').attr('href',link);
                }
            });
    });

});


function bind_event_cmt_all() {
    $(".insert_cmt").each(function () {
        $(this).keypress(function (e) {
            if (e.which == 13) {
                var obj = e.target;
                var content = obj.innerHTML;
                content = content.replace(/\u00a0/g," ");
                content = content.replace(/(<([^>]+)>)/ig," ");
                content = content.replace(/(<([^>]+)>)/ig," ");
                content = content.replace(/&nbsp;/g, ' ');
                if (content.trim() === '') {
                    return false;
                }

                var target_id = obj.getAttribute('target_id');
                var type = obj.getAttribute('type');
                var parent_id = obj.getAttribute('parent_id');
                var char_avar = obj.getAttribute('my_char_avar');
                var username = obj.getAttribute('my_username');
                var avatar = obj.getAttribute('my_avatar');
                var level = obj.getAttribute('level');
                var color = obj.getAttribute('color');
                obj.innerHTML = '';

                var rand_id = makeid(20);


                if (level == "1") {
                    var html_new = insertNewCmtLv1(avatar,char_avar, username, content, color, rand_id,target_id,type);
                    var wrapper = document.createElement('div');
                    wrapper.innerHTML = html_new;
                    var el = wrapper.firstChild;
                    var el2 = wrapper.children[1];

                    var block_cmt = document.getElementById('comment-list-target-' + target_id + '-type-' + type);
                    block_cmt.appendChild(el);
                    block_cmt.appendChild(el2);

                    bind_event_cmt_new(level,rand_id);
                } else {
                    // level 2
                    var cmt_id = obj.getAttribute('cmt_id');
                    var html_new = insertNewCmtLv2(avatar,char_avar, username, content, color, rand_id,cmt_id);
                    var wrapper = document.createElement('div');
                    wrapper.innerHTML = html_new;
                    var el = wrapper.firstChild;
                    var block_cmt_lv1 = document.getElementById('comment-block-lv1-' + parent_id);
                    block_cmt_lv1.appendChild(el);

                    bind_event_cmt_new(level,rand_id);
                }

                $.post("/Comment/insertComment",
                    {
                        content: content,
                        type: type,
                        target_id: target_id,
                        content: content,
                        parent_id: parent_id,
                        rand_id: rand_id,
                    },
                    function (data, status) {
                        var id_cmt_new = data;
                        $('#like' + rand_id).attr('cmt_id',id_cmt_new);
                        $('#like' + rand_id).css('display','inline-block');
                        $('#like' + rand_id).attr('id',id_cmt_new);
                        $('#reply' + rand_id).css('display','inline-block');

                        if (level == "1"){

                            $('#insert-cmt-' + rand_id).attr('cmt_id',id_cmt_new);
                            $('#insert-cmt-' + rand_id).attr('parent_id',id_cmt_new);
                            $('#insert-cmt-' + rand_id).attr('id','insert-cmt-' + id_cmt_new);

                            $('#insertComment-' + rand_id).css('display','flex');
                            $('#insertComment-' + rand_id).css('display','flex');

                            $('#comment-block-lv1-'+ rand_id).attr('id','comment-block-lv1-'+ id_cmt_new);

                            $('#reply' + rand_id).attr('cmt_id',id_cmt_new);


                            $("#btn_menu_" + rand_id ).click(function (e){
                                showDropdownCommentOption(id_cmt_new);
                            })

                            $("#btn_del_" + rand_id ).click(function (e){
                                ClickDelComment(id_cmt_new,1);
                            });

                            $("#DropdownComment" + rand_id ).attr('id','DropdownComment' + id_cmt_new);
                            $("#-comment-reply-" + rand_id ).attr('id','-comment-reply-' + id_cmt_new);


                        }else{
                            $("#btn_menu_" + rand_id ).click(function (e){
                                showDropdownCommentOption(id_cmt_new);
                            });

                            $("#btn_del_" + rand_id ).click(function (e){
                                console.log("ClickDelComment lv 222");
                                console.log("id_cmt_new");
                                console.log(id_cmt_new);

                                ClickDelComment(id_cmt_new,2);
                            });

                            $("#DropdownComment" + rand_id ).attr('id','DropdownComment' + id_cmt_new);
                            $("#-comment-reply-" + rand_id ).attr('id','-comment-reply-' + id_cmt_new);
                        }
                    });

                return false;
            }
        });
    });

    $(".btn_reply").each(function () {
        $(this).click(function (e) {
            var level = $(this).attr('level');
            var target_id = $(this).attr('target_id');
            var type = $(this).attr('type');
            var cmt_id = $(this).attr('cmt_id');

            if (level == '0'){
                $('#insertComment-target' + target_id + '-type-' + type).focus();
            }else{
                $('#insert-cmt-' + cmt_id).focus();
            }

            return false;
        });

    });

    $(".btn_like_cmt").each(function () {
        $(this).click(function (e) {
            var cmt_id = $(this).attr('cmt_id');
            var status = $(this).html();

            if (status == 'Thích'){
                $(this).html('Đã thích');
                $(this).css('font-weight','bold');
                $.post("/Comment/actionLike",
                    {
                        status: 0,
                        comment_id: cmt_id,
                    },
                    function (data, status) {

                    });

            }else{
                $(this).html('Thích');
                $(this).css('font-weight','normal');
                $.post("/Comment/actionLike",
                    {
                        status: 1,
                        comment_id: cmt_id,
                    },
                    function (data, status) {

                    });
            }

            return false;
        });

    });

    $('.btn_see_more').each(function () {
        $(this).click(function (e) {
            var cmt_id = $(this).attr('cmt_id');
            $('#content_short'+ cmt_id).css('display','none');
            $(this).css('display','none');
            $('#content'+ cmt_id).css('display','inline');

        });
    });
}

function bind_event_cmt_new(level,id_cmt_random) {
    // bind event like, reply

    // .btn_reply
    $('#reply' +  id_cmt_random).click(function (e) {
        var level = $(this).attr('level');
        var target_id = $(this).attr('target_id');
        var type = $(this).attr('type');
        var cmt_id = $(this).attr('cmt_id');

        if (level == '0'){
            $('#insertComment-target' + target_id + '-type-' + type).focus();
        }else{
            $('#insert-cmt-' + cmt_id).focus();
        }

        return false;
    });

    // .btn_like_cmt
    $('#like' + id_cmt_random).click(function (e) {
        var cmt_id = $(this).attr('cmt_id');
        var status = $(this).html();

        if (status == 'Thích'){
            $(this).html('Đã thích');
            $(this).css('font-weight','bold');
            $.post("/Comment/actionLike",
                {
                    status: 0,
                    comment_id: cmt_id,
                },
                function (data, status) {

                });

        }else{
            $(this).html('Thích');
            $(this).css('font-weight','normal');
            $.post("/Comment/actionLike",
                {
                    status: 1,
                    comment_id: cmt_id,
                },
                function (data, status) {

                });
        }

        return false;
    });


    if (level == '1'){
        // .insert_cmt
        $("#insert-cmt-" + id_cmt_random ).keypress(function (e) {
            if (e.which == 13) {
                var obj = e.target;
                var content = obj.innerHTML;
                content = content.replace(/\u00a0/g," ");
                content = content.replace(/(<([^>]+)>)/ig," ");
                content = content.replace(/(<([^>]+)>)/ig," ");
                content = content.replace(/&nbsp;/g, ' ');
                if (content.trim() === '') {
                    return false;
                }

                var target_id = obj.getAttribute('target_id');
                var type = obj.getAttribute('type');
                var parent_id = obj.getAttribute('parent_id');
                var char_avar = obj.getAttribute('my_char_avar');
                var username = obj.getAttribute('my_username');
                var level = obj.getAttribute('level');
                var color = obj.getAttribute('color');
                obj.innerHTML = '';

                var rand_id = makeid(20);


                if (level == "1") {
                    var html_new = insertNewCmtLv1(char_avar, username, content, color, rand_id,target_id,type);
                    var wrapper = document.createElement('div');
                    wrapper.innerHTML = html_new;
                    var el = wrapper.firstChild;
                    var el2 = wrapper.children[1];

                    var block_cmt = document.getElementById('comment-list-target-' + target_id + '-type-' + type);
                    block_cmt.appendChild(el);
                    block_cmt.appendChild(el2);

                    bind_event_cmt_new(level,rand_id);
                } else {
                    // level 2
                    var cmt_id = obj.getAttribute('cmt_id');
                    var html_new = insertNewCmtLv2(char_avar, username, content, color, rand_id,cmt_id);
                    var wrapper = document.createElement('div');
                    wrapper.innerHTML = html_new;
                    var el = wrapper.firstChild;
                    var block_cmt_lv1 = document.getElementById('comment-block-lv1-' + parent_id);
                    block_cmt_lv1.appendChild(el);
                    bind_event_cmt_new(level,rand_id);

                }

                $.post("/Comment/insertComment",
                    {
                        content: content,
                        type: type,
                        target_id: target_id,
                        content: content,
                        parent_id: parent_id,
                        rand_id: rand_id,
                    },
                    function (data, status) {
                        var id_cmt_new = data;
                        $('#like' + rand_id).attr('cmt_id',id_cmt_new);
                        $('#like' + rand_id).css('display','inline-block');
                        $('#like' + rand_id).attr('id',id_cmt_new);
                        $('#reply' + rand_id).css('display','inline-block');

                        if (level == "1"){

                            $('#insert-cmt-' + rand_id).attr('cmt_id',id_cmt_new);
                            $('#insert-cmt-' + rand_id).attr('parent_id',id_cmt_new);
                            $('#insert-cmt-' + rand_id).attr('id','insert-cmt-' + id_cmt_new);

                            $('#insertComment-' + rand_id).css('display','flex');
                            $('#insertComment-' + rand_id).css('display','flex');

                            $('#comment-block-lv1-'+ rand_id).attr('id','comment-block-lv1-'+ id_cmt_new);

                            $('#reply' + rand_id).attr('cmt_id',id_cmt_new);

                        }else{

                        }
                    });

                return false;
            }
        });



    }else{
        //
    }





}

function ClickDelComment(id_comment, level) {

    $('#DropdownComment'+ id_comment).css('display','none');

    // Cấp 1: Xóa block cấp 1 và ô insert cấp 2
    // Cấp 2: xóa block cấp 2
    if (level == 1){
        // xóa comment level 1
        $('#comment-block-lv1-' + id_comment).remove();
        $('#-comment-reply-' + id_comment).remove();

    }else{
        $('#-comment-reply-' + id_comment).remove();
    }

    $.post("/Comment/delComment",
        {
            comment_id: id_comment,
        },
        function (data, status) {

        });

    return false;
}

function showDropdownCommentOption(id_comment) {
    console.log("hehehehe");
    var css_display = $('#DropdownComment'+ id_comment).css('display');

    if( css_display === 'none'){
        $('.dropdown-comment-option').css('display','none');
        $('#DropdownComment'+ id_comment).css('display','block');
    }else{
        $('#DropdownComment'+ id_comment).css('display','none');
    }
    return false;
}

function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function insertNewCmtLv1(avatar,char_avar, username, content, color, rand_id,target_id,type) {
    var html =
        '<div id="comment-block-lv1-'+ rand_id + '">' +
        '<div class="comment-block">' +
        // '<figure class="comment-block__avatar -color-random-' + color + '">' +
        // '<figcaption class="text-avatar">' + char_avar + '</figcaption>' +
        // '</figure>' +
        '<div><img class="comment-block__avatar" src="' + avatar + '" /></div>' +
        '<div class="comment-block__content">' +
        '<div class="user-comment">' +
        '<form class="user-comment__text">' +
        '<p class="text-content">' +
        '<span class="username">' + username + '</span> ' +
        '<span id="content*">' + content + '</span>' +
        '</p>' +
        '</form>' +
        '<div class="user-comment__btn-more">' +
        '<a href="javascript:void(0)" class="button-more" id="btn_menu_' + rand_id + '" ><span class="icon-baseline-more_horiz-24px-1"></span></a>' +
        '<ul class="dropdown-comment-option" id="DropdownComment' + rand_id + '" >' +
        '<li id="btn_del_' + rand_id + '"  class="menu_comment">' +
        '<a href="javascript:void(0)" class="link-items special-option">' +
        'Xóa bình luận' +
        '</a>' +
        '</li>' +
        '</ul>' +
        '</div>' +
        '</div>' +
        '<div class="button">' +
        '<div class="button__like-reply-time">' +
        '<a cmt_id="*" href="" class="button-action custom-margin btn_like_cmt" id="like' + rand_id + '" style="display: none">Thích</a>' +
        '<a target_id="' + target_id + '"   type="' + type + '" href="" level="1"  class="button-action custom-margin btn_reply"  id="reply' + rand_id + '" style="display: none">Trả lời</a>' +
        '<span class="date-comment custom-margin">Vừa xong</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div> ' +
        '<div id="-comment-reply-' + rand_id + '" > ' +
        '<div class="comment-block -comment-reply -custom-answer" id="insertComment-' + rand_id + '" style="display: none">' +

// '<figure class="comment-block__avatar -color-random-' + color + ' -comment-reply"> ' +
// '<figcaption class="text-avatar -comment-reply">' + char_avar + '</figcaption> ' +
// '</figure> ' +
        '<div><img class="comment-block__avatar" src="' + avatar + '" /></div>' +
'<div class="comment-block__content"> ' +
'<div class="user-comment"> ' +
'<form class="user-comment__text -custom-answer"> ' +
'<div id="insert-cmt-'+ rand_id + '" cmt_id="*" color="'+ color +'"   my_char_avar="' + char_avar + '"   my_username="' + username + '"  parent_id="*" level="2"  target_id="' + target_id + '"  type="' + type + '"  class="text-content -custom-answer insert_cmt" contenteditable="true" placeholder=" Viết phản hồi..." spellcheck="false"></div>' +
'</form> ' +
'<div class="user-comment__btn-more"> ' +
'<a href="" class="button-more"><span class="icon-baseline-more_horiz-24px-1"></span></a> ' +
'</div> ' +
'</div>  ' +
'</div> ' +
'</div> '
    '</div> ';

    return html;


}

function insertNewCmtLv2(avatar, char_avar, username, content, color, rand_id,cmt_id) {

    var html =
        '<div class="comment-block -comment-reply" id="-comment-reply-' +  rand_id + '">' +
        // '<figure class="comment-block__avatar -color-random-' + color + '  -comment-reply">' +
        // '<figcaption class="text-avatar -comment-reply">' + char_avar + '</figcaption>' +
        // '</figure>' +
        '<div><img class="comment-block__avatar" src="' + avatar + '" /></div>' +
        '<div class="comment-block__content">' +
        '<div class="user-comment">' +
        '<form class="user-comment__text -comment-reply">' +
        '<p class="text-content">' +
        '<span class="username">' + username + '</span> ' +
        '<span id="content_short17">' + content + '</span>' +
        '</p>' +
        '</form>' +
        '<div class="user-comment__btn-more">' +
        '<a href="javascript:void(0)" class="button-more" id="btn_menu_' + rand_id + '" ><span class="icon-baseline-more_horiz-24px-1"></span></a>' +
        '<ul class="dropdown-comment-option" id="DropdownComment' + rand_id + '" >' +
        '<li id="btn_del_' + rand_id + '"  class="menu_comment">' +
        '<a href="javascript:void(0)" class="link-items special-option">' +
        'Xóa bình luận' +
        '</a>' +
        '</li>' +
        '</ul>' +
        '</div>' +
        '</div>' +
        '<div class="button">' +
        '<div class="button__like-reply-time">' +
        '<a cmt_id="*" href="" class="button-action custom-margin btn_like_cmt" id="like' + rand_id + '" style="display: none">Thích</a>' +
        '<a cmt_id="' + cmt_id + '" href="" class="button-action custom-margin btn_reply" id="reply' + rand_id + '" level="2">Trả lời</a>' +
        '<span class="date-comment custom-margin">Vừa xong</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    return html;


}
