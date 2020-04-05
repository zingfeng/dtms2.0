<html>
<head></head>
<body>
<form action="<?php echo $url;?>" method="post" id="your_father" style="display: none">
    <input type="hidden" name="fulltest_timestamp" value="<?php echo $fulltest_timestamp;?>">
    <input type="hidden" name="fulltest_all_step" value='<?php echo $fulltest_all_step;?>' >
    <input type="hidden" name="fulltest_now_step" value="<?php echo $fulltest_now_step;?>">
    <button type="submit">Send</button>
</form>

<script>
    var send = document.getElementById("your_father").submit();
</script>
</body>
</html>
