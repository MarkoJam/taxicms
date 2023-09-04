
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
				<fieldset class="form-horizontal">
					<div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
						<div class="col-sm-10"><input type="text" name="name" value="{$name}" class="form-control" "></div>
					</div>			
					<div class="form-group"><label class="col-sm-2 control-label">{$PLG_LANGUAGE}</label>
						<div class="col-sm-10"><input type="text" name="language" value="{$language}" class="form-control" "></div>
					</div>
					<div class="form-group"><label class="col-sm-2 control-label">DB POSTFIX(_)</label>
						<div class="col-sm-10"><input type="text" name="dbpostfix" value="{$dbpostfix}" class="form-control" "></div>
					</div>					
					<div class="form-group"><label class="col-sm-2 control-label">FILE POSTFIX</label>
						<div class="col-sm-10"><input type="text" name="filepostfix" value="{$filepostfix}" class="form-control" "></div>
					</div>						
					<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATE}</label>
						<div class="col-sm-10"><input type="text" name="country" value="{$country}" class="form-control" "></div>
					</div>		
					<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
						<div class="col-sm-10">
							<select id="statusid" name="statusid" class="form-control">
								{html_options values=$status_val selected=$status_sel output=$status_out}
							</select>
						</div>
					</div>	
					<div class="form-group"><label class="col-sm-2 control-label">{$PLG_IMAGE}</label>
						<div class="col-sm-6">
						   <input id="picture" name="picture" type="text" value="{$picture}" size="50" class="form-control">
						</div>
						<div class="col-sm-2">
						  <a class="btn btn-success" href="javascript:BrowseServer(this);"><i class="fa fa-plus-square-o" ></i> {$PLG_ADD}</a>
						</div>
						<div class="col-sm-2">
						  <img src="{$ROOT_WEB}{$slika}" height="100" />
						</div>
					</div>						
					<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
						<div class="col-sm-10"><textarea id="description" name="description" class="form-control">{$description}</textarea></div>
					</div>							
				</fieldset>	
			</div>	
		</div>
		<input name="subsiteid" type="hidden" id="" value="{$subsiteid}">
		<input name="isdefault" type="hidden" id="" value="{$isdefault}">	
		
	</form>
</div>


