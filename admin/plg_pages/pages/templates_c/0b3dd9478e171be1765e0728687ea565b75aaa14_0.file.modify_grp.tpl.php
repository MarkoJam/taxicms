<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:48:12
  from 'C:\wamp\www\taxicms\admin\plg_pages\pages\templates\modify_grp.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642abcfc246639_39578370',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0b3dd9478e171be1765e0728687ea565b75aaa14' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_pages\\pages\\templates\\modify_grp.tpl',
      1 => 1666177686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642abcfc246639_39578370 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
echo '<script'; ?>
 type="text/javascript" src="CKeditor/ckeditor/ckeditor.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

	function modify_plugin() {
	//	audio_recording();

	prepare_rows('img');
	insert_row('img','1','');
	prepare_rows('vid');
	insert_row('vid');
	prepare_rows('web');
	insert_row('web');
	prepare_rows('doc');
	insert_row('doc','2','File');

	}

<?php echo '</script'; ?>
>


<div id="content" >
	<form  id='inner' action="modify_final.php" method="post" enctype="multipart/form-data" >
		<input name="mode" type="hidden" id="mode" value="<?php echo $_smarty_tpl->tpl_vars['mode']->value;?>
">
		<div class="row wrapper  page-heading">
			<div class="col-lg-4">
				<h2 id="modi_title"></h2>
			</div>
			<div class="col-lg-8">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
</div>
					<div name="pretvori_u_kategoriju" id="promeni" class="btn btn-info"><i class="fa fa-paste"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_TRANSFORM']->value;
echo $_smarty_tpl->tpl_vars['PLG_CATEGORY']->value;?>
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
                                <li class="<?php if ($_smarty_tpl->tpl_vars['active']->value != 3) {?>active<?php }?>"><a class="active" data-toggle="tab" href="#tab-1"> <?php echo $_smarty_tpl->tpl_vars['PLG_INFO']->value;?>
</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2"> <?php echo $_smarty_tpl->tpl_vars['PLG_SEO']->value;?>
</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-3"> <?php echo $_smarty_tpl->tpl_vars['PLG_CONTENT']->value;?>
</a></li>
																<li class=""><a data-toggle="tab" href="#tab-4"> <?php echo $_smarty_tpl->tpl_vars['PLG_EXT_RES']->value;?>
</a></li>
                            </ul>
							 <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											                                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
</label>
                                                <div class="col-sm-10"><input id='title' type="text" name="header" value="<?php echo $_smarty_tpl->tpl_vars['header']->value;?>
" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
"></div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_TEMPLATE']->value;?>
</label>
                                                <div class="col-sm-10">
												     <select name="template_id" class="form-control">
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['tmpl_values']->value,'selected'=>$_smarty_tpl->tpl_vars['tmpl_selected']->value,'output'=>$_smarty_tpl->tpl_vars['tmpl_output']->value),$_smarty_tpl);?>

													 </select>
												</div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_STATUS']->value;?>
</label>
                                                <div class="col-sm-10">
													<select name="statusid" class="form-control">
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['status_val']->value,'selected'=>$_smarty_tpl->tpl_vars['status_sel']->value,'output'=>$_smarty_tpl->tpl_vars['status_out']->value),$_smarty_tpl);?>

													 </select>
												</div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_ACCESS']->value;?>
</label>
                                                <div class="col-sm-10">
													<select name="protection_id" onchange="javascript:UpdateRole();" class="form-control">
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['pageprotection_val']->value,'selected'=>$_smarty_tpl->tpl_vars['pageprotection_sel']->value,'output'=>$_smarty_tpl->tpl_vars['pageprotection_out']->value),$_smarty_tpl);?>

													</select>
												</div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_USERROLE']->value;?>
</label>
                                                <div class="col-sm-10">
													<select name="userroleid" class="form-control">
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['userrole_val']->value,'selected'=>$_smarty_tpl->tpl_vars['userrole_sel']->value,'output'=>$_smarty_tpl->tpl_vars['userrole_out']->value),$_smarty_tpl);?>

													</select>
												</div>
											</div>
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PARENT']->value;?>
</label>
                                                <div class="col-sm-10">
													<?php echo $_smarty_tpl->tpl_vars['parentPageCmb']->value;?>

												</div>
											</div>
                                        </fieldset>

                                    </div>
                                </div>
								<div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_KEYWORDS']->value;?>
