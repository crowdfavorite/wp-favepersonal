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

// Prettier captions
function cfcp_img_captions($output, $attr, $content = null) {
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;

	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

	return '
		<dl '.$id.'class="wp-caption '.$align.'" style="max-width:'.$width.'px">
			<dt>'.do_shortcode($content).'</dt>
			<dd>'.$caption.'</dd>
		</dl>';
}
add_filter('img_caption_shortcode', 'cfcp_img_captions', 10, 3);

// Do not output default WP styles with gallery shortcode
add_filter('gallery_style', create_function('$a', 'return "<div class=\'gallery\'>";'));

class CFCT_Gallery {
	public $id;
	public $post_id;
	public $attachment_ids;
	public $gallery;
	public $number_of_images = -1; // Unlimited by default
	public $height = 474;
	public $width = 710;

	protected static $instances;

	public function __construct($id, $number_of_images = null, $attachment_ids = null) {
		$this->post_id = $id;

		if ($number_of_images) {
			$this->number_of_images = $number_of_images;
		}
		if ($attachment_ids) {
			$this->attachment_ids = explode(',', $attachment_ids);
		}
		if (defined('CFCT_GALLERY_HEIGHT')) {
			$this->height = CFCT_GALLERY_HEIGHT;
		}
		if (defined('CFCT_GALLERY_WIDTH')) {
			$this->width = CFCT_GALLERY_WIDTH;
		}
	}

	/* Just an API function for piecing together the slide naming convention */
	public function get_slide_id($id) {
		return 's'.$id;
	}

	public function get_attachments() {
		if (!$this->gallery) {
			if (!empty($this->attachment_ids)) {
				$this->gallery = new WP_Query(array(
					'post__in' => $this->attachment_ids,
					'post_type' => 'attachment',
					'post_status' => 'inherit',
					'posts_per_page' => $this->number_of_images, // -1 to show all
					'post_mime_type' => 'image%',
					'orderby' => 'post__in'
				));
			}
			else {
				$this->gallery = new WP_Query(array(
					'post_parent' => $this->post_id,
					'post_type' => 'attachment',
					'post_status' => 'inherit',
					'posts_per_page' => $this->number_of_images, // -1 to show all
					'post_mime_type' => 'image%',
					'orderby' => 'menu_order',
					'order' => 'ASC'
				));
			}
		}
		return $this->gallery;
	}

	public function exists() {
		$e = $this->get_attachments();
		return $e->have_posts();
	}

	public function max_size() {
		$max_height = 0;
		$max_width = 0;

		if ($this->exists()) { // loads attachments
			// get IDs
			$photo_ids = array();
			foreach ($this->gallery->posts as $photo) {
				$photo_ids[] = $photo->ID;
			}
			// get meta
			$meta = cf_get_post_meta($photo_ids, '_wp_attachment_metadata');
			// check widths
			foreach ($meta as $data) {
				$size = (isset($data['sizes']['gallery-large-img']) ? $data['sizes']['gallery-large-img'] : $data);
				if (isset($size['height']) && $max_height < $size['height']) {
					$max_height = $size['height'];
				}
				if (isset($size['width']) && $max_width < $size['width']) {
					$max_width = $size['width'];
				}
			}
		}
		if (!$max_height) {
			$max_height = 474;
		}
		if (!$max_width) {
			$max_width = 710;
		}
		return array(
			'height' => $max_height,
			'width' => $max_width
		);
	}

	public function render($args = array()) {
		if (!$this->exists()) {
			return;
		}
		global $content_width;
		$sizes = $this->max_size();
		if ($content_width < $sizes['width']) {
			$ratio = $sizes['width'] / $content_width;
			$this->width = floor($sizes['width'] / $ratio);
			$this->height = floor($sizes['height'] / $ratio);
		}
		else {
			$this->width = $sizes['width'];
			$this->height = $sizes['height'];
		}

		if (empty($args['height'])) {
			$args['height'] = $this->height;
		}
		if (empty($args['width'])) {
			$args['width'] = $this->width;
		}

		$args['gallery'] = $this->get_attachments();

		$this->view($args);
	}

