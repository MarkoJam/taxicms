<script type="application/ld+json">
{literal}
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{/literal}{$proizvod_detail.naziv} {literal}",
  "image": [
	{/literal}
	{section name=cnt loop=$images}
			"{$images[cnt]}"{if $smarty.section.cnt.last}{else},{/if}
	{/section}
	{literal}
   ],
  "description": "{/literal}{$proizvod_detail.napomenaadd}{literal}",
  "sku": "{/literal}{$proizvod_detail.sifra}{literal}",
  "mpn": "{/literal}{$proizvod_detail.sifra}{literal}",
  "brand": {
    "@type": "Thing",
    "name": "Blue Molds"
  },
  "offers": {
    "@type": "Offer",
    "url": "{/literal}{$ROOT_WEB}{$smarty.server.REQUEST_URI}{literal}",
    "priceCurrency": "{/literal}{$smarty.session.currency}{literal}",
    "price": "{/literal}{if $proizvod_detail.cenab eq 0}{$proizvod_detail.cenaa|number_format:2:'.':','}{else}{$proizvod_detail.cenab|number_format:2:'.':','}{/if}{literal}",
    "itemCondition": "https://schema.org/NewCondition",
    "availability": "{/literal}{if $proizvod_detail.statusid eq 51 }https://schema.org/InStock {/if}{if $proizvod_detail.statusid eq 56 }https://schema.org/LimitedAvailability {/if}{if $proizvod_detail.statusid eq 54 }https://schema.org/SoldOut {/if}{literal}",
    "seller": {
      "@type": "Organization",
      "name": "Blue Molds"
    }
  }
}
{/literal}
</script>
<script>
{literal}
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
  var url = '{/literal}{$ROOT_WEB}{literal}plugins/plg_order/sessionUpdateAjax.php?proizvodid='+id+'&kolicina='+kol+'&lang={/literal}{$lang}{literal}';
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
    			var submit = $('#add_cart span').text('{/literal}{$PLG_ADDED}{literal}');
    			setTimeout(function() {$(submit).text('{/literal}{$PLG_PRODUCT_BASKET}{literal}') }, 2000);
    		}
    	})
    }
});
{/literal}
</script>
<!-- tpl:ProductDetails -->
<div class="container">
    <div class="row position-relative">
{if $details.pathData neq "" and $details.pathData neq "&nbsp;"}
<div class="path path-products">
{if count($details.pathData) gt 1}
<ul>
		{foreach from=$details.pathData item=pathData name=parentData}
	 			{if $smarty.foreach.parentData.first}
	 				<li><a href="{$ROOT_WEB}{$lang}{$PLG_LINK_PRODUCTS}">{$pathData.title}</a></li>
	 			{else}
	 				<li><a href='{$pathData.link}'>{$pathData.title}</a></li>
 				{/if}
		{/foreach}
    <li>{$proizvod_detail.naziv}</li>
</ul>
		{/if}
