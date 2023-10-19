<script type="text/javascript" src="CKeditor/ckeditor/ckeditor.js"></script>
<script>
{literal}
	function modify_plugin() {
		BrowseImageData();
		if (window.title) $('#inner #modi_title').text(window.title);
		prepare_rows('img');
		insert_row('img','1','');
		prepare_rows('vid');
		insert_row('vid');
		prepare_rows('web');
		insert_row('web');
		prepare_rows('doc');
		insert_row('doc','2','documents');

		$('.chosen-select').chosen({width: "100%"});


	}
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
				<div class="tabs-container">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-1"> {$PLG_INFO}</a></li>
						<li class=""><a data-toggle="tab" href="#tab-2"> {$PLG_CONTENT}</a></li>
						<li class=""><a data-toggle="tab" href="#tab-3"> {$PLG_EXT_RES}</a></li>
					</ul>
					<div class="tab-content">

                        <div id="tab-1" class="tab-pane  active">
                            <div class="panel-body">
                                <fieldset class="form-horizontal">
                                    <div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
                                        <div class="col-sm-10"><input type="text" id='title' name="header" value="{$header}" class="form-control" placeholder="{$PLG_NAME}"></div>
                                    </div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
										<div class="col-sm-10">
											<select name="statusid" class="form-control">
												{html_options values=$status_val selected=$status_sel output=$status_out}
											</select>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_CATEGORY}</label>
										<div class="col-sm-10">
											<div>
											<select size="5" multiple="multiple" name="sectionscategories[]" class="chosen-select">
												{html_options values=$sectionscategory_val selected=$sectionscategory_sel output=$sectionscategory_out}
											</select>
											</div>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_IMAGE}</label>
										<div class="col-sm-6">
										   <input id="slika" name="slika" type="text" value="{$slika}" class="form-control image">
										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServerSlika(this);"><i class="fa fa-plus-square-o" ></i> {$PLG_ADD}</a>
										</div>
										<div class="col-sm-2">
										 <a data-toggle="modal" data-target="#myModal7"><img class="imageover responsive image-title" src="{$slika}"  /><div class="overlay-icon"></div></a>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">Video</label>
										<div class="col-sm-6">
											<input id="video" name="video" type="text" value="{$video}"  class="form-control">
										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServerVideo(this);"><i class="fa fa-plus-square-o" ></i> {$PLG_ADD} video</a>
										</div>
										<div class="col-sm-2">
											<video class="responsive" autoplay muted loop>
									    	<source class="video" src="{$video}" type="video/mp4" />
									  	</video>
										</div>
									</div>
                                    <div class="form-group"><label class="col-sm-2 control-label">{$PLG_LINK}</label>
                                        <div class="col-sm-10"><input type="text" id='section_link' name="section_link" value="{$sectionlink}" class="form-control" placeholder="{$PLG_LINK}"></div>
                                    </div>
                                </fieldset>
                            </div>
						</div>
						<div id="tab-2" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_SHORTDESCRIPTION}</label>
										<div class="col-sm-10">
											<textarea id="rtelsmall" name="rtelsmall">{$shorthtml}</textarea>
											<script type="text/javascript">
											{literal}
												CKEDITOR.replace( 'rtelsmall',
													 { height:'100',
													   width:'650'
													  });
											{/literal}
											</script>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
										<div class="col-sm-10">
												<textarea id="rtel" name="rtel">{$html}</textarea>
												<script type="text/javascript">
												{literal}
													CKEDITOR.replace( 'rtel',
														 { height:'200',
														   width:'650'
														  });
												{/literal}
												</script>
										</div>
									</div>
								</fieldset>
							</div>
						</div>

						<div id="tab-3" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									{$img_rows}
								</fieldset>
							</div>
						</div>
					</div>
				<input name="sections_id" type="hidden" id="sections_id" value="{$sectionsid}">
			</div>
		</div>
	</form>
</div>
