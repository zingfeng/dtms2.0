<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<div class="form-group">
    <label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("block_position"); ?></label>
    <div class="col-sm-10 col-xs-12">
    	<select name="position" class="form-control">
    		<?php foreach ($arrConfig['position'] as $key => $position) { ?>
    		<option value="<?php echo $key; ?>" <?php echo ($row['position'] == $key) ? 'selected':''?>><?php echo $position; ?></option>
    		<?php } ?>
    	</select>
    </div>
</div>
<?php 
	$arrSize = $this->config->item("resize");
	$arrSpecial = $this->config->item("blocktop");
	if ($params = $arrConfig['params']) {

	foreach ($params as $key => $param) {
	if (is_array($param)) { 
		?>
		<div class="form-group">
		    <label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("block_param_".$key); ?></label>
		    <div class="col-sm-10 col-xs-12">
		    	<select name="params[<?php echo $key; ?>]" class="form-control">
		    		<option  value=""><?php echo $this->lang->line("block_param_".$key); ?></option>
		    		<?php foreach ($param as $k => $p) { ?>
		    		<option <?php if ($row['params'][$key] == $k) echo 'selected'; ?>  value="<?php echo $k; ?>"><?php echo $p; ?></option>
		    		<?php } ?>
		    	</select>
		    </div>
		</div>
	<?php }
	else { ?>
		<div class="form-group">
		    <label class="control-label col-sm-2 col-xs-12"><?php echo $this->lang->line("block_param_".$param); ?></label>
		    <div class="col-sm-10 col-xs-12">
		<?php 
		switch ($param) {
			case 'title': ?>
			<div class="checkbox">
                <label><input type="checkbox" value="1" <?php echo ($row['params']['title'] == 1) ? 'checked' : ''; ?> name="params[<?php echo $param; ?>]"></label>                       
            </div>
			<?php 
			break;
			case 'content': ?>
				<div class="ckeditor_detail">
					<textarea name="content"><?php echo $row['content']; ?></textarea>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						CKEDITOR.replace('content');
					})
				</script>
			<?php
			break;
			case 'thumb': 
				?>
				<select class="form-control" name="params[<?php echo $param; ?>]">
					<option <?php if ($row['params'][$param] == 'size0') echo 'selected'; ?> value="size0">Hình gốc</option>
					<?php 
					foreach ($arrSize as $key => $size) {?>
					<option <?php if ($row['params'][$param] == $key) echo 'selected'; ?> value="<?php echo $key; ?>"><?php echo implode('x',$size); ?></option>
					<?php } ?>
				</select>
			<?php break;
			default: ?>
				<input type="text" name="params[<?php echo $param; ?>]" value="<?php echo $row['params'][$param]; ?>" placeholder="<?php echo $this->lang->line("block_param_".$param); ?>" class="form-control">
				<?php break;
			} ?>
			</div>
		</div>
	<?php }
	}
}?>
