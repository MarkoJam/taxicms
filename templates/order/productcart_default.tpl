<script>

</script>
	<div class="cart">
	{if $data.basketCount gt 0 and $orderfinish neq "true" }
	<a id="cart" href="{$data.basketLink}" class="position-relative">
		<i class="fa-solid fa-cart-shopping"></i>
		<span {if $data.basketCount eq 0} style='display:none;' {/if}>{$data.basketCount}</span>
	</a>
	{else}
	<i class="fa-solid fa-cart-shopping"></i>
	{/if}
</div>
{*
  <div  class="cart_tab" id="cart_content">
{if $data.basketCount gt 0}
<table cellspacing="0" cellpadding="0" width="100%" border="0" >
	<tr>
		<td colspan="2">
			<h3>Broj proizvoda u korpi: {$data.basketCount}</h3>
		</td>
	</tr>
	{section name=cnt loop=$proizvodi_basket}
	<tr>
		<td class="product"><img src="{$ROOT_WEB}{$proizvodi_basket[cnt].slikathumb}" /></td>
		<td class="product">
			<p class="naziv"><a href='{$proizvodi_basket[cnt].link}'>{$proizvodi_basket[cnt].naziv}</a></p>
			<p class="kolicina">Količina: {$proizvodi_basket[cnt].kolicinabasket}</p>
		</td>
	</tr>
	{/section}
	<tr>
		<td colspan="2">
			<div class="orderoklop">
					<a href="{$data.basketLink}">
					<div id="view_cart">
							Pogledaj korpu
					</div>
					</a>
			</div>
		</td>
	</tr>
</table>
{else}
	<p>{$PLG_PRODUCT_BASKET_EMPTY} </p>
{/if}
</div>
*}
