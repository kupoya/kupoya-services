<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// var_dump($strategy);
// echo '<br/><br/>';
// var_dump($microdeal);
// echo '<br/><br/>';
// var_dump($plan);
// echo '<br/><br/>';
// var_dump($blocks);
// echo '<br/><br/>';

if (isset($plan['plan_type']))
{
	// handle expiration 
	if ($plan['plan_type'] === 'expiration' && isset($strategy['expiration_date']))
	{
		$plan_type = 'expiration';
		// in expiration, plan_total means the unix timestamp of the expiration date
		$plan_total = @strtotime($strategy['expiration_date']);

		// and the plan_used will be the current timestamp
		$plan_used = time();

		$plan_used_percent = 0;
		if ($plan_used_percent != 0)
			$plan_used_percent = number_format(($plan_used / $plan_total), 2) * 100;

		$plan_available = ($plan_total - $plan_used);

		$plan_available_percent = 0;
		if ($plan_used_percent != 0)
			$plan_available_percent = number_format(($plan_available / $plan_total), 2) * 100;
	}

	// handle bank size
	if ($plan['plan_type'] === 'expiration')
	{
		$plan_type = 'bank';
	}
}

$data['strategy'] = $strategy;
$data['campaign'] = $campaign;

?>

		<!-- Article Content -->
		<section>

			<!-- Side Tab Content #sidetab1 -->
			<div class="sidetab default-sidetab" id="sidetab1">
				<h3><?php echo $strategy['name'] ?></h3>
			</div>

		<!-- /Article Content -->
		</section>


		<hr/>

		<!-- Strategy Widgets Information -->
		<!-- Widget Container -->
		<section id="widgets-container">
		
			<?php
				//echo Modules::run('strategy/strategy_widgets/_get_strategy_widgets', $data);
				echo Modules::run('microdeal/microdeal_widgets/_get_strategy_widgets', $data);
			?>
			
		</section>
		<!-- /Widget Container -->
		<!-- /Strategy Widgets Information -->

		<hr>
		<?php
			// graph for visits/redemptions
			//echo Modules::run('microdeal/microdeal_reports_overview/_widget_requests_graph', $data);

			// graph for exposure/redemptions
			echo Modules::run('microdeal/microdeal_reports_overview/_widget_redemptions_graph', $data);
		?>



<?php

	$strategy_graph_gender = base_url();
	$strategy_graph_age = base_url();
	$strategy_graph_redemption_returning_customer = base_url();
	$strategy_graph_customer_redemptions_profile = base_url();
	$strategy_graph_redemptions_foot_traffic = base_url();
	$strategy_graph_customer_friends_count_profile = base_url();

	if (isset($strategy['id']))
	{
		$strategy_graph_gender .= 'strategy/reports/demographics/get_by_gender/'.$strategy['id'];
		$strategy_graph_age .= 'strategy/reports/demographics/get_by_age/'.$strategy['id'];
		$strategy_graph_redemption_returning_customer .= 'microdeal/reports/overview/get_redemptions_per_returning_customer/'.$strategy['id'];
		$strategy_graph_customer_redemptions_profile .= 'microdeal/reports/overview/get_customer_redemption_profile/'.$strategy['id'];
		$strategy_graph_redemptions_foot_traffic .= 'microdeal/reports/overview/get_redemptions_foot_traffic/'.$strategy['id'];
		$strategy_graph_customer_friends_count_profile .= 'microdeal/reports/overview/get_customer_friends_count_profile/'.$strategy['id'];
	}

