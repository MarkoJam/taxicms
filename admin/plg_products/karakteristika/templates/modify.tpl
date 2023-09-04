<script type="text/javascript" language="javascript1.2">
{literal}		
	function modify_plugin() {
		$(document).ready(function() {
			$('table #delete-element').click(function() {
				link = window.folder+"/"+'delete_element.php';
				var param = $(this).attr('data-param');
				update2(link,param);
			})
			$('table #action_modify').click(function() {
				link = window.folder+"/"+'modify_element.php';
				var kid = $('#karakteristika_vrsta_id').val();			
				var naziv = $('#elementvrednost_mod').val();
				var param = 'karakteristika_vrsta_id='+kid+'&karakteristikaelementid='+ $(this).attr('data-param')+'&elementvrednost_mod='+naziv+param_add();
				update2(link,param);
			})
			$('table #modifybutt').click(function() {
				link = window.folder+"/"+'modify.php';
				var kid = $('#karakteristika_vrsta_id').val();				
				var param = 'karakteristika_vrsta_id='+kid+'&action=modify'+'&karakteristikaelementid=' + $(this).attr('data-param') + param_add();
				update(link,param);
			})
			$('.title-actionplugin #addbutt').click(function() {
				link = window.folder+"/"+'insert_element.php';
				var naziv = $('#elementvrednost_add').val();
				var kid = $('#karakteristika_vrsta_id').val();
				var mode = $('#inner #mode').val();
				var param = 'mode='+mode+'&karakteristika_vrsta_id='+kid+'&elementvrednost_add='+naziv+param_add();
				if (mode=='insert') mode='insert2';								
				window.param2= 'mode='+mode+'&karakteristika_vrsta_id='+kid+'&elementvrednost_add='+naziv+param_add();
				update2(link,param);
			})
		});
	}
{/literal}
</script>

<div id="content">
	<form name="modify_karakteristika" id="inner" action="modify_final.php" method="post" enctype="multipart/form-data">
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
											<input id="title" name="naziv" type="text" value="{$naziv}" class="title form-control" placeholder="Naziv">
										</div>
                                  </div>
								  <div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
                                        <div class="col-sm-10">
											<textarea id="description" name="opis" rows="3" class="form-control">{$opis}</textarea>
										</div>
                                 </div>
                            </fieldset>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<h2>{$PLG_CARACTERISTIC_OPTIONS}</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="panel-body">
							<fieldset class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="Pitanje">{$PLG_CARACTERISTICS_NEW}</label> 
									<div class="col-sm-8">
										<input id="elementvrednost_add" name="elementvrednost_add" type="text" value="" class="form-control"> 
									</div>
									<div class="col-sm-2">
										<div class="title-actionplugin">
											<div id="addbutt" name="action_add" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;{$PLG_ADD}</div>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
				<div class="table-responsive">

					{if $no_data_karakt_elementi eq ""}
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
							table_attr='cellspacing=0 class="index" id="normal"'
							message=$poruka 
							cnt_all_rows=$tbl_all_rows_count
						}
					{else}
						{$no_data_karakt_elementi}
					{/if}

   				<input name="karakteristika_vrsta_id" type="text" id="karakteristika_vrsta_id" value="{$karakteristikavrstaid}">
			</div>

	</form>
</div>