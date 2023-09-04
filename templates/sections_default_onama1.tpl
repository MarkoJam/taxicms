<section class="about-area">
  <div class="container">
		{section name=pom loop=$data.sections_all}
    <div class="row about-box">
      <div class="col-lg-7 p-5">
			  <div class="about-content ps-5">
			     <h2>{$data.sections_all[pom].header}</h2>
			        {$data.sections_all[pom].shorthtml}
			   </div>
			</div>
      <div class="col-lg-5 p-0 about-image" style="background:url({$ROOT_WEB}{$data.sections_all[pom].slika})  center center / cover ">
      </div>
		</div>
		{/section}
  </div>
</section>
