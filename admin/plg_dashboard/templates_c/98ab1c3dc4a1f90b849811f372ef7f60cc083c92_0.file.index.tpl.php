<?php
/* Smarty version 3.1.32, created on 2022-10-26 12:14:15
  from 'C:\wamp\www\taxicms\admin\plg_dashboard\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6359087772e1b5_98565387',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '98ab1c3dc4a1f90b849811f372ef7f60cc083c92' => 
    array (
      0 => 'C:\\wamp\\www\\taxicms\\admin\\plg_dashboard\\templates\\index.tpl',
      1 => 1666177686,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6359087772e1b5_98565387 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
>

	function timeConverter(v, axis){
	  v=v-0.1;
	  v=v.toFixed(0);		
	  if (v>12) v=v-12;
	  v=v-1;
	  var periods = <?php echo $_smarty_tpl->tpl_vars['periods']->value;?>

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
			<?php echo $_smarty_tpl->tpl_vars['visits_sum_period']->value;?>

			]
		};	
		$.plot($("#flot-bar-chart_visits"), [barData2], barOptions1);
		$.plot($("#flot-line-chart_visits"), [barData2], barOptions2);		
	}

<?php echo '</script'; ?>
>
<div class="wrapper wrapper-content">
        <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right"><?php echo $_smarty_tpl->tpl_vars['PLG_YEARLY']->value;?>
</span>
                                <h5><?php echo $_smarty_tpl->tpl_vars['PLG_NEWS']->value;?>
</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['news_count']->value;?>
</h1>
                                
                                <small><?php echo $_smarty_tpl->tpl_vars['PLG_TOTAL']->value;?>
</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right"><?php echo $_smarty_tpl->tpl_vars['PLG_MONTHLY']->value;?>
</span>
                                <h5><?php echo $_smarty_tpl->tpl_vars['PLG_ADMIN_LOGIN']->value;?>
</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['alog_count']->value;?>
</h1>
                               
                                <small><?php echo $_smarty_tpl->tpl_vars['PLG_TOTAL']->value;?>
</small>
                            </div>
                        </div>
                    </div>					
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right"><?php echo $_smarty_tpl->tpl_vars['PLG_YEARLY']->value;?>
</span>
                                <h5><?php echo $_smarty_tpl->tpl_vars['PLG_VISIT']->value;?>
</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['visit_count']->value;?>
</h1>
                               
                                <small><?php echo $_smarty_tpl->tpl_vars['PLG_TOTAL']->value;?>
</small>
                            </div>
                        </div>
                    </div>	
			</div>			

						
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $_smarty_tpl->tpl_vars['PLG_VISIT']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['lab_period']->value;?>
</h5>
				</div>
				<div class="ibox-content">
						<div class="flot-chart">
							<div class="flot-chart-content" id="flot-bar-chart_visits"></div>
						</div>
				</div>
			</div>
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $_smarty_tpl->tpl_vars['PLG_VISIT']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['lab_period']->value;?>
</h5>
				</div>
				<div class="ibox-content">

					<div class="flot-chart">
						<div class="flot-chart-content" id="flot-line-chart_visits"></div>
					</div>
				</div>
			</div>					
			
		
		
</div>		
	


 


<?php }
}
