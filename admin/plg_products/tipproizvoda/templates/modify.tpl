<script type="text/javascript" language="javascript1.2">
{literal}


	function GETLinkPromeni(param0, param1)
	{
		var link = window.folder+"/"+'modify.php';
		var param = "modifykarakt=1&tipproizvodaid="+param0+"&karakteristikaid="+param1+"&naziv="+document.editcategory.naziv.value+"&opis="+document.editcategory.opis.value;
		update(link,param);
	}
	function GETLinkObrisi(param0, param1)
	{
		var link = window.folder+"/"+'delete_kar_final.php';
		var param = "deletekarakt=1&tipproizvodaid="+param0+"&karakteristikaid="+param1+"&naziv="+document.editcategory.naziv.value+"&opis="+document.editcategory.opis.value;
		update2(link,param);
	}

	function modify_plugin() {
		$(document).ready(function() {
			$('table #move').click(function() {
				link = window.folder+"/"+$(this).attr('data-link');
				var param = $(this).attr('data-param')+param_add();
				update2(link,param);
			})

			$('table #modifybutt').click(function() {
				link = window.folder+"/"+'modify_karakteristika.php';
				var nk = $('table #nazivkar').val();
				var param = "karakteristikaid="+$(this).attr('data-param')+"&nazivkar="+nk+param_add();
				update2(link,param);
			})
			$('.title-actionplugin #addbutt').click(function() {
				link = window.folder+"/"+'insert_karakteristika.php';
				var kvid = $('#karakteristikavrstaid option:selected').val();
				var tid = $('#tipproizvodaid').val();
				var nk = $('#nazivkarnovo').val();
				var mode = $('#inner #mode').val();
				var param = 'mode='+mode+'&tipproizvodaid='+tid+'&karakteristikavrstaid='+kvid+'&nazivkarnovo='+nk+param_add();
				if (mode=='insert') mode='insert2';
				window.param2= 'mode='+mode+'&tipproizvodaid='+tid+'&karakteristikavrstaid='+kvid+'&nazivkarnovo='+nk+param_add();
				update2(link,param);
			})
		});
	}
{/literal}
</script>
<div id="content">
	<form name="editcategory" id="inner" action="modify_final.php" method="post" enctype="multipart/form-data">
	<input name="mode" type="hidden" id="mode" value="{$mode}">
		<div class="row wrapper  page-heading">
			<div class="col-lg-8">
				<h2 id="modi_title"></h2>
			</div>
			<div class="col-lg-4">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;{$PLG_SAVE}</div>
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
										<input id="title" name="naziv" type="text" value="{$naziv}" size="40" class="title form-control" placeholder="{$PLG_NAME}">
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
					<h2>{$PLG_CARACTERISTICS}</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel-body">
						<fieldset class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="Pitanje"> {$PLG_CARACTERISTICS_NEW} </label>
								<div class="col-sm-4">
									<input name="nazivkarnovo" id="nazivkarnovo" value="" maxlength="255" type="text" class="form-control">
								</div>
								<div class="col-sm-4">
									<select name="karakteristikavrstaid" id="karakteristikavrstaid" class="form-control">
										{html_options values=$vrstekarakteristika_val selected=$vrstekarakteristika_sel output=$vrstekarakteristika_out}
									 </select>
								</div>
								<div class="col-sm-2">
									<div class="title-actionplugin">
										<div name="addbutt" id="addbutt" class="btn btn-primary "><i class="fa fa-plus-square-o"></i>&nbsp;{$PLG_ADD}</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				{html_table_advanced  cols=5 loop=$tbl_content tableheader=$tbl_header table_attr=' border="0" cellspacing="0" class="index" id="normal"'}
				<input name="tipproizvodaid" type="hidden" id="tipproizvodaid" value="{$tipproizvodaid}">
				<input name="type" type="hidden" id="type" value="{$type}">
				<input name="order" type="hidden" id="order" value="{$order}">
			</div>
		</div>
	</form>
</div>
