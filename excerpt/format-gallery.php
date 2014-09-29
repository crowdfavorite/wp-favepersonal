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

?>
<article id="post-excerpt-<?php the_ID() ?>" <?php post_class('excerpt clearfix'); ?>>
	<div class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'favepersonal' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title() ?></a></h1>
		<time class="entry-date" datetime="<?php the_time('c'); ?>" pubdate><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></time>
	</div>
	<div class="entry-content">
<?php

$args = array(
	'size' => 'thumb-img',
	'before' => '<div class="entry-media clearfix">',
	'after' => '</div>'
);

if (cfpf_post_gallery_type() == 'shortcode') {
	$args['attachment_ids'] = cfpf_post_gallery_shortcode_ids();
}

cfcp_gallery_excerpt($args);

the_excerpt();
?>
	</div>
	<?php cfct_misc('entry-meta-excerpts'); ?>
</article>
