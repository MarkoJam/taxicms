// plugin za CKEditor tooltip 
( function() {
	

	CKEDITOR.dialog.add('tooltipDialog', function( editor) {
		return {
        title: 'Insert ToolTip',
        minWidth: 200,
        minHeight: 200,

        contents: [
            {
                id: 'options',
                elements: [
                    {
                        type: 'select',
                        id: 'tooltipname',
                        label: 'Select  tooltip',
                        items: TTSelectBox,
						onChange: function () {
									var id= this.getDialog().getValueOf('options','tooltipname');
									var url=  CKEDITOR.plugins.getPath('tooltip') + 'ttgethtml.php';
									var param = 'id='+id;
									//alert (url);
									//alert (param);
									$.ajax({
										url: url,
										type: 'post',
										data: param,
										async: false,
										success: function(data) {
												window.html=data;
											},
									});
									var html=window.html;
									this.getDialog().setValueOf('options','tipcontent',html);
						}
                    },				
                    {
                        type: 'textarea',
                        id: 'tipcontent',
						onLoad: function() {
							this.getDialog().getContentElement('options','tipcontent').disable();
						},
						
                    }					
                ]
            },
        ],
        onOk: function() {
            var cka_tt = this.getValueOf( 'options', 'tooltipname' );
			
			var attributes = {
				id: cka_tt,
				title: 'TT'+cka_tt,
		//		style: cka_style,
				class: 'tooltip_new',
				'data-toggle': 'tooltip',
				'data-html': 'true'
			};			
			var style = new CKEDITOR.style( { element: 'span', attributes: attributes } );
			style.type = CKEDITOR.STYLE_INLINE;
			editor.applyStyle( style );
        }
    };
	});
}) ();