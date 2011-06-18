<?php

// Choose what to display in the header: 3 featured post, header image, or nothing

function cfcp_header_admin_init() {
	register_setting('cfcp_header_options', 'cfcp_header_options', 'cfcp_header_options_validate');
	if (cfcp_header_options('type') == 'featured') {
		add_action( 'add_meta_boxes', 'cfcp_set_featured_position' );
	}
	wp_register_style( 'myPluginStylesheet', get_bloginfo('template_url') . '/css/masthead.css' );
	wp_enqueue_style( 'myPluginStylesheet' );
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
	$data = get_option('cfcp_header_options', array(
		'type' => 'none',
		'posts' => array(
			'_1' => null,
			'_2' => null,
			'_3' => null,
		),
		'image_url' => null
	));
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

function cfcp_header_featured_save_post($post_id, $post) {
	if (!defined('XMLRPC_REQUEST') && isset($_POST['_cfcp_header_slot'])) {
		update_post_meta($post_id, '_cfcp_header_slot', intval($_POST['_cfcp_header_slot']));
		if ($post->post_status == 'publish') {
			remove_action('publish_post', 'cfcp_header_featured_publish_post');
			cfcp_header_featured_publish_post($post_id);
		}
	}
}
add_action('save_post', 'cfcp_header_featured_save_post', 10, 2);

function cfcp_header_featured_publish_post($post_id) {
	if ($slot = get_post_meta($post_id, '_cfcp_header_slot', true)) {
		$posts = cfcp_header_options('posts');
// find previous post in slot
		$prev_id = (!empty($posts['_'.$slot]) ? $prev_ids['_'.$slot] : false);
		if ($prev_id != $post_id) {
			if ($prev_id) {
// remove previous post in slot (meta)
				delete_post_meta($prev_id, '_cfcp_header_slot');
			}
			foreach ($posts as $k => $v) {
				if ($v == $post_id) {
					$posts[$k] = null;
				}
			}
			$posts['_'.$slot] = $post_id;
			cfcp_header_options('posts', $posts);
		}
	}
}
add_action('publish_post', 'cfcp_header_featured_publish_post');

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

// Adding some extra style to overide WP
function cfcp_admin_header_css() {
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
	$type = cfcp_header_options('type');
?>
	<div class="wrap cf cf-clearfix">
		<h2><?php _e('Header Settings', 'favepersonal'); ?></h2>

<?php 
		if (!empty($_GET['settings-updated']) && $_GET['settings-updated'] == true) {
			echo '<div class="updated below-h2 fade cf-updated-message-fade" id="message"><p>'.__('Settings updated.', 'favepersonal').'</p></div>';
		}
?>

		<div id="cfp-header-settings">
			<form id="cfcp-header-settings" name="cfcp-header-settings" action="<?php echo admin_url('options.php'); ?>" method="post">

				<?php settings_fields('cfcp_header_options'); ?>
				
				<ul id="cfp-header-options">
					<li id="cfp-header-featured">
						<label for="cfcp-header-type-featured">
							<input type="radio" name="cfcp_header_options[type]" id="cfcp-header-type-featured" value="featured" <?php checked('featured', $type); ?>> <?php _e('Featured Posts', 'favepersonal'); ?>
						</label>
						<div class="cfp-header-preview">
							<?php cfct_misc('header-featured-posts'); ?>
						</div><!--.cfp-featured-preview-->
					</li>
					<li id="cfp-header-image">
						<label for="cfcp-header-type-image">
							<input type="radio" name="cfcp_header_options[type]" id="cfcp-header-type-image" value="image" <?php checked('image', $type); ?>> <?php _e('Header Image', 'favepersonal'); ?>
						</label>
						<div class="cfp-header-preview">
							<?php cfct_misc('header-image'); ?>
						</div><!--.cfp-image-preview-->
					</li>
					<li id="cfp-header-none">
						<label for="cfcp-header-type-none">
							<input type="radio" name="cfcp_header_options[type]" id="cfcp-header-type-none" value="none" <?php checked('none', $type); ?>> <?php _e('No Header', 'favepersonal'); ?>
						</label>
					</li>
				</ul>

				<p class="submit"><input class="button button-primary" type="submit" name="submit" value="<?php _e('Save Settings', 'favepersonal'); ?>" /></p>
			</form>
		</div><!--#cfp-header-->
	</div><!--.cf wrap -->
	<script type="text/javascript">
	jQuery(function($) {
		$('input[name="cfcp_header_options[type]"]').click(function() {
			$('#cfp-header-options .cfp-selected').removeClass('cfp-selected');
			$('input[name="cfcp_header_options[type]"]:checked').closest('li').addClass('cfp-selected');
		});
		$('input[name="cfcp_header_options[type]"]:checked').click();
	});
	</script>
<?php
}

function cfcp_header_options_validate($settings) {
	return array_merge(cfcp_header_options(), $settings);
}

// Adds a box to the main column on the Post and Page edit screens
function cfcp_set_featured_position() {
	add_meta_box(
		'cfp-set-featured-position',
		__( 'Featured Post Position', 'myplugin_textdomain' ),
		'cfcp_header_featured_slot_form',
		'post',
		'normal',
		'high'
	);
}

function cfcp_header_featured_slot_form() {
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
// select
			$('#_cfcp_header_slot').val($(this).attr('id').replace('cfp-featured-position-', ''));
			$(this).siblings().removeClass('cfp-featured-pending').removeClass('cfp-featured-set').end().addClass('cfp-featured-pending');
		});
	});
	</script>