</div>
{/if}

	<form action="plugins/plg_order/korpa_add_one.php" method="POST">
		<div class="product-detail-area">
				<div class="container">
						<div class="row product-detail-box">
								<div class="col-sm-12 col-md-6 col-lg-6 product-detail-image">
										<div class="product-detail-thumb">
                    	<div class="swiper myimage">
							<div class="swiper-wrapper">
                              <div class="swiper-slide">
  									<a class="lightbox-image" data-fancybox="gallery" href="{$ROOT_WEB}{$proizvod_detail.slika}">
                                	<img src="{$ROOT_WEB}{$proizvod_detail.slika}"  alt="Image">
                                </a>
                              </div>
															{section name=cnt loop=$images start=0}
                              <div class="swiper-slide">
  															<a class="lightbox-image" data-fancybox="gallery" href="{$ROOT_WEB}{$images[cnt]}">
                                	<img src="{$ROOT_WEB}{$images[cnt]}"  alt="Image">
                                </a>
                              </div>
															{/section}
														</div>

													</div>
													<div thumbsSlider="" class="swiper myimagethumb">
															<div class="swiper-wrapper">
                                <div class="nav-item swiper-slide">
                                  	<img src="{$ROOT_WEB}{$proizvod_detail.slika}"  alt="Image">
                                </div>
																{section name=cnt loop=$images start=0}
																<div class="nav-item swiper-slide">
                                	<img src="{$ROOT_WEB}{$images_thumb[cnt]}" alt="Image" >
                                </div>
																{/section}
															</div>
														</div>
													</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6 product-detail-content">
                            <div class="product-detail-content">
                                <h4>{$pathData.title}</h4>
                                <p class="code">{$proizvod_detail.sifra}</p>
                                <h2 class="product-detail-title">{$proizvod_detail.naziv}</h2>
								{if $proizvod_detail.cenaamp neq 0}
									{if $proizvod_detail.cenabmp eq 0}
										<div class="product-detail-price">€ {$proizvod_detail.cenaampformatirano}</div>
									{else}
										<div class="product-detail-old-price">€ {$proizvod_detail.cenaampformatirano}</div>
										<div class="product-detail-price">€ {$proizvod_detail.cenabmpformatirano}</div>
									{/if}
								{else}

								{/if}

                                <div class="product-description">{$proizvod_detail.opis}</div>
								
								{section loop=$proizvod_detail.modules name=cnt}
									<h4><a href="{$proizvod_detail.modules[cnt].link}">{$proizvod_detail.modules[cnt].title}</a></h4>
									{section loop=$proizvod_detail.modules[cnt].options name=cnt2}
										<ul>
											<a href="{$proizvod_detail.modules[cnt].options[cnt2].link_dt}">{$proizvod_detail.modules[cnt].options[cnt2].title}</a>
											{if $proizvod_detail.modules[cnt].options[cnt2].link ne ""}
												<a class="bg-info rounded-circle" href="{$ROOT_DEMO}{$proizvod_detail.modules[cnt].options[cnt2].link}"><i>DEMO</i></a>
												<a href="{$ROOT_HELP}{$proizvod_detail.modules[cnt].options[cnt2].link}"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
											{/if}
										</ul>
									{/section}
								{/section}
                              </div>
                            </div>
							{*
                            <div class="col-sm-12 col-md-6 col-lg-6 product-detail-cart ">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="pro-qty">
											<label>{$PLG_PRODUCT_ORDER_QUANTITY}:</label>
											<button type="button" id="sub" class="sub"><i class="fa-solid fa-chevron-down"></i></button>
                                            <input type="text" class="quantity" title="Quantity" value="1"  disabled />
                                            <button type="button" id="add" class="add"><i class="fa-solid fa-chevron-up"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
									{if $proizvod_detail.statusid neq 54 and $proizvod_detail.cenaamp neq 0 }
										<button id="add_cart" class="product-detail-cart-btn" type="button"><i class="fa-solid fa-cart-shopping"></i> <span>{$PLG_PRODUCT_BASKET}</span></button>
										<div id="proizvodid" style="display:none">{$proizvod_detail.proizvodid}</div>
									{/if}
                                    </div>
                                </div>
                            </div>
							
							<ul class="product-detail-meta">
								{if $karakteristike_all|@count gt 0}
								{section name=cnt loop=$karakteristike_all}
								{if $karakteristike_all[cnt].vrednost neq "*"}
								<li><span>{$karakteristike_all[cnt].naziv}:</span>{$karakteristike_all[cnt].vrednost}</li>
								{else}
								<li><span>{$karakteristike_all[cnt].naziv}</span></li>
								{/if}
								{/section}
								{/if}
							</ul>
							*}
						</div>
                            	{include file="products/conected_products.tpl"}
													</div>

						</div>

	</form>
  </div>
  </div>
