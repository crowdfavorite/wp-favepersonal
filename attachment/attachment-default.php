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

global $post;

get_header();

?>

<?php
if (have_posts()) : while (have_posts()) : the_post(); 
?>

	<div id="attachment" class="clearfix">
		
		<div class="attachment-header">
			<p class="h5"><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment">&larr; back to &#8220;<?php echo get_the_title($post->post_parent); ?>&#8221;</a></p>
			<h1><?php the_title(); ?></h1>			
		</div>
		<div class="attachment-prev">
		<?php
		if (cfct_get_adjacent_image_link(true) != '') {
			previous_image_link('thumb-img');
		}
		?>
		</div>
		
		<div class="attachment-content">
			<div class="center">
				<a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'large-img' ); ?></a>
			</div>

			<?php 
			if (!empty($post->post_excerpt)) {
				echo '<div class="attachment-excerpt">',the_excerpt(),'</div>'; // this is the "caption"
			}
			the_content();
			?>			
		</div>

		<div class="attachment-next">
		<?php
		if (cfct_get_adjacent_image_link(false) != '') {
			next_image_link('thumb-img');
		}
		?>
		</div>
	</div><!--#attachment-->

<?php endwhile; else: ?>

	<p><?php _e('Sorry, no attachments matched your criteria.', 'favepersonal'); ?></p>

<?php endif; ?>


<?php get_footer(); ?>