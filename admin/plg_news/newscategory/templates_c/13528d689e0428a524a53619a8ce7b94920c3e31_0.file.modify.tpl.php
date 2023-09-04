<?php
/* Smarty version 3.1.32, created on 2022-10-26 12:14:23
  from 'C:\wamp\www\taxicms\admin\plg_news\newscategory\templates\modify.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6359087f8e5f92_88461017',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '13528d689e0428a524a53619a8ce7b94920c3e31' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_news\\newscategory\\templates\\modify.tpl',
      1 => 1666177686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6359087f8e5f92_88461017 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\taxicms\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),));
echo '<script'; ?>
>

	function modify_plugin() {}


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
				<div class="panel-body">
                    <fieldset class="form-horizontal">
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
</label>
                            <div class="col-sm-10">
								<input name="nazivkategorije" type="text" value="<?php echo $_smarty_tpl->tpl_vars['nazivkategorije']->value;?>
"  size="40" class="title form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_NAME']->value;?>
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
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['PLG_NUMBER']->value;?>
</label>
                            <div class="col-sm-10">
								<input name="brojVestiKategorije" type="text" value="<?php echo $_smarty_tpl->tpl_vars['brojVestiKategorije']->value;?>
" id="brojVestiKategorije" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['PLG_NUMBER_NEWS']->value;?>
">
							</div>
                        </div>
					</fieldset>
				</div>
			</div>
		</div>
		<input name="newscategoryid" type="hidden" id="newscategoryid" value="<?php echo $_smarty_tpl->tpl_vars['newscategoryid']->value;?>
">
	</form>
</div>
<?php }
}
