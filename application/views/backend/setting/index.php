<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->config('data');
?>
<form class="form-horizontal form-label-left ajax-submit-form" action="" method="POST">
<div class="form-group">	
	<button class="btn btn-primary" onclick="goBack();" type="button">Back</button>
	<button class="btn btn-success ajax-submit-button" type="submit"><?php echo $this->lang->line("common_save"); ?></button>
	<input  type="hidden" name="token" value="<?php echo $this->security->generate_token_post(SITE_ID) ?>"/>
</div>
<div class="row">
	<ul class="nav nav-tabs col-xs-12" role="tablist" style="margin-bottom: 20px;">
		<li class="active"><a href="#step1" role="tab" data-toggle="tab">Cấu hình hệ thống</a></li>
		<li><a href="#step2" role="tab" data-toggle="tab">Hệ thống</a></li>
		<li><a href="#step3" role="tab" data-toggle="tab">Mã nhúng</a></li>
	</ul>
	<div class="tab-content">
		<div id="step1" class="tab-pane active" role="tabpanel">
			<div class="col-sm-7 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Form Design <small>different form elements</small></h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>
							<li><a class="close-link"><i class="fa fa-close"></i></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content row">
						<div class="form-group validation_email_admin">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("setting_email_admin"); ?> *</label>
							<div class="col-md-9 col-sm-9 col-xs-12 validation_form">
								<input required type="text" name="email_admin" value="<?php echo $row['email_admin']; ?>" placeholder="<?php echo $this->lang->line("setting_email_admin"); ?>" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("setting_email_host"); ?> *</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="email_host" value="<?php echo $row['email_host']; ?>" placeholder="<?php echo $this->lang->line("setting_email_host"); ?>" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("setting_email_username"); ?> *</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="email_username" value="<?php echo $row['email_username']; ?>" placeholder="<?php echo $this->lang->line("setting_email_username"); ?>" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("setting_email_password"); ?> *</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="password" name="email_password" value="<?php echo $row['email_password']; ?>" placeholder="<?php echo $this->lang->line("setting_email_password"); ?>" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Hotline</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="hotline" value="<?php echo $row['hotline']; ?>" placeholder="Hotline" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Email support</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="email_support" value="<?php echo $row['email_support']; ?>" placeholder="Email support" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="facebook" value="<?php echo $row['facebook']; ?>" placeholder="Facebook" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Twitter</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="twitter" value="<?php echo $row['twitter']; ?>" placeholder="Twitter" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Google plus</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="google" value="<?php echo $row['google']; ?>" placeholder="Google plus" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Youtube</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="youtube" value="<?php echo $row['youtube']; ?>" placeholder="Youtube" class="form-control">
							</div>
		                </div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Bảng quy điểm</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="score_table" value="<?php echo $row['score_table']; ?>" placeholder="Link bảng quy điểm" class="form-control">
							</div>
		                </div>
					</div>
                    <div class="x_content row">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Link redirect test speaking</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="link_speaking" value="<?php echo $row['link_speaking'];; ?>" placeholder="Link redirect test speaking" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="x_content row">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Link redirect test writing</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="link_writing" value="<?php echo $row['link_writing'];; ?>" placeholder="Link redirect test writing" class="form-control">
                            </div>
                        </div>
                    </div>

				</div>
			</div>
			<div class="col-sm-5 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>SEO</h2>
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("setting_seo_title"); ?></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="seo_title" value="<?php echo $row['seo_title']; ?>" placeholder="<?php echo $this->lang->line("setting_seo_title"); ?>" class="form-control">
							</div>
		                </div>
		                <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("setting_seo_keyword"); ?></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="seo_keyword" value="<?php echo $row['seo_keyword']; ?>" placeholder="<?php echo $this->lang->line("setting_seo_keyword"); ?>" class="form-control">
							</div>
		                </div>
		                <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("setting_seo_description"); ?></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea name="seo_description" class="form-control" placeholder="<?php echo $this->lang->line("setting_seo_description"); ?>" value="" rows="3"><?php echo $row['seo_description']; ?></textarea>
						
							</div>
		                </div>
					</div>
				</div>
			</div>
		</div>
		<div id="step2" class="tab-pane" role="tabpanel">
			<div class="col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Các cơ sở</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line("setting_seo_title"); ?></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php 
								$arrBranch = json_decode($row['branch'],TRUE);
								$j = 0;
								if($arrBranch) {
								foreach ($arrBranch as $key => $branch) { ?>
									<div class="item form-inline" style="margin-bottom: 10px;">
										<input type="text" name="branch[<?php echo $j; ?>][id]" value="<?php echo $branch['id']; ?>" placeholder="Id" class="form-control">
										<input type="text" name="branch[<?php echo $j; ?>][label]" value="<?php echo $branch['label']; ?>" placeholder="Nhãn" class="form-control">
										<input type="text" name="branch[<?php echo $j; ?>][address]" value="<?php echo $branch['address']; ?>" placeholder="Địa chỉ" class="form-control">
										<input type="text" name="branch[<?php echo $j; ?>][iframe_map]" value="<?php echo $branch['iframe_map']; ?>" placeholder="Link Google Map" class="form-control">
										<input type="text" name="branch[<?php echo $j; ?>][time_open]" value="<?php echo $branch['time_open']; ?>" placeholder="Thời gian mở cửa - ; để xuống dòng" class="form-control">
										<input type="text" name="branch[<?php echo $j; ?>][name]" value="<?php echo $branch['name']; ?>" placeholder="Tên" class="form-control">
										<input type="text" name="branch[<?php echo $j; ?>][phone]" value="<?php echo $branch['phone']; ?>" placeholder="Điện thoại" class="form-control">
										<select name="branch[<?php echo $j; ?>][loc]" class="form-control">
											<option value="1" <?php if ($branch['loc'] == 1) echo 'selected'; ?>>Hà Nội</option>
											<option value="2" <?php if ($branch['loc'] == 2) echo 'selected'; ?>>HCM</option>
											<option value="3" <?php if ($branch['loc'] == 3) echo 'selected'; ?>>Đà nẵng</option>
										</select>
									</div>
								<?php $j ++; } }
								for ($i = $j; $i < 20; $i ++) { ?>
								<div class="item form-inline" style="margin-bottom: 10px;">
									<input type="text" name="branch[<?php echo $i; ?>][id]" value="" placeholder="Id" class="form-control">
									<input type="text" name="branch[<?php echo $i; ?>][label]" value="" placeholder="Nhãn" class="form-control">
									<input type="text" name="branch[<?php echo $i; ?>][name]" value="" placeholder="Tên" class="form-control">
									<input type="text" name="branch[<?php echo $i; ?>][phone]" value="" placeholder="Điện thoại" class="form-control">
									<select name="branch[<?php echo $i; ?>][loc]" class="form-control">
										<option value="1">Hà Nội</option>
										<option value="2">HCM</option>
										<option value="3">Đà nẵng</option>
									</select>
								</div>
								<?php } ?>
							</div>
		                </div>
					</div>
				</div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Các địa điểm Offline</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content row">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php //echo $this->lang->line("setting_seo_title"); ?></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
                                $arrOffline = json_decode($row['offline_place'],TRUE);
                                $j = 0;
                                if($arrOffline) {
                                    foreach ($arrOffline as $key => $place) { ?>
                                        <div class="item form-inline" style="margin-bottom: 10px;">
                                            <input type="text" name="offlineplace[<?php echo $j; ?>][id]" value="<?php echo $place['id']; ?>" placeholder="Id" class="form-control">
                                            <input type="text" name="offlineplace[<?php echo $j; ?>][label]" value="<?php echo $place['label']; ?>" placeholder="Nhãn" class="form-control">
                                            <input type="text" name="offlineplace[<?php echo $j; ?>][name]" value="<?php echo $place['name']; ?>" placeholder="Tên" class="form-control">
                                            <input type="text" name="offlineplace[<?php echo $j; ?>][phone]" value="<?php echo $place['phone']; ?>" placeholder="Điện thoại" class="form-control">
                                            <select name="offlineplace[<?php echo $j; ?>][loc]" class="form-control">
                                                <option value="1" <?php if ($place['loc'] == 1) echo 'selected'; ?>>Hà Nội</option>
                                                <option value="2" <?php if ($place['loc'] == 2) echo 'selected'; ?>>HCM</option>
                                                <option value="3" <?php if ($place['loc'] == 3) echo 'selected'; ?>>Đà nẵng</option>
                                            </select>
                                        </div>
                                        <?php $j ++; } }
                                for ($i = $j; $i < 20; $i ++) { ?>
                                    <div class="item form-inline" style="margin-bottom: 10px;">
                                        <input type="text" name="offlineplace[<?php echo $i; ?>][id]" value="" placeholder="Id" class="form-control">
                                        <input type="text" name="offlineplace[<?php echo $i; ?>][label]" value="" placeholder="Nhãn" class="form-control">
                                        <input type="text" name="offlineplace[<?php echo $i; ?>][name]" value="" placeholder="Tên" class="form-control">
                                        <input type="text" name="offlineplace[<?php echo $i; ?>][phone]" value="" placeholder="Điện thoại" class="form-control">
                                        <select name="offlineplace[<?php echo $i; ?>][loc]" class="form-control">
										<option value="1">Hà Nội</option>
										<option value="2">HCM</option>
										<option value="3">Đà nẵng</option>
									</select>
								</div>
								<?php } ?>
							</div>
		                </div>
					</div>
				</div>
			</div>
		</div>
		<div id="step3" class="tab-pane" role="tabpanel">
			<div class="col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Mã nhúng</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content row">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Mã nhúng trên header</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea class="form-control" rows="10" name="tracking_code_header"><?php echo $row['tracking_code_header']; ?></textarea>
							</div>
		                </div>
		                <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Mã nhúng dưới body</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<textarea class="form-control" rows="10" name="tracking_code_footer"><?php echo $row['tracking_code_footer']; ?></textarea>
							</div>
		                </div>
					</div>
				</div>
			</div>
		</div>
        <div id="step4" class="tab-pane" role="tabpanel">
            <div class="col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Reading</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content row">
                        <div class="form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12"></label>
                            <div class="col-md-11 col-sm-11 col-xs-12">
                                <?php
                                $arrReading = unserialize($row['reading']);
                                $j = 0;
                                if($arrReading) {
                                    foreach ($arrReading as $key => $reading) { ?>
                                        <div class="item form-inline" style="margin-bottom: 10px;">
                                            <div class="container-fluid" style="margin-bottom: 60px;">
                                                <div class="row" style="margin-bottom: 10px;">
                                                    <div class="col-sm-12" style="">
                                                        &bull; Điểm số từ  <input type="number" step="0.5" min="0" max="9" name="reading[<?php echo $j; ?>][from]" value="<?php echo $reading['from']; ?>" placeholder="Từ điểm" class="form-control" style="margin-left: 8px;margin-right: 8px;">
                                                        Đến <input type="number" step="0.5" min="0" max="9"  name="reading[<?php echo $j; ?>][to]" value="<?php echo $reading['to']; ?>" placeholder="Đến điểm" class="form-control"  style="margin-left: 8px;margin-right: 8px;">

                                                    </div>

                                                </div>
                                                <div class="row" style="">
                                                    <p style="font-style: italic; margin: 0;padding: 2px 10px;">Reading</p>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea" type="text" rows=3 name="reading[<?php echo $j; ?>][result]" value="<?php echo $reading['result']; ?>" placeholder="Kết quả, nhận xét" class="form-control" style="min-width: 400px;"><?php echo $reading['result']; ?></textarea>

                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea"   type="text" rows=3 name="reading[<?php echo $j; ?>][suggest]" value="<?php echo $reading['suggest']; ?>" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"><?php echo $reading['suggest']; ?></textarea>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <?php $j ++; } }
                                for ($i = $j; $i < 10; $i ++) { ?>
                                    <div class="item form-inline" style="margin-bottom: 10px;">
                                        <input type="number" step="0.5" min="0" max="9" name="reading[<?php echo $i; ?>][from]" value="" placeholder="Từ điểm" class="form-control">
                                        <input type="number" step="0.5" min="0" max="9"  name="reading[<?php echo $i; ?>][to]" value="" placeholder="Đến điểm" class="form-control">
                                        <textarea class="ckeditor_textarea"  type="text" rows=3 name="reading[<?php echo $i; ?>][result]" value="" placeholder="Kết quả, nhận xét" class="form-control"  style="min-width: 400px;"></textarea>
                                        <textarea class="ckeditor_textarea"  type="text" rows=3 name="reading[<?php echo $i; ?>][suggest]" value="" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"></textarea>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Writing</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content row">
                        <div class="form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12"></label>
                            <div class="col-md-11 col-sm-11 col-xs-12">
                                <?php
                                $arrwriting = json_decode($row['writing'],TRUE);                                $j = 0;
                                if($arrwriting) {
                                    foreach ($arrwriting as $key => $writing) { ?>
<!--                                        <div class="item form-inline" style="margin-bottom: 10px;">-->
<!--                                            <input type="number" step="0.5" min="0" max="9" name="writing[--><?php //echo $j; ?><!--][from]" value="--><?php //echo $writing['from']; ?><!--" placeholder="Từ điểm" class="form-control">-->
<!--                                            <input type="number" step="0.5" min="0" max="9"  name="writing[--><?php //echo $j; ?><!--][to]" value="--><?php //echo $writing['to']; ?><!--" placeholder="Đến điểm" class="form-control">-->
<!--                                            <textarea type="text" rows=3 name="writing[--><?php //echo $j; ?><!--][result]" value="--><?php //echo $writing['result']; ?><!--" placeholder="Kết quả, nhận xét" class="form-control" style="min-width: 400px;">--><?php //echo $writing['result']; ?><!--</textarea>-->
<!--                                            <textarea type="text" rows=3 name="writing[--><?php //echo $j; ?><!--][suggest]" value="--><?php //echo $writing['suggest']; ?><!--" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;">--><?php //echo $writing['suggest']; ?><!--</textarea>-->
<!--                                        </div>-->


                                        <div class="item form-inline" style="margin-bottom: 10px;">
                                            <div class="container-fluid" style="margin-bottom: 60px;">
                                                <div class="row" style="margin-bottom: 10px;">
                                                    <div class="col-sm-12" style="">
                                                        &bull; Điểm số từ  <input type="number" step="0.5" min="0" max="9" name="writing[<?php echo $j; ?>][from]" value="<?php echo $writing['from']; ?>" placeholder="Từ điểm" class="form-control" style="margin-left: 8px;margin-right: 8px;">
                                                        Đến <input type="number" step="0.5" min="0" max="9"  name="writing[<?php echo $j; ?>][to]" value="<?php echo $writing['to']; ?>" placeholder="Đến điểm" class="form-control"  style="margin-left: 8px;margin-right: 8px;">

                                                    </div>

                                                </div>
                                                <div class="row" style="">
                                                    <p style="font-style: italic; margin: 0;padding: 2px 10px;">Writing</p>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea" type="text" rows=3 name="writing[<?php echo $j; ?>][result]" value="<?php echo $writing['result']; ?>" placeholder="Kết quả, nhận xét" class="form-control" style="min-width: 400px;"><?php echo $writing['result']; ?></textarea>

                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea"   type="text" rows=3 name="writing[<?php echo $j; ?>][suggest]" value="<?php echo $writing['suggest']; ?>" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"><?php echo $writing['suggest']; ?></textarea>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        
                                        <?php $j ++; } }
                                for ($i = $j; $i < 10; $i ++) { ?>
                                    <div class="item form-inline" style="margin-bottom: 10px;">
                                        <input type="number" step="0.5" min="0" max="9" name="writing[<?php echo $i; ?>][from]" value="" placeholder="Từ điểm" class="form-control">
                                        <input type="number" step="0.5" min="0" max="9"  name="writing[<?php echo $i; ?>][to]" value="" placeholder="Đến điểm" class="form-control">
                                        <textarea type="text" rows=3 name="writing[<?php echo $i; ?>][result]" value="" placeholder="Kết quả, nhận xét" class="form-control"  style="min-width: 400px;"></textarea>
                                        <textarea type="text" rows=3 name="writing[<?php echo $i; ?>][suggest]" value="" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"></textarea>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Listening</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content row">
                        <div class="form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12"></label>
                            <div class="col-md-11 col-sm-11 col-xs-12">
                          <?php
                                $arrlistening = json_decode($row['listening'],TRUE);
                                $j = 0;
                                if($arrlistening) {
                                    foreach ($arrlistening as $key => $listening) { ?>
<!--                                        <div class="item form-inline" style="margin-bottom: 10px;">-->
<!--                                            <input type="number" step="0.5" min="0" max="9" name="listening[--><?php //echo $j; ?><!--][from]" value="--><?php //echo $listening['from']; ?><!--" placeholder="Từ điểm" class="form-control">-->
<!--                                            <input type="number" step="0.5" min="0" max="9"  name="listening[--><?php //echo $j; ?><!--][to]" value="--><?php //echo $listening['to']; ?><!--" placeholder="Đến điểm" class="form-control">-->
<!--                                            <textarea type="text" rows=3 name="listening[--><?php //echo $j; ?><!--][result]" value="--><?php //echo $listening['result']; ?><!--" placeholder="Kết quả, nhận xét" class="form-control" style="min-width: 400px;">--><?php //echo $listening['result']; ?><!--</textarea>-->
<!--                                            <textarea type="text" rows=3 name="listening[--><?php //echo $j; ?><!--][suggest]" value="--><?php //echo $listening['suggest']; ?><!--" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;">--><?php //echo $listening['suggest']; ?><!--</textarea>-->
<!--                                        </div>-->

                                        <div class="item form-inline" style="margin-bottom: 10px;">
                                            <div class="container-fluid" style="margin-bottom: 60px;">
                                                <div class="row" style="margin-bottom: 10px;">
                                                    <div class="col-sm-12" style="">
                                                        &bull; Điểm số từ  <input type="number" step="0.5" min="0" max="9" name="listening[<?php echo $j; ?>][from]" value="<?php echo $listening['from']; ?>" placeholder="Từ điểm" class="form-control" style="margin-left: 8px;margin-right: 8px;">
                                                        Đến <input type="number" step="0.5" min="0" max="9"  name="listening[<?php echo $j; ?>][to]" value="<?php echo $listening['to']; ?>" placeholder="Đến điểm" class="form-control"  style="margin-left: 8px;margin-right: 8px;">
                                                    </div>

                                                </div>
                                                <div class="row" style="">
                                                    <p style="font-style: italic; margin: 0;padding: 2px 10px;">Listening</p>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea" type="text" rows=3 name="listening[<?php echo $j; ?>][result]" value="<?php echo $listening['result']; ?>" placeholder="Kết quả, nhận xét" class="form-control" style="min-width: 400px;"><?php echo $listening['result']; ?></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea"   type="text" rows=3 name="listening[<?php echo $j; ?>][suggest]" value="<?php echo $listening['suggest']; ?>" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"><?php echo $listening['suggest']; ?></textarea>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        
                                        
                                        <?php $j ++; } }
                                for ($i = $j; $i < 10; $i ++) { ?>
                                    <div class="item form-inline" style="margin-bottom: 10px;">
                                        <input type="number" step="0.5" min="0" max="9" name="listening[<?php echo $i; ?>][from]" value="" placeholder="Từ điểm" class="form-control">
                                        <input type="number" step="0.5" min="0" max="9"  name="listening[<?php echo $i; ?>][to]" value="" placeholder="Đến điểm" class="form-control">
                                        <textarea type="text" rows=3 name="listening[<?php echo $i; ?>][result]" value="" placeholder="Kết quả, nhận xét" class="form-control"  style="min-width: 400px;"></textarea>
                                        <textarea type="text" rows=3 name="listening[<?php echo $i; ?>][suggest]" value="" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"></textarea>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Speaking</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content row">
                        <div class="form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12"></label>
                            <div class="col-md-11 col-sm-11 col-xs-12">
                                <?php
                                $arrspeaking = json_decode($row['speaking'],TRUE);
                                $j = 0;
                                if($arrspeaking) {
                                    foreach ($arrspeaking as $key => $speaking) { ?>
                                        
                                        
<!--                                        <div class="item form-inline" style="margin-bottom: 10px;">-->
<!--                                            <input type="number" step="0.5" min="0" max="9" name="speaking[--><?php //echo $j; ?><!--][from]" value="--><?php //echo $speaking['from']; ?><!--" placeholder="Từ điểm" class="form-control">-->
<!--                                            <input type="number" step="0.5" min="0" max="9"  name="speaking[--><?php //echo $j; ?><!--][to]" value="--><?php //echo $speaking['to']; ?><!--" placeholder="Đến điểm" class="form-control">-->
<!--                                            <textarea type="text" rows=3 name="speaking[--><?php //echo $j; ?><!--][result]" value="--><?php //echo $speaking['result']; ?><!--" placeholder="Kết quả, nhận xét" class="form-control" style="min-width: 400px;">--><?php //echo $speaking['result']; ?><!--</textarea>-->
<!--                                            <textarea type="text" rows=3 name="speaking[--><?php //echo $j; ?><!--][suggest]" value="--><?php //echo $speaking['suggest']; ?><!--" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;">--><?php //echo $speaking['suggest']; ?><!--</textarea>-->
<!--                                        </div>-->

                                        <div class="item form-inline" style="margin-bottom: 10px;">
                                            <div class="container-fluid" style="margin-bottom: 60px;">
                                                <div class="row" style="margin-bottom: 10px;">
                                                    <div class="col-sm-12" style="">
                                                        &bull; Điểm số từ  <input type="number" step="0.5" min="0" max="9" name="speaking[<?php echo $j; ?>][from]" value="<?php echo $speaking['from']; ?>" placeholder="Từ điểm" class="form-control" style="margin-left: 8px;margin-right: 8px;">
                                                        Đến <input type="number" step="0.5" min="0" max="9"  name="speaking[<?php echo $j; ?>][to]" value="<?php echo $speaking['to']; ?>" placeholder="Đến điểm" class="form-control"  style="margin-left: 8px;margin-right: 8px;">
                                                    </div>

                                                </div>
                                                <div class="row" style="">
                                                    <p style="font-style: italic; margin: 0;padding: 2px 10px;">Speaking</p>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea" type="text" rows=3 name="speaking[<?php echo $j; ?>][result]" value="<?php echo $speaking['result']; ?>" placeholder="Kết quả, nhận xét" class="form-control" style="min-width: 400px;"><?php echo $speaking['result']; ?></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea"   type="text" rows=3 name="speaking[<?php echo $j; ?>][suggest]" value="<?php echo $speaking['suggest']; ?>" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"><?php echo $speaking['suggest']; ?></textarea>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        
                                        <?php $j ++; } }
                                for ($i = $j; $i < 10; $i ++) { ?>
                                    <div class="item form-inline" style="margin-bottom: 10px;">
                                        <input type="number" step="0.5" min="0" max="9" name="speaking[<?php echo $i; ?>][from]" value="" placeholder="Từ điểm" class="form-control">
                                        <input type="number" step="0.5" min="0" max="9"  name="speaking[<?php echo $i; ?>][to]" value="" placeholder="Đến điểm" class="form-control">
                                        <textarea type="text" rows=3 name="speaking[<?php echo $i; ?>][result]" value="" placeholder="Kết quả, nhận xét" class="form-control"  style="min-width: 400px;"></textarea>
                                        <textarea type="text" rows=3 name="speaking[<?php echo $i; ?>][suggest]" value="" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"></textarea>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Fulltest</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content row">
                        <div class="form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12"></label>
                            <div class="col-md-11 col-sm-11 col-xs-12">
                                <?php
                                $arrfulltest = json_decode($row['fulltest'],TRUE);
                                $j = 0;
                                if($arrfulltest) {
                                    foreach ($arrfulltest as $key => $fulltest) { ?>
<!--                                        <div class="item form-inline" style="margin-bottom: 10px;">-->
<!--                                            <input type="number" step="0.5" min="0" max="9" name="fulltest[--><?php //echo $j; ?><!--][from]" value="--><?php //echo $fulltest['from']; ?><!--" placeholder="Từ điểm" class="form-control">-->
<!--                                            <input type="number" step="0.5" min="0" max="9"  name="fulltest[--><?php //echo $j; ?><!--][to]" value="--><?php //echo $fulltest['to']; ?><!--" placeholder="Đến điểm" class="form-control">-->
<!--                                            <textarea type="text" rows=3 name="fulltest[--><?php //echo $j; ?><!--][result]" value="--><?php //echo $fulltest['result']; ?><!--" placeholder="Kết quả, nhận xét" class="form-control" style="min-width: 400px;">--><?php //echo $fulltest['result']; ?><!--</textarea>-->
<!--                                            <textarea type="text" rows=3 name="fulltest[--><?php //echo $j; ?><!--][suggest]" value="--><?php //echo $fulltest['suggest']; ?><!--" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;">--><?php //echo $fulltest['suggest']; ?><!--</textarea>-->
<!--                                        </div>-->

                                        <div class="item form-inline" style="margin-bottom: 10px;">
                                            <div class="container-fluid" style="margin-bottom: 60px;">
                                                <div class="row" style="margin-bottom: 10px;">
                                                    <div class="col-sm-12" style="">
                                                        &bull; Điểm số từ  <input type="number" step="0.5" min="0" max="9" name="fulltest[<?php echo $j; ?>][from]" value="<?php echo $fulltest['from']; ?>" placeholder="Từ điểm" class="form-control" style="margin-left: 8px;margin-right: 8px;">
                                                        Đến <input type="number" step="0.5" min="0" max="9"  name="fulltest[<?php echo $j; ?>][to]" value="<?php echo $fulltest['to']; ?>" placeholder="Đến điểm" class="form-control"  style="margin-left: 8px;margin-right: 8px;">
                                                    </div>

                                                </div>
                                                <div class="row" style="">
                                                    <p style="font-style: italic; margin: 0;padding: 2px 10px;">fulltest</p>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea" type="text" rows=3 name="fulltest[<?php echo $j; ?>][result]" value="<?php echo $fulltest['result']; ?>" placeholder="Kết quả, nhận xét" class="form-control" style="min-width: 400px;"><?php echo $fulltest['result']; ?></textarea>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <textarea class="ckeditor_textarea"   type="text" rows=3 name="fulltest[<?php echo $j; ?>][suggest]" value="<?php echo $fulltest['suggest']; ?>" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"><?php echo $fulltest['suggest']; ?></textarea>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        
                                        <?php $j ++; } }
                                for ($i = $j; $i < 10; $i ++) { ?>
                                    <div class="item form-inline" style="margin-bottom: 10px;">
                                        <input type="number" step="0.5" min="0" max="9" name="fulltest[<?php echo $i; ?>][from]" value="" placeholder="Từ điểm" class="form-control">
                                        <input type="number" step="0.5" min="0" max="9"  name="fulltest[<?php echo $i; ?>][to]" value="" placeholder="Đến điểm" class="form-control">
                                        <textarea type="text" rows=3 name="fulltest[<?php echo $i; ?>][result]" value="" placeholder="Kết quả, nhận xét" class="form-control"  style="min-width: 400px;"></textarea>
                                        <textarea type="text" rows=3 name="fulltest[<?php echo $i; ?>][suggest]" value="" placeholder="Gợi ý" class="form-control"  style="min-width: 400px;"></textarea>
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

<script>
    $( document ).ready(function() {
        CKEDITOR.replaceClass = 'ckeditor_textarea';
    });



</script>