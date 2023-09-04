<script>
{literal}
	function param_add() {
		$('#inner select, #inner input, #inner textarea').each(function() {
			if ($(this).attr('name') && !($(this).attr('name')=='mode')) {
				var name = $(this).attr('name');
				name = name.replace('[]','');
				$(this).attr('id', name);	
				var x1 = "#inner #"+name;
				var visible = $(this).css('visibility');
				if (visible=='hidden') 
				{
					var instance = CKEDITOR.instances[name];
					instance.updateElement();
					var val = instance.getData();
				}	
				else var val = $(x1).val();		
				param = param + "&" + name + "=" + val;
			}			
		})
		return param;
	}
	function modify_plugin() {
		$('.chosen-select').chosen({width: "100%"});
		// vezani dodatni resursi
		prepare_rows('img');	
		insert_row('img','images','files/Image/proizvod/user_uploads');
		prepare_rows('vid');		
		insert_row('vid');	
		prepare_rows('web');		
		insert_row('web');			
		prepare_rows('doc');	
		insert_row('doc','files','files/File/proizvod/user_uploads');	

		$('.input-group.date').datepicker({
			  todayBtn: "linked",
			  keyboardNavigation: false,
			  forceParse: false,
			  calendarWeeks: true,
			  autoclose: true,
			  format: "dd. mm. yyyy",
			  language: "sr-latin"
		});		
		
		delete_row(); 
		input_row();
		change_quantity();
		suma();
		format_row();
		change_user();
		$('.table-responsive #pager').hide();	
	};	
	
	function input_row() {
		var new_row=$('#components tbody tr:last').clone();
		$('.table-responsive select').change(function() {
			var cnid = $('.table-responsive #vproizvodid1 option:selected').val();
			var nid = $('#invoiceid').val();
			var mode = $('#mode').val(); 
			var link = window.folder+"/"+'insert_vproizvod.php';
			var param = 'proizvodid='+cnid+'&invoiceid='+nid+'&mode='+mode;
			//alert (param);
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
			format_row();
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
			format_row();
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				async: false,
				success: function(data) {					
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
	function format_row() {
		$('#components input,p').css({'text-align':'right'});		
		$('#components input').each(function() {
			var vr=Number($(this).val());
			vr = vr.toFixed(3);
			$(this).val(vr);
		})	
		$('#components p').each(function() {
			var vr=Number($(this).text());
			vr = vr.toFixed(2);
			$(this).text(vr);
		})			
	}
	function change_user() {
		$('#inner #userid').change(function() {	
			var x = $('#inner #userid option:selected').val();
			link = window.folder+"/"+'json_user.php?userid='+x;
			
			$.ajax({ 
				type: 'GET', 
				url: link,
	            success: function (data, status) 
				{
					var jsonObj =  jQuery.parseJSON(data);
					$('#inner #name').val(jsonObj.name+' '+jsonObj.surname);
					$('#inner #firm').val(jsonObj.firm);
					$('#inner #pib').val(jsonObj.pib);
					$('#inner #address').val(jsonObj.address);
					$('#inner #postalcode').val(jsonObj.postalcode);
					$('#inner #place').val(jsonObj.place);
					$('#inner #phone').val(jsonObj.phone);
					$('#inner #email a').html(jsonObj.email);
					$('#inner #email a').attr('href','mailto:'+jsonObj.email);	
				}
			});	
		})		
	}	
{/literal}
</script>
<div id="content">
	<form id='inner' name="editproizvod" action="modify_final.php" method="post" enctype="multipart/form-data">
	<input name="mode" type="hidden" id="mode" value="{$mode}">			
	<div class="row wrapper  page-heading">
		<div class="col-lg-8">
			<h2 id="modi_title"></h2>
			<h4>{$invoiceid}</h4>
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
						<li class=""><a data-toggle="tab" href="#tab-2"> {$PLG_ORDERER}</a></li>						
						<li class=""><a data-toggle="tab" href="#tab-3"> {$PLG_DESCRIPTION}</a></li>
						<li class=""><a data-toggle="tab" href="#tab-4"> {$PLG_SPECIFICATION}</a></li>
					</ul>
					 <div class="tab-content">
						<div id="tab-1" class="tab-pane active">
							<div class="panel-body">

								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_STATUS}</label>
										<div class="col-sm-10">
											<select name="statusid" class="form-control">
												{html_options values=$status_val selected=$status_sel output=$status_out}
											</select>
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
									<div class="row"><label class="col-sm-2 control-label"><strong>{$PLG_NOTE}</strong></label>
										<div class="col-sm-10">
											<input id='note' name="note" type="text" value="{$note}" size="60" class="form-control">											
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<div id="tab-2" class="tab-pane">
							<div class="panel-body">

								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_USER}</label>
										<div class="col-sm-10">
											<select id='userid' name='userid' class="form-control">
												{html_options values=$user_val selected=$user_sel output=$user_out}
											</select>
										</div>
									</div>								
									<div class="form-group"><label class="col-sm-2 control-label"><strong>{$PLG_NAME}</strong></label>
										<div class="col-sm-10">
											<input id='name' name="name" type="text" value="{$name} {$surname}" size="60" class="form-control" disabled>
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><strong>{$PLG_PIB}</strong></label>
										<div class="col-sm-10">
											<input id='pib' name="pib" type="text" value="{$pib}" size="60" class="form-control" disabled>					
										</div>
									</div>
									<div class="form-group"><label class="col-sm-2 control-label"><strong>{$PLG_FIRM}</strong></label>
										<div class="col-sm-10">
											<input id='firm' name="firm" type="text" value="{$firm}" size="60" class="form-control" disabled>
										</div>
									</div>									
									<div class="form-group"><label class="col-sm-2 control-label"><strong>{$PLG_ADDRESS}</strong></label>
										<div class="col-sm-10">
											<input id='address' name="address" type="text" value="{$address}" size="60" class="form-control" disabled>
										</div>
									</div>
									<div class="row"><label class="col-sm-2 control-label"><strong>{$PLG_POSTALCODE}</strong></label>
										<div class="col-sm-10">
											<input id='postalcode' name="postalcode" type="text" value="{$postalcode}" size="60" class="form-control" disabled>											
										</div>
									</div>
									<div class="row"><label class="col-sm-2 control-label"><strong>{$PLG_PLACE}</strong></label>
										<div class="col-sm-10">
											<input id='place' name="place" type="text" value="{$place}" size="60" class="form-control" disabled>
										</div>
									</div>
									<div class="row"><label class="col-sm-2 control-label"><strong>{$PLG_PHONE}</strong></label>
										<div class="col-sm-10">
											<input id='phone' name="phone" type="text" value="{$phone}" size="60" class="form-control" disabled>
										</div>
									</div>
									<div class="row"><label class="col-sm-2 control-label"><strong>{$PLG_EMAIL}</strong></label>
										<div class="col-sm-10">
											<p id='email'><a href="mailto:{$email}">{$email}</a><p>											
										</div>
									</div>
								</fieldset>
							</div>
						</div>						
						<div id="tab-3" class="tab-pane">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="form-group"><label class="col-sm-2 control-label">{$PLG_DESCRIPTION}</label>
										<div class="col-sm-10">
											<textarea id="opis" name="opis">{$opisCK}</textarea>
											<script type="text/javascript">
											{literal}
												CKEDITOR.replace( 'opis', 
													 { height:'250', 
													   width:'700'
													  });
											{/literal}
											</script>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<div id="tab-4" class="tab-pane ">
							<div class="panel-body">
								<fieldset class="form-horizontal">
									<div class="table-responsive">
										<div class="table-responsive" id='components'>
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
			
													
										</div>
									
									</div>
								</fieldset>
							</div>
						</div>						
					</div>
				</div>
			</div>
			<input name="invoiceid" type="hidden" id="invoiceid" value="{$invoiceid}">
		</div>	
					

	</form>
</div>


