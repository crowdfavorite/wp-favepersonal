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

define('CFCT_PATH', trailingslashit(TEMPLATEPATH));

/**
 * Set this to "true" to turn on debugging mode.
 * Debug helps with development by showing you the paths of the files loaded by Carrington.
 */
define('CFCT_DEBUG', false);

/**
 * In production mode, or doing development?
 * When true, assets/load.php will enqueue the built versions of the files
 */
define('CFCT_PRODUCTION', true);

/**
 * Theme version.
 */
define('CFCT_THEME_VERSION', '1.0');

/**
 * Theme URL version.
 * Added to query var at the end of assets to force browser cache to reload after upgrade.
 */
define('CFCT_URL_VERSION', '0.3');

/**
 * Define Header Text Color, even though it isn't used in the theme, need to define to prevent Notices
 */ 
if (!(defined('HEADER_TEXTCOLOR'))) {
	define('HEADER_TEXTCOLOR', '');
}

/**
 * Includes
 */
include_once(CFCT_PATH.'carrington-core/carrington.php');
include_once(CFCT_PATH.'functions/sidebars.php');
include_once(CFCT_PATH.'functions/gallery.php');
include_once(CFCT_PATH.'functions/about/about.php');
include_once(CFCT_PATH.'functions/header/header.php');
include_once(CFCT_PATH.'functions/patch-nav-menu.php');
include_once(CFCT_PATH.'functions/admin.php');

function cfcp_load_social() {
	if (!class_exists('Social') && get_option('cfcp_social_enabled') != 'no') {
		add_filter('social_plugins_url', 'cfcp_social_plugins_url');
		add_filter('social_plugins_path', 'cfcp_social_plugins_path');
		add_action('set_current_user', array('Social', 'social_loaded_by_theme'));
		include_once(CFCT_PATH.'plugins/social/social.php');
	}
}
add_action('after_setup_theme', 'cfcp_load_social');

function cfcp_cfpf_base_url($url) {
	return get_template_directory_uri().'/plugins/cf-post-formats/';
}
add_filter('cfpf_base_url', 'cfcp_cfpf_base_url');

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

		// set primary content width
		global $content_width;
		$content_width = '510';
		
		// set default gallery dimensions
		define('CFCT_GALLERY_HEIGHT', 474);
		define('CFCT_GALLERY_WIDTH', 710);
		
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
		
		register_nav_menu( 'main', __( 'Main Navigation', 'favepersonal'));
		
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
		
		/**
		 * Remove Carrington-added rev attribute -- now deprecated in HTML5
		 */
		remove_filter('comments_popup_link_attributes', 'cfct_ajax_comment_link');
	}
}
add_action( 'after_setup_theme', 'carrington_personal_setup' );

function cfcp_image_size_input_fields_sizes($sizes) {
	$sizes['medium-img'] = 'Content Width';
	$sizes['banner-img'] = 'Content Width Short (Cropped)';
	$sizes['large-img'] = 'Full Width';
	return $sizes;
}
add_filter('image_size_names_choose', 'cfcp_image_size_input_fields_sizes');

function cfcp_admin_header_style() {} // empty.

/**
 * Load assets at action 'wp', when conditionals like is_single are available.
 */
function cfct_load_assets() {
	include_once(CFCT_PATH.'assets/load.php');
}

/**
 * Load assets at action 'init' for admin, since wp fires inconsistently on admin side
 */
function cfct_load_admin_assets() {
	include_once(CFCT_PATH.'assets/load-admin.php');
}

if (!is_admin()) {
	add_action('wp', 'cfct_load_assets');
}
else {
	add_action('init', 'cfct_load_admin_assets');
}

// Dequeue Social Plugin Stylesheet
function cfcp_social_dequeue_style() {
	wp_dequeue_style('social_comments');
}
add_action('wp_enqueue_scripts', 'cfcp_social_dequeue_style', 999);

/**
 * Misc other things we want added to the <head>
 */
function cfcp_head_extra() {
	echo '<link rel="pingback" href="'.get_bloginfo('pingback_url').'" />';
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
function hex2rgb($color) {
	if ($color[0] == '#') {
			$color = substr($color, 1);
	}
	if (strlen($color) == 6) {
		list($r, $g, $b) = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);
	}
	else if (strlen($color) == 3) {
		list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
	}
	else {
		return false;
	}
	$r = hexdec($r);
	$g = hexdec($g);
	$b = hexdec($b);
	return array($r, $g, $b);
}
function echo_hex($color2hex) {
	$color_array = hex2rgb($color2hex);
	for ($i = 0; $i < 3; $i++) {
		if ($i == 2) {
			echo $color_array[$i];
		}
		else {
			echo $color_array[$i].',';
		}
	}
}

// Replaces "[...]" with something more pretty
function cfcp_excerpt_more($more) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'cfcp_excerpt_more' );

// make status posts clickable if they include URLs
function cfcp_make_clickable($content) {
	global $post;
	if (has_post_format('status', $post)) {
		$content = make_clickable($content);
	}
	return $content;
}
add_filter('the_content', 'cfcp_make_clickable');

