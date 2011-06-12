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

load_theme_textdomain('favepersonal');

/**
 * Set this to "true" to turn on debugging mode.
 * Debug helps with development by showing you the paths of the files loaded by Carrington.
 */
define('CFCT_DEBUG', false);

define('CFCT_PATH', trailingslashit(TEMPLATEPATH));

/**
 * Theme version.
 */
define('CFCT_THEME_VERSION', '1.0');

/**
 * Theme URL version.
 * Added to query var at the end of assets to force browser cache to reload after upgrade.
 */
define('CFCT_URL_VERSION', '0.2');

/**
 * Includes
 */
include_once(CFCT_PATH.'carrington-core/carrington.php');
include_once(CFCT_PATH.'functions/sidebars.php');
include_once(CFCT_PATH.'functions/gallery.php');
include_once(CFCT_PATH.'functions/about/about.php');
include_once(CFCT_PATH.'functions/header.php');
include_once(CFCT_PATH.'plugins/load.php');

/**
 * Removing theme settings from carrington-core, will replace with favepersonal settings
 */
//remove_action('admin_menu', 'cfct_admin_menu');

/**
 * Theme Setup
 */
if ( ! function_exists( 'carrington_personal_setup' ) ) {
	function carrington_personal_setup() {
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );

		// New image sizes that are not overwrote in the admin
		add_image_size('tiny-img', 80, 60, true); // thumbnails for full gallery
		add_image_size('thumb-img', 160, 120, true); // gallery excerpt
		add_image_size('small-img', 310, 180, true); // masthead featured img, bio box
		add_image_size('medium-img', 510, 510, false); // excerpt image-format
		add_image_size('large-img', 710, 700, false); // single view for image
		add_image_size('gallery-large-img', 710, 474, false); // large size for gallery (~3:2 aspect ratio)
		add_image_size('banner-img', 510, 180, true); // excerpt featured img
		
		// Add post formats
		add_theme_support(
			'post-formats', 
			array(
				'status',
				'link',
				'image',
				'gallery',
				'video',
				'quote',
			)
		);
		
		register_nav_menus(array(
			'main' => __( 'Main Navigation', 'favepersonal' ),
			'footer' => __( 'Footer Navigation', 'favepersonal' )
		));
		
		// Let's load some scripts
		if (!is_admin()) {
			wp_enqueue_script('cfcp-global');
		}
		
		add_action('admin_head', 'cf_admin_css');
	}
}
add_action( 'after_setup_theme', 'carrington_personal_setup' );

/* Let's load some styles that will be used on all theme setting pages */
function cf_admin_css() {
	$cf_admin_styles = get_bloginfo('template_url').'/css/admin.css';
	echo '<link rel="stylesheet" type="text/css" href="' . $cf_admin_styles . '" />';
}

// Remove default Carrington-Core theme settings screen
remove_action('admin_menu', 'cfct_admin_menu');

// Register Scripts
wp_register_script('jquery-cycle', get_template_directory_uri().'/js/jquery.cycle.all.min.js', array('jquery'), '2.99', true);
wp_register_script('cfcp-global', get_bloginfo('template_directory').'/js/global.js', array('jquery'), CFCT_URL_VERSION);

// feed permalink for link posts

function cfp_the_permalink_rss($url) {
	global $post;
	if (has_post_format('link', $post)) {
		$link = get_post_meta($post->ID, '_format_link_url', true);
		if (!empty($link)) {
			$url = $link;
		}
	}
	return $url;
}
add_filter('the_permalink_rss', 'cfp_the_permalink_rss');

// Convert color to RGB so we can use background opacity
function hex2rgb( $color ) {
	if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
	}
	if ( strlen( $color ) == 6 ) {
		list( $r, $g, $b ) = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		list( $r, $g, $b ) = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return false;
	}
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	return array( $r, $g, $b );
}
function echo_hex($color2hex) {
	$color_array = hex2rgb($color2hex);
	for ($i=0; $i < 3; $i++) { 
		echo $color_array[$i].',';
	}
}

// Replaces "[...]" with something more pretty
function cfcp_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'cfcp_excerpt_more' );

// Common Relative date formatting. Uses plugins/cf-compat/
function cfcp_date() {
	global $post;
	$date_format = get_option('date_format');
	return cf_relative_time_ago($post->post_date_gmt, '', 'ago', '4', $date_format, '', true);
}
function cfcp_comment_date() {
	global $comment;
	$date_format = get_option('date_format');
	return cf_relative_time_ago($comment->comment_date_gmt, '', 'ago', '4', $date_format, '', true);
}

// admin utility
function cfp_get_popover_html($popover_id, $params = array()) {
	$html = $class = '';

	if (!empty($params['html'])) {
		$html = $params['html'];
	}

	if (!empty($params['class'])) {
		$class = esc_attr($params['class']);
	}

	$arrow_pos = 'center';
	if (!empty($params['arrow_pos'])) {
		$arrow_pos = esc_attr($params['arrow_pos']);
	}

	$display = 'none';
	if (!empty($params['display'])) {
		$display = esc_attr($params['display']);
	}

	return cfcp_load_view('misc/admin-popover-template.php', compact('popover_id', 'html', 'arrow_pos', 'class', 'display'));
}

/**
 * Load a view file.
 * File path is relative to the theme root
 *
 * @param string $file 
 * @param string $params 
 * @return void
 */
function cfcp_load_view($file, $params) {
	$file = trailingslashit(get_template_directory()).$file;
	$html = '';

	if (is_file($file)) {
		ob_start();
		extract($params);
		include($file);
		$html = ob_get_clean();
	}

	return $html;
}


//
// Working HTML for featured post position HTML
//
add_action( 'add_meta_boxes', 'cfp_set_featured_position' );
/* Adds a box to the main column on the Post and Page edit screens */
function cfp_set_featured_position() {
	add_meta_box(
		'cfp-set-featured-position',
		__( 'Featured Post Position', 'myplugin_textdomain' ),
		'cfp_featured_position_content',
		'post',
		'advanced',
		'high'
	);
}
/* Prints the box content */
function cfp_featured_position_content() {	
	echo '
	<ul class="cf-clearfix">
		<li id="cfp-featured-position-1" class="cfp-featured-preset">
			<h4 class="cfp-featured-title">Really really long title that wraps to the next line</h4>
			<p class="cfp-featured-meta">Post Type &middot; May, 31 2011</p>
		</li>
		<li id="cfp-featured-position-2">
			<h4 class="cfp-featured-title">Title</h4>
			<p class="cfp-featured-meta">Post Type &middot; May, 31 2011</p>
		</li>
		<li id="cfp-featured-position-3">
			<h4 class="cfp-featured-title">Title</h4>
			<p class="cfp-featured-meta">Post Type &middot; May, 31 2011</p>
		</li>
	</ul>
	';
}
//END featured post position HTML