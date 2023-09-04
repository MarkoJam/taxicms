<script>
{literal}
	function table_plugin() {
		var link = window.folder+"/index.php";
		$("#formRecordsPerPage").change(function(){
			var rpp = $("#formRecordsPerPage option:selected").val(); 
			var param= "records_per_page=" + rpp;
			table(link,param);
		})	
	
		// editovanje polja
		$('.edit-cena').editable('plg_products/proizvod/modify_cena_final.php', {
			id: 'proizvodid',
			style: 'display:inline;',
			submit: 'OK',
			cancel: 'Poništi',
			cssclass: 'editable'
		});
		$('.edit-tezina').editable('plg_products/proizvod/modify_tezina_final.php', {
			id: 'proizvodid',
			style: 'display:inline;',
			submit: 'OK',
			cancel: 'Poništi',
			cssclass: 'editable'
		});
		
		// dodavanje u grupu proizvoda
		$(".dodaj_u_grupu").click(function() {
			var grpProizId = $(".html5buttons #grupaproizvodaid option:selected").val();
			var proizvodId = $(this).attr('data-param');
			var link = $(this).attr('data-link');
			link = window.folder+"/"+link;
			var param = "grupaproizvodaid=" + grpProizId + "&proizvodid=" + proizvodId;
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				success: function(data) {
					var klasa = $(data).attr('class');
					toastr[klasa](data);
					var link = window.folder+"/index.php";
					var param = window.param;
					table (link,param);
				}
			});
		});
		// dodavanje niza proizvoda u grupu
		$("#dodaj_sve_u_grupu").click(function() {
			var grpProizId = $(".html5buttons #grupaproizvodaid option:selected").val();
			var data = {
				'proizvodid[]': [],
				'grupaproizvodaid': grpProizId
			};
			$("#tabledivbody input:checked").each(function() {
				data['proizvodid[]'].push($(this).val());
			});
			var link = $(this).attr('data-link');
            link = window.folder+"/"+link;	
			$.ajax({
				type: 'POST',
				url: link,
				data: data,
				success: function(data) {
					var klasa = $(data).attr('class');
					toastr[klasa](data);
					var link = window.folder+"/index.php";
					var param = window.param;
					table (link,param);

					$("#formTable input:checked").each(function() {
						$(this).removeAttr("checked");
					});
				}
			});
        });
		// dodavanje novog proizvoda u tip
		$("#dodajproiz").click(function() {
			var tip = $("#tipproizvodaid option:selected").val(); 
			var link = $(this).attr('data-link');
            link = window.folder+"/"+link;	
			var param = "mode=insert&tipproizvodaid="+tip;
			$.ajax({
				type: 'POST',
				url: link,
				data: param,
				success: function(data) {
					$('.backdrop').css("display", "block").html(data);
					modify_plugin();
					$('#inner .title-action #promeni').click(function() {
						var name = $(this).attr('name');
						modify(name);	
					})
				}	
			});
        });
		// selektovanje
		$("#selectall").click(function() {
			var m=0;
			if ($(this).is(":checked")) {
				$("#tabledivbody input:checkbox").each(function() {
					$(this).attr("checked", "true");
				});
			} else {
				$("#tabledivbody input:checkbox").each(function() {
					$(this).removeAttr("checked");
				});
			}
		});
		// obrisi sve selektovane
		$(".obrisi_sve_selektovane").click(function() {
			var data = {
				'proizvodid[]': []
			};
			$("#tabledivbody input:checked").each(function() {
				data['proizvodid[]'].push($(this).val());
			});
			var link = $(this).attr('data-link');
            link = window.folder+"/"+link;	

			$.ajax({
				type: 'POST',
				url: link,
				data: data,
				success: function(data) {
					var klasa = $(data).attr('class');
					toastr[klasa](data);
					var link = window.folder+"/index.php";
					var param = window.param;
					table (link,param);
				}
			});
		});
		move_rows();	
		$("#back").click(function() {
			$('a[data-class="product"]').trigger('click');
		})
	}


{/literal}
</script>



<div class="ibox float-e-margins">
	<div class="ibox-title">
		<div class="ibox-tools">
			<a class="collapse-link">
					<i class="fa fa-chevron-up"></i>
			</a>
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-wrench"></i>
			</a>

			<a class="close-link">
				<i class="fa fa-times"></i>
			</a>
		</div>
	</div>
	<div class="ibox-content">
		<input type="hidden" id="bproizvodid" value="{$proizvodid}">	
		<div class="row">
			<div class="col-lg-8">
				<div class="html5buttons">
					<div class="dt-buttons btn-group pr-buttons">
							<form name="dodajproiz"  method="POST" >
								<div class="btn btn-success buttons-html5" id="dodajproiz" data-link='modify.php' data-param='mode=insert'><i class="fa fa-plus-square-o" ></i> <span>{$PLG_ADD_INTRO_TYPE}</span></div>
								<select name="tipproizvodaid" class="form-control" id="tipproizvodaid">
									{html_options values=$tipproizvoda_val selected=$tipproizvoda_sel output=$tipproizvoda_out}
								</select> 
							</form>
							
							<form name="dodajugrupu" method="POST" class="html5buttons">
								<div class="btn btn-success buttons-html5 dodaj_sve_u_grupu" id="dodaj_sve_u_grupu" data-link='insert_grupa_multi.php'><i class="fa fa-plus-square-o" ></i> <span>{$PLG_ADD_INTRO_GROUP}</span></div> 
									{$parentgrpCmb}
								
							</form>



							
							<div data-link='delete_final_multi.php' class="btn btn-success buttons-html5 obrisi_sve_selektovane"><i class="fa fa-minus-square-o"></i> <span>{$PLG_DELETE_SELECTED}</span></div>

					</div>
				</div>
			</div>
			<div class="col-lg-4 pr-rec">	
				<form name="formRecordsPerPage" id="formRecordsPerPage">
					<label class="perpage">{$PLG_RESULTS_PER_PAGE} </label>
					<select class="form-control" name="records_per_page" '>
						{html_options values=$recordsPerPage_val selected=$recordsPerPage_sel output=$recordsPerPage_out}
					</select>
				</form> 
			</div>
		</div>
		
		<div class="table-responsive">
			<div id="content">
				
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
						exportlinks=$tbl_show_export_links
						message=$poruka			
					}		

			</div>
		</div>
	</div>
</div>

<script language="JavaScript" type="text/JavaScript">
{if $smarty.get.affected_categ_del}
	alert("{$PLG_SELECTION_CHANGE_CATEGORY} {$smarty.get.affected_categ_del}.");
{/if}
{if $smarty.get.affected_status_arh}
	alert("{$PLG_SELECTION_CHANGE_STAUS} {$smarty.get.affected_status_arh}.");
{/if}
</script>

