<?php

/*
Plugin Name: Header Settings
Description: Choose what to display in the header: 3 featured post, header image, or nothing
Version: dev
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/

// This is just the start for working HTML

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
    $cfcp_admin_header_styles = get_bloginfo('template_url').'/css/masthead.css';
    echo '<link rel="stylesheet" type="text/css" href="' . $cfcp_admin_header_styles . '" />';
}
add_action('admin_head', 'cfcp_admin_header_css');

// The settings form, page content
	function cfcp_header_admin_form() {
?>

		<div class="wrap cf cf-clearfix">
			<h2><?php _e('Header Settings', 'favepersonal'); ?></h2>

			<div id="cfp-header-settings">
				<form id="cfcp-header-settings" name="cfcp-header-settings" action="" method="">
					
					<ul id="cfp-header-options">
						<li id="cfp-header-featured" class="cfp-selected"> <!-- set .cfp-selected class to it open -->
							<label>
								<input type="radio" name="cfp-header-option" value=""> Featured Posts
							</label>
							<div class="cfp-header-preview">
								<?php cfct_misc('header-featured-posts'); ?>
							</div><!--.cfp-featured-preview-->
						</li>
						<li id="cfp-header-image">
							<label>
								<input type="radio" name="cfp-header-option" value=""> Header Image
							</label>
							<div class="cfp-header-preview">
								<?php cfct_misc('header-image'); ?>
							</div><!--.cfp-image-preview-->
						</li>
						<li id="cfp-header-none">
							<label>
								<input type="radio" name="cfp-header-option" value=""> Remove Header
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