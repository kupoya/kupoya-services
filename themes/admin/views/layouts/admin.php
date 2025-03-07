<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<title>
		<?php echo isset($template['title']) ? $template['title'] : 'kupoya services'; ?>
	</title>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="<?= base_url() ?>favicon.ico">
	<link rel="apple-touch-icon" href="<?= base_url() ?>apple-touch-icon.png">
	
	<?php echo $template['metadata']; ?>
	<?php //echo $template['partials']['metadata']; ?>

	<!-- CSS Styles
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/colors.css">
	<link rel="stylesheet" href="css/jquery.tipsy.css">
	<link rel="stylesheet" href="css/jquery.wysiwyg.css">
	<link rel="stylesheet" href="css/jquery.datatables.css">
	<link rel="stylesheet" href="css/jquery.nyromodal.css">
	<link rel="stylesheet" href="css/jquery.datepicker.css">
	<link rel="stylesheet" href="css/jquery.fileinput.css">
	<link rel="stylesheet" href="css/jquery.fullcalendar.css">
	<link rel="stylesheet" href="css/jquery.visualize.css">
	-->
	<?=	theme_css('style.css'); ?>
	<?=	theme_css('colors.css'); ?>
	<?=	theme_css('jquery.tipsy.css'); ?>
	<?=	theme_css('jquery.wysiwyg.css'); ?>
	<?=	theme_css('jquery.datatables.css'); ?>
	<?=	theme_css('jquery.nyromodal.css'); ?>
	<?=	theme_css('jquery.datepicker.css'); ?>
	<?=	theme_css('jquery.fileinput.css'); ?>
	<?=	theme_css('jquery.fullcalendar.css'); ?>
	<?=	theme_css('jquery.visualize.css'); ?>

	<!-- Google WebFonts -->
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>

	<!--
	<script src="js/libs/modernizr-1.7.min.js"></script>
	-->

	<!-- JS Libs at the end for faster loading -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="js/jquery/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<?=	theme_js('libs/modernizr-1.7.min.js'); ?>
</head>

<!-- Add class .fixed for fixed layout. You would need also edit CSS file for width -->
<body>
	<!-- Fixed Layout Wrapper -->
	<div class="fixed-wraper">

	<!-- Aside Block -->
	<section role="navigation">
		<!-- Header with logo and headline -->
		<header>
			<a href="<?= base_url() ?>" title="Back to Homepage"></a>
			<?php //echo isset($template['partials']['header']) ? $template['partials']['header'] : '' ?>
		</header>
		
		<!-- User Info -->
		<section id="user-info">
			<img src="<?php $brand_picture = kupoya_operator('brand_picture'); if (!is_array($brand_picture)) echo base_url($brand_picture); ?>"
					alt="Sample User Avatar">
			<div>
				<a href="<?= site_url('brand/edit_brand_profile'); ?>" title="Account Settings and Profile Page">
					<?php $name = kupoya_operator('name'); if (!is_array($name)) echo $name; ?>
				</a>
				<em><?php //$brand_name = kupoya_operator('brand_name'); if (!is_array($brand_name)) echo $brand_name; ?></em>
				<ul>
					<li><a class="button-link" href="<?= site_url('operator/change_password'); ?>" rel="">change password</a></li>
					<br/>
					<li><a class="button-link" href="<?= site_url('auth/logout'); ?>" rel="">sign-out</a></li>
				</ul>
			</div>
		</section>
		<!-- /User Info -->
		
		<!-- Main Navigation -->
		<nav id="main-nav">
			<ul>
			<?php
			/*
				<li><a href="<?= base_url() ?>" title="" class="dashboard no-submenu"><?=lang('menu:dashboard');?></a></li> <!-- Use class .no-submenu to open link instead of a sub menu-->
				<!-- Use class .current to open submenu on page load -->
			*/
			?>
				<li class="<?= (isset($menu['context']) && $menu['context'] == 'campaigns') ? 'current' : '' ?>">
					<a href="" title="" class="events"><?=lang('menu:dashboard');?></a>
					<ul>
						<li class="<?= (isset($menu['page']) &&  $menu['page'] == 'my_campaigns') ? 'current' : '' ?>"><a href="<?= base_url() . 'strategy/manage/index'?>" title=""><?=lang('menu:campaigns:campaign_selection');?></a></li>
						<!--
						<li class="<?= (isset($menu['page']) &&  $menu['page'] == 'new_campaign') ? 'current' : '' ?>"><a href="<?= base_url() . 'strategy/manage/create'?>" title=""><?=lang('menu:campaigns:new_campaign');?></a></li>
						-->
					</ul>
				</li>
			<?php
			/*
				<li>
					<a href="" title="" class="projects">Projects</a><span title="You have 3 new tasks">3</span>
					<ul>
						<li class=""><a href="index.html" title="">Sample Index Page</a></li>
						<li><a href="401.html" title="">Error 401</a></li>
						<li><a href="403.html" title="">Error 403</a></li>
						<li><a href="404.html" title="">Error 404</a></li>
						<li><a href="500.html" title="">Error 500</a></li>
						<li><a href="503.html" title="">Error 503</a></li>
						<li><a href="login.html" title="">Sample Login Page</a></li>
					</ul>
				</li>
				<li class="<?= (isset($menu['context']) && $menu['context'] == 'account') ? 'current' : '' ?>">
					<a href="" title="" class="settings"><?= lang('menu:account')?></a>
					<ul>
						<li class="<?= (isset($menu['page']) &&  $menu['page'] == 'my_brands') ? 'current' : '' ?>">
							<a href="<?= base_url().'brand/edit_brand'?>" title=""><?= lang('menu:account:my_brands')?></a></li>
						<li class="<?= (isset($menu['page']) &&  $menu['page'] == 'Profile') ? 'current' : '' ?>">
							<a href="<?= base_url().'operator/view_contact'?>" title=""><?= lang('menu:account:profile')?></a></li>
					</ul>
				</li>
				<li><a href="" title="" class="gallery">Image Gallery</a><span title="You have 47 new tasks">47</span></li>
			*/
			?>

				<li><a href="<?=site_url('create_new_campaign')?>" title="" class="dashboard no-submenu"><?=lang('menu:Create_new_campaign')?></a></li>

				<li><a href="<?=site_url('contact_page')?>" title="" class="gallery no-submenu"><?=lang('menu:support:contact')?></a></li>
			<?php
			/*
				<li class="<?= (isset($menu['context']) && $menu['context'] == 'support') ? 'current' : '' ?>">
					<a href="" title="" class="articles"><?= lang('menu:support')?></a>
					<ul>
						<li><a href="http://www.kupoya.com/aboutus/contact-us/" title=""><?= lang('menu:support:contact')?></a></li>
						<li><a href="http://www.kupoya.com/strategies/see-what-we-can-do-with-our-codes/" title=""><?= lang('menu:support:examples')?></a></li>
						<li><a href="http://www.kupoya.com/faq/" title=""><?= lang('menu:support:faq')?></a></li>
					</ul>
				</li>
			*/
			?>
				
			</ul>
		</nav>
		<!-- /Main Navigation -->
		
		<!-- Sidebar -->
		<?php
		/*
		<section class="sidebar nested"> <!-- Use class .nested for diferent style -->
			<h2>Nested Section</h2>
			<p>Lorem ipsum dolor sit amet, conse ctetur adipiscing elit. Maec enas id augue ac metu aliquam.</p>
			<p>Sed pharetra placerat est suscipit sagittis. Phasellus <a href="#">aliquam</a> males uada blandit. Donec adipiscing sem erat.</p>
		</section>
		<!-- /Sidebar -->
		*/
		?>

		
		<!-- Sidebar -->
		<?php
		/*
		<section class="sidebar">
			<h2>Paragraph with Separator</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus.</p>
			<p class="separator">Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis.</p>
			<p class="separator">Phasellus aliquam malesuada blandit. Donec adipiscing sem erat.</p>
			<a class="button-link" href="#" title="This is my title!">read more</a>
		</section>
		<!-- /Sidebar -->
		
		<!-- Sidebar -->
		<section class="sidebar">
			<!-- <img src="img/sample_image.jpg" alt="Sample Image"> -->
			<h2>Lorem Ipsum Header</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat.</p>
			<a class="button-link" href="#" title="This is my title!">super long read more link</a>
		</section>
		<!-- /Sidebar -->
		
		<!-- Sidebar -->
		<section class="sidebar separator">
			<h2>Section with Separator</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis.</p>
			<ul>
				<li><strong>Sed pharetra placerat</strong></li>
				<li><em>Phasellus aliquam malesuada</em></li>
				<li>Maecenas id augue</li>
				<li>Consectetur <a href="#">adipiscing</a> elit</li>
				<li>Lorem ipsum dolor</li>
			</ul>
		</section>
		<!-- /Sidebar -->
		*/
		?>

	</section>
	<!-- /Aside Block -->
	
	<!-- Main Content -->
	<section role="main">

		<!-- Full Content Block -->
		<!-- Note that only 1st article need clearfix class for clearing -->
		<article class="full-block clearfix">
			<!-- Notifications -->
			<?php echo $template['partials']['notifications']; ?>
			<!-- /Notifications -->

			<!-- Article Container for safe floating -->
			<div class="article-container">		
				<?php echo $template['body']; ?>
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Full Content Block -->

