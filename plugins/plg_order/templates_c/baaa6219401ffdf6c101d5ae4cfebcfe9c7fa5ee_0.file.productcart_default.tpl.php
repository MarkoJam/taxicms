<?php
/* Smarty version 3.1.32, created on 2022-10-26 11:59:20
  from 'C:\wamp\www\taxicms\templates\order\productcart_default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_635904f83019c5_61109424',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'baaa6219401ffdf6c101d5ae4cfebcfe9c7fa5ee' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\order\\productcart_default.tpl',
      1 => 1666249509,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_635904f83019c5_61109424 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
>

<?php echo '</script'; ?>
>
	<div class="cart">
	<?php if ($_smarty_tpl->tpl_vars['data']->value['basketCount'] > 0 && $_smarty_tpl->tpl_vars['orderfinish']->value != "true") {?>
	<a id="cart" href="<?php echo $_smarty_tpl->tpl_vars['data']->value['basketLink'];?>
" class="position-relative">
		<i class="fa-solid fa-cart-shopping"></i>
		<span <?php if ($_smarty_tpl->tpl_vars['data']->value['basketCount'] == 0) {?> style='display:none;' <?php }?>><?php echo $_smarty_tpl->tpl_vars['data']->value['basketCount'];?>
</span>
	</a>
	<?php } else { ?>
	<i class="fa-solid fa-cart-shopping"></i>
	<?php }?>
</div>
<?php }
}
