<?php
// Load bundler config.
include_once(CFCT_PATH.'assets/config.php');
// Load custom color styles
include_once(CFCT_PATH.'assets/css/colors.php');
$assets = trailingslashit(get_bloginfo('template_url')) . 'assets/';

if (!is_admin()) {
	
	// Enqueue bundles compiled by bundler script
	foreach (Bundler::$build_profiles as $bundler) {
		$bundles = $bundler->get_bundles();
		foreach($bundles as $bundle) {
			if (CFCT_PRODUCTION) {
				enqueue_bundle($bundle->get_language(), $bundle->get_bundle_key(), $assets . $bundle->get_bundled_path(), $bundle->get_meta('dependencies'), CFCT_THEME_VERSION);
			}
			else {
				foreach($bundle->get_bundle_items() as $bundle_item) {
					enqueue_bundle($bundle->get_language(), $bundle_item->get_key(), $assets . $bundle_item->get_path(), $bundle->get_meta('dependencies'), CFCT_THEME_VERSION);
				}
			}
		}
	}
	
	// Register Scripts
	wp_register_script('jquery-cycle', $assets.'js/jquery.cycle.all.min.js', array('jquery'), '2.99', true);
}
// Admin side
else {
	/* Let's load some styles that will be used on all theme setting pages */
	wp_enqueue_style('cf-admin-css', $assets.'css/admin.css', array(), CFCT_THEME_VERSION);
}

function enqueue_bundle($language, $key, $path, $dependencies, $version) {
	switch($language) {
		case 'javascript':
			wp_enqueue_script($key, $path, $dependencies, $version);
			break;
		case 'css':
			wp_enqueue_style($key, $path, $dependencies, $version);
			break;
	}
}

?>