<?php
/*
		<!-- Widget Container -->
		<section id="widgets-container">
		
			<!-- Widget Box -->
			<div class="widget increase" id="new-visitors">
				<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
				<span>increase</span>
				<p><strong>+35,18<sup>%</sup></strong> +2489 new visitors</p>
			</div>
			<!-- /Widget Box -->
			
			<!-- Widget Box -->
			<div class="widget decrease" id="new-orders">
				<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
				<span>decrease</span>
				<p><strong>-12,50<sup>%</sup></strong> -311 new orders</p>
			</div>
			<!-- Widget Box -->
			
			<!-- /Widget Box -->
			<div class="widget increase" id="new-tasks">
				<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
				<span>7</span>
				<p><strong>Tasks</strong> +3 New Tasks</p>
			</div>
			<!-- Widget Box -->
			
			<!-- /Widget Box -->
			<div class="widget text-only" id="text-widget">
				<a href="#" class="close-widget" title="Hide Widget" rel="tooltip">x</a>
				<p><strong>Text Only App</strong> +29 Lorem Ipsum</p>
			</div>
			<!-- /Widget Box -->
			
			<!-- Add New Widget Box -->
			<div class="widget add-new-widget">
				<a href="#">
					<span>Add</span>
					<strong>Add Widget</strong>
				</a>
			</div>
			<!-- /Add New Widget Box -->
			
		</section>
		<!-- /Widget Container -->
		
		<!-- Breadcumbs -->
		<ul id="breadcrumbs">
			<li><a href="/" title="Back to Homepage">Back to Home</a></li>
			<li><a href="#">Projects</a></li>
			<li><a href="#">Project's Assets</a></li>
			<li><a href="#">Edit Assets</a></li>
			<li>Current Page</li>
		</ul>
		<!-- /Breadcumbs -->
		
		<!-- Full Content Block -->
		<!-- Note that only 1st article need clearfix class for clearing -->
		<article class="full-block clearfix">
		
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2>Chromatron Admin Theme</h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch">
							<li><a class="default-tab" href="#tab0" rel="tooltip" title="Switch to next tab">Graphs</a></li>
							<li><a href="#tab1" rel="tooltip" title="Switch to next tab">Basic Typo</a></li>
							<li><a href="#tab2" rel="tooltip" title="Switch to next tab">Table and form</a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
				
					<!-- Tab Content #tab0 -->
					<div class="tab default-tab" id="tab0">
						<h3>Data visualization</h3>
						<table class="data" data-chart="line">
							<thead>
								<tr>
									<td></td>
									<th scope="col">food</th>
									<th scope="col">auto</th>
									<th scope="col">household</th>
									<th scope="col">furniture</th>
									<th scope="col">kitchen</th>
									<th scope="col">bath</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">Mary</th>
									<td>190</td>
									<td>160</td>
									<td>40</td>
									<td>120</td>
									<td>30</td>
									<td>70</td>
								</tr>
								<tr>
									<th scope="row">Tom</th>
									<td>3</td>
									<td>40</td>
									<td>30</td>
									<td>45</td>
									<td>35</td>
									<td>49</td>
								</tr>
								<tr>
									<th scope="row">Brad</th>
									<td>10</td>
									<td>180</td>
									<td>10</td>
									<td>85</td>
									<td>25</td>
									<td>79</td>
								</tr>
								<tr>
									<th scope="row">Kate</th>
									<td>40</td>
									<td>80</td>
									<td>90</td>
									<td>25</td>
									<td>15</td>
									<td>119</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- /Tab Content #tab0 -->
				
					<!-- Tab Content #tab1 -->
					<div class="tab" id="tab1">
						<h3>This is the second tab</h3>
						
						<!-- Image Minimenu Actions -->
						<div class="image-frame right">
							<img src="img/sample_image_large.jpg" alt="Sample Image">
							<ul class="image-actions">
								<li class="view"><a href="#">View</a></li>
								<li class="delete"><a href="#">Delete</a></li>
							</ul>
						</div>
						<!-- /Image Minimenu Actions -->
						
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat. Nunc at dui id purus lacinia tincidunt sit amet vel erat. Quisque congue urna ut <a class="button-link" href="#sample" rel="modal">open modal</a> sodales. Sed neque leo, elementum id malesuada id, consequat et erat. Maecenas lorem mauris, consequat ornare elementum adipiscing, tristique eu eros. Nulla sodales, tellus id porta condimentum, purus tortor faucibus orci, et interdum dui purus quis massa.</p>
						<ul>
							<li>Lorem ipsum dolor sit amet</li>
							<li>Suspendisse et dignissim metus</li>
							<li>Maecenas id augue ac metus tempus</li>
							<li>Sed pharetra placerat est suscipit</li>
							<li>Phasellus aliquam males</li>
							<li>Nunc at dui id purus lacinia tincidunt</li>
						</ul>
					</div>
					<!-- /Tab Content #tab1 -->
					
					<!-- Tab Content #tab2 with class. sidetabs for side tabs container -->
					<div class="tab sidetabs" id="tab2">
						<!-- Side Tab Navigation -->
						<nav class="sidetab-switch">
							<ul>
								<li><a class="default-sidetab" href="#sidetab1">Table</a></li>
								<li><a href="#sidetab2">Form</a></li>
								<li><a href="#sidetab3">Goodies</a></li>
							</ul>
							<p>Aenean facilisis ligula eget orci adipiscing varius. Curabitur sem ligula, egestas vel bibendum sed, sodales eu nulla. Vestibulum luctus aliquam feugiat. Donec porta interdum placerat.</p>
						</nav>
						<!-- /Side Tab Navigation -->
						
						<!-- Side Tab Content #sidetab1 -->
						<div class="sidetab default-sidetab" id="sidetab1">
							<h3>Table with jQuery.dataTables</h3>

							<table class="datatable">
								<thead>
									<tr>
										<th>id</th>
										<th>Serial Number That is Used</th>
										<th>status</th>
										<th>user_id </th>
										<th>purchased_time</th>
										<th>Strategy Id</th>
									</tr>
								</thead>
							</table>

							<h3 class="clearfix">Regular Table</h3>
							<form class="table-form">
								<table>
									<thead>
										<tr>
											<th><input type="checkbox" class="check-all"></th>
											<th>&nbsp;</th>
											<th>Rendering engine</th>
											<th>Browser</th>
											<th>Platform(s)</th>
											<th>Version</th>
											<th>Tags</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Trident</td>
											<td>Internet Explorer 4.0</td>
											<td>Win 95+</td>
											<td>4</td>
											<td><span class="tag red">High</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Trident</td>
											<td>Internet  Explorer 5.0</td>
											<td>Win 95+</td>
											<td>5</td>
											<td><span class="tag orange">Medium</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Trident</td>
											<td>Internet Explorer 5.5</td>
											<td>Win 95+</td>
											<td>5.5</td>
											<td><span class="tag green">Low</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Trident</td>
											<td>Internet Explorer 6</td>
											<td>Win 98+</td>
											<td>6</td>
											<td><span class="tag gray">Closed</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Trident</td>
											<td>Internet Explorer 7</td>
											<td>Win XP SP2+</td>
											<td>7</td>
											<td><span class="tag blue">#337</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Trident</td>
											<td>AOL browser (AOL desktop)</td>
											<td>Win XP</td>
											<td>6</td>
											<td><span class="tag gray">Closed</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Gecko</td>
											<td>Firefox 1.0</td>
											<td>Win 98+ / OSX.2+</td>
											<td>1.7</td>
											<td><span class="tag gray">Closed</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Gecko</td>
											<td>Firefox 1.5</td>
											<td>Win 98+ / OSX.2+</td>
											<td>1.8</td>
											<td><span class="tag gray">Closed</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Gecko</td>
											<td>Firefox 2.0</td>
											<td>Win 98+ / OSX.2+</td>
											<td>1.8</td>
											<td><span class="tag gray">Closed</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Gecko</td>
											<td>Firefox 3.0</td>
											<td>Win 2k+ / OSX.3+</td>
											<td>1.9</td>
											<td><span class="tag gray">Closed</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Gecko</td>
											<td>Camino 1.0</td>
											<td>OSX.2+</td>
											<td>1.8</td>
											<td><span class="tag gray">Closed</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox"></td>
											<td>
												<!-- Table actions -->
												<a class="toggle-table-switch" href="#" title="Show options" rel="tooltip">Options</a>
												<ul class="table-switch">
													<li><a href="#">view</a></li>
													<li><a href="#">edit</a></li>
													<li><a href="#">delete</a></li>
												</ul>
												<!-- /Table actions -->
											</td>
											<td>Gecko</td>
											<td>Camino 1.5</td>
											<td>OSX.3+</td>
											<td>1.8</td>
											<td><span class="tag gray">Closed</span></td>
											<td>
												<ul class="actions">
													<li><a class="view" href="#" title="View Item" rel="tooltip">view</a></li>
													<li><a class="edit" href="#" title="Edit Item" rel="tooltip">edit</a></li>
													<li><a class="delete" href="#" title="Delete Item" rel="tooltip">delete</a></li>
												</ul>
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="8">
												<!-- Pagination -->
												<ul class="pagination">
													<li><a class="button gray" href="#">&laquo; first</a></li>
													<li><a class="button gray" href="#">&lt; next</a></li>
													<li class="hellip">&hellip;</li>
													<li><a class="button gray" href="#">5</a></li>
													<li><a class="button gray" href="#">6</a></li>
													<li><a class="button" href="#">7</a></li>
													<li><a class="button gray" href="#">8</a></li>
													<li><a class="button gray" href="#">9</a></li>
													<li class="hellip">&hellip;</li>
													<li><a class="button gray" href="#">prev &gt;</a></li>
													<li><a class="button gray" href="#">last &raquo;</a></li>
												</ul>
												<!-- /Pagination -->
											</td>
										</tr>
									</tfoot>
								</table>
							</form>
						</div>
						<!-- /Side Tab Content #sidetab1 -->
						
						<!-- Side Tab Content #sidetab2 -->
						<div class="sidetab" id="sidetab2">
							<h3>Form</h3>
							<form>
								<!-- Inputs -->
								<!-- Use class .small, .medium or .large for predefined size -->
								<fieldset>
									<legend>Legend</legend>
									<dl>
										<dt>
											<label>Short Input</label>
										</dt>
										<dd>
											<input type="text" class="small">
											<p>Short description of event</p>
										</dd>
										<dt>
											<label>Medium Input</label>
										</dt>
										<dd>
											<input type="text" class="medium">
										</dd>
										<dt>
											<label>Focused Input</label>
										</dt>
										<dd>
											<input type="text" class="medium">
										</dd>
										<dt>
											<label>Valid Input</label>
										</dt>
										<dd>
											<input type="text" class="medium valid">
											<span class="valid-side-note">Valid text</span>
										</dd>
										<dt>
											<label>Invalid Input</label>
										</dt>
										<dd>
											<input type="text" class="medium invalid">
											<span class="invalid-side-note">Invalid text</span>
										</dd>
										<dt>
											<label>Disabled Input</label>
										</dt>
										<dd>
											<input type="text" class="medium" disabled>
										</dd>
										<dt>
											<label>Long text input</label>
										</dt>
										<dd>
											<input type="text" class="large">
											<p>Short description of event</p>
										</dd>
										<dt>
											<label>Text content</label>
										</dt>
										<dd class="text">
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque mattis lobortis nisl nec commodo. In eleifend, arcu sed aliquet varius, turpis dolor sollicitudin mi, condimentum consequat lectus massa vitae risus. Aliquam sed arcu sed magna auctor dictum.</p>
										</dd>
										<dt>
											<label>Text content</label>
										</dt>
										<dd class="text">
											Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque mattis lobortis nisl nec commodo. In eleifend, arcu sed aliquet varius, turpis dolor sollicitudin mi, condimentum consequat lectus massa vitae risus. Aliquam sed arcu sed magna auctor dictum.
										</dd>
										<dt>
											<label>File input</label>
										</dt>
										<dd>
											<input type="file" class="fileupload">
											<p>Max size 5Mb</p>
										</dd>
										<dt>
											<label>Date input</label>
										</dt>
										<dd>
											<input type="text" class="datepicker small">
										</dd>
										<dt>
											<label>Textarea</label>
										</dt>
										<dd>
											<!-- Use class .wysiwyg for jQuery jWYSIWYG initiation -->
											<textarea rows="5" cols="40" class="wysiwyg large"></textarea>
											<p>Short description of event</p>
										</dd>
									</dl>
								</fieldset>
								<fieldset>
									<legend>Check-in some of these</legend>
									<dl>
										<dt class="checkbox"><label>Checkbox A</label></dt>
										<dd><input type="checkbox"></dd>
										<dt class="checkbox"><label>Checkbox B</label></dt>
										<dd><input type="checkbox"></dd>
										<dt class="checkbox"><label>Checkbox C</label></dt>
										<dd><input type="checkbox"></dd>
									</dl>
								</fieldset>
								<fieldset>
									<legend>Choose one of these</legend>
									<dl>
										<dt class="radio"><label>Option 1</label></dt>
										<dd><input type="radio" name="test"></dd>
										<dt class="radio"><label>Option 2</label></dt>
										<dd><input type="radio" name="test"></dd>
										<dt class="radio"><label>Option 3</label></dt>
										<dd><input type="radio" name="test"></dd>
									</dl>
								</fieldset>
								<fieldset>
									<legend>Choose one of these</legend>
									<dl>
										<dt><label>Select</label></dt>
										<dd>
											<select name="actions">
												<option selected>Choose an action</option>
												<option value="e">Edit</option>
												<option value="r">Remove</option>
												<option value="x">Export</option>
											</select>
										</dd>
									</dl>
								</fieldset>
								<button type="submit">Submit</button> or <a href="#">Cancel</a>
							</form>
						</div>
						<!-- /Side Tab Content #sidetab2 -->
						
						<!-- Side Tab Content #sidetab3 -->
						<div class="sidetab" id="sidetab3">
							<h3>Emoticons</h3>
							<p>We have made for you simple predefined emoticons. Use class .emoticon with mood class of your choice (.emoticon .smile).</p>
							<p>
								<span class="emoticon smile">:smile:</span>
								<span class="emoticon grin">:grin:</span>
								<span class="emoticon evilgrin">:evilgrin:</span>
								<span class="emoticon happy">:happy:</span>
								<span class="emoticon surprised">:surprised:</span>
								<span class="emoticon tongue">:tongue:</span>
								<span class="emoticon unhappy">:unhappy:</span>
								<span class="emoticon waii">:waii:</span>
								<span class="emoticon wink">:wink:</span>
								<span class="emoticon neutral">:neutral:</span>
								<span class="emoticon cool">:cool:</span>
								<span class="emoticon confuse">:confuse:</span>
								<span class="emoticon cry">:cry:</span>
								<span class="emoticon fat">:fat:</span>
								<span class="emoticon mad">:mad:</span>
								<span class="emoticon red">:red:</span>
								<span class="emoticon roll">:roll:</span>
								<span class="emoticon slim">:slim:</span>
								<span class="emoticon yell">:yell:</span>
								<span class="emoticon bug">:bug:</span>
								<span class="emoticon heart">:heart:</span>
								<span class="emoticon rocket">:rocket:</span>
								<span class="emoticon basketball">:basketball:</span>
								<span class="emoticon soccer">:soccer:</span>
								<span class="emoticon tennis">:tennis:</span>
								<span class="emoticon golf">:golf:</span>
								<span class="emoticon football">:football:</span>
								<span class="emoticon eightball">:8ball:</span>
								<span class="emoticon raquet">:raquet:</span>
								<span class="emoticon shuttlecock">:shuttlecock:</span>
							</p>
							<h3>File Extension</h3>
							<p>Chromatron Admin comes also with special predefined file extension styles. Use class .extension with file type class to add extension icon (.extension .cplusplus) to any element.</p>
							<ul class="left">
								<li><span class="extension empty">Empty document</span></li>
								<li><span class="extension pdf">Acrobat document</span></li>
								<li><span class="extension access">Access document</span></li>
								<li><span class="extension cup">Cup document</span></li>
								<li><span class="extension cplusplus">C++ document</span></li>
								<li><span class="extension csharp">C# document</span></li>
								<li><span class="extension database">Database document</span></li>
								<li><span class="extension film">Film document</span></li>
								<li><span class="extension find">Find document</span></li>
								<li><span class="extension freehand">Freehand document</span></li>
							</ul>
							<ul class="left">
								<li><span class="extension excel">Excel document</span></li>
								<li><span class="extension flash">Flash document</span></li>
								<li><span class="extension dvd">DVD document</span></li>
								<li><span class="extension php">PHP document</span></li>
								<li><span class="extension powerpoint">Powerpoint document</span></li>
								<li><span class="extension picture">Picture document</span></li>
								<li><span class="extension ruby">Ruby document</span></li>
								<li><span class="extension illustrator">Illustrator document</span></li>
								<li><span class="extension photoshop">Photoshop document</span></li>
								<li><span class="extension swoosh">Swoosh document</span></li>
							</ul>
							<ul class="left">
								<li><span class="extension text">Text document</span></li>
								<li><span class="extension tux">Tux document</span></li>
								<li><span class="extension word">Word document</span></li>
								<li><span class="extension visualstudio">Visual Studio document</span></li>
								<li><span class="extension zip">Zip document</span></li>
								<li><span class="extension music">Music document</span></li>
								<li><span class="extension office">MS Office document</span></li>
								<li><span class="extension report">Report document</span></li>
								<li><span class="extension wrench">Wrench document</span></li>
							</ul>
						</div>
						<!-- /Side Tab Content #sidetab3 -->
						
					</div>
					<!-- /Tab Content #tab2 -->
				</section>
				<!-- /Article Content -->
				
				<!-- Article Footer -->
				<footer>
					<?php echo $template['partials']['footer']; ?>
				</footer>
				<!-- /Article Footer -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Full Content Block -->
		
		<!-- Full Content Block with .nested style -->
		<article class="full-block nested">
		
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2>Headline H2</h2>
					
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="tab-switch">
							<li><a href="#tab3">Notifications</a></li>
							<li><a class="default-tab" href="#tab4">Some more typo</a></li>
							<li><a href="#tab5">Image Gallery</a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
					
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
				
					<!-- Tab Content #tab3 -->
					<div class="tab" id="tab3">
						<h3>Notifications</h3>
						
						<!-- Notification -->
						<div class="notification error">
							<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
							<p><strong>Error notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
						</div>
						<!-- /Notification -->
						
						<!-- Notification -->
						<div class="notification success">
							<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
							<p><strong>Success notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
						</div>
						<!-- /Notification -->
						
						<!-- Notification -->
						<div class="notification information">
							<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
							<p><strong>Information notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
						</div>
						<!-- /Notification -->
						
						<!-- Notification -->
						<div class="notification attention">
							<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
							<p><strong>Attention notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
						</div>
						<!-- /Notification -->
						
						<!-- Notification -->
						<div class="notification note">
							<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
							<p><strong>Note</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
						</div>
						<!-- /Notification -->
						
					</div>
					<!-- /Tab Content #tab3 -->
					
					<!-- Tab Content #tab4 -->
					<div class="tab default-tab" id="tab4">
						<h3>Headline H3</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat. Nunc at dui id purus lacinia tincidunt sit amet vel erat.</p>
						<ol>
							<li>Lorem ipsum dolor sit amet</li>
							<li><strong>Consectetur adipiscing elit</strong></li>
							<li><em>Suspendisse et dignissim metus</em></li>
							<li>Maecenas id <a href="#">augue ac metus</a> tempus</li>
							<li>Sed pharetra placerat est suscipit</li>
						</ol>
						<h4>Headline H4</h4>
						
						<!-- Image Minimenu Actions -->
						<div class="image-frame right">
							<img src="img/sample_image.jpg" alt="Sample Image">
							<ul class="image-actions">
								<li class="view"><a href="#">View</a></li>
								<li class="delete"><a href="#">Delete</a></li>
							</ul>
						</div>
						<!-- /Image Minimenu Actions -->
						
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat. Nunc at dui id purus lacinia tincidunt sit amet vel erat.</p>
						<h5>Headline H5</h5>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat. Nunc at dui id purus lacinia tincidunt sit amet vel erat.</p>
					</div>
					<!-- /Tab Content #tab4 -->
					
					<!-- Tab Content #tab5 -->
					<div class="tab" id="tab5">
						<h3>Image Gallery</h3>
						<!-- Inline Image Gallery -->
						<ul class="image-gallery">
							<li class="image-frame">
								<img src="img/sample_image.jpg" alt="Sample Image">
								<ul class="image-actions">
									<li class="view"><a href="#">View</a></li>
									<li class="delete"><a href="#">Delete</a></li>
								</ul>
							</li>
							<li class="image-frame">
								<img src="img/sample_image.jpg" alt="Sample Image">
								<ul class="image-actions">
									<li class="view"><a href="#">View</a></li>
									<li class="delete"><a href="#">Delete</a></li>
								</ul>
							</li>
							<li class="image-frame">
								<img src="img/sample_image.jpg" alt="Sample Image">
								<ul class="image-actions">
									<li class="view"><a href="#">View</a></li>
									<li class="delete"><a href="#">Delete</a></li>
								</ul>
							</li>
							<li class="image-frame">
								<img src="img/sample_image.jpg" alt="Sample Image">
								<ul class="image-actions">
									<li class="view"><a href="#">View</a></li>
									<li class="delete"><a href="#">Delete</a></li>
								</ul>
							</li>
							<li class="image-frame">
								<img src="img/sample_image.jpg" alt="Sample Image">
								<ul class="image-actions">
									<li class="view"><a href="#">View</a></li>
									<li class="delete"><a href="#">Delete</a></li>
								</ul>
							</li>
							<li class="image-frame">
								<img src="img/sample_image.jpg" alt="Sample Image">
								<ul class="image-actions">
									<li class="view"><a href="#">View</a></li>
									<li class="delete"><a href="#">Delete</a></li>
								</ul>
							</li>
							<li>
								<img src="img/sample_image.jpg" alt="Sample Image">
							</li>
							<li>
								<img src="img/sample_image.jpg" alt="Sample Image">
							</li>
						</ul>
						<!-- /Inline Image Gallery -->
					</div>
					<!-- /Tab Content #tab5 -->
					
				</section>
				<!-- /Article Content -->
		
			</div>
			<!-- /Article Container -->
		
		</article>
		<!-- /Full Content Block with .nested style -->
		
		<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->
		
		<!-- Half Content Block -->
		<article class="half-block">
		
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2>Half block with Buttons</h2>
					<!-- Article Header Tab Navigation -->
					<nav>
						<ul class="button-switch">
							<li><a href="#" class="button">View</a></li>
							<li><a href="#" class="button">Edit</a></li>
							<li><a href="#" class="button gray">Delete</a></li>
						</ul>
					</nav>
					<!-- /Article Header Tab Navigation -->
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat. Nunc at dui id purus lacinia tincidunt sit amet vel erat. Quisque congue urna ut nunc tempor sodales. Sed neque leo, elementum id malesuada id, consequat et erat.</p>
					
					<!-- AJAX Loading icons -->
					<span class="loader" title="Loading, please wait&#8230;"></span>
					<span class="loader red" title="Loading, please wait&#8230;"></span>
					<span class="loader green" title="Loading, please wait&#8230;"></span>
					<span class="loader blue" title="Loading, please wait&#8230;"></span>
					<!-- /AJAX Loading icons -->
					
				</section>
				<!-- /Article Content -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Half Content Block -->
		
		<!-- Half Content Block -->
		<article class="half-block nested clearrm">
			
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2>Ajax Loading Iocns</h2>
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat. Nunc at dui id purus lacinia tincidunt sit amet vel erat.</p>
					
					<!-- AJAX Loading icons -->
					<span class="loader" title="Loading, please wait&#8230;"></span>
					<span class="loader red" title="Loading, please wait&#8230;"></span>
					<span class="loader green" title="Loading, please wait&#8230;"></span>
					<span class="loader blue" title="Loading, please wait&#8230;"></span>
					<!-- /AJAX Loading icons -->
					
				</section>
				<!-- /Article Content -->
				
				<!-- Article Footer -->
				<footer>
					<p>Ajax Loading Icon comes in 8 different variants</p>
				</footer>
				<!-- /Article Footer -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Half Content Block -->
		
		<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->
		
		<!-- Third Content Block -->
		<article class="third-block clearfix">
		
			<!-- Article Container for safe floating -->
			<div class="article-container">
		
				<!-- Article Header -->
				<header>
					<h2>Contacts</h2>
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
				
					<!-- Contacts -->
					<ul class="contacts">
						<li>
							<img src="img/sample_user.png" alt="Sample User Avatar">
							<a href="#" class="contacts-user">Tomas Jeff</a>
							<em>Administrator</em>
							<ul>
								<li><a class="button-link" href="#">Send Message</a></li>
								<li><a class="button-link" href="#">Add New Task</a></li>
							</ul>
						</li>
						<li>
							<img src="img/sample_user.png" alt="Sample User Avatar">
							<a href="#" class="contacts-user">Paul Derren</a>
							<em>Supervisor</em>
							<ul>
								<li><a class="button-link" href="#">Send Message</a></li>
								<li><a class="button-link" href="#">Add New Task</a></li>
							</ul>
						</li>
						<li>
							<img src="img/sample_user.png" alt="Sample User Avatar">
							<a href="#" class="contacts-user">Kate Därlan</a>
							<em>Site Manager</em>
							<ul>
								<li><a class="button-link" href="#">Send Message</a></li>
								<li><a class="button-link" href="#">Add New Task</a></li>
							</ul>
						</li>
						<li>
							<img src="img/sample_user.png" alt="Sample User Avatar">
							<a href="#" class="contacts-user">Vanda Gale</a>
							<em>Site Editor</em>
							<ul>
								<li><a class="button-link" href="#">Send Message</a></li>
								<li><a class="button-link" href="#">Add New Task</a></li>
							</ul>
						</li>
					</ul>
					<!-- /Contacts -->
					
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat. Nunc at dui id purus lacinia tincidunt sit amet vel erat. Quisque congue urna ut nunc tempor sodales.</p>
					
				</section>
				<!-- /Article Content -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Third Content Block -->
		
		<!-- Third Content Block -->
		<article class="third-block nested">
			
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2>Buttons and links</h2>
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
					<!-- Links and buttons -->
					<p><a href="#sample" rel="modal">Regulart Text Link with modal</a></p>
					<p><a href="#sample" class="outside" rel="modal">Regulart Text Link with .outside class</a></p>
					<p><a href="#" class="button-link">Button-like Text Link (class '.button-link')</a></p>
					<p><a href="#" class="button-link blue">Button-like Text Link (class '.button-link.blue')</a></p>
					<p><a href="#" class="button-link green">Button-like Text Link (class '.button-link.green')</a></p>
					<p><a href="#" class="button-link gray">Button-like Text Link (class '.button-link.gray')</a></p>
					<p><a href="#" class="button">Text Link (class '.button')</a></p>
					<!-- /Links and buttons -->
					
					<!-- Links and buttons -->
					<p><button>Button (default is auto width)</button></p>
					<p><button class="blue small">Button</button></p>
					<p><button class="green medium">Button (.medium)</button></p>
					<p><button class="gray large">Button (.large)</button></p>
					<p><button disabled>Button:disabled</button></p>
					<!-- /Links and buttons -->
					
				</section>
				<!-- /Article Content -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Third Content Block -->
		
		<!-- Third Content Block -->
		<article class="third-block clearrm">
		
			<!-- Article Container for safe floating -->
			<div class="article-container">
		
				<!-- Article Header -->
				<header>
					<h2>Progress bars and Stats</h2>
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
					
					<!-- Stats Summary -->
					<ul class="stats-summary">
						<li>
							<strong class="stats-count">17</strong>
							<p>New registrations</p>
							<a href="#" class="button stats-view" title="View new registrations" rel="tooltip">View</a>
						</li>
						<li>
							<strong class="stats-count">89</strong>
							<p>New visitors</p>
							<a href="#" class="button stats-view" title="View new visitros" rel="tooltip">View</a>
						</li>
						<li>
							<strong class="stats-count">346</strong>
							<p>New sales</p>
							<a href="#" class="button stats-view" title="View new sales" rel="tooltip">View</a>
						</li>
						<li>
							<strong class="stats-count">266</strong>
							<p>New orders</p>
							<a href="#" class="button stats-view" title="View new orders" rel="tooltip">View</a>
						</li>
						<li>
							<strong class="stats-count">1024</strong>
							<p>New requests</p>
							<a href="#" class="button stats-view" title="View new requests" rel="tooltip">View</a>
						</li>
					</ul>
					<!-- /Stats Summary -->
					
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam.</p>
					
					<!-- Progress Bar -->
					<div class="progress-bar green small">
						<div style="width:80%;">
							<span>80<sup>%</sup></span>
						</div>
					</div>
					<!-- /Progress Bar -->
					
					<!-- Progress Bar -->
					<div class="progress-bar red medium">
						<div style="width:60%;">
							<span>60<sup>%</sup></span>
						</div>
					</div>
					<!-- /Progress Bar -->
					
					<!-- Progress Bar -->
					<div class="progress-bar blue large">
						<div style="width:32%;">
							<span>32<sup>%</sup></span>
						</div>
					</div>
					<!-- /Progress Bar -->
					
				</section>
				<!-- /Article Content -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Third Content Block -->
		
		<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->
		
		<!-- Quarter Content Block -->
		<article class="quarter-block">
			
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2>Accordion</h2>
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
					<!-- Accordion -->
					<ul class="accordion">
						<!-- Accordion Tab -->
						<li>
							<a class="accordion-switch" href=""><h3>First Heading</h3></a>
							<div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam.</p>
							</div>
						</li>
						<!-- /Accordion Tab -->
						
						<!-- Accordion Tab -->
						<li>
							<a class="accordion-switch" href=""><h3>Second Heading</h3></a>
							<div>
								<p>Sed neque leo, elementum id malesuada id, consequat et erat. Maecenas lorem mauris, consequat ornare elementum adipiscing, tristique eu eros.</p>
							</div>
						</li>
						<!-- /Accordion Tab -->
						
						<!-- Accordion Tab -->
						<li>
							<a class="accordion-switch" href=""><h3>Third Heading</h3></a>
							<div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam.</p>
							</div>
						</li>
						<!-- /Accordion Tab -->
						
						<!-- Accordion Tab -->
						<li>
							<a class="accordion-switch" href=""><h3>Fourth Heading</h3></a>
							<div>
								<p>Sed neque leo, elementum id malesuada id, consequat et erat. Maecenas lorem mauris, consequat ornare elementum adipiscing, tristique eu eros.</p>
							</div>
						</li>
						<!-- /Accordion Tab -->
					</ul>
					<!-- /Accordion -->
				</section>
				<!-- /Article Content -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Quarter Content Block -->
		
		<!-- Quarter Content Block -->
		<article class="quarter-block">
			
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2>Chromatron</h2>
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis.</p>
					<ul class="list-style-arrow">
						<li>Lorem ipsum dolor sit amet</li>
						<li>Suspendisse et dignissim metus</li>
						<li>Maecenas id augue ac metus tempus</li>
						<li>Sed pharetra placerat est suscipit</li>
						<li>Phasellus aliquam males</li>
						<li>Nunc at dui id purus lacinia tincidunt</li>
					</ul>
				</section>
				<!-- /Article Content -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Quarter Content Block -->
		
		<!-- Quarter Content Block -->
		<article class="quarter-block">
			
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2>Chromatron</h2>
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat.</p>
					<ul class="list-style-checkmark">
						<li>Lorem ipsum dolor sit amet</li>
						<li>Suspendisse et dignissim metus</li>
						<li>Maecenas id augue ac metus tempus</li>
						<li>Sed pharetra placerat est suscipit</li>
						<li>Phasellus aliquam males</li>
						<li>Nunc at dui id purus lacinia tincidunt</li>
					</ul>
				</section>
				<!-- /Article Content -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Quarter Content Block -->
		
		<!-- Quarter Content Block -->
		<article class="quarter-block nested clearrm">
			
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
				<!-- Article Header -->
				<header>
					<h2>Chromatron</h2>
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat. Nunc at dui id purus lacinia tincidunt sit amet vel erat.</p>
					<ul class="list-style-cross">
						<li>Lorem ipsum dolor sit amet</li>
						<li>Suspendisse et dignissim metus</li>
						<li>Maecenas id augue ac metus tempus</li>
						<li>Sed pharetra placerat est suscipit</li>
						<li>Phasellus aliquam males</li>
						<li>Nunc at dui id purus lacinia tincidunt</li>
					</ul>
				</section>
				<!-- /Article Content -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Quarter Content Block -->
		
		<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->
		
		<!-- Full Content Block -->
		<article class="full-block clearfix">
			
			<!-- Article Container for safe floating -->
			<div class="article-container">
			
			<!-- Article Header -->
				<header>
					<h2>Chromatron Admin Theme</h2>
				</header>
				<!-- /Article Header -->
				
				<!-- Article Content -->
				<section>
					
					<!-- Side Tab Container -->
					<div class="sidetabs">
					
						<!-- Side Tab Navigation -->
						<nav class="sidetab-switch">
							<ul>
								<li><a href="#sidetab4">Event Logs</a></li>
								<li><a class="default-sidetab" href="#sidetab5">Calendar</a></li>
								<li><a href="#sidetab6">Wizard</a></li>
								<li><a href="#sidetab7">Tickets</a></li>
							</ul>
							<p>Aenean facilisis ligula eget orci adipiscing varius. Curabitur sem ligula, egestas vel bibendum sed, sodales eu nulla. Vestibulum luctus aliquam feugiat. Donec porta interdum placerat.</p>
						</nav>
						<!-- /Side Tab Navigation -->
						
						<!-- Side Tab Content #sidetab4 -->
						<div class="sidetab" id="sidetab4">
							<h3>Latest Activity</h3>
							
							<!-- Event Logs -->
							<ul class="logs">
								<li>
									<span class="logs-timestamp">May 28, 2011</span>
									<h4><a class="logs-event" href="#">System Update #112563</a></h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit.</p>
									<em class="logs-meta">Posted by <a href="#">Administrator</a></em>
								</li>
								<li>
									<span class="logs-timestamp">May 26, 2011</span>
									<h4><a class="logs-event" href="#">System Update #112562</a></h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit.</p>
									<em class="logs-meta">Posted by <a href="#">Administrator</a></em>
								</li>
								<li class="bomb">
									<span class="logs-timestamp">May 25, 2011</span>
									<h4><a class="logs-event" href="#">Security Violation</a></h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit.</p>
									<em class="logs-meta">Posted by <a href="#">Administrator</a></em>
								</li>
								<li>
									<span class="logs-timestamp">May 23, 2011</span>
									<h4><a class="logs-event" href="#">System Update #112561</a></h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit.</p>
									<em class="logs-meta">Posted by <a href="#">Administrator</a></em>
								</li>
								<li class="event">
									<span class="logs-timestamp">May 23, 2011</span>
									<h4><a class="logs-event" href="#">New User Created</a></h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit.</p>
									<em class="logs-meta">Posted by <a href="#">Administrator</a></em>
								</li>
							</ul>
							<!-- /Event Logs -->
							
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis. Phasellus aliquam malesuada blandit. Donec adipiscing sem erat. Nunc at dui id purus lacinia tincidunt sit amet vel erat. Quisque congue urna ut nunc tempor sodales. Sed neque leo, elementum id malesuada id, consequat et erat. Maecenas lorem mauris, consequat ornare elementum adipiscing, tristique eu eros. Nulla sodales, tellus id porta condimentum, purus tortor faucibus orci, et interdum dui purus quis massa.</p>
						</div>
						<!-- /Side Tab Content #sidetab4 -->
						
						<!-- Side Tab Content #sidetab5 -->
						<div class="sidetab default-sidetab" id="sidetab5">
							<h3>jQuery Full Calendar Plugin</h3>
							
							<!-- jQuery Full Calendar Plugin -->
							<div class="fullcalendar"></div>
							<!-- /jQuery Full Calendar Plugin -->
							
							<h3>Clean HTML Calendar</h3>
							
							<!-- HTML Calendar Actions -->
							<ul class="htmlcalendar-actions">
								<li class="current-day">Tuesday 8<sup>th</sup></li>
								<li class="current-month"><h4>May 2011</h4></li>
								<li class="actions">
									<ul>
										<li><a href="#" class="button">Add</a></li>
										<li><a href="#" class="button">Export</a></li>
										<li><a href="#" class="button">Print</a></li>
									</ul>
								</li>
							</ul>
							<!-- /HTML Calendar Actions -->
							
							<!-- HTML Calendar -->
							<table class="htmlcalendar">
								<tbody>
									<tr>
										<th class="week"><span>Week</span>9<sup>th</sup></th>
										<td class="day previous-month">
											<div>
												<div class="calendar-entry"><span>Sunday</span>27<sup>th</sup></div>
												<div class="calendar-event">
													<div class="event"><a href="#">Meeting</a></div>
												</div>
											</div>
										</td>
										<td class="day previous-month">
											<div>
												<div class="calendar-entry"><span>Monday</span>28<sup>th</sup></div>
												<div class="calendar-event">
													<div class="event">Meeting</div>
												</div>
											</div>
										</td>
										<td class="day previous-month">
											<div>
												<div class="calendar-entry"><span>Tuesday</span>1<sup>st</sup></div>
												<div class="calendar-event"></div>
											</div>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Wednesday</span>2<sup>nd</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Thursday</span>3<sup>tr</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Friday</span>4<sup>th</sup></div>
												<div class="calendar-event">
													<div class="event gray"><a href="#">Fix #226 Bug</a></div>
												</div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Saturday</span>5<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
									</tr>
									<tr>
										<th class="week current-week"><span>Week</span>10<sup>th</sup></th>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Sunday</span>6<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Monday</span>7<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day today">
											<div>
												<div class="calendar-entry"><span>Tuesday</span>8<sup>th</sup></div>
												<div class="calendar-event">
													<div class="event green"><a href="#">PPC Training</a></div>
												</div>
											</div>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Wednesday</span>9<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Thursday</span>10<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Friday</span>11<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Saturday</span>12<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
									</tr>
									<tr>
										<th class="week"><span>Week</span>11<sup>th</sup></th>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Sunday</span>13<sup>th</sup></div>
												<div class="calendar-event">
													<div class="event"><a href="#">Meeting</a></div>
													<div class="event orange">Tenis</div>
												</div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Monday</span>14<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Tuesday</span>15<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Wednesday</span>16<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Thursday</span>17<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Friday</span>18<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Saturday</span>19<sup>th</sup></div>
												<div class="calendar-event">
													<div class="event green"><a href="#">Long Calendar Event Lorem Ipsum Dolor Too Looong Link </a></div>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<th class="week"><span>Week</span>12<sup>th</sup></th>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Sunday</span>20<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Monday</span>21<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Tuesday</span>22<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Wednesday</span>23<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Thursday</span>24<sup>th</sup></div>
												<div class="calendar-event">
													<div class="event black"><a href="#">Project Meeting</a></div>
												</div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Friday</span>25<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Saturday</span>26<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
									</tr>
									<tr>
										<th class="week"><span>Week</span>13<sup>th</sup></th>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Sunday</span>28<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Monday</span>29<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day">
											<div>
												<div class="calendar-entry"><span>Tuesday</span>30<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										<td class="day next-month">
											<div>
												<div class="calendar-entry"><span>Wednesday</span>1<sup>st</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
										<td class="day next-month">
											<div>
												<div class="calendar-entry"><span>Thursday</span>2<sup>nd</sup></div>
												<div class="calendar-event">
													<div class="event blue"><a href="#">Holiday</a></div>
												</div>
											</div>
										</td>
										<td class="day next-month">
											<div>
												<div class="calendar-entry"><span>Friday</span>3<sup>rd</sup></div>
												<div class="calendar-event">
													<div class="event blue"><a href="#">Holiday</a></div>
												</div>
											</div>
										</td>
										<td class="day next-month">
											<div>
												<div class="calendar-entry"><span>Saturday</span>4<sup>th</sup></div>
												<div class="calendar-event"></div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<!-- /HTML Calendar -->

						</div>
						<!-- /Side Tab Content #sidetab5 -->
						
						<!-- Side Tab Content #sidetab6 -->
						<div class="sidetab" id="sidetab6">
							<h3>Wizard</h3>
							
							<!-- Wizard -->
							<!-- Wizard Steps -->
							<ol class="wizard-steps">
								<li><a href="#step1">Register</a></li>
								<li><a href="#step2">Personal Information</a></li>
								<li><a href="#step3">Payment Information</a></li>
								<li><a href="#step4">Confirmation</a></li>
							</ol>
							<!-- /Wizard Steps -->
							
							<!-- Wizard Item -->
							<div id="step1" class="wizard-content">
								<h4>Wizard Step 1</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc placerat dapibus tortor quis sodales. Mauris convallis lobortis justo a facilisis. Aenean mollis lacus ac nunc bibendum tempus. Proin laoreet, ante id convallis aliquet, leo orci placerat nisi, nec suscipit mi tortor at enim. Mauris eu augue a lectus tempus sagittis. Fusce lacinia suscipit velit, quis commodo eros tincidunt fringilla.</p>
								<p>In eget nulla nec neque condimentum luctus non non justo. Sed at felis libero, non sagittis ipsum. Aenean mauris erat, auctor eget sodales nec, euismod sed nunc. Integer accumsan egestas augue eu tincidunt. Etiam in orci ut enim ullamcorper sagittis. Maecenas pharetra lorem vitae nulla rhoncus quis aliquet nisl tincidunt. Mauris malesuada purus in augue ultrices lacinia. Praesent a nunc at eros hendrerit molestie a a est. Integer nec est in nulla volutpat lacinia quis dapibus magna. Etiam eu justo nec magna imperdiet rutrum. Suspendisse imperdiet condimentum lacus ac condimentum.</p>
								<a href="#step2" class="wizard-next">Next step &raquo;</a>
							</div>
							<!--/ Wizard Item -->
							
							<div id="step2" class="wizard-content">
								<h4>Wizard Step 2</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc placerat dapibus tortor quis sodales. Mauris convallis lobortis justo a facilisis. Aenean mollis lacus ac nunc bibendum tempus. Proin laoreet, ante id convallis aliquet, leo orci placerat nisi, nec suscipit mi tortor at enim. Mauris eu augue a lectus tempus sagittis. Fusce lacinia suscipit velit, quis commodo eros tincidunt fringilla.</p>
								<p>In eget nulla nec neque condimentum luctus non non justo. Sed at felis libero, non sagittis ipsum. Aenean mauris erat, auctor eget sodales nec, euismod sed nunc. Integer accumsan egestas augue eu tincidunt. Etiam in orci ut enim ullamcorper sagittis. Maecenas pharetra lorem vitae nulla rhoncus quis aliquet nisl tincidunt. Mauris malesuada purus in augue ultrices lacinia. Praesent a nunc at eros hendrerit molestie a a est. Integer nec est in nulla volutpat lacinia quis dapibus magna. Etiam eu justo nec magna imperdiet rutrum. Suspendisse imperdiet condimentum lacus ac condimentum.</p>
								<a href="#step3" class="wizard-next">Next step &raquo;</a>
							</div>
							<div id="step3" class="wizard-content">
								<h4>Wizard Step 3</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc placerat dapibus tortor quis sodales. Mauris convallis lobortis justo a facilisis. Aenean mollis lacus ac nunc bibendum tempus. Proin laoreet, ante id convallis aliquet, leo orci placerat nisi, nec suscipit mi tortor at enim. Mauris eu augue a lectus tempus sagittis. Fusce lacinia suscipit velit, quis commodo eros tincidunt fringilla.</p>
								<p>In eget nulla nec neque condimentum luctus non non justo. Sed at felis libero, non sagittis ipsum. Aenean mauris erat, auctor eget sodales nec, euismod sed nunc. Integer accumsan egestas augue eu tincidunt. Etiam in orci ut enim ullamcorper sagittis. Maecenas pharetra lorem vitae nulla rhoncus quis aliquet nisl tincidunt. Mauris malesuada purus in augue ultrices lacinia. Praesent a nunc at eros hendrerit molestie a a est. Integer nec est in nulla volutpat lacinia quis dapibus magna. Etiam eu justo nec magna imperdiet rutrum. Suspendisse imperdiet condimentum lacus ac condimentum.</p>
								<a href="#step4" class="wizard-next">Next step &raquo;</a>
							</div>
							<div id="step4" class="wizard-content">
								<h4>Wizard Step 4</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc placerat dapibus tortor quis sodales. Mauris convallis lobortis justo a facilisis. Aenean mollis lacus ac nunc bibendum tempus. Proin laoreet, ante id convallis aliquet, leo orci placerat nisi, nec suscipit mi tortor at enim. Mauris eu augue a lectus tempus sagittis. Fusce lacinia suscipit velit, quis commodo eros tincidunt fringilla.</p>
								<p>In eget nulla nec neque condimentum luctus non non justo. Sed at felis libero, non sagittis ipsum. Aenean mauris erat, auctor eget sodales nec, euismod sed nunc. Integer accumsan egestas augue eu tincidunt. Etiam in orci ut enim ullamcorper sagittis. Maecenas pharetra lorem vitae nulla rhoncus quis aliquet nisl tincidunt. Mauris malesuada purus in augue ultrices lacinia. Praesent a nunc at eros hendrerit molestie a a est. Integer nec est in nulla volutpat lacinia quis dapibus magna. Etiam eu justo nec magna imperdiet rutrum. Suspendisse imperdiet condimentum lacus ac condimentum.</p>
								<a href="#">Submit</a>
							</div>
							<!-- /Wizard -->
							
						</div>
						<!-- /Side Tab Content #sidetab6 -->
						
						<!-- Side Tab Content #sidetab7 -->
						<div class="sidetab" id="sidetab7">
							<h3>Tickets</h3>
							
							<!-- Tickets -->
							<ul class="tickets">
							
								<!-- Ticket Headers -->
								<li class="ticket-header">
									<ul>
										<li class="ticket-header-ticket">Ticket</li>
										<li class="ticket-header-activity">Activity</li>
										<li class="ticket-header-user">User</li>
										<li class="ticket-header-priority">Priority</li>
										<li class="ticket-header-age">Age</li>
									</ul>
								</li>
								<!-- /Ticket Headers -->
								
								<!-- Ticket Data -->
								<li class="ticket-data">
									<div class="ticket-overview">
										<ul>
											<li class="ticket-data-ticket">
												#13664
											</li>
											<li class="ticket-data-activity">
												<a href="#" class="ticket-open-details">Vestibulum luctus aliquam feugiat. Donec porta</a>
												<p>New Ticket</p>
											</li>
											<li class="ticket-data-user">
												<strong>Duke Smith</strong>
												Best Deals Ltd.
											</li>
											<li class="ticket-data-priority">
												<span class="tag red">High</span>
											</li>
											<li class="ticket-data-age">
												16 hours
											</li>
										</ul>
									</div>
									<div class="ticket-details">
										<h4>Donec porta interdum placerat</h4>
										<dl>
											<dt>Opened:</dt>
											<dd><strong>16 hours ago</strong></dd>
											<dt>Last updated:</dt>
											<dd><strong>11 hours ago</strong></dd>
											<dt>Milestone:</dt>
											<dd><strong>N/A</strong></dd>
											<dt class="clear">Reported by:</dt>
											<dd><strong>Jamie</strong></dd>
											<dt>Assigned to:</dt>
											<dd><strong>Anybody</strong></dd>
											<dt>Tags:</dt>
											<dd><strong>N/A</strong></dd>
										</dl>
										<h5>Description</h5>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis.</p>
										<ul class="ticket-details-actions">
											<li><a href="#" class="button gray">Update ticket</a></li>
											<li><a href="#" class="button red">Close ticket</a></li>
										</ul>
									</div>
									<!-- /Ticket Details -->
									
								</li>
								<!-- /Ticket Data -->
								
								<!-- Ticket Data -->
								<li class="ticket-data">
								
									<!-- Ticket Overview -->
									<div class="ticket-overview">
										<ul>
											<li class="ticket-data-ticket">
												#13663
											</li>
											<li class="ticket-data-activity">
												<a href="#" class="ticket-open-details">Nulla aliquam sapien semper mauris consectetur</a>
												<p>New Ticket</p>
											</li>
											<li class="ticket-data-user">
												<strong>Mathew Kulas</strong>
												Adept Ltd.
											</li>
											<li class="ticket-data-priority">
												<span class="tag red">High</span>
											</li>
											<li class="ticket-data-age">
												22 hours
											</li>
										</ul>
									</div>
									<!-- /Ticket Overview -->
									
									<!-- Ticket Details -->
									<div class="ticket-details">
										<h4>Nulla aliquam sapien semper mauris consectetur suscipit</h4>
										<dl>
											<dt>Opened:</dt>
											<dd><strong>22 hours ago</strong></dd>
											<dt>Last updated:</dt>
											<dd><strong>22 hours ago</strong></dd>
											<dt>Milestone:</dt>
											<dd><strong>N/A</strong></dd>
											<dt class="clear">Reported by:</dt>
											<dd><strong>Mathew</strong></dd>
											<dt>Assigned to:</dt>
											<dd><strong>Anybody</strong></dd>
											<dt>Tags:</dt>
											<dd><strong>N/A</strong></dd>
										</dl>
										<h5>Description</h5>
										<p>Vivamus sit amet sapien est. Vestibulum at mattis orci. Duis sit amet tincidunt nisi. Morbi at porttitor nunc. Aliquam lorem massa, dictum vel consequat vitae, sodales nec lectus. Nam metus libero, mollis nec iaculis sit amet, eleifend ac orci. Sed mollis mollis luctus.</p>
										<ul class="ticket-details-actions">
											<li><a href="#" class="button gray">Update ticket</a></li>
											<li><a href="#" class="button red">Close ticket</a></li>
										</ul>
									</div>
									<!-- /Ticket Details -->
									
								</li>
								<!-- /Ticket Data -->
								
								<!-- Ticket Data -->
								<li class="ticket-data">
								
									<!-- Ticket Overview -->
									<div class="ticket-overview">
										<ul>
											<li class="ticket-data-ticket">
												#13662
											</li>
											<li class="ticket-data-activity">
												<a href="#" class="ticket-open-details">Sed pharetra placerat est suscipit sagittis</a>
												<p>New Ticket</p>
											</li>
											<li class="ticket-data-user">
												<strong>Ted Rollin</strong>
												Systel, Inc.
											</li>
											<li class="ticket-data-priority">
												<span class="tag orange">Medium</span>
											</li>
											<li class="ticket-data-age">
												1 day
											</li>
										</ul>
									</div>
									<!-- /Ticket Overview -->
									
									<!-- Ticket Details -->
									<div class="ticket-details">
										<h4>Sed pharetra placerat est suscipit sagittis</h4>
										<dl>
											<dt>Opened:</dt>
											<dd><strong>1 day ago</strong></dd>
											<dt>Last updated:</dt>
											<dd><strong>23 hours ago</strong></dd>
											<dt>Milestone:</dt>
											<dd><strong>N/A</strong></dd>
											<dt class="clear">Reported by:</dt>
											<dd><strong>Ted Rollin</strong></dd>
											<dt>Assigned to:</dt>
											<dd><strong>Javier Zulauf</strong></dd>
											<dt>Tags:</dt>
											<dd><strong>N/A</strong></dd>
										</dl>
										<h5>Description</h5>
										<p>Quisque ut eleifend lorem. Ut bibendum lobortis ante, in blandit quam aliquet eget. Donec tortor risus, vestibulum id dictum laoreet, condimentum vel nisi. Ut euismod laoreet justo vel iaculis. Phasellus at lacus eget magna laoreet euismod et vitae elit.</p>
										<ul class="ticket-details-actions">
											<li><a href="#" class="button gray">Update ticket</a></li>
											<li><a href="#" class="button red">Close ticket</a></li>
										</ul>
									</div>
									<!-- /Ticket Details -->
									
								</li>
								<!-- /Ticket Data -->
								
								<!-- Ticket Data -->
								<li class="ticket-data">
								
									<!-- Ticket Overview -->
									<div class="ticket-overview">
										<ul>
											<li class="ticket-data-ticket">
												#13661
											</li>
											<li class="ticket-data-activity">
												<a href="#" class="ticket-open-details">Quisque ac nisl vitae sapien porta luctus eget sed</a>
												<p>New Ticket</p>
											</li>
											<li class="ticket-data-user">
												<strong>Hugh Tilman</strong>
												Sunix Consulting
											</li>
											<li class="ticket-data-priority">
												<span class="tag orange">Medium</span>
											</li>
											<li class="ticket-data-age">
												2 days
											</li>
										</ul>
									</div>
									<!-- /Ticket Overview -->
									
									<!-- Ticket Details -->
									<div class="ticket-details">
										<h4>Quisque ac nisl vitae sapien porta luctus eget sed dui</h4>
										<dl>
											<dt>Opened:</dt>
											<dd><strong>2 days ago</strong></dd>
											<dt>Last updated:</dt>
											<dd><strong>11 hours ago</strong></dd>
											<dt>Milestone:</dt>
											<dd><strong>N/A</strong></dd>
											<dt class="clear">Reported by:</dt>
											<dd><strong>Hugh Tilman</strong></dd>
											<dt>Assigned to:</dt>
											<dd><strong>Anybody</strong></dd>
											<dt>Tags:</dt>
											<dd><strong>N/A</strong></dd>
										</dl>
										<h5>Description</h5>
										<p>Duis viverra quam tempor felis suscipit sit amet interdum erat pulvinar. Nulla nec quam quis mi pharetra tincidunt et in neque. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris a cursus velit.</p>
										<ul class="ticket-details-actions">
											<li><a href="#" class="button gray">Update ticket</a></li>
											<li><a href="#" class="button red">Close ticket</a></li>
										</ul>
									</div>
									<!-- /Ticket Details -->
									
								</li>
								<!-- /Ticket Data -->
								
								<!-- Ticket Data -->
								<li class="ticket-data">
								
									<!-- Ticket Overview -->
									<div class="ticket-overview">
										<ul>
											<li class="ticket-data-ticket">
												#13660
											</li>
											<li class="ticket-data-activity">
												<a href="#" class="ticket-open-details">Etiam ipsum justo, venenatis a facilisis vel</a>
												<p>New Ticket</p>
											</li>
											<li class="ticket-data-user">
												<strong>Selena Cartier</strong>
												Sunix Consulting
											</li>
											<li class="ticket-data-priority">
												<span class="tag orange">Medium</span>
											</li>
											<li class="ticket-data-age">
												2 days
											</li>
										</ul>
									</div>
									<!-- /Ticket Overview -->
									
									<!-- Ticket Details -->
									<div class="ticket-details">
										<h4>Etiam ipsum justo, venenatis a facilisis vel, posuere a ligula</h4>
										<dl>
											<dt>Opened:</dt>
											<dd><strong>2 days ago</strong></dd>
											<dt>Last updated:</dt>
											<dd><strong>22 hours ago</strong></dd>
											<dt>Milestone:</dt>
											<dd><strong>N/A</strong></dd>
											<dt class="clear">Reported by:</dt>
											<dd><strong>Selena</strong></dd>
											<dt>Assigned to:</dt>
											<dd><strong>Anybody</strong></dd>
											<dt>Tags:</dt>
											<dd><strong>N/A</strong></dd>
										</dl>
										<h5>Description</h5>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et dignissim metus. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis.</p>
										<ul class="ticket-details-actions">
											<li><a href="#" class="button gray">Update ticket</a></li>
											<li><a href="#" class="button red">Close ticket</a></li>
										</ul>
									</div>
									<!-- /Ticket Details -->
									
								</li>
								<!-- /Ticket Data -->
								
								<!-- Ticket Data -->
								<li class="ticket-data">
								
									<!-- Ticket Overview -->
									<div class="ticket-overview">
										<ul>
											<li class="ticket-data-ticket">
												#13659
											</li>
											<li class="ticket-data-activity">
												<a href="#" class="ticket-open-details">Vivamus sit amet sapien est</a>
												<p>New Ticket</p>
											</li>
											<li class="ticket-data-user">
												<strong>Javier Zulauf</strong>
												Systectio USA
											</li>
											<li class="ticket-data-priority">
												<span class="tag green">Low</span>
											</li>
											<li class="ticket-data-age">
												3 days
											</li>
										</ul>
									</div>
									<!-- /Ticket Overview -->
									
									<!-- Ticket Details -->
									<div class="ticket-details">
										<h4>Vivamus sit amet sapien est</h4>
										<dl>
											<dt>Opened:</dt>
											<dd><strong>3 days ago</strong></dd>
											<dt>Last updated:</dt>
											<dd><strong>11 hours ago</strong></dd>
											<dt>Milestone:</dt>
											<dd><strong>N/A</strong></dd>
											<dt class="clear">Reported by:</dt>
											<dd><strong>Javier Zulauf</strong></dd>
											<dt>Assigned to:</dt>
											<dd><strong>Anybody</strong></dd>
											<dt>Tags:</dt>
											<dd><strong>N/A</strong></dd>
										</dl>
										<h5>Description</h5>
										<p>Aenean magna massa, condimentum id tristique eu, accumsan vel enim. Morbi et risus vel quam convallis eleifend non nec neque. Sed pellentesque malesuada interdum. Nunc malesuada nulla in velit posuere porta. Ut nec turpis nibh, ut luctus magna.</p>
										<ul class="ticket-details-actions">
											<li><a href="#" class="button gray">Update ticket</a></li>
											<li><a href="#" class="button red">Close ticket</a></li>
										</ul>
									</div>
									<!-- /Ticket Details -->
									
								</li>
								<!-- /Ticket Data -->
								
								<!-- Ticket Data -->
								<li class="ticket-data">
								
									<!-- Ticket Overview -->
									<div class="ticket-overview">
										<ul>
											<li class="ticket-data-ticket">
												#13658
											</li>
											<li class="ticket-data-activity">
												<a href="#" class="ticket-open-details">Donec porta interdum placerat!</a>
												<p>New Ticket</p>
											</li>
											<li class="ticket-data-user">
												<strong>Matt Muench</strong>
												Systems GmbH
											</li>
											<li class="ticket-data-priority">
												<span class="tag green">Low</span>
											</li>
											<li class="ticket-data-age">
												3 days
											</li>
										</ul>
									</div>
									<!-- /Ticket Overview -->
									
									<!-- Ticket Details -->
									<div class="ticket-details">
										<h4>Donec porta interdum placerat!</h4>
										<dl>
											<dt>Opened:</dt>
											<dd><strong>3 days ago</strong></dd>
											<dt>Last updated:</dt>
											<dd><strong>20 hours ago</strong></dd>
											<dt>Milestone:</dt>
											<dd><strong>N/A</strong></dd>
											<dt class="clear">Reported by:</dt>
											<dd><strong>Mathew</strong></dd>
											<dt>Assigned to:</dt>
											<dd><strong>Anybody</strong></dd>
											<dt>Tags:</dt>
											<dd><strong>N/A</strong></dd>
										</dl>
										<h5>Description</h5>
										<p>Aliquam gravida sapien sit amet quam consectetur vitae vehicula dolor tempor. Etiam vitae purus sem. Aenean imperdiet, ante a interdum vehicula, justo nulla rutrum dolor, a adipiscing turpis orci vitae nisi. Cras sit amet tortor a ligula feugiat placerat sit amet porttitor magna.</p>
										<ul class="ticket-details-actions">
											<li><a href="#" class="button gray">Update ticket</a></li>
											<li><a href="#" class="button red">Close ticket</a></li>
										</ul>
									</div>
									<!-- /Ticket Details -->
									
								</li>
								<!-- /Ticket Data -->
								
								<!-- Ticket Data -->
								<li class="ticket-data">
								
									<!-- Ticket Overview -->
									<div class="ticket-overview">
										<ul>
											<li class="ticket-data-ticket">
												#13657
											</li>
											<li class="ticket-data-activity">
												<a href="#" class="ticket-open-details">Curabitur varius suscipit nibh, eu venenatis lectus</a>
												<p>New Ticket</p>
											</li>
											<li class="ticket-data-user">
												<strong>Max Granata</strong>
												Adobell, Inc
											</li>
											<li class="ticket-data-priority">
												<span class="tag green">Low</span>
											</li>
											<li class="ticket-data-age">
												3 days
											</li>
										</ul>
									</div>
									<!-- /Ticket Overview -->
									
									<!-- Ticket Details -->
									<div class="ticket-details">
										<h4>Curabitur varius suscipit nibh, eu venenatis lectus sodales sit amet</h4>
										<dl>
											<dt>Opened:</dt>
											<dd><strong>3 days ago</strong></dd>
											<dt>Last updated:</dt>
											<dd><strong>11 hours ago</strong></dd>
											<dt>Milestone:</dt>
											<dd><strong>N/A</strong></dd>
											<dt class="clear">Reported by:</dt>
											<dd><strong>Max Granata</strong></dd>
											<dt>Assigned to:</dt>
											<dd><strong>Anybody</strong></dd>
											<dt>Tags:</dt>
											<dd><strong>N/A</strong></dd>
										</dl>
										<h5>Description</h5>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam at nisi orci, eget congue orci. Aliquam dictum venenatis erat, vel porta massa pellentesque et. Sed blandit, odio sit amet sollicitudin iaculis, quam nisi sodales enim, ut blandit enim nisi in urna.</p>
										<ul class="ticket-details-actions">
											<li><a href="#" class="button gray">Update ticket</a></li>
											<li><a href="#" class="button red">Close ticket</a></li>
										</ul>
									</div>
									<!-- /Ticket Details -->
									
								</li>
								<!-- /Ticket Data -->
								
							</ul>
							<!-- /Tickets-->
							
						</div>
						<!-- /Side Tab Content #sidetab6 -->
						
					</div>
					<!-- /Side Tab Container -->
					
				</section>
				<!-- /Article Content -->
				
				<!-- Article Footer -->
				<footer>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et <a href="#">dignissim metus</a>. Maecenas id augue ac metus tempus aliquam. Sed pharetra placerat est suscipit sagittis.</p>
				</footer>
			<!-- /Article Footer -->
			
			</div>
			<!-- /Article Container -->
			
		</article>
		<!-- /Full Content Block -->
		
		<!-- Notification -->
		<div class="notification error">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p><strong>Error notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
		</div>
		<!-- /Notification -->
		
		<!-- Notification -->
		<div class="notification success">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p><strong>Success notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
		</div>
		<!-- /Notification -->
		
		<!-- Notification -->
		<div class="notification information">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p><strong>Information notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
		</div>
		<!-- /Notification -->
		
		<!-- Notification -->
		<div class="notification attention">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p><strong>Attention notification</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
		</div>
		<!-- /Notification -->
		
		<!-- Notification -->
		<div class="notification note">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p><strong>Note</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.</p>
		</div>
		<!-- /Notification -->
		
		<!-- Sample Modal -->
		<article id="sample" class="modal">
			<h2>nyroModal</h2>
			<p>Ajax Call, Ajax Call with targeting content, Single Image, Images Gallery with arrow navigating, Gallery with any kind of content, Form, Form in iframe, Form with targeting content, Form with file upload, Form with file upload with targeting content, Dom Element, Manual Call, Iframe, Stacked Modals, Many embed element through Embed.ly API, Error handling, Modal will never goes outside the view port, Esc key to close the window, Customizable animation, Customizable look, Modal title.</p>
			<a href="http://nyromodal.nyrodev.com/" class="outside">http://nyromodal.nyrodev.com</a>
		</article>
		<!-- /Sample Modal -->
	
	</section>
	<!-- /Main Content -->
	*/
	?>

	</div>
	<!-- /Fixed Layout Wrapper -->

	<!--
	<script src="js/libs/selectivizr.js"></script>
	<script src="js/jquery/jquery.nyromodal.js"></script>
	<script src="js/jquery/jquery.tipsy.js"></script>
	<script src="js/jquery/jquery.wysiwyg.js"></script>
	<script src="js/jquery/jquery.datatables.js"></script>
	<script src="js/jquery/jquery.datepicker.js"></script>
	<script src="js/jquery/jquery.fileinput.js"></script>
	<script src="js/jquery/jquery.fullcalendar.min.js"></script>
	<script src="js/jquery/excanvas.js"></script>
	<script src="js/jquery/jquery.visualize.js"></script>
	<script src="js/jquery/jquery.visualize.tooltip.js"></script>
	<script src="js/script.js"></script>
	-->

	<?php
		$txt = (isset($template['partials']['pre_jquery'])) ? $template['partials']['pre_jquery'] : '';
		echo $txt;
	?>

	<?=	theme_js('libs/selectivizr.js'); ?>
	<?=	theme_js('jquery/jquery.nyromodal.js'); ?>
	<?=	theme_js('jquery/jquery.tipsy.js'); ?>
	<?=	theme_js('jquery/jquery.wysiwyg.js'); ?>
	<?=	theme_js('jquery/jquery.datatables.js'); ?>
	<?=	theme_js('jquery/jquery.datepicker.js'); ?>
	<?=	theme_js('jquery/jquery.fileinput.js'); ?>
	<?=	theme_js('jquery/jquery.fullcalendar.min.js'); ?>
	<?=	theme_js('jquery/excanvas.js'); ?>
	<?=	theme_js('jquery/jquery.visualize.js'); ?>
	<?=	theme_js('jquery/jquery.visualize.tooltip.js'); ?>
	<?=	theme_js('script.js'); ?>

	<?php
		$txt = (isset($template['partials']['post_jquery'])) ? $template['partials']['post_jquery'] : '';
		echo $txt;

		$assets = Asset::get_assets('js', null, TRUE);
		echo $assets;
	?>
	<!--
	<script>
		var _gaq=[['_setAccount','UA-XXXXXXX'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
	-->

</body>
</html>