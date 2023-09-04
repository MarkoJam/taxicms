	<script>
	{literal}
		function unix_time(x) {
			var x = x.getTime()/1000;
			var x = x.toFixed(0);
			return x;
		}

		function prepare_param () {
			$('#formTable').load("loader.php");
			var par = "";
			$('select').each(function() {
				var name = $(this).attr('name');
				var val = $(this).find('option:selected').val();
				par = par + "&" + name + "=" + val;
			});
			window.sd=$('#reportrange').data('daterangepicker').startDate;
			window.ed=$('#reportrange').data('daterangepicker').endDate;
			var sd = unix_time(window.sd._d);
			var ed = unix_time(window.ed._d);
			var param = par + "&start="+ sd +"&end=" + ed;
			var range=window.sd.format('DD/MM/YYYY') + ' - ' + window.ed.format('DD/MM/YYYY');
			var param = param + '&range='+ range;
			return param;
		}
		function table_prepare() {
			var param = prepare_param();
			var link = window.folder+"/index.php";
			table (link,param);	//vracanje na tabelu u index.php-u , normalan slucaj
		}
		function cb(start, end) {
			var range1=$('#range').val();
			if (range1=='') var range=start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY');
			else var range=range1;
			$('#reportrange span').html(range);
		}

		function table_plugin() {

			var start = moment().subtract(29, 'days');
			var end = moment();
			$('#reportrange').daterangepicker({
				startDate: start,
				endDate: end,
				ranges: {
				   'Danas': [moment(), moment()],
				   'Juče': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				   'Proteklih 7 dana': [moment().subtract(6, 'days'), moment()],
				   'Proteklih 30 dana': [moment().subtract(29, 'days'), moment()],
				   'Ovaj mesec': [moment().startOf('month'), moment().endOf('month')],
				   'Prošli mesec': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				locale: {
				'daysOfWeek': ['Ned','Pon','Uto','Sre','Čet','Pet','Sub'],
				'monthNames': ['Januar','Februar','Mart','April','Maj','Juni','Juli','Avgust','Septembar','Oktobar','Novembar','Decembar'],
				'format': 'DD/MM/YYYY',
				'separator': ' - ',
				'applyLabel': 'Primeni',
				'cancelLabel': 'Odustani',
				'fromLabel': 'Od',
				'toLabel': 'Do',
				'customRangeLabel': 'Izaberi opseg'
				}
			}, cb);

			cb(start, end);

			// dogadjaji iz zaglavlje - bez ponovnog postavljanja
			// records per page change
			$('.perpage').change(function() {table_prepare() });
			// newsletter change
			$('#newsletterid').change(function() {table_prepare() });
			// date picker
			$('#reportrange').on('apply.daterangepicker', function() {table_prepare()});
		};
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


	<form name="formHeader">
		<div class="row">

			<input type='hidden' id='range' name='range' value='{$range}'/>
			<div class="col-lg-8"></div>
			<div class="col-lg-4 pr-rec">
					<label class="perpage">{$PLG_RESULTS_PER_PAGE} </label>
					<select name="records_per_page" class="form-control" onChange='formHeader.submit();'>
						{html_options values=$recordsPerPage_val selected=$recordsPerPage_sel output=$recordsPerPage_out}
					</select>
				</div>
		</div>
			<div class="row">
				<div class="col-lg-6 ">
						<label class="perpage">Newsletter </label>

					<select id="newsletterid" name="newsletterid"  class="form-control">
						{html_options values=$newsletter_val selected=$newsletter_sel output=$newsletter_out}
					</select>
				</div>
				<div class="col-lg-6 ">
					<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 8px 10px; border: 1px solid #e5e6e7;margin-top:20px;">
					<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
					<span></span> <b class="caret"></b>
				</div>
				</div>
			</div>
	</form>
	<div class="table-responsive">
		<div id="content">

		<form action="index.php" method="POST" id="formTable" name="formTable">
			{html_table_advanced
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
				message='Proba'
				table_attr='cellspacing=0 class="index" id="normalpreglediproiz"'
				exportlinks=$tbl_show_export_links
				message=$poruka
			}
		<div class="sum_count">Ukupno pregleda: <span>{$sum_count}</span></div>
		</form>
	</div>
</div>
</div>
</div>