</label>
                                                <div class="col-sm-10"><input name="keywords" type="text" value="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_KEYWORDS']->value;?>
"></div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
</label>
                                                <div class="col-sm-10"><input name="description" type="text" value="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
"></div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_FREQ']->value;?>
</label>
                                                <div class="col-sm-10">
													<select name="frequency" class="form-control">
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['freq_val']->value,'selected'=>$_smarty_tpl->tpl_vars['freq_sel']->value,'output'=>$_smarty_tpl->tpl_vars['freq_out']->value),$_smarty_tpl);?>

													</select>
												</div>
											</div>
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRIORITY']->value;?>
</label>
                                                <div class="col-sm-10">
													<select name="priority" class="form-control">
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['prior_val']->value,'selected'=>$_smarty_tpl->tpl_vars['prior_sel']->value,'output'=>$_smarty_tpl->tpl_vars['prior_out']->value),$_smarty_tpl);?>

													</select>
												</div>
											</div>
										</fieldset>
                                    </div>
                                </div>
								<div id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											
											<div class="form-group"><label class="col-sm-2 control-label">Sadržaj stranice</label>
												<div class="col-sm-10">
														<textarea id="rtel" name="rtel"><?php echo $_smarty_tpl->tpl_vars['html']->value;?>
</textarea>
														<?php echo '<script'; ?>
 type="text/javascript">
														
															CKEDITOR.replace( 'rtel',
																 { height:'200',
																	 width:'650',
																	 disallowedContent : 'img{width,height}'
																	});
														
														<?php echo '</script'; ?>
>
												</div>
											</div>
											<div class="form-group"><label class="col-sm-2 control-label">Sadržaj ispod naslova</label>
												<div class="col-sm-10">
													<textarea id="rtelsmall" name="rtelsmall"><?php echo $_smarty_tpl->tpl_vars['shorthtml']->value;?>
</textarea>
													<?php echo '<script'; ?>
 type="text/javascript">
													
														CKEDITOR.replace( 'rtelsmall',
															 { height:'200',
															   width:'650',
																 disallowedContent : 'img{width,height}'
															  });
													
													<?php echo '</script'; ?>
>
												</div>
											</div>
										</fieldset>
                  </div>
                </div>
								<div id="tab-4" class="tab-pane">
									<div class="panel-body">
										<fieldset class="form-horizontal">
											<?php echo $_smarty_tpl->tpl_vars['img_rows']->value;?>

											<div class="hr-line-dashed"></div>
											<?php echo $_smarty_tpl->tpl_vars['vid_rows']->value;?>

											<div class="hr-line-dashed"></div>
											<?php echo $_smarty_tpl->tpl_vars['web_rows']->value;?>

											<div class="hr-line-dashed"></div>
											<?php echo $_smarty_tpl->tpl_vars['doc_rows']->value;?>

										</fieldset>
									</div>
								</div>
							</div>
						</div>
					</div>
						<input name="page_id" type="hidden" id="page_id" value="<?php echo $_smarty_tpl->tpl_vars['page_id']->value;?>
">
						<input name="parent_id_old" type="hidden" id="parent_id" value="<?php echo $_smarty_tpl->tpl_vars['parent_id']->value;?>
">
						<input name="navigationtype" type="hidden" id="navigationtype" value="<?php echo $_smarty_tpl->tpl_vars['navigationtype']->value;?>
">
						<input name="createdby" type="hidden" id="createdby" value="<?php echo $_smarty_tpl->tpl_vars['createdby']->value;?>
">
						<input name="createddate" type="hidden" id="createddate" value="<?php echo $_smarty_tpl->tpl_vars['createddate']->value;?>
">
						<input name="modifyby" type="hidden" id="modifyby" value="<?php echo $_smarty_tpl->tpl_vars['modifyby']->value;?>
">
						<input name="modifydate" type="hidden" id="modifydate" value="<?php echo $_smarty_tpl->tpl_vars['modifydate']->value;?>
">

						<input name="header_old" type="hidden" id="header" value="<?php echo $_smarty_tpl->tpl_vars['header']->value;?>
">
						<input name="order" type="hidden" id="order" value="<?php echo $_smarty_tpl->tpl_vars['order']->value;?>
">
						<input name="pagetypeid" type="hidden" id="pagetypeid" value="<?php echo $_smarty_tpl->tpl_vars['pagetypeid']->value;?>
">
					</form>
				</div>
<?php }
}
