/**
 * @license Edit and use as you want
 *
 * Creato da TurboLab.it - 01/01/2014 (buon anno!)
 * Modified by Eric van Eldik
 */
CKEDITOR.dialog.add( 'contactDialog', function( editor ) {

    return {
        title: 'Insert Contact',
        minWidth: 400,
        minHeight: 75,
        contents: [
            {
                id: 'tab-basic',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'select',
                        id: 'contact',
                        default: 'form_contact',
                        items: [ [ 'Form liên hệ','form_contact' ] ],
                        label: 'Choose your option'

                    },
                    {
                        type: 'text',
                        id: 'contact_name',
                        label: 'Form name'
                    },
                    {
                        type: 'select',
                        id: 'contact_input',
                        default: ['phone','branch'],
                        items: [ [ 'So dien thoai','phone' ], [ 'Co so','branch' ], [ 'Khu vuc','location' ] ],
                        label: 'Select input',
                        style: 'height: 50px',
                        multiple: true
                    },
                ],
                onChange: function( api ) {
                    // this = CKEDITOR.ui.dialog.select
                    alert( 'Current value: ' + this.getValue() );
                }
            }
        ],
        onOk: function() {
            var dialog = this;
			var url=dialog.getValueOf( 'tab-basic', 'contact').trim();
            var name = dialog.getValueOf( 'tab-basic', 'contact_name').trim();
			var form_input = dialog.getValueOf( 'tab-basic', 'contact_input').trim();
            var oP = editor.document.createElement( 'div' );
            oP.setAttribute( 'data-type', url);
            oP.setAttribute( 'class', 'ck_detail_' + url);
            oP.setAttribute( 'data-name', name);
            oP.setAttribute( 'data-input', form_input);
            editor.insertElement( oP );
        }
    };
});