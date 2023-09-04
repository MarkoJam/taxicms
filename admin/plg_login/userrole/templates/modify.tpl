
<script language="JavaScript" type="text/JavaScript">
function confirmLink(theLink, theSqlQuery)
{ldelim}
    var confirmMsg  = '{$QUESTION}';
		// Confirmation is not required in the configuration file
    if (confirmMsg == '') {ldelim}
        return true;
    {rdelim}
    var is_confirmed = confirm(confirmMsg + ' :\n' + theSqlQuery);
    return is_confirmed;
{rdelim} // end of the 'confirmLink()' function
</script>

<script>
{literal}
	function modify_plugin() {
		$(document).ready(function() {
			$('table #delete_plugin').click(function() {
				link = window.folder+"/"+'delete_final.php';
				var param = $(this).attr('data-param');
				update2(link,param);
			})
		});
	}
{/literal}
</script>

<div id="content">
	<form id='inner' action="modify_final.php" method="post" enctype="multipart/form-data">
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
											<input name="role" type="text" value="{$role}" class="title form-control" placeholder="{$PLG_NAME}">
										</div>
                                  </div>
								  <div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
                                        <div class="col-sm-10">
											<textarea name="description" cols="50" rows="3" id="description" class="form-control">{$description}</textarea>
										</div>
                                 </div>
                            </fieldset>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<h2>{$PLG_USERS}</h2>
					</div>
				</div>
				<div class="table-responsive">

					{html_table_advanced
						filter=$filter					
						browseString=$tbl_browseString 
						scriptName=$scriptName 
						cnt_rows=$tbl_row_count 
						rowOffset=$tbl_offset 
						tr_attr=$tbl_tr_attributes 
						td_attr=$tbl_td_attributes 
						loop=$tbl_content 
						cols=$tbl_cols_count 
						tableheader=$tbl_header 
						table_attr=' cellspacing=0 class="index" ' 
						message=$poruka  
						cnt_all_rows=$tbl_all_rows_count
					}
				</div>

		<input name="userroleid" type="hidden" id="" value="{$userroleid}">
	</form>
</div>