<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
$test_type = $this->config->item("test_type");
?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Chọn loại câu hỏi</h2>
				<div class="clearfix"></div>
			</div>

			<div class="x_content">
				<ul>
					<?php foreach ($test_type as $key => $value) { ?>
						<li><a href="<?php echo SITE_URL; ?>/test/question_add?testid=<?php echo $this->input->get("testid"); ?>&type=<?php echo $key; ?>"><?php echo $value; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