	public function view($args = array()) {
		extract($args);
		$thumbs = '';

		foreach ($gallery->posts as $image) {
			/* Individual links can be anchored to. Anchoring to a link triggers Javascript to
			load its larger image in the stage area */
			$id = $this->get_slide_id($image->ID);
			$slide_src = wp_get_attachment_image_src($image->ID, 'gallery-large-img', false);
			$attachment_url = get_attachment_link($image->ID);
			$thumb = wp_get_attachment_image($image->ID, 'tiny-img', false);

			// FavePersonal was built when WordPress used the post_content for captions
			// in WP 3.6, the media library was changed to expose the post_excerpt for
			// captions instead. We'll try to be backward compatible and forward looking
			// at the same time here.
			$caption = (!empty($image->post_excerpt) ? $image->post_excerpt : $image->post_content);

			$thumbs .= '<li><a id="'.esc_attr($id).'" data-largesrc="'.esc_attr($slide_src[0]).'" href="'.esc_url($attachment_url).'" data-title="'.esc_attr(strip_tags($image->post_title)).'" data-caption="'.esc_attr(strip_tags($caption)).'" data-largeh="'.esc_attr($slide_src[2]).'" data-largew="'.esc_attr($slide_src[1]).'">'.$thumb.'</a></li>';
		}
?>
<div class="cfgallery clearfix" data-width="<?php echo intval($width); ?>" data-height="<?php echo intval($height); ?>">
	<div class="gallery-stage"></div>
	<ul class="gallery-thumbs"><?php echo $thumbs; ?></ul>
</div>
<?php
	}
}

class CFCT_Gallery_Excerpt extends CFCT_Gallery {
	public $number_of_images = 9; // 9 by default

	protected function _view_prep($args = array()) {
		$post = get_post();
		$defaults = array(
			'id' => $post->ID,
			'view_all_link' => true
		);
		if (empty($defaults['height'])) {
			$defaults['height'] = $this->height;
		}
		if (empty($defaults['width'])) {
			$defaults['width'] = $this->width;
		}
		$args = array_merge($defaults, $args);
		$args['thumbs'] = '';
		$args['post_permalink'] = get_permalink($args['id']);
		return $args;
	}

	public function view($args = array()) {
		$args = $this->_view_prep($args);
		extract($args);
		$i = 0;
		// remove the last gallery post if there are more than we can show here (we'll show a link to view all instead)
		if ($gallery->found_posts > count($gallery->posts)) {
			unset($gallery->posts[count($gallery->posts) - 1]);
		}
		foreach ($gallery->posts as $image) {
			$thumbs .= '<li class="excerpt-img-'.$i.'"><a href="'.esc_url($post_permalink.'#'.$this->get_slide_id($image->ID)).'">'.wp_get_attachment_image($image->ID, $size, false).'</a></li>';
			$i++;
		}
		if ($view_all_link && $gallery->found_posts > count($gallery->posts)) {
			$text = sprintf(__('View all %s', 'favepersonal'), intval($gallery->found_posts));
			$thumbs .= '<li class="gallery-view-all h5"><a href="'.esc_url($post_permalink).'"> '.esc_html($text).'</a></li>';
		}

		?>
<ul class="gallery-img-excerpt">
	<?php echo $thumbs; ?>
</ul>
		<?php
	}

	public function view_featured($args = array()) {
		$args = $this->_view_prep($args);
		extract($args);
		$images = array(
			'_0' => '',
			'_1' => '',
			'_2' => '',
			'_3' => '',
		);
		switch (count($gallery->posts)) {
			case '1':
				$images['_1'] = $gallery->posts[0];
			break;
			case '2':
				$images['_1'] = $gallery->posts[0];
				$images['_2'] = $gallery->posts[1];
			break;
			case '4':
				$images['_3'] = $gallery->posts[3];
			case '3':
				$images['_0'] = $gallery->posts[0];
				$images['_1'] = $gallery->posts[1];
				$images['_2'] = $gallery->posts[2];
			break;
		}
		$i = 0;
		foreach ($images as $image) {
			if (empty($image)) {
				$thumbs .= '<li class="excerpt-img-'.$i.'"></li>';
			}
			else {
				$thumbs .= '<li class="excerpt-img-'.$i.'"><a href="'.esc_url($post_permalink.'#'.$this->get_slide_id($image->ID)).'">'.wp_get_attachment_image($image->ID, $size, false).'</a></li>';
			}
			$i++;
		}

		?>
<ul class="gallery-img-excerpt">
	<?php echo $thumbs; ?>
</ul>
		<?php
	}

	public function render_featured($args = array()) {
		if (!$this->exists()) {
			return;
		}
		$args['gallery'] = $this->get_attachments();
		$this->view_featured($args);
	}
}

