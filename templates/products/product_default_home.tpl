<!-- tpl:ProductDefaultHome -->
<section class="products-area">
	<form action="plugins/plg_order/korpa_add_one.php" method="POST">
	<div class="container">
		<div class="row">
			{section name=cnt loop=$data.proizvodi_all}

			<div class="col-md-4 itemheight">

					<div class="product-box">
						<h2><a href="{$data.proizvodi_all[cnt].link}">{$data.proizvodi_all[cnt].naziv}</a></h2>
						{$data.proizvodi_all[cnt].kratakopis}
						<div class="slika slika-home" {if $data.proizvodi_all[cnt].slikaover neq ''}style="background-image: url('{$data.proizvodi_all[cnt].slikaover}');"{else}style="background-image: url('{$data.proizvodi_all[cnt].slika}');"{/if}>
								<a class="product-item-thumb" href="{$data.proizvodi_all[cnt].link}">
					      	<img src="{$ROOT_WEB}{$data.proizvodi_all[cnt].slika}" alt="{$data.proizvodi_all[cnt].naziv}">
					      </a>
						</div>
						{if $data.proizvodi_all[cnt].statusid eq 54 }

						{else}
						<a class="product-button" href="{$data.proizvodi_all[cnt].link}">
							{$PLG_PRODUCT_ORDER}
						</a>
						{/if}
					</div>
			</div>
			{/section}
		</div>
	</div>
	</form>
</section>
<!-- tpl:ProductDefaultHome -->
