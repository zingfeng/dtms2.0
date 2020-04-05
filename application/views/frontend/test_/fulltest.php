<?php
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash(),
);
?>
<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=yes">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-title" content="<?php echo $seo_keyword ?>" />
	<?php if ($meta) {
	foreach ($meta as $key => $value) {?>
			<meta name="<?php echo $key; ?>" content="<?php echo $value; ?>" />
		<?php }
}?>
	<?php if ($ogMeta) {
	foreach ($ogMeta as $key => $value) {?>
			<meta property="<?php echo $key; ?>" content="<?php echo $value; ?>" />
		<?php }
}?>
	<meta name="keywords" content="<?php echo $seo_keyword ?>">
	<meta name="description" content="<?php echo $seo_description ?>">
	<link rel="canonical" href="<?php echo BASE_URL ?>"/>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->config->item("img"); ?>favicon.ico">
	<title><?php echo $seo_title; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=vietnamese" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>fontAwesome/css/font-awesome.min.css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>bootstrap.min.css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>style.css" media="all" />
	<link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>customize.css" media="all" />
	<script type="text/javascript">
		SITE_URL = '<?php echo SITE_URL; ?>';
	</script>
	<script src="<?php echo $this->config->item("js"); ?>jquery-2.1.4.min.js"></script>
	<?php echo $this->config->item("tracking_code_header"); ?>
    <style type="text/css">
        /* Only in showing */
        .tilte_explain_question{
            display: none !important;
        }
        .content_explain_question{
            background-color: transparent !important;
            padding: 0 !important;
        }
    </style>

</head>

<body class="body_home listening-test">
	<!--HEADER-->
	<header id="header" class="section header">
		<a class="img_logo" href="">
			<img class="logo_web" src="<?php echo $this->config->item("img"); ?>graphics/logo.png" alt="Trang chủ" data-was-processed="true">
		</a>
		<div class="btn_control_menu"><i class="fa fa-bars"></i></div>
		<div class="my_user">
			<a class="notification" href=""><i class="fa fa-globe"></i><span>2</span></a>
			<a class="login" href=""><i class="fa fa-user"></i></a>
			<a class="ava" href=""><img src="<?php echo $this->config->item("img"); ?>graphics/ava.png" alt="this"></a>
		</div>
	</header>
	<!--END HEADER-->
	<section class="listening-test_head clearfix">
		<div class="container">
			<div class="show_test" id="show_test_info" style="display: none;">
				<div class="book left">
					<img src="<?php echo $this->config->item("img"); ?>icons/book.png" alt="">
					<a href="<?php echo $cateDetail['share_url']; ?>"><h4><?php echo $cateDetail['name']; ?></h4></a>
				</div>
				<div class="info right">
					<div class="date">
						<!--<p><i class="fa fa-calendar"></i>Ngày đăng: 22/11/2018</p>-->
						<p><i class="fa fa-file-text-o"></i>Số lần test: <?php echo $test['total_hit']?></p>
						<!--<p><i class="fa fa-file-zip-o"></i>Người tạo: Aland IELTS</p>-->
					</div>
					<div class="user">
						<div class="content">
							<h4><?php echo $test['title']; ?></h4>
							<?php if($test['author']) { ?>
								<p>Biên soạn bởi <?php echo $test['author']?></p>
							<?php } ?>
						</div>
						<img class="<?php echo $test['title']; ?>" src="<?php echo getimglink($test['images'],'size1');?>" alt="<?php echo $test['title']; ?>">
					</div>
				</div>
			</div>
			<a class="img_logo" href="<?php echo BASE_URL; ?>">
				<img class="logo_web" src="<?php echo $this->config->item("img"); ?>graphics/logo.png" alt="Trang chủ" data-was-processed="true">
			</a>
			<div class="select_sever">
				<span class="hidden-xs">Chọn Section để làm bài</span>
				<?php
