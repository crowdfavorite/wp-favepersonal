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

$blog_desc = get_bloginfo('description');
(is_home() && !empty($blog_desc)) ? $title_description = ' - '.$blog_desc : $title_description = '';
?>
<!DOCTYPE html>
<!--[if IE]><![endif]-->
<html <?php language_attributes() ?>>
<head>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />

	<title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name'), 1 ).$title_description; ?></title>

	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'carrington-personal' ), esc_attr( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'carrington-personal' ), esc_attr( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	
	<link rel="stylesheet" type="text/css" media="screen, print, handheld" href="<?php bloginfo('template_url') ?>/css/css.php?ver=<?php echo CFCT_URL_VERSION; ?>" />
	<style type="text/css" media="screen">
		/* This is only colors, plan to get this working from /css/color.php */
		body {
			background-color: <?php echo cf_kuler_color('dark'); ?>;
		}
		a {
			color: <?php echo cf_kuler_color('darkest'); ?>;
			text-decoration: none;
		}
		a:hover {
			color: <?php echo cf_kuler_color('medium'); ?>;
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
		}
		.featured-title a {
			background-color: <?php echo cf_kuler_color('darkest') ?>;
			color: <?php echo cf_kuler_color('lightest') ?>;
		}
		.featured-content {
			color:<?php echo cf_kuler_color('lightest') ?>;
		}
		.featured-link {
			border-color: <?php echo cf_kuler_color('darkest') ?>;
		}
		/* rollover */
		.featured:hover .featured-title a {
			color: <?php echo cf_kuler_color('medium') ?>;
		}
		.featured:hover .featured-content {
			background-color: rgba(<?php echo_hex(cf_kuler_color('light')); ?>.9);
			color: <?php echo cf_kuler_color('darkest') ?>;
		}
		.featured:hover .featured-link {
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
		
		/** Comments
		 -------------------------------------------------- */
		.mcc-comment-inner:hover .mcc-posted-from {
			background-color: <?php echo cf_kuler_color('dark'); ?>;
		}
		.notification {
			background-color: <?php echo cf_kuler_color('lightest'); ?>;
			color: <?php echo cf_kuler_color('dark'); ?>;
		}

		/** Sidebar
		 -------------------------------------------------- */
		.bio-box a {
			color: <?php echo cf_kuler_color('darkest'); ?>;
		}
		.bio-box a:hover {
			color: <?php echo cf_kuler_color('lightest'); ?>;
		}
		.bio-box-gallery a.bio-carousel-nav:hover {
			background-color: <?php echo cf_kuler_color('medium'); ?>;
		}
		.bio-box-content,
		.bio-box-links {
			background-color: <?php echo cf_kuler_color('medium'); ?>;
			color: <?php echo cf_kuler_color('lightest'); ?>;
		}
		.bio-box-title {
			color: <?php echo cf_kuler_color('darkest'); ?>;
		}
		.bio-box-links ul li a:hover {
			border-color: <?php echo cf_kuler_color('darkest'); ?>;
		}
		.widget-title,
		.widget_search form {
			color: <?php echo cf_kuler_color('dark'); ?>;
			background-color: <?php echo cf_kuler_color('light'); ?>;
		}
		.widget_search form #s {
			color: <?php echo cf_kuler_color('darkest'); ?>;
		}
		.widget_search form label {
			color: <?php echo cf_kuler_color('dark'); ?>;
		}
		.widget_search form label.focus {
			color: <?php echo cf_kuler_color('medium'); ?>;
		}
		.widget_search form #searchsubmit:hover,
		.widget_search form #searchsubmit:focus {
			background-color: <?php echo cf_kuler_color('dark'); ?>;
		}
		.widget_search form #searchsubmit:active {
			background-color: <?php echo cf_kuler_color('darkest'); ?>;
		}

		/** Footer
		 -------------------------------------------------- */
		#footer {
			color: <?php echo cf_kuler_color('lightest'); ?>;
			background-color: <?php echo cf_kuler_color('dark'); ?>;
		}
		#footer a {
			color: <?php echo cf_kuler_color('light'); ?>;
		}
		
		/** Utilities
		 -------------------------------------------------- */
		.wp-caption dd {
			color: <?php echo cf_kuler_color('dark'); ?>;
			background-color: <?php echo cf_kuler_color('lightest'); ?>;
		}
		.gallery-img-excerpt li.gallery-view-all a {
			background-color: <?php echo cf_kuler_color('lightest'); ?>;
		}
		.gallery-img-excerpt li.gallery-view-all a:hover {
			background-color: <?php echo cf_kuler_color('light'); ?>;
		}
		.gallery-thumbs a:hover {
			border-bottom-color: <?php echo cf_kuler_color('medium'); ?>;
		}
		.gallery-thumbs a.activated {
			border-bottom-color: <?php echo cf_kuler_color('darkest'); ?>;
		}
	</style>

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->


<?php
	/* Add JavaScript to pages with the comment form to support threaded comments (when in use). */
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );		
	}
	
	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
	
	<header id="header">
		<div class="container">
			<h1><a href="<?php bloginfo('url') ?>/" title="Home" rel="home"><?php bloginfo('name') ?></a></h1>
			<?php wp_nav_menu( array(
				'container' => 'nav',
				'container_id' => 'nav-main',
				'theme_location' => 'main',
				'depth' => 2
			)); ?>
		</div><!-- .container -->
	</header><!-- #header -->
	
	
	<section id="masthead">
		<div class="container clearfix">
			<div class="col-a">
				<article class="featured has-featured-img">
					<img src="<?php bloginfo('template_url'); ?>/img/fpo-300x170-1.jpg" width="310" height="180" class="featured-img" />
					<div class="featured-content">
						<h2 class="featured-title"><a href="">Praesent Placerat</a></h2>
						<div class="featured-description">
							<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>							
						</div>
					</div>
					<a href="" class="featured-link">Read More</a>
				</article><!-- .featured -->
			</div><!-- .col-a -->
			<div class="col-b">
				<article class="featured has-featured-img">
					<img src="<?php bloginfo('template_url'); ?>/img/fpo-300x170-2.jpg" width="310" height="180" class="featured-img" />
					<div class="featured-content">
						<h2 class="featured-title"><a href="">Vestibulum Auctor Dapibus</a></h2>
						<div class="featured-description">
							<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
						</div>
					</div>
					<a href="" class="featured-link">Read More</a>
				</article><!-- .featured -->
			</div><!-- .col-b -->
			<div class="col-c">
				<article class="featured">
					<div class="featured-content">
						<h2 class="featured-title"><a href="">Integer Vitae Libero</a></h2>
						<div class="featured-description">
							<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
						</div>
					</div>
					<a href="" class="featured-link">Read More</a>
				</article><!-- .featured -->
			</div><!-- .col-c -->
		</div><!-- .container -->
	</section><!-- #masthead -->
	
	
	<section id="content">
		<div class="container clearfix">
