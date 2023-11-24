{if count($data.page_headers) gt 0}

<div class="row" style="background-color: #7a7a7a17;text-shadow: 1px 1px black;">
	{section name=cnt loop=$data.page_headers}
		<div class="col-md-12">
			<a {if $data.page_ids[cnt] eq $data.current_pageid} style="font-weight: bold;" {/if} href="{$data.links_arr[cnt]}">{$data.page_headers[cnt]}</a>
		</div>	
	{/section}
</div>
{/if}