function cfcp_gallery($args = array()) {
	$defaults = array(
		'number' => -1,
		'id' => get_the_ID(),
		'attachment_ids' => null,
		'before' => '',
		'after' => '',
	);
	$args = array_merge($defaults, $args);
	$gallery = new CFCT_Gallery($args['id'], $args['number'], $args['attachment_ids']);
	if ($gallery->exists()) {
		echo $args['before'];
		$gallery->render($args);
		echo $args['after'];
	}
	unset($gallery);
}

function cfcp_gallery_shortcode($content, $args = array()) {
	// Go with default gallery if in a feed (we don't want to run JS in feeds)
	if (is_feed()) {
		return '';
	}

	$post = get_post();

	$gallery_args = $defaults = array(
		'number' => -1,
		'id' => $post->ID,
		'attachment_ids' => null,
		'before' => '<div>',
		'after' => '</div>',
	);
	// occasionally $args is null
	if (is_array($args)) {
		$gallery_args = array_merge($defaults, $args);
	}
	if (!empty($args['ids'])) {
		$gallery_args['attachment_ids'] = $args['ids'];
	}

	$gallery = new CFCT_Gallery(
		$gallery_args['id'],
		$gallery_args['number'],
		$gallery_args['attachment_ids']
	);

	ob_start();
	echo $args['before'];
	$gallery->render($args);
	echo $args['after'];
	return ob_get_clean();
}
if (!is_admin()) {
	add_filter('post_gallery', 'cfcp_gallery_shortcode', 1, 2);
}
// disable carrington core gallery
remove_filter('post_gallery', 'cfct_post_gallery', 10, 2);

// Display gallery images with our own markup for excerpts
function cfcp_gallery_excerpt($args = array()) {
	$post = get_post();
	$defaults = array(
		'size' => 'thumbnail',
		'number' => 9,
		'id' => $post->ID,
		'attachment_ids' => null,
		'before' => '',
		'after' => '',
		'view_all_link' => true,
	);
	$args = array_merge($defaults, $args);
	$gallery = new CFCT_Gallery_Excerpt($args['id'], $args['number'], $args['attachment_ids']);
	if ($gallery->exists()) {
		$display_args = array(
			'size' => $args['size'],
			'view_all_link' => $args['view_all_link']
		);

		echo $args['before'];
		$gallery->render($display_args);
		echo $args['after'];
	}
	unset($gallery);
}

// Display gallery images with our own markup for featured posts in masthead
// TODO - refactor to pass args to render that can select different view methods
function cfcp_gallery_featured($args = array()) {
	$defaults = array(
		'size' => 'thumbnail',
		'number' => 4,
		'id' => get_the_ID(),
		'before' => '',
		'after' => '',
		'view_all_link' => true,
	);
	$args = array_merge($defaults, $args);
	$gallery = new CFCT_Gallery_Excerpt($args['id'], $args['number']);
	if ($gallery->exists()) {
		$display_args = array(
			'size' => $args['size'],
			'view_all_link' => $args['view_all_link']
		);

		echo $args['before'];
		$gallery->render_featured($display_args);
		echo $args['after'];
	}
	unset($gallery);
}

if (!function_exists('cf_get_post_meta')) {
/**
 * Retrieve post meta field for multiple posts.
 *
 * @uses $wpdb
 * @link http://codex.wordpress.org/Function_Reference/get_post_meta
 *
 * @param mixed $post_ids Post ID or array of post IDS.
 * @param string $key The meta key to retrieve.
 * @param bool $single Whether to return a single value.
 * @return mixed Will be an array if $single is false. Will be value of meta data field if $single
 *  is true.
 */
function cf_get_post_meta($post_ids, $key, $single = false) {
	// if just one, pass through normal call
	if (is_array($post_ids) && count($post_ids) == 1) {
		$post_ids = $post_ids[0];
	}
	if (!is_array($post_ids)) {
		return get_post_meta($post_ids, $key, $single);
	}
	else {
		global $wpdb;
		$post_ids = array_unique(array_map('intval', $post_ids));
		$sql = $wpdb->prepare("
				SELECT post_id, meta_value
				FROM $wpdb->postmeta
				WHERE meta_key = '%s'
				AND post_id IN (".implode(',', $post_ids).")
			",
			$key
		);
		$results = $wpdb->get_results($sql);
		$data = array();
		if (is_array($results) && count($results)) {
			foreach ($results as $result) {
				$data['post_'.$result->post_id] = maybe_unserialize($result->meta_value);
			}
		}
		return apply_filters('cf_get_post_meta_values', $data);
	}
}
} // end exists check
