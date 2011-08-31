<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2011 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * **********************************************************************
 */

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

$blog_desc = get_bloginfo('description');
$title_description = (is_home() && !empty($blog_desc) ? ' - '.$blog_desc : '');
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes() ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset') ?>" />
	<title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name'), 1 ).$title_description; ?></title>
	<?php /*
	Empty conditional comment prevents blocking downloads in IE8. Good ol' IE.
	See http://www.phpied.com/conditional-comments-block-downloads/ for more info. */ ?>
	<!--[if IE]><![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header id="header">
		<div class="container clearfix">
			<h1 id="site-name"><a href="<?php echo home_url('/'); ?>" title="<?php _e('Home', 'favepersonal'); ?>"><?php bloginfo('name') ?></a></h1>
			<nav id="nav-main">
				<h1><?php _e('Main Navigation', 'favepersonal'); ?></h1>
				<?php wp_nav_menu( array(
					'container' => '',
					'theme_location' => 'main',
					'depth' => 2
				)); ?>
			</nav>
		</div><!-- .container -->
	</header><!-- #header -->
	
<?php

cfcp_header_display();

?>	
	
	<section id="content">
		<div class="container clearfix">