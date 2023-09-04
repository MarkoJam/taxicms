{if $plugin_view eq "search_results"}

<div class="search-header-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="gp-title">
						<h2>{$PLG_SEARCH_RESULTS}</h2>
						<h3>{$PLG_SEARCH_RESULTS_KEYWORD} <strong>{$keywords}</strong></h3>
						<h3>{$PLG_SEARCH_FOUND} <strong>{math equation="a + b + c" a=$product_results|@count b=$page_results|@count c=$resources_count }</strong></h3>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="search-result-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-12">

    	{if $product_search eq "true"}
				{if count($product_results) gt 0}
				<div class="row product-search">
					<div class="col-md-3">
						<h3>{$PLG_PRODUCTS}</h3>
					</div>
					<div class="col-md-9">
					{section name=cnt loop=$product_results}
					{if $product_results[cnt].pathData neq "" and $product_results[cnt].pathData neq "&nbsp;"}
								{if count($product_results[cnt].pathData) gt 1}
									{foreach from=$product_results[cnt].pathData item=pathData name=parentData}
									{if $pathData.link neq '*'}
										<a href='{$pathData.link}'>{$pathData.title}</a> /
									{else}
									{$pathData.title} /
									{/if}
									{/foreach}
								{/if}
							{/if}
							<a href="{$product_results[cnt].link}">{$product_results[cnt].naziv}</a>
					{/section}
					</div>
				</div>
				{/if}
			{/if}

		{if $page_search eq "true"}
			{if count($page_results) gt 0}
			<div class="row page-search">
				<div class="col-md-3">
					<h3>{$PLG_PAGES}</h3>
				</div>
				<div class="col-md-9">
	    		{section name=cnt loop=$page_results}
						<a href="{$page_results[cnt].link}">{$page_results[cnt].header}</a>
	    		{/section}
				</div>
			</div>
	    {/if}
	   {/if}

			{section name=cnt_e loop=$results}
				{assign var="result_res" value=$results[cnt_e].text}

				{if count($result_res) gt 0}
				<div class="row res-search">
					<div class="col-md-3">
						<h3>Aktuelnosti</h3>
					</div>
					<div class="col-md-9">
					{section name=cnt loop=$result_res}
					<a href="{$result_res[cnt].link}">{$result_res[cnt].header}</a>
					{/section}
					</div>
				</div>
				{/if}
			{/section}

		</div>
	</div>
	</div>
</div>
{/if}
