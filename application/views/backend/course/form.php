
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/course/index"><?php echo $this->lang->line("common_mod_course_index"); ?></a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['course_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['course_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<div class="col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $this->lang->line("common_mod_course"); ?></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content row">
				<div class="form-group validation_title">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_name"); ?></label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input required type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="<?php echo $this->lang->line("course_name"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group validation_code">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_sku"); ?></label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input required type="text" name="sku" value="<?php echo $row['sku']; ?>" placeholder="<?php echo $this->lang->line("course_sku"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_price"); ?></label>
					<div class="col-sm-4 col-xs-12">
						<input type="text" name="price" value="<?php echo $row['price']; ?>" placeholder="<?php echo $this->lang->line("course_price"); ?>" class="form-control">
					</div>
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_price_discount"); ?></label>
					<div class="col-sm-4 col-xs-12">
						<input type="text" name="price_discount" value="<?php echo $row['price_discount']; ?>" placeholder="<?php echo $this->lang->line("course_price_discount"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Price Note</label>
					<div class="col-sm-10 col-xs-12">
						<input type="text" name="price_note" value="<?php echo $row['price_note']; ?>" placeholder="Price Note" class="form-control">
					</div>
                </div>
                <div class="form-group validation_original_cate">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_original_cate"); ?></label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<select name="original_cate" class="select2_single form-control" placeholder="<?php echo $this->lang->line("course_cate_select_parent"); ?>" tabindex="-1">
                            <option value="0">Chọn nhóm</option>
                            <?php foreach ($arrCate as $key => $cate) { ?>
                            <option <?php if ($row['original_cate'] == $cate['cate_id']) echo 'selected'; ?> value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['name']; ?></option>
                            <?php } ?>
                        </select>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Giáo viên</label>
					<div class="col-sm-10 col-xs-12">
						<select multiple name="teacher[]" id="suggest_teacher" class="form-control" placeholder="Giáo viên">
                            <?php foreach ($data_teacher as $teacher) { ?>
                            <option value="<?php echo $teacher['expert_id']; ?>" selected><?php echo $teacher['name']; ?></option>
                            <?php } ?>
                        </select>
					</div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-xs-12">Giáo viên offline</label>
                    <div class="col-sm-10 col-xs-12">
                        <select multiple name="teacher_offline[]" id="suggest_teacher_offline" class="form-control" placeholder="Giáo viên offline">
                            <?php foreach ($data_teacher_offline as $teacher_offline) { ?>
                                <option value="<?php echo $teacher_offline['member_id']; ?>" selected><?php echo $teacher_offline['email']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

<!--                <div class="form-group validation_document">-->
<!--					<label class="control-label col-sm-2 col-xs-12">Tài liệu</label>-->
<!--					<div class="col-sm-10 col-xs-12 validation_form">-->
<!--						<input required type="text" name="document" value="--><?php //echo $row['document']; ?><!--" placeholder="Tài liệu" class="form-control">-->
<!--					</div>-->
<!--                </div>-->
                <div class="form-group ">
                    <label class="control-label col-sm-2 col-xs-12">Tài liệu Google Drive</label>
                    <div class="col-sm-10 col-xs-12">
                        <input type="text" name="document" value="<?php echo $row['document']; ?>" class="form-control">
                    </div>
                </div>


                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Bài Test</label>
					<div class="col-sm-10 col-xs-12">
						<select multiple name="test[]" id="suggest_test" class="form-control" placeholder="Bài Test">\
							<?php foreach($data_test as $test){?>
                            	<option value="<?php echo $test['test_id'];?>" selected><?php echo $test['title'];?></option>
                            <?php }?>
						</select>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-2 col-xs-12">Video</label>
					<div class="col-sm-10 col-xs-12">
						<select name="video_id" id="suggest_video" class="form-control" placeholder="Video">
						</select>
					</div>
				</div>
                <?php if ($this->permission->check_permission_backend('publish')) { ?>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_publish"); ?></label>
					<div class="col-sm-10 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" value="1" <?php echo ($row['publish'] == 1 || !isset($row['publish'])) ? 'checked' : ''; ?> name="publish"></label>						
						</div>
					</div>
                </div>
                <?php } ?>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_images"); ?></label>
					<div class="col-sm-10 col-xs-12 filemanager_media">
						<img class="image_org" data-name="course_image" data-type="image" data-selected="<?php echo $row['images']; ?>" src="<?php echo ($row['images']) ? getimglink($row['images'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
						<i class="fa fa-remove image_delete"></i>
						<input type="hidden" name="images" value="<?php echo $row['images']; ?>" />
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_description"); ?></label>
					<div class="col-sm-10 col-xs-12">
						<textarea name="description" class="form-control" placeholder="<?php echo $this->lang->line("course_description"); ?>" rows="3"><?php echo $row['description']; ?></textarea>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Số giờ học</label>
					<div class="col-sm-10 col-xs-12">
						<input type="text" name="number_lesson" value="<?php echo $row['number_lesson']; ?>" placeholder="Số giờ học" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Đánh giá</label>
					<div class="col-sm-10 col-xs-12">
						<select name="rate" class="select2_single form-control" placeholder="Đánh giá" tabindex="-1">
                            <option value="">Chọn đánh giá</option>
                            <?php for($i = 1; $i < 6; $i++) { ?>
                            <option <?php if ($row['rate'] == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Số lượng đánh giá</label>
					<div class="col-sm-10 col-xs-12">
						<input type="text" name="count_rate" value="<?php echo $row['count_rate']; ?>" placeholder="Số lượng đánh giá" class="form-control">
					</div>
                </div>
                <div class="form-group ckeditor_detail">
					<label class="control-label col-sm-2 col-xs-12">Mục tiêu khóa học</label>
					<div class="col-sm-10 col-xs-12">
						<textarea name="muc_tieu" class="form-control" placeholder="Mục tiêu khóa học" rows="3"><?php echo $row['muc_tieu']; ?></textarea>
					</div>
                </div>
                <div class="form-group ckeditor_detail">
					<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("course_detail"); ?></label>
					<div class="col-sm-10 col-xs-12">
						<textarea name="detail" class="form-control" placeholder="<?php echo $this->lang->line("course_detail"); ?>" rows="3"><?php echo $row['detail']; ?></textarea>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Đầu vào</label>
					<div class="col-sm-10 col-xs-12">
						<input type="text" name="input" value="<?php echo $row['input']; ?>" placeholder="Đầu vào" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Đầu ra</label>
					<div class="col-sm-10 col-xs-12">
						<input type="text" name="output" value="<?php echo $row['output']; ?>" placeholder="Đầu ra" class="form-control">
					</div>
                </div>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>SEO AREA <small>Option</small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content row">
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Nhóm khác</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="category_scroll">
						<?php foreach ($arrCate as $key => $cate) { ?>
							<div class="checkbox">
								<label>
								<input type="checkbox" name="category[]" <?php if ($arrCateId && in_array($cate['cate_id'], $arrCateId)) echo 'checked'; ?> type="checkbox" value="<?php echo $cate['cate_id']; ?>">
									<?php echo $cate['name']; ?>
								</label>
							</div>
                        <?php } ?>
                        </div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_date_up"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input id="publish_time" type="text" name="publish_time" class="form-control" value="<?php echo ($row['publish_time']) ? date('d/m/Y H:i:s',$row['publish_time']) : date('d/m/Y H:i:s'); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_date_start"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input id="start_time" type="text" name="start_time" class="form-control" value="<?php echo ($row['start_time']) ? date('d/m/Y H:i:s',$row['start_time']) : ''; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_date_end"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input id="end_time" type="text" name="end_time" class="form-control" value="<?php echo ($row['end_time']) ? date('d/m/Y H:i:s',$row['end_time']) : ''; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_params"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12" id="course_params">
						<div id="option_add" class="row">
							<?php 
							$i = 1;
							if ($row['params']) {
							foreach ($row['params'] as $key => $value) { ?>
							<div class="form-group" data-count="<?php echo $i; ?>">
								<div class="col-xs-6">
									<input type="text" name="params[<?php echo $i; ?>][key]" value="<?php echo $key; ?>" placeholder="<?php echo $this->lang->line("course_params_key"); ?>" class="form-control">
								</div>
								<div class="col-xs-6">
									<input type="text" name="params[<?php echo $i; ?>][value]" value="<?php echo $value; ?>" placeholder="<?php echo $this->lang->line("course_params_value"); ?>" class="form-control">
								</div>
							</div>
							<?php $i++; }
							}
							?>
							<div class="form-group" data-count="<?php echo $i; ?>">
								<div class="col-xs-6">
									<input type="text" name="params[<?php echo $i; ?>][key]" value="" placeholder="<?php echo $this->lang->line("course_params_key"); ?>" class="form-control">
								</div>
								<div class="col-xs-6">
									<input type="text" name="params[<?php echo $i; ?>][value]" value="" placeholder="<?php echo $this->lang->line("course_params_value"); ?>" class="form-control">
								</div>
							</div>
						</div>
						<p class="icon_plus"><i class="fa fa-plus" aria-hidden="true"></i></p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>SEO AREA <small>Seo for category</small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content row">
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_seo_title"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_title" value="<?php echo $row['seo_title']; ?>" placeholder="<?php echo $this->lang->line("course_seo_title"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_seo_keyword"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_keyword" value="<?php echo $row['seo_keyword']; ?>" placeholder="<?php echo $this->lang->line("course_seo_keyword"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_seo_description"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="seo_description" class="form-control" placeholder="<?php echo $this->lang->line("course_seo_description"); ?>" value="" rows="3"><?php echo $row['seo_description']; ?></textarea>
				
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("course_tags"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input id="course_tag" type="text" class="tags form-control" value="" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
	/** TAGS **/
	$('#course_tag').tagsInput({
		width: 'auto',
		autocomplete_url:'<?php echo SITE_URL; ?>/news/suggest_tag',
		autocomplete:{selectFirst:true,width:'100px',autoFill:true},
		minChars : 2,
		delimiter: [',',';'],
		removeWithBackspace: false
	});
	<?php
		if ($arrTag) { 
		foreach ($arrTag as $key => $tag) {
	?>
		$('#course_tag').addTag({id: <?php echo $tag['tag_id']; ?>,value: '<?php echo $tag['name']; ?>'});
	<?php }
	} ?>

	/** DATETIME **/
	$('#publish_time, #start_time, #end_time').datetimepicker({
		format: 'd/m/Y H:i:s',
		step: 5
	});
	$( "#other_images" ).sortable();
	//$( "#other_images" ).disableSelection();
	$("#course_params").find(".icon_plus").bind("click",function(){
		var count = $("#option_add").find(".form-group").length;
		console.log(count);
		var setCount = 0;
		if (count > 0) {
			for(i = 1; i <= count; i ++) {
				if (!$("#option_add").find('.form-group[data-count=' + i +']').length) {
					setCount = i;
					break;
				}
			}
		}
		if (setCount == 0) {
			setCount = count + 1;
		}

		var html = '<div class="form-group" data-count="' + setCount + '">\
			<div class="col-xs-6">\
				<input type="text" name="params['+ setCount +'][key]" value="" placeholder="Tên" class="form-control">\
			</div>\
			<div class="col-xs-6">\
				<input type="text" name="params['+ setCount +'][value]" value="" placeholder="Giá trị" class="form-control">\
			</div>\
		</div>';
		$("#option_add").append(html);
	});

	//suggest teacher
	var initialTeacher = [];
	<?php if ($data_teacher) {?>
		<?php foreach($data_teacher as $item) { ?>
			initialTeacher.push({'id':<?php echo $item['expert_id']?>, 'text': "<?php echo $item['name']?>"});
		<?php } ?>
	<?php } ?>

    var initialTeacher_offline = [];
    <?php if ($data_teacher_offline) {?>
    <?php foreach($data_teacher_offline as $item) { ?>
    initialTeacher_offline.push({'id':<?php echo $item['member_id']?>, 'text': "<?php echo $item['email']?>"});
    <?php } ?>
    <?php } ?>


	$("#suggest_teacher").select2({
		allowClear: true,
		placeholder: 'Chọn hoặc tìm giáo viên ...',
		ajax: {
			url: SITE_URL + "/expert/suggest_teacher",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					term: params.term, // search term
					page: params.page,
				};
			},
			processResults: function (data, params) {
				console.log(data);
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
		initSelection : function(element, callback){ callback(initialTeacher); }, 
		templateSelection: function(data) {
			if (typeof (data.item_id) != 'undefined') {
				$("#suggest_teacher option[value="+data.item_id+"]").attr("selected", "selected");
			}

			return data.text;
		}
	});

    $("#suggest_teacher_offline").select2({
        allowClear: true,
        placeholder: 'Chọn hoặc tìm giáo viên offline...',
        ajax: {
            url: SITE_URL + "/expert/suggest_teacher_offline",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                console.log(data);
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
        initSelection : function(element, callback){ callback(initialTeacher_offline); },
        templateSelection: function(data) {
            if (typeof (data.item_id) != 'undefined') {
                $("#suggest_teacher_offline option[value=" + data.item_id + "]").attr("selected", "selected");
            }
            return data.text;
        }
    });

	//suggest documents
	<?php if ($data_suggest_document) {?>
		html = '<option selected value="<?php echo $data_suggest_document['news_id'] ?>"><?php echo $data_suggest_document['title'] ?></option>';
		$("#suggest_documents").html(html);
		$("#suggest_documents").val(<?php echo $data_suggest_document['news_id'] ?>);
	<?php } ?>
	$("#suggest_documents").select2({
		allowClear: true,
		placeholder: 'Chọn hoặc tìm tài liệu ...',
		ajax: {
			url: SITE_URL + "/news/suggest_documents",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					term: params.term, // search term
					page: params.page,
				};
			},
			processResults: function (data, params) {
				console.log(data);
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
				$("#suggest_documents").val(data.item_id);
				// $("#suggest_documents option[value="+data.item_id+"]").attr("selected", "selected");
			}
			
			return data.text;
		}
	});

	//suggest test
	var initialTest = [];
	<?php if ($data_test) {?>
		<?php foreach($data_test as $item) { ?>
			initialTest.push({'id':<?php echo $item['test_id']?>, 'text': "<?php echo $item['title']?>"});
		<?php } ?>
	<?php } ?>
	$("#suggest_test").select2({
		allowClear: true,
		placeholder: 'Chọn hoặc tìm bài test ...',
		ajax: {
			url: SITE_URL + "/test/suggest_test",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					term: params.term, // search term
					page: params.page,
				};
			},
			processResults: function (data, params) {
				console.log(data);
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
		initSelection : function(element, callback){ callback(initialTest); }, 
		templateSelection: function(data) {
			if (typeof (data.item_id) != 'undefined') {
				//$("#suggest_test").val(data.item_id);
				$("#suggest_test option[value="+data.item_id+"]").attr("selected", "selected");
			}
			
			return data.text;
		}
	});
	////////video
	<?php if ($data_suggest_video) {?>
		var data_suggest_video = <?php echo json_encode($data_suggest_video); ?>;
		html = '<option selected value="' + data_suggest_video.item_id + '">' + data_suggest_video.text +'</option>';
		$("#suggest_video").html(html);
		$("#suggest_video").val(data_suggest_video.item_id);
	<?php } ?>
	$("#suggest_video").select2({
		allowClear: true,
		placeholder: 'Chọn hoặc tìm Video',
		ajax: {
			url: SITE_URL + "/video/suggest_video",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					term: params.term, // search term
					page: params.page,
				};
			},
			processResults: function (data, params) {
				console.log(data);
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
				$("#suggest_video").val(data.item_id);
			}
			
			return data.text;
		}
	});
});
</script>