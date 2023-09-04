<script>
{literal}
	function modify_plugin() {}
{/literal}
</script>

<div id="welcome">
{if $norights_message neq ""}
	<h1>{$norights_message}</h1>
{else}
	<h1>You do not have enough access privileges. Please contact Your administrator.</h1>
{/if}
</div>	
<div class="title-action">
		<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;{$COMMON_CLOSE}</div>
</div>

