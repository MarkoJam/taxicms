<div id="slides-wraper">
	<div id="slides-container">
		 <div id="full-width-slider" class="royalSlider heroSlider rsMinW">
			 {section name=pom loop=$data.sections_all}
			 <a href="{$data.sections_all[pom].sectionlink}"><img alt="" src="{$ROOT_WEB}{$data.sections_all[pom].slika}" /></a>
			 {/section}
		 </div>
	 </div>
</div>
