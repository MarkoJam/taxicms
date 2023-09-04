
{if $orderfinish}
	{include file="order/checkout.tpl"}
{else}
	<script src="{$ROOT_WEB}includes/js/jquery.validate.js"></script>
	<script>
	{literal}
	$("form").validate();
	$(document).ready(function() {
		//$('#button-submit').click(function() {
	//		$('.login-form').addClass('open');
	//	})
	$('.add').click(function () {
			if ($(this).prev().val() < 100) {
			$(this).prev().val(+$(this).prev().val() + 1);
				$(this).prev().trigger('change');
			}
	});
	$('.sub').click(function () {
			if ($(this).next().val() > 1) {
			if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
				$(this).next().trigger('change');
			}
	});

		$('.deleteproduct').click(function() {
			var id=$(this).attr('data-id');
			var selector='#id'+id;
			$(selector).hide(2000);
			selector=selector+' .quantity';
			$(selector).val(0);
			$(selector).trigger('change');
		})

		$('.quantity').change(function() {
			var kol=$(this).val();
			if (kol<0) $(this).val(0);
			var id=$(this).attr('data-id');
<<<<<<< HEAD
			var url = '{/literal}{$ROOT_WEB}{literal}plugins/plg_order/sessionUpdateAjax.php?option=1&proizvodid='+id+'&kolicina='+kol+'&lang={/literal}{$lang}{literal}';
=======
			var url = '{/literal}{$ROOT_WEB}{literal}plugins/plg_order/sessionUpdateAjax.php?option=1&proizvodid='+id+'&kolicina='+kol;
>>>>>>> 6c7a9b31ef9c3ffc476a9fd2a48f5bef9fa01d80
			update_basket(url);

			var url2 = '{/literal}{$ROOT_WEB}{literal}plugins/plg_order/basketUpdateAjax.php?lang={/literal}{$lang}{literal}';
			$.ajax({
				type: 'GET',
				url: url2,
				async: false,
				success: function(data) {
					$('#order_basket').html(data);
				}
			})
		})

		$('.same_address').click(function() {
			if( $(this).is(':checked')) {
			$(".shipping_body").show();
			$('#shipaddress').val($('#address').val());
			$('#shipcity').val($('#city').val());
			$('#shippostalcode ').val($('#postalcode' ).val());
			$('#shipcountry ').val($('#country' ).val());
			} else {
			$(".shipping_body").hide();
			}
		});
		$('.order-proceed').click(function() {
			$("#orderdata").show();
			$(this).hide();
		});
	})
	{/literal}
	</script>
	{if $message_unsucsesfull}
		<p style='color:red;'>Plaćanje je neuspešno, molimo ponovite!</p>
	{/if}
	<div class="basket-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="entry-header-title">
						<h2>{$PLG_SHOPPING_CART}</h2>
					</div>
				</div>
			</div>

		{if $editbasket_message neq ""}
			<div class="basket_message">
				{$editbasket_message}
			</div>
		{/if}
	</div>
		{if $empty_basket eq "false"}
		<div class="container">
		<form action="" name="korpaEdit" method="POST" id="form">
				<div class="row">
					<div class="col-lg-12">
							<div class="table-content">
									<table class="w-100">
										<thead>
											<tr>
												<th class="product-remove"></th>
												<th class="product-thumbnail"></th>
												<th class="product-name">{$PLG_PRODUCT}</th>
												<th class="product-code">{$PLG_PRODUCT_CODE}</th>
												<th class="product-price">{$PLG_PRODUCT_ORDER_PRICE}</th>
												<th class="product-quantity">{$PLG_PRODUCT_ORDER_QUANTITY}</th>
												<th class="product-subtotal">{$PLG_PRODUCT_ORDER_TOTAL}</th>
											</tr>
										</thead>
										<tbody>

					{section name=cnt loop=$proizvodi_basket}

					<tr class="row-basket" id='id{$proizvodi_basket[cnt].proizvodid}'>
						<td class="product-remove">
								<i data-id='{$proizvodi_basket[cnt].proizvodid}' class="fa fa-times deleteproduct"></i>
						</td>
						<td class="product-thumbnail">
							{if $proizvodi_basket[cnt].slika eq ""}
								<img src="{$ROOT_WEB}files/Image/product-noimage.png"  />
							{else}
								<img src="{$ROOT_WEB}{$proizvodi_basket[cnt].slikathumb}" />
							{/if}
						</td>
						<td class="product-name" data-label="{$PLG_PRODUCT}">
								<a href='{$proizvodi_basket[cnt].link}'>{$proizvodi_basket[cnt].naziv}</a>
						</td>
						<td class="product-code" data-label="{$PLG_PRODUCT_CODE}">
								{$proizvodi_basket[cnt].sifra}
						</td>
						<td class="product-price" data-label="{$PLG_PRODUCT_ORDER_PRICE}"><span class="amount">{$smarty.session.currency} €  {$proizvodi_basket[cnt].cenabasket|number_format:2:",":"."} </span>
							{if $proizvodi_basket[cnt].popust gt 0}
								{if $proizvodi_basket[cnt].cenaosnovnab gt 0}
									<br>€ {$proizvodi_basket[cnt].cenaosnovnab|number_format:2:",":"."}
								{else}
									<br>€ {$proizvodi_basket[cnt].cenaosnovnaa|number_format:2:",":"."}
								{/if}
								<br>{$proizvodi_basket[cnt].popustopis} {$proizvodi_basket[cnt].popust|number_format:0:",":"."}%
							{/if}
						</td>
						<td class="product-quantity" data-label="{$PLG_PRODUCT_ORDER_QUANTITY}">
							<button type="button" id="sub" class="sub"><i class="fa-solid fa-chevron-down"></i></button>
							<input type='text' name='quantity' class='quantity' data-price='{$proizvodi_basket[cnt].cenabasket}' data-id='{$proizvodi_basket[cnt].proizvodid}' value='{$proizvodi_basket[cnt].kolicinabasket}'/>
							<button type="button" id="add" class="add"><i class="fa-solid fa-chevron-up"></i></button>
						</td>
						<input name="proizvod_id" type="hidden" id="proizvod_id" value="{$proizvodi_basket[cnt].proizvodid}">
						<td id='row_total-{$proizvodi_basket[cnt].proizvodid}' class="product-subtotal" data-label="{$PLG_PRODUCT_ORDER_TOTAL}">€  {$proizvodi_basket[cnt].medjuzbirbasket|number_format:2:",":""}</td>
					</tr>
					{/section}
					<tr class="price-total-wrap">
						<td class="price-blank"></td>
						<td class="price-description" colspan="5">{$PLG_PRODUCT_ORDER_TEXT} </br>{$PLG_PRODUCT_ORDER_TEXT2}</td>
						<td class="total-amount">€  <input readonly id='totalprice' class="amount" value='{$ukupna_cena|number_format:2:",":"."}'/></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	</div>
	<div class="row mt-10">
				<div class="col-lg-6 col-md-6 col-12">
					<div class="buttons-cart mb-30">
					  <a href="{$ROOT_WEB}{$lang}{$PLG_LINK_PRODUCTS}">{$PLG_PRODUCT_ORDER_CONTINUE}</a>
					</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12">
									<div class="wc-proceed-to-checkout">
											<a href="#orderdata" class="order-proceed">{$PLG_PRODUCT_ORDER_PROCEED}</a>
									</div>
								</div>
							</div>
	</div>
	<div  id="orderdata" style="display:none;">
	<div class="container" >
	<div class="row">
		<div class="col-lg-12">
			<div class="entry-header-title">
				<h2>{$PLG_PRODUCT_ORDER_DATA}</h2>
			</div>
		</div>
	</div>
	</div>
	<div class="container order-data" >
	<div class="row">
		<div class="col-lg-6 col-md-6 col-12 ">
				<div class="checkout-form-list">
						<label>{$PLG_COMPANY}</label>
						<input name="company" type="text" value="{$company}" required />
				</div>
		</div>
		<div class="col-lg-6 col-md-6 col-12">
				<div class="checkout-form-list">
						<label>{$PLG_PIB} </label>
						<input name="pib" type="text" value="{$pib}" required />
				</div>
		</div>

			<div class="col-lg-6 col-md-6 col-12 ">
					<div class="checkout-form-list">
							<label>{$PLG_NAME}</label>
							<input name="name" type="text" value="{$name}" required />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_ADDRESS} </label>
							<input name="address" id="address" type="text" value="{$address}" required />
					</div>
			</div>

			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_SURNAME}</label>
							<input name="surname" type="text" value="{$surname}" required />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_POSTALCODE} </label>
							<input name="postalcode" id="postalcode" type="text" value="{$postalcode}" required />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_EMAIL} </label>
							<input name="email" type="email" id="email" value="{$email}" required email />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_CITY} </label>
							<input name="city" id="city" type="text" value="{$city}" required />
					</div>
			</div>

			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_PHONE}  </label>
							<input name="phone" type="text" value="{$phone}" required />
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_STATE}  </label>
							<input name="country" id="country" type="text" value="{$country}" required />
					</div>
			</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="sameaddress tick d-flex justify-content-start">
				<input type="checkbox" name="sameaddress" class="same_address mt-4 align-self-start" /> <label class="ms-4 mt-3">{$PLG_ADDRESS_CHECKED}</label>
			</div>
		</div>
	</div>

	<div class="row shipping_body mt-5" style="display:none;">
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_ADDRESS} </label>
							<input name="shipaddress" id="shipaddress" type="text" value="{$shipaddress}">
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_POSTALCODE} </label>
							<input name="shippostalcode" id="shippostalcode" type="text" value="{$shippostalcode}">
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_CITY}</label>
							<input name="shipcity" id="shipcity" type="text" value="{$shipcity}">
					</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12">
					<div class="checkout-form-list">
							<label>{$PLG_STATE}  </label>
							<input name="shipcountry" id="shipcountry" type="text" value="{$shipcountry}">
					</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="gdpr-click d-flex">
					<input type="checkbox" class="checkbox gdpr mt-4 align-self-start" id="agree" name="agree" required  />
				<label class="ms-4 mt-3">{$PLG_CONTACT_INFO}</label>
			</div>
		</div>
		<div class="col-12">
			<input type="submit" value="{$PLG_PRODUCT_ORDER_FINISH}" name="order_finish" id="order_finish" />
		</div>
	</div>
				<input type="hidden" value="{$order_type}" name="order_type" id="order_type" />
				<input type="hidden" value="{$smarty.server.QUERY_STRING}" name="backurl" id="backurl" />
			</form>
			</div>
		</div>
		{else}
		<div class="container">
			<p class="korpa">Dear customer, <br> shopping cart is empty</p>
		</div>
		{/if}
	</div>
{/if}
