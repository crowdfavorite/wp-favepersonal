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
	
	/* Add JavaScript to pages with the comment form to support threaded comments (when in use). */
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
// Admin side
else {
	/* Let's load some styles that will be used on all theme setting pages */
	wp_enqueue_style('cf-admin-css', $assets.'css/admin.css', array(), CFCT_THEME_VERSION);
}

function cfct_html5_shim() { ?>
<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php
}
add_action('wp_head', 'cfct_html5_shim', 7);

function cfct_ie_css_overrides() { ?>
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/assets/css/ie7.css?ver=<?php echo CFCT_URL_VERSION; ?>" />
	<style type="text/css" media="screen">
		#featured-posts .featured:hover .featured-content {
			background-color: <?php echo cf_kuler_color('light', 'featured_posts_hover_content_background'); ?>;
		}
	</style>
<![endif]-->
<?php
}
add_action('wp_head', 'cfct_ie_css_overrides', 8);

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