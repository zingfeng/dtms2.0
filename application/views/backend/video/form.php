<?php 
    if (!defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->config('data');
    $vimeo_oauth = $this->config->item('vimeo_oauth');
    if ($row['size']) {
        $arrSize = json_decode($row['size'],TRUE);
    }
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/video/index">Danh sách Video</a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['video_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['video_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
    <div class="col-sm-12 col-xs-12">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a id="video-tab" href="#video_detail" role="tab" data-toggle="tab" aria-controls="video_detail" aria-expanded="false">Video</a></li>
            <li role="presentation"><a id="time-tab" href="#video_time" role="tab" data-toggle="tab" aria-controls="video_time" aria-expanded="false">Add time</a></li>
        </ul>
    </div>
</div>
<div class="row tab-pane" id="video_detail">
	<div class="col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Video</h2>
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
					<label class="control-label col-sm-2 col-xs-12">Tên Video</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<input required type="text" id="title" name="title" value="<?php echo $row['title']; ?>" placeholder="Tên Video" class="form-control">
					</div>
                </div>
                <div class="form-group validation_original_cate">
					<label class="control-label col-sm-2 col-xs-12">Nhóm Video</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<select name="original_cate" class="select2_single form-control" placeholder="<?php echo $this->lang->line("video_cate_select_parent"); ?>" tabindex="-1">
                            <option value="0">Chọn nhóm Video</option>
                            <?php foreach ($arrCate as $key => $cate) { ?>
                            <option <?php if ($row['original_cate'] == $cate['cate_id']) echo 'selected'; ?> value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['name']; ?></option>
                            <?php } ?>
                        </select>
					</div>
                </div>
                <?php if ($this->permission->check_permission_backend('publish')) { ?>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Xuất bản</label>
					<div class="col-sm-10 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" value="1" <?php echo ($row['publish'] == 1 || !isset($row['publish'])) ? 'checked' : ''; ?> name="publish"></label>			
						</div>
					</div>
                </div>
                <?php } ?>
                <div class="form-group validation_vimeo_id_video">
					<label class="control-label col-sm-2 col-xs-12">Video</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<div class="row">
							<input type="file" id="file_input" class="button" accept="video/*">
							<button id="button_upload" type="button" class="btn btn-primary">Upload</button>
						</div>
						<div class="row">
							<div class="during-upload">
					        	<div id="progress-container" class="progress" style="display: none;">
						            <div id="progress" class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100" style="width: 0%">&nbsp;0%
						            </div>
						        </div>
					      	</div>
				        	<div class="row">
					          	<div class="col-md-12">
					            	<div id="results"></div>
					          	</div>
					        </div>
						</div>
						<div class="row">
							<div id="video_preview">
								<?php if($row['vimeo_id']){ ?>
                                <iframe src="https://player.vimeo.com/video/<?php echo $row['vimeo_id']; ?>?badge=0&autopause=0&player_id=0&app_id=<?php echo $this->config->item('vimeo_oauth')['app_id']?>" width="320" height="180" frameborder="0" title="<?php echo $row['title']; ?>" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                <?php }?>
							</div>
						</div>
					</div>
                </div>
                <div class="form-group validation_title">
                    <label class="control-label col-sm-2 col-xs-12">Link video youtube</label>
                    <div class="col-sm-10 col-xs-12 validation_form">
                        <input type="text" id="link_youtube" value="<?php echo $row['youtube_id'] ? 'https://www.youtube.com/watch?v='.$row['youtube_id'] : '' ?>" placeholder="Link video youtube" class="form-control">
                        <div class="row" style="margin-top: 10px">
                            <div class="col-md-12">
                                <div id="actualyoutube">
                                    <?php echo $row['youtube_id'] ? '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$row['youtube_id'].'" frameborder="0" allowfullscreen></iframe>': ''?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Ảnh</label>
					<div class="col-sm-10 col-xs-12 filemanager_media">
						<img class="image_org" data-name="video_image" data-type="image" data-selected="<?php echo $row['images']; ?>" src="<?php echo ($row['images']) ? getimglink($row['images'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
						<i class="fa fa-remove image_delete"></i>
						<input type="hidden" name="images" value="<?php echo $row['images']; ?>" />
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-sm-2 col-xs-12">Mô tả</label>
					<div class="col-sm-10 col-xs-12">
						<textarea name="description" id="description" class="form-control" placeholder="<?php echo $this->lang->line("video_description"); ?>" rows="3"><?php echo $row['description']; ?></textarea>
					</div>
                </div>
                <div class="form-group validation_title">
                    <label class="control-label col-sm-2 col-xs-4">Duration</label>
                    <div class="col-sm-2 col-xs-12 validation_form">
                        <input required type="text" id="video_duration" readonly name="duration" value="<?php echo $row['duration']; ?>" placeholder="Thời lượng" class="form-control">
                    </div>
                    <label class="control-label col-sm-2 col-xs-12">Width</label>
                    <div class="col-sm-2 col-xs-12 validation_form">
                        <input required type="text" id="video_width" readonly name="params[width]" value="<?php echo $arrSize['width']; ?>" placeholder="Width" class="form-control">
                    </div>
                    <label class="control-label col-sm-2 col-xs-12">Heigh</label>
                    <div class="col-sm-2 col-xs-12 validation_form">
                        <input required type="text" id="video_height" readonly name="params[height]" value="<?php echo $arrSize['height']; ?>" placeholder="Height" class="form-control">
                    </div>
                </div>
			</div>
		</div>
	</div>
	<input type="hidden" id="accessToken" class="form-control" value="<?php echo $vimeo_oauth['access_token'];?>" placeholder="Vimeo access token"></input>
	<input id="vimeo_id_video" type="hidden" name="vimeo_id_video" value="<?php echo $row['vimeo_id_video'];?>">
	<input type="hidden" name="youtube_id_video" id="video-id" value="<?php echo $row['youtube_id_video'];?>">
</div>
<div class="row tab-pane" id="video_time" style="display: none;">
    <div class="col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_content row">
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12">Thời gian</label>
                    <div class="col-md-10 col-sm-10 col-xs-12" id="video_params">
                        <div id="option_add" class="row">
                            <div class="col-md-12">
                                <div class="col-xs-4">
                                    <label>Mốc thời gian</label>
                                </div>
                                <div class="col-xs-4">
                                    <label>Object</label>
                                </div>
                                <div class="col-xs-4">
                                    <label>Type</label>
                                </div>
                            </div>
                            <?php 
                            $i = 1;
                            if ($row['params']) {
                            foreach ($row['params'] as $value) { ?>
                            <div class="form-group" data-count="<?php echo $i; ?>">
                                <div class="col-xs-4">
                                    <input type="text" name="params[<?php echo $i; ?>][time]" value="<?php echo $value['time']; ?>" placeholder="Thời gian (giây)" class="form-control">
                                </div>
                                <div class="col-xs-4">
                                    <select name="params[<?php echo $i; ?>][object_id]" class="form-control suggest_test" placeholder="Bài Test" style="width: 100%;">
                                        <?php if($arrTest[$value['object_id']]){?>
                                        <option selected value="<?php echo $arrTest[$value['object_id']]['test_id'];?>"><?php echo $arrTest[$value['object_id']]['title'];?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select class="form-control select2_single" name="params[<?php echo $i; ?>][type]" style="width: 100%;">
                                        <option value="1" <?php echo ($value['type'] == 1) ?"selected":""; ?>>Bài test</option>
                                    </select>
                                </div>
                            </div>
                            <?php $i++; }
                            }
                            ?>
                            <div class="form-group" data-count="<?php echo $i; ?>">
                                <div class="col-md-4">
                                    <input type="text" name="params[<?php echo $i; ?>][time]" value="" placeholder="Thời gian (giây)" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <select name="params[<?php echo $i; ?>][object_id]" class="form-control suggest_test" placeholder="Bài Test" style="width: 100%;">
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control select2_single" name="params[<?php echo $i; ?>][type]" style="width: 100%;">
                                        <option value="1">Bài test</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p class="icon_plus"><i class="fa fa-plus" aria-hidden="true"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
	/** DATETIME **/
	$('#publish_time').datetimepicker({
		format: 'd/m/Y H:i:s',
		step: 5
	});
	
});
</script>
<script type="text/javascript">
    /**
     * Called when files are dropped on to the drop target or selected by the browse button.
     * For each file, uploads the content to Drive & displays the results when complete.
     */
    function handleFileSelect(ele) {

        var files = $(ele).get(0).files
        var results = document.getElementById('results')

        /* Clear the results div */
        while (results.hasChildNodes()) results.removeChild(results.firstChild)

        /* Rest the progress bar and show it */
        updateProgress(0)
        document.getElementById('progress-container').style.display = 'block' 

        /* Instantiate Vimeo Uploader */
        ;(new VimeoUpload({
            name: document.getElementById('title').value,
            file: files[0],
            token: document.getElementById('accessToken').value,
            onError: function(data) {
                alert('error');
                showMessage('<strong>Error</strong>: ' + JSON.parse(data).error, 'danger')
            },
            onProgress: function(data) {
                updateProgress(data.loaded / data.total)
            },
            onComplete: function(videoId, index) {
                if (index > -1) {
                    var arrVideoId = videoId.split(":");
                    $('#vimeo_id_video').val(arrVideoId[0]);
                    /* The metadata contains all of the uploaded video(s) details see: https://developer.vimeo.com/api/endpoints/videos#/{video_id} */
                    // url = this.metadata[index].link;
                    /* add stringify the json object for displaying in a text area */
                    //var pretty = JSON.stringify(this.metadata[index], null, 2)
                    // $('#video_preview').html(this.metadata[index].embed.html);
                    showMessage('<strong>Upload Successful</strong>')
                }
                else {
                    alert("Upload video lỗi");
                }
                
            }
        })).upload()

        /* local function: show a user message */
        function showMessage(html, type) {
            /* hide progress bar */
            document.getElementById('progress-container').style.display = 'none'

            /* display alert message */
            var element = document.createElement('div')
            element.setAttribute('class', 'alert alert-' + (type || 'success'))
            element.innerHTML = html
            results.appendChild(element)
        }
    }


    /**
     * Updat progress bar.
     */
    function updateProgress(progress) {
        progress = Math.floor(progress * 100)
        var element = document.getElementById('progress')
        element.setAttribute('style', 'width:' + progress + '%')
        element.innerHTML = '&nbsp;' + progress + '%'
    }

    function suggest_test(){
        //suggest test
        $(".suggest_test").select2({
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
            templateSelection: function(data,container) {
                console.log(container);
                if (typeof (data.item_id) != 'undefined') {
                    $(container).val(data.item_id);
                    //$("#suggest_test option[value="+data.item_id+"]").attr("selected", "selected");
                }
                
                return data.text;
            }
        });
    }

    $(document).ready(function(){
        suggest_test();
    	$('#button_upload').click(function(){
    		var title = $('#title').val();
    		var file = $('#file_input').val();
    		if(!title){
    			show_notify_error({message:'Tiêu đề không được để trống'});
    			return false;
    		}
    		if(!file){
    			show_notify_error({message:'Chưa chọn video'});
    			return false;
    		}
    		handleFileSelect('#file_input');
    	});

        ////tab
        $('.nav-tabs a').click(function (e) {
            e.preventDefault()
            $(this).tab('show');
            var id_tab = $(this).attr('href');
            $('.tab-pane').hide();
            $(id_tab).show();
        });
        //add params
        $("#video_params").find(".icon_plus").bind("click",function(){
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
                <div class="col-xs-4">\
                    <input type="text" name="params['+ setCount +'][time]" value="" placeholder="Thời gian (giây)" class="form-control">\
                </div>\
                <div class="col-xs-4">\
                    <select name="params['+ setCount +'][object_id]" class="form-control suggest_test" placeholder="Bài Test" style="width: 100%;">\
                    </select>\
                </div>\
                <div class="col-xs-4">\
                    <select class="form-control select2_single" name="params['+ setCount +'][type]" style="width: 100%;">\
                        <option value="1">Bài test</option>\
                    </select>\
                </div>\
            </div>';
            $("#option_add").append(html);
            $('.select2_single').select2();
            suggest_test();
        });
        //Change link youtube
        $(document).on('change', '#link_youtube', function() {
            var url = $(this).val();
            var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
            if(videoid != null) {
                $('#actualyoutube').html('<iframe width="560" height="315" src="https://www.youtube.com/embed/'+videoid[1]+'" frameborder="0" allowfullscreen></iframe>');
                $('input[name="youtube_id_video"]').val(videoid[1]);
            } else { 
                console.log("The youtube url is not valid.");
            }
        });

    });

</script>