/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.dtd.$removeEmpty['i'] = false;

CKEDITOR.editorConfig = function( config ) {
	// %REMOVE_START%
	// The configuration options below are needed when running CKEditor from source files.
//	config.plugins = 'dialogui,dialog,about,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,clipboard,button,panelbutton,panel,floatpanel,colorbutton,colordialog,templates,menu,contextmenu,div,resize,toolbar,elementspath,enterkey,entities,popup,filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo,font,format,horizontalrule,htmlwriter,iframe,wysiwygarea,image,indent,indentblock,indentlist,justify,link,internpage,list,liststyle,magicline,maximize,newpage,pagebreak,pastetext,pastefromword,preview,print,removeformat,save,selectall,showblocks,showborders,sourcearea,specialchar,stylescombo,tab,table,tabletools,undo,backgrounds,lineutils,widget,btgrid,widgetbootstrap,bootstrapVisibility,tableresize,videodetector';

	config.plugins = 'a11yhelp,a11ychecker,about,basicstyles,bidi,blockquote,clipboard,colorbutton,colordialog,contextmenu,copyformatting,dialogadvtab,div,elementspath,enterkey,entities,filebrowser,find,flash,floatingspace,font,format,forms,horizontalrule,htmlwriter,iframe,image,indentblock,indentlist,justify,language,link,internpage,list,liststyle,magicline,maximize,newpage,pagebreak,pastefromword,pastetext,preview,print,removeformat,resize,save,scayt,selectall,showblocks,showborders,smiley,sourcearea,specialchar,stylescombo,tab,table,tabletools,templates,toolbar,undo,wsc,wysiwygarea,widget,widgetbootstrap,tableresize,videodetector,tooltip,ckawesome,html5video,accordion';

	config.skin = 'moono-lisa';
//	config.preset = 'full';
	// %REMOVE_END%

	// Define changes to default configuration here. For example:
		config.language = 'sr-latn';
	// config.uiColor = '#AADC6E';

  config.filebrowserBrowseUrl = CKEDITOR.basePath + '../filemanager/dialog.php?type=2&editor=ckeditor&fldr=documents';
	config.filebrowserImageBrowseUrl = CKEDITOR.basePath + '../filemanager/dialog.php?type=1&editor=ckeditor&fldr=images';
	config.filebrowserUploadUrl = CKEDITOR.basePath + '../filemanager/dialog.php?type=2&editor=ckeditor&fldr=documents';
	config.filebrowserImageUploadUrl = CKEDITOR.basePath + '../filemanager/dialog.php?type=2&editor=ckeditor&fldr=images';

	config.contentsCss = CKEDITOR.basePath + 'contents.css';

	config.entities_latin = false;

	config.protectedSource.push(/<i[^>]*><\/i>/g);

	config.extraPlugins = 'videodetector,widgetbootstrap,tooltip,ckawesome,html5video,widget,widgetselection,clipboard,lineutils,a11ychecker,balloonpanel,accordion';

	config.resize_dir = 'both';

	config.pasteFilter = 'null';

	config.basicEntities = false; // dodato za sprecavanje unosa non-breake space karaktera

	config.allowedContent = true;
//	config.extraAllowedContent = 'img[widht,height]';
	config.extraAllowedContent = 'data-toggle[*]{*}';

	config.disallowedContent = 'img{width,height}';
//	config.coreStyles_bold = {
 //   element: 'font',
 //   attributes: { 'style': 'font-weight: bold;' },
 //   overrides: 'strong'
//};

	//config.toolbar = ['VideoDetector'];
		config.toolbar = 'Full';

config.toolbar_Full =
[
	{ name: 'document', items : [ 'A11ychecker','Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates','Accordion' ] },
	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	{ name: 'editing', items : [ 'Find','Replace','-','SelectAll'] },
	'/',
	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','CopyFormatting','RemoveFormat' ] },
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
	'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
	{ name: 'insert', items : [ 'Image','Flash','VideoDetector','html5video','Table','HorizontalRule','SpecialChar','PageBreak','Iframe','-','Btgrid','WidgetbootstrapLeftCol','WidgetbootstrapRightCol','WidgetbootstrapTwoCol','WidgetbootstrapThreeCol','WidgetbootstrapFourCol' ] },
	'/',
	{ name: 'styles', items : [ 'Styles','Format','FontSize' ] },
	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	{ name: 'tools', items : [ 'Maximize', 'ShowBlocks' ] },
	{ name: 'tooltip', items: ['tooltip'] },
	{ name: 'CKAwesome', items: ['ckawesome'] }
];


config.toolbar_Mail =
[
	{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	{ name: 'editing', items : [ 'Find','Replace','-','SelectAll' ] },
	'/',
	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','CopyFormatting','RemoveFormat' ] },
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
	'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
	{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','SpecialChar','Iframe' ] },
	'/',
	{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-' ] }
];


config.toolbar_Basic =
[
	['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-']
];

config.toolbar_Tooltip =
[
	['Bold','Italic','Underline','Strike', '-', 'Link', 'Unlink','-']
];
};
