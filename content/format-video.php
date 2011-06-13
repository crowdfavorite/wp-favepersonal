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

global $wp_embed, $content_width;
$content_width = '710'; // set for this view
add_filter('cfcp_format_video_embed', array(&$wp_embed, 'autoembed'));

?>
<article id="post-<?php the_ID() ?>" <?php post_class('content cleafix') ?>>
	<div class="post-header">
		<h1 class="post-title"><?php the_title() ?></h1>
		<p class="post-date"><a href="<?php the_permalink(); ?>"><?php echo cfcp_date(); ?></a></p>
	</div>
	
	<div class="post-media">
<?php
echo apply_filters(
	'cfcp_format_video_embed', 
	get_post_meta(get_the_ID(), '_format_video_embed', true)
);
?>
	</div>
	
	<?php cfct_misc('post-meta'); ?>
	
	<div class="post-content clearfix">
		<?php 
			the_content('<span class="more-link">'.__('Continued...', 'favepersonal').'</span>'); 
			$args = array(
				'before' => '<p class="pages-link">'. __('Pages: ', 'favepersonal'),
				'after' => "</p>\n",
				'next_or_number' => 'number'
			);
			wp_link_pages($args);
		?>
	</div><!--post-content-->
</article><!-- .post -->