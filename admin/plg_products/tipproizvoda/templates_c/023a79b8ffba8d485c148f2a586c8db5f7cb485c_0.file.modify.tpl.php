<?php
/* Smarty version 3.1.32, created on 2020-09-05 09:47:59
  from 'C:\wamp\www\mobillwood\admin\plg_products\tipproizvoda\templates\modify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5f5342af3ce179_52625786',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '023a79b8ffba8d485c148f2a586c8db5f7cb485c' => 
    array (
      0 => 'C:\\wamp\\www\\mobillwood\\admin\\plg_products\\tipproizvoda\\templates\\modify.tpl',
      1 => 1581401582,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f5342af3ce179_52625786 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\mobillwood\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\wamp\\www\\mobillwood\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
echo '<script'; ?>
 type="text/javascript" language="javascript1.2">


	function param_add() {
		var title = $('#inner #title').val();
		var description = $('#description').val();
		return '&title='+title+'&description='+description;
	}

	function GETLinkPromeni(param0, param1)
	{
		var link = window.folder+"/"+'modify.php';
		var param = "modifykarakt=1&tipproizvodaid="+param0+"&karakteristikaid="+param1+"&naziv="+document.editcategory.naziv.value+"&opis="+document.editcategory.opis.value;
		update(link,param);
	}
	function GETLinkObrisi(param0, param1)
	{
		var link = window.folder+"/"+'delete_kar_final.php';
		var param = "deletekarakt=1&tipproizvodaid="+param0+"&karakteristikaid="+param1+"&naziv="+document.editcategory.naziv.value+"&opis="+document.editcategory.opis.value;
		update2(link,param);
	}

	function modify_plugin() {
		$(document).ready(function() {
			$('table #move').click(function() {
				link = window.folder+"/"+$(this).attr('data-link');
				var param = $(this).attr('data-param')+param_add();
				update2(link,param);
			})

			$('table #modifybutt').click(function() {
				link = window.folder+"/"+'modify_karakteristika.php';
				var nk = $('table #nazivkar').val();
				var param = "karakteristikaid="+$(this).attr('data-param')+"&nazivkar="+nk+param_add();
				update2(link,param);
			})
			$('.title-actionplugin #addbutt').click(function() {
				link = window.folder+"/"+'insert_karakteristika.php';
				var kvid = $('#karakteristikavrstaid option:selected').val();
				var tid = $('#tipproizvodaid').val();
				var nk = $('#nazivkarnovo').val();
				var mode = $('#inner #mode').val();
				var param = 'mode='+mode+'&tipproizvodaid='+tid+'&karakteristikavrstaid='+kvid+'&nazivkarnovo='+nk+param_add();
				if (mode=='insert') mode='insert2';
				window.param2= 'mode='+mode+'&tipproizvodaid='+tid+'&karakteristikavrstaid='+kvid+'&nazivkarnovo='+nk+param_add();
				update2(link,param);
			})
		});
	}

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
					<div name="promeni" id="promeni" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_SAVE']->value;?>
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
" size="40" class="title form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
">
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
					<h2><?php echo $_smarty_tpl->tpl_vars['PLG_CARACTERISTICS']->value;?>
</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel-body">
						<fieldset class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="Pitanje"> <?php echo $_smarty_tpl->tpl_vars['PLG_CARACTERISTICS_NEW']->value;?>
 </label>
								<div class="col-sm-4">
									<input name="nazivkarnovo" id="nazivkarnovo" value="" maxlength="255" type="text" class="form-control">
								</div>
								<div class="col-sm-4">
									<select name="karakteristikavrstaid" id="karakteristikavrstaid" class="form-control">
										<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['vrstekarakteristika_val']->value,'selected'=>$_smarty_tpl->tpl_vars['vrstekarakteristika_sel']->value,'output'=>$_smarty_tpl->tpl_vars['vrstekarakteristika_out']->value),$_smarty_tpl);?>

									 </select>
								</div>
								<div class="col-sm-2">
									<div class="title-actionplugin">
										<div name="addbutt" id="addbutt" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['PLG_ADD']->value;?>
</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<?php echo smarty_function_html_table_advanced(array('cols'=>5,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'table_attr'=>' border="0" cellspacing="0" class="index" id="normal"'),$_smarty_tpl);?>

				<input name="tipproizvodaid" type="hidden" id="tipproizvodaid" value="<?php echo $_smarty_tpl->tpl_vars['tipproizvodaid']->value;?>
">
				<input name="type" type="hidden" id="type" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
				<input name="order" type="hidden" id="order" value="<?php echo $_smarty_tpl->tpl_vars['order']->value;?>
">
			</div>
		</div>
	</form>
</div>
<?php }
}
