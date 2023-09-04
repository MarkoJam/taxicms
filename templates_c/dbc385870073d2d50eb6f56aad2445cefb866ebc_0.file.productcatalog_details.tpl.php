<?php
/* Smarty version 3.1.32, created on 2023-04-03 14:08:46
  from 'C:\wamp\www\taxicms\templates\products\productcatalog_details.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_642ac1ceec8584_92632930',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dbc385870073d2d50eb6f56aad2445cefb866ebc' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\products\\productcatalog_details.tpl',
      1 => 1671542194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_642ac1ceec8584_92632930 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['ajaxpages']->value)) {?>
<head>
<!-- Font CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Vendor CSS (Bootstrap & Icon Font) -->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
css/bootstrap.min.css">

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
css/fontawesome/css/all.min.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
css/nice-select.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
css/fancybox.min.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
css/main.css">

</head>
<?php }?>


<div class="path">
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
	</ul>
		<?php }?>
</div>

<?php if ($_smarty_tpl->tpl_vars['details']->value['data']['opis'] != '') {?>
	<p><?php echo $_smarty_tpl->tpl_vars['details']->value['data']['opis'];?>
</p>
<?php }?>

  <?php echo '<script'; ?>
 type="text/javascript">

	jQuery(function($){
		jQuery("#productsortby, #productsbypage").change(function(){
			jQuery("#productsortby").closest("form").submit();
			});
	});

<?php echo '</script'; ?>
>

  <?php if (count($_smarty_tpl->tpl_vars['details']->value['paginationData']) > 0) {?>

 <form action="<?php echo $_SERVER['REQUEST_URI'];?>
" method="POST">
<div class="product-group-title">
	<h2 ><?php echo $_smarty_tpl->tpl_vars['details']->value['data']['naziv'];?>
</h3>
</div>
	<div class="row ">
 	<?php
$__section_cnt_4_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['details']->value['paginationData']) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_4_total = $__section_cnt_4_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_4_total !== 0) {
for ($__section_cnt_4_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_4_iteration <= $__section_cnt_4_total; $__section_cnt_4_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>
	<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4  mb-6">
		<div class="itemheight product-group-box">
			<div class="slika" <?php if ($_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slikaover'] != '') {?>style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slikaover'];?>
');"<?php } else { ?>style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slika'];?>
');"<?php }?>>
			<a class="product-item-thumb" href="<?php echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
">
      	<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slika'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['naziv'];?>
">
      </a>
		</div>
			<div class="product-item-info text-center">
      	<h5 class="product-item-title mt-6 mb-0"><a href="<?php echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['naziv'];?>
</a></h5>
				<?php if ($_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenaa'] != 0) {?>
					<?php if ($_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenab'] == 0) {?>
					<div class="product-item-price">€ <?php echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenaaformatirano'];?>
</div>
					<?php } else { ?>
					<span class="price-old">€ <?php echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenaaformatirano'];?>
</span>
					<div class="product-item-price">€ <?php echo $_smarty_tpl->tpl_vars['details']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenabformatirano'];?>
</div>
					<?php }?>
				<?php } else { ?>

				<?php }?>
      </div>
    </div>
	</div>
 <?php
}
}
?>

 <div class="col-12">
	 <div class="shop-top-bar">
		<?php if ($_smarty_tpl->tpl_vars['paginate']->value['total'] > '24') {?>
		<nav class="pagination-area ms-md-auto mt-3 mt-md-0">
    	<?php echo $_smarty_tpl->tpl_vars['data']->value['pagination'];?>

		</nav>
		<?php }?>
 </div>
</div>
</div>

</form>
<?php }?>
</div>
<?php }
}
