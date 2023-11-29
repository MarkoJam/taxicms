<div class="row">
	{section name=pom loop=$data.module_all}
		<div class="col-md-6 col-md-6-modules-edit">
			<a href="{$data.module_all[pom].link_print_dt}">
				<div class="news-group-box">
					<image src="{$ROOT_WEB}{$data.module_all[pom].slika}"></image>
					<div class="news-content">
						<h5>{$data.module_all[pom].header}</h5>
						{$data.module_all[pom].shorthtml}
						<div class="news-link"><i class="fa-solid fa-chevron-right"></i></div>
					</div>
				</div>	
			</a>
		</div>
	{/section}
</div>		
<div class="row">
	<div class="col-12">
		<nav class="pagination-area ms-md-auto mt-3 mt-md-0">
		{$data.pagination}
		</nav>
	</div>
</div>