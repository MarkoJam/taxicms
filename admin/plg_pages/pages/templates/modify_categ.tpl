

<script>
{literal}
	function modify_plugin() {


		var pid=$('#inner #page_id').val();
		var parid=$('#inner #parent_id').val();
		
		$('#inner #title').on('change', function () {
			var link = window.folder+'/check_title.php';
			var header = $(this).val();
			var param='header='+header+'&pid='+pid+'&parid='+parid;
			alert (param);
			$.ajax({
                type: 'POST',
                url: link,
                data: param,
				dataType: 'json',
                success: function(data) {			;
					if (data.tip!=2) 	{$('#inner #promeni').attr('disabled','disabled');
						toastr['warning'](data.msg); 
					}
					else $('#inner #promeni').attr('disabled', false);

                }
            });
		})	
	}
{/literal}
</script>

<div id="content">
	<form  id='inner' action="modify_final.php" method="post" enctype="multipart/form-data" >
		<input name="mode" type="hidden" id="mode" value="{$mode}">
		<div class="row wrapper  page-heading">
			<div class="col-lg-6">
				<h2 id="modi_title"></h2>			
			</div>
			<div class="col-lg-6">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;{$PLG_SAVE}</div>
					<div name="pretvori_u_stranicu" id="promeni" class="btn btn-info"><i class="fa fa-paste"></i>&nbsp;{$PLG_TRANSFORM}/{$PLG_PAGE}</div>
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
								<input name="header" id='title' type="text" value="{$header}" size="40" class="title form-control" placeholder="{$PLG_NAME}">
							</div>
					   </div>
										
					   
					   <div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
							<div class="col-sm-10">
								<select name="statusid" class="form-control">
								  {html_options values=$status_val selected=$status_sel output=$status_out}
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
		</div>

		<input name="page_id" type="hidden" id="page_id" value="{$page_id}">
		<input name="template_id" type="hidden" id="template_id" value="{$template_id}">
		<input name="order" type="hidden" id="order" value="{$order}">
		<input name="pagetypeid" type="hidden" id="pagetypeid" value="{$pagetypeid}">
		<input name="navigationtype" type="hidden" id="navigationtype" value="{$navigationtype}">

	</form>
</div>
