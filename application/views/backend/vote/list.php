<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$i = 1;
?>

<form action="" method="POST" class="delete_form">
<div class="search">
	<?php echo temp_delete_icon()?>
	<?php echo temp_quick_search() ?>
</div>
<?php
if (isset($error))
echo '<div class="error">'.$error.'</div>';
?>
<table class="table_list">
	<thead>
	<tr class="title">
		<th width="40px">
			<?php echo $this->lang->line('common_no'); ?>
		</th>
		<?php echo temp_del_head(); ?>
		<th><?php echo $this->lang->line('vote_name'); ?></th>
        <th><?php echo $this->lang->line('vote_date_up'); ?></th>
		<?php echo temp_edit_head(); ?>
	</tr>
	</thead>
	<tbody>
	<?php
	if (!empty($row)){
	foreach ($row as $row){?>
	<tr>
		<td align="center"><?php echo $i?></td>
		<?php echo temp_del_check($row['vote_id']) ?>
		<td><?php echo $row['title']?></td>
		<td align="center" width="140px"><?php echo convert_datetime($row['date_up'],2)?></td>
		<?php echo temp_edit_icon('vote/edit/'.$row['vote_id'],'','',1) ?>
	</tr>
	<?php
	$i ++;
	}
	}?>
	</tbody>
</table>
</form>