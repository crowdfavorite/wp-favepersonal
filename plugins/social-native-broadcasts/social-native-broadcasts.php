<?php
/*
Plugin Name: Social Native Facebook Broadcasts 
Plugin URI: http://crowdfavorite.com/wordpress/plugins/ 
Description: Send post formats to Facebook as native objects (image and video formats, gallery in the future)
Version: 0.7
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/

// TODO - gallery support

function native_social_fb_broadcasts_wp_loaded() {
	remove_action('social_broadcast_form_item_content', array('Social_Facebook', 'social_broadcast_form_item_content'), 10, 3);
	add_action('social_broadcast_form_item_content', 'native_social_fb_previews', 10, 3);
}
add_action('wp_loaded', 'native_social_fb_broadcasts_wp_loaded', 11);

function native_social_fb_broadcasts($request) {
	extract($request);
	if (empty($post_id)) {
		return $request;
	}
	$format = get_post_format($post_id);
	switch ($format) {
		case 'image':
		case 'link':
		case 'video':
		case 'gallery':
			$func = '_native_social_fb_'.$format;
			return $func($request);
	}
	return $request;
}
add_filter('facebook_broadcast_request', 'native_social_fb_broadcasts', 10, 3);

function _native_social_fb_image($request) {
	extract($request);
	if (has_post_thumbnail($post_id)) {
// 		$photo_id = get_post_thumbnail_id($post_id);
// 		$photo = wp_get_attachment_image_src($photo_id, 'large-img');
		$request['url'] = 'me/photos';
		$request['args'] = array(
			'name' => $args['message'],
			'url' => $args['picture'], // preferred - full-size image
//			'url' => $photo[0], // image within Facebook's stated size restrictions
		);
	}
	return $request;
}

function _native_social_fb_link($request) {
	extract($request);
	$link_url = get_post_meta($post_id, '_format_link_url', true);
	if (!empty($link_url)) {
		$request['args']['link'] = $link_url;
		unset($request['args']['description']);
	}
	return $request;
}

function _native_social_fb_video($request) {
	extract($request);
	$video_url = get_post_meta($post_id, '_format_video_embed', true);
	if (!empty($video_url)) {
		$request['args']['link'] = $video_url;
		unset($request['args']['description']);
	}
	return $request;
}

function _native_social_fb_gallery($request) {
	// TODO
	// - create album
	// - add images to album
	// - add images and album to broadcasted meta
	return $request;
}

function native_social_fb_previews($post, $service, $account) {
	$format = get_post_format($post);
	switch ($format) {
		case 'image':
		case 'link':
		case 'video':
		case 'gallery':
			$func = '_native_social_fb_preview_'.$format;
			return $func($post, $service, $account);
			break;
		default:
			return Social_Facebook::social_broadcast_form_item_content($post, $service, $account);
	}
}

function _native_social_fb_preview_image($post, $service, $account) {
	if ($service->key() != 'facebook') {
		return;
	}
	setup_postdata($post);
	$thumbnail = $thumbnail_class = '';
	if (function_exists('has_post_thumbnail') and has_post_thumbnail($post->ID)) {
		$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'banner-img');
		$thumbnail = '<img src="'.$image[0].'" alt="'.__('Image', 'favepersonal').'" />';
		$thumbnail_class = 'has-img';
	}
?>
<style>
.facebook-photo-preview {
	margin-top: 7px;
	padding-left: 20px;
}
.facebook-photo-preview img {
	height: 90%;
	width: 90%;
}
</style>
<div class="facebook-photo-preview <?php echo esc_attr($thumbnail_class); ?>">
<?php
	echo $thumbnail; 
?>
</div>
<?php
}

function native_social_fb_link_description($format, $post, $service) {
	if ($service->key() == 'facebook' && 
		in_array(get_post_format($post), array('link', 'video')) && 
		$post->post_content > $service->max_broadcast_length()
	) {
		$format .= "\n\n".'{url}';
	}
	return $format;
}
add_filter('social_broadcast_format', 'native_social_fb_link_description', 12, 3);

function _native_social_fb_preview_link($post, $service, $account) {
	if ($service->key() != 'facebook') {
		return;
	}
	setup_postdata($post);
	$link_url = get_post_meta($post->ID, '_format_link_url', true);
	if (!empty($link_url)) {
		$url = $link_url;
		$thumbnail_url = site_url('wp-includes/images/crystal/document.png');
	}
	else {
		$url = get_permalink($post->ID);
		if (function_exists('has_post_thumbnail') and has_post_thumbnail($post->ID)) {
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
			$thumbnail = '<img src="'.$image[0].'" alt="'.__('Image', 'favepersonal').'" />';
		}
	}
	$url_parts = parse_url($url);
?>
<div class="facebook-link-preview has-img">
	<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php _e('Placeholder', 'favepersonal'); ?>" />
	<h4><a href="<?php echo esc_url($url); ?>"><?php printf(__('Title will be pulled from %s', 'favepersonal'), $url_parts['host']); ?></a></h4>
	<h5><?php echo esc_html($url_parts['host']); ?></h5>
	<p><?php printf(__('Short description/preview content will be pulled from %s by Facebook, using applicable Open Graph information if possible.', 'favepersonal'), $url_parts['host']); ?></p>
</div>
<?php
}

function _native_social_fb_preview_video($post, $service, $account) {
	if ($service->key() != 'facebook') {
		return;
	}
	setup_postdata($post);
	$video_url = get_post_meta($post->ID, '_format_video_embed', true);
	if (!empty($video_url)) {
		$url = $video_url;
	}
	else {
		$url = get_permalink($post->ID);
	}
	$url_parts = parse_url($url);
?>
<div class="facebook-link-preview has-img">
	<img src="<?php echo esc_url(site_url('wp-includes/images/crystal/video.png')); ?>" alt="<?php _e('Placeholder', 'favepersonal'); ?>" />
	<h4><a href="<?php echo esc_url($url); ?>"><?php printf(__('Title will be pulled from %s', 'favepersonal'), $url_parts['host']); ?></a></h4>
	<h5><?php echo esc_html($url_parts['host']); ?></h5>
	<p><?php printf(__('Short description/preview content will be pulled from %s by Facebook, using applicable Open Graph information if possible.', 'favepersonal'), $url_parts['host']); ?></p>
</div>
<?php
}

function _native_social_fb_preview_gallery($post, $service, $account) {

// TODO

}
