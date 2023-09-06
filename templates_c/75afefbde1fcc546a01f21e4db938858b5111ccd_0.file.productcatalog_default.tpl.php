<?php
/* Smarty version 3.1.32, created on 2023-09-06 10:49:41
  from 'C:\wamp\www\taxicms\templates\products\productcatalog_default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64f83d25cbcea0_52675843',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '75afefbde1fcc546a01f21e4db938858b5111ccd' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\products\\productcatalog_default.tpl',
      1 => 1693399416,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:products/filters.tpl' => 1,
  ),
),false)) {
function content_64f83d25cbcea0_52675843 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- productcatalog_default START-->
<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
  <div class="category-box">
    <div class="accordion" id="accordionPanelsStayOpenExample">
  <div>
    <h2 id="panelsStayOpen-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
        <?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_CATALOG']->value;?>

      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse dont-collapse-sm" aria-labelledby="panelsStayOpen-headingOne">

          <ul>
          <?php
$__section_cnt_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['menuItem']['items']) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_0_total = $__section_cnt_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_0_total !== 0) {
for ($__section_cnt_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_0_iteration <= $__section_cnt_0_total; $__section_cnt_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>
          <?php if ($_smarty_tpl->tpl_vars['data']->value['menuItem']['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['id'] != $_smarty_tpl->tpl_vars['data']->value['specGroup']) {?>
          <li class="main_nav">
            <a href="<?php echo $_smarty_tpl->tpl_vars['data']->value['menuItem']['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
">
              <?php echo $_smarty_tpl->tpl_vars['data']->value['menuItem']['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['title'];?>

            </a>
             <?php if (count($_smarty_tpl->tpl_vars['data']->value['menuItem']['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['items']) > 0) {?>
             <ul>
            <?php }?>
            <?php
$__section_inner_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['menuItem']['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['items']) ? count($_loop) : max(0, (int) $_loop));
$__section_inner_1_total = $__section_inner_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_inner'] = new Smarty_Variable(array());
if ($__section_inner_1_total !== 0) {
for ($__section_inner_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_inner']->value['index'] = 0; $__section_inner_1_iteration <= $__section_inner_1_total; $__section_inner_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_inner']->value['index']++){
?>
            <li class="sub_nav">
               <a href="<?php echo $_smarty_tpl->tpl_vars['data']->value['menuItem']['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_inner']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_inner']->value['index'] : null)]['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['menuItem']['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_inner']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_inner']->value['index'] : null)]['title'];?>
</a>
            </li>
            <?php
}
}
?>
            <?php if (count($_smarty_tpl->tpl_vars['data']->value['menuItem']['items'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['items']) > 0) {?>
            </ul>
           <?php }?>
            </li>
          <?php }?>
          <?php
}
}
?>
          <ul>

    </div>
  </div>
</div>

    </div>
    <?php $_smarty_tpl->_subTemplateRender("file:products/filters.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>

<?php if ($_smarty_tpl->tpl_vars['data']->value['grupaProizvodaID'] == 0) {?>
<div class="col-sm-12 col-md-8 col-lg-9 col-xl-9 product-group">
	<?php if (count($_smarty_tpl->tpl_vars['data']->value['paginationData']) > 0) {?>

		<form action="<?php echo $_SERVER['REQUEST_URI'];?>
" method="POST">
      <div class="product-group-title">
	       <h2 ><?php echo $_smarty_tpl->tpl_vars['PLG_PRODUCT_ALL']->value;?>
</h3>
         </div>
			<div class="row ">
				<?php
$__section_cnt_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['data']->value['paginationData']) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_2_total = $__section_cnt_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_2_total !== 0) {
for ($__section_cnt_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_2_iteration <= $__section_cnt_2_total; $__section_cnt_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>
					<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4  mb-6">
						<div class="itemheight product-group-box">

							<div class="slika" <?php if ($_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slikaover'] != '') {?>style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slikaover'];?>
');"<?php } else { ?> style="background-image: url('<?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slika'];?>
');"<?php }?>>
								<a class="product-item-thumb" href="<?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
">
									<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['slika'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['naziv'];?>
">
								</a>
							</div>
							<div class="product-item-info text-center ">
								<h5 class="product-item-title mt-6 mb-0" ><a href="<?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['naziv'];?>
</a></h5>
								<?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['grupa'];?>
 
								<?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['kratakopis'];?>

								<?php if ($_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenaa'] != 0) {?>
									<?php if ($_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenab'] == 0) {?>
										<div class="product-item-price mb-0">€ <?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenaaformatirano'];?>
</div>
									<?php } else { ?>
										<span class="price-old">€ <?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenaaformatirano'];?>
</span>
										<div class="product-item-price mb-0">€ <?php echo $_smarty_tpl->tpl_vars['data']->value['paginationData'][(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)]['cenabformatirano'];?>
</div>
									<?php }?>
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

						<nav class="pagination-area ms-md-auto mt-3 mt-md-0">
							<?php echo $_smarty_tpl->tpl_vars['data']->value['pagination'];?>

						</nav>
					</div>
				</div>
			</div>

		</form>
	<?php }?>
</div>
<?php }
}
}
