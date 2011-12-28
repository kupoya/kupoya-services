<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<title>Login | Chromatron Admin Theme</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	
	<?php echo $template['metadata']; ?>
	<?php //echo $template['partials']['metadata']; ?>

	<!-- CSS Styles
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/colors.css">
	<link rel="stylesheet" href="css/jquery.tipsy.css">
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
	<?=	theme_js('libs/modernizr-1.7.min.js'); ?>

</head>
<body class="login">
	<section role="main">
	
	<?php echo $template['body']; ?>
		
	</section>

	<!-- JS Libs at the end for faster loading -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="js/jquery/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
	<!--
	<script src="js/libs/selectivizr.js"></script>
	<script src="js/jquery/jquery.tipsy.js"></script>
	<script src="js/login.js"></script>
	-->

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
	<?= theme_js('login.js'); ?>


	<!-- Article Footer -->
	<footer>
		<?php //echo $template['partials']['footer']; ?>
	</footer>
	<!-- /Article Footer -->

</body>
</html>