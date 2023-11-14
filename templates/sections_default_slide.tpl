<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
	<div class="carousel-inner">
		{section name=pom loop=$data.sections_all}
			<video class="img-fluid w-100" style="margin-top:-5%; margin-bottom:-5%" autoplay loop muted>
				<source src="{$ROOT_WEB}{$data.sections_all[pom].video_rnd}" type="video/mp4" />
			</video>
			<div class="layout"></div>
			<div class="container carousel-wrap">
				<div class="row">
					<div class="col-md-6">
						<div class="carousel-caption d-flex justify-content-center flex-column">
							{$data.sections_all[pom].shorthtml}
							{$data.sections_all[pom].html}
							<a class="carousel-button" href="{$data.sections_all[pom].sectionlink}">Check Products</a>
						</div>
					</div>
				</div>
			</div>
		{/section}
	</div>
</div>
