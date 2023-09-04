<script type="text/javascript" src="CKeditor/ckeditor/ckeditor.js"></script>
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
				<h2>{$PLG_PAGES}</h2>
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
                 <div class="tabs-container">
                      <ul class="nav nav-tabs">
                           <li class="active"><a data-toggle="tab" href="#tab-1"> {$PLG_INFO}</a></li>
                           <li class=""><a data-toggle="tab" href="#tab-2"> {$PLG_CONTENT}</a></li>
                      </ul>
					<div class="tab-content">
                         <div id="tab-1" class="tab-pane active">
                             <div class="panel-body">
                                <fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
                                         <div class="col-sm-10"><input type="text" name="header" value="{$header}" class="form-control" placeholder="{$PLG_NAME}"></div>
                                    </div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_TEMPLATE}</label>
                                          <div class="col-sm-10">
												<select name="template_id" class="form-control" >
													{html_options values=$tmpl_values selected=$tmpl_selected output=$tmpl_output}
												</select>
											</div>
                                    </div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS} </label>
                                        <div class="col-sm-10">
											<select name="status_id" class="form-control" >
												  {html_options values=$status_val selected=$status_sel output=$status_out}
											</select>
										</div>
                                    </div>
								</fieldset>
                             </div>
                        </div>
						<div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                               <fieldset class="form-horizontal">
								<div class="form-group">
									<div class="col-sm-12">
									<textarea id="rtel" name="rtel">{$html}</textarea>
									<script type="text/javascript">
										{literal}
											CKEDITOR.replace( 'rtel',
												 { height:'550',
												   width:'700'
												  });
										{/literal}
									</script>
								</div>
							</div>
						</fieldset>
                     </div>
                  </div>
				</div>
			</div>
		</div>

	<input name="spage_id" type="hidden" id="spage_id" value="{$spage_id}">
    <input name="order" type="hidden" id="order" value="{$order}">
    <input name="typeid" type="hidden" id="typeid" value="{$typeid}">

</form>
</div>
