
CKEDITOR.scriptLoader.load( CKEDITOR.plugins.getPath( 'tooltip' ) + 'tooltip.php' );

CKEDITOR.plugins.add('tooltip', {
    requires: 'colordialog',
    icons: 'tooltip',

    init: function(editor) {
    	var config = editor.config;


        CKEDITOR.dialog.add('tooltipDialog', this.path + 'dialogs/tooltip.js');
        editor.addCommand( 'tooltip', new CKEDITOR.dialogCommand( 'tooltipDialog', { extraAllowedContent: 'span[class]{color,font-size}(*);data-toggle[*]{*}' }));
        editor.ui.addButton( 'tooltip', {
              label: 'Insert ToolTip',
              command: 'tooltip',
              toolbar: 'insert',
        });
    }
});
