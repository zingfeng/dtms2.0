<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <style>
        p.menu-option {
            padding: 5px;
            width: 150px;
            margin: 0;
            border-bottom: 1px solid grey;
            user-select: none;
        }

        p.menu-option:hover {
            cursor: pointer;
            background-color: #bfbfbf;
        }

        div#menu_context_add {
            border: 1px solid grey;
            position: absolute;
            z-index: 100;
            background-color: #fffff5;
            box-shadow: 2px 2px #cccbcb;
            border-bottom: none;
        }

        .popover-body {
            width: 100%;
            min-width: 200px;
            min-height: 150px;
            max-height: 300px;
            overflow: auto;
            background-color: #ffeaaa;
            color: black;
            margin: 0px;
            padding: 5px;
            margin-right: 10px;
            border-radius: 5px;
            font-size: 1rem !important;
        }

        .kidding {
            cursor: pointer;
            user-select: none;
        }

        .popover-header {
            background-color: #FFC107 !important;
        }

        .popover {
            box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.3);

        }

    </style>

    <style type="text/css">
        #abc{
            color: red;
        }
    </style>
</head>
<body>
<h1 id="abc">ppopop</h1>

<div>
    <button onclick="addCSS()"> Add</button>
</div>
<script>
    function addCSS() {

    }
</script>

<p id="mom_element_target" oncontextmenu="return false;" style="padding: 8px;">
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
    standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
    type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
    Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of
    Lorem Ipsum.
    Lorem Ipsum is simply dummy text <span style="font-weight: bold">of the printing and typesetting</span> industry.
    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
    of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap
    into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of
    Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
    PageMaker including versions of Lorem Ipsum.
    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
    standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
    type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
    Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of
    Lorem Ipsum.
</p>
<div id="menu_context_add" class="menu" style="display: none; ">
    <p id="optionHighligh" class="menu-option" onclick="ClickHighligh()" id_now="">Highligh</p>
    <p id="optionNote" class="menu-option">Note</p>
    <p id="optionClear" class="menu-option" id_now="" onclick="ClearHighlight()">Clear</p>
    <p class="menu-option" onclick="ClearAllHighlight()">Clear All</p>
