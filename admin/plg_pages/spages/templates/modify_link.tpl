<script>
{literal}
	function modify_plugin() {}
{/literal}
</script>

<div id="content">
	<form  id='inner' action="modify_final.php" method="post" enctype="multipart/form-data" >
		<input name="mode" type="hidden" id="mode" value="{$mode}">
		<div class="row wrapper  page-heading">
			<div class="col-lg-8">
				<h2 id="modi_title"></h2>
				<h2>{$PLG_LINKS}</h2>				
			</div>
			<div class="col-lg-4">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;{$PLG_SAVE}</div>
					<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;{$PLG_CLOSE}</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel-body">
					<fieldset class="form-horizontal">
						<div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
							<div class="col-sm-10">
								<input name="header" type="text" value="{$header}" size="50" class="title form-control" placeholder="{$PLG_NAME}">
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
							<div class="col-sm-10">
								<select name="status_id" class="form-control">
									{html_options values=$status_val selected=$status_sel output=$status_out}
								</select>
							</div>
					   </div>
					   <div class="form-group"><label class="col-sm-2 control-label">Link:</label>
							<div class="col-sm-8">
								<input name="rtel" type="text" value="{$html}" size="40" class="form-control" placeholder="{$PLG_NAME}">
							</div>
							<div class="col-sm-2">
								<select name="target" class="form-control">
									{html_options values=$target_values selected=$target_selected output=$target_output}
								</select>	
							</div>
						</div>
					</fieldset>
				</div>	
			</div>
		</div>


		<input name="spage_id" type="hidden" id="spage_id" value="{$spage_id}">
		<input name="template_id" type="hidden" id="template_id" value="{$template_id}">
		<input name="order" type="hidden" id="order" value="{$order}">
		<input name="typeid" type="hidden" id="typeid" value="{$typeid}">

	</form>
</div>
