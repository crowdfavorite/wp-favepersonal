<?php

// Choose what to display in the header: 3 featured post, header image, or nothing

function cfcp_header_admin_init() {
	if (cfcp_header_options('type') == 'featured') {
		add_action('add_meta_boxes', 'cfcp_set_featured_position');
	}
}
add_action('admin_init', 'cfcp_header_admin_init');

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

function cfcp_header_featured_meta($post_id = null) {
	if (!$post_id) {
		$post_id = get_the_ID();
	}
	return intval(get_post_meta($post_id, '_cfcp_header_slot', true));
}

// getter/setter function
function cfcp_header_options($key = null, $val = null) {
	$posts = array(
		'_1' => null,
		'_2' => null,
		'_3' => null,
	);
	$data = get_option('cfcp_header_options', array(
		'type' => 'featured',
		'posts' => $posts
	));
	if (!is_array($data)) {
		$data = array();
	}
	if (!isset($data['type'])) {
		$data['type'] = 'featured';
	}
	if (!isset($data['posts'])) {
		$data['posts'] = $posts;
	}
	// if we have a val, save and return
	if (!empty($val)) {
		$data[$key] = $val;
		return update_option('cfcp_header_options', $data);
	}
	// return data
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

function cfcp_header_unfeature_post($post_id) {
	$posts = cfcp_header_options('posts');
	if (in_array($post_id, $posts)) {
		foreach ($posts as $k => $v) {
			if ($v == $post_id) {
				$posts[$k] = null;
			}
		}
		cfcp_header_options('posts', $posts);
	}
}

function cfcp_header_featured_save_post($post_id, $post) {
	if (!defined('XMLRPC_REQUEST') && isset($_POST['_cfcp_header_slot']) && $post->post_type != 'revision') {
		$val = intval($_POST['_cfcp_header_slot']);
		if ($val == 0) {
			cfcp_header_featured_clear_post($post_id);
		}
		else {
			update_post_meta($post_id, '_cfcp_header_slot', $val);
			if ($post->post_status == 'publish') {
				remove_action('publish_post', 'cfcp_header_featured_publish_post');
				cfcp_header_featured_publish_post($post_id);
			}
			else {
				cfcp_header_unfeature_post($post_id);
			}
		}
	}
}
add_action('save_post', 'cfcp_header_featured_save_post', 10, 2);

function cfcp_header_featured_publish_post($post_id) {
	if ($slot = get_post_meta($post_id, '_cfcp_header_slot', true)) {
// remove post from any other slots
		cfcp_header_unfeature_post($post_id);
// find previous post in slot
		$posts = cfcp_header_options('posts');
		$prev_id = (!empty($posts['_'.$slot]) ? $posts['_'.$slot] : false);
		if ($prev_id != $post_id) {
			if ($prev_id) {
// remove previous post in slot (meta)
				delete_post_meta($prev_id, '_cfcp_header_slot');
			}
			$posts['_'.$slot] = $post_id;
			cfcp_header_options('posts', $posts);
		}
	}
}
add_action('publish_post', 'cfcp_header_featured_publish_post');

function cfcp_header_featured_clear_post($post_id) {
	delete_post_meta($post_id, '_cfcp_header_slot');
	cfcp_header_unfeature_post($post_id);
}
add_action('trash_post', 'cfcp_header_featured_clear_post');
add_action('delete_post', 'cfcp_header_featured_clear_post');

function cfcp_header_options_fields($html) {
	$type = cfcp_header_options('type');

	ob_start();
?>
				<ul id="cfp-header-options">
					<li id="cfp-header-featured">
						<label for="cfcp-header-type-featured">
							<input type="radio" name="cfcp_header_options[type]" id="cfcp-header-type-featured" value="featured" <?php checked('featured', $type); ?>> <?php _e('Featured Posts', 'favepersonal'); ?>
							<img src="<?php echo get_template_directory_uri(); ?>/functions/header/img/header-option-posts.png" alt="<?php _e('Featured Posts', 'favepersonal'); ?>" height="56" width="250" />
						</label>
						<p><?php _e('Defaults to 3 most recent Posts. Set a featured post and position from an Edit Post screen.', 'favepersonal'); ?></p>
					</li>
					<li id="cfp-header-image">
						<label for="cfcp-header-type-image">
							<input type="radio" name="cfcp_header_options[type]" id="cfcp-header-type-image" value="image" <?php checked('image', $type); ?>> <?php _e('Header Image', 'favepersonal'); ?>
							<img src="<?php echo get_template_directory_uri(); ?>/functions/header/img/header-option-image.png" alt="<?php _e('Header Image', 'favepersonal'); ?>" height="56" width="250" />
						</label>
						<p><a href="<?php echo admin_url('themes.php?page=custom-header'); ?>"><?php _e('Upload or choose a header image', 'favepersonal'); ?></a></p>
					</li>
					<li id="cfp-header-none">
						<label for="cfcp-header-type-none">
							<input type="radio" name="cfcp_header_options[type]" id="cfcp-header-type-none" value="none" <?php checked('none', $type); ?>> <?php _e('No Header', 'favepersonal'); ?>
						</label>
					</li>
				</ul>
<?php
	$html = ob_get_clean();

	echo $html;
}
add_filter('cfct_option_cfcp_header', 'cfcp_header_options_fields');

// make a few changes to the default header image screen
function cfcp_custom_header_options() {
?>
<script type="text/javascript">
jQuery(function($) {
	$('.wrap h2:first').append('<div class="updated"><p><?php printf( __( 'This theme supports multiple header options, <a href="%s">manage your theme options here</a>.' ), admin_url( 'themes.php?page=carrington-settings' ) ); ?></p></div>');
	$('#removeheader').closest('tr').remove();
});
</script>
<?php
}
add_action('custom_header_options', 'cfcp_custom_header_options');

function cfcp_header_custom_menu_text() {
	remove_submenu_page('themes.php', 'custom-header');
	global $custom_image_header;
	add_theme_page(
		__('Header Image', 'favepersonal'),
		__('Header Image', 'favepersonal'),
		'edit_theme_options',
		'custom-header',
		array(&$custom_image_header, 'admin_page')
	);
}
add_action('admin_menu', 'cfcp_header_custom_menu_text', 100);

function cfcp_header_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('header');
	if (current_user_can('edit_theme_options')) {
		$wp_admin_bar->add_menu(array(
			'parent' => 'appearance',
			'id' => 'header',
			'title' => __('Header Image', 'favepersonal'),
			'href' => admin_url('themes.php?page=custom-header')
		));
	}
}
add_action('wp_before_admin_bar_render', 'cfcp_header_admin_bar');

