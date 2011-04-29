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

global $previousday;
$previousday = -1;

?>
<article id="post-<?php the_ID() ?>" <?php post_class('post'); ?>>
	<div class="post-header">
		<h1 class="post-title"><a href="<?php the_permalink() ?>" title="Permanent link to <?php the_title_attribute() ?>" rel="bookmark" rev="post-<?php the_ID(); ?>"><?php the_title() ?> &rarr;</a></h1>
		<p class="post-date"><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></p>
	</div>
	<?php cfct_misc('post-meta'); ?>
	<div class="post-content clearfix">
		<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php the_permalink() ?>" class="link-screenshot"><?php the_post_thumbnail('thumb-img'); ?></a>
		<?php } ?>
		<?php the_content(); ?>
	</div><!--post-content-->
</article><!-- .post -->

