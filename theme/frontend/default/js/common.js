$(document).ready(function (){

   $("#auto_search_button").click(function(){
      $( "#search" ).slideToggle( "slow", function() {
      });        
    });
    $('.sub-icon').click(function () {
        if ($(this).next('ul').css('display') == 'none') {
            $(this).html('-');
        } else {
            $(this).html('+');
        };              
        $(this).next('ul').slideToggle( "slow", function() {});        
    });

    $('.sub-icon2').click(function () {
        if ($(this).next('ul').css('display') == 'none') {
            $(this).html('-');
        } else {
            $(this).html('+');
        };              
        $(this).next('ul').slideToggle( "slow", function() {});
    });
 

    $('.category_new').find('h3').click(function () {
        if ($(this).next('.level2').css('display') == 'none') {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        };              
        $(this).next('.level2').slideToggle( "slow", function() {});        
    });            
  
    $(".list_baihoc ").find("thead").click(function(){
        $(this).siblings('thead').removeClass('active');
        $('tbody').css('display', 'none');
        if(!$(this).hasClass("active")){
            $(this).addClass("active");
            $(this).next('tbody').css('display', 'contents');
        }
        else{
            $(this).removeClass("active");
        }
    });

    /*SLIDE TOP HOME*/
    var owl_slide_top_home = $('.slide_top_home .owl-carousel, #top_banner .owl-carousel');
        owl_slide_top_home.owlCarousel({
            loop: true,
            autoplay: true,
            animateOut: 'fadeOut',
            autoplayTimeout: 6000,
            items: 1,
            pagination : false,
        })

    /*END SLIDE TOP HOME*/

    var owl_slide_book = $('.slide_book .owl-carousel');
        owl_slide_book.owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 6000,
            items: 1,
            pagination : false,
        })

  

    /*SLIDE LEARN*/
    var owl_list_learn = $('.list_learn .owl-carousel ,.bai_test_khac .owl-carousel');
        owl_list_learn.owlCarousel({
            loop: false,
            autoplay: false,
            margin:20,
            autoplayTimeout: 6000,
            items: 3,
            nav:false,
            responsive: {
                0: {
                        items: 1,
                        margin: 10
                },
                590: {
                        items: 2,
                        margin: 20
                },                
                1200: {
                    items:3
                },                  
            }             
        })

    /*END SLIDE LEARN*/  

    /*SLIDE EXPERT*/
    var owl_slide_expert = $('.slide_expert .owl-carousel');
        owl_slide_expert.owlCarousel({
            loop: true,
            autoplay: false,
            margin:30,
            autoplayTimeout: 6000,
            items: 5,
            nav:true,
            responsive: {
                0: {
                        items: 2,
                        margin: 10
                },
                590: {
                        items: 3,
                        margin: 20
                },
                1000: {
                    items: 4,
                    margin: 20
                },                
                1200: {
                    items:5
                },                  
            }             
        })

    /*END SLIDE EXPERT*/  

