<script>
{literal}
	function timeConverter(v, axis){
	  v=v-0.1;
	  v=v.toFixed(0);		
	  if (v>12) v=v-12;
	  v=v-1;
	  var periods = {/literal}{$periods}{literal}
	  var period = periods[v];	  
	  var time = period ;
	  return time;
	}
	
	function table_plugin() {
		$('#post').change(function() {
			var post=$('#post option:selected').val();
			var param = 'plugin='+post;
			window.param=param;
			window.folder='plg_dashboard/posts';
			$('#title').html($('#post option:selected').text()); // naslovi za desno
			$('#title2').html($('#post option:selected').text());
			table('plg_dashboard/posts/index.php',param);			
		});	
		$('#graph_uploads').change(function() {
			var post=$('#graph_uploads option:selected').val();
			var param = 'plugin='+post;
			window.param=param;
			window.folder='plg_dashboard/graphs_uploads';
			$('#title').html($('#graph_uploads option:selected').text()); // naslovi za desno
			$('#title2').html($('#graph_uploads option:selected').text());
			table('plg_dashboard/graphs_uploads/index.php',param);			
		});			
		$('#graph_views').change(function() {
			var post=$('#graph_views option:selected').val();
			var param = 'plugin='+post;
			window.param=param;
			window.folder='plg_dashboard/graphs_views';
			$('#title').html($('#graph_views option:selected').text()); // naslovi za desno
			$('#title2').html($('#graph_views option:selected').text());
			table('plg_dashboard/graphs_views/index.php',param);			
		});				
		$('#users_report').click(function() {
			window.folder='plg_dashboard/users';
			$('#title').html($(this).text()); // naslovi za desno
			$('#title2').html($(this).text());
			table('plg_dashboard/users/index.php',param);			
		});			
	
		var barOptions1 = {
			series: {
				bars: {
					show: true,
					barWidth: 0.6,
					fill: true,
					fillColor: {
						colors: [{
							opacity: 0.8
						}, {
							opacity: 0.8
						}]
					}
				}
			},
			xaxis: {
				tickFormatter: timeConverter
			},
			colors: ["#1ab394"],
			grid: {
				color: "#999999",
				hoverable: true,
				clickable: true,
				tickColor: "#D4D4D4",
				borderWidth:0
			},
			legend: {
				show: false
			},
			tooltip: true,
			tooltipOpts: {
				content: "x: %x, y: %y"
			}
		};
		
		var barOptions2 = {
			series: {
				lines: {
					show: true,
					lineWidth: 2,
					fill: true,
					fillColor: {
						colors: [{
							opacity: 0.0
						}, {
							opacity: 0.0
						}]
					}
				}
			},
			xaxis: {
				tickFormatter: timeConverter
			},
			colors: ["#1ab394"],
			grid: {
				color: "#999999",
				hoverable: true,
				clickable: true,
				tickColor: "#D4D4D4",
				borderWidth:0
			},
			legend: {
				show: false
			},
			tooltip: true,
			tooltipOpts: {
				content: "x: %x, y: %y"
			}
		};	
		
		var barData2 = {
			label: "bar",
			data: [
			{/literal}{$visits_sum_period}{literal}
			]
		};	
		$.plot($("#flot-bar-chart_visits"), [barData2], barOptions1);
		$.plot($("#flot-line-chart_visits"), [barData2], barOptions2);		
	}
{/literal}
</script>
<div class="wrapper wrapper-content">
        <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">{$PLG_YEARLY}</span>
                                <h5>{$PLG_NEWS}</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{$news_count}</h1>
                                
                                <small>{$PLG_TOTAL}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">{$PLG_MONTHLY}</span>
                                <h5>{$PLG_ADMIN_LOGIN}</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{$alog_count}</h1>
                               
                                <small>{$PLG_TOTAL}</small>
                            </div>
                        </div>
                    </div>					
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">{$PLG_YEARLY}</span>
                                <h5>{$PLG_VISIT}</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{$visit_count}</h1>
                               
                                <small>{$PLG_TOTAL}</small>
                            </div>
                        </div>
                    </div>	
			</div>			

			{*combo box za postove
			<div class="row ibox">
				<div class="col-sm-3">
					<select id="graph_uploads" name="graph_uploads" class="form-control">
						<option value='empty'>{$PLG_CHOOSE} / {$PLG_GRAPH} (Uploads)</option>
						{html_options values=$resources_val output=$resources_out }  
					</select>							
				</div>		
				<div class="col-sm-3">
					<select id="graph_views" name="graph_views" class="form-control">
						<option value='empty'>{$PLG_CHOOSE} / {$PLG_GRAPH} ({$PLG_VIEWS})</option>
						{html_options values=$resources_val output=$resources_out }  
					</select>							
				</div>					
			</div>				
			*}
			
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>{$PLG_VISIT} / {$lab_period}</h5>
				</div>
				<div class="ibox-content">
						<div class="flot-chart">
							<div class="flot-chart-content" id="flot-bar-chart_visits"></div>
						</div>
				</div>
			</div>
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>{$PLG_VISIT} / {$lab_period}</h5>
				</div>
				<div class="ibox-content">

					<div class="flot-chart">
						<div class="flot-chart-content" id="flot-line-chart_visits"></div>
					</div>
				</div>
			</div>					
			
		
		
</div>		
	


 


