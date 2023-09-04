<script>
{literal}
	function table_plugin() {
		var link = window.folder+"/index.php";
		$("#formRecordsPerPage").change(function(){
			var rpp = $("#formRecordsPerPage option:selected").val();
			var param= "records_per_page=" + rpp;
			table(link,param);
		})
		
		move_rows();
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
					<div class="dt-buttons btn-group">
							<a class="btn btn-success buttons-html5" tabindex="0" href="modify.php?mode=insert">
								<i class="fa fa-file-text-o" ></i> <span>{$PLG_ADD}</span>
							</a>
					</div>
				</div>
			</div>

			<div class="col-lg-4 pr-rec">
				<form name="formRecordsPerPage" id="formRecordsPerPage">
					<label class="perpage">{$PLG_RESULTS_PER_PAGE} </label>
					<select class="form-control" name="records_per_page">
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
					exportlinks=$tbl_show_export_links
					table_attr='cellspacing=0 class="index" id="normal"'
					message=$poruka
				}


			</div>
		</div>
	</div>
</div>
