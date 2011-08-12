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

?>
<article id="post-excerpt-<?php the_ID() ?>" <?php post_class('excerpt clearfix'); ?>>
	<div class="post-header">
		<h1 class="post-title"><a href="<?php the_permalink() ?>"  title="<?php printf( esc_attr__( 'Permalink to %s', 'favepersonal' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title() ?></a></h1>
		<a class="post-date" href="<?php the_permalink(); ?>"><time datetime="<?php the_time('c'); ?>" pubdate><?php echo cfcp_date(); ?></time></a>
		
		<?php cfct_misc('post-meta-excerpts'); ?>
	</div>
	
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-media">
			<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('banner-img'); ?></a>
		</div>
	<?php } ?>
	
	<div class="post-content clearfix">
		<?php the_excerpt(); ?>
	</div><!--post-content-->
	<?php edit_post_link('edit', '<span class="edit-link">', '</span>'); ?>
</article><!-- .excerpt -->