<div class="fillter-test">
	<a class="on" href="javascript:;"><i class="fa fa-backward"></i></a>
	<ul>
		<h4>FULL TEST</h4>
		<li class="listening" <?php if( (! is_array($arr_list_test_type)) || (! in_array('Listening', $arr_list_test_type))) echo ' style ="display:none" ';  ?> >
			<a class="<?php if($type == 'listening') echo 'active'; ?>" href="<?php echo str_replace('/test/', '/test/listening/', $test['share_url']); ?>">
				<img src="<?php echo $this->config->item("img"); ?>icons/headphone1.png" alt="">
				<img class="img2" src="<?php echo $this->config->item("img"); ?>icons/icon-headphone1.png" alt="">
				<img class="img3" src="<?php echo $this->config->item("img"); ?>icons/headphone.png" alt="">
				<img class="img4" src="<?php echo $this->config->item("img"); ?>icons/icon-headphone.png" alt="">
				<span>listening</span>
			</a>
		</li>
		<li class="reading" <?php if( (! is_array($arr_list_test_type)) || (! in_array('Reading', $arr_list_test_type))) echo ' style ="display:none" ';  ?> >
			<a class="<?php if($type == 'reading') echo 'active'; ?>" href="<?php echo str_replace('/test/', '/test/reading/', $test['share_url']); ?>">
				<img src="<?php echo $this->config->item("img"); ?>icons/book1.png" alt="">
				<img class="img2" src="<?php echo $this->config->item("img"); ?>icons/icon-book1.png" alt="">
				<img class="img3" src="<?php echo $this->config->item("img"); ?>icons/book.png" alt="">
				<img class="img4" src="<?php echo $this->config->item("img"); ?>icons/icon-book.png" alt="">
				<span>reading</span>
			</a>
		</li>
		<li class="writing" <?php if( (! is_array($arr_list_test_type)) || (! in_array('Writing', $arr_list_test_type))) echo ' style ="display:none" ';  ?> >
			<a class="<?php if($type == 'writing') echo 'active'; ?>" href="<?php echo str_replace('/test/', '/test/writing/', $test['share_url']); ?>">
				<img src="<?php echo $this->config->item("img"); ?>icons/pencil1.png" alt="">
				<img class="img2" src="<?php echo $this->config->item("img"); ?>icons/icon-pencil1.png" alt="">
				<img class="img3" src="<?php echo $this->config->item("img"); ?>icons/pencil.png" alt="">
				<img class="img4" src="<?php echo $this->config->item("img"); ?>icons/icon-pencil.png" alt="">
				<span>writing</span>
			</a>
		</li>
		<li  class="speaking" <?php if( (! is_array($arr_list_test_type)) || (! in_array('Speaking', $arr_list_test_type))) echo ' style ="display:none" ';  ?>>
			<a class="<?php if($type == 'speaking') echo 'active'; ?>" href="<?php echo str_replace('/test/', '/test/speaking/', $test['share_url']); ?>">
				<img src="<?php echo $this->config->item("img"); ?>icons/microphone1.png" alt="">
				<img class="img2" src="<?php echo $this->config->item("img"); ?>icons/icon-microphone1.png" alt="">
				<img class="img3" src="<?php echo $this->config->item("img"); ?>icons/microphone.png" alt="">
				<img class="img4" src="<?php echo $this->config->item("img"); ?>icons/icon-microphone.png" alt="">                          
				<span>speaking</span>
			</a>
		</li>                                                                   
	</ul>
</div> 