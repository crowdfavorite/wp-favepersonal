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

/**
 * In production mode, or doing development?
 * When true, assets/load.php will enqueue the built versions of the files
 */
define('CFCT_PRODUCTION', false);


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
include_once(CFCT_PATH.'functions/header/header.php');
include_once(CFCT_PATH.'functions/CF_Patch_Nav_Menu.php');
include_once(CFCT_PATH.'functions/admin.php');

function cfcp_load_social() {
	if (!class_exists('Social') && get_option('cfcp_social_enabled') != 'no') {
		include_once(CFCT_PATH.'plugins/social/social.php');
	}
}
add_action('after_setup_theme', 'cfcp_load_social');

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
		
		// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
		define( 'HEADER_IMAGE', '%s/functions/header/img/default.png' );
	
		define( 'HEADER_IMAGE_WIDTH', apply_filters( 'cfcp_header_image_width', 990 ) );
		define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'cfcp_header_image_height', 240 ) );
	
		set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );
	
		// Don't support text inside the header image.
		define( 'NO_HEADER_TEXT', true );
	
		add_custom_image_header( '', 'cfcp_admin_header_style' );
		
		$patch_nav = new CF_Patch_Nav_Menu();
		$patch_nav->attach_hooks();
	}
}
add_action( 'after_setup_theme', 'carrington_personal_setup' );

function cfcp_admin_header_style() {} // empty.

/**
 * Load assets at action 'wp', when conditionals like is_single are available.
 */
function cfct_load_assets() {
	include_once(CFCT_PATH.'assets/load.php');
}
add_action('init', 'cfct_load_assets');

// Dequeue Social Plugin Stylesheet
function cfcp_social_dequeue_style() {
	wp_dequeue_style('social_style_main');
}
add_action('init', 'cfcp_social_dequeue_style', 10);

/**
 * Misc other things we want added to the <head>
 */
function cfcp_head_extra() {
	echo '<link rel="pingback" href="'.get_bloginfo('pingback_url').'" />';
	wp_get_archives('type=monthly&format=link');
}
add_action('wp_head', 'cfcp_head_extra');

// feed permalink for link posts
function cfcp_the_permalink_rss($url) {
	global $post;
	if (has_post_format('link', $post)) {
		$link = get_post_meta($post->ID, '_format_link_url', true);
		if (!empty($link)) {
			$url = $link;
		}
	}
	return $url;
}
add_filter('the_permalink_rss', 'cfcp_the_permalink_rss');

// Convert color to RGB so we can use background opacity
// source - http://css-tricks.com/snippets/php/convert-hex-to-rgb/
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
		if ($i == 2) {
			echo $color_array[$i];
		} else {
			echo $color_array[$i].',';
		}
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
function cfcp_get_popover_html($popover_id, $params = array()) {
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

	return cfct_template_content(
		'misc',
		'admin-popover-template',
		compact('popover_id', 'html', 'arrow_pos', 'class', 'display')
	);
}

function cfcp_social_plugins_url($url) {
	$url = trailingslashit(get_bloginfo('template_url'));
	return $url.'plugins/social/';
}
add_filter('social_plugins_url', 'cfcp_social_plugins_url', 10, 2);