// Adds a box to the main column on the Post and Page edit screens
function cfcp_set_featured_position() {
	add_meta_box(
		'cfp-set-featured-position',
		__('Featured Post Position', 'favepersonal'),
		'cfcp_header_featured_slot_form',
		'post',
		'normal',
		'high'
	);
}

function cfcp_header_featured_slot_form() {
	global $post;
// get featured posts
	$featured_ids = cfcp_header_options('posts');
// echo 3 boxes
?>
	<ul class="cf-clearfix">
<?php
	foreach ($featured_ids as $slot => $id) {
		$featured = (!empty($id) ? get_post($id) : false);
		cfcp_header_featured_slot_item($post, $featured, str_replace('_', '', $slot));
	}
?>
	</ul>
	<input type="hidden" name="_cfcp_header_slot" id="_cfcp_header_slot" value="<?php echo cfcp_header_featured_meta($post->ID); ?>" />
	<script type="text/javascript">
	jQuery(function($) {
		$('#cfp-set-featured-position li').click(function() {

// if already selected, deselect
			var c = $(this).attr('class');
			if (typeof c != 'undefined' && c.indexOf('cfp-featured-') != -1) {
				$('#_cfcp_header_slot').val('0');
				$(this).removeClass('cfp-featured-pending').removeClass('cfp-featured-set')
			}
			else {
// select
				$('#_cfcp_header_slot').val($(this).attr('id').replace('cfp-featured-position-', ''));
				$(this).siblings().removeClass('cfp-featured-pending').removeClass('cfp-featured-set').end().addClass('cfp-featured-pending');
			}
		});
	});
	</script>
<?php
}

