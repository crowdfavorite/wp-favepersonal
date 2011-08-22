<?php
/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2011 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * **********************************************************************
 */

// Prettier captions
function cfcp_img_captions($attr, $content = null) {
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ($output != '') {
		return $output;
	}
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));
	if ( 1 > (int) $width || empty($caption) ) {
		return $content;
	}
	return '
		<dl id="'.$id.'" class="wp-caption '.$align.'" style="width:'.$width.'px">
			<dt>'.do_shortcode($content).'</dt>
			<dd>'.$caption.'</dd>
		</dl>';
}
add_shortcode('wp_caption', 'cfcp_img_captions');
add_shortcode('caption', 'cfcp_img_captions');

// Do not output default WP styles with gallery shortcode
add_filter('gallery_style', create_function('$a', 'return "<div class=\'gallery\'>";'));

class CFCT_Gallery {
	public $id;
	public $post_id;
	public $gallery;
	public $number_of_images = -1; // Unlimited by default
	protected static $instances;
	
	public function __construct($id, $number_of_images = null) {
		$this->post_id = $id;
		
		if ($number_of_images) {
			$this->number_of_images = $number_of_images;
		}
		/* Gallery ID based on post id. This should be unique enough. Can't use uniqid because
		the ID needs to be reproduceable across page loads (for anchoring to slides).
		If we end up needing multiple same galleries per page, we can make a factory
		to make sure each gallery id is unique. */
		$this->id = sprintf('gal%s', $this->post_id);
	}
	
	/* Just an API function for piecing together the slide naming convention */
	public function get_slide_id($id) {
		return 's'.$id;
	}
	
	public function get_attachments() {
		if (!$this->gallery) {
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
		return $this->gallery;
	}
	
	public function exists() {
		$e = $this->get_attachments();
		return $e->have_posts();
	}
	
	public function render($args = array()) {
		if (!$this->exists()) {
			return;
		}
		$args['gallery'] = $this->get_attachments();
		$this->view($args);
	}
	
	public function view($args = array()) {
		extract($args);
		$thumbs = '';
		
		foreach($gallery->posts as $image) {
			/* Individual links can be anchored to. Anchoring to a link triggers Javascript to
			load its larger image in the stage area */
			$id = $this->get_slide_id($image->ID);
			$slide_src = wp_get_attachment_image_src($image->ID, 'gallery-large-img', false);
			$attachment_url = get_attachment_link($image->ID);
			$thumb = wp_get_attachment_image($image->ID, 'tiny-img', false);
			
			$thumbs .= '<li><a id="'.esc_attr($id).'" data-largesrc="'.esc_attr($slide_src[0]).'" href="'.esc_url($attachment_url).'">'.$thumb.'</a></li>';
		}
		?>
<div id="<?php echo $this->id; ?>" class="cfgallery clearfix">
	<div class="gallery-stage"></div>
	<ul class="gallery-thumbs"><?php echo $thumbs; ?></ul>
</div>
		<?php
	}
}

class CFCT_Gallery_Excerpt extends CFCT_Gallery {
	public $number_of_images = 8; // 8 by default
	
	protected function _view_prep($args = array()) {
		$defaults = array(
			'id' => get_the_ID(),
			'view_all_link' => true
		);
		$args = array_merge($defaults, $args);
		$args['thumbs'] = '';
		$args['post_permalink'] = get_permalink($args['id']);
		return $args;
	}
	
	public function view($args = array()) {
		$args = $this->_view_prep($args);
		extract($args);
		$i = 0;
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
//		foreach ($gallery->posts as $image) {
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

function cfcp_gallery_has_images($post_id = null) {
	if (empty($post_id)) {
		$post_id = get_the_ID();
	}
	$gallery = new CFCT_Gallery($post_id);
	$ret = $gallery->exists();
	unset($gallery);
	return $ret;
}

function cfcp_gallery($args = array()) {
	$defaults = array(
		'number' => -1,
		'id' => get_the_ID(),
		'before' => '',
		'after' => ''
	);
	$args = array_merge($defaults, $args);
	$gallery = new CFCT_Gallery($args['id'], $args['number']);
	if ($gallery->exists()) {
		echo $args['before'];
		$gallery->render();
		echo $args['after'];
	}
	unset($gallery);
}

function cfcp_gallery_shortcode($content, $args) {
	remove_filter('post_gallery', 'cfct_post_gallery', 10, 2);
	ob_start();
	cfcp_gallery(array(
		'before' => '<div>',
		'after' => '</div>',
	));
	return ob_get_clean();
}
if (!is_admin()) {
	add_filter('post_gallery', 'cfcp_gallery_shortcode', 1, 2);
}

// Display gallery images with our own markup for excerpts 
function cfcp_gallery_excerpt($args = array()) {
	$defaults = array(
		'size' => 'thumbnail',
		'number' => 8,
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
		'number' => 8,
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

function cfcp_gallery_max_height($size = '', $post_id = null) {
	$max_sizes = cfcp_gallery_max_size($size, $post_id);
	return $max_sizes['height'];
}

function cfcp_gallery_max_width($size = '', $post_id = null) {
	$max_sizes = cfcp_gallery_max_size($size, $post_id);
	return $max_sizes['width'];
}

function cfcp_gallery_max_size($size = '', $post_id = null) {
	$max_height = 0;
	$max_width = 0;
	if (empty($post_id)) {
		$post_id = get_the_ID();
	}
	$gallery = new CFCT_Gallery($post_id, -1);
	if ($gallery->exists()) { // loads attachments
// get IDs
		$photo_ids = array();
		foreach ($gallery->gallery->posts as $photo) {
			$photo_ids[] = $photo->ID;
		}
// get meta
		$meta = cf_get_post_meta($photo_ids, '_wp_attachment_metadata');
// check widths
		foreach ($meta as $data) {
			$size = (isset($data['sizes']['gallery-large-img']) ? $data['sizes']['gallery-large-img'] : $data);
			if ($max_height < $size['height']) {
				$max_height = $size['height'];
			}
			if ($max_width < $size['width']) {
				$max_width = $size['width'];
			}
		}
	}
	unset($gallery);
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

?>
