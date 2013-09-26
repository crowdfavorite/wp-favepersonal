<?php

/*
Plugin Name: About Settings & Widget
Description: About&hellip;
Version: 1.0.1
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/

define('CFCP_ABOUT_VERSION', '1.0.1');
define('CFCP_ABOUT_SETTINGS', 'cfcp_about_settings');

// Init
include_once('widget/about.php');
if (is_admin()) {
	include_once('lib/cf-favicon-fetch.class.php');
}

function cfcp_about_admin_init() {
	global $pagenow, $plugin_page;
	if ($pagenow == 'themes.php' && $plugin_page == 'about.php') {
		wp_register_script(
			'jquery-popover', 
			get_template_directory_uri().'/assets/js/cf-popover/jquery.cf.popover.min.js',
			array('jquery', 'jquery-ui-position'),
			CFCP_ABOUT_VERSION
		);
		wp_enqueue_script(
			'o-type-ahead',
			get_template_directory_uri().'/assets/js/o-type-ahead.js',
			array('jquery'),
			CFCP_ABOUT_VERSION
		);
		wp_enqueue_script(
			'cfcp-about-admin-js',
			get_template_directory_uri().'/functions/about/js/about-admin.js',
			array('jquery', 'jquery-ui-sortable', 'jquery-ui-position', 'jquery-popover'),
			CFCP_ABOUT_VERSION
		);
		wp_localize_script(
			'cfcp-about-admin-js', 
			'cfcp_about_settings', 
			array(
				'image_del_confirm' => __('Remove this image from the carousel?', 'favepersonal'),
				'favicon_fetch_error' => __('Could not fetch the favicon for: ', 'favepersonal'),
				'add' => __('Add', 'favepersonal'),
				'loading' => __('Loading...', 'favepersonal'),
				'err_link_title' => __('Please enter a title.', 'favepersonal'),
				'err_link_url' => __('Please enter a valid URL (http://...).', 'favepersonal'),
			)
		);
	}
	register_setting(CFCP_ABOUT_SETTINGS, CFCP_ABOUT_SETTINGS, 'cfcp_about_settings_validate');
}
add_action('admin_init', 'cfcp_about_admin_init');

/**
 * Conditionally enqueue the cycle script only if the about carousel is being used
 *
 * @return void
 */
function cfcp_about_module_carousel_enqueue() {
	$settings = cfcp_about_get_settings();
	$images_count = 0;
	if (isset($settings['images'])) {
		$images_count = count($settings['images']);
	}
	
	if (
		!is_admin()
		&& $images_count > 1
		&& is_active_widget(null, null, 'cfcp-about')
	) {
		wp_enqueue_script('jquery-cycle'); // registered in the theme's functions.php file
	}
}
add_action('wp', 'cfcp_about_module_carousel_enqueue', 11);

// Ajax

/**
 * Generic Ajax handler
 *
 * @return void
 */
function cfcp_about_admin_ajax() {
	if (!empty($_POST['cfcp_about_action'])) {
		switch($_POST['cfcp_about_action']) {
			case 'cfcp_image_search':
				$results = cfcp_about_image_search(array(
					'key' => $_POST['key'],
					'term' => $_POST['cfp-img-search-term'],
					'exclude' => (!empty($_POST['cfcp_search_exclude']) ? array_map('intval', $_POST['cfcp_search_exclude']) : array())
				));

				$ret = array(
					'success' => (!empty($results) ? true : false),
					'key' => $_POST['key'],
					'html' => (!empty($results) ? $results : '<div class="cfp-img-search-no-results">'.__('No results found.', 'favepersonal').'</div>')
				);
				
				break;
			case 'cfcp_fetch_favicon':
				usleep(500000); // pause for 1/2 second to allow the spinner to at least display in the admin
				
				$u = new CF_Favicon_Fetch(cfcp_about_get_favicon_dir());
				$favicon = $u->have_site_favicon($_POST['url']);

				if (empty($favicon)) {
					$success = false;
					$favicon = $u->get_site_favicon_url($_POST['url']);

					if (!empty($favicon)) {
						$success = true;
						$favicon_status = 'new';
					}
					else {
						$success = false;
						$favicon = cfcp_about_favicon_url('default');
						$favicon_status = 'default';
					}
				}
				else {
					$success = true;
					$favicon = cfcp_about_favicon_url($favicon);
					$favicon_status = 'local';
				}
				
				$ret = array(
					'success' => $success,
					'favicon_url' => $favicon,
					'favicon_status' => $favicon_status
				);
				
				break;
			case 'cfcp_save_favicon':
				$success = false;
				$error = '';
				$link = array(
					'title' => trim($_POST['link']['title']),
					'url' => trim($_POST['link']['url']), // if we need to support relative urls then the esc_url will have to go
					'favicon' => trim($_POST['link']['favicon']),
					'favicon_status' => trim($_POST['link']['favicon_status']),
				);

				$qs = strpos($link['favicon'], '?');
				if ($qs !== false) {
					$link['favicon'] = substr($link['favicon'], 0, $qs);
				}

				// fetch
				if (!empty($link['url']) && !empty($link['title'])) {
					if ($link['favicon_status'] == 'new') {

						$u = new CF_Favicon_Fetch(cfcp_about_get_favicon_dir());						
						$a = $u->get_favicon($link['url']);
				
						if (!empty($a) && $a != 'default') {
							$link['favicon'] = basename($a);
							$link['favicon_status'] = 'local';
						}
						else {
							$link['favicon'] = 'default';
							$link['favicon_status'] = 'local';
						}

						if (!empty($link['favicon'])) {
							$success = true;
						}
						else {
							$error = $u->get_last_error();
						}
					}
					elseif ($link['favicon_status'] == 'local' || $link['favicon_status'] == 'default') {
						if ($link['favicon_status'] == 'default') {
							$link['favicon'] = 'default';
						}
						else {
							$link['favicon'] = basename($link['favicon']);
						}
						$success = true;
					}
					elseif ($link['favicon_status'] == 'custom') {
						$u = new CF_Favicon_Fetch(cfcp_about_get_favicon_dir());						
						// download and save favicon
						$f_data = $u->fetch_favicon($link['favicon']);
						$filename = $u->make_filename($link['url'], $f_data['ext']);
						if ($u->save_file($filename, $f_data) !== false) {
							$link['favicon'] = $filename;
							$link['favicon_status'] = 'local';
							$success = true;
						}
					}
				}
				else {
					if (empty($link['title'])) {
						$error += '<p>'.__('Please enter a valid link title.', 'favepersonal').'</p>';
					}
					if (empty($link['url'])) {
						$error += '<p>'.__('Please enter a valid link URL.', 'favepersonal').'</p>';
					}
				}

				// formulate response
				if ($success) {
					$ret = array(
						'success' => true,
						'html' => cfct_template_content(
							'functions/about/views',
							'link-item',
							compact('link')
						)
					);
				}
				else {
					$ret = array(
						'success' => false,
						'error' => $error
					);
				}
				
				break;
		}
		header('Content-Type: application/json');
		echo json_encode($ret);
		exit;
	}
}
add_action('wp_ajax_cfcp_about', 'cfcp_about_admin_ajax');

