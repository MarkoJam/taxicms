	<style>
	.editable input 
	{ldelim}
		width: 80px;
	{rdelim}
	</style>



<script>
{literal}

	function unix_time(x) {
		var x = x.getTime()/1000; 
		var x = x.toFixed(0);
		return x;
	}
	function cb(start, end) {
		$('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
	}
	function prepare_param () {
		var par = "";
		$('select').each(function() {	
			var name = $(this).attr('name');
			$(this).attr('id', name);
			var x1 = "#"+name+' option:selected';
			var val = $(x1).val();
			par = par + "&" + name + "=" + val;
		});						
		var sd = unix_time($('#reportrange').data('daterangepicker').startDate._d);		
		window.start=$('#reportrange').data('daterangepicker').startDate	;	
		var ed = unix_time($('#reportrange').data('daterangepicker').endDate._d);			
		window.end=$('#reportrange').data('daterangepicker').endDate	;			
		var range = $('#reportrange span').html();
		var param = par + "&start="+ sd +"&end=" + ed + "&range=" + range;
		return param;
	}	
	
	
	function table_plugin() {
	
		// filtriranje
		var link = window.folder+"/index.php";

		// records per page change			
		$(".records_per_page").change(function(){alert ('xxx');
			var start = moment().subtract(364, 'days');
			var end = moment();
			$('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
			var param = prepare_param();
			window.param=param;
			table(link,param);
		})
		// newsletter change
		$('#newsletterid').change(function() {
			var param = prepare_param();
			window.param=param;
			table(link,param);			
		});
		// date picker
		$('#reportrange').on('apply.daterangepicker', function() {
			var param = prepare_param();
			window.param=param;
			table(link,param);
		}); 			

	
		if (window.start) var start = window.start ;
		else var start = moment().subtract(364, 'days');
		if (window.end) var end = window.end;
		else var end = moment();
		

		$('#reportrange').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
			   'Today': [moment(), moment()],
			   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			   'Last 7 days': [moment().subtract(6, 'days'), moment()],
			   'Last 30 days': [moment().subtract(29, 'days'), moment()],
			   'Last 365 days': [moment().subtract(364, 'days'), moment()],			   
			   'This month': [moment().startOf('month'), moment().endOf('month')],
			   'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			locale: {
			'separator': ' - ',
			}
		}, cb);
		if ($('#reportrange span').is(':empty')) cb(start, end);
	}	
{/literal}
</script>

<h1 id='main_title'></h1>
<p id='main_description'></p>

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
		<form name="formHeader">
			<div class="col-lg-4 left newsletter-sel">
				<label class="daterange pull-left">Newsletter: </label>
				<select id="newsletterid" name="newsletterid"  class="form-control" >
					{html_options values=$newsletter_val selected=$newsletter_sel output=$newsletter_out}
				</select>
			</div>
			<div class="col-lg-4 left">
				<label class="daterange pull-left">{$PLG_DATE_RANGE}</label>
				<div id="reportrange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
					<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
					<span>{$range}</span> <b class="caret"></b>
				</div>
			</div>
			<div class="col-lg-4 pr-rec">
				<label class="perpage">{$PLG_RESULTS_PER_PAGE} </label>
				<select class="records_per_page" name="records_per_page" >
					{html_options values=$recordsPerPage_val selected=$recordsPerPage_sel output=$recordsPerPage_out}
				</select>
			</div>
		</form>
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
						message=$poruka
					}

			</div>
		</div>	
	</div>
</div>