{* DETAILS VIEW *}
{if $plugin_view eq "news_details"}
<section class="news-details-area">
<div class="container">
  <div class="row position-relative">
		<div class="path path-news">
					<ul>
						<li><a href="{$ROOT_WEB}{$lang}{$PLG_LINK_NEWS}">{$PLG_NEWS}</a></li>
						<li>{$news_detail.header}</li>
					</ul>
		</div>
	</div>
		<div class="row">
		<div class="col-md-12">
			<div class="gp-title">
				<h2>{$news_detail.header}</h2>
			</div>
		</div>
	</div>
	<div class="row">
			<div class="col-lg-12 col-md-12 col-12 content-gallery">
				<p class="date">{$news_detail.date}</p>
				<img src="{$ROOT_WEB}{$news_detail.slika}" class="mb-10 w-100" />
							{$news_detail.html}
			</div>
		</div>
							{if $news_detail.img_rows neq ""}
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

							{if $news_detail.vid_rows neq "<div class='res_vid'></div>"}
							<div class="col-md-12">
								{$news_detail.vid_rows}
							</div>
							{/if}

							{$news_detail.doc_rows}

							{$news_detail.web_rows}
              {*
							{if !empty($connews)}
							<div class="connected-news">
								<h2>{$PLG_CONNEWS}</h2>
								{section name=pom loop=$connews}
									<div class="box-item">
										{if $connews[pom].slika neq ""}<div class="box-img"><a href='{$connews[pom].link_print_dt}'><img src="{$ROOT_WEB}{$connews[pom].slika}" alt="{$connews[pom].header}" /></a></div>{/if}
										<div class="box-text"><a href='{$connews[pom].link_print_dt}'>{$connews[pom].header}</a></div>
									</div>
								{/section}
							</div>
							{/if}
              *}

				</div>
			</div>
		</div>
	</div>
</section>
{/if}
