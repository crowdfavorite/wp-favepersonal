<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/favepersonal/
 *
 * Copyright (c) 2008-2013 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * **********************************************************************
 */

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

// delete_site_transient('update_themes'); // for testing only

function cfcp_pre_set_site_transient_update_themes($value) {
// use new function to get theme info, will now require WP 3.4
	$theme = wp_get_theme();
	$response = wp_remote_get(
		'http://api.crowdfavorite.com/wordpress/themes/favepersonal/?cf_action=version-api&request=latest&current_version='.CFCT_THEME_VERSION,
		array(
			'timeout' => 20,
			'httpversion' => '1.1'
		)
	);
	if (is_array($response) && isset($response['response']) && isset($response['response']['code']) && $response['response']['code'] == 200 && !empty($response['body'])) {
		if (strpos($response['body'], '\\\\') !== false) {
			$response['body'] = stripslashes($response['body']);
		}
		$version = json_decode($response['body']);
		if (isset($version->current_version) && version_compare(CFCT_THEME_VERSION, $version->current_version) < 0) {
			$value->response[$theme->template] = array(
				'new_version' => $version->current_version,
				'url' => $version->more_info,
			);
		}
	}
	return $value;
}
add_filter('pre_set_site_transient_update_themes', 'cfcp_pre_set_site_transient_update_themes');
