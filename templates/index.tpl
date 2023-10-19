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

{include file="templates/additional-style.tpl"}
<body>
	<!--== Wrapper Start ==-->
	<div class="wrapper">
	    <!--== Header Wrapper Start ==-->
	    <header class="header-wrapper d-flex justify-content-center flex-column header-wrapper-edit">
			<div class="header-middle">
				<!-- Conainer: -->
	            <div class="container">
	                <div class="row align-items-center justify-content-between align-items-center">
						<nav class="navbar navbar-expand-lg navbar-default navbar-default-edit">
							<a class="navbar-brand" href="{$ROOT_WEB}"><img class="logo-main" src="{$ROOT_WEB}images/logo/logo-black.svg" alt="Logo" width="200px" height="100px"></a>
							<div class="collapse navbar-collapse header-navigation " id="navbarSupportedContent">
								<!-- Main nav: -->
								<ul class="main-nav navbar-nav">
									{$menu_render_horizontal}
								</ul>
							</div>
							<div class="col-auto">
								<div class="header-action d-flex align-items-center">
									<div id="sb-search" class="sb-search" data-bs-toggle="modal" data-bs-target="#search"><i class="fa-solid fa-magnifying-glass"></i></div>
									<!--<div id='cart_content' class=" minicart">
										{* <template:def plugin="plg_productcart_default" position="standard" /> *}

										<!-- Info - plg_productcart_default->pluginName, standard->pluginPosition -->
										{* {if CheckPlugin($smartypluginblocks, "plg_productcart_default", "standard", $data)}
											{include file="order/productcart_default.tpl"}
										{/if} *}
									</div>
									{*<div class="book">
										<a href="{ROOT_WEB}{$lang}{$PLG_LINK_CATALOGUE}">
											<svg width="16" height="19" viewBox="0 0 23 31" fill="#002D74" xmlns="http://www.w3.org/2000/svg">
												<path d="M22.1054 9.2647V25.7747C22.1054 26.6073 21.3917 27.0045 20.5265 27.6249C19.8318 28.1242 18.9476 27.5053 18.9476 26.6887V10.5567C18.9476 10.2201 18.8307 9.89951 18.4518 9.70333C18.0728 9.50714 6.23415 3.21958 6.23415 3.21958C6.0431 3.14781 5.20944 2.61667 4.09788 3.19406C3.04159 3.74275 2.46686 4.33929 2.32002 4.62001L15.2355 11.7689C15.5782 11.9507 15.7897 12.2314 15.7897 12.5919V29.8213C15.7858 30.0156 15.7295 30.2052 15.6268 30.3696C15.5242 30.5341 15.3791 30.6671 15.2071 30.7544C15.0436 30.8359 14.8636 30.8779 14.6813 30.8772C14.4669 30.8797 14.256 30.8223 14.0719 30.7113C13.7324 30.5023 1.7974 23.1094 1.00953 22.6293C0.630586 22.3997 0.186911 21.9291 0.177438 21.5798L0.000599562 5.17348C0.000599562 4.85767 -0.0357154 4.301 0.456906 3.52742C1.55741 1.79842 5.39733 -0.168233 7.34097 0.850983L21.5496 8.11629C21.8922 8.29493 22.1054 8.65221 22.1054 9.2647Z" fill=""/>
											</svg>
										</a>
									</div>*}
									<div id="language" class="{$language}">
										{*<a href="{$ROOT_WEB}eng">ENG</a>*}
									</div>
								</div>
								{*<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="25" height="25" fill="#002D74"><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
								</button>*}
							</div>
						</nav>
	                </div>
	            </div>

	        </div>
		</header>

