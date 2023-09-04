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
		$('#publishingdatum').datetimepicker({
			format:'d.m.Y H:i'
		});

		$('.input-group.date').datepicker({
			  todayBtn: "linked",
			  keyboardNavigation: false,
			  forceParse: false,
			  calendarWeeks: true,
			  autoclose: true,
			  format: "dd. mm. yyyy",
			  language: "sr-latin"
		});

		$(document).ready(function() {
			delete_conres();
			$('.title-actionconres #insert_conres').click(function() {
				var crid = $('#conres1 option:selected').val();
				var nid = $('#module_id').val();
				var mode = $('#mode').val();
				var link = 'insert_conres.php';
				var param = 'conres_id='+crid+'&res_id='+nid+'&class=Module'+'&mode='+mode;
				if (mode=='insert') mode='insert2';
				window.param2='mode='+mode+'&module_id='+nid+'&active=3'+param_add() + '&cnc=1';
				update2(link,param);
			})

		})
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
						<li class="{if $active ne 3}active{/if}"><a data-toggle="tab" href="#tab-1"> {$PLG_INFO}</a></li>
						<li class=""><a data-toggle="tab" href="#tab-2"> {$PLG_CONTENT}</a></li>
						<li class="{if $active eq 3}active{/if}"><a data-toggle="tab" href="#tab-3"> {$PLG_CON}</a></li>
						<li class=""><a data-toggle="tab" href="#tab-4"> {$PLG_EXT_RES}</a></li>
					</ul>
					<div class="tab-content">

                        <div id="tab-1" class="tab-pane  {if $active ne 3}active{/if}">
                            <div class="panel-body">
                                <fieldset class="form-horizontal">
                                    <div class="form-group"><label class="col-sm-2 control-label">{$PLG_KEYWORDS}</label>
                                        <div class="col-sm-10"><input type="text" id='title' name="keywords" value="{$keywords}" class="form-control" placeholder="{$PLG_KEYWORDS}"></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
                                        <div class="col-sm-10"><input type="text" id='title' name="header" value="{$header}" class="form-control" placeholder="{$PLG_NAME}"></div>
                                    </div>
									{*<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PLACE}</label>
										<div class="col-sm-10"><input type="text" name="place" value="{$place}" class="form-control" placeholder="{$PLG_PLACE}"></div>
									</div>*}
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PUBLISHINGDATE}</label>
										<div class="col-sm-10">
											<input id="publishingdatum" name="publishingdate" type="text" class="form-control" value="{$publishingdatum}">
										</div>
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
											<select size="5" multiple="multiple" name="modulecategories[]" class="chosen-select">
												{html_options values=$modulecategory_val selected=$modulecategory_sel output=$modulecategory_out}
											</select>
											</div>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DATE}</label>
										<div class="col-sm-10">
											<div class="input-group date" data-provide="datepicker">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input name="datum" type="text" class="form-control" value="{$datum}">
											</div>

										</div>
									</div>
									{*<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DURATION}</label>
										<div class="col-sm-1"><input type="text" name="duration" value="{$duration}" class="form-control" placeholder="{$PLG_DURATION}"></div>
									</div>*}									
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_LINK}</label>
										<div class="col-sm-10"><input type="text" name="link" value="{$link}" class="form-control" placeholder="{$PLG_LINK}"></div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_IMAGE}</label>
										<div class="col-sm-6">
										   <input id="slika" name="slika" type="text" value="{$slika}" size="50" class="form-control image">
										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServer(this);"><i class="fa fa-plus-square-o" ></i> {$PLG_ADD}</a>
										</div>
										<div class="col-sm-2">
										  <a data-toggle="modal" data-target="#myModal7"><img class="image responsive image-title" src="{$slika}"  /><div class="overlay-icon"></div></a>
										</div>
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

						<div id="tab-3" class="tab-pane {if $active eq 3}active{/if}">
							<div class="panel-body">
								<div class="panel-body">
									<fieldset class="form-horizontal">
										<div class="form-group">
											<label class="col-sm-2 control-label" for="Pitanje"> {$PLG_CON2} </label>

											<div class="col-sm-8">
												<select id="conres1" name="conres1" class="chosen-select">
													{html_options values=$conres_val output=$conres_out }
												</select>
											</div>
											<div class="col-sm-2">
												<div class="title-actionconres">
													<div name="promeni" id="insert_conres" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;{$PLG_ADD}</div>
												</div>
											</div>
										</div>
										<div class="table-responsive">
											{if $tbl_all_rows_count gt 0}
											{html_table_advanced
													filter=$filter
													content=$tbl_content
													cnt_all_rows=$tbl_all_rows_count
													browseString=$tbl_browseString
													scriptName=$scriptName
													cnt_rows=$tbl_row_count
													rowOffset=$tbl_offset
													tr_attr=$tbl_tr_attributes
													td_attr=$tbl_td_attributes
													loop=$tbl_content
													cols=$tbl_cols_count
													tableheader=$tbl_header
													exportlinks=$tbl_show_export_links
													table_attr='cellspacing=0 class="index" id="normal"'
													message=$poruka}
												{/if}
										</div>
									</fieldset>
								</div>
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
				<input name="module_id" type="hidden" id="module_id" value="{$moduleid}">
			</div>
		</div>
	</form>
</div>
