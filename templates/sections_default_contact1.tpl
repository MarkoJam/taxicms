<div class="contact-form1">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="cf-title">
      <h2>{$PLG_CONTACT_US}</h2>
    </div>
    </div>
  </div>
  <div class="row contact-info-header1">
		{section name=pom loop=$data.sections_all}
      <div class="col-md-12 contact-container" style="background:url({$ROOT_WEB}{$data.sections_all[pom].slika});background-position: 15px 10px;background-repeat: no-repeat;">
			  <div class="contact-info">
			     <h2>{$data.sections_all[pom].header}</h2>
			        {$data.sections_all[pom].shorthtml}
              {$data.sections_all[pom].html}
            <div class="phone"><i class="fa-solid fa-phone-flip"></i> {$data.sections_all[pom].sectionlink}</div>
			   </div>
			</div>
		{/section}
    </div>
  </div>
</div>
