<script>
{literal}
	$(document).ready(function(){
		$(".update").click(function(){
			window.error=0;
			$('#form input').each(function() {
				var value= $(this).val();
				if ((!$.trim(this.value).length)) {
					$(this).addClass('border_red');
					$(this).css('border', '1px solid red');
					window.error=1;
				}
			});
			if (window.error==0) {
				$('#form').submit();
			}
		});
	});
{/literal}
</script>
<div class="basket-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="entry-header-title">
					<h2>{$PLG_PRODUCT_ORDER_CONFIRM}</h2>
				</div>
			</div>
		</div>
{if $editbasket_message neq ""}
		<div class="basket_message">
			{$editbasket_message}
		</div>
	{/if}
</div>
	<div class="container">
		<div class="row">
				<div class="col-lg-12">
						<div class="table-content table-responsive">
								<table class="w-100">
									<thead>
										<tr>
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
									<td class="product-thumbnail">
										{if $proizvodi_basket[cnt].slika eq ""}
											<img src="{$ROOT_WEB}files/Image/product-noimage.png"  />
										{else}
											<img src="{$ROOT_WEB}{$proizvodi_basket[cnt].slikathumb}" />
										{/if}
									</td>
									<td class="product-name">
											<a href='{$proizvodi_basket[cnt].link}'>{$proizvodi_basket[cnt].naziv}</a>
									</td>
									<td class="product-code">
											{$proizvodi_basket[cnt].sifra}
									</td>
									<td class="product-price"><span class="amount"> €  {$proizvodi_basket[cnt].cenabasket|number_format:2:",":"."} </span>
										{if $proizvodi_basket[cnt].popust gt 0}
											{if $proizvodi_basket[cnt].cenaosnovnab gt 0}
												<br>€  {$proizvodi_basket[cnt].cenaosnovnab|number_format:2:",":"."}
											{else}
												<br>€  {$proizvodi_basket[cnt].cenaosnovnaa|number_format:2:",":"."}
											{/if}
											<br>{$proizvodi_basket[cnt].popustopis} {$proizvodi_basket[cnt].popust|number_format:0:",":"."}%
										{/if}
									</td>
									<td class="product-quantity">
										{$proizvodi_basket[cnt].kolicinabasket}
									</td>
									<td class="product-subtotal">€ {$proizvodi_basket[cnt].medjuzbirbasket|number_format:2:",":""}</td>
								</tr>
								{/section}
								<tr>
									<td colspan="5">{$PLG_PRODUCT_ORDER_TEXT} </br>{$PLG_PRODUCT_ORDER_TEXT2}</td>
									<td>€ {$ukupna_cena|number_format:2:",":"."}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="container" >
			<div class="order-data-checkout">
				<div class="row">
						<div class="col-12 order-data-title">
							<h3>{$PLG_PRODUCT_ORDER_NO} {$orderid}</h3>
							<h5>{$PLG_PRODUCT_ORDER_DATE} <span>{$smarty.now|date_format}</span></h5>
						</div>
					</div>
					<div class="row order-data-list">
						<div class="col-lg-6 col-md-12 col-12 ">
								<div class="checkout-form-list">
										<label><div class="name d-inline-block">{$PLG_COMPANY}:</div> <span>{$company}</span></label>
								</div>
						</div>
						<div class="col-lg-6 col-md-12 col-12">
								<div class="checkout-form-list">
										<label><div class="name d-inline-block">{$PLG_PIB}:</div> <span>{$pib}</span></label>
								</div>
						</div>
							<div class="col-lg-6 col-md-12 col-12 ">
									<div class="checkout-form-list">
											<label><div class="name d-inline-block">{$PLG_NAME}:</div> <span>{$name}</span></label>
									</div>
							</div>
							<div class="col-lg-6 col-md-12 col-12">
									<div class="checkout-form-list">
											<label><div class="name d-inline-block">{$PLG_ADDRESS}:</div> <span>{$address}</span></label>
									</div>
							</div>
							<div class="col-lg-6 col-md-12 col-12">
									<div class="checkout-form-list">
											<label><div class="name d-inline-block">{$PLG_SURNAME}:</div> <span>{$surname}</span></label>
									</div>
							</div>
							<div class="col-lg-6 col-md-12 col-12">
									<div class="checkout-form-list">
											<label><div class="name d-inline-block">{$PLG_POSTALCODE}:</div> <span>{$postalcode}</span></label>
									</div>
							</div>
							<div class="col-lg-6 col-md-12 col-12">
									<div class="checkout-form-list">
											<label><div class="name d-inline-block">{$PLG_EMAIL}:</div> <span>{$email}</span></label>
									</div>
							</div>
							<div class="col-lg-6 col-md-12 col-12">
									<div class="checkout-form-list">
											<label><div class="name d-inline-block">{$PLG_CITY}:</div> <span>{$city}</span></label>
									</div>
							</div>
							<div class="col-lg-6 col-md-12 col-12">
									<div class="checkout-form-list">
											<label><div class="name d-inline-block">{$PLG_PHONE}:</div>  <span>{$phone}</span></label>
									</div>
							</div>
							<div class="col-lg-6 col-md-12 col-12">
									<div class="checkout-form-list">
											<label><div class="name d-inline-block">{$PLG_STATE}:</div>  <span>{$country}</span></label>
									</div>
							</div>
					</div>
				</div>
				<div class="order-data-checkout">
					<div class="row">
							<div class="col-12 order-data-title">
								<h3>{$PLG_PRODUCT_ORDER_ADDRESS_ORDER}:</h3>
							</div>
					</div>
					<div class="row order-data-list">
						<div class="col-lg-6 col-md-12 col-12">
								<div class="checkout-form-list">
										<label><div class="name d-inline-block">{$PLG_ADDRESS}:</div> <span>{$shipaddress}</span></label>
								</div>
						</div>
						<div class="col-lg-6 col-md-12 col-12">
								<div class="checkout-form-list">
										<label><div class="name d-inline-block">{$PLG_POSTALCODE}:</div> <span>{$shippostalcode}</span></label>
								</div>
						</div>
						<div class="col-lg-6 col-md-12 col-12">
								<div class="checkout-form-list">
										<label><div class="name d-inline-block">{$PLG_CITY}:</div> <span>{$shipcity}</span></label>
								</div>
						</div>
						<div class="col-lg-6 col-md-12 col-12">
								<div class="checkout-form-list">
										<label><div class="name d-inline-block">{$PLG_STATE}:</div>  <span>{$shipcountry}</span></label>
								</div>
						</div>
				</div>
			</div>
		</div>
	</div>
