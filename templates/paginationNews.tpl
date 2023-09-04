{if $count gt 0}
<div class="pagination pagination-news">
	{* <div class="col-md-6">
		<span class="show">
		display pagination header
		{$GLOBAL_SHOW_TEXT} {$fres}-{$lres} {$GLOBAL_TOTAL_TEXT} {$count}
		</span>
	</div>
	*}

	{* display results *}
	{if $first}<button class='pager' data-offset='{$first_offset}' type='button'><<</button>{/if}
	{if $previous}<button class='pager' data-offset='{$previous_offset}' type='button'><</button>{/if}
	{section name=pom1 loop=$pages_arr}
		|<button class='pager' data-offset='{$pages_arr[pom1].offset}' type='button' {if $current_page eq $pages_arr[pom1].page}disabled{/if}>
			{$pages_arr[pom1].page}
		</button>
	{/section}
	{if $next}|<button class='pager' data-offset='{$next_offset}' type='button'>></button>{/if}
	{if $last}|<button class='pager' data-offset='{$last_offset}' type='button'>>></button>{/if}
	</span>
	</div>
{else}

{/if}
<script>
{literal}
$(document).ready(function() {
$(".pager").on('click', function(e) {
    $('html, body').animate({
        scrollTop: $(".pag-top").offset().top
    }, 500);
});
});
{/literal}
</script>
