
<script>
{literal}
	function modify_plugin() {
		$('.input-group.date').datepicker({
			  todayBtn: "linked",
			  keyboardNavigation: false,
			  forceParse: false,
			  calendarWeeks: true,
			  autoclose: true,
			  format: "dd. mm. yyyy",
			  language: "sr-latin"
		});	 
		$('#myModal6 #save_pass').click(function(){
			var psw = $('#myModal6 #password_new').val();
			var id =  $('#inner #userid').val();
			param = 'userid='+id + '&password_new=' + psw;
			link = 'plg_login/login/changepass_final.php';
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				success: function(data) {
					var klasa = $(data).attr('class');
					toastr[klasa](data);
					$('#myModal6 #close_pass').trigger( "click" );	
					//$('#myModal6').css("display", "none").empty();
				}
			})
		})	
	}
	function addUserSubSite()
	{
		window.document.location = "add_usersubsite.php?userid="+document.mainForm.userid.value+"&subsiteid_add="+document.mainForm.subsiteid_add.value+"&expirydate="+document.mainForm.expirydate.value+"&statusid="+document.mainForm.statusid.value;
	}
	$(document).ready(function(){

		$("#showDetails").click(function(){
			$("#showDetails").hide();
			$("#loginDetails").show();
			return false;
		});
			
	});

{/literal}
</script>

