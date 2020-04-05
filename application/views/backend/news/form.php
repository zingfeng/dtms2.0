<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/news/index"><?php echo $this->lang->line("common_mod_news_index"); ?></a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['news_id']) { ?>
	<a class="btn btn-primary" target="_blank" href="<?php echo BASE_URL; ?>/news/preview/<?php echo $row['news_id']; ?>/<?php echo $this->security->generate_token_post($row['news_id']) ;?>">Preview</a> 
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['news_id']) ?>"/>
	<?php } ?>

</div>
<div class="row">
    <div class="col-sm-12 col-xs-12">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a id="news-detail-tab" href="#news_detail" role="tab" data-toggle="tab" aria-expanded="false">Chi tiết</a></li>
            <li role="presentation"><a id="news-option-tab" href="#news_option" role="tab" data-toggle="tab" aria-expanded="false">Mở rộng</a></li>
        </ul>
    </div>
</div>
<div class="tab-content">
	<div class="row tab-pane active" id="news_detail">
		<div class="col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><?php echo $this->lang->line("common_mod_news"); ?></small></h2>
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
						<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("news_name"); ?> *</label>
						<div class="col-sm-10 col-xs-12 validation_form">
							<input required type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="<?php echo $this->lang->line("news_name"); ?>" class="form-control">
						</div>
	                </div>
	                <div class="form-group validation_original_cate">
						<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("news_original_cate"); ?></label>
						<div class="col-sm-10 col-xs-12 validation_form">
							<select name="original_cate" class="select2_single form-control" placeholder="<?php echo $this->lang->line("news_cate_select_parent"); ?>" tabindex="-1">
	                            <option value="0"><?php echo $this->lang->line("news_cate_select_parent"); ?></option>
	                            <?php foreach ($arrCate as $key => $cate) { ?>
	                            <option <?php if ($row['original_cate'] == $cate['cate_id']) echo 'selected'; ?> value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['name']; ?></option>
	                            <?php } ?>
	                        </select>
						</div>
	                </div>
	                <?php if ($this->permission->check_permission_backend('publish')) { ?>
	                <div class="form-group">
						<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("news_publish"); ?></label>
						<div class="col-sm-10 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" value="1" <?php echo ($row['publish'] == 1 || !isset($row['publish'])) ? 'checked' : ''; ?> name="publish"></label>						
							</div>
						</div>
	                </div>
	                <?php } ?>
	                <div class="form-group">
						<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("news_images"); ?></label>
						<div class="col-sm-10 col-xs-12 filemanager_media">
							<img class="image_org" data-name="news_image" data-type="image" data-selected="<?php echo $row['images']; ?>" src="<?php echo ($row['images']) ? getimglink($row['images'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
							<i class="fa fa-remove image_delete"></i>
							<input type="hidden" name="images" value="<?php echo $row['images']; ?>" />
						</div>
	                </div>
	                <div class="form-group">
						<label class="control-label col-sm-2 col-xs-12">Ảnh chia sẻ</label>
						<div class="col-sm-10 col-xs-12 filemanager_media">
							<img class="image_org" data-name="news_image_social" data-type="image" data-selected="<?php echo $row['images_social']; ?>" src="<?php echo ($row['images_social']) ? getimglink($row['images_social'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
							<i class="fa fa-remove image_delete"></i>
							<input type="hidden" name="images_social" value="<?php echo $row['images_social']; ?>" />
						</div>
	                </div>
	                <div class="form-group">
						<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("news_description"); ?></label>
						<div class="col-sm-10 col-xs-12">
							<textarea name="description" class="form-control" placeholder="<?php echo $this->lang->line("news_description"); ?>" rows="3"><?php echo $row['description']; ?></textarea>
						</div>
	                </div>
	                <div class="form-group ckeditor_detail">
						<label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("news_detail"); ?></label>
						<div class="col-sm-10 col-xs-12">
							<textarea name="detail" class="form-control" placeholder="<?php echo $this->lang->line("news_detail"); ?>" rows="3"><?php echo $row['detail']; ?></textarea>
						</div>
	                </div>
	                <div class="form-group">
						<label class="control-label col-sm-2 col-xs-12">Mở rộng</label>
						<div class="col-sm-10 col-xs-12">
							<textarea name="extra" class="form-control" placeholder="Mở rộng" rows="3"><?php echo $row['extra']; ?></textarea>
						</div>
	                </div>
				</div>
			</div>
			<div class="x_panel">
				<div class="x_title">
					<h2>Thêm thuộc tính <small>Dành cho các thông số thêm</small></h2>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Thuộc tính</label>
						<div class="col-md-9 col-sm-9 col-xs-12" id="product_params">
							<div id="option_add" class="row">
								<?php 
								$i = 1;
								if ($row['params']) {
								foreach ($row['params'] as $key => $value) { ?>
								<div class="form-group" data-count="<?php echo $i; ?>">
									<div class="col-xs-6">
										<input type="text" name="params[<?php echo $i; ?>][key]" value="<?php echo $key; ?>" placeholder="Tên" class="form-control">
									</div>
									<div class="col-xs-6">
										<input type="text" name="params[<?php echo $i; ?>][value]" value="<?php echo $value; ?>" placeholder="Giá trị" class="form-control">
									</div>
								</div>
								<?php $i++; }
								}
								?>
								<div class="form-group" data-count="<?php echo $i; ?>">
									<div class="col-xs-6">
										<input type="text" name="params[<?php echo $i; ?>][key]" value="" placeholder="Tên" class="form-control">
									</div>
									<div class="col-xs-6">
										<input type="text" name="params[<?php echo $i; ?>][value]" value="" placeholder="Giá trị" class="form-control">
									</div>
								</div>
							</div>
							<p class="icon_plus"><i class="fa fa-plus" aria-hidden="true"></i></p>
						</div>
					</div>
	            </div>
	        </div>
	        <div class="x_panel">
				<div class="x_title">
					<h2>Media <small>different form elements</small></h2>
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
						<label class="col-xs-12"><?php echo $this->lang->line("news_media"); ?></label>
						<div class="col-xs-12 other_images">
							
			                <ul id="other_images" data-name="gallery">
			                	<?php
			                	if ($arrImages) {
			                	$i = 1;
			                	foreach ($arrImages as $image) {
			                	?>
			                	<li data-count="<?php echo $i; ?>">
			                		<input type="hidden" name="gallery[<?php echo $i; ?>][url]" value="<?php echo $image['images']; ?>"><image src="<?php echo getimglink($image['images'],'size2'); ?>" />
			                		<textarea name="gallery[<?php echo $i; ?>][caption]"><?php echo $image['caption']; ?></textarea>
			                		<i class="fa fa-remove" onclick="delete_parent(this)"></i></li>
			                	<?php $i++;} } ?>
			                </ul>
			                <div class="filemanager_multi_media" data-name="other_images"><i class="fa fa-plus"></i></div>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("news_cate"); ?></label>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("news_date_up"); ?></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input id="publish_time" type="text" name="publish_time" class="form-control" value="<?php echo ($row['publish_time']) ? date('d/m/Y H:i:s',$row['publish_time']) : date('d/m/Y H:i:s'); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3 col-xs-12"><?php echo $this->lang->line("news_theme"); ?></label>
						<div class="col-sm-9 col-xs-12">
							<select name="theme" class="form-control">
	                            <?php foreach ($this->config->item('news_theme') as $key => $theme) { ?>
	                            <option <?php if ($row['theme'] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $theme; ?></option>
	                            <?php } ?>
	                        </select>
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
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("news_seo_title"); ?></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="seo_title" value="<?php echo $row['seo_title']; ?>" placeholder="<?php echo $this->lang->line("news_seo_title"); ?>" class="form-control">
						</div>
	                </div>
	                <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("news_seo_keyword"); ?></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input type="text" name="seo_keyword" value="<?php echo $row['seo_keyword']; ?>" placeholder="<?php echo $this->lang->line("news_seo_keyword"); ?>" class="form-control">
						</div>
	                </div>
	                <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("news_seo_description"); ?></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<textarea name="seo_description" class="form-control" placeholder="<?php echo $this->lang->line("news_seo_description"); ?>" value="" rows="3"><?php echo $row['seo_description']; ?></textarea>
					
						</div>
	                </div>
	                <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("news_tags"); ?></label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input id="news_tag" type="text" class="tags form-control" value="" />
						</div>
					</div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("slug_seo"); ?></label>
                        <div class="col-md-9 col-sm-9 col-xs-12" >
                            <input id="slug_seo" name="slug_seo" title="Tùy chỉnh link - Tối ưu SEO" type="text" class="tags form-control" value="<?php echo $row['slug_seo']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Noindex</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="checkbox">
								<label><input type="checkbox" value="1" <?php echo $row['noindex'] == 1 ? 'checked' : ''; ?> name="noindex"></label>						
							</div>
						</div>
	                </div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php if ($row) { ?>
		<p class="bg-info" style="padding: 10px;">
			<a href="<?php echo BASE_URL . $row['share_url']; ?>"><?php echo BASE_URL . $row['share_url']; ?></a>
		</p>
		<?php } ?>
	</div>
	<div class="row tab-pane" id="news_option">
	    <div class="col-sm-12 col-xs-12">
		    <div class="x_panel">
		    	<div class="x_title">
					<h2>Mô tả</h2>
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
						<label class="control-label col-sm-2 col-xs-12">Lớp học</label>
						<div class="col-sm-10 col-xs-12">
							<div class="category_scroll">
								<?php foreach ($arrGroup as $key => $group) { ?>
								<div class="checkbox">
									<label>
									<input type="checkbox" name="group[]" <?php if ($arrGroupId && in_array($group['class_id'], $arrGroupId)) echo 'checked'; ?> type="checkbox" value="<?php echo $group['class_id']; ?>">
										<?php echo $group['name']; ?>
									</label>
	                        	</div>
								<?php } ?>
							</div>
						</div>
	                </div>

		        </div>
		    </div>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
function generateInputFormSelectBox(name_select,place_holder,arr_data)
{
    // var select = $("<select></select>").attr("placeholder", place_holder).attr("name", "coso");
    var select = $("<select></select>");
    select.append($("<option></option>").attr("value", '').text(place_holder));
    for (var i = 0; i < arr_data.length; i++) {
            var Mono = arr_data[i];
            var option = $("<option></option>").attr("value", Mono['value']).text(Mono['text']).attr("style", Mono['style']);
            if (Mono['disabled'] !== '')
            {
                option.attr('disabled','disabled');
            }
            select.append(option);
    }
    return '<div class="form-group"><select  class="form-control" required=""  name="'+name_select+'" >' + select.html() + '</select></div>';
}


$(document).ready(function() {
	/** TAGS **/
	$('#news_tag').tagsInput({
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
	$('#news_tag').addTag({id: <?php echo $tag['tag_id']; ?>,value: '<?php echo $tag['name']; ?>'});
	<?php }
	} ?>
	/** DATETIME **/
	$('#publish_time').datetimepicker({
		format: 'd/m/Y H:i:s',
		step: 5
	});
	$( "#other_images" ).sortable();
	//$( "#other_images" ).disableSelection();


    /** GetList_brand_Offline_place for Form Template **/


    $.ajax({
        type: 'POST',
        url: document.location.origin + '/admin/news/getbranch',
        data: '', // serializes the form's elements.
        dataType: 'json',
        beforeSend: function() {
        },
        success: function(data)
        {
            /* GET BRANCH - same varname */
            var branch = data['branch'];
            var branch_live = [];
            if (branch !== '')
            {
                branch_live = JSON.parse(branch);
            }

            {
                var arr_location_name =[]; // id_location => name_location
                arr_location_name[1] = 'Hà Nội';
                arr_location_name[2] = 'HCM';
                arr_location_name[3] = 'Đà Nẵng';
                // Định nghĩa thêm id_location ở đây  ->
            }

            var arr_data = [];
            // Phân loại theo location - loc
            $.each(branch_live,function(index,json){
                var id_loc = json.loc;
                if (! arr_data.hasOwnProperty(id_loc))
                {
                    arr_data[id_loc] = [];
                }

                // push vào
                var mono_select = [];
                mono_select['value'] = json.id;
                mono_select['text'] = json.label + ': ' + json.name +' SDT:' + json.phone;
                mono_select['disabled'] = '';
                mono_select['style'] = '';
                arr_data[id_loc].push(mono_select);
            });

            var array_data_generate = [];
            var label_group_more = 'Cơ sở '; /* MOD */

            arr_data.forEach(function (item,index) {
                // Thêm label
                var label_name = arr_location_name[index]; /* MOD */
                var label_group = [];
                label_group['value'] = '';
                label_group['text'] = label_group_more + label_name; /* MOD */
                label_group['disabled'] = 'disabled';
                label_group['style'] = 'font-weight: bold';
                array_data_generate.push(label_group);

                // Thêm phần tử
                array_data_generate = array_data_generate.concat(item);
            });

            var text_select_box1 = generateInputFormSelectBox('coso','Cơ sở đăng ký Test',array_data_generate);  // Form đăng ký Test
            var text_select_box2 = generateInputFormSelectBox('coso','Cơ sở đăng ký nhận tư vấn',array_data_generate);  // Form đăng ký nhận tư vấn


            /* GET OFFLINE PLACE - same varname */
            var offline_place = data['offline_place'];
            var offline_place_live = [];
            if (offline_place !== '')
            {
                offline_place_live = JSON.parse(offline_place);
            }

            {
                var arr_location_name =[]; // id_location => name_location
                arr_location_name[1] = 'Hà Nội';
                arr_location_name[2] = 'HCM';
                arr_location_name[3] = 'Đà Nẵng';
                // Định nghĩa thêm id_location ở đây  ->
            }
            var arr_data = [];
            // Phân loại theo location - loc
            $.each(offline_place_live,function(index,json){
                var id_loc = json.loc;
                if (! arr_data.hasOwnProperty(id_loc))
                {
                    arr_data[id_loc] = [];
                }
                var mono_select = [];
                mono_select['value'] = json.id;
                mono_select['text'] = json.label + ': ' + json.name +' SDT:' + json.phone;
                mono_select['disabled'] = '';
                mono_select['style'] = '';
                arr_data[id_loc].push(mono_select);
            });

            var array_data_generate = [];
            var label_group_more = 'Cơ sở '; /* MOD */
            arr_data.forEach(function (item,index) {
                // Thêm label
                var label_name = arr_location_name[index]; /* MOD */
                var label_group = [];
                label_group['value'] = '';
                label_group['text'] = label_group_more + label_name; /* MOD */
                label_group['disabled'] = 'disabled';
                label_group['style'] = 'font-weight: bold';
                array_data_generate.push(label_group);

                // Thêm phần tử
                array_data_generate = array_data_generate.concat(item);
            });
            var text_select_box3 = generateInputFormSelectBox('offline_place','Cơ sở đăng ký tham gia',array_data_generate);

            {
                // Select khu vực bạn sống
                var arr_data_live_area = [];

                var mono___ = [];
                mono___['text'] = 'Hà Nội';
                mono___['value'] = 'Hà Nội';
                mono___['style'] = '';
                mono___['disabled'] = '';
                arr_data_live_area.push(mono___);

                var mono___ = [];
                mono___['text'] = 'Hồ Chí Minh';
                mono___['value'] = 'Hồ Chí Minh';
                mono___['style'] = '';
                mono___['disabled'] = '';
                arr_data_live_area.push(mono___);

                var mono___ = [];
                mono___['text'] = 'Đà Nẵng';
                mono___['value'] = 'Đà Nẵng';
                mono___['style'] = '';
                mono___['disabled'] = '';
                arr_data_live_area.push(mono___);

                var text_select_box4 = generateInputFormSelectBox('living_area','Khu vực bạn đang ở',arr_data_live_area);

            }
            // MOD thành phần của form
            var name_div = '<div class="form-group"><input class="form-control" type="text" required="" name="fullname"  placeholder="Họ và tên"></div>';
            var phone_div = '<div class="form-group"><input class="form-control" type="text" required="" name="phone" placeholder="Số điện thoại"></div>';
            var email_div = '<div class="form-group"><input class="form-control" type="text" name="email" placeholder="Email"></div>';
            var date_of_birth = '<div class="form-group"><input  placeholder="Ngày sinh"  type="text" onfocus="(this.type=\'date\')"   class="form-control"  name="dateofbirth" style="width: 100%;"></div>';
            var url_now = '<div class="form-group hidden" style="display: none"><input id="url_form_target" class="form-control" type="text" name="url"  placeholder="Url" value=""></div>';
            var btn_submit = '<div style="text-align:center"><button class="btn btn-warning btn_send" type="submit" id="tuvan_submit" style="width: 100%;background-color: orange; color: white;">Gửi</button></div>';

            var select_co_so_test = text_select_box1;
            var select_co_so_nhan_tu_van = text_select_box2;
            var select_co_so_event_offline = text_select_box3;
            var select_living_area = text_select_box4;

            // ======================
            var site_url = '<?php
                if(isset($_SERVER['HTTPS'])){
                    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
                }
                else{
                    $protocol = 'http';
                }
                echo $protocol . "://" . $_SERVER['HTTP_HOST'];
                ?>';

            // Note: cần xử lý đầy đủ event submit cho danh sách các id form trong common.js
            // tuvan_form_new test_contact_form document_earn_form event_offline_form
            CKEDITOR.addTemplates("default", {
                imagesPath: CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates") + "templates/images/"),
                templates: [
                    {
                        title: "Form đăng ký Test",
                        image: "template1.gif",
                        description: "Mẫu đăng ký Test",
                        html: '<div style="text-align: center !important;"> ' +
                            '<div class="form_template" style=" display: inline-block; border: 2px solid rgb(224, 23, 23); padding: 20px; width: 400px; resize: both; overflow: auto; max-width: 100%;  "> ' +
                            '<h3 class="text-uppercase" style="color: #1a80d1;">Mẫu đăng ký thông tin nhận test</h3> ' +
                            '<form style="" id="test_contact_form" method="POST" action="' +site_url+ '/contact/tuvan?type=test_contact_form">'+
                            '<div class="form-group"><input name="form_type" value="form_dang_ky_test" class="form-control" type="text" required="" style="display: none; height: 0;"></div>' +
                            name_div + phone_div + email_div + date_of_birth + select_co_so_test + url_now +  btn_submit +
                            '</form>' +
                            '</div>' +
                            '</div>'
                        ,
                    },
                    {
                        title: "Form đăng ký nhận tư vấn",
                        image: "template1.gif",
                        description: "Form đăng ký nhận tư vấn",
                        html: '<div style="text-align: center !important;"> ' +
                            '<div class="form_template" style=" display: inline-block; border: 2px solid rgb(224, 23, 23); padding: 20px; width: 400px; resize: both; overflow: auto; max-width: 100%;  "> ' +
                            '<h3 class="text-uppercase" style="color: #1a80d1;" >Mẫu đăng ký nhận tư vấn</h3>' +
                            '<form style="" id="tuvan_form_new" method="POST" action="' +site_url+ '/contact/tuvan?type=tuvan_form_new">' +
                            '<div class="form-group"><input name="form_type" value="form_dang_ky_tu_van" class="form-control" type="text" required="" style="display: none"></div>' +
                            name_div + phone_div + email_div + date_of_birth + select_co_so_nhan_tu_van + url_now + btn_submit +
                            '</form>' +
                            '</div>' +
                            '</div>',
                    },
                    {
                        title: "Form đăng ký tham gia Offline",
                        image: "template1.gif",
                        description: "Form đăng ký tham gia Offline",
                        html: '<div style="text-align: center !important;"> ' +
                            '<div class="form_template" style=" display: inline-block; border: 2px solid rgb(224, 23, 23); padding: 20px; width: 400px; resize: both; overflow: auto; max-width: 100%;  "> ' +
                            '<h3 class="text-uppercase"  style="color: #1a80d1;">Mẫu đăng ký tham gia Offline</h3> ' +
                            '<form style="" id="event_offline_form" method="POST" action="' +site_url+ '/contact/tuvan?type=event_offline_form">' +
                            '<input name="form_type" value="form_dang_ky_offline" class="form-control" type="text" required="" style="display: none">' +
                            name_div + phone_div + email_div + date_of_birth + select_co_so_event_offline + url_now + btn_submit +
                            '</form>' +
                            '</div>' +
                            '</div>',
                    },
                    {
                        title: "Form đăng ký nhận tài liệu",
                        image: "template1.gif",
                        description: "Form đăng ký nhận tài liệu",
                        html: '<div style="text-align: center !important;">' +
                            '<div class="form_template" style=" display: inline-block; border: 2px solid rgb(224, 23, 23); padding: 20px; width: 400px; resize: both; overflow: auto; max-width: 100%;  "> ' +
                            '<h3 class="text-uppercase"  style="color: #1a80d1;" >Mẫu đăng ký nhận tài liệu</h3> ' +
                            '<form style="" id="document_earn_form" method="POST" action="' +site_url+ '/contact/tuvan?type=document_earn_form">' +
                            '<input name="form_type" value="form_dang_ky_tai_lieu" class="form-control" type="text" required="" style="display: none">' +
                            name_div + phone_div + email_div + date_of_birth + select_living_area + url_now + btn_submit +
                            '</form>' +
                            '</div>' +
                            '</div>',
                    },
                ]
            });
        },
        error: function(e){
            show_notify_error();
            progress_loading.hide();
        }
    });

    $("#product_params").find(".icon_plus").bind("click",function(){
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



});



</script>