<!-- MAIN CONTENT ==================================================================================================== -->
		<main class="main-content">
			<!-- Top: -->
			<div class="row">
				<div class="col-md-9">
					{* <template:def plugin="plg_sections_default" position="slideshow" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "slideshow", $data)}
						{include file="sections_default_slide.tpl"}
					{/if}
				</div>			
				<div class="col-md-3">
					{* <template:def plugin="plg_news_default" position="homepage" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_news_default", "homepage", $data)}
						{include file="news_default_home.tpl"}
					{/if}
				</div>
			</div>

			<!-- Middle: -->
			<div class="row">
				<div class="col-md-9">			
					{* <template:def plugin="plg_sections_default" position="about" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "about", $data)}
						{include file="sections_default_about.tpl"}
					{/if}
				</div>			
				<div class="col-md-3">
					{* ------ katalog proizvoda Home page ------ *}
					{* <template:def plugin="plg_katalogproizvoda_default" position="home" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_katalogproizvoda_default", "home", $data)}
						{include file="products/productcatalog_default_home.tpl"}
					{/if}
				</div>
			</div>
			
			{* ------ grupa proizvoda HOMEPAGE ------ *}
			{* <template:def plugin="plg_grupaproizvod_default" position="homepage" /> *}

			{* {if CheckPlugin($smartypluginblocks, "plg_grupaproizvod_default", "homepage", $data)}
				{if $data.grupaproizvoda_view eq "SIMPLE_VIEW"}
					{include file="products/product_default_home.tpl"}
				{/if}
				{if $data.grupaproizvoda_view eq "COMPLEX_VIEW"}
					{include file="products/productgroupcomplex_default.tpl"}
				{/if}
			{/if} *}

			{* <template:def plugin="plg_newsletter_default" position="standard" /> *}
			{if CheckPlugin($smartypluginblocks, "plg_newsletter_default", "standard", $data)}
				{include file="newsletter_default_mc.tpl"}
			{/if}

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
					{* <template:def plugin="plg_sections_default" position="onama-sekcija1" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "onama-sekcija1", $data)}
						{include file="sections_default_onama1.tpl"}
					{/if}
					{* <template:def plugin="plg_sections_default" position="onama-sekcija2" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "onama-sekcija2", $data)}
						{include file="sections_default_onama2.tpl"}
					{/if}
					{* <template:def plugin="plg_sections_default" position="onama-sekcija3" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "onama-sekcija3", $data)}
						{include file="sections_default_onama3.tpl"}
					{/if}
					{* <template:def plugin="plg_sections_default" position="system-sekcija1" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "system-sekcija1", $data)}
						{include file="sections_default_system1.tpl"}
					{/if}
					{* <template:def plugin="plg_sections_default" position="system-sekcija2" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "system-sekcija2", $data)}
						{include file="sections_default_system2.tpl"}
					{/if}
					{* <template:def plugin="plg_sections_default" position="system-sekcija3" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "system-sekcija3", $data)}
						{include file="sections_default_system3.tpl"}
					{/if}
					{* <template:def plugin="plg_sections_default" position="system-sekcija4" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "system-sekcija4", $data)}
						{include file="sections_default_system4.tpl"}
					{/if}
					{* <template:def plugin="plg_sections_default" position="system-sekcija5" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "system-sekcija5", $data)}
						{include file="sections_default_system5.tpl"}
					{/if}
					{* <template:def plugin="plg_sections_default" position="system-sekcija6" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "system-sekcija6", $data)}
						{include file="sections_default_system6.tpl"}
					{/if}
					{* <template:def plugin="plg_sections_default" position="cts" /> *}
					{if CheckPlugin($smartypluginblocks, "plg_sections_default", "cts", $data)}
						{include file="sections_default_cts.tpl"}
					{/if}
					<div class="container">
						{* <template:def plugin="plg_naviglinks_default" position="standard" /> *}
						{if CheckPlugin($smartypluginblocks, "plg_naviglinks_default", "standard", $data)}
							{include file="navlinks_default.tpl"}
						{/if}
						
						{if $html neq ''}
							<div class="row">
								<div class="col-md-12">
									<div class="content page-desc">
										<h1>{$header}</h1>
										<h4>{$shorthtml}</h4>
										{$html}
									</div>
								</div>
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
