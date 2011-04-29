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
define('CFCP_FAVICON_DIR', WP_CONTENT_URL . '/uploads/favicons');

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
		// temporary image processing
		$settings['images'] = trim($settings['images']);
		if (!empty($settings['images'])) {
			$settings['images'] = explode(',', $settings['images']);
			$settings['images'] = array_map('trim', $settings['images']);
		}
		// links processing
		foreach ($settings['links'] as &$link) {
			$link['title'] = esc_html($link['title']);
			$link['url'] = esc_url($link['url']); // might not want to do this as it'll foobar relative urls
			if (!empty($link['url'])) {
								
			}
		}
		
		return $settings;
	}
	
// Utility

	function cfcp_get_site_favicon_info() {
		// use Yahoo YQL service to grab the icon from the html source
		$api_url = "http://query.yahooapis.com/v1/public/yql?";
		// $yql = "q=select%20*%20from%20html%20where%20url%3D%22".$url.
		// 		"%22and%20xpath%3D%22/html/head/link[@rel%3D'icon']%20".
		// 		"|%20/html/head/link[@rel%3D'ICON']%20|%20/html/head/link[@rel%3D'shortcut%20icon']%20".
		// 		"|%20/html/head/link[@rel%3D'SHORTCUT%20ICON']%22".
		// 		"&format=json&callback=grab";
		$yql = urlencode("q=select * from html where url=\"".$url.
				"\" and xpath=\"/html/head/link[@rel='icon'] ".
				"| /html/head/link[@rel='ICON'] | /html/head/link[@rel='shortcut icon'] ".
				"| /html/head/link[@rel='SHORTCUT ICON']\"".
				"&format=json&callback=grab");
		$r = wp_remote_get($yql);
		pp($r);
		
		// fallback to grab the file from the webroot
		
	}

	function cfcp_about_get_settings() {
		return get_option(CFCP_ABOUT_SETTINGS, array(
			'title' => null,
			'description' => null,
			'images' => array(),
			'links' => array()
		));
	}

	function cf_about_favicon_url($favicon) {
		// in the future the $favicon will come in as just a filename
		if ($favicon == 'default') {
			$favicon_url = trailingslashit(get_template_directory_uri()).'img/default-favicon.png';
		}
		else {
			$favicon_url = $favicon;
		}
		return $favicon;
	}
?>