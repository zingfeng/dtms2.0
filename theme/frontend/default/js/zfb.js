// class default: zf_input

// classname canvas: instruction_zf_canvas__
// track and untrack Canvas
// Canvas is something which not intelligent - Để có thể thay đổi thuộc tính của nó thì cần track nó cụ thể
// Cụ thể là lưu nó theo tên biến
// Trường hợp chỉ cần vẽ 1 hình 1 lúc và cần hiệu ứng chuyển giữa các hình thì cần dùng ham, track,
// Truowngdf hợp cần vẽ nhiều hình 1 lúc thì dùng hàm independent

// 4 khối hàm chia bởi 2 miền: draw indepent và ( draw auto hay full config)
//


var instruction_zf = {
    rect2d: 'This is rect draw by instruction_zf',  // to track
    id_target: 'id_element_target_default',
    borderColor: 'rgba(0,0,0,0.75)',
    borderWidth: 1,
    padding: 3,
    time_effect: 200, // ms
    interval_effect: 'var interval',
    x : 0,
    y : 0,
    width : 0,
    height : 0,

    clear: function (id_target){
        $("#instruction_zf_canvas__" + id_target).remove();
    },

    clearAll: function (){
        $(".instruction_zf_canvas__").remove();
    },

    // ============== HÀM TRACK - Auto Config
    drawSmart: function (id_target){
        console.log("SMMMMMMM");

        var rect = instruction_zf.getPositionXY(id_target);
        instruction_zf.drawRectOutside(rect,instruction_zf.borderColor,instruction_zf.borderWidth,instruction_zf.padding,id_target);
    },

    // ============== HÀM TRACK - Full config
    draw: function (config_arr){
        for (var i = 0; i < config_arr.length; i++) {
            var mono_config = config_arr[i];
            var name_config = mono_config[0];
            window['instruction_zf'][name_config] = mono_config[1];
        }
        var rect = instruction_zf.getPositionXY(instruction_zf.id_target);
        instruction_zf.drawRectOutside(rect,instruction_zf.borderColor,instruction_zf.borderWidth,instruction_zf.padding,instruction_zf.id_target);
    },
    drawRectOutside: function (rect,borderColor,borderWidth,padding,id_target ){
        // var bottom =  rect.bottom;
        // var top =  rect.top;
        // var left =  rect.left;
        // var right =  rect.right;

        var height =  rect.height;
        var width =  rect.width;
        var x =  rect.x;
        var y =  rect.y;

        x = x - padding;
        y = y - padding;
        width = width + padding * 2;
        height = height + padding * 2;
        instruction_zf.drawRect(x,y,width,height,borderColor,borderWidth,id_target);
    },
    drawRect: function (x,y,width,height,borderColor,borderWidth,id_target) {
        var canvas = document.createElement('canvas'); //Create a canvas element
        //Set canvas width/height
        canvas.style.width='100%';
        canvas.style.height='100%';

        if ( $('#instruction_zf_canvas__' + id_target ).length === 0 ){
            // Save config to track
            instruction_zf.x = x;
            instruction_zf.y = y;
            instruction_zf.width = width;
            instruction_zf.height = height;
            instruction_zf.borderColor = borderColor;
            instruction_zf.borderWidth = borderWidth;
            instruction_zf.id_target = id_target;
            // ====================

            canvas.id= 'instruction_zf_canvas__' + id_target;
            canvas.className = 'instruction_zf_canvas__';

            //Set canvas drawing area width/height
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            //Position canvas
            canvas.style.position = 'fixed';
            // canvas.style.backgroundColor =  'rgba(0, 0, 0, 0.3)';
            canvas.style.left = 0;
            canvas.style.top = 0;
            canvas.style.zIndex= 100;
            canvas.style.pointerEvents='none'; //Make sure you can click 'through' the canvas
            document.body.appendChild(canvas); //Append canvas to body element
            instruction_zf.rect2d = canvas.getContext('2d');

            //Draw rectangle
            if (typeof borderWidth !== 'undefined'){
                instruction_zf.rect2d.lineWidth = borderWidth;
            }
            if (typeof borderColor !== 'undefined'){
                instruction_zf.rect2d.strokeStyle = borderColor;
            }
            instruction_zf.rect2d.rect(x, y, width, height);
            instruction_zf.rect2d.stroke();
            // Dưới đây là lệnh vẽ hình full màu bên trong
            // instruction_zf.rect2d.fillStyle = 'yellow';
            // instruction_zf.rect2d.fill();

        }

    },

    // ======= HÀM MOVE TRACK // move rect tracking của thư viện đến 1 id_target_mới
    moveRectTrackingToNewTarget: function (id_target_new,id_target_old,time_effect, new_borderColor, new_borderWidth, new_padding) {
        if (typeof time_effect === 'undefined'){
            time_effect = instruction_zf.time_effect;
        }
        if (typeof new_borderColor === 'undefined'){
            new_borderColor = instruction_zf.borderColor;
        }
        if (typeof new_borderWidth === 'undefined'){
            new_borderWidth = instruction_zf.borderWidth;
        }
        if (typeof new_padding === 'undefined'){
            new_padding = instruction_zf.padding;
        }

        var newTarget = instruction_zf.getPositionXY(id_target_new);
        newTarget.x -=   new_padding;
        newTarget.y -=   new_padding;
        newTarget.width += new_padding*2;
        newTarget.height += new_padding*2;

        // Block 5 ms
        var number_block = ( time_effect /5);

        // Calculate
        var delta_x_per_block = (newTarget.x - instruction_zf.x) /number_block;
        var delta_y_per_block = (newTarget.y - instruction_zf.y) /number_block ;
        var delta_width_per_block = (newTarget.width - instruction_zf.width) /number_block;
        var delta_height_per_block = (newTarget.height - instruction_zf.height) /number_block;
        var canvas = document.createElement('canvas'); //Create a canvas element
        //Set canvas width/height
        canvas.style.width='100%';
        canvas.style.height='100%';

        if ( $('#instruction_zf_canvas__' + id_target_old ).length > 0 ){
            instruction_zf.clear(id_target_old);
            var index_block = 0;
            instruction_zf.interval_effect =  setInterval(function(){
                if (index_block <= number_block ){
                    instruction_zf.clear(id_target_new);
                    instruction_zf.drawRect(    newTarget.x - delta_x_per_block*(number_block - index_block),
                        newTarget.y - delta_y_per_block*(number_block - index_block),
                        newTarget.width - delta_width_per_block*(number_block - index_block),
                        newTarget.height - delta_height_per_block*(number_block - index_block),
                        new_borderColor,new_borderWidth,id_target_new);

                    index_block ++;

                }else{
                    // Finish
                    instruction_zf.draw(newTarget.x ,newTarget.y,newTarget.width,newTarget.height,new_borderColor,new_borderWidth,id_target_new);
                    clearInterval(instruction_zf.interval_effect);
                }
            }, 5);
        }

    },


    // ==============  HÀM INDEPENDENT - Auto Config
    drawSmartIndependent: function (id_target){
        var rect = instruction_zf.getPositionXY(id_target);
        instruction_zf.drawRectOutsideIndependent(rect,instruction_zf.borderColor,instruction_zf.borderWidth,instruction_zf.padding,id_target);
    },

    // ==============  HÀM INDEPENDENT - Auto Config
    drawIndependent: function (config_arr){
        var config_independent = [];
        for (var m = 0; m < config_arr.length; m++) {
            var mono_config = config_arr[m];
            var name_config = mono_config[0];
            config_independent[name_config] = mono_config[1];
        }

        // load default
        if (typeof config_independent['borderColor'] === 'undefined'){
            config_independent['borderColor'] = 'rgba(0,0,0,0.75)';
        }
        if (typeof config_independent['borderWidth'] === 'undefined'){
            config_independent['borderWidth'] = 2;
        }
        if (typeof config_independent['padding'] === 'undefined'){
            config_independent['padding'] = 3;
        }
        if (typeof config_independent['id'] === 'undefined'){
            config_independent['id'] = 'id_element_target_default';
        }

        var rect = instruction_zf.getPositionXY(config_independent['id']);
        instruction_zf.drawRectOutsideIndependent(rect, config_independent['borderColor'],config_independent['borderWidth'],
            config_independent['padding'],config_independent['id']);
    },

    // ==============  HÀM INDEPENDENT - Full Config
    drawRectOutsideIndependent: function (rect,borderColor,borderWidth,padding,id_target ){
        // var bottom =  rect.bottom;
        // var top =  rect.top;
        // var left =  rect.left;
        // var right =  rect.right;

        var height =  rect.height;
        var width =  rect.width;
        var x =  rect.x;
        var y =  rect.y;

        x = x - padding;
        y = y - padding;
        width = width + padding * 2;
        height = height + padding * 2;

        instruction_zf.drawRectIndependent(x,y,width,height,borderColor,borderWidth,id_target);
    },
    drawRectIndependent: function (x,y,width,height,borderColor,borderWidth,id_target) {
        var canvas = document.createElement('canvas'); //Create a canvas element
        //Set canvas width/height
        canvas.style.width='100%';
        canvas.style.height='100%';

        if ( $('#instruction_zf_canvas__' + id_target ).length === 0 ){

            canvas.id= 'instruction_zf_canvas__' + id_target;
            canvas.className = 'instruction_zf_canvas__';

            //Set canvas drawing area width/height
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            //Position canvas
            canvas.style.position = 'fixed';
            // canvas.style.backgroundColor =  'rgba(0, 0, 0, 0.3)';
            canvas.style.left = 0;
            canvas.style.top = 0;
            canvas.style.zIndex= 100000;
            canvas.style.pointerEvents='none'; //Make sure you can click 'through' the canvas
            document.body.appendChild(canvas); //Append canvas to body element
            var context_no_track = canvas.getContext('2d');

            //Draw rectangle
            if (typeof borderWidth !== 'undefined'){
                context_no_track.lineWidth = borderWidth;
            }
            if (typeof borderColor !== 'undefined'){
                context_no_track.strokeStyle = borderColor;
            }
            context_no_track.rect(x, y, width, height);
            context_no_track.stroke();
            // Dưới đây là lệnh vẽ hình full màu bên trong
            // instruction_zf.rect2d.fillStyle = 'yellow';
            // instruction_zf.rect2d.fill();

        }

    },

    // =============  TECHNICAL
    getPositionXY:  function (id) {
        var target = document.getElementById(id);

        // Việc thẻ mẹ có thuộc tính has scroll sẽ ảnh hưởng đến tọa độ Dom rect của element
        // Cần get thêm chiều rộng của scroll để điều chỉnh vị trí khung element
        // ko chỉ thế còn phụ thuộc vào thuộc tính position của các thẻ mẹ
        // 1 điểm yếu của thư viện



        // var scroll_body_width =  instruction_zf.getScrollbarWidthBody();
        // console.log("scroll_body_width");
        // console.log(scroll_body_width);
        // scroll_body_width = 0;


        // Idea: Biến thẻ body không có scroll để xác định vị trí rect chuẩn nhất
        $('body').css('overflow','hidden');
        var rect = target.getBoundingClientRect();
        $('body').css('overflow','auto');

        return rect;
    },

    // Việc thẻ mẹ có thuộc tính has scroll sẽ ảnh hưởng đến tọa độ Dom rect của element
    // Cần get thêm chiều rộng của scroll để điều chỉnh vị trí khung element
    // ko chỉ thế còn phụ thuộc vào thuộc tính position của các thẻ mẹ
    // 1 điểm yếu của thư viện
    hasScroll: function (jquery_element){
        // Đúng ra cần check all parent element: thuộc tính scrollWidth  và clientWidth để xác định scroll
        //  Thuộc tính position để xem nó có ảnh hưởng không ??
        // Hiện tại chỉ check scroll bar của thẻ body

    },

    getScrollbarWidthBody: function (){
        // check chiều dày của thanh scroll dọc và ngang
        // check vị trí của thanh scroll dọc là bên trái hay bên phải
        // check vị trí của thanh scroll ngang là bên trên hay bên dưới

        // Hiện tại chỉ check chiều dày của scroll bar dọc
        // Creating invisible container
        const outer = document.createElement('div');
        outer.style.visibility = 'hidden';
        outer.style.overflow = 'scroll'; // forcing scrollbar to appear
        outer.style.msOverflowStyle = 'scrollbar'; // needed for WinJS apps
        document.body.appendChild(outer);

        // Creating inner element and placing it in the container
        const inner = document.createElement('div');
        outer.appendChild(inner);

        // Calculating difference between container's full width and the child width
        const scrollbarWidth = (outer.offsetWidth - inner.offsetWidth);

        // Removing temporary elements from the DOM
        outer.parentNode.removeChild(outer);

        return scrollbarWidth;
    },


    // ===================== POP OVER Instruction
    // - 2 kiểu config: config = html hoặc js

    // config = html
    instruct_html: function (config_instruct_popover) {
        instruction_zf.type_instruct = 'html';
        instruction_zf.roadmap_hmtl = config_instruct_popover;
        for (var i = 0; i < config_instruct_popover.length; i++) {
            var id_mono = config_instruct_popover[i];

            if (! $("#" + id_mono).hasClass('zf_intruct_target_element') ){
                $("#" + id_mono).addClass('zf_intruct_target_element');
                // Để quản lý ẩn hiện
            }

            $("#" + id_mono).popover({
                toggle: 'popover',
                placement: 'auto',
                title: 'Instruction',
                html: true,
                content: id_mono,
            });

            $("#" + id_mono).bind("click", function(){
                // lấy lại mũi tên arrow
                var id_popover_shown = $(this).attr('aria-describedby');
                var old_content = $('#' + id_popover_shown + ':last-child').html();

                if ( (typeof old_content) !== 'undefined' ){

                    var id_target = $(this).attr('id');
                    var content_to_show = '';
                    $(".content_instruct").each(function () {
                        if ($(this).attr("target") === id_target){
                            content_to_show = $(this).html();
                        }
                    });


                    var n = old_content.indexOf("</div>");
                    var arrow = old_content.substr(0,n+6);
                    console.log("arrow");
                    console.log(arrow);

                    $('#' + id_popover_shown + ':last-child').html(arrow +content_to_show );
                }



            });
        }

        // bắt đầu
    },

    start_instruct: function (){
        if (instruction_zf.type_instruct === 'html'){
            var roadmap_going = instruction_zf.roadmap_hmtl;
            var now_index_roadmap = instruction_zf.now_index;

            if (now_index_roadmap < 0 ){
                // Bắt đầu
                instruction_zf.now_index = 0;
                instruction_zf.pointer_to_instruct_element_start(roadmap_going[0]);
            }else{
                // Đây ko phải bắt đầu
            }
        }
    },

    next_instruct: function (){
        if (instruction_zf.type_instruct === 'html'){
            var roadmap_going = instruction_zf.roadmap_hmtl;
            var now_index_roadmap = instruction_zf.now_index;
            var all_length_instruct = roadmap_going.length;

            if (now_index_roadmap < ( all_length_instruct - 1 ) ){
                // Bắt đầu
                var id_target_old = roadmap_going[now_index_roadmap];
                now_index_roadmap ++;
                var id_target_new = roadmap_going[now_index_roadmap];

                instruction_zf.now_index = now_index_roadmap;
                instruction_zf.pointer_to_instruct_element_next(id_target_new,id_target_old);
            }else{
                // Stop all instruct
            }
        }
    },

    // vẽ lần đầu
    pointer_to_instruct_element_start: function (id_element_new){
        // scroll to element new if it is not in viewport
        if ( ! instruction_zf.isScrolledIntoView($('#' + id_element_new)) ){
            $('html, body').animate({
                scrollTop: $("#" + id_element_new).offset().top
            }, 500);
        }

        instruction_zf.drawSmart(id_element_new);
        $('#' + id_element_new).popover('show');
    },


    isScrolledIntoView: function(elem){
        var $elem = $(elem);
        var $window = $(window);

        var docViewTop = $window.scrollTop();
        var docViewBottom = docViewTop + $window.height();

        var elemTop = $elem.offset().top;
        var elemBottom = elemTop + $elem.height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    },


    // có move
    pointer_to_instruct_element_next: function (id_element_new, id_element_old){
        // scroll to element new if it is not in viewport
        console.log("pointer_to_instruct_element_next");


        if ( ! instruction_zf.isScrolledIntoView($('#' + id_element_new)) ){
            console.log('Scroll to ' + id_element_new);
            $('html, body').animate({
                scrollTop: $("#" + id_element_new).offset().top
            }, 500);
        }
        console.log('Start move Rect ');
        instruction_zf.moveRectTrackingToNewTarget(id_element_new,id_element_old);
        $('#' + id_element_old).popover('hide');
        $('#' + id_element_new).popover('show');

    },


    // chưa viết xong
    instruct_js: function (config_instruct_popover) {
        for (var i = 0; i < config_instruct_popover.length; i++) {
            var mono_step = config_instruct_popover[i];
            var id_mono = mono_step[0];
            var title = mono_step[1];
            var content_html = mono_step[2];

            $("#" + id_mono).popover({
                toggle: 'popover',
                placement: 'auto',
                title: 'Instruction',
                html: true,
                content: '',
            });

            $("#" + id_mono).on('shown.bs.popover', function () {
                var id_popover_shown = $("#" + id_mono).attr('aria-describedby');
                $('#' + id_popover_shown + ':last-child').html('<div class="arrow" style="left: 92px;"></div>'+
                    '<h3 class="popover-header" id=" + id_popover_shown + header___pop"  >' + title + '</h3>' +
                    '<div class="popover-body">' + content_html + '</div>' +
                    '<div class="popover-footer">' +
                    '<button class="btn btn-sm btn-success">Prev</button>' +
                    '<button class="btn btn-sm btn-success">Skip</button>' +
                    '<button class="btn btn-sm btn-success">Next</button>' +
                    '</div>');
            });

        }
        $("#" + config_instruct_popover[0][0]).click();
    },

    now_index: -1, // chưa bắt đầu
    type_instruct: 'js', // js hoặc html để sử dụng roadmap phù hợp
    roadmap_hmtl: [],
    roadmap_js: [],
    _setup_instruct: function () {
        if ($('#content_instruct_all').length === 0){
            $('body').append('<div id="content_instruct_all" style="display: none !important;"></div>');
        }
    }
};

$( document ).ready(function() {
    // var config_instruct = [
    //     ['id'  ,'a'], // id của thẻ vẽ khung bao quanh
    //     ['padding' , 5], // Thuộc tính khi bấm vào thẻ body thì ẩn Pop over
    //     ['borderColor' ,'rgba(0,0,0,.75)'],
    //     ['borderWidth' ,2],
    // ];

    var config_instruct_popover = ['a','b','c','d','a','c','b'];

    instruction_zf.instruct_html(config_instruct_popover);

    // TRY NEW



    // instruction_zf.draw(config_instruct);

});

