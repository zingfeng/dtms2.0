<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title><?php echo $this->lang->line('fmag_heading_title'); ?></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<script src="<?php echo $this->config->item("theme"); ?>vendors/jquery/dist/jquery.min.js"></script>
<script src="<?php echo $this->config->item("theme"); ?>vendors/jstree/js/jstree.min.js"></script>
<script src="<?php echo $this->config->item("js"); ?>ajaxupload.js"></script>
<link href="<?php echo $this->config->item("theme"); ?>vendors/jstree/css/themes/default/style.min.css" rel="stylesheet">
<link href="<?php echo $this->config->item("theme"); ?>vendors/jquery/dist/jquery-ui.css" rel="stylesheet">
<script src="<?php echo $this->config->item("theme"); ?>vendors/jquery/dist/jquery-ui-1.10.0.custom.min.js"></script>

<?php //echo js('jquery.bgiframe-2.1.2.js')?>



<style type="text/css">
body {
	padding: 0;
	margin: 0;
	background: #F7F7F7;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
img {
	border: 0;
}
#container {
	padding: 0px 10px 7px 10px;
}
#menu {
	clear: both;
	height: 29px;
	margin-bottom: 3px;
}
#column-left {
	background: #FFF;
	border: 1px solid #CCC;
	float: left;
	width: 20%;
	overflow: auto;
	min-height: 300px;
}
#column-right {
	background: #FFF;
	border: 1px solid #CCC;
	float: right;
	min-height: 300px;
	width: 78%;
	overflow: auto;
	text-align: center;
}
#column-right div {
	text-align: left;
	padding: 5px;
}
#column-right a {
	display: inline-block;
	text-align: center;
	border: 1px solid #EEEEEE;
	cursor: pointer; overflow: hidden;
	margin: 5px; width: 60px;
	padding: 5px;
}
#column-right a.selected {
	border: 1px solid #7DA2CE;
	background: #EBF4FD;
}
#column-right input {
	display: none;
}
#column-right img{
    max-width: 40px;
    max-width: 40px;
}
#dialog {
	display: none;
}
.button {
	display: block;
	float: left;
	padding: 8px 5px 8px 25px;
	margin-right: 5px;
	background-position: 5px 6px;
	background-repeat: no-repeat;
	cursor: pointer;
}
.button:hover {
	background-color: #EEEEEE;
}
.thumb {
	padding: 5px;
	width: 105px;
	height: 105px;
	background: #F7F7F7;
	border: 1px solid #CCCCCC;
	cursor: pointer;
	cursor: move;
	position: relative;
}
.img_name{width: 80px; overflow: hidden;}
.fileaction {display: none;}
</style>
</head>
<body>
<div id="container">
  <div id="menu">
        
        <a id="delete" class="button fileaction" style="background-image: url('<?php echo $theme?>edit-delete.png');"><?php echo $this->lang->line('fmag_button_delete'); ?></a>
        <a id="move" class="button fileaction" style="background-image: url('<?php echo $theme?>edit-cut.png');"><?php echo $this->lang->line('fmag_button_move'); ?></a>
        <a id="copy" class="button fileaction" style="background-image: url('<?php echo $theme?>edit-copy.png');"><?php echo $this->lang->line('fmag_button_copy'); ?></a>
        <a id="paste" class="button" style="display: none; background-image: url('<?php echo $theme?>edit-paste.png');"><?php echo $this->lang->line('fmag_button_paste'); ?></a>
        <a id="rename" class="button fileaction" style="background-image: url('<?php echo $theme?>edit-rename.png');"><?php echo $this->lang->line('fmag_button_rename'); ?></a>
        <a id="upload" class="button" style="background-image: url('<?php echo $theme?>upload.png');">
        <?php echo $this->lang->line('fmag_button_upload'); ?></a>
        <a id="refresh" class="button" style="background-image: url('<?php echo $theme?>refresh.png');"><?php echo $this->lang->line('fmag_button_refresh'); ?></a>
        <a id="selectimg" class="button fileaction" style="background-image: url('<?php echo $theme?>select.png');"><?php echo $this->lang->line('fmag_button_select'); ?></a>

  </div>
  <div id="column-left">
  		<div id="jstree"></div>
  </div>
  <div id="column-right"></div>
