<section class="system-area5">
  <div class="container">
    <div class="row">
		{section name=pom loop=$data.sections_all}
			<div class="col-md-12">
            {$data.sections_all[pom].shorthtml}
 			        {$data.sections_all[pom].html}
 						<a class="carousel-button" href="{$data.sections_all[pom].sectionlink}">{$PLG_VIEW_MORE}</a>
			</div>
		{/section}
    </div>
  </div>
</div>
</section>
