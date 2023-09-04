<?php
/* Smarty version 3.1.32, created on 2019-07-20 11:02:20
  from 'C:\wamp\www\reimstore\admin\plg_products\postarina\templates\index_detail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5d32d89cd89644_45668173',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aebd2813e6296fd998bb9537c83528a55dcd8918' => 
    array (
      0 => 'C:\\wamp\\www\\reimstore\\admin\\plg_products\\postarina\\templates\\index_detail.tpl',
      1 => 1561551738,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d32d89cd89644_45668173 (Smarty_Internal_Template $_smarty_tpl) {
?>
		<tr>
			<td><input class="form-control" name="<?php echo $_smarty_tpl->tpl_vars['pi']->value;?>
" size="7" type="text" value="<?php echo $_smarty_tpl->tpl_vars['priceid']->value;?>
" disabled></td>
			<td><input class="form-control" name="<?php echo $_smarty_tpl->tpl_vars['wf']->value;?>
" size="3" type="text" value="<?php echo $_smarty_tpl->tpl_vars['weightfrom']->value;?>
" ></td>
			<td><input class="form-control" name="<?php echo $_smarty_tpl->tpl_vars['wt']->value;?>
" size="3" type="text" value="<?php echo $_smarty_tpl->tpl_vars['weightto']->value;?>
" ></td>
			<td><input class="form-control" name="<?php echo $_smarty_tpl->tpl_vars['npp']->value;?>
" size="5" type="text" value="<?php echo $_smarty_tpl->tpl_vars['postprice']->value;?>
" ></td>
			
		</tr>
<?php }
}
