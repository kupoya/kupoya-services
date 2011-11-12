<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<title><?= $template['title']; ?></title>
	<meta http-equiv="content-type" content="text/html; charset='utf-8'" />
	<?php echo $template['metadata']; ?>
	<?php //echo $template['partials']['metadata']; ?>
	
	<?=	theme_css('admin.css'); ?>
</head>
<body>
<?php 
	print Menu::get_menu();
?>
    <div id="main">
        <div id="header">
            <a href="#" class="logo"><img src="<?= image_path('logo.gif','_theme_') ?>" width="101" height="29" alt="" /></a>
            <ul id="top-navigation">
                <li><a href="#" class="active">Homepage</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="#">Orders</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Statistics</a></li>
                <li><a href="#">Design</a></li>
                <li><a href="#">Contents</a></li>
            </ul>
        </div>
        <div id="middle">
            <div id="left-column">
            	<?php echo $template['partials']['header']; ?>
                <h3>Header</h3>
                <ul class="nav">
                    <li><a href="#">Lorem Ipsum dollar</a></li>
                    <li><a href="#">Dollar</a></li>
                    <li><a href="#">Lorem dollar</a></li>
                    <li><a href="#">Ipsum dollar</a></li>
                    <li><a href="#">Lorem Ipsum dollar</a></li>
                    <li><a href="#">Dollar Lorem Ipsum</a></li>
                </ul>
                <a href="#" class="link">Link here</a>
                <a href="#" class="link">Link here</a>
            </div>
            
            
            <div id="center-column">
            	<?php echo $template['body']; ?>
            </div>
            
            
            <div id="right-column">
                <strong class="h">Quick Info</strong>
                <div class="box">This is your admin home page. It will give you access to all things within the back end system that you will need to facilitate a smooth operation.</div>
            </div>
        </div>
        <div id="footer"><p>Developed by <a href="http://twitter.com/umutm">Umut Muhaddisoglu</a> 2008. Updated for HTML5/CSS3 by <a href="http://mediagearhead.com">Giles Wells</a> 2010.</p>
        <?php echo $template['partials']['footer']; ?>
        </div>
    </div>
</body>
</html>