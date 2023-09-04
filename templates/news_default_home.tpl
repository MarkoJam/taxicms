<section class="news-area">
	<div class="container">
		<div class="row">
		{section name=pom loop=$data.news_all}
		<div class="row">
				<div class="col-md-4">
					<div class="news-image">
						<img src="{$ROOT_WEB}{$data.news_all[pom].slika}" />
					</div>
				</div>	
				<div class="col-md-8">
					<a href="{$data.news_all[pom].link_print_dt}">{$data.news_all[pom].header}</a>
					{$data.news_all[pom].shorthtml}
				</div>
		</div>
		{/section}
		</div>
		<div class="row">
			<div class="col-md-12 text-center pt-5">
				<a class="news-button" href="{$ROOT_WEB}{$lang}{$PLG_LINK_NEWS}" >
					{$PLG_SEE_ALL}
				</a>
			</div>
		</div>
	</div>
</section>
