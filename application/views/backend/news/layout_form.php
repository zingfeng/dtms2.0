<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
$arrCateType = $this->config->item('cate_type');
?>
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<?php if ($this->permission->check_permission_backend('index')) {?>
	<a class="btn btn-primary" href="<?php echo SITE_URL; ?>/news/index"><?php echo $this->lang->line("common_mod_news_index"); ?></a>
	<?php } ?>
</div>
<div class="row">
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
                <div class="form-group validation_original_cate">
					<label class="control-label col-sm-2 col-xs-12">Loại bài viết</label>
					<div class="col-sm-10 col-xs-12 validation_form">
						<select id="news_select_layout" name="news_type" class="select2_single form-control" placeholder="Loại bài viết" tabindex="-1">
							<option value="0">Chọn loại bài viết</option>
							<?php foreach ($arrCateType as $key => $cateType) { 
								if ($cateType['module'] != 'news') continue;
								?>
								<option value="<?php echo $key; ?>"><?php echo $cateType['name']; ?></option>
							<?php } ?>
                            
                         
                        </select>
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#news_select_layout").bind("change",function() {
		var type = $(this).val();
		redirect('<?php echo SITE_URL; ?>/news/add/' + type )
	})
</script>