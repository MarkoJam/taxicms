<!DOCTYPE html lang="sr">
<head>
<title>{$SITE_NAME} - {$header}{$proizvod_detail.naziv}{$news_detail.header}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="{$keywords}" />
<meta name="description" content="{$description}{$news_detail.html_clean}{$proizvod_detail.napomena}" />
<meta name="EXPIRES" content="0">
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">
<meta http-equiv="Cache-Control" content="no-cache">

<meta property="og:title" content="{$SITE_NAME} - {$header}{$proizvod_detail.naziv}{$news_detail.header}"/>
<meta property="og:type" content="company"/>
<meta property="og:url" content="{$ROOT_WEB}{$smarty.server.REQUEST_URI}" />
<meta property="og:site_name" content="{$SITE_NAME}"/>

{if (isset($plg_product_details) and $plg_product_details eq "true")}
<meta property="og:image" content="{$ROOT_WEB}{$proizvod_detail.slika}{$news_detail.slika}"/>
<meta property="og:description" content="{$proizvod_detail.napomenaadd} {$news_detail.html_clean_short}" />
{else}
<meta property="og:description" content="{$description}" />
<meta property="og:image" content="{$ROOT_WEB}{$images[0]}" />
{/if}

<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" type="image/x-icon" href="{$ROOT_WEB}images/favicon.ico" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.0/jquery-migrate.min.js" integrity="sha256-lubBd1CVmtB9FHh+c1CWkr4jCSiszGj7bhzWPpNgw1A=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="{$ROOT_WEB}includes/js/bootstrap.min.js"></script>

<!-- Font CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Vendor CSS (Bootstrap & Icon Font) -->
<link rel="stylesheet" href="{$ROOT_WEB}css/bootstrap.min.css">

<link rel="stylesheet" href="{$ROOT_WEB}css/fontawesome/css/all.min.css">
<link rel="stylesheet" href="{$ROOT_WEB}css/nice-select.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
<link rel="stylesheet" href="{$ROOT_WEB}css/fancybox.min.css">
<link rel="stylesheet" href="{$ROOT_WEB}css/lightbox.css">
<link rel="stylesheet" href="{$ROOT_WEB}css/main.css?version=1">
<link rel="stylesheet" href="{$ROOT_WEB}css/responsive.css?version=1">

</head>
<input id='rootweb' name='rootweb' type='hidden' value='{$ROOT_WEB}'/>
{assign var="data" value=""}

{*include file="templates/additional-style.tpl"*}
<body>
	<!--== Wrapper Start ==-->
	<div class="wrapper">
		{* <template:def plugin="plg_sections_default" position="header" /> *}
		{if CheckPlugin($smartypluginblocks, "plg_sections_default", "header", $data)}
			{include file="sections_default_header.tpl"}
		{/if}	
	    <!--== Header Wrapper Start ==-->
	    <header class="sticky-top d-flex justify-content-center flex-column">
			<div class="header-middle">
				<!-- Conainer: -->
	            <div class="container">
	                <div class="row align-items-center justify-content-between align-items-center">
						<nav  style="background:white;" class="navbar navbar-expand-lg navbar-default sticky-top">
							<a class="navbar-brand" href="{$ROOT_WEB}"><img class="logo-main" src="{$ROOT_WEB}images/logo/logo-blackM.png" height="50" width="70" alt="Logo"></a>
							<div class="collapse navbar-collapse header-navigation " id="navbarSupportedContent">
								<ul class="main-nav navbar-nav">
									{$menu_render_horizontal}
								</ul>
							</div>
							<!--<div class="col-auto">
								<div class="header-action d-flex align-items-center">
									<div id="sb-search" class="sb-search" data-bs-toggle="modal" data-bs-target="#search"><i class="fa-solid fa-magnifying-glass"></i></div>
										{* <template:def plugin="plg_productcart_default" position="standard" /> *}

										{if CheckPlugin($smartypluginblocks, "plg_productcart_default", "standard", $data)}
											{include file="order/productcart_default.tpl"}
										{/if} 
									</div>

									<div id="language" class="{$language}">
										<a href="{$ROOT_WEB}eng">ENG</a>
									</div>
								</div>
							</div>!-->
							<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="25" height="25" fill="#002D74"><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
							</button>							
						</nav>
	                </div>
	            </div>

	        </div>
		</header>