</div>
<div id="popover_content" style="display: none"></div>
<script>

    //

    var lib_hightligh_and_note_zf = {
        HideClear: function() {
            $('#optionClear').css('display', 'none');
        },

        ShowClear: function() {
            $('#optionClear').css('display', 'block');
        }

        ShowHighligh: function() {
            $('#optionHighligh').css('display', 'block');
        }

        HideHighligh: function() {
            $('#optionHighligh').css('display', 'none');
        }

        ShowNote: function() {
            $('#optionNote').css('display', 'block');
        }

        HideNote: function() {
            $('#optionNote').css('display', 'none');
        }

        ShowClear: function() {
            $('#optionClear').css('display', 'block');
        }




    };


    // Event Click Menu
    function ClickHighligh() {
        var id_now = $('#optionHighligh').attr('id_now');
        console.log("id_now");
        console.log(id_now);

        $('#' + id_now).css('background-color', 'yellow');
        ExitMenu();
    }

    document.getElementById('optionNote').addEventListener('click', (event) => {
        event.stopPropagation();
        event.preventDefault();
        var id_now = $('#optionHighligh').attr('id_now');
        console.log("id_now");
        console.log(id_now);
        $('#' + id_now).css('background-color', 'yellow');
        ExitMenu();
        console.log("Đến event pop over show");
        $('#' + id_now).popover('show');
        return false;
    });

    function ClearHighlight() {
        var id_span = document.getElementById('optionClear').getAttribute('id_now');
        $('#' + id_span).popover('hide');
        var id_span_html = document.getElementById(id_span).outerHTML;
        var contetn_inner = document.getElementById(id_span).innerHTML;
        // replace
        var contetn_inner_all = document.getElementById('mom_element_target').innerHTML;
        contetn_inner_all = contetn_inner_all.replace(id_span_html, contetn_inner);
        document.getElementById('mom_element_target').innerHTML = contetn_inner_all;
        ExitMenu();
        // After replace innerHTML - Lack all event listener
        rebindEventListener();
    }

    function ClearHighlightById(id_span) {
        var id_span_html = document.getElementById(id_span).outerHTML;
        var contetn_inner = document.getElementById(id_span).innerHTML;
        // replace
        var contetn_inner_all = document.getElementById('mom_element_target').innerHTML;
        contetn_inner_all = contetn_inner_all.replace(id_span_html, contetn_inner);
        document.getElementById('mom_element_target').innerHTML = contetn_inner_all;
        // After replace innerHTML - Lack all event listener
        rebindEventListener();
    }

    function ClearAllHighlight() {
        var contetn_inner_all = document.getElementById('mom_element_target').innerHTML;
        $(".kidding").each(function () {
            var id_span = $(this).attr('id');
            $('#' + id_span).popover('hide');
            var id_span_html = document.getElementById(id_span).outerHTML;
            var contetn_inner = document.getElementById(id_span).innerHTML;
            contetn_inner_all = contetn_inner_all.replace(id_span_html, contetn_inner);
        });
        document.getElementById('mom_element_target').innerHTML = contetn_inner_all;
        ExitMenu();
        rebindEventListener();
    }

    // Technical
    function getSelectionText() {
        var text = "";
        if (window.getSelection) {
            text = window.getSelection().toString();
        } else if (document.selection && document.selection.type != "Control") {
            text = document.selection.createRange().text;
        }
        return text;
    }

    function getHTMLOfSelection() {
        var range;
        if (document.selection && document.selection.createRange) {
            range = document.selection.createRange();
            return range.htmlText;
        } else if (window.getSelection) {
            var selection = window.getSelection();
            if (selection.rangeCount > 0) {
                range = selection.getRangeAt(0);
                var clonedSelection = range.cloneContents();
                var div = document.createElement('div');
                div.appendChild(clonedSelection);
                return div.innerHTML;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    function OpenMenu(left, top) {
        $('#menu_context_add').css('display', 'block');
        $('#menu_context_add').css('position', 'absolute');
        $('#menu_context_add').css('left', left);
        $('#menu_context_add').css('top', top);
        document.getElementById('mom_element_target').addEventListener('click', ExitMenu_And_Re_Formal);
    }

    function ExitMenu_And_Re_Formal() {
        ExitMenu();
        // formal lại all các thẻ span class = kidding mà chưa có background color
        clear_highlight_white_not_yellow();
    }

    function ExitMenu() {
        $('#menu_context_add').css('display', 'none');
        // unhiglight_white();
        document.getElementById('mom_element_target').removeEventListener('click', ExitMenu_And_Re_Formal);
        clearSelection();
    }

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    function rebindEventListener() {
        $(".kidding").each(function () {
            var id_kidding = $(this).attr('id');
            Maskup_Right_Click_for_highlight(id_kidding);
        });
    }

    function disableEventListener() {
        $(".kidding").each(function () {
            var id_kidding = $(this).attr('id');
            var old_element = document.getElementById(id_kidding);
            var new_element = old_element.cloneNode(true);
            old_element.parentNode.replaceChild(new_element, old_element);
        });
    }

    function HideAllPopover() {
        $(".kidding").each(function () {
            var id_kidding = $(this).attr('id');
            $('#' + id_kidding).popover('hide');
        });
    }

    function HideAllPopoverExcept(id_showing) {
        $(".kidding").each(function () {
            var id_kidding = $(this).attr('id');
            if (id_kidding !== id_showing){
                $('#' + id_kidding).popover('hide');
            }

        });
    }


    function countNumberClassKidding(str_input) {
        console.log("count count");

        const regex = /(.{1}class=\"kidding\")/gm;
        const str = str_input;
        let m;

        var number_class_kidding = 0;
        while ((m = regex.exec(str)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches
            if (m.index === regex.lastIndex) {
                regex.lastIndex++;
            }

            // The result can be accessed through the `m`-variable.
            m.forEach((match, groupIndex) => {
                console.log(`Found match, group ${groupIndex}: ${match}`);
                number_class_kidding++;
            });
        }
        console.log("m");
        console.log(m);
        return number_class_kidding;

    }

    /**
     *
     */
    function clearSelection()
    {
        if (window.getSelection) {window.getSelection().removeAllRanges();}
        else if (document.selection) {document.selection.empty();}
    }


    // *** Main action ***
    function Maskup_Right_Click() {
        var new__ = document.getElementById('mom_element_target');
        new__.addEventListener('contextmenu', function (e) {
            console.log("context new ==============");

            e.preventDefault();
            HideClear();

            var userSelection = window.getSelection().getRangeAt(0);
            var text_selected = getSelectionText();
            console.log("text_selected");
            console.log(text_selected);

            if (text_selected.length === 0) {
                // Có 2 trường hợp -
                // ko chọn gì và ngoài span kidding: just clear all - (nếu có)
                // trong span kidding - hiển thị clear

                console.log('select 0');
                var left = e.pageX;
                var top = e.pageY;
                OpenMenu(left, top);
                HideNote();
                HideHighligh();
                return false;
            } else {
                console.log('select 1 - class kidding: 0 - 0.5 - 1'); // include span class = kidding: 0; 1; 0.5;
                // Phân loại dựa trên có chứa thẻ <span .. > hoặc </span> hay không
                // regex
                // - bắt số lượng class="kidding -> Nếu
                // - bắt số lượng </span>
                var html_selected2 = getHTMLOfSelection();
                var number_class_kidding = countNumberClassKidding(html_selected2);

                console.log("number_class_kidding");
                console.log(number_class_kidding);

                if (number_class_kidding > 0) {
                    // bỏ select và chỉ hiển thị Clear All

                    var left = e.pageX;
                    var top = e.pageY;
                    OpenMenu(left, top);
                    HideHighligh();
                    HideNote();
                    HideClear();
                    return false;
                } else {
                    // Select không chứa class kidding nhưng vẫn có thể lỗi DOM

                    var new_id = makeid(8);
                    var newNode = document.createElement("span"); // div
                    newNode.setAttribute("style", "display: inline;");
                    newNode.setAttribute('id', new_id);
                    newNode.setAttribute("class", "kidding");

                    try {
                        userSelection.surroundContents(newNode);
                        // Đang chọn nhiều thẻ hmtl thì sẽ báo lỗi
                        // Trường hợp này không lỗi


                        $("#popover_content").append('<div id="' + new_id + 'content" ></div>');
                        $('#optionHighligh').attr('id_now', new_id);

                        Maskup_Right_Click_for_highlight(new_id);

                        $("#" + new_id).popover({
                            toggle: 'popover',
                            placement: 'auto',
                            title: 'Note',
                            html: true,
                            content: function () {
                                return $('#' + new_id + 'content').html();
                            },
                        });

                        $("#" + new_id).on('show.bs.popover', function () {
                            // do something…
                            console.log("show.bs.popover");
                            HideAllPopoverExcept(new_id);
                            // Bắt đúng đối tượng popover body để

                        });

                        $("#" + new_id).on('shown.bs.popover', function () {
                            console.log("shown.bs.popover");
                            if ($('#' + new_id + 'content').length) {
                                var content_exist = $('#' + new_id + 'content').html();
                            } else {
                                var content_exist = '';
                            }
                            var id_popover_shown = $("#" + new_id).attr('aria-describedby');
                            console.log($('#' + id_popover_shown + ':last-child')); // return a collection ! Damn it -  my 3 hours

                            $('#' + id_popover_shown + ':last-child').html('<div class="arrow" style="left: 92px;"></div><h3 class="popover-header" id="' + id_popover_shown + 'header___pop"  >Note</h3><div class="popover-body" id="' + id_popover_shown + 'body___pop" contenteditable="true">' + content_exist + '</div>');

                            $(".popover-body").each(function () {
                                $(this).attr('contenteditable', 'true');
                            });

                            $('#' + id_popover_shown + 'body___pop').focus();

                            document.getElementById(id_popover_shown + 'header___pop').addEventListener('click', function (e) {
                                e.stopPropagation();
                                return false;
                            }, false);
                            document.getElementById(id_popover_shown + 'body___pop').addEventListener('click', function (e) {
                                e.stopPropagation();
                                return false;
                            }, false);
                        });

                        $("#" + new_id).on('hide.bs.popover', function () {
                            console.log("hide.bs.popover");
                            var id_popover_shown = $("#" + new_id).attr('aria-describedby');
                            var content_new = $('#' + id_popover_shown + 'body___pop').html();
                            $('#' + new_id + 'content').html(content_new);
                        })

                        console.log("1111");

                        ShowHighligh();
                        ShowNote();
                        HideClear();
                        var left = e.pageX;
                        var top = e.pageY;
                        console.log("2222");

                        OpenMenu(left, top);
                        return false;

                    } catch (err) {
                        // TH này có lỗi - bỏ select và mở Menu
                        // var html_selected = getHTMLOfSelection();
                        // console.log("html_selected");
                        // console.log(html_selected);
                        // disableEventListener();
                        clearSelection();
                        HideNote();
                        HideHighligh();
                        HideClear();
                        var left = e.pageX;
                        var top = e.pageY;
                        OpenMenu(left, top);
                        return false;
                    }
                }
            }


        }, false);
    }

    function Maskup_Right_Click_for_highlight(id_kidding) {
        console.log("MASKUP right click - id_kidding");
        console.log(id_kidding);

        var kidding_new = document.getElementById(id_kidding);
        kidding_new.addEventListener('contextmenu', function (e) {
            e.stopPropagation();
            console.log("context kidding ==============");
            e.preventDefault();

            var text_selected = getSelectionText();
            console.log("text_selected");
            console.log(text_selected);

            if (text_selected.length === 0) {
                var left = e.pageX;
                var top = e.pageY;

                $('#optionClear').attr('id_now', id_kidding);
                $('#optionHighligh').attr('id_now', id_kidding);

                console.log("optionClear");
                console.log(id_kidding);

                OpenMenu(left, top);
                console.log("Menu kidding");
                ShowNote();
                ShowClear();
                HideHighligh();
                return false;
            } else {
                var left = e.pageX;
                var top = e.pageY;
                $('#optionClear').attr('id_now', id_kidding);

                OpenMenu(left, top);
                HideHighligh();
                HideNote();
                HideClear();
                return false;

            }
        }, false);
    }

    // Hàm này dùng khi người dùng bấm chuột phải - đã highlight white nhưng thoát ra ngoài
    function clear_highlight_white_not_yellow() {
        $(".kidding").each(function () {
            var backcolor = $(this).css('background-color');
            var id_kidding = $(this).attr('id');
            if ((backcolor !== 'yellow') || (backcolor !== 'rgb(255, 255, 0)')) {
                console.log("backcolor");
                console.log(backcolor);
                ClearHighlightById(id_kidding);
            }
        });
    }

    // Background
    $('html').on('click', function (e) {
        if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover.in')) {
            $('[data-original-title]').popover('hide');
            // formal lại all các thẻ span class = kidding mà chưa có background color
            // clear_highlight_white_not_yellow();

        }
    });
    Maskup_Right_Click();
</script>
</body>
</html>