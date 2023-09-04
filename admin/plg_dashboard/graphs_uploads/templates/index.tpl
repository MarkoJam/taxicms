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
			{/literal}{$uploads_sum_period}{literal}
			]
		};	
		
		$.plot($("#flot-bar-chart_uploads"), [barData2], barOptions1);
		$.plot($("#flot-line-chart_uploads"), [barData2], barOptions2);		
	}
{/literal}
</script>
<div class="wrapper wrapper-content">

			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>UPLOADS / {$lab_period}</h5>
				</div>
				<div class="ibox-content">
						<div class="flot-chart">
							<div class="flot-chart-content" id="flot-bar-chart_uploads"></div>
						</div>
				</div>
			</div>
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>UPLOADS / {$lab_period}</h5>
				</div>
				<div class="ibox-content">

					<div class="flot-chart">
						<div class="flot-chart-content" id="flot-line-chart_uploads"></div>
					</div>
				</div>
			</div>					
		
</div>		
	


 


