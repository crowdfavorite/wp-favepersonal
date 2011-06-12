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

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

global $previousday, $post;
$previousday = -1;

$title_attr = the_title_attribute(array('echo' => false));
$title_permalink = sprintf(__('Permanent link to %s', 'favepersonal'), $title_attr);
$title_external = sprintf(__('External link to %s', 'favepersonal'), $title_attr);

$link = get_post_meta($post->ID, '_format_link_url', true);
if (!empty($link)) {
	$url = $link;
	$title = $title_external;
}
else {
	$url = get_permalink($post->ID);
	$title = $title_permalink;
}

?>
<article id="post-<?php the_ID() ?>" <?php post_class('post'); ?>>
	<div class="post-header">
		<h1 class="post-title"><a href="<?php echo $url; ?>" title="<?php echo $title; ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"><?php the_title() ?> &rarr;</a></h1>
		<p class="post-date"><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></p>
	</div>
	<?php cfct_misc('post-meta'); ?>
	<div class="post-content clearfix">
		<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php echo $url; ?>" class="link-screenshot"><?php the_post_thumbnail('thumb-img'); ?></a>
		<?php } ?>
		<?php the_content(); ?>
		<p class="format-link-local"><a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $title_permalink; ?>">#</a></p>
	</div><!--post-content-->
</article><!-- .post -->

