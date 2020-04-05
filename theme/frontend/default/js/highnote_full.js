/**
 * Require Bootstrap (cần pop over) + (jquery 3.3.7)
 * Write by Dat Daybreak - 2019 Jun 20
 * @type {{makeid: (function(*): (string|string)), ShowClear: highnote_zf.ShowClear, Maskup_Right_Click: highnote_zf.Maskup_Right_Click, getHTMLOfSelection: highnote_zf.getHTMLOfSelection, Maskup_Right_Click_for_highlight: highnote_zf.Maskup_Right_Click_for_highlight, mom_element_target: string, ShowNote: highnote_zf.ShowNote, ClearHighlightById: highnote_zf.ClearHighlightById, clear_text: string, HideClear: highnote_zf.HideClear, ExitMenu_And_Re_Formal: highnote_zf.ExitMenu_And_Re_Formal, rebindEventListener: highnote_zf.rebindEventListener, clearSelection: highnote_zf.clearSelection, countNumberClassKidding: (function(*): number), disableEventListener: highnote_zf.disableEventListener, HideAllPopoverExcept: highnote_zf.HideAllPopoverExcept, HideHighligh: highnote_zf.HideHighligh, dissmiss_menu: boolean, ShowHighligh: highnote_zf.ShowHighligh, clear_highlight_white_not_highlight: highnote_zf.clear_highlight_white_not_highlight, start: highnote_zf.start, addCSS_to_head: highnote_zf.addCSS_to_head, OpenMenu: highnote_zf.OpenMenu, ExitMenu: highnote_zf.ExitMenu, clear_all_text: string, HideNote: highnote_zf.HideNote, dissmiss_popover: boolean, getSelectionText: (function(): string), highligh_text: string, ClearAllHighlight: highnote_zf.ClearAllHighlight, note_text: string, HideAllPopover: highnote_zf.HideAllPopover}}
 */
// Multi Instance in 1 page

