<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
echo validation_errors();
?>
<form action="" method="POST">
	<table cellpadding="4px" width="100%">
		<tr>
			<td class="left"><?php echo $this->lang->line('vote_name')?></td>
			<td class="right"><?php echo $title?></td>
		</tr>
        <?php if ($row_answer) { ?>
        <tr>
            <td class="left">Phuong an truoc</td>
            <td class="right">
                <?php foreach ($row_answer as $r) { ?>
                <div style="margin-bottom: 5px;" id="answer_update_<?php echo $r['answer_id']; ?>"><input type="text" value="<?php echo $r['name']; ?>"/><img style="cursor: pointer; margin: 0 7px;" onclick="updatevoteanswer(<?php echo $r['answer_id']; ?>)" src="<?php echo $this->config->item("img"); ?>edit.png" title=""/><img style="cursor: pointer;" src="<?php echo $this->config->item("img"); ?>delete.gif" onclick="deletevoteanswer(<?php echo $r['answer_id']; ?>)" title=""/>

                </div>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
			<td class="left"><?php echo $this->lang->line('vote_answer')?></td>
			<td class="right" id="vote_answer">
                <div id="voteanswerarea">
                    <div style="margin-bottom: 5px;"><?php echo $answer; ?></div>
                </div>
                <p style="margin-top: 10px; cursor: pointer;" id="vote_add"><?php echo $this->lang->line('vote_answer_addmore')?></p>
            </td>
		</tr>
		<tr>
			<td></td>
			<td class="right">
				<?php echo $submit?>
			</td>
		</tr>
	</table>
</form>
<script>
$("#vote_add").bind("click",function(){
    var html = '<div style="margin-bottom: 5px;"><input type="text" value="" name="answer[]" placeholder="<?php echo $this->lang->line('vote_answer')?>"/></div>';
    $("#voteanswerarea").append(html);
});
function updatevoteanswer (id) {
    var name = $("#answer_update_" + id).find("input").val();
    $.post( "<?php echo site_url('vote/updateanswer'); ?>", {answerid: id, name: name},function( data ) {
        if (data.result == 'success') {
            alert('<?php echo $this->lang->line('vote_answer_update_sucess')?>')
        }
        else {
            alert(data.rev);
        }
    },'JSON');
}
function deletevoteanswer (id) {
    $.post( "<?php echo site_url('vote/deleteanswer'); ?>", {answerid: id},function( data ) {
        if (data.result == 'success') {
            $("#answer_update_" + id).fadeOut()
        }
        else {
            alert(data.rev);
        }
    },'JSON');
}
</script>