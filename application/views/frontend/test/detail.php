<div class="col-md-8 col-sm-8 col-xs-12">
	<?php echo $breadcrumb; ?>
	
	<div class="col_box_baihoc_view col_box_test" id="test_random">
	    <form id="testing_form" action="<?php echo SITE_URL; ?>/test/result" method="POST">
	    	<div class="head-list-read"><h1><?php echo $test['title']; ?></h1></div>
	    	<?php foreach ($question as $key => $question) { ?>
	    		<div class="question alias_answer" data-question="<?php echo $question['question_id']?>" style="padding: 0">
		    		<?php $this->load->view('test/skill/question_'.$question['type'],array('question' => $question,'page' => 1),FALSE);?>
	    		</div>
	    	<?php } ?>
	        <div>
				<div class="btn-bh testing_result_button"><a href="javascript:void(0)" onclick="return mshoatoeic.tapescript()">Tapescript</a></div>
				<div class="btn-bh testing_result_button" id="testing_answer_button"><a href="javascript:void(0)" onclick="return mshoatoeic.send_answer_training()">Score</a></div>
				<div class="btn-bh"><a href="javascript:void(0)" onclick="return location.reload();">Again</a></div>
				<?php if ($next) { ?>
				<div class="btn-bh"><a href="<?php echo $test['share_url']; ?>?page=<?php echo $next; ?>">Next</a></div>
				<?php } ?>
				<input name="test_id" value="<?php echo $test['test_id']; ?>" type="hidden">
				<input type="hidden" name="token" value="<?php echo $this->security->generate_token_post(array($test['test_id'],0)); ?>">
			</div> 	
		</form>				
	</div>	
	<div class="text-right">
		<div class="fb-like" data-href="<?php echo current_url(); ?>" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>
	</div>
	<?php if ($test_relate) {?>
	<ul class="list_practice">
	   	<h2>Luyện tập thêm</h2>
	   	<?php foreach ($test_relate as $row) { ?>
			<li><a href="<?php echo $row['share_url']; ?>"><?php echo $row['title']; ?></a></li>
		<?php } ?>
	</ul><!-- End -->
	<?php } ?>

	<!-- Tài liệu luyện thi toeic -->
	<?php echo $this->load->get_block('content'); ?> 
 
</div> 

<div class="col-md-4 col-sm-4 col-xs-12">
    <?php echo $this->load->get_block('right'); ?>
    <div class="sidebar-block"> 
        <div class="title-header-bl"><h2>FANPAGE</h2><span><i class="fa fa-angle-right arow"></i></span></div>
        <div class="fb-page" data-href="<?php echo $this->config->item('facebook');?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $this->config->item('facebook');?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $this->config->item('facebook');?>">Facebook</a></blockquote></div>
    </div><!--End-->
</div>
<?php
$html = <<<HTML
<script type="text/javascript" src="{$this->config->item('js')}mshoatoeic.js"></script>
<script type="text/javascript" src="{$this->config->item('js')}jquery.countdown.min.js"></script>
HTML;
$this->load->push_section('script','test_page',$html);
?>