<!-- MAIN CONTENT ==================================================================================================== -->
		<main class="main-content">			
			{* <template:def plugin="plg_sections_default" position="slideshow" /> *}
			{if CheckPlugin($smartypluginblocks, "plg_sections_default", "slideshow", $data)}
				{include file="sections_default_slide.tpl"}
			{/if}

			<!-- Middle: -->
		
			{* <template:def plugin="plg_sections_default" position="banners" /> *}
			{if CheckPlugin($smartypluginblocks, "plg_sections_default", "banners", $data)}
				{include file="sections_default.tpl"}
			{/if}

			
			{* ------ grupa proizvoda HOMEPAGE ------ *}
			{* <template:def plugin="plg_grupaproizvod_default" position="homepage" /> *}



			{* plugin for orders module *}
			{* ------ korpa za kupovinu ------ *}
			{if $plugin eq "order" and $plugin_view eq "basket"}
				<div id='order_basket'>{include file="order/basket.tpl"}</div>
			{/if}
			{if $plugin eq "order" and $plugin_view eq "shipment"}
				{include file="order_shipment.tpl"}
			{/if}
			{if $plugin eq "order" and $plugin_view eq "overview"}
				{include file="order/overview.tpl"}
			{/if}
			{if $plugin eq "order" and $plugin_view eq "checkout"}
				{include file="order/checkout.tpl"}
			{/if}
			{if $plugin eq "order" and $plugin_view eq "orderfinish"}
				{include file="order/finish.tpl"}
			{/if}

			{include file="products/product_basket_message.tpl"}

			{if isset($plg_login_details) and $plg_login_details eq "true"}
					{include file="login_details.tpl"}
			{/if}


			<!-- Section: --------- -->
			<section {if $HOME_PAGE neq "true"} id="content" {/if}>
				{if $HOME_PAGE neq "true" and $pagecms eq "true" and $plg_sitemap neq "true" and $plugin neq "order" }		
					{* <template:def plugin="plg_sections_default" position="cts" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "cts", $data)}
						{include file="sections_default_cts.tpl"}
					{/if}					
					
					<div class="container">						
						{if $html neq ''}
							<div class="row">
								{if $page_img}
									<div class="col-md-8">
										<div class="content page-desc">
											<h2>{$header}</h2>
											<h4>{$shorthtml}</h4>
											{$html}	
										</div>
									</div>	
									{* <template:def plugin="plg_naviglinks_default" position="standard" /> *}
									<div class="col-md-4">
										{if CheckPlugin($smartypluginblocks, "plg_naviglinks_default", "standard", $data)}
											{include file="navlinks_default.tpl"}
										{/if}
									</div>
									<div class="col-md-4">
										<img src="{$page_img}"/ style="width:100%">
									</div>
								{else}
									<div class="col-md-12">
										<div class="content page-desc">
											<h2>{$header}</h2>
											<h4>{$shorthtml}</h4>
											{$html}
										</div>
									</div>	
								{/if}	
							</div>
	
						{/if}
						{if $page_img neq ''}
							<div class="row">
								{section name=cnt loop=$images}
									{if $smarty.section.cnt.index gt 1}
										{assign var='rows' value='true'}
									{else}
										{assign var='rows' value='false'}
									{/if}
								{/section}
								<div class="col-lg-12 col-md-12 col-12 order-lg-12 {if $rows eq 'true'}content-gallery{/if}">
									<div class="row {if $rows eq 'true'}web-rows{/if}">
										{section name=cnt loop=$images start=1}
											<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 galerija-wrap">
												<div class="galerija">
													<a class="example-image-link" href="{$ROOT_WEB}{$images[cnt]}" data-lightbox="example-1">
														<div class="image-wrap">
															<img class="example-image" alt="" src="{$ROOT_WEB}{$images_thumb[cnt]}">
														</div>
													</a>
												</div>
											</div>
										{/section}
									</div>
									<div class="loadmore"><button id="loadMore">Load more</button></div>
								</div>
							</div>
						{/if}

						{if $page_vid neq ''}
							<div class="row video-gallery">
								{$page_vid}
							</div>
						{/if}

						{if $page_doc neq ''}
							<div class="row web-rows">
								<div class="col-lg-12 col-md-12 col-12">
									<div class="page-title">
										<h2>{$PLG_PAGE_DOC}</h2>
									</div>
									<div class="product-pdf row">
										{$page_doc}
									</div>
								</div>
							</div>
						{/if}
												
					</div> <!-- End of container -->

				{/if}

				{if (CheckPlugin($smartypluginblocks, "plg_katalogproizvoda_default", "standard", $data) and $plg_search_details neq "true" and $plg_news_details neq "true") or ($plg_katalogproizvoda_details eq "true" and $plg_product_details neq "true") or CheckPlugin($smartypluginblocks, "plg_grupaproizvod_default", "standard", $data)}

					<div class="row position-relative mb-10">
						{* ------ katalog proizvoda STANDARD ------ *}
						{* <template:def plugin="plg_katalogproizvoda_default" position="standard" /> *}
						{if CheckPlugin($smartypluginblocks, "plg_katalogproizvoda_default", "standard", $data) and $plg_search_details neq "true" and $plg_news_details neq "true"}
							{include file="products/productcatalog_default.tpl"}
						{/if}
						{* ------ katalog proizvoda (details kataloga proizvoda) ------ *}
						{if isset($plg_katalogproizvoda_details) and $plg_katalogproizvoda_details eq "true" and $plg_product_details neq "true"}
							<!-- page main wrapper start -->
							{* ------ katalog proizvoda STANDARD ------ *}
							{* <template:def plugin="plg_katalogproizvoda_default" position="products" /> *}
							{if CheckPlugin($smartypluginblocks, "plg_katalogproizvoda_default", "products", $data) and $plg_search_details neq "true" and $plg_news_details neq "true"}
								{include file="products/productcatalog_default.tpl"}
							{/if}
							<div id="catalog-detail" class="col-sm-12 col-md-8 col-lg-9 col-xl-9 product-group">{include file="products/productcatalog_details.tpl"}</div>
						{/if}
						{* ------ grupa proizvoda  ------ *}
						{* <template:def plugin="plg_grupaproizvod_default" position="standard" /> *}
						{if CheckPlugin($smartypluginblocks, "plg_grupaproizvod_default", "standard", $data) and $plg_news_details neq "true"}
							{include file="products/productgroup_default.tpl"}
						{/if}
					</div>

				{/if}

				{* ------ proizvod detalji prikaz------ *}
				{if isset($plg_product_details) and $plg_product_details eq "true"}
					{include file="products/product_details.tpl"}
				{/if}

				{if isset($plg_search_details) and $plg_search_details eq "true"}
					{include file="search_details.tpl"}
				{/if}

				{if isset($plg_news_details) and $plg_news_details eq "true"}
					{include file="news_details.tpl"}
				{/if}				
				
				{if isset($plg_module_details) and $plg_module_details eq "true"}
					{include file="module_details.tpl"}
				{/if}				
				
				{if isset($plg_option_details) and $plg_option_details eq "true"}
					{include file="option_details.tpl"}
				{/if}

				{* <template:def plugin="plg_formcontact_default" position="standard" /> *}
				{if CheckPlugin($smartypluginblocks, "plg_formcontact_default", "standard", $data)}
					{include file="formcontact_default.tpl"}
				{/if}
				{* <template:def plugin="plg_sections_default" position="kontakt-sekcija1" /> *}
				{if CheckPlugin($smartypluginblocks, "plg_sections_default", "kontakt-sekcija1", $data)}
					{include file="sections_default_contact1.tpl"}
				{/if}
				{* <template:def plugin="plg_sections_default" position="kontakt-sekcija2" /> *}
				{if CheckPlugin($smartypluginblocks, "plg_sections_default", "kontakt-sekcija2", $data)}
					{include file="sections_default_contact2.tpl"}
				{/if}
				{* <template:def plugin="plg_sections_default" position="termsofuse" /> *}
				{if CheckPlugin($smartypluginblocks, "plg_sections_default", "termsofuse", $data)}
					{include file="sections_default_termsofuse.tpl"}
				{/if}

				{* <template:def plugin="plg_news_default" position="standard" />*}
				{if CheckPlugin($smartypluginblocks, "plg_news_default", "standard", $data)}
					{include file="news_default.tpl"}
				{/if}				
				
				{* <template:def plugin="plg_module_default" position="standard" />*}
				{if CheckPlugin($smartypluginblocks, "plg_module_default", "standard", $data)}
					{include file="module_default.tpl"}
				{/if}				
				
				{* <template:def plugin="plg_option_default" position="standard" />*}
				{if CheckPlugin($smartypluginblocks, "plg_option_default", "standard", $data)}
					{include file="option_default.tpl"}
				{/if}
			</section>
		</main>

