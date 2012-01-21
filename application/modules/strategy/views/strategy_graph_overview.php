<?php

	$strategy_graph_overview_url = base_url();
	$strategy_graph_overview_by_day = base_url();
	$strategy_graph_overview_by_hour = base_url();
	$strategy_graph_overview_by_month = base_url();

	if (isset($strategy['id']))
	{
		$strategy_graph_overview_url .= 'strategy/reports/overview/get_requests_graph_data/'.$strategy['id'];
		$strategy_graph_overview_by_day .= 'strategy/reports/overview/get_strategy_requests_agg_by/day/'.$strategy['id'];
		$strategy_graph_overview_by_hour .= 'strategy/reports/overview/get_strategy_requests_agg_by/hour/'.$strategy['id'];
		$strategy_graph_overview_by_month .= 'strategy/reports/overview/get_strategy_requests_agg_by/month/'.$strategy['id'];
	}

?>

			<!-- Begin Overview Line Chart -->

				    <!--Load the AJAX API-->
				    <script type="text/javascript">
				    
				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(drawChart);
				      
				    function drawChart() {

				      var v1 = $('input[name=date_start]');
				      var v2 = $('input[name=date_end]');

				      mydata = 'date_start='+v1.val()+'&date_end='+v2.val();

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_overview_url; ?>",
				          type: 'POST',
				          dataType:"json",
				          data: mydata,
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: "100%", height: 240,
				          title: '<?php echo lang("strategy:requests_graph_title")?>'
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				      chart.draw(data, options);
				    }

				    </script>
				    <!--/Load the AJAX API-->
					<div id="chart_div">
					</div>
				    <form name="strategy_report_form" action="#">
					    <dl>
						    <dt>
								<label>Range: </label>
							</dt>
							<dd>
								<label>From </label>
								<input type="text" class="datepicker tiny" name="date_start">
								<label>To </label>
								<input type="text" class="datepicker tiny" name="date_end">
								<a class="button" href="javascript:drawChart()">Apply</a>
							</dd>
							<dt>
								<label>Type: </label>
							</dt>
							<dd>
								<input type="radio" name="type" value="date" checked /> Date
							</dd>

						</dl>
					</form>


<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->