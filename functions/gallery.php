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

/**
 * Run code for gallery at the WP action
 */
function cfcp_gallery_on_wp() {
	$theme = trailingslashit(get_bloginfo('template_directory'));
	/* Add scripts for full gallery */
	wp_enqueue_script('jquery-cfgallery', $theme . 'js/cfgallery/jquery.cfgallery.js', array('jquery'), CFCT_URL_VERSION);
}
add_action('wp', 'cfcp_gallery_on_wp');


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
				'post_parent'		=> $this->post_id,
				'post_type'			=> 'attachment',
				'post_status'		=> 'inherit',
				'posts_per_page'	=> $this->number_of_images, // -1 to show all
				'post_mime_type'	=> 'image%',
				'orderby'			=> 'menu_order',
				'order'				=> 'ASC'
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
<div id="<?php echo $this->id; ?>" class="gallery clearfix">
	<div class="gallery-stage"></div>
	<ul class="gallery-thumbs"><?php echo $thumbs; ?></ul>
</div>
		<?php
	}
}

class CFCT_Gallery_Excerpt extends CFCT_Gallery {
	public $number_of_images = 8; // 8 by default
	
	public function view($args = array()) {
		$defaults = array(
			'id' => get_the_ID(),
			'view_all_link' => true
		);
		$args = array_merge($defaults, $args);
		extract($args);
		if (empty($id)) {
			$id = get_the_ID();
		}
		$thumbs = '';
		$post_permalink = get_permalink($id);
		
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

function cfcp_gallery_max_width($size = '', $post_id = null) {
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
			if ($max_width < $data['sizes']['gallery-large-img']['width']) {
				$max_width = $data['sizes']['gallery-large-img']['width'];
			}
		}
	}
	unset($gallery);
	if (!$max_width) {
		$max_width = 710;
	}
	return $max_width;
}

?>