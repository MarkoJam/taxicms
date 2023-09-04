{if isset($ajaxpages)}
<head>
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
<link rel="stylesheet" href="{$ROOT_WEB}css/main.css">

</head>
{/if}


<div class="path">
{if count($details.pathData) gt 1}
<ul>
		{foreach from=$details.pathData item=pathData name=parentData}

		{if $smarty.foreach.parentData.first}
			<li><a href="{$ROOT_WEB}{$lang}{$PLG_LINK_PRODUCTS}">{$pathData.title}</a></li>
		{else}
			<li><a href='{$pathData.link}'>{$pathData.title}</a></li>
		{/if}
		{/foreach}
	</ul>
		{/if}
</div>

{if $details.data.opis neq ""}
	<p>{$details.data.opis}</p>
{/if}

 {*<h1> {$details.data.naziv}</h1>*}
 {* iscrtavanje dela za podgrupe izabrane grupe *}
{*
 {section loop=$details.menuItem.items name=cnt}
	 <div id="katalog_podgrupe_body">
 		<h2>
 			<a href="{$details.menuItem.items[cnt].link}">{$details.menuItem.items[cnt].title} ({$details.menuItem.items[cnt].totalcount})</a>
 		</h2>
		{if $details.menuItem.items[cnt].image neq ""}
			<img  alt="" src="{$ROOT_WEB}{$details.menuItem.items[cnt].image}" />
 		{else}
 			<img  alt="" src="{$ROOT_WEB}files/Image/noimage.gif" />
		{/if}
		{section loop=$details.menuItem.items[cnt].items name=inner}
 		{counter print=no assign=brojac}
	 	<p>
	 		<a href="{$details.menuItem.items[cnt].items[inner].link}">{$details.menuItem.items[cnt].items[inner].title}</a>
	 		{if $brojac neq count($details.menuItem.items[cnt].items)} </br>{/if}
	 	</p>
	 	{/section}
	 	{counter print=no assign=brojac start=0}
	</div>
 {/section}
*}
<script type="text/javascript">
{literal}
	jQuery(function($){
		jQuery("#productsortby, #productsbypage").change(function(){
			jQuery("#productsortby").closest("form").submit();
			});
	});
{/literal}
</script>

 {* iscrtavanje dela za proizvode izabrane grupe *}
 {if count($details.paginationData) gt 0}

 <form action="{$smarty.server.REQUEST_URI}" method="POST">
<div class="product-group-title">
	<h2 >{$details.data.naziv}</h3>
</div>
{*
	 <div class="shop-top-bar">
	 	<select id="productsbypage" name="productsbypage" class="select-shoing">
			{html_options values=$productbypage_val selected=$productbypage_sel output=$productbypage_out}
		</select>
		<select id="productsortby" name="productsortby" class="select-shoing">
			{html_options values=$productsortby_val selected=$productsortby_sel output=$productsortby_out}
		</select>
	 </div>
*}
	<div class="row ">
 	{section loop=$details.paginationData name=cnt}
	<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4  mb-6">
		<div class="itemheight product-group-box">
			<div class="slika" {if $details.paginationData[cnt].slikaover neq ''}style="background-image: url('{$details.paginationData[cnt].slikaover}');"{else}style="background-image: url('{$details.paginationData[cnt].slika}');"{/if}>
			<a class="product-item-thumb" href="{$details.paginationData[cnt].link}">
      	<img src="{$ROOT_WEB}{$details.paginationData[cnt].slika}" alt="{$details.paginationData[cnt].naziv}">
      </a>
		</div>
			<div class="product-item-info text-center">
      	<h5 class="product-item-title mt-6 mb-0"><a href="{$details.paginationData[cnt].link}">{$details.paginationData[cnt].naziv}</a></h5>
				{if $details.paginationData[cnt].cenaa neq 0}
					{if $details.paginationData[cnt].cenab eq 0}
					<div class="product-item-price">€ {$details.paginationData[cnt].cenaaformatirano}</div>
					{else}
					<span class="price-old">€ {$details.paginationData[cnt].cenaaformatirano}</span>
					<div class="product-item-price">€ {$details.paginationData[cnt].cenabformatirano}</div>
					{/if}
				{else}

				{/if}
      </div>
    </div>
	</div>
 {/section}

 <div class="col-12">
	 <div class="shop-top-bar">
		{if $paginate.total gt '24'}
		<nav class="pagination-area ms-md-auto mt-3 mt-md-0">
    	{$data.pagination}
		</nav>
		{/if}
 </div>
</div>
</div>

</form>
{/if}
</div>
