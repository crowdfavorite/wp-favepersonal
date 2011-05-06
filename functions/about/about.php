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
$favicon_subdir = '/uploads/favicons';
define('CFCP_FAVICON_URL', WP_CONTENT_URL.$favicon_subdir);
define('CFCP_FAVICON_DIR', WP_CONTENT_DIR.$favicon_subdir);

// Init
	include_once('widget/about.php');
	if (is_admin()) {
		include_once('lib/cf-favicon-fetch.class.php');
	}

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
	
	// Add link to the admin menu bar
	function cfcp_about_admin_bar() {
		global $wp_admin_bar;
		if (current_user_can('manage_options')) {
			$wp_admin_bar->add_menu(array(
				'id' => 'cfcp-about',
				'title' => __('About', 'cfcp-about'),
				'href' => admin_url('themes.php?page='.basename(__FILE__)),
				'parent' => 'appearance'
			));
		}
	}
	add_action('wp_before_admin_bar_render', 'cfcp_about_admin_bar');
	
	
	function cfcp_about_admin_form() {
		$settings = cfcp_about_get_settings();
		include('views/admin-view.php');
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
		if (!empty($settings['links'])) {
			$u = new CF_Favicon_Fetch(CFCP_FAVICON_DIR);
			foreach ($settings['links'] as &$link) {
				$link['title'] = esc_html($link['title']);
				$link['url'] = esc_url($link['url']); // might not want to do this as it'll foobar relative urls
				
				if (!empty($link['url'])) {
					// we need the filename without the extension so that
					// we can compare the name to see if we need to re-fetch 
					// the ico for this link
					$curricon = false;
					if (!empty($link['favicon']) && $link['favicon'] !== 'default') {
						$finfo = pathinfo($link['favicon']); // PATHINFO_FILENAME is not available 'till 5.2...
						$curricon = $finfo['filename'];
					}

					switch(true) {
						case (empty($link['favicon']) || $link['favicon'] == 'default'):	
							// favicon is new or we want to re-evaluate a previous 'default' status
							$fetch = true;
							break;
						case !is_file(CFCP_FAVICON_DIR.'/'.$link['favicon']): 				
							// favicon file has been purged
							$fetch = true;
							break;
						case $u->make_filename($link['url']) != $curricon: 					
							// old filename doesn't match calculated filename from POST data
							$fetch = true;
							break;
						default:
							$fetch = false;
					}
					
					if ($fetch) {
							$a = $u->get_favicon($link['url']);
							if (!empty($a) && $a != 'default') {
								$link['favicon'] = basename($a);
							}
							else {
								$link['favicon'] = 'default';
							}
					}
				}
			}
		}
		
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
	}

	function cf_about_favicon_url($favicon) {
		// in the future the $favicon will come in as just a filename
		if ($favicon == 'default') {
			$favicon_url = trailingslashit(get_template_directory_uri()).'img/default-favicon.png';
		}
		else {
			$favicon_url = CFCP_FAVICON_URL.'/'.$favicon;
		}
		return $favicon_url;
	}
?>