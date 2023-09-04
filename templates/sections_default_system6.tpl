<script>
{literal}
$( document ).ready(function() {
$('.video-wrap').each(function(event){

//  const fileUrl = {/literal}{$proizvod_detail.slika}{literal};
  const imgExtensions = ['jpg', 'png'];
  const videoExtensions = ['mkv', 'mp4', 'webm'];
  const name = '{/literal}{$data.sections_all[0].slika}{literal}';
  const lastDot = name.lastIndexOf('.');

  const ext = name.substring(lastDot + 1);
	console.log(ext);

  if (imgExtensions.includes(ext)) {
    $(".video-container").hide(); // hide video preview
    $(".image-container").show();
  } else if (videoExtensions.includes(ext)) {
    $(".image-container").hide(); // hide image preview
    $(".video-container").show();
  }
});
});
{/literal}
</script>
<section class="system-area3">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>{$PLG_SECTION_HIGH}</h2>
      </div>
    </div>
  </div>
  {if $data.sections_all[0].slika neq ''}
  <div class="video-container">
  	<video controls class="w-100">
    	<source src="{$ROOT_WEB}{$data.sections_all[0].slika}" type="video/mp4" />
  	</video>
	</div>
  <div class="system-area3-video image-container">
    <img src="{$ROOT_WEB}{$data.sections_all[0].slika}" />
  </div>
  {else}
  <div class="system-area3-video">
    {$data.sections_all[0].shorthtml}</h3>
  </div>
  {/if}
</section>
