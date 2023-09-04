<script>
{literal}	
	function param_partial() {
		var title = $('#inner #title').val();
		var description = $('#description').val();
		return '&title='+title+'&description='+description;
	}
	function modify_plugin() {
		$(document).ready(function() {
		
			$('#inner table .naziv').click(function() {
				link = window.folder+"/"+'modify.php';
				var param = $(this).attr('data-param')+param_partial();
				update(link,param);
			})
			$('table #delete_plugin').click(function() {
				link = window.folder+"/"+'delete_plugin.php';
				var param = $(this).attr('data-param');
				update2(link,param);
			})
			$('table #modifybutt').click(function() {
				link = window.folder+"/"+'modify_plugin.php';
				var tmplplgid = $(this).attr('data-param');
				var pid = $('#pluginid option:selected').val();
				var sid = $('#selectionid option:selected').val();
				var posid = $('#position option:selected').val();
				var tid = $('#template_id').val();
				var param = 'tmplplgid='+tmplplgid+'&pluginid='+pid+'&selectionid='+sid+'&position='+posid+'&template_id='+tid+param_partial();
				window.param2='mode='+mode+'&pluginid1='+pid+'&template_id='+tid+param_partial();				
				update2(link,param);
			})
			$('.title-actionplugin #insert_plugin').click(function() {
				var pid = $('#pluginid1 option:selected').val();
				var tid = $('#template_id').val();
				var mode = $('#mode').val(); 
				var link = window.folder+"/"+'insert_plugin.php';
				var param = 'pluginid1='+pid+'&template_id='+tid+'&mode='+mode;
				if (mode=='insert') mode='insert2';
				window.param2='mode='+mode+'&pluginid1='+pid+'&template_id='+tid+param_add();
				update2(link,param);
			})
		});
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
					 <div class="panel-body">
                           <fieldset class="form-horizontal">
                                 <div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
                                        <div class="col-sm-10">
											<input name="title" type="text" id="title" value="{$Title}" size="40" class="title form-control" placeholder="{$PLG_NAME}">
										</div>
                                  </div>
								  <div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
                                        <div class="col-sm-10">
											<textarea name="description" cols="50" rows="3" id="description" class="form-control">{$Description}</textarea>
										</div>
                                 </div>
                            </fieldset>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<h2>{$PLG_CHANGEPLUGIN}</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel-body">
							<fieldset class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="Pitanje"> {$PLG_NAME} </label> 
									
									<div class="col-sm-8">
										<select id="pluginid1" name="pluginid1" class="form-control">
											{html_options values=$sel_values_plg selected=$sel_selected_plg output=$sel_output_plg }  
										</select>
									</div>
									<div class="col-sm-2">
										<div class="title-actionplugin">
											<div name="promeni" id="insert_plugin" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;{$PLG_ADD}</div>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
    			<div class="table-responsive">
					{if $tbl_all_rows_count gt 0}
					{html_table_advanced 
							filter=$filter		  
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

					<input name="template_id" type="hidden" id="template_id" value="{$TemplateID}">
				</div>

</form>
</div>