$i = 1;
$time = 0;
foreach ($arrQuestion as $key => $question) {
	if ($i % 2 == 1 && $i != 1) {
		echo '<div class="clearfix visible-xs"></div>';
	}

	?>
					<a data-section="<?php echo $question['question_id']; ?>" id="question_setion_selection_<?php echo $question['question_id']; ?>" class="reading_change_section <?php if ($i == 1) {
		echo 'active';
	}
	?>" href="javascript:void(0)"><?php echo $question['title']; ?></a>
					<?php $i++;
	$test_time += $question['test_time'] * 60 * 1000;
	//var_dump($test_time); die;
}?>
			</div>
			<div class="option_listening">
				<div class="social_share">
					<div class="fb-share-button" data-href="<?php echo SITE_URL . $newsDetail['share_url'] ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url ?>" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
	                <div class="fb-like" data-href="<?php echo SITE_URL . $newsDetail['share_url'] ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
				</div>
				<!--<a href=""><i class="icon icon-download"></i></a>-->
				<!--<a href=""><i class="icon icon-social"></i></a> -->
				<!--<a href=""><i class="icon icon-font"></i></a>-->
				<!--<a href="" title="Thoát"><i class="icon icon-out"></i></a>-->
				<a href="javascript:void(0)" class="show_info_test">Show info test<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
			</div>
		</div>
	</section>

		<section class="listening-test_running clearfix">
			<div class="container">
				<div class="row">
					<div class="col-xs-6">
						<?php echo $this->load->view('common/player'); ?>
						<?php
/* $i = 1;
foreach ($arrQuestion as $key => $question) { ?>
<audio controls autoplay>
<source src="<?php echo UPLOAD_URL . 'sound/'.$question['sound']; ?>" type="audio/ogg">
</audio>
<?php }*/?>
						</div>
						<div class="col-xs-6 right">
							<h3 style="display:none">Chữa bài</h3>
							<!--<div class="timer"><i class="fa fa-clock-o"></i>20:00</div>-->
							<!--<a class="back" href="javascript:voi(0)" id="submit_answer_result">Nộp bài</a>-->
						</div>
					</div>
				</div>
			</section>

			<section class="listening-test_container clearfix">



				<div class="container max_width warp_slidebar">
					<?php
echo $this->load->view('test/common/skill_menu', array('test' => $test, 'type' => 'listening')); ?>
					<div class="row <?php if (!$this->input->get('skill')) {
	echo 'slidebar_2';
}
?>">
						<div class="col_left col-md-9 col-sm-9 col-xs-12">
							<form class="form" method="POST" action="/test/result" id="test_form">
								<input type="hidden" name="test_id" value="<?php echo $test['test_id']; ?>">
								<input type="hidden" name="type" value="<?php echo $keyType; ?>">
								<input type="hidden" name="start_time" value="<?php echo $start_time; ?>">
								<input type="hidden" name="token" value="<?php echo $token; ?>">
								<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
								<?php
$number_question = 1;
foreach ($arrQuestion as $qkey => $question) {
	?>
									<div class="question_section_content" id="question_section_<?php echo $question['question_id']; ?>" <?php if ($number_question != 1) {
		echo 'style="display: none"';
	}
	?>>
										<div class="warp_content">
											<div class="scrollbar-inner">

												<?php foreach ($arrQuestionGroup[$question['question_id']] as $key => $qgroup) {
		?>
												<div style="margin-top: 10px;" class="question mb30">

												<a class="listening" href=""><i class="fa fa-headphones"></i>&nbsp;&nbsp;Listening from here</a>
						                        <h3><?php echo $qgroup['title']; ?></h3>
						                        <div class="mb20"><?php echo $qgroup['detail']; ?></div>
						                        <?php
//var_dump($qgroup['question_answer']); die;
		echo $this->load->view("test/question/type_" . $qgroup['type'], array('rows' => $qgroup['question_answer'], 'number' => $number_question)); ?>
						                        </div>
						                        <?php $number_question += $qgroup['number_question'];}?>

						                        <?php if ($nextSection = $arrQuestion[$qkey + 1]) {?>
						                        <div class="passage-control">
						                            <a class="reading_change_section" href="javascript:void(0)" data-section="<?php echo $nextSection['question_id']; ?>"><?php echo $nextSection['title']; ?>&nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
						                        </div>
						                        <?php }?>



											</div>
										</div>
									</div>
								<?php
$arrNumberCheck[$question['question_id']] = $number_question;
}?>

							</form>
						</div>

						<div class="col_right col-md-3 col-sm-3 col-xs-12" id="list_answer">
							<div class="warp_content">
								<div class="timer"><i class="fa fa-clock-o"></i><span id="show_count_down"></span></div>
								<div class="scrollbar-inner">
									<div class="col-xs-12">

										<?php
