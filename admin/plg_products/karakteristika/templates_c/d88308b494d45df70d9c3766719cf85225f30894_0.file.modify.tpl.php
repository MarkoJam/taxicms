<?php
/* Smarty version 3.1.32, created on 2020-09-05 09:49:00
  from 'C:\wamp\www\mobillwood\admin\plg_products\karakteristika\templates\modify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5f5342ecb1fd61_83593737',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd88308b494d45df70d9c3766719cf85225f30894' => 
    array (
      0 => 'C:\\wamp\\www\\mobillwood\\admin\\plg_products\\karakteristika\\templates\\modify.tpl',
      1 => 1576216810,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f5342ecb1fd61_83593737 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\mobillwood\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
echo '<script'; ?>
 type="text/javascript" language="javascript1.2">
	
	function param_add() {
		var title = $('#inner #title').val();
		var description = $('#description').val();
		return '&title='+title+'&description='+description;
	}	
	
	function modify_plugin() {
		$(document).ready(function() {
			$('table #delete-element').click(function() {
				link = window.folder+"/"+'delete_element.php';
				var param = $(this).attr('data-param');
				update2(link,param);
			})
			$('table #action_modify').click(function() {
				link = window.folder+"/"+'modify_element.php';
				var kid = $('#karakteristika_vrsta_id').val();			
				var naziv = $('#elementvrednost_mod').val();
				var param = 'karakteristika_vrsta_id='+kid+'&karakteristikaelementid='+ $(this).attr('data-param')+'&elementvrednost_mod='+naziv+param_add();
				update2(link,param);
			})
			$('table #modifybutt').click(function() {
				link = window.folder+"/"+'modify.php';
				var kid = $('#karakteristika_vrsta_id').val();				
				var param = 'karakteristika_vrsta_id='+kid+'&action=modify'+'&karakteristikaelementid=' + $(this).attr('data-param') + param_add();
				update(link,param);
			})
			$('.title-actionplugin #addbutt').click(function() {
				link = window.folder+"/"+'insert_element.php';
				var naziv = $('#elementvrednost_add').val();
				var kid = $('#karakteristika_vrsta_id').val();
				var mode = $('#inner #mode').val();
				var param = 'mode='+mode+'&karakteristika_vrsta_id='+kid+'&elementvrednost_add='+naziv+param_add();
				if (mode=='insert') mode='insert2';								
				window.param2= 'mode='+mode+'&karakteristika_vrsta_id='+kid+'&elementvrednost_add='+naziv+param_add();
				update2(link,param);
			})
		});
	}

<?php echo '</script'; ?>
>

<div id="content">
	<form name="modify_karakteristika" id="inner" action="modify_final.php" method="post" enctype="multipart/form-data">
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
					 <div class="panel-body">
                           <fieldset class="form-horizontal">
                                 <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
</label>
                                        <div class="col-sm-10">
											<input id="title" name="naziv" type="text" value="<?php echo $_smarty_tpl->tpl_vars['naziv']->value;?>
" class="title form-control" placeholder="Naziv">
										</div>
                                  </div>
								  <div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_DESCRIPTION']->value;?>
</label>
                                        <div class="col-sm-10">
											<textarea id="description" name="opis" rows="3" class="form-control"><?php echo $_smarty_tpl->tpl_vars['opis']->value;?>
</textarea>
										</div>
                                 </div>
                            </fieldset>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<h2><?php echo $_smarty_tpl->tpl_vars['PLG_CARACTERISTIC_OPTIONS']->value;?>
</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel-body">
							<fieldset class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="Pitanje"><?php echo $_smarty_tpl->tpl_vars['PLG_CARACTERISTICS_NEW']->value;?>
</label> 
									<div class="col-sm-8">
										<input id="elementvrednost_add" name="elementvrednost_add" type="text" value="" class="form-control"> 
									</div>
									<div class="col-sm-2">
										<div class="title-actionplugin">
											<div id="addbutt" name="action_add" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</div>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
				<div class="table-responsive">

					<?php if ($_smarty_tpl->tpl_vars['no_data_karakt_elementi']->value == '') {?>
						<?php echo smarty_function_html_table_advanced(array('filter'=>$_smarty_tpl->tpl_vars['filter']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','message'=>$_smarty_tpl->tpl_vars['poruka']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value),$_smarty_tpl);?>

					<?php } else { ?>
						<?php echo $_smarty_tpl->tpl_vars['no_data_karakt_elementi']->value;?>

					<?php }?>

   				<input name="karakteristika_vrsta_id" type="hidden" id="karakteristika_vrsta_id" value="<?php echo $_smarty_tpl->tpl_vars['karakteristikavrstaid']->value;?>
">
			</div>

	</form>
</div><?php }
}
