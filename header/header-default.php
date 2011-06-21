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
(is_home() && !empty($blog_desc)) ? $title_description = ' - '.$blog_desc : $title_description = '';
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes() ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes() ?>> <!--<![endif]-->
<head>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name'), 1 ).$title_description; ?></title>
	<?php /*
	Empty conditional comment prevents blocking downloads in IE8. Good ol' IE.
	See http://www.phpied.com/conditional-comments-block-downloads/ for more info. */ ?>
	<!--[if IE]><![endif]-->
	
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
		#header #nav-main ul li,
		#header .menu ul li {
			border-bottom: 3px solid <?php echo cf_kuler_color('darkest'); ?>;
		}
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
		#header #nav-main ul ul li,
		#header #nav-main ul ul li:hover,
		#header #nav-main ul ul li.current_page_item,
		#header .menu ul ul li,
		#header .menu ul ul li:hover,
		#header .menu ul ul li.current_page_item {
			border-bottom: 0;
		}
		#header #nav-main ul ul li.current_page_item > a,
		#header .menu ul ul li.current_page_item > a {
			border-left: 3px solid <?php echo cf_kuler_color('darkest'); ?>;
			border-right: 3px solid <?php echo cf_kuler_color('darkest'); ?>;
		}

		/** Masthead
		 -------------------------------------------------- */
		#masthead {
			background-color: <?php echo cf_kuler_color('dark'); ?>;
		}
		/* featured posts */
		#featured-posts .featured {
			background-color: <?php echo cf_kuler_color('darkest') ?>;
		}
		#featured-posts .featured-title {
			background-color: <?php echo cf_kuler_color('darkest') ?>;
			color: <?php echo cf_kuler_color('lightest') ?>;
		}
		#featured-posts .featured-content {
			color:<?php echo cf_kuler_color('lightest') ?>;
		}
		#featured-posts .featured-link {
			border-color: <?php echo cf_kuler_color('darkest') ?>;
		}
		/* rollover */
		#featured-posts .featured:hover .featured-content {
			background-color: rgb(<?php echo_hex(cf_kuler_color('light')); ?>); /* fallback for IE */
			background-color: rgba(<?php echo_hex(cf_kuler_color('light')); ?>, .8);
			color: <?php echo cf_kuler_color('darkest') ?>;
		}
		/* header image */
		#header-image img {
			border-color: <?php echo cf_kuler_color('darkest') ?>;
		}
		
		/** Post
		 -------------------------------------------------- */
		.post-title {
			color: <?php echo cf_kuler_color('dark'); ?>;
		}
		.post-media a:hover {
			border-bottom-color: <?php echo cf_kuler_color('medium'); ?>;
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

		/** Sidebar, Widgets, Search Results
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
		.bio-box-gallery-images,
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
		.widget_search form,
		.search-title {
			color: <?php echo cf_kuler_color('dark'); ?>;
			background-color: <?php echo cf_kuler_color('light'); ?>;
		}
		.search-title em {
			color: <?php echo cf_kuler_color('darkest'); ?>;
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
		.post .gallery-img-excerpt li a:hover {
			border-bottom-color: <?php echo cf_kuler_color('medium'); ?>;
		}
		.post .gallery-img-excerpt li.gallery-view-all a {
			background-color: <?php echo cf_kuler_color('lightest'); ?>;
		}
		.post .gallery-img-excerpt li.gallery-view-all a:hover {
			background-color: <?php echo cf_kuler_color('light'); ?>;
		}
		.post .gallery-thumbs a:hover {
			border-bottom-color: <?php echo cf_kuler_color('medium'); ?>;
		}
		.post .gallery-thumbs a.activated {
			border-bottom-color: <?php echo cf_kuler_color('darkest'); ?>;
		}

		
		/* Social */
		#social a {
			color: <?php echo cf_kuler_color('dark'); ?>;
		}
		#social .social-title,
		#social .social-nav,
		#social .social-nav a span {
			background-color: <?php echo cf_kuler_color('light'); ?>;
		}
		#social .social-title {
			color: <?php echo cf_kuler_color('dark'); ?>;
			padding: 6px 10px 3px;
		}
		#social .social-nav a,
		#social .social-post-form button,
		#facebook_signin,
		#twitter_signin {
			background-color: <?php echo cf_kuler_color('dark'); ?>;
		}
		#social .social-nav a:hover {
			background-color: <?php echo cf_kuler_color('medium'); ?>;
		}
		.link-screenshot:hover {
			border-bottom-color: <?php echo cf_kuler_color('medium'); ?>;
		}		
	</style>

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/css/ie7.css?ver=<?php echo CFCT_URL_VERSION; ?>" />
		<style type="text/css" media="screen">
			#featured-posts .featured:hover .featured-content {
				background-color: <?php echo cf_kuler_color('light'); ?>;
			}
		</style>
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
		<div class="container clearfix">
			<h1><a href="<?php bloginfo('url') ?>/" title="Home" rel="home"><?php bloginfo('name') ?></a></h1>
			<?php wp_nav_menu( array(
				'container' => 'nav',
				'container_id' => 'nav-main',
				'theme_location' => 'main',
				'depth' => 2
			)); ?>
		</div><!-- .container -->
	</header><!-- #header -->
	
<?php

cfcp_header_display();

?>	
	
	<section id="content">
		<div class="container clearfix">