var highnote_zf = {
    highligh_text: "Highlight",
    note_text: "Note",
    clear_text: "Clear",
    clear_all_text: "Clear All",
    mom_element_target: 'mom_element_target',
    list_mom_element_target: [],
    dissmiss_popover: true, // Bấm ra ngoài ẩn giao diện
    dissmiss_menu: true, // Bấm ra ngoài menu và ở trong thẻ mom_element_target thì mặc định sẽ ẩn menu
    // Nếu cần bấm vào thẻ body cũng ẩn menu thì set thuộc tính này bằng true

    start: function (config_highnote_zf) {
        // load config trước
        for (var i = 0; i < config_highnote_zf.length; i++) {
            var mono_config = config_highnote_zf[i];
            var name_config = mono_config[0];
            window['highnote_zf'][name_config] = mono_config[1];
        }

        // khởi động
        if (highnote_zf.dissmiss_popover === true) {
            $('html').on('click', function (e) {
                if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover.in')) {
                    $('[data-original-title]').popover('hide');
                }
            });
        }

        if (highnote_zf.dissmiss_menu === true) {
            document.getElementById(highnote_zf.mom_element_target).addEventListener('click', (event) => {
                event.stopPropagation();
                event.preventDefault();
                $('[data-original-title]').popover('hide');
                return false;
            });

            $('html').on('click', function (e) {
                if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover.in')) {
                    // $('[data-original-title]').popover('hide');
                    $('#highnote_zf_menu_context_add').css('display', 'none');
                    document.getElementById(highnote_zf.mom_element_target).removeEventListener('click', highnote_zf.ExitMenu_And_Re_Formal);
                }
            });
        }

        var html_menu = '<div id="highnote_zf_menu_context_add" class="highnote_zf_menu" style="display: none;">' +
            '<p id="highnote_zf_optionHighligh" class="highnote_zf_menu-option" id_now="">' + highnote_zf.highligh_text + '</p>' +
            '<p id="highnote_zf_optionNote" class="highnote_zf_menu-option">' + highnote_zf.note_text + '</p>' +
            '<p id="highnote_zf_optionClear" class="highnote_zf_menu-option" id_now="">' + highnote_zf.clear_text + '</p>' +
            '<p id="highnote_zf_optionClearAll" class="highnote_zf_menu-option">' + highnote_zf.clear_all_text + '</p>' +
            '</div>';
        if (!$('#highnote_zf_menu_context_add').length)         // use this if you are using id to check
        {
            $("body").append(html_menu);
        }


        var popover_content = '<div id="highnote_zf_popover_content" style="display: none"></div>';

        if (!$('#highnote_zf_popover_content').length)         // use this if you are using id to check
        {
            $("body").append(popover_content);
        }

        var style_more = 'p.highnote_zf_menu-option {\n' +
            'padding: 5px;\n' +
            'width: 150px;\n' +
            'margin: 0;\n' +
            'border-bottom: 1px solid grey;\n' +
            'user-select: none;\n' +
            '  }\n' +
            '\n' +
            '  p.highnote_zf_menu-option:hover {\n' +
            'cursor: pointer;\n' +
            'background-color: #bfbfbf;\n' +
            '  }\n' +
            '\n' +
            '  div#highnote_zf_menu_context_add {\n' +
            'border: 1px solid grey;\n' +
            'position: absolute;\n' +
            'z-index: 100;\n' +
            'background-color: #fffff5;\n' +
            'box-shadow: 2px 2px #cccbcb;\n' +
            'border-bottom: none;\n' +
            '  }\n' +
            '\n' +
            '  .popover-body {\n' +
            'width: 100%;\n' +
            'min-width: 200px;\n' +
            'min-height: 150px;\n' +
            'max-height: 300px;\n' +
            'overflow: auto;\n' +
            'background-color: #ffeaaa;\n' +
            'color: black;\n' +
            'margin: 0px;\n' +
            'padding: 5px;\n' +
            'margin-right: 10px;\n' +
            'border-radius: 5px;\n' +
            'font-size: 1rem !important;\n' +
            '  }\n' +
            '\n' +
            '  .kidding_highnote_zf {\n' +
            'cursor: pointer;\n' +
            'user-select: none;\n' +
            '  }\n' +
            '\n' +
            '  .popover-header {\n' +
            'background-color: #FFC107 !important;\n' +
            '  }\n' +
            '\n' +
            '  .popover {\n' +
            'box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.3);\n' +
            '  }\n' +
            '  .highnote_zf_hightlighted{\n' +
            'background-color: yellow;\n' +
            '  }';
        highnote_zf.addCSS_to_head(style_more);

        highnote_zf.list_mom_element_target.push(highnote_zf.mom_element_target); // Quản lý theo list cho multi instance
        // bind event
        document.getElementById('highnote_zf_optionHighligh').addEventListener('click', (event) => {
            event.stopPropagation();
            event.preventDefault();
            var id_now = $('#highnote_zf_optionHighligh').attr('id_now');
            $('#' + id_now).addClass('highnote_zf_hightlighted');
            highnote_zf.ExitMenu();
            $('#' + id_now).popover('show');
            return false;
        });

        document.getElementById('highnote_zf_optionNote').addEventListener('click', (event) => {
            event.stopPropagation();
            event.preventDefault();



            var id_now = $('#highnote_zf_optionHighligh').attr('id_now');
            $('#' + id_now).addClass('highnote_zf_hightlighted');
            highnote_zf.ExitMenu();
            $('#' + id_now).popover('show');
            return false;
        });

        document.getElementById('highnote_zf_optionClear').addEventListener('click', (event) => {
            event.stopPropagation();
            event.preventDefault();
            //=========
            var id_span = document.getElementById('highnote_zf_optionClear').getAttribute('id_now');
            console.log("id_span");
            console.log(id_span);

            // $('#' + id_span).popover('hide');
            highnote_zf.HideAllPopover();
            var id_span_html = document.getElementById(id_span).outerHTML;
            var mom_element_target_independent = document.getElementById(id_span).getAttribute('mom_element_target');
            console.log("mom_element_target_independent");
            console.log(mom_element_target_independent);


            var content_inner = document.getElementById(id_span).innerHTML;
            // replace
            var content_inner_all = document.getElementById(mom_element_target_independent).innerHTML;
            content_inner_all = content_inner_all.replace(id_span_html, content_inner);
            document.getElementById(mom_element_target_independent).innerHTML = content_inner_all;
            highnote_zf.ExitMenu();



            // After replace innerHTML - Lack all event listener
            highnote_zf.rebindEventListener();

            // ===========

            var id_now = $('#highnote_zf_optionHighligh').attr('id_now');
            $('#' + id_now).addClass('highnote_zf_hightlighted');
            highnote_zf.ExitMenu();
            $('#' + id_now).popover('show');
            return false;
        });

        // document.getElementById('').addEventListener('click', highnote_zf.ClearAllHighlight());

        document.getElementById('highnote_zf_optionClearAll').addEventListener('click', (event) => {
            event.stopPropagation();
            event.preventDefault();

            //=========


            $(".kidding_highnote_zf").each(function () {
                var id_span = $(this).attr('id');
                $('#' + id_span).popover('hide');
                var mom_element_target_independent = $(this).attr('mom_element_target');
                var content_inner_all = document.getElementById(mom_element_target_independent).innerHTML;

                var id_span_html = document.getElementById(id_span).outerHTML;
                var content_inner = document.getElementById(id_span).innerHTML;
                content_inner_all = content_inner_all.replace(id_span_html, content_inner);
                document.getElementById(mom_element_target_independent).innerHTML = content_inner_all;
            });
            highnote_zf.ExitMenu();
            highnote_zf.rebindEventListener();


            // ===========
            return false;
        });

        highnote_zf.Maskup_Right_Click(highnote_zf.mom_element_target);


    },

    HideClear: function () {
        $('#highnote_zf_optionClear').css('display', 'none');
    },

    ShowClear: function () {
        $('#highnote_zf_optionClear').css('display', 'block');
    },

    ShowHighligh: function () {
        $('#highnote_zf_optionHighligh').css('display', 'block');
    },

    HideHighligh: function () {
        $('#highnote_zf_optionHighligh').css('display', 'none');
    },

    ShowNote: function () {
        $('#highnote_zf_optionNote').css('display', 'block');
    },

    HideNote: function () {
        $('#highnote_zf_optionNote').css('display', 'none');
    },

    addCSS_to_head: function (css) {
        // var css = 'h1 { background: red; }',
        head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');
        head.appendChild(style);
        style.type = 'text/css';
        if (style.styleSheet) {
            // This is required for IE8 and below.
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }
    },

    ExitMenu: function () {
        $('#highnote_zf_menu_context_add').css('display', 'none');
        for (var k = 0; k < highnote_zf.list_mom_element_target.length; k++) {
            var mom_element_target_mono = highnote_zf.list_mom_element_target[k];
            document.getElementById(mom_element_target_mono).removeEventListener('click', highnote_zf.ExitMenu_And_Re_Formal);
        }
        highnote_zf.clearSelection();
    },


    // ==============

    ClearHighlightById: function (id_span) {
        var id_span_html = document.getElementById(id_span).outerHTML;
        var content_inner = document.getElementById(id_span).innerHTML;
        // replace

        var mom_element_target_independent =  document.getElementById(id_span).getAttribute('mom_element_target');

        var content_inner_all = document.getElementById(mom_element_target_independent).innerHTML;
        content_inner_all = content_inner_all.replace(id_span_html, content_inner);
        document.getElementById(mom_element_target_independent).innerHTML = content_inner_all;
        // After replace innerHTML - Lack all event listener
        highnote_zf.rebindEventListener();
    },

    // Technical

    getSelectionText: function () {
        var text = "";
        if (window.getSelection) {
            text = window.getSelection().toString();
        } else if (document.selection && document.selection.type != "Control") {
            text = document.selection.createRange().text;
        }
        return text;
    },

    getHTMLOfSelection: function () {
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
    },

    OpenMenu: function (left, top) {
        $('#highnote_zf_menu_context_add').css('display', 'block');
        $('#highnote_zf_menu_context_add').css('position', 'absolute');
        $('#highnote_zf_menu_context_add').css('left', left);
        $('#highnote_zf_menu_context_add').css('top', top);
        // list mom ??
        for (var k = 0; k < highnote_zf.list_mom_element_target.length; k++) {
            var mom_element_target_mono = highnote_zf.list_mom_element_target[k];
            document.getElementById(mom_element_target_mono).addEventListener('click', highnote_zf.ExitMenu_And_Re_Formal);
        }
    },

    ExitMenu_And_Re_Formal: function () {
        highnote_zf.ExitMenu();
        // formal lại all các thẻ span class = kidding mà chưa có background color
        highnote_zf.clear_highlight_white_not_highlight();
    },

    makeid: function (length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    },

    rebindEventListener: function () {
        $(".kidding_highnote_zf").each(function () {
            var id_kidding = $(this).attr('id');
            highnote_zf.Maskup_Right_Click_for_highlight(id_kidding);
        });
    },

    disableEventListener: function () {
        $(".kidding_highnote_zf").each(function () {
            var id_kidding = $(this).attr('id');
            var old_element = document.getElementById(id_kidding);
            var new_element = old_element.cloneNode(true);
            old_element.parentNode.replaceChild(new_element, old_element);
        });
    },

    HideAllPopover: function () {
        $(".kidding_highnote_zf").each(function () {
            var id_kidding = $(this).attr('id');
            $('#' + id_kidding).popover('hide');
        });
    },

    HideAllPopoverExcept: function (id_showing) {
        $(".kidding_highnote_zf").each(function () {
            var id_kidding = $(this).attr('id');
            if (id_kidding !== id_showing) {
                $('#' + id_kidding).popover('hide');
            }

        });
    },

    countNumberClassKidding: function (str_input) {
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

    },

    clearSelection: function () {
        if (window.getSelection) {
            window.getSelection().removeAllRanges();
        } else if (document.selection) {
            document.selection.empty();
        }
    },

    // *** Main action ***
    Maskup_Right_Click: function (mom_element_target) {

        var new__ = document.getElementById(mom_element_target);

        new__.addEventListener('contextmenu', function (e) {
            console.log("context new ==============");

            e.preventDefault();
            highnote_zf.HideClear();

            var userSelection = window.getSelection().getRangeAt(0);
            var text_selected = highnote_zf.getSelectionText();
            console.log("text_selected");
            console.log(text_selected);

            if (text_selected.length === 0) {
                // Có 2 trường hợp -
                // ko chọn gì và ngoài span kidding: just clear all - (nếu có)
                // trong span kidding - hiển thị clear

                console.log('select 0');
                var left = e.pageX;
                var top = e.pageY;
                highnote_zf.OpenMenu(left, top);
                highnote_zf.HideNote();
                highnote_zf.HideHighligh();
                return false;
            } else {
                console.log('select 1 - class kidding: 0 - 0.5 - 1'); // include span class = kidding: 0; 1; 0.5;
                // Phân loại dựa trên có chứa thẻ <span .. > hoặc </span> hay không
                // regex
                // - bắt số lượng class="kidding -> Nếu
                // - bắt số lượng </span>
                var html_selected2 = highnote_zf.getHTMLOfSelection();
                var number_class_kidding = highnote_zf.countNumberClassKidding(html_selected2);

                console.log("number_class_kidding");
                console.log(number_class_kidding);

                if (number_class_kidding > 0) {
                    // bỏ select và chỉ hiển thị Clear All

                    var left = e.pageX;
                    var top = e.pageY;
                    highnote_zf.OpenMenu(left, top);
                    highnote_zf.HideHighligh();
                    highnote_zf.HideNote();
                    highnote_zf.HideClear();
                    return false;
                } else {
                    // Select không chứa class kidding nhưng vẫn có thể lỗi DOM

                    var new_id = highnote_zf.makeid(8);
                    var newNode = document.createElement("span"); // div
                    newNode.setAttribute("style", "display: inline;");
                    newNode.setAttribute('id', new_id);
                    newNode.setAttribute('mom_element_target', mom_element_target);
                    newNode.setAttribute("class", "kidding_highnote_zf");

                    try {
                        userSelection.surroundContents(newNode);
                        // Đang chọn nhiều thẻ hmtl thì sẽ báo lỗi
                        // Trường hợp này không lỗi


                        $("#highnote_zf_popover_content").append('<div id="' + new_id + 'content" ></div>');
                        $('#highnote_zf_optionHighligh').attr('id_now', new_id);

                        highnote_zf.Maskup_Right_Click_for_highlight(new_id);

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
                            highnote_zf.HideAllPopoverExcept(new_id);
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

                        highnote_zf.ShowHighligh();
                        highnote_zf.ShowNote();
                        highnote_zf.HideClear();
                        var left = e.pageX;
                        var top = e.pageY;
                        console.log("2222");

                        highnote_zf.OpenMenu(left, top);
                        return false;

                    } catch (err) {
                        // TH này có lỗi - bỏ select và mở Menu
                        // var html_selected = highnote_zf.getHTMLOfSelection();
                        // console.log("html_selected");
                        // console.log(html_selected);
                        // disableEventListener();
                        highnote_zf.clearSelection();
                        highnote_zf.HideNote();
                        highnote_zf.HideHighligh();
                        highnote_zf.HideClear();
                        var left = e.pageX;
                        var top = e.pageY;
                        highnote_zf.OpenMenu(left, top);
                        return false;
                    }
                }
            }


        }, false);
    },

    Maskup_Right_Click_for_highlight: function (id_kidding) {
        console.log("MASKUP right click - id_kidding");
        console.log(id_kidding);

        var kidding_new = document.getElementById(id_kidding);
        kidding_new.addEventListener('contextmenu', function (e) {
            e.stopPropagation();
            console.log("context kidding ==============");
            e.preventDefault();

            var text_selected = highnote_zf.getSelectionText();
            console.log("text_selected");
            console.log(text_selected);

            if (text_selected.length === 0) {
                var left = e.pageX;
                var top = e.pageY;

                $('#highnote_zf_optionClear').attr('id_now', id_kidding);
                $('#highnote_zf_optionHighligh').attr('id_now', id_kidding);

                console.log("optionClear");
                console.log(id_kidding);

                highnote_zf.OpenMenu(left, top);
                console.log("Menu kidding");
                highnote_zf.ShowNote();
                highnote_zf.ShowClear();
                highnote_zf.HideHighligh();
                return false;
            } else {
                var left = e.pageX;
                var top = e.pageY;
                $('#highnote_zf_optionClear').attr('id_now', id_kidding);

                highnote_zf.OpenMenu(left, top);
                highnote_zf.HideHighligh();
                highnote_zf.HideNote();
                highnote_zf.HideClear();
                return false;

            }
        }, false);
    },

    // Hàm này dùng khi người dùng bấm chuột phải - đã highlight white nhưng thoát ra ngoài
    clear_highlight_white_not_highlight: function () {
        $(".kidding_highnote_zf").each(function () {
            var id_kidding = $(this).attr('id');
            if (!$("#" + id_kidding).hasClass("highnote_zf_hightlighted")) {
                highnote_zf.ClearHighlightById(id_kidding);
            }
        });
    },

};