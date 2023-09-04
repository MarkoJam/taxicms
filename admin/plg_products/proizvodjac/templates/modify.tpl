<script type="text/javascript" language="javascript1.2">
{literal}
	function modify_plugin() {
	}
{/literal}
</script>
<div id="content">	
	<form name="editcategory" id="inner" action="modify_final.php" method="post" enctype="multipart/form-data">
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
											<input name="naziv" type="text" value="{$naziv}" class="title form-control" placeholder="{$PLG_NAME}">
								</div>
                            </div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
                                <div class="col-sm-10">
											<textarea name="opis" rows="3" class="form-control">{$opis}</textarea>
								</div>
                            </div>
                      </fieldset>
				</div>
			</div>
		</div>
							
		<input name="proizvodjacid" type="hidden" id="proizvodjacid" value="{$proizvodjacid}">

	</form>
</div>