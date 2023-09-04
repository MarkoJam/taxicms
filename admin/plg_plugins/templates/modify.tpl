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
		<div class="row">
                <div class="col-lg-12">
					 <div class="panel-body">
						<fieldset class="form-horizontal">
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
                                <div class="col-sm-10">
									<input name="title" type="text" value="{$title}" class="title form-control" />
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_FILENAME}</label>
                                <div class="col-sm-10">
									<input name="filename" type="text" value="{$filename}" class="title form-control" />
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_CLASSNAME}</label>
                                <div class="col-sm-10">
									<input name="classname" type="text" value="{$classname}" class="title form-control" />
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_MODULE}</label>
                                <div class="col-sm-10">
									<select name="pluginmoduleid" class="form-control">
										{html_options values=$pluginmodule_val selected=$pluginmodule_sel output=$pluginmodule_out}
									</select>
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_TEMPLATEBASE}</label>
                                <div class="col-sm-10">
									<select name="templatebase" id="templatebase" class="form-control">
										{html_options values=$templatebase_val selected=$templatebase_sel output=$templatebase_out}
									</select>
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS_ACTIVE}</label>
                                <div class="col-sm-10">
									<select name="active" id="active" class="form-control">
										{html_options values=$active_val selected=$active_sel output=$active_out}
									</select>
								</div>
							</div>

						</fieldset>
					</div>
				</div>
			</div>


   		<input name="pluginid" type="hidden" id="pluginid" value="{$pluginid}">

	</form>
</div>