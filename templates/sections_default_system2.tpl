<section class="system-area2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>{$PLG_SECTION_BENEFITS2}</h2>
      </div>
    </div>
    <div class="row">
		{section name=pom loop=$data.sections_all}
			<div class="col-md-4">
			  <div class="system-content text-center">
          <img src="{$ROOT_WEB}{$data.sections_all[pom].slika}" height="140"/>
			     <h3>{$data.sections_all[pom].header}</h3>
			   </div>
			</div>
		{/section}
    </div>
  </div>
</section>