<div id="content">
	<form id='inner' name="mainForm" action="modify_final.php" method="post" enctype="multipart/form-data">
	<input name="mode" type="hidden" id="mode" value="{$mode}">		
			<div class="row wrapper  page-heading">
                <div class="col-lg-8">
                    <h2 id="modi_title"></h2>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
						<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i> {$PLG_SAVE}</div>	
						<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;{$PLG_CLOSE}</div>
                    </div>
                </div>
			</div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1"> {$PLG_INFO}</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2"> {$PLG_ACCESS}</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-3"> {$PLG_USERS_LOG_HISTORY}</a></li>
								<li class=""><a data-toggle="tab" href="#tab-4"> {$PLG_MESSAGE}</a></li>
                            </ul>
							 <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
										<fieldset class="form-horizontal">
                                            <div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
                                                <div class="col-sm-10">
													<input name="name" type="text" value="{$name}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_LASTNAME}</label>
                                                <div class="col-sm-10">
													<input name="surname" type="text" value="{$surname}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_MANUFACTURER}</label>
                                                <div class="col-sm-10">
													<input name="firm" type="text" value="{$firm}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_TAXID}</label>
                                                <div class="col-sm-10">
													<input name="pib" type="text" value="{$pib}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_REGNO}</label>
                                                <div class="col-sm-10">
													<input name="matbr" type="text" value="{$matbr}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PLACE}</label>
                                                <div class="col-sm-10">
													<input name="place" type="text" value="{$place}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_ADDRESS}</label>
                                                <div class="col-sm-10">
													<input name="address" type="text" value="{$address}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_POSTALCODE}</label>
                                                <div class="col-sm-10">
													<input name="postalcode" type="text" value="{$postalcode}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PHONE}</label>
                                                <div class="col-sm-10">
													<input name="phone" type="text" value="{$phone}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_EMAIL}</label>
                                                <div class="col-sm-10">
													<input name="email" type="text" value="{$email}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_COMMENT}</label>
                                                <div class="col-sm-10">
													<textarea name="comment" rows="5" class="form-control">{$comment}</textarea>
												</div>
                                            </div>
										</fieldset>
                                    </div>
                                </div>
								<div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_USERNAME}</label>
                                                <div class="col-sm-10">
													<input name="username" type="text" value="{$username}" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PASSWORD}</label>
                                                <div class="col-sm-10">
													<a data-toggle="modal" class="btn btn-primary" data-target="#myModal6">{$PLG_CHANGE_PASSWORD}</a>
												</div>
                                            </div>
											<div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-sm">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
															<h4 class="modal-title">{$PLG_CHANGE_PASSWORD}</h4>
														</div>
														<div class="modal-body">
															<p><strong>{$PLG_CHANGEPASSADD_NEW}</strong></p>
															<input type="text" value="" name="password_new" id="password_new" class="form-control" />
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-white" id="close_pass" data-dismiss="modal">{$PLG_CLOSE}</button>
															<button type="button" class="btn btn-primary" id="save_pass" name="save_pass">{$PLG_SAVE}</button>
														</div>
													</div>
												</div>
											</div>

											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
                                                <div class="col-sm-10">
													<select name="statusid" id="statusid" class="form-control">
														{html_options values=$status_val selected=$status_sel output=$status_out}
													</select>
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_CATEGORY}</label>
                                                <div class="col-sm-10">
													<select name="usercategoryid" id="usercategoryid" class="form-control">
														{html_options values=$usercategory_val selected=$usercategory_sel output=$usercategory_out}
													</select>
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_TYPE}</label>
                                                <div class="col-sm-10">
													<select name="usertypeid" id="usertypeid" class="form-control">
														{html_options values=$usertype_val selected=$usertype_sel output=$usertype_out}
													</select>
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DISCOUNT}</label>
                                                <div class="col-sm-10">
													<input name="discount" type="text" value="{$discount}" size="40" class="form-control" />
												</div>
                                            </div>
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_EXDATE}</label>
                                                <div class="col-sm-10">
													<div class="input-group date" data-provide="datepicker">
														<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														<input name="datum" type="text" class="form-control" value="{$datum}" >
													</div>
												</div>
                                            </div>
										</fieldset>
                                    </div>
                                </div>
								<div id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_HISTORY_TABLE}</label>
                                                <div class="col-sm-10">
													<div class="table-responsive">
														{if count($user_log_history_data) gt 0}
														<table cellpadding="0" cellspacing="0">
														<tr>
															<th>R.b</th>
															<th align="center">{$PLG_HISTORY_TIME}</th>
															<th align="center">{$PLG_HISTORY_IPADDRESS}</th>
														</tr>
															{section loop=$user_log_history_data name=cnt}
																{if $smarty.section.cnt.index < 5}
																<tr>
																	<td width="15px"><p class="history">{$smarty.section.cnt.index}</p></td>
																	<td width="150px"><p class="history">{$user_log_history_data[cnt].lastlogdateformated}</p></td>
																	<td width="100px"><p class="history">{$user_log_history_data[cnt].lastlogip}</p></td>
																</tr>
																{/if}
															{/section}
														</table>
														{if count($user_log_history_data) gt 5}
														<a id="showDetails" href="#">Prikazi više</a>
														<table cellpadding="0" cellspacing="0" id="loginDetails" style="display: none">
															{section loop=$user_log_history_data name=cnt}
																{if $smarty.section.cnt.index >= 5}
																<tr>
																	<td width="15px"><p class="history">{$smarty.section.cnt.index}</p></td>
																	<td width="150px"><p class="history">{$user_log_history_data[cnt].lastlogdateformated}</p></td>
																	<td width="100px"><p class="history">{$user_log_history_data[cnt].lastlogip}</p></td>
																</tr>
																{/if}
															{/section}
														</table>
														{/if}
														{else}Nema podataka{/if}
													</div>
												</div>
                                            </div>
										</fieldset>
                                    </div>
                                </div>
								<div id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset class="form-horizontal">
											<div class="form-group"><label class="col-sm-2 control-label">{$PLG_INFO_PAGE}</label>
                                                <div class="col-sm-10">
													<textarea id="userdescription" name="userdescription">{$html}</textarea>
													<script type="text/javascript">
													{literal}
														CKEDITOR.replace( 'userdescription', {
														   toolbar : 'Basic',
														   height: '100', 
														   width: '400'
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

			<input name="userid" type="hidden" id="userid" value="{$userid}">
		    <input name="subsiteid" type="hidden" id="subsiteid" value="{$subsiteid}">
	</form>
</div>
