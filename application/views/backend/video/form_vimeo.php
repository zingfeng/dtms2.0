
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
$vimeo_oauth = $this->config->item('vimeo_oauth');
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
						<input required type="text" id="videoName" name="name" value="<?php echo $row['title']; ?>" placeholder="Tên Video" class="form-control">
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
                <div class="form-group validation_youtube_id_video">
					<label class="control-label col-sm-2 col-xs-12">Video</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<div class="row">
							<input type="file" id="browse" class="button" accept="video/*">
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
						<textarea name="description" id="videoDescription" class="form-control" placeholder="<?php echo $this->lang->line("video_description"); ?>" rows="3"><?php echo $row['description']; ?></textarea>
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Ngày đăng</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input id="publish_time" type="text" name="publish_time" class="form-control" value="<?php echo ($row['publish_time']) ? date('d/m/Y H:i:s',$row['publish_time']) : date('d/m/Y H:i:s'); ?>"/>
					</div>
				</div>
				<input type="hidden" id="accessToken" class="form-control" value="<?php echo $vimeo_oauth['access_token'];?>" placeholder="Vimeo access token"></input>
				<input id="vimeo_id_video" type="hidden" name="vimeo_id_video" value="<?php echo $row['vimeo_id_video'];?>">
				<input type="hidden" name="youtube_id_video" id="video-id" value="<?php echo $row['youtube_id_video'];?>">
		</div>
	</div>
	<div class="col-sm-6 col-xs-12">
		
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
        function handleFileSelect(evt) {
            evt.stopPropagation()
            evt.preventDefault()

            var files = evt.dataTransfer ? evt.dataTransfer.files : $(this).get(0).files
            var results = document.getElementById('results')

            /* Clear the results div */
            while (results.hasChildNodes()) results.removeChild(results.firstChild)

            /* Rest the progress bar and show it */
            updateProgress(0)
            document.getElementById('progress-container').style.display = 'block'

            /* Instantiate Vimeo Uploader */
            ;(new VimeoUpload({
                name: document.getElementById('videoName').value,
                description: document.getElementById('videoDescription').value,
                file: files[0],
                token: document.getElementById('accessToken').value,
                onError: function(data) {
                    showMessage('<strong>Error</strong>: ' + JSON.parse(data).error, 'danger')
                },
                onProgress: function(data) {
                    updateProgress(data.loaded / data.total)
                },
                onComplete: function(videoId, index) {
                    var url = 'https://vimeo.com/' + videoId
                    $('#vimeo_id_video').val(videoId);
                    if (index > -1) {
                        /* The metadata contains all of the uploaded video(s) details see: https://developer.vimeo.com/api/endpoints/videos#/{video_id} */
                        url = this.metadata[index].link //

                        /* add stringify the json object for displaying in a text area */
                        var pretty = JSON.stringify(this.metadata[index], null, 2)
                        //results.html(pretty.embed.html);
                        console.log(pretty) /* echo server data */
                    }

                    showMessage('<strong>Upload Successful</strong>: check uploaded video @ <a href="' + url + '">' + url + '</a>. Open the Console for the response details.')
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
        /**
         * Wire up drag & drop listeners once page loads
         */
        document.addEventListener('DOMContentLoaded', function() {
            var browse = document.getElementById('browse')
            browse.addEventListener('change', handleFileSelect, false)
        })

    </script>