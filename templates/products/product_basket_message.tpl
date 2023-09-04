<!-- tpl:ProductBasketMessage -->
{if $smarty.request.basket_message}
	<div id="basket_message">
		{if $smarty.request.basket_message eq "added"}
			<p>
				Proizvodi su uspešno dodati u korpu za naručivanje. 
			</p>
		{/if}
		
		{if $smarty.request.basket_message neq "added" and $smarty.request.basket_message neq "noselection"}
			{$smarty.request.basket_message}
		{/if}
	</div>
{/if}
<!-- tpl:ProductBasketMessage -->