function cfcp_header_featured_slot_item($post, $featured, $i = 1) {
// set class
	if (cfcp_header_featured_meta($post->ID) == $i) {
		$class = 'class="'.($featured->post_status == 'publish' ? 'cfp-featured-set' : 'cfp-featured-pending').'"';
	}
	else {
		$class = '';
	}

// no post set? also handle "this post"
	if (!$featured || $post->ID == $featured->ID) {
?>
		<li id="cfp-featured-position-<?php echo $i; ?>" <?php echo $class; ?>>
			<p class="none"><?php _e('(empty)', 'favepersonal'); ?></p>
		</li>
<?php
	}
	else {
// show post type
?>
		<li id="cfp-featured-position-<?php echo $i; ?>" <?php echo $class; ?>>
			<h4 class="cfp-featured-title"><?php echo esc_html($featured->post_title); ?></h4>
			<p class="cfp-featured-meta"><?php echo esc_html(get_post_format_string(get_post_format($featured->ID))); ?> &middot; <?php echo get_the_time('F j, Y', $featured); ?></p>
		</li>
<?php
	}
}

// Front-end Display functions

function cfcp_header_display() {
	switch (cfcp_header_options('type')) {
		case 'featured':
			cfcp_header_display_featured();
		break;
		case 'image':
			cfcp_header_display_image();
		break;
		case 'none':
		default:
	}
}

function cfcp_header_featured_slots() {
	$slots = cfcp_header_options('posts');
	$count = 0;
	$ids = array();
	foreach ($slots as $post_id) {
		if (!empty($post_id)) {
			$ids[] = $post_id;
			$count++;
		}
	}

	$selected_args = apply_filters('cfcp_header_featured_slots_selected_args', array(
		'post__in' => wp_parse_id_list($ids)
	));
	$posts = new WP_Query($selected_args);
// if we have less than 3 posts set, grab the latest posts to fill the empty spots
	if ($count < 3) {
		$filler_args = apply_filters('cfcp_header_featured_slots_filler_args', array(
			'posts_per_page' => (3 - $count),
			'post__not_in' => wp_parse_id_list($ids)
		));
		$filler = new WP_Query($filler_args);
	}
// run the slots
	$filler_i = 0;
	foreach ($slots as $slot => $post_id) {
		if (empty($post_id) && count($filler->posts)) {
			$slots[$slot] = $filler->posts[$filler_i]->ID;
			unset($filler->posts[$filler_i]);
			$filler_i++;
		}
	}
	return $slots;
}

function cfcp_header_display_featured() {
	global $more;
	$_more = $more;
	$more = 1;
	$post_ids = cfcp_header_featured_slots();
	ob_start();
	foreach ($post_ids as $slot => $post_id) {
		cfcp_header_display_featured_post(str_replace('_', '', $slot), $post_id);
	}
	$content = ob_get_clean();
	cfct_template_file('header', 'featured-posts', compact('content'));
	$more = $_more;
}

function cfcp_header_display_featured_post($slot, $post_id) {
	if (empty($post_id)) {
		$file = 'empty';
	}
	else {
		$file = 'default';
		if ($post_format = get_post_format($post_id)) {
// find files
			$format_files = cfct_files(CFCT_PATH.'header/featured');
// check for format file, or fall to default
			if (count($format_files) && in_array('format-'.$post_format.'.php', $format_files)) {
				$file = 'format-'.$post_format;
			}
		}
	}
	cfct_template_file('header/featured', $file, compact('slot', 'post_id'));
}

function cfcp_header_display_image() {
	cfct_template_file('header', 'featured-image');
}
