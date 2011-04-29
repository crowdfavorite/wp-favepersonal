<?php

/*
Plugin Name: About Settings & Widget
Description: About&hellip;
Version: dev
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/

define('CFCP_ABOUT_VERSION', 0.1);
define('CFCP_ABOUT_SETTINGS', 'cfcp_about_settings');

// Init
	include_once('widget/about.php');

	function cfcp_about_init() {
		if (!is_admin()) {
			cfcp_about_module_carousel_enqueue();
		}
		else {
			wp_enqueue_script('cfcp-about-admin-js', get_template_directory_uri().'/functions/about/js/about-admin.js', array('jquery'), CFCP_ABOUT_VERSION);
		}
	}
	add_action('init', 'cfcp_about_init', 50);
	
	function cfcp_about_admin_init() {
		register_setting(CFCP_ABOUT_SETTINGS, CFCP_ABOUT_SETTINGS, 'cfcp_validate_settings');
	}
	add_action('admin_init', 'cfcp_about_admin_init');
	
	/**
	 * Conditionally enqueue the cycle script only if the about carousel is being used
	 *
	 * @return void
	 */
	function cfcp_about_module_carousel_enqueue() {
		$settings = cfcp_about_get_settings();
		if (count($settings['images']) > 1 && is_active_widget(null, null, 'cfcp-about')) {
			wp_enqueue_script('jquery-cycle'); // registered in the theme's functions.php file
		}
	}

// Admin Page

	function cfcp_about_admin_menu() {
		add_submenu_page(
			'themes.php',
			__('About', 'carrington-personal'),
			__('About', 'carrington-personal'),
			'manage_options',
			basename(__FILE__),
			'cfcp_about_admin_form'
		);
	}
	add_action('admin_menu', 'cfcp_about_admin_menu');
	
	function cfcp_about_admin_form() {
		$settings = cfcp_about_get_settings();
		include('admin-view.php');
	}
	
// Settings

	function cfcp_validate_settings($settings) {
		ep($settings);
		
		// temporary image processing
		$settings['images'] = explode(',', $settings['images']);
		$settings['images'] = array_map('trim', $settings['images']);
		
		return $settings;
	}
	
// Utility

	function cfcp_about_get_settings() {
		return get_option(CFCP_ABOUT_SETTINGS, array(
			'title' => null,
			'description' => null,
			'images' => array(),
			'links' => array()
		));
		
		// return array(
		// 	'title' => 'About Carrington Personal',
		// 	'description' => '<b>Lorem ipsum dolor sit</b> amet sed do eiusmod tempor <a href="#">incididunt</a> ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.
		// 
		// 	foo bar baz!',
		// 	'images' => array(8, 7, 6),
		// 	'links' => array(
		// 		array(
		// 			'title' => 'Flicks',
		// 			'url' => 'http://www.flickr.com/photos/tehgipster/',
		// 			'favicon' => 'http://l.yimg.com/g/favicon.ico' // temporary url
		// 		),
		// 		array(
		// 			'title' => 'Twitts',
		// 			'url' => 'https://twitter.com/#!/WookieeBoy',
		// 			'favicon' => 'http://twitter.com/phoenix/favicon.ico' // temporary url
		// 		)
		// 	)
		// );
	}

	function cf_about_favicon_url($favicon) {
		// in the future the $favicon will come in as just a filename
		return $favicon;
	}
?>