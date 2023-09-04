{if count($data.page_headers) gt 0}
{*<h2>{$data.page_header}</h2>*}
	<div class="sub-menu">
	<ul>
	{section name=cnt loop=$data.page_headers}
		<li {if $data.page_ids[cnt] eq $data.current_pageid} class="selected" {/if}><a href="{$data.links_arr[cnt]}">{$data.page_headers[cnt]}</a></li>
	{/section}
	</ul>
</div>
{/if}
