/**
 * @license Modifica e usa come vuoi
 *
 * Creato da TurboLab.it - 01/01/2014 (buon anno!)
 */
CKEDITOR.plugins.add( 'contact', {
    icons: 'contact',
    init: function( editor ) {
        editor.addCommand( 'contactDialog', new CKEDITOR.dialogCommand( 'contactDialog' ) );
        editor.ui.addButton( 'contact', {
            label: 'Insert contact',
            command: 'contactDialog',
            toolbar: 'paragraph'
        });

        CKEDITOR.dialog.add( 'contactDialog', this.path + 'dialogs/contact.js' );
    }
});