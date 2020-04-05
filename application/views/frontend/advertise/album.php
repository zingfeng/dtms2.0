<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div id="breakcrumb">
    <a href="<?php echo base_url() ?>"><?php echo $this->lang->line("common_home") ?></a>
    <?php echo $this->lang->line("common_gallery")?>
</div>
<ul id="album">
    <?php 
    $i = 1;
    foreach ($rows as $row) { 
        ?>
        <li <?php if ($i % 4 == 1) echo 'class="first"'; ?>>
            <div class="image">
                <a href="<?php echo set_url('gallery_cate',$row['alias'],$row['cate_id']) ?>">
                <img onload="resizeImage(this,100)" src="<?php echo $api_resize.$row['images'] ?>" alt="<?php echo $row['name'] ?>"/>
                </a>
            </div>
            <h3><?php echo $row['name'] ?></h3>
        </li>
    <?php $i ++; }  ?>
</ul>
<?php echo $paging ?>