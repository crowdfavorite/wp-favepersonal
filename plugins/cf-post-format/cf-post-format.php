<?php
/*
Plugin Name: CF Post Formats
Plugin URI: http://crowdfavorite.com
Description: Custom post format admin screens
Version: dev
Author: crowdfavorite
Author URI: http://crowdfavorite.com 
*/

/**
 * Copyright (c) 2011 crowdfavorite. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

define('CFPF_VERSION', '0.1');

function cfpf_init() {
	global $pagenow;
	if (is_admin() && in_array($pagenow, array('post.php', 'post-new.php'))) {
		switch(true) {
			case empty($_GET['post_type']):
				$post_type = 'post';
				break;
			case !empty($_GET['post_type']):
				$post_type = $_GET['post_type'];
				break;
			default:
				global $post;	
				$post_type = $post->post_type;
		}
		
		if (post_type_supports($post_type, 'post-formats') && current_theme_supports('post-formats')) {
			// assets
			wp_enqueue_script('cf-post-format', get_bloginfo('template_directory').'/plugins/cf-post-format/js/admin.js', array('jquery'), CFPF_VERSION);
			//wp_enqueue_style('cf-post-format', get_bloginfo('template_directory').'/css/admin.css', array(), CFPF_VERSION, 'screen');
			wp_enqueue_style('cf-post-format', get_bloginfo('template_directory').'/plugins/cf-post-format/css/admin.css', array(), CFPF_VERSION, 'screen');
			
			// actions
			add_action('edit_form_advanced', 'cfpf_post_admin_setup');
		}
	}
}
add_action('admin_init', 'cfpf_init');

/**
 * Show the post format navigation tabs
 * A lot of cues are taken from the `post_format_meta_box`
 *
 * @return void
 */
function cfpf_post_admin_setup() {
	$post_formats = get_theme_support('post-formats');
	if (!empty($post_formats[0]) && is_array($post_formats[0])) {
		global $post;
		$current_post_format = get_post_format($post->ID);

		// support the possibility of people having hacked in custom 
		// post-formats or that this theme doesn't natively support
		// the post-format in the current post - a tab will be added
		// for this format but the default WP post UI will be shown ~sp
		if (!empty($current_post_format) && !in_array($current_post_format, $post_formats[0])) {
			array_push($post_formats[0], get_post_format_string($current_post_format));
		}
		
		array_unshift($post_formats[0], 'standard');
		
		$post_formats = $post_formats[0];
		include('views/tabs.php');
		
	}
}

?>