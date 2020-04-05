<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$this->load->config('data');
$class_type = $this->config->item("course_class_type");
?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Chọn loại</h2>
				<div class="clearfix"></div>
			</div>

			<div class="x_content">
				<ul>
					<?php foreach ($class_type as $key => $value) { ?>
						<li><a href="<?php echo SITE_URL; ?>/course/class_add/<?php echo $topic_id; ?>?type=<?php echo $key; ?>"><?php echo $value; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
