<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:47:21
  from 'C:\wamp\www\taxicms\templates\order\productcart_default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642abcc99ce225_98544497',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e7dc3dca9ccb3c3740ebb089aef047755d09e02d' => 
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
function content_642abcc99ce225_98544497 (Smarty_Internal_Template $_smarty_tpl) {
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
