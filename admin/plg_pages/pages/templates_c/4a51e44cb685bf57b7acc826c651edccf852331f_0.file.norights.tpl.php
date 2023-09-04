<?php
/* Smarty version 3.1.32, created on 2023-08-31 08:34:05
  from 'C:\wamp\www\taxicms\admin\templates\norights.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64f0345d319a13_53055097',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4a51e44cb685bf57b7acc826c651edccf852331f' => 
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
function content_64f0345d319a13_53055097 (Smarty_Internal_Template $_smarty_tpl) {
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
