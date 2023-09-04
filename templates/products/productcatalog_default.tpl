<!-- productcatalog_default START-->
<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
  <div class="category-box">
    <div class="accordion" id="accordionPanelsStayOpenExample">
  <div>
    <h2 id="panelsStayOpen-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
        {$PLG_PRODUCT_CATALOG}
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse dont-collapse-sm" aria-labelledby="panelsStayOpen-headingOne">

          <ul>
          {section loop=$data.menuItem.items name=cnt}
          {if $data.menuItem.items[cnt].id ne $data.specGroup}
          <li class="main_nav">
            <a href="{$data.menuItem.items[cnt].link}">
              {$data.menuItem.items[cnt].title}
            </a>
             {if count($data.menuItem.items[cnt].items) gt 0}
             <ul>
            {/if}
            {section loop=$data.menuItem.items[cnt].items name=inner}
            <li class="sub_nav">
               <a href="{$data.menuItem.items[cnt].items[inner].link}">{$data.menuItem.items[cnt].items[inner].title}</a>
            </li>
            {/section}
            {if count($data.menuItem.items[cnt].items) gt 0}
            </ul>
           {/if}
            </li>
          {/if}
          {/section}
          <ul>

    </div>
  </div>
</div>

    </div>
    {include file="products/filters.tpl"}
</div>

{if $data.grupaProizvodaID eq 0}
<div class="col-sm-12 col-md-8 col-lg-9 col-xl-9 product-group">
	{if count($data.paginationData) gt 0}

		<form action="{$smarty.server.REQUEST_URI}" method="POST">
      <div class="product-group-title">
	       <h2 >{$PLG_PRODUCT_ALL}</h3>
         </div>
			<div class="row ">
				{section loop=$data.paginationData name=cnt}
					<div class="col-sm-12 col-md-6 col-lg-4 col-xl-4  mb-6">
						<div class="itemheight product-group-box">

							<div class="slika" {if $data.paginationData[cnt].slikaover neq ''}style="background-image: url('{$data.paginationData[cnt].slikaover}');"{else} style="background-image: url('{$data.paginationData[cnt].slika}');"{/if}>
								<a class="product-item-thumb" href="{$data.paginationData[cnt].link}">
									<img src="{$ROOT_WEB}{$data.paginationData[cnt].slika}" alt="{$data.paginationData[cnt].naziv}">
								</a>
							</div>
							<div class="product-item-info text-center ">
								<h5 class="product-item-title mt-6 mb-0" ><a href="{$data.paginationData[cnt].link}">{$data.paginationData[cnt].naziv}</a></h5>
								{$data.paginationData[cnt].grupa} 
								{$data.paginationData[cnt].kratakopis}
								{if $data.paginationData[cnt].cenaa neq 0}
									{if $data.paginationData[cnt].cenab eq 0}
										<div class="product-item-price mb-0">€ {$data.paginationData[cnt].cenaaformatirano}</div>
									{else}
										<span class="price-old">€ {$data.paginationData[cnt].cenaaformatirano}</span>
										<div class="product-item-price mb-0">€ {$data.paginationData[cnt].cenabformatirano}</div>
									{/if}
								{/if}
							</div>
						</div>
					</div>
				{/section}

				<div class="col-12">
					<div class="shop-top-bar">

						<nav class="pagination-area ms-md-auto mt-3 mt-md-0">
							{$data.pagination}
						</nav>
					</div>
				</div>
			</div>

		</form>
	{/if}
</div>
{/if}
