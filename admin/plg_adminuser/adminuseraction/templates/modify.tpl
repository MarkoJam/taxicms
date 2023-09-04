<script>
{literal}
	function modify_plugin() {}
{/literal}
</script>
<div id="content">
	<form id='inner' name="editcategory" action="modify_final.php" method="post" enctype="multipart/form-data">
	<input name="mode" type="hidden" id="mode" value="{$mode}">		
		<div class="row wrapper  page-heading">
			<div class="col-lg-8">
				<h2 id="modi_title"></h2>
			</div>
			<div class="col-lg-4">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;{$PLG_SAVE}</div>
					<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;{$PLG_CLOSE}</div>
				</div>
			</div>
		</div>
		
		<table width="600"  border="0"  cellpadding="5" cellspacing="0" class="tablemodify">
				<tr>
					<td width="150">{$PLG_NAME}</td>
					<td width="450"><input name="title" type="text" value="{$title}" size="40" class="form-control"></td>
				</tr>  
				<tr>
					<td width="150">{$PLG_DESCRIPTION}</td>
					<td width="450"><input name="description" type="text" value="{$description}" size="40" class="form-control"></td>
				</tr>  
				<tr>
					<td width="150">{$PLG_CODE}</td>
					<td width="450"><input name="actioncode" type="text" value="{$actioncode}" size="40" class="form-control"></td>
				</tr>
				<tr>
					<td width="150">{$PLG_PLUGIN}</td>
					<td width="450">
					<select name="pluginid" id="pluginid" class="form-control">
							{html_options values=$plugins_val selected=$plugins_sel output=$plugins_out}
						</select>
					</td>
				</tr>
		<tr>
			<td colspan="2">&nbsp;</td>

   		<input name="adminuseractionid" type="hidden" id="adminuseractionid" value="{$adminuseractionid}">
</form>
</div>
