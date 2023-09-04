
	<script type="text/javascript">
		{literal}
		function table_plugin() {
			
			$("#selectall").click(function(){
				if($(this).is(":checked"))
				{
					$("#formTable input:checkbox").each(function() {
  						$(this).attr("checked", "true");
  						});
  				}
  				else 
  				{
  					$("#formTable input:checkbox").each(function() {
  						$(this).removeAttr("checked");
  						});
  				}
			});
			// filtriranje
			var link = window.folder+"/index.php";
			$(".submitButton").click(function(){
				var word = $('#formTable #filter_value').val();
				var field = $('#formTable #filter_field option:selected').val();
				var param = "filter_value=" + word +"&filter_field="+ field + "&submitFilter=da";
				table(link,param);
			})
			
			$(".resetButton").click(function(){
				var param = "resetFilter=da";
				table(link,param);
			})
			
			$("#formRecordsPerPage").change(function(){
				var rpp = $("#formRecordsPerPage option:selected").val(); 
				var param= "records_per_page=" + rpp;
				table(link,param);
			})
			
			// dodavanje korisnika u rolu
			$(".dodaj_u_rolu").click(function(){
				var userRoleId = $("#userroleid").val();
				var userId = $(this).attr('data-param');
				var param = "userroleid=" + userRoleId +"&userid="+ userId;
				var link = $(this).attr('data-link');
				link = window.folder+"/"+link;
				$.ajax({  
            		type: "POST",  
            		url: link,  
            		data: param,
            		success: function(data){ 
						var klasa = $(data).attr('class');
						toastr[klasa](data);
						var link = window.folder+"/index.php";
						var param = window.param;
						table (link,param);						
            		}
            	});
			});

			// brisanje korisnika iz role
			$(".izbrisi_iz_role").click(function(){
				var userRoleId = $("#userroleid").val();
				var userId = $(this).attr('data-param');
				var param = "userroleid=" + userRoleId +"&userid="+ userId;
				var link = $(this).attr('data-link');
				link = window.folder+"/"+link;
				$.ajax({  
            		type: "POST",  
            		url: link,  
            		data: param,
            		success: function(data){ 
						var klasa = $(data).attr('class');
						toastr[klasa](data);
						var link = window.folder+"/index.php";
						var param = window.param;
						table (link,param);						
            		}
            	});
			});
			
			// dodavanje niza korisnika u grupu
			$("#dodaj_sve_u_rolu").click(function(){						
				var userRoleId = $("#userroleid").val();
				var data = { 'userid[]' : [] , 'userroleid' : userRoleId};
				
				$("#formTable input:checked").each(function() {
  					data['userid[]'].push($(this).val());
				});
				var link = $(this).attr('data-link');
                link = window.folder+"/"+link;
				$.ajax({
				  type: 'POST',
				  url: link,
				  data: data,
				  success: function(data){ 
				  	var klasa = $(data).attr('class');
					toastr[klasa](data);
					var link = window.folder+"/index.php";
					var param = window.param;
					table (link,param);						
            	  }
				});
				$("#formTable input:checked").each(function() {
						$(this).parent().parent().remove();
					});				
			});
		}
		{/literal}
	</script>
		

<div class="ibox float-e-margins">
	<div class="ibox-title">
		
		<div class="ibox-tools">
			<a class="collapse-link">
					<i class="fa fa-chevron-up"></i>
			</a>
			<a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>

			<a class="close-link">
				<i class="fa fa-times"></i>
			</a>
		</div>
	</div>
	<div class="ibox-content">
		<div class="row">
			<div class="col-lg-8">
				<div class="html5buttons">
					<div class="dt-buttons pr-buttons">
							<a class="btn btn-success html5buttons" tabindex="0" href="modify.php?mode=insert">
								<i class="fa fa-file-text-o" ></i> <span>{$PLG_ADD}</span>
							</a>
							<form name="dodajurolu" method="POST" class="html5buttons">
								<div data-link="add_to_role_multi.php" class="btn btn-success buttons-html5 dodaj_sve_u_rolu"  id="dodaj_sve_u_rolu"><i class="fa fa-plus-square-o" ></i> <span> {$PLG_USERROLE}</span></div>  
								<select name="userroleid" id="userroleid" class="form-control" >
									{html_options values=$userrole_val selected=$userrole_sel output=$userrole_out}
								</select>
							</form>
							
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
		<form action="index.php" method="POST" name="formTable" id="formTable" class="pages">
			
			<div id="filter" class="form-inline">
				 <div class="form-group">
					 <label for="naziv" >{$PLG_FILTER}</label>
					 <input name="filter_value" id="filter_value" value="{$login_filter_value}"  type="text"  class="form-control" placeholder="{$PLG_INSERT}" />
				 </div>
				 <div class="form-group">
					 <label for="polje" class="sr-only">Izaberi opciju</label>
					 <select name="filter_field" id="filter_field" size="1" class="form-control" >
						<option value="namesurname">{$PLG_NAME}</option>					 
						<option value="firm">{$PLG_FIRM}</option>					 
						<option value="place">{$PLG_PLACE}</option>
						<option value="email">{$PLG_EMAIL}</option>

					</select>
				</div>				
					<div  class="submitButton btn btn-primary" name="submitFilter">{$PLG_FILTER_DO}</div>
					<div  class="resetButton btn btn-danger" name="resetFilter">{$PLG_RESET}</div>
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
		</form>				
	</div>
</div>

		<script language="JavaScript" type="text/JavaScript">
		{if $insertrole eq "true"}
			alert("{$PLG_HEADERADD_SUCCESS}");
		{/if}
		{if $insertrole eq "false"}
			alert("{$PLG_HEADERADD_FAILED}");
		{/if}
		</script>
		
