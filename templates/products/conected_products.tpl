{if count($details.conectedproducts)>0 }
<div class="row conected-products-box">
    <div class="col-lg-12 col-md-12 col-12 conected">
      <div class="product-group-title mt-1">
       <h2>{$PLG_PRODUCT_CONECTED_PRODUCTS}</h2>
     </div>
   </div>
 </div>
<div class="row connected-products">

 {* iscrtavanje dela za proizvode izabrane grupe *}

 {section loop=$details.conectedproducts name=cnt}
  {if $smarty.section.cnt.index < 8}
  <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4  mb-6">
    <div class="itemheight product-group-box">
      <div class="slika" {if $details.conectedproducts[cnt].proizvod_detail.slikaover neq ''}style="background-image: url('{$details.conectedproducts[cnt].proizvod_detail.slikaover}');"{else}style="background-image: url('{$details.conectedproducts[cnt].proizvod_detail.slika}');"{/if}>
      <a class="product-item-thumb" href="{$details.conectedproducts[cnt].proizvod_detail.link}">
        <img src="{$ROOT_WEB}{$details.conectedproducts[cnt].proizvod_detail.slika}" alt="{$details.conectedproducts[cnt].proizvod_detail.naziv}">
      </a>
    </div>
      <div class="product-item-info text-center">
        <h5 class="product-item-title mt-6 mb-0"><a href="{$details.conectedproducts[cnt].proizvod_detail.link}">{$details.conectedproducts[cnt].proizvod_detail.naziv}</a></h5>
        {if $details.conectedproducts[cnt].proizvod_detail.cenaa neq 0}
          {if $details.conectedproducts[cnt].proizvod_detail.cenab eq 0}
          <div class="product-item-price">€ {$details.conectedproducts[cnt].proizvod_detail.cenaaformatirano}</div>
          {else}
          <span class="price-old">€ {$details.conectedproducts[cnt].proizvod_detail.cenaaformatirano}</span>
          <div class="product-item-price">€ {$details.conectedproducts[cnt].proizvod_detail.cenabformatirano}</div>
          {/if}
        {else}

        {/if}
      </div>
    </div>
  </div>
{/if}
 {/section}
</div>
{/if}
