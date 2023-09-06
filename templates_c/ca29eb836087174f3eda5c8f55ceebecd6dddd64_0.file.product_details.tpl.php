<?php
/* Smarty version 3.1.32, created on 2023-09-06 10:49:52
  from 'C:\wamp\www\taxicms\templates\products\product_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64f83d301a11d5_48414448',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ca29eb836087174f3eda5c8f55ceebecd6dddd64' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\products\\product_details.tpl',
      1 => 1693831228,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:products/conected_products.tpl' => 1,
  ),
),false)) {
function content_64f83d301a11d5_48414448 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="application/ld+json">

{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['naziv'];?>
 ",
  "image": [
	
	<?php
$__section_cnt_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['images']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_0_total = $__section_cnt_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_0_total !== 0) {
for ($__section_cnt_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_0_iteration <= $__section_cnt_0_total; $__section_cnt_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
$_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['last'] = ($__section_cnt_0_iteration === $__section_cnt_0_total);
?>
			"<?php echo $_smarty_tpl->tpl_vars['images']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
"<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['last'] : null)) {
} else { ?>,<?php }?>
	<?php
}
}
?>
	
   ],
  "description": "<?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['napomenaadd'];?>
",
  "sku": "<?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['sifra'];?>
",
  "mpn": "<?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['sifra'];?>
",
  "brand": {
    "@type": "Thing",
    "name": "Blue Molds"
  },
  "offers": {
    "@type": "Offer",
    "url": "<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_SERVER['REQUEST_URI'];?>
",
    "priceCurrency": "<?php echo $_SESSION['currency'];?>
",
    "price": "<?php if ($_smarty_tpl->tpl_vars['proizvod_detail']->value['cenab'] == 0) {
echo number_format($_smarty_tpl->tpl_vars['proizvod_detail']->value['cenaa'],2,'.',',');
} else {
echo number_format($_smarty_tpl->tpl_vars['proizvod_detail']->value['cenab'],2,'.',',');
}?>",
    "itemCondition": "https://schema.org/NewCondition",
    "availability": "<?php if ($_smarty_tpl->tpl_vars['proizvod_detail']->value['statusid'] == 51) {?>https://schema.org/InStock <?php }
if ($_smarty_tpl->tpl_vars['proizvod_detail']->value['statusid'] == 56) {?>https://schema.org/LimitedAvailability <?php }
if ($_smarty_tpl->tpl_vars['proizvod_detail']->value['statusid'] == 54) {?>https://schema.org/SoldOut <?php }?>",
    "seller": {
      "@type": "Organization",
      "name": "Blue Molds"
    }
  }
}

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

$( document ).ready(function() {
$('.add').click(function () {
		if ($(this).prev().val() < 100) {
    	$(this).prev().val(+$(this).prev().val() + 1);
		}
});
$('.sub').click(function () {
		if ($(this).next().val() > 1) {
    	if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
		}
});
$('#add_cart').click(function() {
  var id=$('#proizvodid').text();
  var kol=$('.quantity').val();
  var url = '<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
plugins/plg_order/sessionUpdateAjax.php?proizvodid='+id+'&kolicina='+kol+'&lang=<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
';
  console.log(url);
  update_basket_details(url);
});
function update_basket_details(url) {
    	$.ajax({
    		type: 'GET',
    		url: url,
    		async: false,
    		success: function(data) {
          //console.log("dodato u korpu");
    			$('#cart_content').html(data);
    			var submit = $('#add_cart span').text('<?php echo $_smarty_tpl->tpl_vars['PLG_ADDED']->value;?>
');
    			setTimeout(function() {$(submit).text('<?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_BASKET']->value;?>
') }, 2000);
    		}
    	})
    }
});

<?php echo '</script'; ?>
>
<!-- tpl:ProductDetails -->
<div class="container">
    <div class="row position-relative">
<?php if ($_smarty_tpl->tpl_vars['details']->value['pathData'] != '' && $_smarty_tpl->tpl_vars['details']->value['pathData'] != "&nbsp;") {?>
<div class="path path-products">
<?php if (count($_smarty_tpl->tpl_vars['details']->value['pathData']) > 1) {?>
<ul>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['details']->value['pathData'], 'pathData', false, NULL, 'parentData', array (
  'first' => true,
  'index' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['pathData']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_parentData']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_parentData']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_parentData']->value['index'];
?>
	 			<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_parentData']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_parentData']->value['first'] : null)) {?>
	 				<li><a href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['lang']->value;
echo $_smarty_tpl->tpl_vars['PLG_LINK_PRODUCTS']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['pathData']->value['title'];?>
</a></li>
	 			<?php } else { ?>
	 				<li><a href='<?php echo $_smarty_tpl->tpl_vars['pathData']->value['link'];?>
'><?php echo $_smarty_tpl->tpl_vars['pathData']->value['title'];?>
</a></li>
 				<?php }?>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <li><?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['naziv'];?>
</li>
</ul>
		<?php }?>
</div>
<?php }?>

	<form action="plugins/plg_order/korpa_add_one.php" method="POST">
		<div class="product-detail-area">
				<div class="container">
						<div class="row product-detail-box">
								<div class="col-sm-12 col-md-6 col-lg-6 product-detail-image">
										<div class="product-detail-thumb">
                    	<div class="swiper myimage">
							<div class="swiper-wrapper">
                              <div class="swiper-slide">
  									<a class="lightbox-image" data-fancybox="gallery" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['slika'];?>
">
                                	<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['slika'];?>
"  alt="Image">
                                </a>
                              </div>
															<?php
$__section_cnt_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['images']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_1_start = min(0, $__section_cnt_1_loop);
$__section_cnt_1_total = min(($__section_cnt_1_loop - $__section_cnt_1_start), $__section_cnt_1_loop);
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_1_total !== 0) {
for ($__section_cnt_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = $__section_cnt_1_start; $__section_cnt_1_iteration <= $__section_cnt_1_total; $__section_cnt_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
$_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['last'] = ($__section_cnt_1_iteration === $__section_cnt_1_total);
?>
                              <div class="swiper-slide">
  															<a class="lightbox-image" data-fancybox="gallery" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
">
                                	<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
"  alt="Image">
                                </a>
                              </div>
															<?php
}
}
?>
														</div>

													</div>
													<div thumbsSlider="" class="swiper myimagethumb">
															<div class="swiper-wrapper">
                                <div class="nav-item swiper-slide">
                                  	<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['slika'];?>
"  alt="Image">
                                </div>
																<?php
$__section_cnt_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['images']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_2_start = min(0, $__section_cnt_2_loop);
$__section_cnt_2_total = min(($__section_cnt_2_loop - $__section_cnt_2_start), $__section_cnt_2_loop);
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_2_total !== 0) {
for ($__section_cnt_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = $__section_cnt_2_start; $__section_cnt_2_iteration <= $__section_cnt_2_total; $__section_cnt_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
$_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['last'] = ($__section_cnt_2_iteration === $__section_cnt_2_total);
?>
																<div class="nav-item swiper-slide">
                                	<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images_thumb']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
" alt="Image" >
                                </div>
																<?php
}
}
?>
															</div>
														</div>
													</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6 product-detail-content">
                            <div class="product-detail-content">
                                <h4><?php echo $_smarty_tpl->tpl_vars['pathData']->value['title'];?>
</h4>
                                <p class="code"><?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['sifra'];?>
</p>
                                <h2 class="product-detail-title"><?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['naziv'];?>
</h2>
								<?php if ($_smarty_tpl->tpl_vars['proizvod_detail']->value['cenaamp'] != 0) {?>
									<?php if ($_smarty_tpl->tpl_vars['proizvod_detail']->value['cenabmp'] == 0) {?>
										<div class="product-detail-price">€ <?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['cenaampformatirano'];?>
</div>
									<?php } else { ?>
										<div class="product-detail-old-price">€ <?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['cenaampformatirano'];?>
</div>
										<div class="product-detail-price">€ <?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['cenabmpformatirano'];?>
</div>
									<?php }?>
								<?php } else { ?>

								<?php }?>

                                <div class="product-description"><?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['opis'];?>
</div>
								
								<?php
$__section_cnt_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['proizvod_detail']->value['modules']) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_3_total = $__section_cnt_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_3_total !== 0) {
for ($__section_cnt_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_3_iteration <= $__section_cnt_3_total; $__section_cnt_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
$_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['last'] = ($__section_cnt_3_iteration === $__section_cnt_3_total);
?>
									<h4><a href="<?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['modules'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['modules'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['title'];?>
</a></h4>
									<?php
$__section_cnt2_4_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['proizvod_detail']->value['modules'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['options']) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt2_4_total = $__section_cnt2_4_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt2'] = new Smarty_Variable(array());
if ($__section_cnt2_4_total !== 0) {
for ($__section_cnt2_4_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt2']->value['index'] = 0; $__section_cnt2_4_iteration <= $__section_cnt2_4_total; $__section_cnt2_4_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt2']->value['index']++){
?>
										<ul><a href="<?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['modules'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['options'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt2']->value['index'] : null)]['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['modules'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['options'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt2']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt2']->value['index'] : null)]['title'];?>
</a></ul>
									<?php
}
}
?>
								<?php
}
}
?>
                              </div>
                            </div>
													</div>
                            	<?php $_smarty_tpl->_subTemplateRender("file:products/conected_products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
													</div>

						</div>

	</form>
  </div>
  </div>
<?php }
}
