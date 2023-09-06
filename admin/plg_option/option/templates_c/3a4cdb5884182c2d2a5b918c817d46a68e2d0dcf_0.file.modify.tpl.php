<?php
/* Smarty version 3.1.32, created on 2023-09-06 12:06:01
  from 'C:\wamp\www\taxicms\admin\plg_option\option\templates\modify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64f84f098d1aa0_91281304',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3a4cdb5884182c2d2a5b918c817d46a68e2d0dcf' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_option\\option\\templates\\modify.tpl',
      1 => 1693994756,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64f84f098d1aa0_91281304 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
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
		$('#publishingdatum').datetimepicker({
			format:'d.m.Y H:i'
		});

		$('.input-group.date').datepicker({
			  todayBtn: "linked",
			  keyboardNavigation: false,
			  forceParse: false,
			  calendarWeeks: true,
			  autoclose: true,
			  format: "dd. mm. yyyy",
			  language: "sr-latin"
		});

		$(document).ready(function() {
			delete_conres();
			$('.title-actionconres #insert_conres').click(function() {
				var crid = $('#conres1 option:selected').val();
				var nid = $('#option_id').val();
				var mode = $('#mode').val();
				var link = 'insert_conres.php';
				var param = 'conres_id='+crid+'&res_id='+nid+'&class=Option'+'&mode='+mode;
				if (mode=='insert') mode='insert2';
				window.param2='mode='+mode+'&option_id='+nid+'&active=3'+param_add() + '&cnc=1';
				update2(link,param);
			})

		})
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
						<li class="<?php if ($_smarty_tpl->tpl_vars['active']->value != 3) {?>active<?php }?>"><a data-toggle="tab" href="#tab-1"> <?php echo $_smarty_tpl->tpl_vars['PLG_INFO']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-2"> <?php echo $_smarty_tpl->tpl_vars['PLG_CONTENT']->value;?>
</a></li>
						<li class="<?php if ($_smarty_tpl->tpl_vars['active']->value == 3) {?>active<?php }?>"><a data-toggle="tab" href="#tab-3"> <?php echo $_smarty_tpl->tpl_vars['PLG_CON']->value;?>
</a></li>
						<li class=""><a data-toggle="tab" href="#tab-4"> <?php echo $_smarty_tpl->tpl_vars['PLG_EXT_RES']->value;?>
</a></li>
					</ul>
					<div class="tab-content">

                        <div id="tab-1" class="tab-pane  <?php if ($_smarty_tpl->tpl_vars['active']->value != 3) {?>active<?php }?>">
                            <div class="panel-body">
                                <fieldset class="form-horizontal">
                                                                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
</label>
                                        <div class="col-sm-10"><input type="text" id='title' name="header" value="<?php echo $_smarty_tpl->tpl_vars['header']->value;?>
" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
"></div>
                                    </div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICE']->value;?>
</label>
										<div class="col-sm-10"><input type="text" name="price" value="<?php echo $_smarty_tpl->tpl_vars['price']->value;?>
" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_PRICE']->value;?>
"></div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PUBLISHINGDATE']->value;?>
</label>
										<div class="col-sm-10">
											<input id="publishingdatum" name="publishingdate" type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['publishingdatum']->value;?>
">
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
									<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_MODULES']->value;?>
</label>
										<div class="col-sm-10">
											<select name="moduleid" class="form-control">
												<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['module_val']->value,'selected'=>$_smarty_tpl->tpl_vars['module_sel']->value,'output'=>$_smarty_tpl->tpl_vars['module_out']->value),$_smarty_tpl);?>

											</select>
										</div>
									</div>
																		<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_DATE']->value;?>
</label>
										<div class="col-sm-10">
											<div class="input-group date" data-provide="datepicker">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input name="datum" type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['datum']->value;?>
">
											</div>

										</div>
									</div>
																		<div class="form-group">
										<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PRICE']->value;?>
</label>
										<div class="col-sm-8">
											<input name="price" type="text" value="<?php echo $_smarty_tpl->tpl_vars['price']->value;?>
" size="20" class="form-control">
										</div>
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

						<div id="tab-3" class="tab-pane <?php if ($_smarty_tpl->tpl_vars['active']->value == 3) {?>active<?php }?>">
							<div class="panel-body">
								<div class="panel-body">
									<fieldset class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="Pitanje"> <?php echo $_smarty_tpl->tpl_vars['PLG_CON2']->value;?>
 </label>

											<div class="col-sm-8">
												<select id="conres1" name="conres1" class="chosen-select">
													<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['conres_val']->value,'output'=>$_smarty_tpl->tpl_vars['conres_out']->value),$_smarty_tpl);?>

												</select>
											</div>
											<div class="col-sm-2">
												<div class="title-actionconres">
													<div name="promeni" id="insert_conres" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</div>
												</div>
											</div>
										</div>
										<div class="table-responsive">
											<?php if ($_smarty_tpl->tpl_vars['tbl_all_rows_count']->value > 0) {?>
											<?php echo smarty_function_html_table_advanced(array('filter'=>$_smarty_tpl->tpl_vars['filter']->value,'content'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'exportlinks'=>$_smarty_tpl->tpl_vars['tbl_show_export_links']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','message'=>$_smarty_tpl->tpl_vars['poruka']->value),$_smarty_tpl);?>

												<?php }?>
										</div>
									</fieldset>
								</div>
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
				<input name="option_id" type="hidden" id="option_id" value="<?php echo $_smarty_tpl->tpl_vars['optionid']->value;?>
">
			</div>
		</div>
	</form>
</div>
<?php }
}
