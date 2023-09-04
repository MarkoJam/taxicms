<?php
/* Smarty version 3.1.32, created on 2023-08-31 08:34:17
  from 'C:\wamp\www\taxicms\admin\templates\norights.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64f03469ce7945_06822511',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0d7dd018353048f94dc04faaf692dc31b81d30f8' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\templates\\norights.tpl',
      1 => 1666177686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64f03469ce7945_06822511 (Smarty_Internal_Template $_smarty_tpl) {
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
<div class="title-action">
		<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;<?php echo $_smarty_tpl->tpl_vars['COMMON_CLOSE']->value;?>
</div>
</div>

<?php }
}
