<!DOCTYPE html>
<html lang="vi" >
<head>
    <head>
        <base href="/">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="doom">
        <meta name="description" content="doom">
        <meta name="keywords" content="Tin tức, hình ảnh, video clip, scandal sao Việt &amp; thế giới - Ngôi Sao">
        <title>ALAND IELTS</title>
        <link rel="shortcut icon" type="image/x-icon" href="https://www.aland.edu.vn/theme/frontend/default/images/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=vietnamese" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>/fontAwesome/css/font-awesome.min.css" media="all">
        <link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>/bootstrap4/bootstrap.min.css" media="all">
        <link rel="stylesheet" href="<?php echo $this->config->item("lib"); ?>/jplayer/css/jplayer-flat-audio-theme.css">
        <link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>/style-test-ielts.css" media="all">
        <script type="text/javascript">
            SITE_URL = 'https://www.aland.edu.vn';
        </script>
        <script src="<?php echo $this->config->item("js"); ?>bootstrap4/jquery-3.4.1.min.js"></script>

        <link rel="stylesheet" href="html/css/style-test-ielts.css" media="all" />
        <style type="text/css">
            /* Only in showing */
            .tilte_explain_question{
                display: none !important;
            }
            .content_explain_question{
                background-color: transparent !important;
                padding: 0 !important;
            }
            .show_tape {
                background: #FBFBFB;
                border: 1px solid #D1D1D1;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 4px;
                margin-bottom: 15px;
            }
            .btn-speaking{
                margin: 5px;
            }

            .recordingList{
                border-left: 5px solid transparent;
                /*border-left: 5px solid #f24962;*/
                padding: 10px;
                margin-left: 20px;
            }
            .cue_card{
                background: #FFF9F2;
                padding: 10px;
                color: #707070;
                border-radius: 6px;
                border: 1px solid #707070;
                margin-bottom: 30px;
            }

            .notepad{
                background: #FBFBFB;
                padding: 10px;
                color: #707070;
                border: 1px solid #D1D1D1;
                border-radius: 6px;
                margin-bottom: 30px;
                min-height: 300px;
                resize: both;
            }

            .div_part{
                margin-bottom: 100px;
            }


        </style>
</head>
<body>

    <main id="main">
        <?php echo $content_for_layout; ?>
    </main>
    <script src="<?php echo $this->config->item("lib"); ?>/jplayer/js/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item("lib"); ?>/jplayer/js/jplayer.playlist.min.js"></script>

<!--    <script src="--><?php //echo $this->config->item("js"); ?><!--bootstrap4/jquery-3.3.1.slim.min.js"></script> jquery slim ko có ajax-->
    <script src="<?php echo $this->config->item("js"); ?>bootstrap4/popper.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>bootstrap4/bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>jquery.scrollbar.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>jquery.countdown.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>colResizable-1.6.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>owl.carousel.min.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>test-ielts.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>recorder.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>app.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>common.js"></script>
    <script src="<?php echo $this->config->item("js"); ?>test.js"></script>
</body>

</html>


