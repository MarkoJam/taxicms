{* DETAILS VIEW *}
{if $plugin_view eq "module_details"}
	<section class="news-details-area">
		<div class="container">
			<div class="row">
				<div class="path path-news">
					<ul>
						<li><a href="{$ROOT_WEB}{$lang}/{$PLG_LINK_MODULE}">{$PLG_MODULES}</a></li>
						<li>{$module_detail.header}</li>
					</ul>
				</div>
			</div>
			{*<div class="row">
				<div class="col-md-12">
					<div class="gp-title">
						<h2>{$module_detail.header}</h2>
					</div>
				</div>
			</div>*}
			<div class="row">
				<div class="col-md-6">
					<img src="{$ROOT_WEB}{$module_detail.slika}" class="mb-10 w-100" />
					{$module_detail.html}
				</div>	
				<div class="col-md-6">
					<p>{$PLG_MENU_OPTIONS}</p>
					{section name=pom loop=$module_detail.options}
						<div class="row">
							<div class="col-md-6">
								<div class="box-text"><a href='{$module_detail.options[pom].link_print_dt}'>{$module_detail.options[pom].header}</a>
									<a target="_blank" class="bg-info rounded-circle" href="{$ROOT_DEMO}{$module_detail.options[pom].link}"><i>demo</i></a>
									<a target="_blank" href="{$ROOT_HELP}{$module_detail.options[pom].link}"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
								</div>	
							</div>
							<div class="col-md-6">
								<small><i>{$module_detail.options[pom].shorthtml}</i></small>
							</div>							
						</div>
					{/section}
				</div>
			</div>			
			{if $module_detail.img_rows neq ""}
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
			{$module_detail.vid_rows}
			{$module_detail.doc_rows}
			{$module_detail.web_rows}
		</div>	
    </section>
{/if}
