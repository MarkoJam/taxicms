<?php
/* Smarty version 3.1.32, created on 2022-08-17 15:10:00
  from 'C:\wamp64\www\mobillwood\admin\templates\norights.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_62fce8a8b78fd7_97334101',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '935ca74eab8f07c7cd9093692d21476ba76f220c' => 
    array (
      0 => 'C:\\wamp64\\www\\mobillwood\\admin\\templates\\norights.tpl',
      1 => 1599472718,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62fce8a8b78fd7_97334101 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
>

	function modify_plugin() {}

<?php echo '</script'; ?>
>

<div id="welcome">
<?php if ($_smarty_tpl->tpl_vars['norights_message']->value != '') {?>
	<h1><?php echo $_smarty_tpl->tpl_vars['norights_message']->value;?>
</h1>
<?php } else { ?>
	<h1>You do not have enough access privileges. Please contact Your administrator.</h1>
<?php }?>
</div>	


<?php }
}
