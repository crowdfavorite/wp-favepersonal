<?php

global $post;
$post = get_post($post_id);
setup_postdata($post);

$class = array();
$image = '';
$format = get_post_format();

if ($format == 'status' || $format == 'quote' || $format == 'link') {
	$show_featured_image = false;
} else {
	$show_featured_image = true;
}

// check for featured image
if (has_post_thumbnail() && ($show_featured_image == true)) {
// set class
	$class[] = 'has-featured-img';
// set image
	ob_start();
	the_post_thumbnail('small-img', array(
		'class' => 'featured-img',
		'height' => '180',
		'width' => '310'
	));
	$image = ob_get_clean();
}

// set format class
if ($format = get_post_format($post_id)) {
	$class[] = 'featured-format-'.$format;
}

$class = implode(' ', $class);

?>