<?php
}

function cfcp_header_featured_slot_item($post, $featured, $i = 1) {
// set class
	if (cfcp_header_featured_meta($post->ID) == $i) {
		$class = 'class="'.($post->post_status == 'publish' ? 'cfp-featured-set' : 'cfp-featured-pending').'"';
	}
	else {
		$class = '';
	}

// no post set?
	if (!$featured) {
?>
		<li id="cfp-featured-position-<?php echo $i; ?>" <?php echo $class; ?>>
			<p class="none"><?php _e('(empty)', 'favepersonal'); ?></p>
		</li>
<?php
	}
	else {
// show post type
		$labels = get_post_type_labels($featured);
?>
		<li id="cfp-featured-position-<?php echo $i; ?>" <?php echo $class; ?>>
			<h4 class="cfp-featured-title"><?php echo esc_html($featured->post_title); ?></h4>
			<p class="cfp-featured-meta"><?php echo esc_html($labels->singular_name); ?> &middot; <?php echo get_the_time('F j, Y', $featured); ?></p>
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

function cfcp_header_display_featured() {

// cfct_misc('header-featured-posts'); return;

	$slots = cfcp_header_options('posts');
	$count = 0;
	$ids = array();
	foreach ($slots as $post_id) {
		if (!empty($post_id)) {
			$ids[] = $post_id;
			$count++;
		}
	}

	$posts = new WP_Query(array(
		'post__in' => wp_parse_id_list($ids)
	));
// if we have less than 3 posts set, grab the latest posts to fill the empty spots
	if ($count < 3) {
		$filler = new WP_Query(array(
			'posts_per_page' => (3 - $count),
			'post__not_in' => wp_parse_id_list($ids)
		));
	}
// run the slots
	ob_start();
	$filler_i = 0;
	foreach ($slots as $slot => $post_id) {
		if (empty($post_id) && count($filler->posts)) {
			$post_id = $filler->posts[$filler_i]->ID;
			unset($filler->posts[$filler_i]);
			$filler_i++;
		}
		cfcp_header_display_featured_post(str_replace('_', '', $slot), $post_id);
	}
	$content = ob_get_clean();
	cfct_template_file('header', 'featured-posts', compact('content'));
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
}