<?php
/* Smarty version 3.1.32, created on 2023-04-03 14:09:12
  from 'C:\wamp\www\taxicms\templates\products\conected_products.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ac1e81be8f3_68695818',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48c506863f86e3fb2efedfcd22abfdc68cb7416f' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\products\\conected_products.tpl',
      1 => 1671542194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ac1e81be8f3_68695818 (Smarty_Internal_Template $_smarty_tpl) {
if (count($_smarty_tpl->tpl_vars['details']->value['conectedproducts']) > 0) {?>
<div class="row conected-products-box">
    <div class="col-lg-12 col-md-12 col-12 conected">
      <div class="product-group-title mt-1">
       <h2><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_CONECTED_PRODUCTS']->value;?>
</h2>
     </div>
   </div>
 </div>
<div class="row connected-products">

 
 <?php
$__section_cnt_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['details']->value['conectedproducts']) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_3_total = $__section_cnt_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_3_total !== 0) {
for ($__section_cnt_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_3_iteration <= $__section_cnt_3_total; $__section_cnt_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>
  <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null) < 8) {?>
  <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4  mb-6">
    <div class="itemheight product-group-box">
      <div class="slika" <?php if ($_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['slikaover'] != '') {?>style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['slikaover'];?>
');"<?php } else { ?>style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['slika'];?>
');"<?php }?>>
      <a class="product-item-thumb" href="<?php echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['link'];?>
">
        <img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['slika'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['naziv'];?>
">
      </a>
    </div>
      <div class="product-item-info text-center">
        <h5 class="product-item-title mt-6 mb-0"><a href="<?php echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['naziv'];?>
</a></h5>
        <?php if ($_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['cenaa'] != 0) {?>
          <?php if ($_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['cenab'] == 0) {?>
          <div class="product-item-price">€ <?php echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['cenaaformatirano'];?>
</div>
          <?php } else { ?>
          <span class="price-old">€ <?php echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['cenaaformatirano'];?>
</span>
          <div class="product-item-price">€ <?php echo $_smarty_tpl->tpl_vars['details']->value['conectedproducts'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['proizvod_detail']['cenabformatirano'];?>
</div>
          <?php }?>
        <?php } else { ?>

        <?php }?>
      </div>
    </div>
  </div>
<?php }?>
 <?php
}
}
?>
</div>
<?php }
}
}