<!-- FOOTER ========================================================================================================= -->
		<footer class="footer-area">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<div class="footer-logo">
							<div class="row ">
								<div class="col-sm-12 d-flex justify-content-center">
									<img src="{$ROOT_WEB}images/logo/logo-color.svg" width="250px" height="250px" />
								</div>
							</div>
						</div>
					</div>	
					<div class="col-lg-8">				
						<!--== Start Footer Main ==-->
						{* <template:def plugin="plg_universalplugin_default" position="footer" /> *}
						{if CheckPlugin($smartypluginblocks, "plg_universalplugin_default", "footer", $data)}
							{include file="universalplugin_default.tpl"}
						{/if}
						<!--== End Footer Main ==-->
						<div class="footer-main">
							<div class="row ">
								<div class="col-sm-12 d-flex justify-content-sm-end">
									<a href="{$ROOT_WEB}{$lang}/terms-of-use-and-privacy-policy/">{$GLOBAL_TERMS}</a></a>
								</div>
							</div>
						</div>
						<!--== Start Footer Bottom ==-->
						<div class="footer-bottom d-flex justify-content-between">
							<div class="copyright">{$GLOBAL_COPYRIGHT}</div>
							<div class="social"><a href="https://www.facebook.com/taxicms"><i class="fa-brands fa-facebook"></i></a> <a href="https://www.linkedin.com/company/taxicms/"><i class="fa-brands fa-linkedin"></i></a> <a href="https://www.instagram.com/taxicms/"><i class="fa-brands fa-square-instagram"></i></a></div>
						</div>

						<div class="footer-bottom">
							{* <template:def plugin="plg_sections_default" position="float-contact" /> *}
							{if CheckPlugin($smartypluginblocks, "plg_sections_default", "float-contact", $data)}
								{include file="sections_default_contact.tpl"}
							{/if}
						</div>

					</div>	
				</div>	
			</div>
		</footer>
	</div> <!-- End of wrapper -->

