<script type="text/javascript" src="CKeditor/ckeditor/ckeditor.js"></script>
<script>
{literal}
	function modify_plugin() {
	//	audio_recording();

	prepare_rows('img');
	insert_row('img','1','');
	prepare_rows('vid');
	insert_row('vid');
	prepare_rows('web');
	insert_row('web');
	prepare_rows('doc');
	insert_row('doc','2','File');

	}
{/literal}
</script>


<div id="content" >
	<form  id='inner' action="modify_final.php" method="post" enctype="multipart/form-data" >
		<input name="mode" type="hidden" id="mode" value="{$mode}">
		<div class="row wrapper  page-heading">
			<div class="col-lg-4">
				<h2 id="modi_title"></h2>
			</div>
			<div class="col-lg-8">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;{$PLG_SAVE}</div>
					<div name="pretvori_u_kategoriju" id="promeni" class="btn btn-info"><i class="fa fa-paste"></i>&nbsp;{$PLG_TRANSFORM}{$PLG_CATEGORY}</div>
					<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;{$PLG_CLOSE}</div>
				</div>
			</div>
		</div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="{if $active ne 3}active{/if}"><a class="active" data-toggle="tab" href="#tab-1"> {$PLG_INFO}</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2"> {$PLG_SEO}</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-3"> {$PLG_CONTENT}</a></li>
																<li class=""><a data-toggle="tab" href="#tab-4"> {$PLG_EXT_RES}</a></li>
                            </ul>
							 <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											{*<div class="form-group" id="title"><label class="col-sm-2 control-label">{$PLG_AUDIO} / {$PLG_NAME}</label>
													<div class="col-sm-6">
														<audio width="500"  controls controlsList="nodownload">
															<source src="{$audio_title}" type="audio/webm">
														</audio>
													</div>
													<div class="col-sm-2">
														<div id="start-recording-title" class="btn btn-primary ">{$PLG_START}</div>
														<div id="stop-recording-title" class="btn btn-default ">{$PLG_STOP}</div>
													</div>
													<div class="col-sm-2 checkbox checkbox-primary">
														<input type="checkbox" class="write_title" name="write" value="write" /><label for="checkbox">{$PLG_AUDIO_VR}</label>
													</div>

											</div>	*}
                                            <div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
                                                <div class="col-sm-10"><input id='title' type="text" name="header" value="{$header}" class="form-control" placeholder="{$PLG_NAME}"></div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label">{$PLG_TEMPLATE}</label>
                                                <div class="col-sm-10">
												     <select name="template_id" class="form-control">
														{html_options values=$tmpl_values selected=$tmpl_selected output=$tmpl_output}
													 </select>
												</div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
                                                <div class="col-sm-10">
													<select name="statusid" class="form-control">
														{html_options values=$status_val selected=$status_sel output=$status_out}
													 </select>
												</div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label">{$PLG_ACCESS}</label>
                                                <div class="col-sm-10">
													<select name="protection_id" onchange="javascript:UpdateRole();" class="form-control">
														{html_options values=$pageprotection_val selected=$pageprotection_sel output=$pageprotection_out}
													</select>
												</div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label">{$PLG_USERROLE}</label>
                                                <div class="col-sm-10">
													<select name="userroleid" class="form-control">
														{html_options values=$userrole_val selected=$userrole_sel output=$userrole_out}
													</select>
												</div>
											</div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PARENT}</label>
                                                <div class="col-sm-10">
													{$parentPageCmb}
												</div>
											</div>
                                        </fieldset>

                                    </div>
                                </div>
								<div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_KEYWORDS}</label>
                                                <div class="col-sm-10"><input name="keywords" type="text" value="{$keywords}" class="form-control" placeholder="{$PLG_KEYWORDS}"></div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
                                                <div class="col-sm-10"><input name="description" type="text" value="{$description}" class="form-control" placeholder="{$PLG_DESCRIPTION}"></div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-2 control-label">{$PLG_FREQ}</label>
                                                <div class="col-sm-10">
													<select name="frequency" class="form-control">
														{html_options values=$freq_val selected=$freq_sel output=$freq_out}
													</select>
												</div>
											</div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PRIORITY}</label>
                                                <div class="col-sm-10">
													<select name="priority" class="form-control">
														{html_options values=$prior_val selected=$prior_sel output=$prior_out}
													</select>
												</div>
											</div>
										</fieldset>
                                    </div>
                                </div>
								<div id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											{*<div class="form-group" id="audio_content"><label class="col-sm-2 control-label">{$PLG_AUDIO}</label>
													<div class="col-sm-6">
														<audio width="400" controls controlsList="nodownload">
															<source src="{$audio_content}" type="audio/webm">
														</audio>
													</div>
													<div class="col-sm-2">
														<div id="start-recording-content" class="btn btn-primary ">{$PLG_START}</div>
														<div id="stop-recording-content" class="btn btn-default ">{$PLG_STOP}</div>
													</div>
													<div class="col-sm-2 checkbox checkbox-primary">
														<input type="checkbox" class="write_content" name="write" value="write" /><label for="checkbox">{$PLG_AUDIO_VR}</label>
													</div>
											</div>*}

											<div class="form-group"><label class="col-sm-2 control-label">Sadržaj stranice</label>
												<div class="col-sm-10">
														<textarea id="rtel" name="rtel">{$html}</textarea>
														<script type="text/javascript">
														{literal}
															CKEDITOR.replace( 'rtel',
																 { height:'200',
																	 width:'650',
																	 disallowedContent : 'img{width,height}'
																	});
														{/literal}
														</script>
												</div>
											</div>
											<div class="form-group"><label class="col-sm-2 control-label">Sadržaj ispod naslova</label>
												<div class="col-sm-10">
													<textarea id="rtelsmall" name="rtelsmall">{$shorthtml}</textarea>
													<script type="text/javascript">
													{literal}
														CKEDITOR.replace( 'rtelsmall',
															 { height:'200',
															   width:'650',
																 disallowedContent : 'img{width,height}'
															  });
													{/literal}
													</script>
												</div>
											</div>
										</fieldset>
                  </div>
                </div>
								<div id="tab-4" class="tab-pane">
									<div class="panel-body">
										<fieldset class="form-horizontal">
											{$img_rows}
											<div class="hr-line-dashed"></div>
											{$vid_rows}
											<div class="hr-line-dashed"></div>
											{$web_rows}
											<div class="hr-line-dashed"></div>
											{$doc_rows}
										</fieldset>
									</div>
								</div>
							</div>
						</div>
					</div>
						<input name="page_id" type="hidden" id="page_id" value="{$page_id}">
						<input name="parent_id_old" type="hidden" id="parent_id" value="{$parent_id}">
						<input name="navigationtype" type="hidden" id="navigationtype" value="{$navigationtype}">
						<input name="createdby" type="hidden" id="createdby" value="{$createdby}">
						<input name="createddate" type="hidden" id="createddate" value="{$createddate}">
						<input name="modifyby" type="hidden" id="modifyby" value="{$modifyby}">
						<input name="modifydate" type="hidden" id="modifydate" value="{$modifydate}">

						<input name="header_old" type="hidden" id="header" value="{$header}">
						<input name="order" type="hidden" id="order" value="{$order}">
						<input name="pagetypeid" type="hidden" id="pagetypeid" value="{$pagetypeid}">
					</form>
				</div>
