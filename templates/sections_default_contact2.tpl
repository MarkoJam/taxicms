<div class="contact-form2">
<div class="container pb-10">
  <div class="row contact-info-header">
		{section name=pom loop=$data.sections_all}
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3  itemheight mt-10 pe-0" style="background:url({$ROOT_WEB}{$data.sections_all[pom].slika});background-position: 30px 20px;background-repeat: no-repeat;">
			  <div class="contact-info-other mt-3">
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
  <div class="map mt-10">
    <img src="{$ROOT_WEB}files/Image/contact/_mapa.svg" />
  </div>