// Common Relative date formatting. Uses plugins/cf-compat/
function cfcp_date() {
	global $post;
	$date_format = get_option('date_format');

	// Preview?
	if (isset($_GET['preview'])) {
		return date($date_format, current_time('timestamp'));
	}
	else {
		return cf_relative_time_ago($post->post_date_gmt, '', 'ago', '4', $date_format, '', true);
	}
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
	$url = trailingslashit(get_template_directory_uri());
	return trailingslashit($url.'plugins/social');
}

function cfcp_social_plugins_path($path) {
	$path = trailingslashit(get_template_directory());
	return trailingslashit($path.'plugins/social');
}

/**
 * Build simple relative dates
 * Doesn't go too deep in to specificity as that is rarely needed
 *
 * @author http://snipplr.com/view/4912/relative-time/
 * @param string $date - date to evaluate
 * @param string $pre - default 'about' - what to put before the time output
 * @param string $post - default 'ago' - what to put after the time output
 * @param int $full_date_cutoff - default 4, how old a date should be until it gets formatted as a date string
 * @param string $format - format for date output past 4 weeks
 * @param string $pre_format - default '' - what to put before the date out past 4 weeks
 * @return string
 */
if (!function_exists('cf_relative_time_ago')) {
	function cf_relative_time_ago($date, $pre = 'about', $post = 'ago' , $full_date_cutoff = 4, $format='F j, Y', $pre_format, $gmt = false) {
		$pre .= ' ';
		$post = ' '.$post;
		$pre_format = ' ';
	
		if ($gmt) {
			$now = gmmktime();
		}
		else {
			$orig_tz = date_default_timezone_get();
			date_default_timezone_set(get_option('timezone_string'));
			$now = time();
		}
	
		if (!is_numeric($date)) { 
			$date = strtotime($date); 
		}
	
		// seconds
		$diff = $now - $date;
		if ($diff < 60){ 
			return sprintf('%1$s%2$s%3$s', $pre, sprintf(
				_n('%d second', '%d seconds', $diff), $diff), $post);
		}
		
		// minutes
		$diff = round($diff/60);
		if ($diff < 60) { 
			return sprintf('%1$s%2$s%3$s', $pre, sprintf(
				_n('%d minute', '%d minutes', $diff), $diff), $post);
		}
		
		// hours
		$diff = round($diff/60);
		if ($diff < 24) {
			return sprintf('%1$s%2$s%3$s', $pre, sprintf(
				_n('%d hour', '%d hours', $diff), $diff), $post);
		}
		
		// days
		$diff = round($diff/24);
		if ($diff < 7) { 
			return sprintf('%1$s%2$s%3$s', $pre, sprintf(
				_n('%d day', '%d days', $diff), $diff), $post);
		}
		
		// weeks
		$diff = round($diff/7);
		if ($diff <= $full_date_cutoff) { 
			return sprintf('%1$s%2$s%3$s', $pre, sprintf(
				_n('%d week', '%d weeks', $diff), $diff), $post);
		}
	
		// actual date string if farther than 4 weeks ago
		$ago = $pre_format . mysql2date($format, date('Y-m-d H:i:s', $date));
	
		if (!$gmt) {
			date_default_timezone_set($orig_tz);
		}
		return $ago;
	}
} // end exists check

/**
 * Function for trimming text.  This function takes text and length as an input, and returns
 * the text truncated to the nearest word if the length of the text is longer than the length
 *
 * @param string $text - (required) Text to truncate
 * @param string $length - Length of the truncated string to return
 * @return $text - Truncated text being returned
 */
if (!function_exists('cf_trim_text')) {
	function cf_trim_text($text, $length = 250, $before = '', $after = '') {
		// If the text field is empty or is shorter than the $length, there is no need to make it smaller
		
		/* Since servers must have MB module installed for mb_* functions, we're keeping the fallback to non-multibyte functions */
		if (function_exists('mb_strlen')) { // 
			if (empty($text) || mb_strlen($text) <= $length) {
				return $text;
			}
			if (mb_strlen($text) > $length) {
				$text = mb_substr($text, 0, $length); // cut string to proper length
				if (mb_strrpos($text, ' ')) { // if we have spaces in text, cut to the last word, not letter
					$text = mb_substr($text, 0, mb_strrpos($text, ' ')); 
				}
			}
		}
		else {
			if (empty($text) || strlen($text) <= $length) {
				return $text;
			}
			if (strlen($text) > $length) {
				$text = substr($text, 0, $length); // cut string to proper length
				if (strrpos($text, ' ')) { // if we have spaces in text, cut to the last word, not letter
					$text = substr($text, 0, strrpos($text, ' ')); 
				}
			}
		}
		// trim trailing dot if we are appending dots
		if (substr($text, -1) == '.' && (substr($after, 0, 8) == '&hellip;' || substr($after, 0, 1) == '.')) {
			$text = substr($text, 0, strlen($text) - 1);
		}
		return $before.$text.$after;
	}
} // end exists check

