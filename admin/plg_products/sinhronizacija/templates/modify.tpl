<script>
	
{literal}
	function modify_plugin() {
		$(document).ready(function() {
			$('#promeni').trigger('click');
		})			
	}	

{/literal}
</script>
<div id="content">
	<form id='inner' name="editproizvod" action="modify_final.php" method="post">
		<input name="executed" type="hidden" id="executed" value="{$executed}" />
		<div class="row wrapper  page-heading">
			<div class="col-lg-4">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i> {$PLG_SAVE}</div>	
					<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;{$PLG_CLOSE}</div>
				</div>
			</div>
		</div>	
	</form>
</div>
