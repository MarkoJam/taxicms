{if $data.news_all[0].header neq ''}
<div class="soc inews"><div class="float-contact">
<div class="news-notify">
	<h2><a href="{$data.news_all[0].link_print_dt}">{$data.news_all[0].header}</a></h2>
					<img src="{$ROOT_WEB}{$data.news_all[0].slika}" />
				{$data.news_all[0].shorthtml}
</div>
</div>
	<img src="{$ROOT_WEB}images/icon-news.svg" width="22" height="22" />
</div>
{/if}