</div>
	<?php if ($image_selected = $this->input->get('selected')) {
		$arrPath = explode('/', $image_selected);
		$path = array("root"); $tmp = '';
		foreach ($arrPath as $arrPath) {
			$tmp = $path[] = trim($tmp.'/'.$arrPath,'/');
		}

		$file = array_pop($path);
		$folder_select = json_encode(array(array_pop($path)));
		$path = json_encode($path); ?>
		<script type="text/javascript">
			var open = JSON.parse('<?php echo $path; ?>');
			var folder_selected = JSON.parse('<?php echo $folder_select; ?>');
			var file_selected = '<?php echo $file; ?>';
			var jstreeStorage = localStorage.getItem('jstree'); 
			jstreeStorage = {"state":{"core":{"open": open,"scroll":{"left":0,"top":0},"selected":folder_selected}},"ttl":false,"sec":<?php echo time(); ?>}
			console.log(jstreeStorage);
			//jstreeStorage = {"state":{"core":{"open":["root","new_folder_80881_1461843216"],"scroll":{"left":0,"top":0},"selected":["new_folder_80881_1461843216/new_folder_24684_1461843229"]}},"ttl":false,"sec":1461845608447}
			//{"state":{"core":{"open":["2016","root"],"scroll":{"left":0,"top":0},"selected":[]}},"ttl":false,"sec":1461842483607}
			localStorage.setItem('jstree', JSON.stringify(jstreeStorage));
		</script>
	<?php } ?>