/**
 * Perform image search
 *
 * @param array $params 
 * @return array
 */
function cfcp_about_image_search($params) {
	$imgs = new WP_Query(array(
		's' => trim(stripslashes($params['term'])),
		'posts_per_page' => 12,
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'post_status' => 'inherit',
		'post__not_in' => (!empty($params['exclude']) ? (array) $params['exclude'] : array()),
		'order' => 'ASC',
		'fields' => 'ids'
	));

	$ret = '';
	if (!empty($imgs->posts)) {
		$post_type_object = get_post_type_object('attachment');
		$img_size = 'tiny-img';
		foreach ($imgs->posts as $img_id) {
			$ret .= '<li class="cfp-search-result">'.cfct_template_content(
				'functions/about/views',
				'image-item',
				compact('img_id', 'post_type_object', 'img_size')
			).'</li>';
		}
	}
	
	if (!empty($ret)) {
		$ret = '<ul>'.$ret.'</ul>';
	}

	return $ret;
}

// Admin Page

function cfcp_about_admin_menu() {
	add_theme_page(
		__('Bio Widget', 'favepersonal'),
		__('Bio Widget', 'favepersonal'),
		'edit_theme_options',
		basename(__FILE__),
		'cfcp_about_admin_form'
	);
}
add_action('admin_menu', 'cfcp_about_admin_menu');

// Add link to the admin menu bar
function cfcp_about_admin_bar() {
	global $wp_admin_bar;
	if (current_user_can('edit_theme_options')) {
		$wp_admin_bar->add_menu(array(
			'id' => 'cfcp-about',
			'title' => __('Bio Widget', 'favepersonal'),
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

function cfcp_about_settings_validate($settings) {
	// this is an array of attachment post-ids
	if (!empty($settings['images'])) {
		$settings['images'] = array_map('intval', $settings['images']);
	}
	
	// links processing - for consistency of editing and to make 
	// sortables easy each link is json_encoded in to a single
	// hidden element
	if (!empty($settings['links'])) {
		foreach ($settings['links'] as &$link) {
			if (!is_array($link)) {
				$link = json_decode($link, true);
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

function cfcp_about_favicon_url($favicon = 'default') {
	// in the future the $favicon will come in as just a filename
	if ($favicon == 'default') {
		$favicon_url = trailingslashit(get_template_directory_uri()).'assets/img/default-favicon.png';
	}
	else {
		$favicon_url = trailingslashit(cfcp_about_get_favicon_dir_url()).$favicon;
	}
	return $favicon_url;
}

function cfcp_about_get_favicon_dir_url() {
	$upload_dir_info = wp_upload_dir();
	return apply_filters(
		'cfcp_about_favicon_dir_url',
		trailingslashit($upload_dir_info['baseurl']).'favicons'
	);
}

function cfcp_about_get_favicon_dir() {
	$upload_dir_info = wp_upload_dir();
	return apply_filters(
		'cfcp_about_favicon_dir',
		trailingslashit($upload_dir_info['basedir']).'favicons'
	);
}
