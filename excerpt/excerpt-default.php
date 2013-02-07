<?php

/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2012 Crowd Favorite, Ltd. All rights reserved.
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

<?php if ( ! is_tax('post_format', 'post-format-image') ) { ?>

<article id="post-excerpt-<?php the_ID() ?>" <?php post_class('excerpt clearfix'); ?>>
	<div class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink() ?>"  title="<?php printf( esc_attr__( 'Permalink to %s', 'favepersonal' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title() ?></a></h1>
		<time class="entry-date" datetime="<?php the_time('c'); ?>" pubdate><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></time>
	</div>	
	<div class="entry-content">
<?php 
if ( has_post_thumbnail() ) { 
?>
		<div class="entry-media">
			<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('banner-img'); ?></a>
		</div>
<?php 
} 
the_excerpt();
?>
	</div>
	<?php cfct_misc('entry-meta-excerpts'); ?>
</article>
<?php 
// END Posts that are NOT post_type image

// Posts that ARE post_type image
} 
else { 
?>
<article id="post-excerpt-<?php the_ID() ?>" <?php post_class('excerpt clearfix featured img-archive'); ?>>

<?php if ( has_post_thumbnail() ) { ?>
<?php } ?>
	<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('medium-img'); ?></a>
	<div class="entry-header-img">
		<h1 class="featured-title entry-title-img"><a href="<?php the_permalink() ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'favepersonal' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title() ?></a></h1>
	</div>
<?php
	the_excerpt();
?>
	
</article>
<?php } // end Posts that ARE post_type image ?>