<script type="text/javascript">
/** FOLDER LEFT **/
$(function () {
	

	$('#jstree')
		.jstree({
			'core' : {
				'data' : {
					'url' : '<?php echo site_url('filemanager/directory')?>/?type=<?php echo $type?>',
					'data' : function (node) {
						console.log(node);
						var id = (node.id == '#') ? '' : node.id;
						return { 'id' : id };
					}
				},
				'force_text' : true,
				'check_callback' : function (op, node) {
					console.log(op);
					if(op === 'delete_node') { return confirm('<?php echo $this->lang->line("common_delete_confirm"); ?>  - Folder' + node.id); }
					if(op === 'create_node') {
						//console.log(node);
					}
				},
				'themes' : {
					'responsive' : false
				},
				 

			},
			'plugins' : ['state','dnd','contextmenu','wholerow'],
			
		})
		.on('delete_node.jstree', function (e, data) {

			$.ajax({
				url: '<?php echo site_url('filemanager/delete')?>/?type=<?php echo $type?>',
				type: 'POST',
				data: { 'path' : data.node.id },
				dataType: 'json',
				success: function(json){
					if (json.error) {
						alert(json.error);
						data.instance.refresh();
					}
				},
				error: function() {
					data.instance.refresh();
				}
			});
		})
		.on('create_node.jstree', function (e, data) {
			// prefix createname
			var folder_name = 'new_folder_' + Math.floor((Math.random() * 99999) + 10000) + '_' + Math.round(new Date().getTime()/1000);
			var id = (data.node.parent == 'root') ? folder_name : data.node.parent + '/' + folder_name;
			data.instance.set_id(data.node, id);
			data.instance.set_text(data.node, folder_name);
			data.node.original = {id: id,text: folder_name};
			// create on server
			$.ajax({
				url: '<?php echo site_url('filemanager/create')?>/?type=<?php echo $type?>',
				type: 'POST',
				data: { 'directory' : data.node.parent, 'position' : data.position, 'name' : data.node.text },
				dataType: 'json',
				async: false,
				success: function(d) {
					if (d.error) {
						data.instance.refresh();
					}
					else {
						data.instance.set_id(data.node, d.id);
					}
				},
				error: function() {
					data.instance.refresh();
				}
			});
		})
		.on('rename_node.jstree', function (e, data) {
			$.ajax({
				url: '<?php echo site_url('filemanager/rename')?>/?type=<?php echo $type?>',
				type: 'POST',
				data: { 'path' : data.node.id, 'name' : data.text },
				dataType: 'json',
				success: function(d) {
					if (d.error) {
						alert(d.error);
						data.instance.set_id(data.node,data.node.original.id);
						data.instance.set_text(data.node, data.node.original.text);
					}
					else {
						data.instance.refresh();
					}
				},
				error: function() {
					data.instance.refresh();
				}
			});

		})
		.on('move_node.jstree', function (e, data) {
			$.ajax({
				url: '<?php echo site_url('filemanager/move')?>/?type=<?php echo $type?>',
				type: 'POST',
				data: { 'from' : data.node.id, 'to' : data.parent, 'position' : data.position },
				dataType: 'json',
				success: function(json) {
					if (json.error) {
						alert(json.error);
					}
					data.instance.refresh();
				},
				error: function() {
					data.instance.refresh();
				}
			});
		})
		.on('copy_node.jstree', function (e, data) {
			$.ajax({
				url: '<?php echo site_url('filemanager/copy')?>/?type=<?php echo $type?>',
				type: 'POST',
				data: { 'from' : data.original.id, 'to' : data.parent, 'position' : data.position },
				dataType: 'json',
				success: function(json) {
					if (json.error) {
						alert(json.error);
					}
					data.instance.refresh();
				},
				error: function() {
					data.instance.refresh();
				}
			});
		})
		.on('changed.jstree', function (e, data) {
			if(data && data.selected && data.selected.length) {
				get_files(data.selected);
			}
			else {
				console.log('error get files',data);
				//$("#column-right").text(data.selected);
			}
		});
});
function get_files(directory){
	$('#column-right').empty();
	$.ajax({
		url: '<?php echo site_url('filemanager/files')?>/?type=<?php echo $type?>',
		type: 'POST',
		data: 'directory=' + directory,
		dataType: 'json',
		success: function(json) {
			html = '<div>';
			if (json) {
				
				for (i = 0; i < json.length; i++) {
					
					name = '';
					name += '<span class="img_name">' + json[i]['filename'] + '</span><br />';
					name += json[i]['size'];
					if (typeof(file_selected) != 'undefined' && json[i]['file'] == file_selected) {
						html += '<a file="' + json[i]['file'] + '" class="selected"><img src="' + json[i]['thumb'] + '" title="' + json[i]['filename'] + '" /><br />' + name + '</a>';	
						delete(file_selected);
					}
					else {
						html += '<a file="' + json[i]['file'] + '"><img src="' + json[i]['thumb'] + '" title="' + json[i]['filename'] + '" /><br />' + name + '</a>';
					}
				}
			}
			html += '</div>';
			$('#column-right').html(html);
		}
	});
}
function refresh_file() {
	var tree = $('#jstree').jstree(true);
	var node = tree.get_selected();
	if (node.length) {
		get_files(node[0]);
	}
}
function refresh_folder() {
	var tree = $('#jstree').jstree(true);
	var node = tree.refresh();
}
// 8 interact with the tree - either way is OK
$(document).ready(function () {

	$('#column-right').on('click','a',function (e) {
		if ($(this).attr('class') == 'selected') {

            if (e.ctrlKey)
            {
                $(this).removeAttr('class');
            }
            else{
                $('#column-right a').removeAttr('class');
                $(this).attr('class', 'selected');
            }
		} else {
            if (!e.ctrlKey)
            {
                $('#column-right a').removeAttr('class');
            }
			$(this).attr('class', 'selected');
		}
		$("#menu").show();
	});
    $('#selectimg').bind("click",function(){
        var html = '';
        $("#column-right").find(".selected").each(function(){
            html += '<p><img alt="" src="<?php echo $directory; ?>'+$(this).attr('file')+'"></p>';
        });
        if (html == ''){
            alert("<?php echo $this->lang->line("fmag_error_file"); ?>");
            return false;
        }
        <?php if ($formname) {?>
        window.opener.CKEDITOR.instances.<?php echo $formname ?>.insertHtml( html );
        self.close();
        window.opener.CKEDITOR.dialog.getCurrent().click('cancel');;
    	<?php } elseif ($callback) { ?>
    		$("#column-right").find(".selected").each(function(){
				window.opener.<?php echo $callback; ?>($(this).attr('file'),'<?php echo $dom; ?>');
			});
			self.close();
		<?php }else { ?>
			self.close();
		<?php } ?>
    })
	$('#column-right').on('dblclick', 'a', function () {
		<?php
        if ($fckeditor OR $fckeditor === '0') { ?>
		window.opener.CKEDITOR.tools.callFunction(<?php echo $fckeditor; ?>, '<?php echo $directory; ?>' + $(this).attr('file'));
        self.close();
		<?php } elseif ($callback) { ?>
			window.opener.<?php echo $callback; ?>($(this).attr('file'),'<?php echo $dom; ?>');
			self.close();
		<?php }else { ?>
			self.close();
		<?php } ?>
        var tree = $.tree.focused();
        var selected = encodeURIComponent($(tree.selected).attr('directory'))
        //createCookie("dirupload",selected,1000);
	});
	$('#delete').bind('click', function () {
		if (!$('#column-right a.selected').length) {
			alert('<?php echo $this->lang->line('fmag_error_select'); ?>');
			return false;
		}
        if (!confirm("<?php echo $this->lang->line('common_delete_confirm') ?>")) {
            return false;
        }
        var arrpath = new Array();
        $('#column-right a.selected').each(function(index) {
            arrpath[index] = $(this).attr("file");
        });
		$.ajax({
			url: '<?php echo site_url('filemanager/delete')?>/?type=<?php echo $type?>',
			type: 'POST',
			data: 'path=' + encodeURIComponent(arrpath),
			dataType: 'json',
			success: function(json) {
				if (json.error) {
					alert(json.error);
					refresh_file();
				}
				else {
					$('#column-right a.selected').remove();
				}
			}
		});

	});


	$('#rename').bind('click', function () {
		$('#dialog').remove();
		if (!$('#column-right a.selected').length || $('#column-right a.selected').length > 1) {
			alert('<?php echo $this->lang->line('fmag_error_select'); ?>');
			return false;
		}
		html  = '<div id="dialog">';
		html += '<?php echo $this->lang->line('fmag_entry_rename'); ?> <input type="text" name="name" value="" /> <input type="button" value="Submit" />';
		html += '</div>';

		$('#column-right').prepend(html);

		$('#dialog').dialog({
			title: '<?php echo $this->lang->line('fmag_entry_rename'); ?>',
			resizable: false
		});

		$('#dialog input[type=\'button\']').bind('click', function () {
			path = $('#column-right a.selected').attr('file');
			var name = $('#dialog input[name=\'name\']').val();
			$.ajax({
				url: '<?php echo site_url('filemanager/rename')?>/?type=<?php echo $type?>',
				type: 'POST',
				data: {path: path,name: name},
				dataType: 'json',
				success: function(json) {
					if (json.error) {
						alert(json.error);
					}
					else {
						$('#dialog').remove();
						$('#column-right a.selected').attr("file",json.path);
						$('#column-right a.selected').find(".img_name").text(json.name);
					}
				}
			});
			
		});
	});

	new AjaxUpload('#upload', {
		action: '<?php echo site_url('filemanager/upload')?>/?type=<?php echo $type?>',
		name: 'image',
        multi: true,
		autoSubmit: false,
		responseType: 'json',
		onChange: function(file, extension) {
			var tree = $('#jstree').jstree(true);
            var node = tree.get_selected  (true);
            if (!node.length || node.length > 1) {
            	alert("<?php echo $this->lang->line("fmag_error_directory"); ?>");
            	return false;
            }
			this.setData({'directory': node[0].id});
			this.submit();
		},
		onSubmit: function(file, extension) {
			$('#upload').append('<img src="<?php echo $theme?>loading.gif" class="loading" style="padding-left: 5px;" />');
		},
		onComplete: function(file, json) {
			if (json.error) {
				alert(json.error);
				return false;
			}
			$('.loading').remove();
			refresh_file();
		}
	});

	$('#refresh').bind('click', function () {
		refresh_folder();
	});
	var arrCopy = new Array();
	var arrMove = new Array();
	$('#copy').bind('click', function () {
		if (!$('#column-right a.selected').length) {
			alert('<?php echo $this->lang->line('fmag_error_select'); ?>');
			return false;
		}
        $('#column-right a.selected').each(function(index) {
            arrCopy[index] = $(this).attr("file");
        });
        arrMove = [];
        $(this).hide();
        $('#paste,#move').show();
	});
	$('#move').bind('click', function () {
		if (!$('#column-right a.selected').length) {
			alert('<?php echo $this->lang->line('fmag_error_select'); ?>');
			return false;
		}
        $('#column-right a.selected').each(function(index) {
            arrMove[index] = $(this).attr("file");
        });
        arrCopy = [];
        $(this).hide();
        $('#paste,#copy').show();
	});
	$('#paste').bind("click",function(){
		var self = $(this);
		var tree = $('#jstree').jstree(true);
		var node = tree.get_selected();
		if (!node.length || node.length > 1) {
			alert('<?php echo $this->lang->line('fmag_error_select'); ?>');
			return false;
		}
		if (arrCopy.length > 0) {
			$.ajax({
				url: '<?php echo site_url('filemanager/copy')?>/?type=<?php echo $type?>',
				type: 'POST',
				data: { 'from' : arrCopy, 'to' : node[0] },
				dataType: 'json',
				success: function(json) {
					if (json.error) {
						alert(json.error);
					}
					else {
						arrCopy = [];
						arrMove = [];
						self.hide();
				        $('#copy,#move').show();
						refresh_file();
					}
				},
				error: function() {
					
				}
			});
		}
		if (arrMove.length > 0) {
			$.ajax({
				url: '<?php echo site_url('filemanager/move')?>/?type=<?php echo $type?>',
				type: 'POST',
				data: { 'from' : arrMove, 'to' : node[0] },
				dataType: 'json',
				success: function(json) {
					if (json.error) {
						alert(json.error);
					}
					else {
						arrCopy = [];
						arrMove = [];
						$(this).hide();
				        $('#copy,#move').show();
						refresh_file();
					}
				},
				error: function() {
					
				}
			});
		}
	});
	$(document).bind("click",function(){
		if ($('#column-right a.selected').length){
			$("#menu").find(".fileaction").show();
		}
		else {
			$("#menu").find(".fileaction").hide();
		}
		if (arrCopy.length > 0 || arrMove.length > 0) {
			$("#paste").show();
		}
		if (arrCopy.length > 0){
			$("#copy").hide();
		}
		if (arrMove.length > 0){
			$("#move").hide();
		}
	});
	var doc_height = $(window).height();
	$("#column-left,#column-right").height(doc_height - 40);
});
//--></script>
</body>
</html>