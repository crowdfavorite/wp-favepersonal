<?php
/**
 * @package carrington-personal
 *
 * This file is part of the Carrington Personal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/carrington-personal/
 *
 * Copyright (c) 2008-2010 Crowd Favorite, Ltd. All rights reserved.
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
	if (is_singular()) {
		$theme = trailingslashit(get_bloginfo('template_directory'));
		
		/* Add scripts for full gallery */
		wp_enqueue_script('jquery-cfgallery', $theme . 'js/cfgallery/jquery.cfgallery.js', array('jquery'), CFCT_URL_VERSION);
	}
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

class CFCT_Gallery {
	public $id;
	public $post_id;
	public $gallery;
	public $number_of_images = -1; // Unlimited by default
	
	public function __construct($id = null, $number_of_images = null) {
		if (!$id) {
			$this->post_id = get_the_ID();
		}
		else {
			$this->post_id = $id;
		}
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
	
	public function render($args = array()) {
		$args['gallery'] = $this->get_attachments();
		
		ob_start();
			$this->view($args);
		$ob = ob_get_clean();
		
		echo $ob;
	}
	
	public function view($args = array()) {
		extract($args);
		$thumbs = '';
		foreach($gallery->posts as $image) {
			/* Individual links can be anchored to. Anchoring to a link triggers Javascript to
			load its larger image in the stage area */
			$id = $this->get_slide_id($image->ID);
			$slide_src = wp_get_attachment_image_src($image->ID, 'large-img', false);
			$attachment_url = get_attachment_link($image->ID);
			$thumb = wp_get_attachment_image($image->ID, 'tiny-img', false);
			
			$thumbs .= '<li><a id="'.$id.'" data-largesrc="'.$slide_src[0].'" href="'.$attachment_url.'">'.$thumb.'</a></li>';
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
	public $number_of_images = 8;
	
	public function view($args = array()) {
		extract($args);
		$thumbs = '';
		$post_permalink = get_permalink(get_the_ID());
		
		foreach($gallery->posts as $image) {
			$id = $this->get_slide_id($image->ID);
			$thumbs .= '<li><a href="'.$post_permalink.'#/'.$id.'">'.wp_get_attachment_image($image->ID, $size, false).'</a></li>';
		}
		if ($gallery->found_posts > count($gallery->posts)) {
			$text = sprintf(__('View all %s', 'carrington-personal'), intval($gallery->found_posts));
			$thumbs .= '<li class="gallery-view-all h5"><a href="'.$post_permalink.'"> '.$text.'</a></li>';
		}
		
		?>
<ul class="gallery-img-excerpt">
	<?php echo $thumbs; ?>
</ul>
		<?php
	}
}

function gallery($number = -1, $id = null) {
	$gallery = new CFCT_Gallery($id, $number);
	$gallery->render();
	unset($gallery);
}

// Display gallery images without our own markup for excerpts 
function gallery_excerpt($size = 'thumbnail', $number = 8, $id = null) {
	$gallery = new CFCT_Gallery_Excerpt($id, $number);
	$args = array(
		'size' => $size
	);
	$gallery->render($args);
	unset($gallery);
}
?>