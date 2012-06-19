<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2012 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * **********************************************************************
 */

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

//delete_site_transient('update_themes'); // for testing only

function cfcp_pre_set_site_transient_update_themes($value) {

    // current_theme_info is deprecated in 3.4 - use wp_get_theme
    // by preference instead
    if (!function_exists('wp_get_theme')) {
            if (!function_exists('current_theme_info')) {
                    include_once(trailingslashit(ABSPATH).'wp-admin/includes/theme.php');
            }
            $theme = current_theme_info();
    }
    else {
            $theme = wp_get_theme();
    }
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

?>
