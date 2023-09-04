<script type="text/javascript" src="CKeditor/ckeditor/ckeditor.js"></script>
<script>
{literal}

	function modify_plugin() {
		$('.chosen-select').chosen({display_selected_options:false,width: "100%"}).next().addClass('up');
	// vezani dodatni resursi
		prepare_rows('img');
		insert_row('img','1','');
		prepare_rows('vid');
		insert_row('vid');
		prepare_rows('web');
		insert_row('web');
		prepare_rows('doc');
		insert_row('doc','2','File');

	};
	function input_row() {
		var new_row=$('#components tbody tr:last').clone();
		$('.table-responsive select').change(function() {
			var cnid = $('.table-responsive #vproizvodid1 option:selected').val();
			var nid = $('#proizvodid').val();
			var mode = $('#mode').val();
			var link = window.folder+"/"+'insert_vproizvod.php';
			var param = 'vproizvodid='+cnid+'&proizvodid='+nid+'&mode='+mode;
			alert (param);
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				async: false,
				success: function(data) {
					//var klasa = $(data).attr('class');
					//toastr[klasa](data);
					$('.table-responsive #input_name:last').text($('.table-responsive #vproizvodid1 option:selected').text());
					$('.table-responsive #delete_vproizvod').show();
					$('.table-responsive #delete_vproizvod').attr('data-param',param);
					$('.table-responsive #kolicina').attr('data-param',param);
					delete_row();
					$('.table-responsive #kolicina').show();
					$('.table-responsive #cena').show();
					$('.table-responsive #vrednost').show();
					var cena = data;
					$('.table-responsive #cena:last').text(cena);
				}
			});
			$('#components tbody').append(new_row);
			input_row() ;
			countries_row();
			change_quantity();
		})
	};
	function delete_row() {
		$('.table-responsive #delete_vproizvod').click(function() {
			link = window.folder+"/"+'delete_vproizvod.php';
			var param = $(this).attr('data-param');
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				async: false,
				success: function(data) {
					//var klasa = $(data).attr('class');
					//toastr[klasa](data);
				}
			});
			$(this).parent().parent().remove();
		})
	}
	function change_quantity() {
		$('.table-responsive #kolicina').change(function() {
			link = window.folder+"/"+'change_quantity.php';
			var kol = $(this).val();
			var param = $(this).attr('data-param')+'&kolicina=' + kol;
			var cena = $(this).parent().parent().find('#cena').text();
			var vr = cena*kol;
			$(this).parent().parent().find('#vrednost').val(vr);
			suma();
			countries_row();
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				async: false,
				success: function(data) {
					//var klasa = $(data).attr('class');
					//toastr[klasa](data);
				}
			});
		})
	}
	function suma() {
		var suma=0;
		$('.table-responsive #vrednost').each(function() {
			suma=suma + Number($(this).val());
		})
		$('.table-responsive #suma').val(suma);
	}
	function countries_row() {
		$('#components input,p').css({'text-align':'right'});
		$('#components input').each(function() {
			var vr=Number($(this).val());
			vr = vr.toFixed(2);
			$(this).val(vr);
		})
		$('#components p').each(function() {
			var vr=Number($(this).text());
			vr = vr.toFixed(2);
			$(this).text(vr);
		})
	}
	$(document).ready(function() {
		delete_row();
		input_row();
		change_quantity();
		suma();
		countries_row();
		$('.table-responsive #pager').hide();
	})
{/literal}
</script>
<div id="content">
	<form id='inner' name="editproizvod" action="modify_final.php" method="post" enctype="multipart/form-data">
	<input name="mode" type="hidden" id="mode" value="{$mode}">
	<div class="row wrapper  page-heading">
		<div class="col-lg-8">
			<h2 id="modi_title"></h2>
			{if $proizvodnaziv}<h2>{$PLG_BASIC_PRODUCT} : {$proizvodnaziv}</h2>{/if}
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
						<li class=""><a data-toggle="tab" href="#tab-2">
						SEO</a></li>
						<li class=""><a data-toggle="tab" href="#tab-3"> {$PLG_DESCRIPTION}</a></li>
						<li class=""><a data-toggle="tab" href="#tab-4"> {$PLG_IMAGE}</a></li>
						<li class=""><a data-toggle="tab" href="#tab-5"> {$PLG_EXT_RES}</a></li>
					</ul>
					 <div class="tab-content">
						<div id="tab-1" class="tab-pane active">
							<div class="panel-body">

								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_TYPE}</label>
										<div class="col-sm-10 tip-label">{$tipproizvodanaziv}</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
										<div class="col-sm-10">
											<select name="statusid" class="form-control">
												{html_options values=$status_val selected=$status_sel output=$status_out}
											</select>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_NAME}</label>
										<div class="col-sm-10">
											<input name="naziv" type="text" value="{$naziv}" size="60" class="form-control">
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_CODE}</label>
										<div class="col-sm-10">
											<input name="sifra" type="text" value="{$sifra}" size="40" class="form-control">
										</div>
									</div>

									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PRICE}</label>
										<div class="col-sm-10">
											<input name="cenaa" type="text" value="{$cenaa}" size="20" class="form-control">
										</div>
									</div>

									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_PRICEDOWN}</label>
										<div class="col-sm-10">
											<input name="cenab" type="text" value="{$cenab}" size="20" class="form-control">
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<div id="tab-2" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">Opis</label>
										<div class="col-sm-10">
											<input name="napomenaadd" type="text" value="{$napomenaadd}"  class="form-control">
										</div>
									</div>

									<div class="form-group"><label class="col-sm-2 control-label">Ključne reči</label>
										<div class="col-sm-10">
											<input name="napomena" type="text" value="{$napomena}"  class="form-control">
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<div id="tab-3" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_SHORTDESCRIPTION}</label>
										<div class="col-sm-10">
											<textarea id="kratak_opis" name="kratak_opis">{$kratak_opisCK}</textarea>
											<script type="text/javascript">
											{literal}
												CKEDITOR.replace( 'kratak_opis',
													 { height:'100',
													   width:'700',
													  });
											{/literal}
											</script>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
										<div class="col-sm-10">
											<textarea id="opis" name="opis">{$opisCK}</textarea>
											<script type="text/javascript">
											{literal}
												CKEDITOR.replace( 'opis',
													 { height:'250',
													   width:'700',
													   toolbar: 'toolbar_Full'													   
													  });
											{/literal}
											</script>
										</div>
									</div>

								</fieldset>
							</div>
						</div>
						<div id="tab-4" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_IMAGE}</label>
										<div class="col-sm-6">
										   <input id="slika" name="slika" type="text" value="{$slika}"  class="form-control">
										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServer(this);"><i class="fa fa-plus-square-o" ></i> {$PLG_ADD}</a>
										</div>
										<div class="col-sm-2">
										  <img class="image responsive" src="{$ROOT_WEB}{$slika}" style="height:auto; width: 100%;" />
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label">Slika mouse over</label>
										<div class="col-sm-6">
										   <input id="slikaover" name="slikaover" type="text" value="{$slikaover}"  class="form-control">
										</div>
										<div class="col-sm-2">
										  <a class="btn btn-success" href="javascript:BrowseServerSlika(this);"><i class="fa fa-plus-square-o" ></i> {$PLG_ADD}</a>
										</div>
										<div class="col-sm-2">
										  <img class="imageover responsive"  src="{$ROOT_WEB}{$slikaover}" style="height:auto; width: 100%;" />
										</div>
									</div>

								</fieldset>
							</div>
						</div>
						<div id="tab-5" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="table-responsive">
									{$img_rows}
									{*
										<div class="hr-line-dashed"></div>
									{$vid_rows}
										<div class="hr-line-dashed"></div>
									{$web_rows}
										<div class="hr-line-dashed"></div>
									{$doc_rows}
										*}
									</div>
								</fieldset>
							</div>
						</div>
					</div>
				</div>
			</div>

			<input name="proizvodid" type="hidden" id="proizvodid" value="{$proizvodid}" />
			<input name="oem" type="hidden"  value="{$oem}" />
			<input name="kolicina" type="hidden"  value="{$kolicina}" />
			<input name="tipproizvodaid" type="hidden" id="tipproizvodaid" value="{$tipproizvodaid}" />
			<input name="order" type="hidden" id="order" value="{$order}" />
			<input name="grpproizbackid" type="hidden" id="grpproizbackid" value="{$smarty.request.grpproizbackid}" />
		</div>


	</form>
</div>
