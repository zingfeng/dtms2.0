<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$arrCateType = $this->config->item('cate_type');
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('cate_index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/category/index?type=<?php echo $row['type']; ?>"><?php echo $this->lang->line("common_mod_category_index"); ?></a>
	<?php } ?>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<?php if ($row['cate_id']) { ?>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post($row['cate_id']) ?>"/>
	<?php } ?>
</div>
<div class="row">
	<div class="col-md-7 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2><?php echo $this->lang->line('common_mod_category_cate'); ?></small></h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content row">
				<div class="form-group validation_name">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("category_cate_name"); ?> *</label>
					<div class="col-md-9 col-sm-9 col-xs-12 validation_form">
						<input required type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="<?php echo $this->lang->line("category_cate_name"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("category_cate_type"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<?php if (!$row['type']) { ?>
						<select id="category_type_select" name="type" class="form-control" placeholder="<?php echo $this->lang->line("category_cate_type"); ?>" tabindex="-1">
                            <?php foreach ($arrCateType as $key => $cateType) { ?>
                            <option <?php if ($row['type'] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo $cateType['name']; ?></option>
                            <?php } ?>
                        </select>
                        <?php } else {?> 
                        <input type="text" class="form-control" disabled="" value="<?php echo $arrCateType[$row['type']]['name']; ?>">
                    	<?php } ?>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("category_cate_parent"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select id="category_select" name="parent" class="select2_single form-control" placeholder="<?php echo $this->lang->line("category_cate_select_parent"); ?>" tabindex="-1">
                            <option value="0"><?php echo $this->lang->line("category_cate_select_parent"); ?></option>
                            <?php foreach ($arrCate as $key => $cate) { ?>
                            <option <?php if ($row['parent'] == $cate['cate_id']) echo 'selected'; ?> value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['name']; ?></option>
                            <?php } ?>
                        </select>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("category_cate_images"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12 filemanager_media">
						<img class="image_org" data-name="category_image" data-type="image" data-selected="<?php echo $row['images']; ?>" src="<?php echo ($row['images']) ? getimglink($row['images'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
						<i class="fa fa-remove image_delete"></i>
						<input type="hidden" name="images" value="<?php echo $row['images']; ?>" />
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Icon</label>
					<div class="col-md-9 col-sm-9 col-xs-12 filemanager_media">
						<img class="image_org" data-name="category_icon" data-type="image" data-selected="<?php echo $row['icon']; ?>" src="<?php echo ($row['icon']) ? getimglink($row['icon'],'size2') : $this->config->item("img").'default_image.jpg'; ?>">
						<i class="fa fa-remove image_delete"></i>
						<input type="hidden" name="icon" value="<?php echo $row['icon']; ?>" />
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("category_cate_ordering"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="ordering" value="<?php echo (int) $row['ordering']; ?>" placeholder="<?php echo $this->lang->line("category_cate_ordering"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group" id="category_hide" style="display: <?php echo ($row['type'] == 2) ? 'block' : 'none' ?>">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Ẩn bên ngoài</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="checkbox">
							<label><input type="checkbox" value="1" <?php echo ($row['hide_folder'] == 1) ? 'checked' : ''; ?> name="hide_folder"></label>						
						</div>
					</div>
                </div>
                <div class="form-group" id="category_style" style="display: <?php echo ($row['type'] == 1 || !isset($row['type'])) ? 'block' : 'none' ?>">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Style</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select name="style" class="form-control" placeholder="Style" tabindex="-1">
                            <option value="1" <?php echo ($row['style'] == 1) ?'selected':'';?>>Tin tức thường</option>
                            <option value="2" <?php echo ($row['style'] == 2) ?'selected':'';?>>Tin video</option>
                        </select>
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Show home</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select name="show_home" class="select2_single form-control" placeholder="Show home" tabindex="-1">
                            <option value="0" <?php echo ($row['show_home'] == 0) ?'selected':'';?>>Hide</option>
                            <option value="1" <?php echo ($row['show_home'] == 1) ?'selected':'';?>>Show</option>
                        </select>
					</div>
                </div>
                <div class="form-group ckeditor_detail">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("category_cate_description"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12" >
						<textarea name="description" class="form-control" placeholder="<?php echo $this->lang->line("category_cate_description"); ?>" rows="3"><?php echo $row['description']; ?></textarea>
					</div>
                </div>
			</div>
		</div>
	</div>
	<div class="col-md-5 col-xs-12">
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("category_seo_title"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_title" value="<?php echo $row['seo_title']; ?>" placeholder="<?php echo $this->lang->line("category_seo_title"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("category_seo_keyword"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="seo_keyword" value="<?php echo $row['seo_keyword']; ?>" placeholder="<?php echo $this->lang->line("category_seo_keyword"); ?>" class="form-control">
					</div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("category_seo_description"); ?></label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="seo_description" class="form-control" placeholder="<?php echo $this->lang->line("category_seo_description"); ?>" value="" rows="3"><?php echo $row['seo_description']; ?></textarea>
				
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
	$('#category_type_select').change(function(){
		var type_id = $(this).val();
		$.ajax( {
	        type: "GET",
	        url: '<?php echo SITE_URL; ?>/category/gettype',
	        data: {type_id: type_id},
	        dataType: "json",
	    }).done(function( data ) {
	    	console.log(type_id);
	    	if (type_id == 1) {
	    		$("#category_style").show();
	    	}
	    	else {
	    		$("#category_style").find("select").val(1);
	    		$("#category_style").hide();
	    	}
	    	if (type_id == 2)  {
	    		$("#category_hide").show();
	    	} else {
	    		$("#category_hide").hide();
	    		$("#category_hide").find("input").prop('checked', false); // Unchecks it
	    	}
	    	if(data.status =='success'){
	    		$("#category_select").select2("val", "");
        		$('#category_select').empty();
        		var arrData = data.data;
        		console.log(arrData);
        		//$('#category_select').empty();
        		$('#category_select').append('<option selected value="0"><?php echo $this->lang->line("category_cate_select_parent"); ?></option>');
        		$.each(arrData, function( index, value ) {
				 	$('#category_select').append('<option value="'+value.cate_id+'">'+value.name+'</option>');
				});
	        } else {
	        	alert('Đã có lỗi hệ thống');
	        }
	    });
	});
</script>