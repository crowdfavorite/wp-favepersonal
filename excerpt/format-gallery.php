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

?>
<article id="post-excerpt-<?php the_ID() ?>" <?php post_class('excerpt'); ?>>
	<div class="post-header">
		<h2 class="post-title"><a href="<?php the_permalink() ?>" title="Permanent link to <?php the_title_attribute() ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"><?php the_title() ?></a></h2>
		<p class="post-date"><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></p>
	</div>
	<?php cfct_misc('post-meta-excerpts'); ?>
	<div class="post-media">
		<?php gallery_excerpt('thumb-img'); ?>
	</div><!-- .post-media -->
	<div class="post-content clearfix">
		<?php the_excerpt(); ?>
	</div><!--post-content-->
</article><!-- .excerpt -->