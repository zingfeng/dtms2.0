<div class="fillter-mobile">
	<a class="<?php if($type == 'listening') echo 'active'; ?>"  href="<?php echo str_replace('/test/', '/test/listening/', $test['share_url']); ?> " <?php if( (! is_array($arr_list_test_type)) || (! in_array('Listening', $arr_list_test_type))) echo ' style ="display:none" ';  ?>>
		<img class="img2" src="<?php echo $this->config->item("img"); ?>icons/icon-headphone1.png" alt="">
		<img class="img4" src="<?php echo $this->config->item("img"); ?>icons/icon-headphone.png" alt="">
	</a>
	<a class="<?php if($type == 'reading') echo 'active'; ?>"  href="<?php echo str_replace('/test/', '/test/reading/', $test['share_url']); ?>" <?php if( (! is_array($arr_list_test_type)) || (! in_array('Reading', $arr_list_test_type)))  echo ' style ="display:none" ';  ?> >
		<img class="img2" src="<?php echo $this->config->item("img"); ?>icons/icon-book1.png" alt="">
		<img class="img4" src="<?php echo $this->config->item("img"); ?>icons/icon-book.png" alt="">
	</a>

	<a class="<?php if($type == 'writing') echo 'active'; ?>"  href="<?php echo str_replace('/test/', '/test/writing/', $test['share_url']); ?>" <?php if( (! is_array($arr_list_test_type)) || (! in_array('Writing', $arr_list_test_type)))  echo ' style ="display:none" ';  ?> >
		<img class="img2" src="<?php echo $this->config->item("img"); ?>icons/icon-pencil1.png" alt="">
		<img class="img4" src="<?php echo $this->config->item("img"); ?>icons/icon-pencil.png" alt="">
	</a>
	<a class="<?php if($type == 'speaking') echo 'active'; ?>"  href="<?php echo str_replace('/test/', '/test/speaking/', $test['share_url']); ?>" <?php if( (! is_array($arr_list_test_type)) || (! in_array('Speaking', $arr_list_test_type)))  echo ' style ="display:none" ';  ?> >
		<img class="img2" src="<?php echo $this->config->item("img"); ?>icons/icon-microphone1.png" alt="">
		<img class="img4" src="<?php echo $this->config->item("img"); ?>icons/icon-microphone.png" alt=""> 
	</a>
</div>