$j = 1;
foreach ($arrNumberCheck as $question_id => $number_max) {
	for ($i = $j; $i < $number_max; $i++) {?>
												<div data-section="<?php echo $question_id; ?>" class="answer_recheck answer_recheck_item_<?php echo $i; ?> circle_number" data-q="q-<?php echo $i; ?>"><?php echo $i; ?></div>
											<?php }
	$j = $i;
}?>
									</div>
									<div class="submit"><button type="submit" id="submit_answer_result" class="btn">Nộp bài</button></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<div class="mask-content"></div>
			<!--MAIN MENU-->
			<nav id="main_menu" class="main_menu">
				<div class="header_menu section">
					<span id="auto_close_left_menu_button" class="close_main_menu">×</span>
					<div class="my_contact">
						<p><i class="fa fa-phone"></i><a style="color:#ff3333;font-weight:bold"><?php echo $this->config->item('hotline')?></a></p>
						<p class="email"><a><i class="fa fa-envelope-o"></i>support@aland.edu.vn</a></p>
					</div>
				</div>
				<div class="block_scoll_menu section">
					<div class="block_search section">
						<form id="search" action="http://timkiem.MSN.net/" method="get">
							<div class="warp">
								<input id="auto_search_textbox" maxlength="80" name="q" class="input_form" placeholder="Tìm kiếm" type="search">
								<button type="submit" id="btn_search_ns" class="btn_search"><i class="fa fa-search"></i></button>
								<button type="reset" class="btn_reset">×</button>
							</div>
						</form>
					</div>
					<div class="list_menu section" id="auto_footer_menu">
						<ul class="list_item_panel section" id="auto_footer_first_list">
							<li>
								<a href="https://www.google.com/" class="link_item_panel">About us</a>
								<span class="sub-icon">+</span>
								<ul class="level2">
									<li>
										<a href="">About us 1</a>
										<span class="sub-icon2">+</span>
										<ul class="level3">
											<li>
												<a href="">About us 2</a>
											</li>
											<li>
												<a href="">About us 2</a>
											</li>
										</ul>
									</li>
									<li>
										<a href="">About us 1</a>
									</li>
									<li>
										<a href="">About us 1</a>
									</li>
								</ul>
							</li>
							<li><a href="#" class="link_item_panel">IELTS Online</a></li>
							<li><a href="#" class="link_item_panel">Lịch khai giảng</a></li>
							<li><a href="#" class="link_item_panel">IELTS Test</a></li>
							<li><a href="#" class="link_item_panel">Lộ trình học</a></li>
							<li><a href="#" class="link_item_panel">Tuyển dụng</a></li>
						</ul>
					</div>
					<div class="footer_bottom">
						<div class="bold_text_top width_common"><h3>Học tiếng anh trực tuyến<br>© 2018 aland.net</h3>
							<p>Trực thuộc công ty cổ phần giáo dục và đào tạo Imap Việt Nam</p>
							<div class="social">
								<a href=""><i class="fa fa-facebook"></i></a>
								<a href=""><i class="fa fa-google-plus"></i></a>
								<a href=""><i class="fa fa-youtube-play"></i></a>
							</div>
						</div>
					</div>
				</div>
			</nav>
			<!--END MAIN MENU-->
			<a href="javascript:;" id="to_top"><i class="fa fa-long-arrow-up"></i></a>

			<!--<script src="<?php echo $this->config->item("js"); ?>owl.carousel.min.js"></script>-->
			<script src="<?php echo $this->config->item("js"); ?>bootstrap.min.js"></script>
			<script src="<?php echo $this->config->item("js"); ?>jquery.scrollbar.min.js"></script>
			<!--Owl slider lib-->
			<script type="text/javascript">
				function question_update_answer(position,value) {

					if (value) {
						$(".answer_recheck_item_" + position).addClass("circle_number_active")
					}
					else {
						$(".answer_recheck_item_" + position).removeClass("circle_number_active")
					}
				}
			</script>
			<link href="<?php echo $this->config->item("lib"); ?>/jplayer/css/jplayer-flat-audio-theme.css" rel="stylesheet">
			<script src="<?php echo $this->config->item("lib"); ?>/jplayer/js/jquery.jplayer.min.js"></script>
			<script type="text/javascript" src="<?php echo $this->config->item("lib"); ?>/jplayer/js/jplayer.playlist.min.js"></script>
			<script src="<?php echo $this->config->item("js"); ?>jquery.countdown.min.js"></script>
			<script src="<?php echo $this->config->item("js"); ?>test.js"></script>
			<script type="text/javascript">
			$(document).ready(function(){
				function liftOff() {
					$("#test_form").submit();
				}

				var fiveSeconds = new Date().getTime() + parseInt(<?php echo (int) $test_time; ?>);
				$('#show_count_down').countdown(fiveSeconds, {elapse: true})
				.on('update.countdown', function(event) {
					var this_countdown = $('#show_count_down');
					if (event.elapsed) {
						// $this.html('Hết thời gian làm bài');
						return liftOff();
					} else {
						this_countdown.html(event.strftime('%H : %M : %S'));
					}
				});

				var arrPlaylist = [];

			<?php foreach ($arrQuestion as $key => $question) {?>
				arrPlaylist.push({
		                title:"<?php echo $question['title']; ?>",
		                mp3:"<?php echo UPLOAD_URL . 'sound/' . $question['sound']; ?>",
            		});
			<?php }?>

			var myPlaylist = new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer_playlist",
            cssSelectorAncestor: "#jp_container_playlist"
		        }, arrPlaylist, {
		            volume: 1.0,
		            playlistOptions: {
		                //autoPlay: true,
		                shuffleOnLoop: false
		            },
		            swfPath: "js",
		            supplied: "oga, mp3",
		            wmode: "window",
		            useStateClassSkin: true,
		            autoBlur: false,
		            //autoplay: true,
		            smoothPlayBar: true,
		            keyEnabled: true
		        });

				jQuery('.scrollbar-inner').scrollbar();
					$(".reading_change_section").bind("click",function(){
						var section_id = $(this).attr("data-section");
						$(".question_section_content").hide();
						$("#question_section_" + section_id).show();

						$(".reading_change_section").removeClass("active");
						$("#question_setion_selection_" + section_id).addClass("active");

						var dataIndex = $(this).attr("data-index");
						myPlaylist.play(dataIndex);
					});
					$("#test_form").find("select").bind("change",function(){
						var number = $(this).attr("data-question-number");

					});
					$(".answer_recheck").bind("click",function(){

				});
				// USERS ANSWER //
				$("#submit_answer_result").bind("click",function(){
					var r = confirm("Bạn có chắc muốn nộp bài ?");
					if (r == true) {
						$("#test_form").submit();
					}
					return false;

				});

				$('#list_answer').on('click', '.answer_recheck', function (event) {
		          	event.preventDefault();
		          	var id = $(this).attr('data-section');
		          	var qid = $(this).attr('data-q');

		          	var tagName = $("#"+ qid)[0].tagName;

		          	if($('#question_section_' + id + ':visible').length == 0){
		                $("table.question_section_content").hide().colResizable({disable : true });
		                $("#question_section_" + id).show().colResizable({liveDrag:true});
		          	}

		          	//Focus
		            if (tagName === 'INPUT' || tagName === 'SELECT') {
		              	$("#"+ qid).focus();
		            }
		        })
			});

			</script>
	</body>

</html>
