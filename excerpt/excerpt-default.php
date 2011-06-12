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
<article id="post-excerpt-<?php the_ID() ?>" <?php post_class('excerpt'); ?>>
	<div class="post-header">
		<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
		<p class="post-date"><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></p>
	</div>
	<?php cfct_misc('post-meta-excerpts'); ?>
	
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-media">
			<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('banner-img'); ?></a>
		</div>
	<?php } ?>
	
	<div class="post-content clearfix">
		<?php the_excerpt(); ?>
	</div><!--post-content-->
</article><!-- .excerpt -->