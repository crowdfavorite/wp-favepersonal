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
	}
	
	public function get_attachments($number) {
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
		$args['gallery'] = $this->get_attachments($this->number);
		
		ob_start();
			$this->view($args);
		$ob = ob_get_clean();
		
		echo $ob;
	}
	
	public function view($args = array()) {
		extract($args);
		
			foreach($gallery->posts as $image) {
			}
	}
}

class CFCT_Gallery_Excerpt extends CFCT_Gallery {
	public $number_of_images = 8;
	
	public function view($args = array()) {
		extract($args);
		
		echo '<ul class="gallery-img-excerpt">';
			foreach($gallery->posts as $image) {
				$attimg  = wp_get_attachment_link($image->ID, $size, false);
				echo '<li>'.$attimg.'</li>';
			}
			if ($gallery->found_posts > count($gallery->posts)) {
				echo '<li class="gallery-view-all h5"><a href="'.get_permalink(get_the_ID()).'">View all '.intval($gallery->found_posts).'</a></li>';
			}
		echo '</ul>';
	}
}

function gallery($number = 8) {
	$gallery = new CFCT_Gallery($id, $number);
	$gallery->render();
	unset($gallery);
}

// Display gallery images without our own markup for excerpts 
function gallery_excerpt($size = 'thumbnail', $number = 8, $id = null) {
	$gallery = new CFCT_Gallery_Excerpt($id, $number);
	$args = array(
		'size' => $size,
	);
	$gallery->render($args);
	unset($gallery);
}
?>