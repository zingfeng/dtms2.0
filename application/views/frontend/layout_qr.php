<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=yes">

        <title>GEN QR CODE</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->config->item("img"); ?>favicon.ico">
        <link rel="stylesheet" href="<?php echo $this->config->item("css"); ?>bootstrap.min.css" media="all"/>
    </head>
    <body>
        <div class="wrapper">
            <?php echo $content_for_layout; ?>
        </div>
    </body>
</html>