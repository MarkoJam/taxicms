<section class="terms-area">
  <div class="container">
    <div class="row">
		{section name=pom loop=$data.sections_all}
			<div class="col-md-3">
        <a href="{$data.sections_all[pom].slika}" target="_blank">
			  <div class="system-content text-center">
          <img src="{$ROOT_WEB}images/download.png" />
			     <h5>{$data.sections_all[pom].header}</h5>
			   </div>
         </a>
			</div>
		{/section}
    </div>
  </div>
</section>
