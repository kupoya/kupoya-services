<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?= $template['title']; ?></title>
	<?php echo $template['metadata']; ?>
	<?php //echo $template['partials']['metadata']; ?>
	
	<?=	css('style.css', '_theme_'); ?>
	<?php
		Asset::get_assets('css');		
		Asset::get_assets('js');
	?>

</head>
<body id="page5">

<div class="main">
<!-- header -->
	<header>
		<div class="wrapper">

		</div>
	</header>
<!-- / header -->
<!-- content -->
	<section id="content">

	<?php echo $template['partials']['header']; ?>
	<div class="clear">&nbsp;</div>
	 
	<?php echo $template['body']; ?>
	
	<div class="clear">&nbsp;</div>
	 
	</section>
<!-- / content -->
<!-- footer -->
	<footer>
		<?php echo $template['partials']['footer']; ?>
		<!-- 
		<a href="http://www.templatemonster.com/" target="_blank">Website template</a> designed by TemplateMonster.com<br>
		<a href="http://www.templates.com/product/3d-models/" target="_blank">3D Models</a> provided by Templates.com
		 -->
	</footer>
<!-- / footer -->
</div>
</body>
</html>