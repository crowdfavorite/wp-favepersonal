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


if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }
if ( has_post_thumbnail() ) {
	$image_id = get_post_thumbnail_id();
	$image_url = wp_get_attachment_image_src($image_id,'image-archive', true);
?>
	<article id="post-excerpt-<?php the_ID() ?>" <?php post_class('excerpt image-excerpt clearfix'); ?>>
		<a class="img-archive-link" href="<?php the_permalink() ?>" style="background-image: url(<?php echo $image_url[0]; ?>)"></a>
		<div class="entry-header-img-vid">
			<h1 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'favepersonal' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title() ?></a></h1>
			<time class="entry-date" datetime="<?php the_time('c'); ?>" pubdate><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></time>
			<?php $comment_count = get_comment_count($post->ID); ?>
			<?php if ($comment_count['approved'] > 0) : ?>
			<a id="comments" class="comments-title" href="<?php comments_link(); ?>"><?php comments_number(__('No Comments (yet)', 'favepersonal'), __('1 Comment', 'favepersonal'), __('% Comments', 'favepersonal')); ?></a>
			<?php endif; ?>
		</div>
	</article>
<?php } ?>