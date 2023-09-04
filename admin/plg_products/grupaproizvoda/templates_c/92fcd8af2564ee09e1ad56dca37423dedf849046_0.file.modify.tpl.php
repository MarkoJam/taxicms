<?php
/* Smarty version 3.1.32, created on 2020-09-05 10:41:58
  from 'C:\wamp\www\mobillwood\admin\plg_products\grupaproizvoda\templates\modify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5f534f5667f353_69073473',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '92fcd8af2564ee09e1ad56dca37423dedf849046' => 
    array (
      0 => 'C:\\wamp\\www\\mobillwood\\admin\\plg_products\\grupaproizvoda\\templates\\modify.tpl',
      1 => 1599295316,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f534f5667f353_69073473 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\mobillwood\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\wamp\\www\\mobillwood\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
?>  	   <!-- iCheck -->
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
js/plugins/iCheck/icheck.min.js"><?php echo '</script'; ?>
>

	<?php echo '<script'; ?>
>
    
        function modify_plugin() {
            // promena href u data
			$('#inner table a').each(function() {
                var href = $(this).attr('href');
                $(this).removeAttr('href');
                $(this).attr('data-link',(href.split('?'))[0]);
				$(this).attr('data-param',(href.split('?'))[1]);
            });	
		
			// pomeranje-sortiranje redova tabele
			$('#inner #normal tbody').attr('id', 'tabledivbody');
			$('#inner #tabledivbody tr').addClass('sectionsid');
			$('#inner #tabledivbody tr').hover(function() {
				$(this).toggleClass('highlight');
			});
			$('#inner #tabledivbody').sortable({
				revert: true,
				items: 'tr:not(.header)',
				axis: 'y',
				cursor: 'move',
				opacity: 0.6,
				update: function() {
					sendOrderToServer();
				}
			});
			$('#inner #tabledivbody tr').disableSelection();
				// section id za upisivanje u sql tabelu
				
			$('#inner #normal tr').each(function() {
				if (!($(this).attr('class')=='header')) {
					var id=($(this).children('td:first').children('a').attr('data-param'));
					id = id.substr(id.lastIndexOf("=")+1);
					id= 'sectionsid_'+id;
					$(this).attr('id',id);
				}
			});	
			function sendOrderToServer() {
				var gpid=$('#inner #grupaproizvodaid').val();
				var link = 'plg_products/grupaproizvoda/move_product_in_group.php';
				var order = $('#inner #tabledivbody').sortable('serialize')+'&grupaproizvodaid='+gpid;
				$.ajax({
					type: 'POST',
					url: link,
					data: order,
					success: function(data) {}
				});
			}
		
            $("#inner .obrisi-proizvod").click(function() {
                var obrisiParams = 'obrisiParams='+$(this).attr("tag");
                $(this).parent().parent().remove();				
                $.ajax({
                    url: "plg_products/grupaproizvoda/delete_product_from_group.php",
                    data: obrisiParams,
                    success: function(data) {
						var klasa = $(data).attr('class');
						toastr[klasa](data);					
                    }
                });
            });

			$("#inner .naziv").click(function() {
                var param = $(this).attr('data-param');
				window.gpid=$('#inner #grupaproizvodaid').val();
                $.ajax({
                    url: "plg_products/proizvod/modify.php",
                    data: param,
                    success: function(data) {
						$('.backdrop').css("display", "none").empty();					
						$('.backdrop').css("display", "block").html(data);
						$('#inner .title-action #promeni').click(function() {
							modify();	
							})					
                    }
                });
			});
        };
    
	<?php echo '</script'; ?>
>


<div id="content">
	<form name="editcategory" id="inner" action="modify_final.php" method="post" enctype="multipart/form-data">
	<input name="mode" type="hidden" id="mode" value="<?php echo $_smarty_tpl->tpl_vars['mode']->value;?>
">				
		<div class="row wrapper  page-heading">
                <div class="col-lg-8">
                    <h2 id="modi_title"></h2>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
						<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i> <?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
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
                                <li class=""><a data-toggle="tab" href="#tab-2"> <?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
</a></li>
                                <li class="<?php if ($_smarty_tpl->tpl_vars['active']->value == 3) {?>active<?php }?>"><a data-toggle="tab" href="#tab-3"> <?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCTS']->value;?>
</a></li>
                            </ul>
							 <div class="tab-content">
                                <div id="tab-1" class="tab-pane <?php if ($_smarty_tpl->tpl_vars['active']->value != 3) {?>active<?php }?>">
                                    <div class="panel-body">
										<fieldset class="form-horizontal">
                                            <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
</label>
                                                <div class="col-sm-10"><input name="naziv" type="text" value="<?php echo $_smarty_tpl->tpl_vars['naziv']->value;?>
" class="form-control" size="40"></div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_PARENT']->value;?>
</label>
                                                <div class="col-sm-10"><?php echo $_smarty_tpl->tpl_vars['parentgrpCmb']->value;?>
</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_TEMPLATE']->value;?>
</label>
												<div class="col-sm-10">
													<select id="templateid" name="templateid" class="form-control">
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['template_val']->value,'selected'=>$_smarty_tpl->tpl_vars['template_sel']->value,'output'=>$_smarty_tpl->tpl_vars['template_out']->value),$_smarty_tpl);?>

													</select>
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_STATUS']->value;?>
</label>
												<div class="col-sm-10">
													<select id="statusid" name="statusid" class="form-control">
														<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['status_val']->value,'selected'=>$_smarty_tpl->tpl_vars['status_sel']->value,'output'=>$_smarty_tpl->tpl_vars['status_out']->value),$_smarty_tpl);?>

													</select>
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_IMAGE']->value;?>
</label>
												<div class="col-sm-6">
												   <input id="slika" name="slika" type="text" value="<?php echo $_smarty_tpl->tpl_vars['slika']->value;?>
"  class="form-control image">
												</div>
												<div class="col-sm-2">
												  <a class="btn btn-success" href="javascript:BrowseServer(this);"><i class="fa fa-plus-square-o" ></i> <?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</a>
												</div>
												<div class="col-sm-2">
												  <a data-toggle="modal" data-target="#myModal7"><img class="image-title" src="<?php echo $_smarty_tpl->tpl_vars['slika']->value;?>
"  /><div class="overlay-icon"></div></a>
												</div>
											</div>	
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_OPTION']->value;?>
</label>

											<div class="col-sm-10">
												<div class="checkbox checkbox-inline checkbox-primary">
													<input type="checkbox" name="congroup" <?php if ($_smarty_tpl->tpl_vars['congroup']->value == 1) {?> checked <?php }?> >
													<label for="inlineCheckbox1"> <?php echo $_smarty_tpl->tpl_vars['PLG_CON']->value;?>
  </label>
												</div>
												<div class="checkbox checkbox-inline checkbox-primary">
													<input type="checkbox" name="nlgroup" <?php if ($_smarty_tpl->tpl_vars['nlgroup']->value == 1) {?> checked <?php }?>>
													<label for="inlineCheckbox1"> <?php echo $_smarty_tpl->tpl_vars['PLG_NL']->value;?>
  </label>
												</div>
												<div class="checkbox checkbox-inline checkbox-primary">
													<input type="checkbox" name="kitgroup" <?php if ($_smarty_tpl->tpl_vars['kitgroup']->value == 1) {?> checked <?php }?> >
													<label for="inlineCheckbox1"> <?php echo $_smarty_tpl->tpl_vars['PLG_KIT']->value;?>
 </label>
												</div>
											</div>
                               
										</fieldset>
                                    </div>
                                </div>
								<div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
</label>
                                                <div class="col-sm-10">
													<textarea id="opis" name="opis"><?php echo $_smarty_tpl->tpl_vars['opis']->value;?>
</textarea>
														<?php echo '<script'; ?>
 type="text/javascript">
															
															CKEDITOR.replace('opis', {
																height: '150',
																width: '800'
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
                                        <fieldset class="form-horizontal">
											<div class="row">
												<div class="col-lg-12">
													<h2><?php echo $_smarty_tpl->tpl_vars['PLG_']->value;?>
</h2>
												</div>
											</div>
											<div class="table-responsive">
											<?php if ($_smarty_tpl->tpl_vars['table_not_empty']->value) {?> <?php echo smarty_function_html_table_advanced(array('browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','message'=>$_smarty_tpl->tpl_vars['poruka']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value),$_smarty_tpl);?>
 <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['PLG_NONE']->value;?>
 <?php }?>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
                  
                        <input name="grupaproizvodaorder" type="hidden" id="grupaproizvodaorder" value="<?php echo $_smarty_tpl->tpl_vars['grupaproizvodaorder']->value;?>
">
                        <input name="grupaproizvodaid" type="hidden" id="grupaproizvodaid" value="<?php echo $_smarty_tpl->tpl_vars['grupaproizvodaid']->value;?>
">
                        <input name="type" type="hidden" id="type" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
						<div class="backdrop"></div>
        </form>
    </div><?php }
}
