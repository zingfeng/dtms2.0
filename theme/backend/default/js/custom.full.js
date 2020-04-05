/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 var URL = window.location.href.split('?')[0],
 $BODY = $('body'),
 $MENU_TOGGLE = $('#menu_toggle'),
 $SIDEBAR_MENU = $('#sidebar-menu'),
 $SIDEBAR_FOOTER = $('.sidebar-footer'),
 $LEFT_COL = $('.left_col'),
 $RIGHT_COL = $('.right_col'),
 $NAV_MENU = $('.nav_menu'),
 $FOOTER = $('footer');

// Sidebar
$(document).ready(function() {
	// TODO: This is some kind of easy fix, maybe we can improve this
	var setContentHeight = function () {
		// reset height
		$RIGHT_COL.css('min-height', $(window).height());

		var bodyHeight = $BODY.height(),
		leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
		contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

		// normalize content
		contentHeight -= $NAV_MENU.height() + $FOOTER.height();

		$RIGHT_COL.css('min-height', contentHeight);
	};

	$SIDEBAR_MENU.find('a').on('click', function(ev) {
		var $li = $(this).parent();

		if ($li.is('.active')) {
			$li.removeClass('active');
			$('ul:first', $li).slideUp(function() {
				setContentHeight();
			});
		} else {
			// prevent closing menu if we are on child menu
			if (!$li.parent().is('.child_menu')) {
				$SIDEBAR_MENU.find('li').removeClass('active');
				$SIDEBAR_MENU.find('li ul').slideUp();
			}
			
			$li.addClass('active');

			$('ul:first', $li).slideDown(function() {
				setContentHeight();
			});
		}
	});

	// toggle small or large menu
	$MENU_TOGGLE.on('click', function() {
		if ($BODY.hasClass('nav-md')) {
			$BODY.removeClass('nav-md').addClass('nav-sm');
			$LEFT_COL.removeClass('scroll-view').removeAttr('style');

			if ($SIDEBAR_MENU.find('li').hasClass('active')) {
				$SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
			}
		} else {
			$BODY.removeClass('nav-sm').addClass('nav-md');

			if ($SIDEBAR_MENU.find('li').hasClass('active-sm')) {
				$SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
			}
		}

		setContentHeight();
	});

	// check active menu
	$SIDEBAR_MENU.find('a[href="' + URL + '"]').parent('li').addClass('current-page');

	$SIDEBAR_MENU.find('a').filter(function () {
		return this.href == URL;
	}).parent('li').addClass('current-page').parents('ul').slideDown(function() {
		setContentHeight();
	}).parent().addClass('active');

	// recompute content when resizing
	$(window).smartresize(function(){  
		setContentHeight();
	});
});
// /Sidebar

// Panel toolbox
$(document).ready(function() {
	$('.collapse-link').on('click', function() {
		var $BOX_PANEL = $(this).closest('.x_panel'),
		$ICON = $(this).find('i'),
		$BOX_CONTENT = $BOX_PANEL.find('.x_content');
		
		// fix for some div with hardcoded fix class
		if ($BOX_PANEL.attr('style')) {
			$BOX_CONTENT.slideToggle(200, function(){
				$BOX_PANEL.removeAttr('style');
			});
		} else {
			$BOX_CONTENT.slideToggle(200); 
			$BOX_PANEL.css('height', 'auto');  
		}

		$ICON.toggleClass('fa-chevron-up fa-chevron-down');
	});
	$('.close-link').click(function () {
		var $BOX_PANEL = $(this).closest('.x_panel');

		$BOX_PANEL.remove();
	});

	if (typeof(filtering) != 'undefined') {
		$("#filter-data").find(".collapse-link").click();
	}

});
// Switchery
/* $(document).ready(function() {
	if ($(".js-switch")[0]) {
		var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
		elems.forEach(function (html) {
			var switchery = new Switchery(html, {
				color: '#26B99A'
			});
		});
	}
});*/
// /Switchery


// Accordion
$(document).ready(function() {
	$(".expand").on("click", function () {
		$(this).next().slideToggle(200);
		$expand = $(this).find(">:first-child");

		if ($expand.text() == "+") {
			$expand.text("-");
		} else {
			$expand.text("+");
		}
	});
});

