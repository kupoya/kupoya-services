<?php

	$strategy_graph_browser_url = base_url();
	$div_id = uniqid();

	if (isset($strategy['id']))
	{
		$strategy_graph_browser_url .= 'strategy/reports/mobile/browser_get_all/'.$strategy['id'];
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
				          url: "<?php echo $strategy_graph_browser_url; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 650, height: 340,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Browser Distribution'
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.PieChart(document.getElementById('pie_chart<?=$div_id?>'));
				      chart.draw(data, options);
				    }
				    </script>
				    <!--/Load the AJAX API-->


	<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->

		<!-- Quarter Content Block -->
		<article>

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="pie_chart<?=$div_id?>">
					</div>

				</section>
			
			</div>

		</article>


<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->