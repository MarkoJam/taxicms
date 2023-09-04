<section class="system-area4" id="catalogue">
  <div class="container">
    <div class="row">
		{section name=pom loop=$data.sections_all}
			<div class="col-lg-6 catalogue">
        <div class="row">
          <div class="col-md-6 col-lg-12 col-xl-6 catalogue-item">
            <img src="{$ROOT_WEB}{$data.sections_all[pom].slika}"/>
          </div>
          <div class="col-md-6 col-lg-12 col-xl-6 catalogue-item">
			     <h3>{$data.sections_all[pom].header}</h3>
           <a class="carousel-button" href="{$data.sections_all[pom].sectionlink}" target="_blank"><i class="fa-solid fa-arrow-down"></i> {$PLG_SECTION_PDF}</a>
         </div>
			  </div>
			</div>
		{/section}
    </div>
  </div>
</div>
</section>
