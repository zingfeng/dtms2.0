<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if (!empty($data)){
?> 
<form action="">
<div class="filter"><ul>
    <? foreach ($data as $data){?>
            <li><?=$data?></li>
        <?}?>
    <li class="last">
        <button type="submit"><?=$this->lang->line('common_filter_submit')?></button></li>
    </ul>
</div>
</form>
<?php }?>
