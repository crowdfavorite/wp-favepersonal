<?php

// Choose what to display in the header: 3 featured post, header image, or nothing

/*

# Process

Header admin screen allows choosing between featured posts, image or nothing. Featured posts are chosen on the individual post page and the location is stored in post meta. When a post is published, it will occupy the selected slot (removing any previous post that was there).


# Data Formats

## Options

cfcp_header = array(
	'type' => 'featured|image|none',
	'posts' => array( // post ids
		'_1' => 123,
		'_2' => 124,
		'_3' => 125,
	),
	'image_url' => 'http://...', // image URL
);

## Post Meta

_cfcp_header_slot = 0|1|2|3

*/

function cfcp_header_options($key = null) {
	$defaults = array(
		'type' => 'none',
		'posts' => array(
			'_1' => null,
			'_2' => null,
			'_3' => null,
		),
		'image_url' => null
	);
	if ($options = get_option('cfcp_header_options')) {
		$data = $options;
	}
	else {
		$data = $defaults;
	}
	if (empty($key)) {
		return $data;
	}
	else if (isset($data[$key])) {
		return $data[$key];
	}
	else {
		return false;
	}
}

function cfcp_header_featured_publish_post($post_id, $post) {
/*
- find previous post in slot
- remove previous post in slot (meta)
- update post in slot (options)
*/
}
add_action('publish_post', 'cfcp_header_featured_publish_post', 10, 2);

// Admin Page
function cfcp_header_admin_menu() {
	add_submenu_page(
		'themes.php',
		__('Header', 'favepersonal'),
		__('Header', 'favepersonal'),
		'manage_options',
		basename(__FILE__),
		'cfcp_header_admin_form'
	);
}
add_action('admin_menu', 'cfcp_header_admin_menu');

// Add link to the admin menu bar
function cfcp_header_admin_bar() {
	global $wp_admin_bar;
	if (current_user_can('manage_options')) {
		$wp_admin_bar->add_menu(array(
			'id' => 'cfcp-header',
			'title' => __('Header', 'cfcp-header'),
			'href' => admin_url('themes.php?page='.basename(__FILE__)),
			'parent' => 'appearance'
		));
	}
}
add_action('wp_before_admin_bar_render', 'cfcp_header_admin_bar');

// Loading style sheets
function cfcp_admin_header_css() {
	global $pagenow, $plugin_page;
	if ($pagenow == 'themes.php' && $plugin_page == 'header.php') {
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_url').'/css/masthead.css' . '" />';
	}
	// Specific styles to over ride WP styles
	echo '<style type="text/css" media="screen">
		#cfp-header-featured #featured-posts h2.featured-title {
			font-family: Helvetica, Verdana, Arial, sans-serif;
			font-size: 18px;
			line-height: 20px;
			text-shadow: none;
			padding: 6px 15px 7px;
		}
		</style>';
}
add_action('admin_head', 'cfcp_admin_header_css');

// The settings form, page content
function cfcp_header_admin_form() {
//	$type = cfcp_header_options('type');
	$type = 'none';
?>

	<div class="wrap cf cf-clearfix">
		<h2><?php _e('Header Settings', 'favepersonal'); ?></h2>

		<div id="cfp-header-settings">
			<form id="cfcp-header-settings" name="cfcp-header-settings" action="" method="">
				
				<ul id="cfp-header-options">
					<li id="cfp-header-featured" class="cfp-selected"> <!-- set .cfp-selected class to it open -->
						<label for="cfcp-header-type-featured">
							<input type="radio" name="cfcp-header-type" id="cfcp-header-type-featured" value="featured" <?php checked('featured', $type); ?>> <?php _e('Featured Posts', 'favepersonal'); ?>
						</label>
						<div class="cfp-header-preview">
							<?php cfct_misc('header-featured-posts'); ?>
						</div><!--.cfp-featured-preview-->
					</li>
					<li id="cfp-header-image">
						<label for="cfcp-header-type-image">
							<input type="radio" name="cfcp-header-type" id="cfcp-header-type-image" value="image" <?php checked('image', $type); ?>> <?php _e('Header Image', 'favepersonal'); ?>
						</label>
						<div class="cfp-header-preview">
							<?php cfct_misc('header-image'); ?>
						</div><!--.cfp-image-preview-->
					</li>
					<li id="cfp-header-none">
						<label for="cfcp-header-type-none">
							<input type="radio" name="cfcp-header-type" id="cfcp-header-type-none" value="none" <?php checked('none', $type); ?>> <?php _e('No Header', 'favepersonal'); ?>
						</label>
					</li>
				</ul>

				<p class="submit"><input class="button button-primary" type="submit" name="submit" value="<?php _e('Save Settings', 'favepersonal'); ?>" /></p>
			</form>
		</div><!--#cfp-header-->
	</div><!--.cf wrap -->

<?php
}
?>