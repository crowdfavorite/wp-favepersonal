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
			add_action('admin_head', 'cf_admin_css');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('o-type-ahead', get_template_directory_uri().'/js/o-type-ahead.js', array('jquery'), CFCP_ABOUT_VERSION);
			wp_enqueue_script('cfcp-about-admin-js', get_template_directory_uri().'/functions/about/js/about-admin.js', array('jquery'), CFCP_ABOUT_VERSION);
			wp_localize_script('cfcp-about-admin-js', 'cfcp_about_settings', array(
				'image_del_confirm' => __('Are you sure you want to delete this image?', 'carrington-personal'),
				'favicon_fetch_error' => __('Could not fetch the favicon for: ', 'carrington-personal')
			));
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
	
	/* Let's load some styles that will be used on all theme setting pages */
	function cf_admin_css() {
	    $cf_admin_styles = get_bloginfo('template_url').'/css/admin.css';
	    echo '<link rel="stylesheet" type="text/css" href="' . $cf_admin_styles . '" />';
	}
	
// Ajax

	/**
	 * Generic Ajax handler
	 *
	 * @return void
	 */
	function cfcp_about_admin_ajax() {
		if (!empty($_POST['cfp_about_action'])) {
			switch($_POST['cfp_about_action']) {
				case 'cfp_image_search':
					$results = cfp_about_image_search(array(
							'key' => $_POST['key'],
							'term' => $_POST['cfp-image-search-term'],
							'exclude' => (!empty($_POST['cfp_search_exclude']) ? array_map('intval', $_POST['cfp_search_exclude']) : array())
						));
					
					$ret = array(
						'success' => (!empty($results) ? true : false),
						'key' => $_POST['key'],
						'html' => (!empty($results) ? $results : '<div class="cfp-img-search-no-results">'.__('No results found.', 'carrington-personal').'</div>')
					);
					
					break;
				case 'cfp_fetch_favicon':
					usleep(500000); // pause for 1/2 second to allow the spinner to at least display in the admin
					
					$u = new CF_Favicon_Fetch(CFCP_FAVICON_DIR);
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
							$favicon = cf_about_favicon_url('default');
							$favicon_status = 'default';
						}
					}
					else {
						$success = true;
						$favicon = cf_about_favicon_url($favicon);
						$favicon_status = 'local';
					}
					
					$ret = array(
						'success' => $success,
						'favicon_url' => $favicon,
						'favicon_status' => $favicon_status
					);
					
					break;
				case 'cfp_save_favicon':
					$success = false;
					$error = '';
					$link = array(
						'title' => esc_html(trim($_POST['link']['title'])),
						'url' => trim($_POST['link']['url']), // if we need to support relative urls then the esc_url will have to go
						'favicon' => esc_html(trim($_POST['link']['favicon'])),
						'favicon_status' => esc_html(trim($_POST['link']['favicon_status'])),
					);
					
					// fetch
					if (!empty($link['url']) && !empty($link['title'])) {
						if ($link['favicon_status'] == 'new') {
							$u = new CF_Favicon_Fetch(CFCP_FAVICON_DIR);						
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
						elseif ($link['favicon_status'] == 'custum') {
							// @TODO
						}
					}
					else {
						if (empty($link['title'])) {
							$error += '<p>'.__('Please enter a valid link title.', 'carrington-personal').'</p>';
						}
						if (empty($link['url'])) {
							$error += '<p>'.__('Please enter a valid link URL.', 'carrington-personal').'</p>';
						}
					}

					// formulate response
					if ($success) {
						$ret = array(
							'success' => true,
							'html' => cfcp_load_view('functions/about/views/link-item.php', compact('link'))
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
			header('content-type: text/javascript');
			echo json_encode($ret);
			exit;
		}
	}
	add_action('wp_ajax_cfp_about', 'cfcp_about_admin_ajax');

	/**
	 * Perform image search
	 *
	 * @param array $params 
	 * @return array
	 */
	function cfp_about_image_search($params) {
		$imgs = new WP_Query(array(
			's' => trim(stripslashes($params['term'])),
			'posts_per_page' => 9,
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
				$ret .= '<li class="cfp-search-result">'.cfcp_load_view('functions/about/views/image-item.php', compact('img_id', 'post_type_object', 'img_size')).'</li>';
			}
		}
		
		if (!empty($ret)) {
			$ret = '<ul>'.$ret.'</ul>';
		}

		return $ret;
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
		// this is an array of attachment post-ids
		if (!empty($settings['images'])) {
			$settings['images'] = array_map('intval', $settings['images']);
		}
		
		// links processing - for consistency of editing and to make 
		// sortables easy each link is json_encoded in to a single
		// hidden element
		if (!empty($settings['links'])) {
			foreach ($settings['links'] as &$link) {
				$link = json_decode($link, true);
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