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


if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

global $post;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ).$title_description; ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />

	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'carrington-text' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'carrington-text' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	
	<link rel="stylesheet" type="text/css" media="screen, print, handheld" href="<?php bloginfo('template_url') ?>/css/carrington-text.css" />
	
<?php
	wp_head(); 
?>
</head>

<body>

<?php

if (have_posts()) : while (have_posts()) : the_post(); 

?>

<div id="attachment">

<p class="top"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment">&larr; back to &#8220;<?php echo get_the_title($post->post_parent); ?>&#8221;</a></p>


<a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></a>

<h1><?php the_title(); ?></h1>

<?php 

if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption"

the_content();

?>

<div class="nav">

<?php

if (cfct_get_adjacent_image_link(false) != '') {
	echo '<span class="next">',next_image_link(),'</span>';
}
if (cfct_get_adjacent_image_link(true) != '') {
	echo '<span class="previous">',previous_image_link(),'</span>';
}
	
?>

</div>

<?php endwhile; else: ?>

<p>Sorry, no attachments matched your criteria.</p>

<?php endif; ?>

		<div class="clear"></div>
		<div id="footer">
<?php
if (cfct_get_option('cfct_credit') == 'yes') {
?>
			<p id="developer-link"><?php printf(__('<a href="http://crowdfavorite.com" title="Custom WordPress development, design and backup services." rel="developer designer">%s</a>', 'carrington-text'), 'Carrington Theme by Crowd Favorite'); ?></p>
<?php
}
?>
			<p id="generator-link"><?php _e('Proudly powered by <a href="http://wordpress.org/" rel="generator">WordPress</a></span> and <span id="theme-link"><a href="http://carringtontheme.com" title="Carrington theme for WordPress">Carrington</a></span>.', 'carrington-text'); ?></p>
			</div><!--.wrapper-->
		</div><!--#footer -->
	</div>
	<?php wp_footer() ?>
</body>
</html>