/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
 (function($,sr){
	// debouncing function from John Hann
	// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
	var debounce = function (func, threshold, execAsap) {
		var timeout;

		return function debounced () {
			var obj = this, args = arguments;
			function delayed () {
				if (!execAsap)
					func.apply(obj, args);
				timeout = null; 
			}

			if (timeout)
				clearTimeout(timeout);
			else if (execAsap)
				func.apply(obj, args);

			timeout = setTimeout(delayed, threshold || 100); 
		};
	};

	// smartresize 
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

function lists_script(){
	//// SCROLL FIX OF BUTTON
	if ($(".scroll_action").length) {
		var top_nav_height = $(".top_nav").height();
		$( window ).scroll(function(x,y) {
			var top = $(this).scrollTop() - 10;
			if (top > top_nav_height ) {
				$(".scroll_action").css('top',top - top_nav_height)
			}
			else {
				$(".scroll_action").css('top',0);
			}
		});
	}
	/////////// CHECK ALL ///////////
	if ($("#checkbox_all").length) {
		$("#checkbox_list").checkboxes('range', true);
		$("#checkbox_all").on("click",'input[type="checkbox"]',function(e){
		    if ($(this).is(":checked")) {
		        $("#checkbox_list").checkboxes('check');
		    }
		    else {
		        $("#checkbox_list").checkboxes('uncheck');
		    }
		    countCheck();
		})
		$("#checkbox_list").on("click",'input[type="checkbox"]',function(e){
			setTimeout(function(){
				if ($("#checkbox_list").find('input[type="checkbox"]').length == $("#checkbox_list").find('input[type="checkbox"]:checked').length) {
		        $("#checkbox_all").find('input[type="checkbox"]').prop('checked',"checked");
			    }
			    else {
			        $("#checkbox_all").find('input[type="checkbox"]').prop('checked',false);
			    }
			    countCheck();
			},1);
			
		});
	}
	/////////////// TOOL TIP ///////
	$(function () {
	  	$('[data-toggle="tooltip"]').tooltip()
	});
	////////////// RESET FORM FILTER //////////
	$("#filter-data").find(".reset").bind("click",function(){
		$("#filter-data").find("input,select").val("");
	})
}
function countCheck() {
	$("#checkbox_list").find("tr.selected").removeClass("selected");
	$("#checkbox_list").find('input[type="checkbox"]:checked').closest("tr").addClass('selected');
}
// FILEMANAGER
function form_script(){
	// change theme select box
	if ($(".select2_single").length) {
		$(".select2_single").each(function(){
			var placeholder = $(this).attr("placeholder");
			$(this).select2({
				placeholder: placeholder,
				allowClear: true
			});
		})
		
	}
	// change theme select box
	if ($(".select2_multiple").length) {
		$(".select2_multiple").each(function(){
			var placeholder = $(this).attr("placeholder");
			$(this).select2({
				//maximumSelectionLength: 4,
				placeholder: placeholder,
				allowClear: true
			});
		})
		
	}
	
	// block enter keypress
	if ($(".ajax-submit-form").length){
		$(".ajax-submit-form").on('keyup keypress', function(e) {
			if (e.keyCode == 13) {
		        var src = e.srcElement || e.target;
		        if (src.tagName.toLowerCase() != "textarea") {
		            if (e.preventDefault) {
		                e.preventDefault();
		            } else {
		                e.returnValue = false;
		            }
		        }
		    }
		});
	}
	if ($(".filemanager_multi_media").length) {
		$(".filemanager_multi_media").each(function(index) {
			var callback = 'filemanager_multi_callback';
			$(this).on('click',function(){
				var type = 'image';
				var dom = $(this).attr('data-name');

				if (typeof($(this).attr('data-type')) != 'undefined') {
					type = $(this).attr('data-type');
				}
				window.open(SITE_URL + '/filemanager?type=' + type + '&dom='+ dom +'&langCode=en&callback=' + callback, 'kcfinder_textbox',
					'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
					'resizable=1, scrollbars=0, width=800, height=600'
					);  
			});
		});
	}
	if ($(".filemanager_media").length) {
		$(".filemanager_media").each(function(index) {
			var callback = 'filemanager_callback';
			$(this).on('click','.image_org',function(event){
				var type = 'image';
				var dom = $(this).attr('data-name');
				$(this).parent().attr("id",dom);
				if (typeof($(this).attr('data-type')) != 'undefined') {
					type = $(this).attr('data-type');
				}
				select = $(this).attr("data-selected") || '';
				if (select) {
					select = '&selected='+select;
				};
				switch (type) {
		            case 'file':
			            var callback = 'filemanager_callback';
			            break;
		            case 'image':
			            var callback = 'imgmanager_callback';
			            break;
		            case 'sound':
			            var callback = 'sound_callback';
			            break;
		        }
				window.open(SITE_URL + '/filemanager?type=' + type + '&dom='+ dom +'&langCode=en&callback=' + callback + select, 'kcfinder_textbox',
					'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
					'resizable=1, scrollbars=0, width=800, height=600'
					);  
				/* $.fancybox.open({
				    padding : 0,
				    href:SITE_URL + '/filemanager?type=' + type + '&dom='+ dom +'&langCode=en&callback=' + callback + select,
				    type: 'iframe',
				    iframe: {
						scrolling : 'no',
						preload   : false
					},
					scrolling: 'no',
        			fitToView: false
				});*/
			});
			$(".filemanager_media").find(".fa-remove").bind("click",function(){
				$(this).parent().find(".image_org").attr({"src" : THEME_URL + 'images/default_image.jpg',"data-selected": ""});
				$(this).parent().find("input").val("");
				$(this).parent().find('.file_name').text('');
				$(this).parent().find(".sound_preview").empty();
			})
		});
	}
	/** CKEDITOR **/
	if ($(".ckeditor_detail").length) {
		$(".ckeditor_detail").find("textarea").each(function(){
			if (typeof($(this).attr('name')) != 'undefined') {
				var params = {};
				if  (typeof($(this).attr('data-toolbar')) != 'undefined') {
					params.toolbar = $(this).attr('data-toolbar')
				}
				params.bodyClass = 'ckeditor_reset_style ';
				if (typeof($(this).attr('data-bodyClass')) != 'undefined') {
					params.bodyClass += $(this).attr('data-bodyClass');
				}
				CKEDITOR.replace( $(this).attr('name'),params);
			}
		})
		
	}
}
function filemanager_multi_callback(file,dom) {
	var count = $("#" + dom).find("li").length;
	var setCount = 0;
	if (count > 0) {
		for(i = 1; i <= count; i ++) {
			if (!$("#" + dom).find('li[data-count=' + i +']').length) {
				setCount = i;
				break;
			}
		}
	}
	if (setCount == 0) {
		setCount = count + 1;
	}

	var name = $("#" + dom).attr("data-name");
	$("#" + dom).append('<li data-count="'+ setCount +'"><input type="hidden" name="'+ name +'['+ setCount +'][url]" value="' + file + '"><image src="' + getimglink(file,'100x100') + '" /><textarea name="'+ name +'['+ setCount +'][caption]"></textarea><i class="fa fa-remove" onclick="delete_parent(this)"></i></li>');
}
function filemanager_multi_callback_popup(type,callback,dom) {
    window.open(SITE_URL + '/filemanager?type=' + type + '&dom='+dom+'&langCode=en&callback=' + callback, 'kcfinder_textbox',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
        ); 
}
function filemanager_callback(file,dom) {
	$("#" + dom).find(".file_name").html(file);
	$("#" + dom).find("input").val(file);
} 
function imgmanager_callback(file,dom) {
	$("#" + dom).find(".image_org").attr({"src" : getimglink(file),"data-selected" : file});
	$("#" + dom).find("input").val(file);
} 
function sound_callback(file,dom) {
    console.log(file,dom);
    var html = '<audio controls>\
                      <source src="' + UPLOAD_URL +'sound/' + file + '" type="audio/mpeg">\
                        Your browser does not support the audio element.\
                </audio><i class="fa fa-remove sound_delete"></i>';
    $("#" + dom).find(".sound_preview").html(html);
    $("#" + dom).find("input").val(file);
} 
function delete_parent(dom) {
	$(dom).parent().remove();
}
/**
* @params: path, size(100x100)
*/
function getimglink(path,size){
	if (typeof(size) == 'undefined') {
		var size = '100x100';
	}
	return UPLOAD_URL  + 'images/resize/' + size + '/' + path;
}
var progress_loading = (function () {
    var pleaseWaitDiv = $('<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"  aria-labelledby="mySmallModalLabel"> <div class="modal-dialog modal-sm"> <div class="modal-content"> <div class="modal-body"> Loading <div class="progress"> <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"> <span class="sr-only">100% Complete</span> </div> </div> </div> </div> </div> </div>');
    return {
        show: function() {
            pleaseWaitDiv.modal({backdrop: 'static'});
        },
        hide: function () {
            pleaseWaitDiv.modal('hide');
        },

    };
})();
//////////////////// FORM ACTION /////////////////
$(document).ready(function() {
	////////////////////////////////////////////////////////////////////////////////
	////////////////// ADD & UPDATE ITEM ///////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	if ($(".ajax-submit-form").length){
		$("#content_for_layout").on('submit','.ajax-submit-form',function(e) {

			
			self = $(this);
			var dataSerialize = self.serializeArray();
			dataSerialize.push({name: 'submit',value: 1});
			$.ajax({
				type: self.attr("method"),
				url: self.attr("action"),
				data: dataSerialize, // serializes the form's elements.
				dataType: 'json',
				beforeSend: function() {
					// $(".ajax-submit-button").attr('disabled', 'disabled').addClass("disabled");
					self.find(".has-error").removeClass("has-error");
					self.find(".validation_form").find(".error").remove();
					progress_loading.show();
				},
				success: function(data)
				{
					if (data.status == 'success') {
						if(data.redirect){
							window.location.href = data.redirect;
						}
						new PNotify({
							title: 'Success',
							text: data.message,
							type: 'success',
							styling: 'bootstrap3',
							delay: 2000,
							mouse_reset: false
						});
						$("#content_for_layout").html(data.html);
						// reaload form script
						form_script();
					}   
					else {
						if (typeof(data.valid_rule) != 'undefined') {
							var rule = data.valid_rule;
							for (var item in rule) {
								console.log(item,rule);
								$('.validation_' + item).addClass('has-error');
								$('.validation_' + item).find(".validation_form").append('<div class="error">' +rule[item]+ '</div>');
							};
						}
						new PNotify({
							title: 'Error',
							text: data.message,
							type: 'error',
							styling: 'bootstrap3',
							delay: 2000,
							mouse_reset: false,
						});
					}
					$(".ajax-submit-button").removeAttr('disabled').removeClass("disabled");
					progress_loading.hide();
			   	},
			   	error: function(e){
			   		show_notify_error();
			   		progress_loading.hide();
			   	}
			});
			e.preventDefault(); // avoid to execute the actual submit of the form.
		});
	}
	////////////////////////////////////////////////////////////////////////////////
	////////////////// DELETE ITEM LISTS ///////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	if ($(".ajax-delete-form").length) {
		$("#content_for_layout").on('submit','.ajax-delete-form',function(e) {
			var dataSerialize = $(this).serializeArray();
			dataSerialize.push({name: 'delete',value: 1});
			var url = $(this).attr("action");
			$.confirm({
		        title: 'Confirm!',
		        content: 'Bạn  có chắc muốn xóa không',
		        closeIcon: true,
		        keyboardEnabled: true,
		        backgroundDismiss: true,
		        cancelButton: "Cancel",
		        confirmButtonClass: 'btn-danger',
		        confirm: function(){
		            $.ajax({
						type: 'POST',
						url: url,
						data: dataSerialize, // serializes the form's elements.
						dataType: 'json',
						success: function(data)
						{
							if (data.status == 'success') {
								new PNotify({
									title: 'Success',
									text: data.message,
									type: 'success',
									styling: 'bootstrap3',
									delay: 2000,
									mouse_reset: false
								});
								$("#content_for_layout").html(data.html);
								lists_script();
							}
							else {
								new PNotify({
									title: 'Error',
									text: data.message,
									type: 'error',
									styling: 'bootstrap3',
									delay: 2000,
									mouse_reset: false
								});
							}
						},
						error: function(e){
					   		show_notify_error();
					   	}
					});
		        }
		    });
			e.preventDefault();
		})
	}
	////////////////////////////////////////////////////////////////////////////////
	////////////////// UPDATE STATUS CONTACT ///////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	if ($(".ajax-update-button").length) {
		$("#content_for_layout").on('click','.ajax-update-button',function(e) {
			var arrId = [];
			var url = $(this).attr("data-action");
			var arrCheckbox = $("#content_for_layout").find("#checkbox_list").find('input[type="checkbox"]:checked').each(function(){
				arrId.push($(this).val());
			});
			if (arrId.length < 1) {
				new PNotify({
					title: 'Error',
					text: 'Phải chọn ít nhất một dữ liệu cần thay đổi',
					type: 'error',
					styling: 'bootstrap3',
					delay: 2000,
					mouse_reset: false
				});
				return false;
			}
			$.ajax({
				type: 'POST',
				url: url,
				data: {cid: arrId,'submit': 1}, // serializes the form's elements.
				dataType: 'json',
				success: function(data)
				{
					if (data.status == 'success') {
						new PNotify({
							title: 'Success',
							text: data.message,
							type: 'success',
							styling: 'bootstrap3',
							delay: 2000,
							mouse_reset: false
						});
						$("#content_for_layout").html(data.html);
						lists_script();
					}
					else {
						new PNotify({
							title: 'Error',
							text: data.message,
							type: 'error',
							styling: 'bootstrap3',
							delay: 2000,
							mouse_reset: false
						});
					}
				},
				error: function(e){
			   		show_notify_error();
			   	}
			});
		})
	}
	////////////////////////////////////////////////////////////////////////////////
	////////////////// RESET & ORDER ITEM  /////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	if ($(".ajax-order-button").length) {
		$("#content_for_layout").on('submit','.ajax-order-form',function(e) {
			$("#checkbox_list").checkboxes('check');
			var dataSerialize = $(this).serializeArray();
			dataSerialize.push({name: 'order',value: 1});
			var url = $(this).attr("action");
            $.ajax({
				type: 'POST',
				url: url,
				data: dataSerialize, // serializes the form's elements.
				dataType: 'json',
				success: function(data)
				{
					if (data.status == 'success') {
						new PNotify({
							title: 'Success',
							text: data.message,
							type: 'success',
							styling: 'bootstrap3',
							delay: 2000,
							mouse_reset: false
						});
					}
					else {
						new PNotify({
							title: 'Error',
							text: data.message,
							type: 'error',
							styling: 'bootstrap3',
							delay: 2000,
							mouse_reset: false
						});
					}
					$("#checkbox_list").checkboxes('uncheck');
				},
				error: function(e){
			   		show_notify_error();
			   	}
			});
			e.preventDefault();
		})
	}
	// quick delete 
	if ($(".quick-delete").length) {
		$("#content_for_layout").on("click",".quick-delete",function () {
			var id = $(this).attr("data-id");
			var type = $(this).attr("data-type");
			var url = $(this).attr("data-url") || '';
			$.confirm({
		        title: 'Confirm!',
		        content: 'Bạn  có chắc muốn xóa không',
		        closeIcon: true,
		        keyboardEnabled: true,
		        backgroundDismiss: true,
		        cancelButton: "Cancel",
		        confirmButtonClass: 'btn-danger',
		        confirm: function(){
		            $.ajax({
						type: 'POST',
						url: url,
						data: {type: type, cid: id,'delete': 1}, // serializes the form's elements.
						dataType: 'json',
						success: function(data)
						{
							if (data.status == 'success') {
								new PNotify({
									title: 'Success',
									text: data.message,
									type: 'success',
									styling: 'bootstrap3',
									delay: 2000,
									mouse_reset: false
								});
								$("#content_for_layout").html(data.html);
								lists_script();
							}
							else {
								new PNotify({
									title: 'Error',
									text: data.message,
									type: 'error',
									styling: 'bootstrap3',
									delay: 2000,
									mouse_reset: false
								});
							}
						},
						error: function(e){
					   		show_notify_error();
					   	}
					});
		        }
		    });
			
		})
	}
});
// go back
function goBack() {
    window.history.back();
}
function redirect(url) {
	window.location.href = url;
}
///////////////////////////////////////// BLOCK MODULE //////////////////////////
function block_form_script() {
	$("#block_module").bind("change",function(){
        var module = $(this).val();
        var params = {module: module,block_id: block_id}
        if (row_module != module) {
            delete params.block_id;
        }
        if (module != 0) {
            $.ajax({
                type: 'GET',
                url: SITE_URL + '/block/option',
                data: params, // serializes the form's elements.
                dataType: 'json',
                success: function(data)
                {
                    if (data.status == 'success') {
                        $("#block_option").html(data.html);
                    }
                    else {
                        alert("Error");
                    }
                },
                error: function(e){
			   		show_notify_error();
			   	}
            });
        }
        else {
            $("#block_option").empty();
        }
    });
    $("#block_module").change();
}
/////////////////////////////////// BUILD TOP MODULE ///////////////////////////
function build_top_check_empty(){
    var length = $("#table_special").find("tbody").find("tr").length;
    if (length > 1) {
        $("#table_special").find(".tr-empty").hide();
    }
    else {
        $("#table_special").find(".tr-empty").show();
    }
}
function buildtop_script() {
    /// delete temp
    $("#table_special").on("click",".tmp-delete",function(){
        var dataId = $(this).attr("data-id");
        $("#table_special").find('tr[data-id='+ dataId +']').remove();
        build_top_check_empty();
    });
    $("#table_suggest").on("click",".tmp-add",function(){
        var dataId = $(this).attr("data-id");
        var dataTitle = $(this).attr("data-title");
        var dataCate = $(this).attr("data-cate");
        // check exist
        if ($("#table_special").find("tbody").find('tr[data-id='+ dataId +']').length) {
            new PNotify({
                title: 'Error',
                text: 'Đã tồn tại bản ghi này vui lòng chọn bản ghi khác',
                type: 'error',
                styling: 'bootstrap3',
                delay: 2000,
                mouse_reset: false
            });
        }
        else {
        	var html = '<tr data-id="' + dataId + '">\
                <td class="a-center "><input type="checkbox" value="' + dataId + '" class="inputSelect" name="cid[]"></td>\
                <td>' + dataTitle + '</td>';
                if (dataCate) {
            		html += '<td>' + dataCate + '</td>';
            	}

            html += '<td class="action last" align="center">\
                    <a class="tmp-delete" data-toggle="tooltip" data-placement="top" title="Delete" data-id="' + dataId + '" href="javascript:void(0)" rel="nofollow">\
                        <i class="fa fa-trash"></i>\
                    </a>\
                </td>\
            </tr>';
            $("#table_special").find("tbody").prepend(html);
            new PNotify({
                title: 'Success',
                text: 'Đã thêm vào bảng. Bạn nhớ lưu lại',
                type: 'success',
                styling: 'bootstrap3',
                delay: 2000,
                mouse_reset: false
            });
        }
        build_top_check_empty();
    });
    // delete all
    $("#build_top").on("click",".tmp-delete-all",function(){
        $("#table_special").find("tr.selected").remove();
        build_top_check_empty();
    });
    // filter button 
    $(".buildtop-suggest-button").bind("click",function(){
        var cate_id = $("#filter_cate").val();
        var keyword = $("#filter_keyword").val();
        var url = $(this).attr('data-url');
        var params = {cate_id: cate_id, keyword: keyword, dataType: 'html'}
        $.ajax({
            type: 'GET',
            url: url, 
            data: params, // serializes the form's elements.
            dataType: 'json',
            success: function(data)
            {
                if (data.status == 'success') {
                    $("#table_suggest").html(data.data);
                }
            },
            error: function(e){
		   		show_notify_error();
		   	}
        });
    });
    var origin = 'sortable';
	$( "#table_suggest").on('mouseover',"tbody tr",function(){
		$(this).draggable({
			connectToSortable: "#table_special tbody",
			helper: "clone",
			revert: "invalid",
			start: function () {
				origin = 'draggable';
			}
        });
    });
    $("#table_special").find("tbody").droppable({
         drop: function (event, ui) {
            var self = ui.draggable;
            var data = self.find(".tmp-add");
            var dataId = data.attr("data-id");
            var dataCate = data.attr("data-cate");
            var dataTitle = data.attr("data-title")
            if ($("#table_special").find("tbody").find('tr[data-id='+ dataId +']').length > 1) {
                ui.draggable.remove();
                return false;
            }
            if (origin === 'draggable') {
            	origin = 'sortable';
                var html =  '<td class="a-center "><input type="checkbox" value="' + dataId + '" class="inputSelect" name="cid[]"></td>\
                        <td>' + dataTitle + '</td>';
                        if (dataCate) {
                        	html += '<td>' + dataCate + '</td>';
                    	}
                html += '<td class="action last" align="center">\
                            <a class="tmp-delete" data-toggle="tooltip" data-placement="top" title="Delete" data-id="' + dataId + '" href="javascript:void(0)" rel="nofollow">\
                                <i class="fa fa-trash"></i>\
                            </a>\
                        </td>';
                 ui.draggable.html(html);
                 ui.draggable.unbind();
                 build_top_check_empty();
            }
            
         }
     }).sortable({
         revert: true
     }).disableSelection();
}
function buildtop_documents_script() {
    // change position url
    $("#buildtop_position").bind('change',function(){
        var position = $(this).val();
        return redirect(SITE_URL + '/news/buildtop/' + position);
    });
    
    // Click show more suggest news
    $("#table_suggest").on("click",".show_more",function(){
        var self = $(this);
        var page = parseInt(self.attr("data-page")) || 1;
        var cate_id = self.attr("data-cate");
        var keyword = self.attr("data-keyword");
        var params = {cate_id: cate_id, keyword: keyword,'dataType': 'json', page: page + 1}
        $.ajax({
            type: 'GET',
            url: SITE_URL + '/documents/suggest_news',
            data: params, // serializes the form's elements.
            dataType: 'json',
            success: function(data)
            {
                if (data.status == 'success') {
                    var html = '';
                    var rows = data.data.rows;
                    for (var item in rows) {
                        html += '<tr>\
                                    <td>' + rows[item].title + '</td>\
                                    <td>' + rows[item].original_cate + '</td>\
                                    <td class="action last" align="center">\
                                        <a class="tmp-add" data-toggle="tooltip" data-placement="top" title="Thêm" data-title="' + rows[item].title + '" data-cate="' + arrCate[rows[item].original_cate] + '" data-id="' + rows[item].news_id + '" href="javascript:void(0)" rel="nofollow">\
                                            <i class="fa fa-exchange" aria-hidden="true"></i>\
                                        </a>\
                                    </td>\
                                </tr>';
                    };
                    $("#table_suggest").find('tbody').append(html);
                    if (data.data.showMore == 1) {
                        self.attr({'data-cate': data.data.cate_id,'data-keyword': data.data.keyword,'data-page': data.data.page})
                    }
                    else {
                        self.remove();
                    }
                }
            },
            error: function(e){
		   		show_notify_error();
		   	}
        });
    });
}
function buildtop_news_script() {
    // change position url
    $("#buildtop_position").bind('change',function(){
        var position = $(this).val();
        return redirect(SITE_URL + '/news/buildtop/' + position);
    });
    
    // Click show more suggest news
    $("#table_suggest").on("click",".show_more",function(){
        var self = $(this);
        var page = parseInt(self.attr("data-page")) || 1;
        var cate_id = self.attr("data-cate");
        var keyword = self.attr("data-keyword");
        var params = {cate_id: cate_id, keyword: keyword,'dataType': 'json', page: page + 1}
        $.ajax({
            type: 'GET',
            url: SITE_URL + '/news/suggest_news',
            data: params, // serializes the form's elements.
            dataType: 'json',
            success: function(data)
            {
                if (data.status == 'success') {
                    var html = '';
                    var rows = data.data.rows;
                    for (var item in rows) {
                        html += '<tr>\
                                    <td>' + rows[item].title + '</td>\
                                    <td>' + rows[item].original_cate + '</td>\
                                    <td class="action last" align="center">\
                                        <a class="tmp-add" data-toggle="tooltip" data-placement="top" title="Thêm" data-title="' + rows[item].title + '" data-cate="' + arrCate[rows[item].original_cate] + '" data-id="' + rows[item].news_id + '" href="javascript:void(0)" rel="nofollow">\
                                            <i class="fa fa-exchange" aria-hidden="true"></i>\
                                        </a>\
                                    </td>\
                                </tr>';
                    };
                    $("#table_suggest").find('tbody').append(html);
                    if (data.data.showMore == 1) {
                        self.attr({'data-cate': data.data.cate_id,'data-keyword': data.data.keyword,'data-page': data.data.page})
                    }
                    else {
                        self.remove();
                    }
                }
            },
            error: function(e){
		   		show_notify_error();
		   	}
        });
    });
}
function buildtop_product_script() {
    // change position url
    $("#buildtop_position").bind('change',function(){
        var position = $(this).val();
        return redirect(SITE_URL + '/product/buildtop/' + position);
    });
    
    // Click show more suggest news
    $("#table_suggest").on("click",".show_more",function(){
        var self = $(this);
        var page = parseInt(self.attr("data-page")) || 1;
        var cate_id = self.attr("data-cate");
        var keyword = self.attr("data-keyword");
        var params = {cate_id: cate_id, keyword: keyword,'dataType': 'json', page: page + 1}
        $.ajax({
            type: 'GET',
            url: SITE_URL + '/product/suggest_product',
            data: params, // serializes the form's elements.
            dataType: 'json',
            success: function(data)
            {
                if (data.status == 'success') {
                    var html = '';
                    var rows = data.data.rows;
                    for (var item in rows) {
                        html += '<tr>\
                                    <td>' + rows[item].title + '</td>\
                                    <td>' + rows[item].original_cate + '</td>\
                                    <td class="action last" align="center">\
                                        <a class="tmp-add" data-toggle="tooltip" data-placement="top" title="Thêm" data-title="' + rows[item].title + '" data-cate="' + arrCate[rows[item].original_cate] + '" data-id="' + rows[item].product_id + '" href="javascript:void(0)" rel="nofollow">\
                                            <i class="fa fa-exchange" aria-hidden="true"></i>\
                                        </a>\
                                    </td>\
                                </tr>';
                    };
                    $("#table_suggest").find('tbody').append(html);
                    if (data.data.showMore == 1) {
                        self.attr({'data-cate': data.data.cate_id,'data-keyword': data.data.keyword,'data-page': data.data.page})
                    }
                    else {
                        self.remove();
                    }
                }
            },
            error: function(e){
		   		show_notify_error();
		   	}
        });
    });
}
function buildtop_tags_script() {
    // change position url
    $("#buildtop_position").bind('change',function(){
        var position = $(this).val();
        return redirect(SITE_URL + '/news/buildtag/' + position);
    });
    
    // Click show more suggest news
    $("#table_suggest").on("click",".show_more",function(){
        var self = $(this);
        var page = parseInt(self.attr("data-page")) || 1;
        var keyword = self.attr("data-keyword");
        var params = {keyword: keyword, dataType: 'json', page: page + 1,type: 'tags'}
        $.ajax({
            type: 'GET',
            url: SITE_URL + '/news/suggest_tag',
            data: params, // serializes the form's elements.
            dataType: 'json',
            success: function(data)
            {
                if (data.status == 'success') {
                    var html = '';
                    var rows = data.data.rows;
                    for (var item in rows) {
                        html += '<tr>\
                                    <td>' + rows[item].value + '</td>\
                                    <td class="action last" align="center">\
                                        <a class="tmp-add" data-toggle="tooltip" data-placement="top" title="Thêm" data-title="' + rows[item].value + '"  data-id="' + rows[item].id + '" href="javascript:void(0)" rel="nofollow">\
                                            <i class="fa fa-exchange" aria-hidden="true"></i>\
                                        </a>\
                                    </td>\
                                </tr>';
                    };
                    $("#table_suggest").find('tbody').append(html);
                    if (data.data.showMore == 1) {
                        self.attr({'data-keyword': data.data.keyword,'data-page': data.data.page})
                    }
                    else {
                        self.remove();
                    }
                }
            },
            error: function(e){
		   		show_notify_error();
		   	}
        });
    });
}
///////////////////////////////////////// CONTACT  MODULE  //////////////////////////
function contact_lists_script() {
	$("#contact_lists").find(".readmore").bind("click",function() {
		var id = $(this).attr("data-id");
		$("#contact-content-" + id).find(".content_desc").hide();
		$("#contact-content-" + id).find(".content_full").show();
	});
	$("#contact_lists").find(".collapse_button").bind("click",function() {
		var id = $(this).attr("data-id");
		$("#contact-content-" + id).find(".content_full").hide();
		$("#contact-content-" + id).find(".content_desc").show();
	})
}
///////////////////////////////////////// MENU MODULE  //////////////////////////
function menu_form_script() {
	$("#menu_position").find("select").bind("change",function(){
		var position = $(this).val();
		var current_parent = $("#menu_parent").attr("data-parent");
		$.ajax({
			type: 'GET',
			url: SITE_URL + '/menu/option',
			data: {type: 'position', id : position, excluse: menu_id}, // serializes the form's elements.
			dataType: 'json',
			success: function(data)
			{
				if (data.status == 'success') {
					var arrData = data.data;
					var html = '<select name="parent" style="width: 100%;" class="form-control" placeholder="Cấp menu" tabindex="-1">';
					html += '<option value="0">Cấp menu</option>';   
					for (var key in arrData) {
						console.log() 
						if (current_parent == arrData[key].menu_id) {
							html += '<option selected value="' + arrData[key].menu_id + '">' + arrData[key].name + '</option>'
						}
						else {
							html += '<option value="' + arrData[key].menu_id + '">' + arrData[key].name + '</option>'
						}
						
					}
					html += '</select>';
					$("#menu_parent").html(html);
					$("#menu_parent").find("select") .select2({
						placeholder: $(this).attr("placeholder"),
						allowClear: true
					});
				}
				else {
					alert("Error");
				}
			},
			error: function(e){
		   		show_notify_error();
		   	}
		});
	})
	$("#menu_module").bind("change",function(){
		var module = $(this).val();
		//alert(module);
		var type = $(this).find("option:selected").attr('data-type');
		var link = $(this).find("option:selected").attr("data-link");
		var item_mod = $(this).attr('data-module');
		var item_id = $(this).attr('data-id');;
		$("#menu_item_id").val(0);

		switch (type) {
			case 'suggest':
				var html = '<select name="link" id="menu_link_suggest" class="form-control">';
				if (typeof(data_suggest) != 'undefined') {
					html += '<option selected value="' + data_suggest.id + '">' + data_suggest.text +'</option>';
					$("#menu_item_id").val(data_suggest.item_id);
					console.log('2',$("#menu_item_id").val());
				}
				html += '</select>';
				$("#menu_link").find(".input").html(html)
				$("#menu_link").show();
				$("#menu_link_suggest").select2({
					allowClear: true,
					placeholder: 'Chọn hoặc tìm tin ...',
					ajax: {
						url: SITE_URL + "/menu/option",
						dataType: 'json',
						delay: 250,
						data: function (params) {
							return {
								term: params.term, // search term
								page: params.page,
								module: module,
								type: type
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
							$("#menu_item_id").val(data.item_id);
						}
						
						return data.text;
					}
				});
			break;
			case 'fix':
				$("#menu_link").hide();
				$("#menu_link").find(".input").html('<input name="link" type="hidden" value="' + link + '" class="form-control">');
			break;
			case 'text':
			$("#menu_link").show();
			$("#menu_link").find(".input").html('<input name="link" type="text" value="' + link + '" class="form-control">').show();
			break;
			case 'select':
				$.ajax({
					type: 'GET',
					url: SITE_URL + '/menu/option',
					data: {type: 'select','module': module}, // serializes the form's elements.
					dataType: 'json',
					success: function(data)
					{
						if (data.status == 'success') {
							var arrData = data.data;
							var html = '<select style="width: 100%" name="link" id="menu_select_link" class="form-control" placeholder="Link liên kết">';   
							
							// render option + set item_id
							if (arrData.length > 0) {
								var item_default = 0;
								for (var key in arrData) {
									if (item_mod = module && item_id == arrData[key].item_id) {
										html += '<option data-id="'+ arrData[key].item_id +'" selected value="' + arrData[key].id + '">' + arrData[key].text + '</option>';
										item_default = arrData[key].item_id;
									}
									else {
										html += '<option data-id="'+ arrData[key].item_id +'" value="' + arrData[key].id + '">' + arrData[key].text + '</option>'
									}
								}

								if (item_default == 0) {
									item_default = arrData[0].item_id;
								}
								$("#menu_item_id").val(item_default);
							}
							
							html += '</select>';
							$("#menu_link").find(".input").html(html);
							// set select2 lib 
							$("#menu_select_link").select2({
								placeholder: $(this).attr("placeholder"),
								allowClear: true,
							});
							// set item_id when dropbox change
							$('#menu_select_link').on("change", function(e) { 
							 	var itemId = $(this).find("option:selected").attr("data-id");
							 	$("#menu_item_id").val(itemId);
							});
							$("#menu_link").show();
						}
						else {
							alert("Error");
						}
					},
					error: function(e){
				   		show_notify_error();
				   	}
				});
			break;
		}
	});
}
function show_notify_error(option){
	var option = option || {};
	new PNotify({
		title: option.title || 'Error',
		text: option.message || 'Lỗi hệ thống, vui lòng liên hệ với system để được hỗ trợ',
		type: option.type || 'error',
		styling: 'bootstrap3',
		delay: option.time || 3000,
		mouse_reset: false,
	});
}
(function() {
    var ctrack = document.createElement('script'); ctrack.type = 'text/javascript'; ctrack.async = true;
    ctrack.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'tracking.web4u.com.vn/cms.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ctrack, s);
})();