?>
			<!-- Begin Pie Chart By Day -->

					<!--Load the AJAX API-->
				    <script type="text/javascript">

				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(strategy_graph_gender);
				      
				    function strategy_graph_gender() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_gender; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 550, height: 400,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Deal claims grouped by gender',
				          titleTextStyle: {fontSize: 14},
				          colors: ['#395A99','#67AA28'],
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.PieChart(document.getElementById('chart1'));
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
				    google.setOnLoadCallback(strategy_graph_age);
				      
				    function strategy_graph_age() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_age; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 550, height: 400,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          legend: {position: 'none'},
				          title: 'Deal claims grouped by age',
				          titleTextStyle: {fontSize: 14},
				          colors: ['#395A99','#67AA28'],
				          hAxis: {title: 'Age groups', titleTextStyle: {color: 'black'}},
				          vAxis: {title: 'Deal claims', titleTextStyle: {color: 'black'}}
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.ColumnChart(document.getElementById('chart2'));
				      chart.draw(data, options);
				    }
				    </script>
				    <!--/Load the AJAX API-->


			<!-- Begin Pie Chart By Hour -->

					<!--Load the AJAX API-->
					
				    <script type="text/javascript">
				    /*
				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(strategy_graph_redemption_returning_customer);
				      
				    function strategy_graph_redemption_returning_customer() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_redemption_returning_customer; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 550, height: 400,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Redemptions per Returning Customer',
				          legend: {position: 'none'},
				          titleTextStyle: {fontSize: 14},
				          hAxis: {title: 'number of returning customers', titleTextStyle: {color: 'black'}},
				          vAxis: {title: 'redemptions count', titleTextStyle: {color: 'black'}}
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.ColumnChart(document.getElementById('chart3'));
				      chart.draw(data, options);
				    }
				    */
				    </script>
				    <!--/Load the AJAX API-->

			<!-- Begin Pie Chart By Hour -->

					<!--Load the AJAX API-->
				    <script type="text/javascript">
				    /*
				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(strategy_graph_customer_redemptions_profile);
				      
				    function strategy_graph_customer_redemptions_profile() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_customer_redemptions_profile; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 550, height: 400,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Customer Redemption Profile',
				          titleTextStyle: {fontSize: 14},
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.PieChart(document.getElementById('chart4'));
				      chart.draw(data, options);
				    }
				    */
				    </script>
				    <!--/Load the AJAX API-->


			<!-- Begin Pie Chart By Hour -->

					<!--Load the AJAX API-->
				    <script type="text/javascript">

				    // Load the Visualization API and the piechart package.
				    google.load('visualization', '1', {'packages':['corechart']});
				      
				    // Set a callback to run when the Google Visualization API is loaded.
				    google.setOnLoadCallback(strategy_graph_redemptions_foot_traffic);
				      
				    function strategy_graph_redemptions_foot_traffic() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_redemptions_foot_traffic; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 550, height: 400,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Deal claims grouped by day of week',
				          legend: {position: 'none'},
				          titleTextStyle: {fontSize: 14},
				          colors: ['#395A99','#67AA28'],
				          hAxis: {title: 'Day of week', titleTextStyle: {color: 'black'}},
				          vAxis: {title: 'Deal claims', titleTextStyle: {color: 'black'}}
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.ColumnChart(document.getElementById('chart5'));
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
				    google.setOnLoadCallback(strategy_graph_customer_friends_count_profile);
				      
				    function strategy_graph_customer_friends_count_profile() {

				      var jsonData = $.ajax({
				          url: "<?php echo $strategy_graph_customer_friends_count_profile; ?>",
				          type: 'POST',
				          dataType:"json",
				          async: false
			          }).responseText;
				          
				      // Create our data table out of JSON data loaded from server.
				      var data = new google.visualization.DataTable(jsonData);

				      // Chart options
					  var options = {
				          width: 550, height: 400,
				          //title: '<?php echo lang("strategy:requests_graph_title")?>'
				          title: 'Deal claims grouped by friend count',
				          legend: {position: 'none'},
				          titleTextStyle: {fontSize: 14},
				          colors: ['#395A99','#67AA28'],
				          hAxis: {title: 'Friends', titleTextStyle: {color: 'black'}},
				          vAxis: {title: 'Deal claims', titleTextStyle: {color: 'black'}}
				        };
				      
				      // Instantiate and draw our chart, passing in some options.
				      var chart = new google.visualization.ColumnChart(document.getElementById('chart6'));
				      chart.draw(data, options);
				    }
				    </script>
				    <!--/Load the AJAX API-->


		<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->

		<!-- Quarter Content Block -->
		<article class="half-block clearfix">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="chart5">
					</div>

				</section>
			
			</div>

		</article>



		<!-- Quarter Content Block -->
		<article class="half-block clearrm">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="chart6">
					</div>

				</section>
			
			</div>

		</article>

		<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->


		<!-- Quarter Content Block -->
		<article class="half-block clearfix">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="chart2">
					</div>

				</section>
			
			</div>

		</article>



		<!-- Quarter Content Block -->
		<article class="half-block clearrm">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="chart1">
					</div>

				</section>
			
			</div>

		</article>




		<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->

		<!-- Quarter Content Block -->
		<article class="half-block clearfix">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="chart4">
					</div>

				</section>
			
			</div>

		</article>



		<!-- Quarter Content Block -->
		<article class="half-block clearrm">

			<!-- Article Container for safe floating -->
			<div class="article-container">

				<!-- Article Content -->
				<section>

					<div id="chart3">
					</div>

				</section>
			
			</div>

		</article>





		<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->

	</section>
	<!-- /Article Content -->
