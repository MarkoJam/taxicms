<?php
/* Smarty version 3.1.32, created on 2023-09-01 11:06:32
  from 'C:\wamp\www\taxicms\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_64f1a998d9b261_10950256',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '555f85127ba0fdba40231f724dca1bbb7a46dd5d' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\templates\\index.tpl',
      1 => 1693558521,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:order/productcart_default.tpl' => 1,
    'file:sections_default_slide.tpl' => 1,
    'file:news_default_home.tpl' => 1,
    'file:sections_default_about.tpl' => 1,
    'file:products/productcatalog_default_home.tpl' => 1,
    'file:products/product_default_home.tpl' => 1,
    'file:products/productgroupcomplex_default.tpl' => 1,
    'file:newsletter_default_mc.tpl' => 1,
    'file:order/basket.tpl' => 1,
    'file:order_shipment.tpl' => 1,
    'file:order/overview.tpl' => 1,
    'file:order/checkout.tpl' => 1,
    'file:order/finish.tpl' => 1,
    'file:products/product_basket_message.tpl' => 1,
    'file:login_details.tpl' => 1,
    'file:sections_default_onama1.tpl' => 1,
    'file:sections_default_onama2.tpl' => 1,
    'file:sections_default_onama3.tpl' => 1,
    'file:sections_default_system1.tpl' => 1,
    'file:sections_default_system2.tpl' => 1,
    'file:sections_default_system3.tpl' => 1,
    'file:sections_default_system4.tpl' => 1,
    'file:sections_default_system5.tpl' => 1,
    'file:sections_default_system6.tpl' => 1,
    'file:navlinks_default.tpl' => 1,
    'file:products/productcatalog_default.tpl' => 2,
    'file:products/productcatalog_details.tpl' => 1,
    'file:products/productgroup_default.tpl' => 1,
    'file:products/product_details.tpl' => 1,
    'file:search_details.tpl' => 1,
    'file:news_details.tpl' => 1,
    'file:module_details.tpl' => 1,
    'file:option_details.tpl' => 1,
    'file:formcontact_default.tpl' => 1,
    'file:sections_default_contact1.tpl' => 1,
    'file:sections_default_contact2.tpl' => 1,
    'file:sections_default_termsofuse.tpl' => 1,
    'file:news_default.tpl' => 1,
    'file:module_default.tpl' => 1,
    'file:option_default.tpl' => 1,
    'file:universalplugin_default.tpl' => 1,
    'file:sections_default_contact.tpl' => 2,
    'file:news_default_notify.tpl' => 1,
    'file:search_default.tpl' => 1,
  ),
),false)) {
function content_64f1a998d9b261_10950256 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html lang="sr">
<head>
<title><?php echo $_smarty_tpl->tpl_vars['SITE_NAME']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['header']->value;
echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['naziv'];
echo $_smarty_tpl->tpl_vars['news_detail']->value['header'];?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;
echo $_smarty_tpl->tpl_vars['news_detail']->value['html_clean'];
echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['napomena'];?>
" />
<meta name="EXPIRES" content="0">
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">
<meta http-equiv="Cache-Control" content="no-cache">

<meta property="og:title" content="<?php echo $_smarty_tpl->tpl_vars['SITE_NAME']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['header']->value;
echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['naziv'];
echo $_smarty_tpl->tpl_vars['news_detail']->value['header'];?>
"/>
<meta property="og:type" content="company"/>
<meta property="og:url" content="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_SERVER['REQUEST_URI'];?>
" />
<meta property="og:site_name" content="<?php echo $_smarty_tpl->tpl_vars['SITE_NAME']->value;?>
"/>

<?php if ((isset($_smarty_tpl->tpl_vars['plg_product_details']->value) && $_smarty_tpl->tpl_vars['plg_product_details']->value == "true")) {?>
<meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['slika'];
echo $_smarty_tpl->tpl_vars['news_detail']->value['slika'];?>
"/>
<meta property="og:description" content="<?php echo $_smarty_tpl->tpl_vars['proizvod_detail']->value['napomenaadd'];?>
 <?php echo $_smarty_tpl->tpl_vars['news_detail']->value['html_clean_short'];?>
" />
<?php } else { ?>
<meta property="og:description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" />
<meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images']->value[0];?>
" />
<?php }?>

<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
images/favicon.ico" />

<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.0/jquery-migrate.min.js" integrity="sha256-lubBd1CVmtB9FHh+c1CWkr4jCSiszGj7bhzWPpNgw1A=" crossorigin="anonymous"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
includes/js/bootstrap.min.js"><?php echo '</script'; ?>
>

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
css/lightbox.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
css/main.css?version=1">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
css/responsive.css?version=1">

</head>
<input id='rootweb' name='rootweb' type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
'/>
<?php $_smarty_tpl->_assignInScope('data', '');?>
<body>
	<!--== Wrapper Start ==-->
	<div class="wrapper">
	    <!--== Start Header Wrapper ==-->
	    <header class="header-wrapper d-flex justify-content-center flex-column">
	        <div class="header-middle">
	            <div class="container">
	                <div class="row align-items-center justify-content-between align-items-center">
						<nav class="navbar navbar-expand-lg navbar-default">
							<a class="navbar-brand" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
"><img class="logo-main" src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
images/logo/logo-black.svg" width="200" height="200" alt="Logo"></a>
							<div class="collapse navbar-collapse header-navigation " id="navbarSupportedContent">
								<ul class="main-nav navbar-nav">
									<?php echo $_smarty_tpl->tpl_vars['menu_render_horizontal']->value;?>

								</ul>
							</div>
							<div class="col-auto">
								<div class="header-action d-flex align-items-center">
									<div id="sb-search" class="sb-search" data-bs-toggle="modal" data-bs-target="#search"><i class="fa-solid fa-magnifying-glass"></i></div>
									<!--<div id='cart_content' class=" minicart">
																				<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_productcart_default","standard",$_smarty_tpl->tpl_vars['data']->value)) {?>
											<?php $_smarty_tpl->_subTemplateRender("file:order/productcart_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
										<?php }?>
									</div>!-->
																		<div id="language" class="<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
">
																			</div>
								</div>
															</div>
						</nav>
	                </div>
	            </div>
	        </div>
		</header>

		<main class="main-content">
			<div class="row">
				<div class="col-md-9">
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","slideshow",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_slide.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
				</div>			
				<div class="col-md-3">
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_news_default","homepage",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:news_default_home.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9">			
						<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","about",$_smarty_tpl->tpl_vars['data']->value)) {?>
				<?php $_smarty_tpl->_subTemplateRender("file:sections_default_about.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>
				</div>			
				<div class="col-md-3">
									<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_katalogproizvoda_default","home",$_smarty_tpl->tpl_vars['data']->value)) {?>
				<?php $_smarty_tpl->_subTemplateRender("file:products/productcatalog_default_home.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>
				</div>
			</div>
									<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_grupaproizvod_default","homepage",$_smarty_tpl->tpl_vars['data']->value)) {?>
				<?php if ($_smarty_tpl->tpl_vars['data']->value['grupaproizvoda_view'] == "SIMPLE_VIEW") {?>
					<?php $_smarty_tpl->_subTemplateRender("file:products/product_default_home.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['data']->value['grupaproizvoda_view'] == "COMPLEX_VIEW") {?>
					<?php $_smarty_tpl->_subTemplateRender("file:products/productgroupcomplex_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>
			<?php }?>

						<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_newsletter_default","standard",$_smarty_tpl->tpl_vars['data']->value)) {?>
				<?php $_smarty_tpl->_subTemplateRender("file:newsletter_default_mc.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>



									<?php if ($_smarty_tpl->tpl_vars['plugin']->value == "order" && $_smarty_tpl->tpl_vars['plugin_view']->value == "basket") {?>
				<div id='order_basket'><?php $_smarty_tpl->_subTemplateRender("file:order/basket.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['plugin']->value == "order" && $_smarty_tpl->tpl_vars['plugin_view']->value == "shipment") {?>
				<?php $_smarty_tpl->_subTemplateRender("file:order_shipment.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['plugin']->value == "order" && $_smarty_tpl->tpl_vars['plugin_view']->value == "overview") {?>
				<?php $_smarty_tpl->_subTemplateRender("file:order/overview.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['plugin']->value == "order" && $_smarty_tpl->tpl_vars['plugin_view']->value == "checkout") {?>
				<?php $_smarty_tpl->_subTemplateRender("file:order/checkout.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['plugin']->value == "order" && $_smarty_tpl->tpl_vars['plugin_view']->value == "orderfinish") {?>
				<?php $_smarty_tpl->_subTemplateRender("file:order/finish.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>

			<?php $_smarty_tpl->_subTemplateRender("file:products/product_basket_message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			<?php if (isset($_smarty_tpl->tpl_vars['plg_login_details']->value) && $_smarty_tpl->tpl_vars['plg_login_details']->value == "true") {?>
					<?php $_smarty_tpl->_subTemplateRender("file:login_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php }?>

			<section <?php if ($_smarty_tpl->tpl_vars['HOME_PAGE']->value != "true") {?> id="content" <?php }?>>
				<?php if ($_smarty_tpl->tpl_vars['HOME_PAGE']->value != "true" && $_smarty_tpl->tpl_vars['pagecms']->value == "true" && $_smarty_tpl->tpl_vars['plg_sitemap']->value != "true" && $_smarty_tpl->tpl_vars['plugin']->value != "order") {?>
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","onama-sekcija1",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_onama1.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","onama-sekcija2",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_onama2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","onama-sekcija3",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_onama3.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","system-sekcija1",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_system1.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","system-sekcija2",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_system2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","system-sekcija3",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_system3.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","system-sekcija4",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_system4.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","system-sekcija5",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_system5.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
										<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","system-sekcija6",$_smarty_tpl->tpl_vars['data']->value)) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:sections_default_system6.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
					<div class="container">
												<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_naviglinks_default","standard",$_smarty_tpl->tpl_vars['data']->value)) {?>
							<?php $_smarty_tpl->_subTemplateRender("file:navlinks_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['html']->value != '') {?>
						<div class="row">
							<div class="col-md-12">
								<div class="content page-desc">
									<h1><?php echo $_smarty_tpl->tpl_vars['header']->value;?>
</h1>
									<h4><?php echo $_smarty_tpl->tpl_vars['shorthtml']->value;?>
</h4>
									<?php echo $_smarty_tpl->tpl_vars['html']->value;?>

								</div>
							</div>
						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['page_img']->value != '') {?>
						<div class="row">
							<?php
$__section_cnt_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['images']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_0_total = $__section_cnt_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_0_total !== 0) {
for ($__section_cnt_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = 0; $__section_cnt_0_iteration <= $__section_cnt_0_total; $__section_cnt_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>
								<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null) > 1) {?>
									<?php $_smarty_tpl->_assignInScope('rows', 'true');?>
								<?php } else { ?>
									<?php $_smarty_tpl->_assignInScope('rows', 'false');?>
								<?php }?>
							<?php
}
}
?>
							<div class="col-lg-12 col-md-12 col-12 order-lg-12 <?php if ($_smarty_tpl->tpl_vars['rows']->value == 'true') {?>content-gallery<?php }?>">
								<div class="row <?php if ($_smarty_tpl->tpl_vars['rows']->value == 'true') {?>web-rows<?php }?>">
									<?php
$__section_cnt_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['images']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_cnt_1_start = min(1, $__section_cnt_1_loop);
$__section_cnt_1_total = min(($__section_cnt_1_loop - $__section_cnt_1_start), $__section_cnt_1_loop);
$_smarty_tpl->tpl_vars['__smarty_section_cnt'] = new Smarty_Variable(array());
if ($__section_cnt_1_total !== 0) {
for ($__section_cnt_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] = $__section_cnt_1_start; $__section_cnt_1_iteration <= $__section_cnt_1_total; $__section_cnt_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']++){
?>
										<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 galerija-wrap">
											<div class="galerija">
												<a class="example-image-link" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
" data-lightbox="example-1">
													<div class="image-wrap">
														<img class="example-image" alt="" src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['images_thumb']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_cnt']->value['index'] : null)];?>
">
													</div>
												</a>
											</div>
										</div>
									<?php
}
}
?>
								</div>
								<div class="loadmore"><button id="loadMore">Load more</button></div>
							</div>
						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['page_vid']->value != '') {?>
						<div class="row video-gallery">
							<?php echo $_smarty_tpl->tpl_vars['page_vid']->value;?>

						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['page_doc']->value != '') {?>
						<div class="row web-rows">
							<div class="col-lg-12 col-md-12 col-12">
								<div class="page-title">
									<h2><?php echo $_smarty_tpl->tpl_vars['PLG_PAGE_DOC']->value;?>
</h2>
								</div>
								<div class="product-pdf row">
									<?php echo $_smarty_tpl->tpl_vars['page_doc']->value;?>

								</div>
							</div>
						</div>
						<?php }?>
					</div>
				<?php }?>
				<?php if ((CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_katalogproizvoda_default","standard",$_smarty_tpl->tpl_vars['data']->value) && $_smarty_tpl->tpl_vars['plg_search_details']->value != "true" && $_smarty_tpl->tpl_vars['plg_news_details']->value != "true") || ($_smarty_tpl->tpl_vars['plg_katalogproizvoda_details']->value == "true" && $_smarty_tpl->tpl_vars['plg_product_details']->value != "true") || CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_grupaproizvod_default","standard",$_smarty_tpl->tpl_vars['data']->value)) {?>
				<div class="row position-relative mb-10">
															<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_katalogproizvoda_default","standard",$_smarty_tpl->tpl_vars['data']->value) && $_smarty_tpl->tpl_vars['plg_search_details']->value != "true" && $_smarty_tpl->tpl_vars['plg_news_details']->value != "true") {?>
						<?php $_smarty_tpl->_subTemplateRender("file:products/productcatalog_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
										<?php if (isset($_smarty_tpl->tpl_vars['plg_katalogproizvoda_details']->value) && $_smarty_tpl->tpl_vars['plg_katalogproizvoda_details']->value == "true" && $_smarty_tpl->tpl_vars['plg_product_details']->value != "true") {?>
						<!-- page main wrapper start -->
																		<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_katalogproizvoda_default","products",$_smarty_tpl->tpl_vars['data']->value) && $_smarty_tpl->tpl_vars['plg_search_details']->value != "true" && $_smarty_tpl->tpl_vars['plg_news_details']->value != "true") {?>
							<?php $_smarty_tpl->_subTemplateRender("file:products/productcatalog_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
						<?php }?>
						<div id="catalog-detail" class="col-sm-12 col-md-8 col-lg-9 col-xl-9 product-group"><?php $_smarty_tpl->_subTemplateRender("file:products/productcatalog_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?></div>
					<?php }?>
															<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_grupaproizvod_default","standard",$_smarty_tpl->tpl_vars['data']->value) && $_smarty_tpl->tpl_vars['plg_news_details']->value != "true") {?>
						<?php $_smarty_tpl->_subTemplateRender("file:products/productgroup_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
					<?php }?>
				</div>
				<?php }?>

								<?php if (isset($_smarty_tpl->tpl_vars['plg_product_details']->value) && $_smarty_tpl->tpl_vars['plg_product_details']->value == "true") {?>
					<?php $_smarty_tpl->_subTemplateRender("file:products/product_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>

				<?php if (isset($_smarty_tpl->tpl_vars['plg_search_details']->value) && $_smarty_tpl->tpl_vars['plg_search_details']->value == "true") {?>
					<?php $_smarty_tpl->_subTemplateRender("file:search_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>

				<?php if (isset($_smarty_tpl->tpl_vars['plg_news_details']->value) && $_smarty_tpl->tpl_vars['plg_news_details']->value == "true") {?>
					<?php $_smarty_tpl->_subTemplateRender("file:news_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>				
				
				<?php if (isset($_smarty_tpl->tpl_vars['plg_module_details']->value) && $_smarty_tpl->tpl_vars['plg_module_details']->value == "true") {?>
					<?php $_smarty_tpl->_subTemplateRender("file:module_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>				
				
				<?php if (isset($_smarty_tpl->tpl_vars['plg_option_details']->value) && $_smarty_tpl->tpl_vars['plg_option_details']->value == "true") {?>
					<?php $_smarty_tpl->_subTemplateRender("file:option_details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>

								<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_formcontact_default","standard",$_smarty_tpl->tpl_vars['data']->value)) {?>
					<?php $_smarty_tpl->_subTemplateRender("file:formcontact_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>
								<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","kontakt-sekcija1",$_smarty_tpl->tpl_vars['data']->value)) {?>
					<?php $_smarty_tpl->_subTemplateRender("file:sections_default_contact1.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>
								<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","kontakt-sekcija2",$_smarty_tpl->tpl_vars['data']->value)) {?>
					<?php $_smarty_tpl->_subTemplateRender("file:sections_default_contact2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>
								<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","termsofuse",$_smarty_tpl->tpl_vars['data']->value)) {?>
					<?php $_smarty_tpl->_subTemplateRender("file:sections_default_termsofuse.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>

								<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_news_default","standard",$_smarty_tpl->tpl_vars['data']->value)) {?>
					<?php $_smarty_tpl->_subTemplateRender("file:news_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>				
				
								<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_module_default","standard",$_smarty_tpl->tpl_vars['data']->value)) {?>
					<?php $_smarty_tpl->_subTemplateRender("file:module_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>				
				
								<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_option_default","standard",$_smarty_tpl->tpl_vars['data']->value)) {?>
					<?php $_smarty_tpl->_subTemplateRender("file:option_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
				<?php }?>
			</section>
		</main>
		<footer class="footer-area">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<div class="footer-logo">
							<div class="row ">
								<div class="col-sm-12 d-flex justify-content-center">
									<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
images/logo/logo-color.svg" width="250px" height="250px" />
								</div>
							</div>
						</div>
					</div>	
					<div class="col-lg-8">				
						<!--== Start Footer Main ==-->
												<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_universalplugin_default","footer",$_smarty_tpl->tpl_vars['data']->value)) {?>
							<?php $_smarty_tpl->_subTemplateRender("file:universalplugin_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
						<?php }?>
						<!--== End Footer Main ==-->
						<div class="footer-main">
							<div class="row ">
								<div class="col-sm-12 d-flex justify-content-sm-end">
									<a href="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;
echo $_smarty_tpl->tpl_vars['lang']->value;?>
/terms-of-use-and-privacy-policy/"><?php echo $_smarty_tpl->tpl_vars['GLOBAL_TERMS']->value;?>
</a></a>
								</div>
							</div>
						</div>
						<!--== Start Footer Bottom ==-->
						<div class="footer-bottom d-flex justify-content-between">
							<div class="copyright"><?php echo $_smarty_tpl->tpl_vars['GLOBAL_COPYRIGHT']->value;?>
</div>
							<div class="social"><a href="https://www.facebook.com/taxicms"><i class="fa-brands fa-facebook"></i></a> <a href="https://www.linkedin.com/company/taxicms/"><i class="fa-brands fa-linkedin"></i></a> <a href="https://www.instagram.com/taxicms/"><i class="fa-brands fa-square-instagram"></i></a></div>
						</div>
						<div class="footer-bottom">
														<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","float-contact",$_smarty_tpl->tpl_vars['data']->value)) {?>
								<?php $_smarty_tpl->_subTemplateRender("file:sections_default_contact.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
							<?php }?>
						</div>
					</div>	
				</div>	
			</div>
		</footer>
	</div>
	<div class="social-icons">
		<a href="https://www.facebook.com/taxicms" target="_blank"><div class="in"><img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
images/icon-fb.svg" width="22" height="22" /></div></a>
		<a href="https://www.linkedin.com/company/taxicms/" target="_blank"><div class="in"><img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
images/icon-in.svg" width="22" height="22" /></div></a>
		<a href="https://www.instagram.com/taxi_cms/" target="_blank"><div class="insta"><img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
images/icon-insta.svg" width="22" height="22" /></div></a>
		<div class="soc cont">
			<div class="float-contact">
						<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_sections_default","float-contact",$_smarty_tpl->tpl_vars['data']->value)) {?>
				<?php $_smarty_tpl->_subTemplateRender("file:sections_default_contact.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
			<?php }?>
			</div>
			<img src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
images/icon-contact.svg" width="22" height="22" />
		</div>
		
		<?php if (CheckPlugin($_smarty_tpl->tpl_vars['smartypluginblocks']->value,"plg_news_default","notify",$_smarty_tpl->tpl_vars['data']->value)) {?>
			<?php $_smarty_tpl->_subTemplateRender("file:news_default_notify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
		<?php }?>


	</div>
	<?php $_smarty_tpl->_subTemplateRender("file:search_default.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	<!-- Custom Main JS -->
	<!-- Bootstrap Core JavaScript -->

	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
includes/js/jquery.matchHeight.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
includes/js/fancybox.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
includes/js/lightbox.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['ROOT_WEB']->value;?>
includes/js/main.js?version=1"><?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
