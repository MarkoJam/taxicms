<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:47:22
  from 'C:\wamp\www\taxicms\templates\products\product_basket_message.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642abccaa08e21_01910591',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bb1133d108bd1dee8de0fc006fbd0841424d8218' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\products\\product_basket_message.tpl',
      1 => 1666177689,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642abccaa08e21_01910591 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- tpl:ProductBasketMessage -->
<?php if ($_REQUEST['basket_message']) {?>
	<div id="basket_message">
		<?php if ($_REQUEST['basket_message'] == "added") {?>
			<p>
				Proizvodi su uspešno dodati u korpu za naručivanje. 
			</p>
		<?php }?>
		
		<?php if ($_REQUEST['basket_message'] != "added" && $_REQUEST['basket_message'] != "noselection") {?>
			<?php echo $_REQUEST['basket_message'];?>

		<?php }?>
	</div>
<?php }?>
<!-- tpl:ProductBasketMessage --><?php }
}
