<?php
/* Smarty version 3.1.32, created on 2023-04-03 13:47:22
  from 'C:\wamp\www\taxicms\templates\products\product_default_home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642abcca331925_41976384',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f842ee0d9436e5e34a93a5b28e528ddd10b36f9' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\products\\product_default_home.tpl',
      1 => 1671542194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642abcca331925_41976384 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- tpl:ProductDefaultHome -->
<section class="products-area">
	<form action="plugins/plg_order/korpa_add_one.php" method="POST">
	<div class="container">
		<div class="row">
			<?php
$__section_cnt_6_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['proizvodi_all']) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_6_total = $__section_cnt_6_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_6_total !== 0) {
for ($__section_cnt_6_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_6_iteration <= $__section_cnt_6_total; $__section_cnt_6_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>

			<div class="col-md-4 itemheight">

					<div class="product-box">
						<h2><a href="<?php echo $_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['naziv'];?>
</a></h2>
						<?php echo $_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['kratakopis'];?>

						<div class="slika slika-home" <?php if ($_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slikaover'] != '') {?>style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slikaover'];?>
');"<?php } else { ?>style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slika'];?>
');"<?php }?>>
								<a class="product-item-thumb" href="<?php echo $_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
">
					      	<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slika'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['naziv'];?>
">
					      </a>
						</div>
						<?php if ($_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['statusid'] == 54) {?>

						<?php } else { ?>
						<a class="product-button" href="<?php echo $_smarty_tpl->tpl_vars['data']->value['proizvodi_all'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
">
							<?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ORDER']->value;?>

						</a>
						<?php }?>
					</div>
			</div>
			<?php
}
}
?>
		</div>
	</div>
	</form>
</section>
<!-- tpl:ProductDefaultHome -->
<?php }
}
