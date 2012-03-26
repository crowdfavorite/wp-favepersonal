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

/**
 * Filter to add options to the theme settings page
 */ 
function cfcp_options($options) {
	unset($options['cfct']['fields']['about']);
	$yn_options = array(
		'yes' => __('Yes', 'favepersonal'),
		'no' => __('No', 'favepersonal')
	);
	
	$personal_options = array(
		'cfcp' => array(
			'label' => '',
			'description' => 'cfct_options_blank',
			'fields' => array(
				'header' => array(
					'type' => 'cfcp_header',
					'label' => __('Header Display', 'favepersonal'),
					'name' => 'header_options[type]',
				),
				'header_1' => array(
					'type' => 'hidden',
					'name' => 'header_options[posts][_1]',
				),
				'header_2' => array(
					'type' => 'hidden',
					'name' => 'header_options[posts][_2]',
				),
				'header_3' => array(
					'type' => 'hidden',
					'name' => 'header_options[posts][_3]',
				),
				'social' => array(
					'type' => 'radio',
					'label' => __('Enable Social Plugin', 'favepersonal'),
					'name' => 'social_enabled',
					'options' => $yn_options,
					'help' => '<span class="cfct-help">'.__('(Social is a plugin that allows broadcasting new post notifications to social networks and also authenticating to them for post commenting. <a href="http://crowdfavorite.com/wordpress/plugins/social/">Learn more...</a>)', 'favepersonal').'</span>',
				),
			),
		),
	);
	// cfct_array_merge_recursive($options, $personal_options); For options display after the defaults.
	
	// Note this will have defaults override our settings. Not an issue with defining the new 'cfcp' section.
	$options = cfct_array_merge_recursive($personal_options, $options);
	return $options;
}
add_filter('cfct_options', 'cfcp_options');

/**
 * Set the option prefix.
 */ 
function cfcp_option_prefix($prefix) {
	return 'cfcp';
}
add_action('cfct_option_prefix', 'cfcp_option_prefix');

/**
 * Filter for registering defaults of cfcp_options.
 */ 
function cfcp_option_defaults($defaults) {
	$defaults[cfct_option_name('social_enabled')] = 'yes';
	$defaults[cfct_option_name('cfcp_header_options')] = array(
		'posts' => array(
			'_1' => null,
			'_2' => null,
			'_3' => null,
		),
		'type' => 'featured',
	);
	return $defaults;
}
add_filter('cfct_option_defaults', 'cfcp_option_defaults');

function cfcp_options_customize() {
?>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><label><?php _e('Customize', 'favepersonal'); ?></label></th>
		<td>
			<p><?php printf(__('<a href="%s">Download Child Theme</a> (with current Colors)', 'favepersonal'), esc_url(home_url('index.php?cf_action=cfcp_child_theme_export'))); ?></p>
			<p><?php _e('<a href="http://crowdfavorite.com/wordpress/themes/favepersonal/docs/customization/" target="_blank">View Customization Tips</a> (in documentation)', 'favepersonal'); ?></p>
		</td>
	</tr>
</table>
<?php
}
add_action('cfct_settings_form_after', 'cfcp_options_customize');

/**
 * Filter theme settings page title
 */ 
function cfcp_admin_settings_title($title) {
	return __('Theme Settings', 'favepersonal');
}
add_filter('cfct_admin_settings_title', 'cfcp_admin_settings_title');
add_filter('cfct_admin_settings_form_title', 'cfcp_admin_settings_title');

