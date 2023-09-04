<script>
{literal}	
	function modify_plugin() {
		$('#save_pass').click(function() {
			link = window.folder+"/"+'changepass_final.php';
			var param = 'password_new='+$('#password_new').val()+'&adminuserid='+$('#adminuserid').val();
			$.ajax({
				type: "POST",
				url: link,
				data: param,
					success: function(data) {
						var klasa = $(data).attr('class');
						toastr[klasa](data);	
					}
			})
		})	
	}

	function passwindow(adminuserid)
	{
		window.open('changepass.php?adminuserid='+adminuserid,'ChangePassword','width=300,height=130,resizable=yes');
	}

{/literal}
</script>

<div id="content">
	<form action="modify_final.php" method="post" id="inner" enctype="multipart/form-data">
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
				<div class="panel-body">
                     <fieldset class="form-horizontal">
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_FULLNAME}</label>
								<div class="col-sm-10">
									<input name="fullname" type="text" value="{$fullname}" class="form-control">
								</div>
                            </div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PLACE}</label>
								<div class="col-sm-10">
									<input name="place" type="text" value="{$place}"  class="form-control">
								</div>
                            </div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PHONE}</label>
								<div class="col-sm-10">
									<input name="phone" type="text" value="{$phone}" class="form-control">
								</div>
                            </div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_EMAIL}</label>
								<div class="col-sm-10">
									<input name="email" type="text" value="{$email}" class="form-control">
								</div>
                            </div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_COMMENT}</label>
								<div class="col-sm-10">
									<textarea name="comment" rows="5" class="form-control">{$comment}</textarea>
								</div>
                            </div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_USERNAME}</label>
								<div class="col-sm-10">
									<input name="username" type="text" value="{$username}"  class="form-control">
								</div>
                            </div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PASSWORD}</label>
                                  <div class="col-sm-10">
										<a data-toggle="modal" class="btn btn-primary" href="javascript:passwindow({$userid})" data-target="#myModal6">{$PLG_CHANGE_PASSWORD}</a>
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
											<p><strong>{$PLG_CHANGEPASS_ADD_NEW}</strong></p>
											<input type="text" value="" name="password_new" id="password_new" class="form-control" />
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-white" data-dismiss="modal">{$PLG_RESET}</button>
											<button type="button" class="btn btn-primary" id="save_pass" name="save_pass" data-dismiss="modal">{$PLG_SAVE}</button>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_USER}</label>
								<div class="col-sm-10">
									<select name="adminusergroupid" id="adminusergroupid" class="form-control">
										{html_options values=$adminusergroup_val selected=$adminusergroup_sel output=$adminusergroup_out}
									</select>
								</div>
                            </div>

							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_SUBSITE}</label>
								<div class="col-sm-10">
									<select name="subsiteid" id="subsiteid" class="form-control">
										<option value="-1">{$PLG_ALLSUBSITES}</option>
										{html_options values=$subsite_val selected=$subsite_sel output=$subsite_out}
									</select>
								</div>
                            </div>

							<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
								<div class="col-sm-10">
									<select name="statusid" id="statusid" class="form-control">
										{html_options values=$status_val selected=$status_sel output=$status_out}
									</select>
								</div>
                            </div>
						</fieldset>
                     </div>
                  </div>
				</div>

	<input name="adminuserid" type="hidden" id="adminuserid" value="{$adminuserid}">
    <input name="type" type="hidden" id="type" value="{$type}">

</form>

</div>

