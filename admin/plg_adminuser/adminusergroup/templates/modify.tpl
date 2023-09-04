<script type="text/javascript" language="javascript1.2">
{literal}
	function param_add() {
		var title = $('#inner #title').val();
		var description = $('#description').val();
		return '&title='+title+'&description='+description;
	}	

	function modify_plugin() {
		$(document).ready(function() {

			$('.pagination a').each(function() {
                var href = $(this).attr('href');
                $(this).removeAttr('href');
                //$(this).attr('data-link',(href.split('?'))[0]);
				$(this).attr('data-param',(href.split('?'))[1]);
            });

			$('.pagination a').click(function() {
				//var link = $(this).attr('data-link');
                link = window.folder+'/modify.php';
                var param = $(this).attr('data-param')+'&mode='+mode;
				update (link,param);
			})
			
			$('table #delete-action').click(function() {
				link = window.folder+"/"+'delete_action.php';
				var param = $(this).attr('data-param')+param_add();
				update2(link,param);
			})
			$('.title-actionplugin #addaction').click(function() {
				link = window.folder+"/"+'insert_action.php';
				var aaid = $('#adminuseractionid option:selected').val();
				var agid = $('#adminusergroupid').val();
				var mode = $('#inner #mode').val();				
				var param = 'mode='+mode+'&adminuseractionid='+aaid+'&adminusergroupid='+agid+param_add();
				if (mode=='insert') mode='insert2';								
				window.param2= 'mode='+mode+'&adminuseractionid='+aaid+'&adminusergroupid='+agid+param_add();			
				update2(link,param);
			})
			$('.title-actionplugin #addactionall').click(function() {
				link = window.folder+"/"+'insert_action_all.php';
				var agid = $('#adminusergroupid').val();
				var mode = $('#inner #mode').val();				
				var param = 'mode='+mode+'&adminusergroupid='+agid+param_add();
				if (mode=='insert') mode='insert2';								
				window.param2= 'mode='+mode+'&adminusergroupid='+agid+param_add();			
				update2(link,param);
			})			
		});
	}
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

		<table width="600"  border="0"  cellpadding="5" cellspacing="0" class="tablemodify">
				<tr>
					<td width="150">{$PLG_NAME}</td>
					<td width="450"><input name="title" id='title' type="text" value="{$title}" size="40" class="form-control"></td>
				</tr>  
				<tr>
					<td width="150">{$PLG_DESCRIPTION}</td>
					<td width="450"><input name="description" id='description' type="text" value="{$description}" size="40" class="form-control"></td>
				</tr>
				<tr>
					<td colspan="2"><hr/></td>
				</tr>
				<tr>
					<td>{$PLG_AVAILABLEACTIONS}</td>
					<td>
						<select name="adminuseractionid" id="adminuseractionid">
							{html_options values=$adminuseraction_val selected=$adminuseraction_sel output=$adminuseraction_out}
						</select>
						<div class="title-actionplugin">
							<div name="addaction" id="addaction" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;{$PLG_ADD}</div>						
							<div name="addactionall" id="addactionall" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;{$PLG_ADD_ALL}</div>						
						</div>	
					</td>
				</tr>
			<tr>
			<td colspan="2">
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
					table_attr='cellspacing=0 class="index" id="normal"'
  					message=$poruka
  			}
			</td>
		</tr>
		<tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>
		</table>
   		<input name="adminusergroupid" type="hidden" id="adminusergroupid" value="{$adminusergroupid}">

</form>
</div>
