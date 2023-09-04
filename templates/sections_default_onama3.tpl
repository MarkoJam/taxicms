<section class="about-area3">
  <div class="container">
		{section name=pom loop=$data.sections_all}
    <div class="row about-box">
      <div class="col-lg-5 p-0 about-image" {if $smarty.section.pom.index is even}style="background:url({$ROOT_WEB}{$data.sections_all[pom].slika}) center center / cover" {else}style="order:2;background:url({$ROOT_WEB}{$data.sections_all[pom].slika}) center center / cover"{/if}>
      </div>
			<div class="col-lg-7 p-5">
			  <div class="about-content ps-5">
			     <h2>{$data.sections_all[pom].header}</h2>
			        {$data.sections_all[pom].shorthtml}
			   </div>
			</div>
		</div>
		{/section}
  </div>
</section>
