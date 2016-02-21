<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="author" content="DmitriyB">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?php wp_head(); ?>

</head>

<body>
<header class="head-wrapper">
	<div class="head">
    	<div class="head-logo"><a href="<?php echo site_url(); ?>"><img src="<?php echo THEMEROOT; ?>/images/logo.jpg" alt="" /></a></div>
        <div class="head-banner"><img src="<?php echo THEMEROOT; ?>/images/728x90.jpg" alt="" /></div>
    </div>
</header>
<div class="menu-wrapper">
	<div class="menu-main">
    <?php
        if (!dynamic_sidebar('menu_header')) :
        endif;
    ?>
 
        <ul class="ico-social">
        	<li><a href="#"><img src="<?php echo THEMEROOT; ?>/images/ico-vk.png" alt="мы вконтакте"/></a></li>
            <li><a href="#"><img src="<?php echo THEMEROOT; ?>/images/ico-youtobe.png" alt="" /></a></li>
            <li><a href="#"><img src="<?php echo THEMEROOT; ?>/images/ico-facebook.png" alt="" /></a></li>
            <li><a href="#"><img src="<?php echo THEMEROOT; ?>/images/ico-twitter.png" alt="" /></a></li>
        </ul>   
    </div>
</div>