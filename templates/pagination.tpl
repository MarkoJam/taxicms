<div class="pagination">
	{*
	<div class="pag-left">
		Pronadjeno <strong>{$count}</strong> <span class="resors"></span> - strana {$current_page} od {$pages_no}
	</div>
	*}
		{if $first}<a class='pager' href="{$smarty.request.basicurl}/1"> << </a>|{/if}
		{if $previous}<a class='pager' href="{$smarty.request.basicurl}/{$previous_offset}"> < </a>{/if}
		{section name=pom1 loop=$pages_arr}
		|<a class='pager' href="{$smarty.request.basicurl}/{$pages_arr[pom1].page}">
				{if $current_page eq $pages_arr[pom1].page}<strong>{/if}{$pages_arr[pom1].page}{if $current_page eq $pages_arr[pom1].page}</strong>{/if}
			</a>
		{/section}
		{if $next}|<a class='pager' href="{$smarty.request.basicurl}/{$next_offset}"> > </a>{/if}
		{if $last}|<a class='pager' href="{$smarty.request.basicurl}/{$last_offset}"> >> </a>{/if}
</div>
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
