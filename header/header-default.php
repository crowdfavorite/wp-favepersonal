<?php

/**
 * @package carrington-personal
 *
 * This file is part of the Carrington Personal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/carrington-personal/
 *
 * Copyright (c) 2008-2010 Crowd Favorite, Ltd. All rights reserved.
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
?>
<!DOCTYPE html>
<!--[if IE 6]><![endif]-->
<html <?php language_attributes() ?>>
<head>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />

	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ).$title_description; ?></title>

	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'carrington-text' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'carrington-text' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	
	<link rel="stylesheet" type="text/css" media="screen, print, handheld" href="<?php bloginfo('template_url') ?>/css/css.php?ver=<?php echo CFCT_URL_VERSION; ?>" />
	<style type="text/css" media="screen">
		/* This is only colors, plan to get this working from /css/color.php */
		body {
			background-color: <?php echo cf_kuler_color('dark'); ?>;
		}
		a {
			color: <?php echo cf_kuler_color('dark'); ?>;
			text-decoration: none;
		}
		a:hover {
			color: <?php echo cf_kuler_color('darkest'); ?>;
		}
		
		/** Header
		 -------------------------------------------------- */
		#header {
			background-color: <?php echo cf_kuler_color('darkest'); ?>;
			border-bottom: 4px solid <?php echo cf_kuler_color('dark'); ?>;
		}
		#header a {
			color: <?php echo cf_kuler_color('lightest'); ?>;
		}
		#header a:hover {
			color: <?php echo cf_kuler_color('medium'); ?>;
		}
		/* Menu */
		#header #nav-main ul li:hover,
		#header #nav-main ul li.current_page_item,
		#header #nav-main ul li.current-menu-parent,
		#header .menu ul li:hover,
		#header .menu ul li.current_page_item,
		#header .menu ul li.current_page_parent {
			border-bottom: 3px solid <?php echo cf_kuler_color('dark'); ?>;
		}
		/* Sub Menu */
		#header ul ul li a:hover {
			color: <?php echo cf_kuler_color('darkest'); ?>;
		}
		#header #nav-main ul ul,
		#header .menu ul ul {
			background: <?php echo cf_kuler_color('dark'); ?>;
			border: 3px solid <?php echo cf_kuler_color('darkest'); ?>;
			border-top: 0;
		}
		#header #nav-main ul ul li:hover,
		#header #nav-main ul ul li.current_page_item,
		#header .menu ul ul li:hover,
		#header .menu ul ul li.current_page_item {
			border-bottom: 0;
		}
		#header #nav-main ul ul li.current_page_item > a,
		#header .menu ul ul li.current_page_item > a {
			border-left: 3px solid <?php echo cf_kuler_color('darkest'); ?>;
			border-right: 3px solid <?php echo cf_kuler_color('darkest'); ?>;
			padding-left: 7px;
			padding-right: 7px;
		}

		/** Masthead
		 -------------------------------------------------- */
		#masthead {
			background-color: <?php echo cf_kuler_color('dark'); ?>;
		}
		.featured {
			background-color: <?php echo cf_kuler_color('darkest') ?>;
			border: 5px solid <?php echo cf_kuler_color('darkest') ?>;
		}
		.featured-title a {
			background-color: <?php echo cf_kuler_color('darkest') ?>;
			color: <?php echo cf_kuler_color('lightest') ?>;
		}
		.featured-content {
			color:<?php echo cf_kuler_color('lightest') ?>;
		}
		/* rollover */
		.featured:hover .featured-content {
			background-color: <?php echo cf_kuler_color('dark') ?>;
		}
		.has-featured-img:hover .featured-content {
			background-color: rgba(<?php echo_hex(cf_kuler_color('dark')); ?>.75);
		}

		/** Post
		 -------------------------------------------------- */
		.post-title {
			color: <?php echo cf_kuler_color('dark'); ?>;			
		}
		.post-meta a {
			color: #999;
		}
		.post-meta a:hover {
			color: <?php echo cf_kuler_color('darkest'); ?>;
		}

		/** Sidebar
		 -------------------------------------------------- */
		.bio-box {
			background-color: <?php echo cf_kuler_color('medium'); ?>;	
			color: <?php echo cf_kuler_color('darkest'); ?>;
		}
		.bio-box a {
			color: <?php echo cf_kuler_color('darkest'); ?>;
		}
		.bio-box a:hover {
			color: <?php echo cf_kuler_color('darkest'); ?>;				
		}
		.widget-title {
			color: <?php echo cf_kuler_color('dark'); ?>;
			background-color: <?php echo cf_kuler_color('light'); ?>;
		}

		/** Footer
		 -------------------------------------------------- */
		#footer {
			background-color: <?php echo cf_kuler_color('dark'); ?>;
		}
		
		/** Utilities
		 -------------------------------------------------- */
		.wp-caption {
			color: <?php echo cf_kuler_color('dark'); ?>;
			background-color: <?php echo cf_kuler_color('light'); ?>;
		}
	</style>

<?php
	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
	
	<div id="header">
		<div class="container">
			<h1><a href="<?php bloginfo('url') ?>/" title="Home" rel="home"><?php bloginfo('name') ?></a></h1>
			<?php wp_nav_menu( array(
				'container' => 'nav',
				'container_id' => 'nav-main',
				'theme_location' => 'main',
				'depth' => 2
			)); ?>
		</div><!-- .container -->
	</div><!-- #header -->
	
	
	<div id="masthead">
		<div class="container clearfix">
			<div class="col-a">
				<div class="featured has-featured-img">
					<img src="<?php bloginfo('template_url'); ?>/img/fpo-300x170-1.jpg" class="featured-img" />
					<div class="featured-content">
						<h2 class="featured-title"><a href="">Praesent Placerat</a></h2>
						<div class="featured-description">
							<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>							
						</div>
					</div>
					<a href="" class="featured-link">Read More</a>
				</div><!-- .featured -->				
			</div><!-- .col-a -->
			<div class="col-b">
				<div class="featured has-featured-img">
					<img src="<?php bloginfo('template_url'); ?>/img/fpo-300x170-2.jpg" class="featured-img" />
					<div class="featured-content">
						<h2 class="featured-title"><a href="">Vestibulum Auctor Dapibus</a></h2>
						<div class="featured-description">
							<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
						</div>
					</div>
					<a href="" class="featured-link">Read More</a>
				</div><!-- .featured -->				
			</div><!-- .col-b -->
			<div class="col-c">
				<div class="featured">
					<div class="featured-content">
						<h2 class="featured-title"><a href="">Integer Vitae Libero</a></h2>
						<div class="featured-description">
							<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
						</div>
					</div>
					<a href="" class="featured-link">Read More</a>
				</div><!-- .featured -->				
			</div><!-- .col-c -->
		</div><!-- .container -->
	</div><!-- #masthead -->
	
	
	<div id="content">
		<div class="container clearfix">