<!-- SOCIAL MEDIA ====================================================================================== -->
	<div class="social-icons">
		<a href="https://www.facebook.com/taxicms" target="_blank"><div class="in"><img src="{$ROOT_WEB}images/icon-fb.svg" width="22" height="22" /></div></a>
		<a href="https://www.linkedin.com/company/taxicms/" target="_blank"><div class="in"><img src="{$ROOT_WEB}images/icon-in.svg" width="22" height="22" /></div></a>
		<a href="https://www.instagram.com/taxi_cms/" target="_blank"><div class="insta"><img src="{$ROOT_WEB}images/icon-insta.svg" width="22" height="22" /></div></a>
		<div class="soc cont">
			<div class="float-contact">
			{* <template:def plugin="plg_sections_default" position="float-contact" /> *}
			{if CheckPlugin($smartypluginblocks, "plg_sections_default", "float-contact", $data)}
				{include file="sections_default_contact.tpl"}
			{/if}
			</div>
			<img src="{$ROOT_WEB}images/icon-contact.svg" width="22" height="22" />
		</div>
		{* <template:def plugin="plg_news_default" position="notify" /> *}

		{if CheckPlugin($smartypluginblocks, "plg_news_default", "notify", $data)}
			{include file="news_default_notify.tpl"}
		{/if}


	</div>
<!-- OTHER: ================================================================================= -->
	{include file="search_default.tpl"}
	<!-- Custom Main JS -->
	<!-- Bootstrap Core JavaScript -->

	<script src="{$ROOT_WEB}includes/js/jquery.matchHeight.js"></script>
	<script src="{$ROOT_WEB}includes/js/fancybox.min.js"></script>
	<script src="{$ROOT_WEB}includes/js/lightbox.js"></script>
	<script src="{$ROOT_WEB}includes/js/main.js?version=1"></script>

</body>
</html>
