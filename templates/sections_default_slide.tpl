<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">

  <div class="carousel-inner">
		{section name=pom loop=$data.sections_all}
    <div class="carousel-item active">
      <video class="img-fluid w-100" autoplay loop muted>
        <source src="{$ROOT_WEB}{$data.sections_all[pom].slika}" type="video/mp4" />
      </video>

			<div class="layout"></div>
			<div class="container carousel-wrap">
				<div class="row">
					<div class="col-md-6">
			      <div class="carousel-caption d-flex justify-content-center flex-column">
			        {$data.sections_all[pom].shorthtml}
			        {$data.sections_all[pom].html}
							<a class="carousel-button" href="{$data.sections_all[pom].sectionlink}">{$PLG_CHECK_PRODUCTS}</a>
			      </div>
					</div>
				</div>
			</div>

    </div>
		{/section}
  </div>

</div>
