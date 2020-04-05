<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<table width="100%" cellpadding="5px">
    <tr>
        <td class="cl_left">
            <?php echo $this->lang->line('contact_fullname'); ?>
        </td>
        <td class="cl_right">
            <?php echo $username?>
        </td>
    </tr>
    <tr>
        <td class="cl_left">
            <?php echo $this->lang->line('contact_email'); ?>
        </td>
        <td class="cl_right">
            <?php echo $email?>
        </td>
    </tr>
    <tr>
        <td class="cl_left">
            <?php echo $this->lang->line('contact_phone'); ?>
        </td>
        <td class="cl_right">
            <?php echo $phone?>
        </td>
    </tr>
    <tr>
        <td class="cl_left">
            <?php echo $this->lang->line('contact_content'); ?>
        </td>
        <td class="cl_right">
            <?php echo $content?>
        </td>
    </tr>
</table>

