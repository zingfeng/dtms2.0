<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="col-md-12">
    <?php echo $this->load->view('common/breadcrumb');?> 
    
    <div class="box-login box_sign_in" style="min-height: 500px;"> 
        <div class="head">
            <h2 class="heading-title"><?php echo $title ?></h2>
        </div>
        <div class="content text-center"> <?php echo $result?> </div>

        <div class="content text-center" style="padding: 20px;">
            <a id="go_back" class="back-home" href="#" ><i class="fa fa-home"></i><span>Trở về trang trước</span></a>
            <script>
                document.getElementById('go_back').href = document.referrer;
            </script>
        </div>
    </div>
</div>