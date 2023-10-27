{if count($data.page_headers) gt 0}
<br><br>

<div class="row sm">
	<ul>
	{section name=cnt loop=$data.page_headers}
		<li {if $data.page_ids[cnt] eq $data.current_pageid} class="selected" {/if}><a href="{$data.links_arr[cnt]}">{$data.page_headers[cnt]}</a></li>
	{/section}
	</ul>
</div>
{/if}
