<script type="text/javascript" src="CKeditor/ckeditor/ckeditor.js"></script>
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
									<input name="header" type="text" value="{$header}" size="50" class="title form-control" placeholder="{$PLG_NAME}">
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_CONTENT}</label>
                                <div class="col-sm-10">
									 <textarea id="rtel" name="rtel">{$html}</textarea>
									<script type="text/javascript">
									{literal}
										CKEDITOR.replace( 'rtel',
											 { height:'350',
											   width:'550'
											  });
									{/literal}
									</script>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
		</div>

	<input name="universalpluginid" type="hidden" id="universalpluginid" value="{$universalpluginid}">

	</form>
</div>
