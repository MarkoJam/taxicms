<?php
/* Smarty version 3.1.32, created on 2023-04-03 14:03:45
  from 'C:\wamp\www\taxicms\admin\plg_universal\sections\templates\modify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ac0a1ccd162_19917423',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cb0fb2b387e8d477ff146ff16d88a87dae6ad692' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_universal\\sections\\templates\\modify.tpl',
      1 => 1671542194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ac0a1ccd162_19917423 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
echo '<script'; ?>
 type="text/javascript" src="CKeditor/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

	function modify_plugin() {
		BrowseImageData();
		if (window.title) $('#inner #modi_title').text(window.title);
		prepare_rows('img');
		insert_row('img','1','');
		prepare_rows('vid');
		insert_row('vid');
		prepare_rows('web');
		insert_row('web');
		prepare_rows('doc');
		insert_row('doc','2','documents');

		$('.chosen-select').chosen({width: "100%"});


	}

<?php echo '</script'; ?>
>

<div id="content">
	<form  id='inner' action="modify_final.php" method="post" enctype="multipart/form-data" >
		<input name="mode" type="hidden" id="mode" value="<?php echo $_smarty_tpl->tpl_vars['mode']->value;?>
">
		<div class="row wrapper  page-heading">
			<div class="col-lg-8">
				<h2 id="modi_title"></h2>
			</div>
			<div class="col-lg-4">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
</div>
					<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_CLOSE']->value;?>
</div>
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-lg-12">
				<div class="tabs-container">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-1"> <?php echo $_smarty_tpl->tpl_vars['PLG_INFO']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-2"> <?php echo $_smarty_tpl->tpl_vars['PLG_CONTENT']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-3"> <?php echo $_smarty_tpl->tpl_vars['PLG_EXT_RES']->value;?>
</a></li>
					</ul>
					<div class="tab-content">

                        <div id="tab-1" class="tab-pane  active">
                            <div class="panel-body">
                                <fieldset class="form-horizontal">
                                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
</label>
                                        <div class="col-sm-10"><input type="text" id='title' name="header" value="<?php echo $_smarty_tpl->tpl_vars['header']->value;?>
" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
"></div>
                                    </div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_STATUS']->value;?>
</label>
										<div class="col-sm-10">
											<select name="statusid" class="form-control">
												<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['status_val']->value,'selected'=>$_smarty_tpl->tpl_vars['status_sel']->value,'output'=>$_smarty_tpl->tpl_vars['status_out']->value),$_smarty_tpl);?>

											</select>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_CATEGORY']->value;?>
</label>
										<div class="col-sm-10">
											<div>
											<select size="5" multiple="multiple" name="sectionscategories[]" class="chosen-select">
												<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['sectionscategory_val']->value,'selected'=>$_smarty_tpl->tpl_vars['sectionscategory_sel']->value,'output'=>$_smarty_tpl->tpl_vars['sectionscategory_out']->value),$_smarty_tpl);?>

											</select>
											</div>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE']->value;?>
</label>
										<div class="col-sm-6">
										   <input id="slika" name="slika" type="text" value="<?php echo $_smarty_tpl->tpl_vars['slika']->value;?>
" class="form-control image">
										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServer(this);"><i class="fa fa-plus-square-o" ></i> <?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</a>
										</div>
										<div class="col-sm-2">
										 <a data-toggle="modal" data-target="#myModal7"><img class="image responsive image-title" src="<?php echo $_smarty_tpl->tpl_vars['slika']->value;?>
"  /><div class="overlay-icon"></div></a>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">Video</label>
										<div class="col-sm-6">
										 										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServerVideo(this);"><i class="fa fa-plus-square-o" ></i> <?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
 video</a>
										</div>
										<div class="col-sm-2">
											<video class="responsive" autoplay muted loop>
									    	<source class="video" src="<?php echo $_smarty_tpl->tpl_vars['slika']->value;?>
" type="video/mp4" />
									  	</video>
										</div>
									</div>
                                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_LINK']->value;?>
</label>
                                        <div class="col-sm-10"><input type="text" id='section_link' name="section_link" value="<?php echo $_smarty_tpl->tpl_vars['sectionlink']->value;?>
" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_LINK']->value;?>
"></div>
                                    </div>
                                </fieldset>
                            </div>
						</div>
						<div id="tab-2" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_SHORTDESCRIPTION']->value;?>
</label>
										<div class="col-sm-10">
											<textarea id="rtelsmall" name="rtelsmall"><?php echo $_smarty_tpl->tpl_vars['shorthtml']->value;?>
</textarea>
											<?php echo '<script'; ?>
 type="text/javascript">
											
												CKEDITOR.replace( 'rtelsmall',
													 { height:'100',
													   width:'650'
													  });
											
											<?php echo '</script'; ?>
>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
</label>
										<div class="col-sm-10">
												<textarea id="rtel" name="rtel"><?php echo $_smarty_tpl->tpl_vars['html']->value;?>
</textarea>
												<?php echo '<script'; ?>
 type="text/javascript">
												
													CKEDITOR.replace( 'rtel',
														 { height:'200',
														   width:'650'
														  });
												
												<?php echo '</script'; ?>
>
										</div>
									</div>
								</fieldset>
							</div>
						</div>

						<div id="tab-3" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<?php echo $_smarty_tpl->tpl_vars['img_rows']->value;?>

								</fieldset>
							</div>
						</div>
					</div>
				<input name="sections_id" type="hidden" id="sections_id" value="<?php echo $_smarty_tpl->tpl_vars['sectionsid']->value;?>
">
			</div>
		</div>
	</form>
</div>
<?php }
}
