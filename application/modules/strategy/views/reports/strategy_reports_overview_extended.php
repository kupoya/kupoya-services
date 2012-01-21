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
			<!-- Begin Pie Chart By Day -->

					<!--Load the AJAX API-->
				    <script type="text/javascript">

				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(drawChartPie_Day);
				      
				    function drawChartPie_Day() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_overview_by_day; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 350, height: 240,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Requests Grouped by Day'
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.PieChart(document.getElementById('pie_chart1'));
				      chart.draw(data, options);
				    }
				    </script>
				    <!--/Load the AJAX API-->



			<!-- Begin Pie Chart By Hour -->

					<!--Load the AJAX API-->
				    <script type="text/javascript">

				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(drawChartPie_Hour);
				      
				    function drawChartPie_Hour() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_overview_by_hour; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 350, height: 240,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Requests Grouped by Hour'
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.PieChart(document.getElementById('pie_chart2'));
				      chart.draw(data, options);
				    }
				    </script>
				    <!--/Load the AJAX API-->


			<!-- Begin Pie Chart By Month -->

					<!--Load the AJAX API-->
				    <script type="text/javascript">

				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(drawChartPie_Month);
				      
				    function drawChartPie_Month() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_overview_by_month; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 350, height: 240,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Requests Grouped by Month'
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.PieChart(document.getElementById('pie_chart3'));
				      chart.draw(data, options);
				    }
				    </script>
				    <!--/Load the AJAX API-->
					


<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->

		<!-- Quarter Content Block -->
		<article class="third-block clearfix">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="pie_chart3">
					</div>

				</section>
			
			</div>

		</article>


		<!-- Quarter Content Block -->
		<article class="third-block clearrm">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="pie_chart2">
					</div>


				</section>
			
			</div>

		</article>



		<!-- Quarter Content Block -->
		<article class="third-block clearrm">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="pie_chart1">
					</div>

				</section>
			
			</div>

		</article>
