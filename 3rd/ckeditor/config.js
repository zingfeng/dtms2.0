/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.baseHref = '/uploads/';
	config.filebrowserBrowseUrl = SITE_URL+'/filemanager/?type=url';
	config.filebrowserImageBrowseUrl = SITE_URL+'/filemanager/?type=image';
	config.filebrowserFlashBrowseUrl = SITE_URL+'/filemanager/?type=flash';
	config.filebrowserUploadUrl = SITE_URL+'/filemanager/fast_upload?type=file';
	config.filebrowserImageUploadUrl = SITE_URL+'/filemanager/fast_upload?type=image';
	config.filebrowserFlashUploadUrl = SITE_URL+'/filemanager/fast_upload?type=flash';
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.allowedContent = true;
	config.removeFormatAttributes = '';

	config.templates = 'default';
	// config.templates_files = [ '/mytemplates/mytemplates.js' ];
	config.templates_replaceContent = false;

	config.htmlEncodeOutput = false;
    config.pasteFromWordPromptCleanup = true;
    config.basicEntities = false;
    config.entities = false;
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.removePlugins = 'elementspath,about';
    config.extraPlugins = 'uploadimage,html5audio';
   	
   	config.toolbar_simple = [
    	[ 'Source', '-', 'Bold', 'Italic', 'BulletedList' ]
	];
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
	config.removeButtons = 'Save,NewPage,Preview,Print,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,Language,About';

    //config.toolbar = 'Full';
    config.contentsCss = ['/theme/frontend/default/lib/bootstrap/css/bootstrap.min.css','/theme/frontend/default/css/tqn_portal.css?v=2'];
};
