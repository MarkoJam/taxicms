CKEDITOR.dialog.add( 'accordionDialog', function ( editor ) {
    return {
        title: 'Konfiguracija polja',
        minWidth: 400,
        minHeight: 200,
        contents: [
            {
                id: 'tab-basic',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'number',
                        label: 'Broj polja koja se otvaraju',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Broj ne moze biti prazan" )
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;
            var sections = parseInt(dialog.getValueOf('tab-basic','number')); //Número de seções que serão criadas

            section = "<h5>Naziv polja</h5><div><p>Tekst koji se nalazi u polju</p></div>"
            intern = ""
            for (i=0;i<sections;i++){
                intern = intern + section
            }

            editor.insertHtml('<div class="accordion">'+ intern +'</div>');

        }
    };
});
