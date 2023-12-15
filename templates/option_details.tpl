{* DETAILS VIEW *}
{if $plugin_view eq "option_details"}
	<section class="news-details-area">
		<div class="container">
			<div class="row">
				<div class="path path-news">
					<ul>
						<li><a href="{$ROOT_WEB}{$lang}/{$PLG_LINK_OPTIONS}">{$PLG_OPTIONS}</a></li>
						<li>{$option_detail.header}</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="gp-title">
						<h2>{$option_detail.header}</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-12">
					{$option_detail.html}
				</div>
			</div>			

			{if $option_detail.img_rows neq ""}
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="g-title">
							<h2>{$PLG_VIEW}</h2>
						</div>
						<div id="gallery" class="row content-gallery">
							{section name=cnt loop=$images }
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 galerija-wrap">
									<div class="galerija">
										<a class="example-image-link" href="{$ROOT_WEB}{$images[cnt]}" data-lightbox="example-1">
											<div class="image-wrap">
												<img class="example-image" alt="" src="{$ROOT_WEB}{$images_thumb[cnt]}">
											</div>
										</a>
									</div>
								</div>
							{/section}
						</div>
					</div>
				</div>
			{/if}
			{$option_detail.vid_rows}
			{$option_detail.doc_rows}
			{$option_detail.web_rows}
		</div>	
    </section>
	{$option_detail.help}
	{$option_detail.fd}
{/if}