/**  DropDown */    

    function DropDown(el) {
                this.dd = el;
                this.placeholder = this.dd.children('span');
                this.opts = this.dd.find('ul.dropdown > li');
                this.val = '';
                this.index = -1;
                this.initEvents();
            }
            DropDown.prototype = {
                initEvents : function() {
                    var obj = this;

                    obj.dd.on('click', function(event){
                        $(this).toggleClass('active');
                        return false;
                    });

                    obj.opts.on('click',function(){
                        var opt = $(this);
                        obj.val = opt.text();
                        obj.index = opt.index();
                        obj.placeholder.text(obj.val);
                    });
                },
                getValue : function() {
                    return this.val;
                },
                getIndex : function() {
                    return this.index;
                }
            }

            $(function() {

                // var dd = new DropDown( $('#dd') );
                //////////// USER MENU //////////////
                $("#dd").bind('click', function(e){
                    $(this).toggleClass('active');
                    e.stopPropagation();
                });

                $(document).click(function() {
                    // all dropdowns
                    $('.wrapper-dropdown-3').removeClass('active');
                });

            });      
      
    
    /**MENU STICKY**/
    $(window).scroll(function() {
      if($(window).scrollTop() >= 610)
      {
        $('#header_sticky').addClass('show_sticky');
          
      }
      else
      {
        $('#header_sticky').removeClass('show_sticky');
      }
    });
    /**END MENU STICKY**/

    /*OPEN & CLOSE MAIN MENU*/
    $(function(){
        $('.btn_control_menu').click(function(){
        $('body').addClass('show_main_menu');
        });

            $('.close_main_menu, .mask-content').click(function(){
            $('body').removeClass('show_main_menu');
        });
    })
    /*END OPEN & CLOSE MAIN MENU*/

    /**BUTTON BACK TO TOP**/
    $(window).scroll(function() {
      if($(window).scrollTop() >= 200)
      {
        $('#to_top').fadeIn();
      }
      else
      {
        $('#to_top').fadeOut();
      }
    });

    $("#to_top,.on_top").click(function() {
      $("html, body").animate({ scrollTop: 0 });
      return false;
    });
    /**END BUTTON BACK TO TOP**/


    $('.block_search .input_form').click(function(){
        $('.block_search').addClass('focus');
    });
     $('.block_search .btn_reset').click(function(){
        $('.block_search').removeClass('focus');
    }); 

    $(".fillter-test").find(".on").click(function(){
        $(this).siblings('.on').removeClass('active');
        if(!$(this).hasClass("active")){
            $(this).addClass("active");
            $("body").addClass("open");
        }
        else{
            $(this).removeClass("active");
            $("body").removeClass("open");
        }      
    });


    $('#tuvan_form').submit(function(e){
        var self = $(this);
        console.log("sth");

        var self_submit = $("input[type=submit]",self);
        self_submit.css('background-color: red');
        console.log("self_submit");
        console.log(self_submit);


        self.find(".has-error").removeClass("has-error");
        self.find(".error").remove();
        e.preventDefault();
        $.ajax({
            type: 'post',
            dataType : 'json',
            url: $(this).attr("action"),
            data: $(this).serializeArray(),
            success: function (respon) {
                if(respon.status == "success"){
                    // redirect('/contact/success');
                    alert('Đăng ký thành công');
                } else {
                    $.each( respon.message, function( key, value ) {
                        var dom = self.find("input[name=\"" + key + "\"]").parent().addClass("has-error").append('<p class="error">' + value + '</p>');
                    });
                }
            },
            error: function(respon,code) {

            }
        });
    });

    $('#tuvan_form_detail').submit(function(e){
        var self = $(this);
        self.find(".has-error").removeClass("has-error");
        self.find(".error").remove();
        e.preventDefault();
        $.ajax({
            type: 'post',
            dataType : 'json',
            url: $(this).attr("action"),
            data: $(this).serializeArray(),
            success: function (respon) {
                if(respon.status == "success"){
                    // redirect('/contact/success');
                    alert('Đăng ký thành công');
                } else {
                    $.each( respon.message, function( key, value ) {
                        var dom = self.find("input[name=\"" + key + "\"]").parent().addClass("has-error").append('<p class="error">' + value + '</p>');
                    });
                }
            },
            error: function(respon,code) {

            }
        });
    });


    /* Add Submit Event for Form */
    // tuvan_form_new test_contact_form document_earn_form event_offline_form

    var arr_id_form_need_to_add_event_submit = ['tuvan_form_new','test_contact_form','document_earn_form','event_offline_form'];
    var pathname = window.location.pathname;
    var url      = window.location.href;

    for (var zign = 0; zign < arr_id_form_need_to_add_event_submit.length; zign++) {
        var mono_id_form = arr_id_form_need_to_add_event_submit[zign];
        $('#'+mono_id_form).submit(function(e){
            var self = $(this);
            $('#url_form_target').val(url);
            self.find(".has-error").removeClass("has-error");
            self.find(".error").remove();
            e.preventDefault();
            $.ajax({
                type: 'post',
                dataType : 'json',
                url: $(this).attr("action"),
                data: $(this).serializeArray(),
                success: function (respon) {
                    if(respon.status == "success"){
                        // redirect('/contact/success?type='+mono_id_form+'&url='+pathname);
                        console.log("data");
                        console.log(data);

                        alert('Đăng ký thành công !');
                    } else {
                        $.each( respon.message, function( key, value ) {
                            var dom = self.find("input[name=\"" + key + "\"]").parent().addClass("has-error").append('<p class="error">' + value + '</p>');
                        });
                    }
                },
                error: function(respon,code) {

                }
            });
        });
    }

    // Get new noti cho người dùng
    getNewNoti();

});

// Start notification Code :))
function showNotification() {
    var element = $('.notifications');
    element.toggleClass("open");
    var now_number = parseInt($('#number_noti').html());
    if (now_number > 0){
        $('#number_noti').html(0);
        var list_noti = [];
        $(".li_notif_unread").each(function () {
            var id_noti = $(this).attr('id_noti');
            list_noti.push(id_noti);
        });
        makeNotiOld(list_noti);
    }
}

// API lấy noti mới cho người dùng
function getNewNoti() {
    $.post("/news/getnoti",
        {

        },
        function (data, status) {
            // console.log(data);
            try {
                var res = JSON.parse(data);
                var status_res = res['status'];
                if (status_res === 'success'){
                    var number = res['number'];
                    var html = res['html'];
                    $('#number_noti').html(number);
                    $('#div_notifbox').html(html);
                }
            }catch(err) {
                console.log(err);
            }

        });
    }

// API thông báo cho Server biết người dùng đã xem Noti nào
function makeNotiOld(list_noti){
    $.post("/news/notiold",
        {
            // id_user: localStorage.getItem('idu_wb'),
            // token: localStorage.getItem('tkk_wb'),
            // number: 1,
            list_noti: list_noti,
        },
        function (data, status) {
            console.log(data);
        });
}

// End notification

function showUserMenu() {
    document.querySelector('.user-menu').classList.toggle('open');
    if($('.notifications-mobile').length) {
        document.querySelector('.notifications-mobile').classList.remove('open');
    }
}