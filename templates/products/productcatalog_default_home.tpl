<!-- productcatalog_default START-->
<section class="product-categories-area">
  <div class="container">
    <div class="row">
        {section loop=$data.menuItem.items name=cnt}
        <div class="col-md-6 itemheight mb-5">
          <a href="{$data.menuItem.items[cnt].link}" class="product-category-item">
            <div class="product-category-thumb">
            {*<img src="{$ROOT_WEB}{$data.menuItem.items[cnt].image}" alt="{$data.menuItem.items[cnt].title}">*}
            <h5 class="product-category-title">{$data.menuItem.items[cnt].title}</h5>
            </div>
          </a>
        </div>
        {/section}
      </div>
      <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
          <a class="carousel-button" href="{$ROOT_WEB}{$lang}{$PLG_LINK_PRODUCTS}">{$PLG_PRODUCT_ORDER}</a>
        </div>
      </div>
  </div>
</section>
<!--  productcatalog_default END -->
