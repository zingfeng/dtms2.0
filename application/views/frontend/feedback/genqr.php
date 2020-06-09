<form method="POST" style="text-align: center;" class="container">
    <h2>Gen QR Code</h2>
    <p style="margin: 30px 0">==============***============== </p>
    <div class="row">
        <div class="col-sm-3 col-xs-12">
            <label for="">Link</label> <br/>
            <input type="text" name="link" placeholder="Nhập link" value="<?php echo $_POST['link']?>" style="width: 100%">
        </div>
        <div class="col-sm-3 col-xs-12">
            <label for="">ECC</label> <br/>
            <select name="level">
                <option value="L" <?php echo $_POST['level'] == "L" ? 'selected' : ''?>>L - smallest</option>
                <option value="M" <?php echo $_POST['level'] == "M" ? 'selected' : ''?>>M</option>
                <option value="Q" <?php echo $_POST['level'] == "Q" ? 'selected' : ''?>>Q</option>
                <option value="H" <?php echo $_POST['level'] == "H" ? 'selected' : ''?>>H - best</option>
            </select>
        </div>
        <div class="col-sm-3 col-xs-12">
            <label for="">SIZE</label> <br/>
            <select name="size">
                <?php for($i = 1; $i <= 10; $i++) { ?>
                    <option value="<?php echo $i?>" <?php echo $_POST['size'] == $i ? 'selected' : ''?>><?php echo $i?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-3 col-xs-12">
            <button>GENERATE</button>
        </div>
    </div>
    <p style="margin: 30px 0">==============***============== </p>
    <?php if($qrcode) { ?>
        <img src="<?php echo $qrcode?>">
    <?php } ?>
</form>